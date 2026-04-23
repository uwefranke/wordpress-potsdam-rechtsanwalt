#!/bin/bash

# --- Konfiguration ---
start_from_this_tag="2.1.3" # Aktuelle WordPress Theme Version
CHANGELOG_FILE="CHANGELOG.md" # Changelog-Datei im Root
STYLE_CSS="../src/style.css" # WordPress Theme style.css
GITHUB_REPO="uwefranke/wordpress-potsdam-rechtsanwalt"

SCRIPT_DIR=$(dirname "$0")
SCRIPT_NAME=$(basename "$0")
# Dynamische Ermittlung des Skriptnamens
RELEASE_SCRIPT_NAME="$SCRIPT_DIR/$SCRIPT_NAME"

# --- Hilfsfunktion für Benutzereingabe ---
prompt_yes_no() {
    local prompt="$1"
    local response
    read -p "$prompt (y/n): " response
    [[ "$response" =~ ^[Yy]$ ]]
}

# --- Kommandozeilenargumente verarbeiten ---
version_mode="auto"  # Standard: auto (patch +1)
custom_version=""

while [[ $# -gt 0 ]]; do
    case $1 in
        --major)
            version_mode="major"
            shift
            ;;
        --minor)
            version_mode="minor"
            shift
            ;;
        --version)
            version_mode="custom"
            custom_version="$2"
            shift 2
            ;;
        *)
            echo "Unbekannte Option: $1"
            echo "Verwendung: $SCRIPT_NAME [--major|--minor|--version X.Y.Z]"
            exit 1
            ;;
    esac
done

# --- Automatische Versionserhöhung / Auswahl ---
# Hole den neuesten Tag (aktuelle Version)
latest_tag=$(git tag --sort=-v:refname | head -n 1)

if [ -z "$latest_tag" ]; then
    # Falls noch kein Tag existiert, starte mit 0.0.1
    version="0.0.1"
    echo "Kein existierender Tag gefunden. Starte mit Version: $version"
else
    # Parse Major, Minor, Patch aus dem letzten Tag
    IFS='.' read -r major minor patch <<< "$latest_tag"
    
    # Berechne neue Version basierend auf Modus
    if [ "$version_mode" = "custom" ]; then
        version="$custom_version"
    elif [ "$version_mode" = "major" ]; then
        major=$((major + 1))
        minor=0
        patch=0
        version="${major}.${minor}.${patch}"
    elif [ "$version_mode" = "minor" ]; then
        minor=$((minor + 1))
        patch=0
        version="${major}.${minor}.${patch}"
    else  # auto (patch)
        patch=$((patch + 1))
        version="${major}.${minor}.${patch}"
    fi
    
    echo "Letzer Tag: $latest_tag → Neue Version: $version (Modus: $version_mode)"
fi

ReleaseTagUrl="https://github.com/$GITHUB_REPO/releases/tag/v$version"

# --- Bestätigung der Version ---
if ! prompt_yes_no "Version $version verwenden?"; then
    echo "Abgebrochen."
    exit 0
fi

# --- WordPress style.css Version aktualisieren ---
echo "Aktualisiere Version in style.css..."
if [ -f "$STYLE_CSS" ]; then
    # Suche nach "Version: X.Y.Z" und ersetze durch neue Version
    sed -i "s/Version: .*/Version: $version/" "$STYLE_CSS"
    echo "style.css aktualisiert: Version $version"
else
    echo "Warnung: style.css nicht gefunden unter $STYLE_CSS"
    if ! prompt_yes_no "Trotzdem fortfahren?"; then
        echo "Abgebrochen."
        exit 1
    fi
fi

# --- Vorbereitung ---
echo "Starte Prozess für Version: $version"

# Sicherstellen, dass du alle Remote-Tags hast
git fetch --tags 
echo "Tags gefetcht."

# Auf den Haupt-Branch wechseln und aktuell halten
git checkout main 
git pull origin main 
echo "Haupt-Branch 'main' ist aktuell."

# Optional: Überprüfen, ob der Tag bereits existiert
if git rev-parse "v$version" >/dev/null 2>&1; then
    echo "FEHLER: Tag 'v$version' existiert bereits!"
    exit 1
fi

# --- Changelog generieren (KERN des Tests) ---
echo "Generiere Changelog für Version $version..."

# Bestimme den "von"-Tag für conventional-changelog
# Wenn der Start-Tag explizit gesetzt und gefunden wird, verwende ihn
if [ -n "$start_from_this_tag" ] && git rev-parse "$start_from_this_tag" >/dev/null 2>&1; then
    FROM_TAG="$start_from_this_tag"
    echo "Generiere Changelog ab festgelegtem Start-Tag '$FROM_TAG' bis zum aktuellen HEAD."
elif previous_tag=$(git tag --sort=-v:refname | head -n 1) && [ -n "$previous_tag" ]; then
    # Ansonsten, wenn es vorherige Tags gibt, den letzten Tag verwenden
    FROM_TAG="$previous_tag"
    echo "Generiere Changelog von letztem Tag '$FROM_TAG' bis zum aktuellen HEAD."
else
    # Wenn keine Tags existieren, den kompletten Changelog generieren (ab erster Commit)
    FROM_TAG="0" # '0' oder -r 0 bedeutet von Anfang an
    echo "Keine vorherigen Tags gefunden. Generiere vollständigen Changelog (ab erstem Commit)."
fi

# Befehl für conventional-changelog
if [ "$FROM_TAG" == "0" ]; then
    changelog_content=$(conventional-changelog -p angular -r 0 --tag-prefix="" --skip-unstable --output-if-empty)
else
    changelog_content=$(conventional-changelog -p angular --tag-prefix="" --skip-unstable --output-if-empty --from "$FROM_TAG" --to "HEAD")
fi

# --- Aktualisiere die CHANGELOG.md Datei ---
echo "Aktualisiere $CHANGELOG_FILE..."

# Temporäre Datei für den alten Changelog-Inhalt erstellen
# Überspringe die erste Zeile "# Changelog" wenn sie existiert, um sie später neu hinzuzufügen
if [ -f "$CHANGELOG_FILE" ]; then
    # Schneide den Header ab (erste Zeile) und speichere den Rest
    tail -n +2 "$CHANGELOG_FILE" > "${CHANGELOG_FILE}.tmp_old"
else
    # Wenn die Datei nicht existiert, erstelle eine leere temporäre Datei
    touch "${CHANGELOG_FILE}.tmp_old"
fi

# Erstelle den vollständigen neuen Changelog-Inhalt
# 1. Haupt-Header
# 2. Der neu generierte Block für die aktuelle Version
# 3. Den alten Changelog-Inhalt (ohne den alten Haupt-Header)
echo "# Changelog" > "$CHANGELOG_FILE"
echo "" >> "$CHANGELOG_FILE" # Leerzeile für Formatierung
# conventional-changelog fügt den Versionstitel selbst hinzu (z.B. "## 1.2.0 (2025-07-06)")
echo "## [$version]($ReleaseTagUrl) ${changelog_content#\#}" >> "$CHANGELOG_FILE"
#echo "" >> "$CHANGELOG_FILE" # Leerzeile für Formatierung
#echo "#$changelog_content" >> "$CHANGELOG_FILE"
#echo "" >> "$CHANGELOG_FILE" # Leerzeile für Formatierung
cat "${CHANGELOG_FILE}.tmp_old" >> "$CHANGELOG_FILE"

# Temporäre Datei löschen
rm "${CHANGELOG_FILE}.tmp_old"

echo "$CHANGELOG_FILE erfolgreich aktualisiert."


#exit 0

# Fügen Sie diese NEUEN Zeilen HIER ein (wie im vorherigen Beispiel)
echo "Füge Release-Skript zum Staging-Bereich hinzu..."
git add "$RELEASE_SCRIPT_NAME"
echo "Füge Changelog-Datei zum Staging-Bereich hinzu..."
git add "$CHANGELOG_FILE" # Füge die aktualisierte Changelog-Datei dem Staging-Bereich hinzu
echo "Füge style.css zum Staging-Bereich hinzu..."
git add "$STYLE_CSS" # WordPress Theme Version

git commit -m "chore(release): Version $version

- Changelog aktualisiert
- style.css Version auf $version erhöht"

echo "Commit für Release erstellt."

echo "Erstelle Git-Tag 'v$version'..."
git tag "v$version" 

echo "Pushe 'main'-Branch..."
git push origin main

echo "Pushe Git-Tag 'v$version'..."
git push origin "v$version"

# Temporäre Changelog-Datei für GitHub Release erstellen
echo "$changelog_content" > .changelog_temp.md
echo "Changelog-Inhalt in .changelog_temp.md gespeichert für GitHub Release."

echo "Erstelle GitHub Release für 'v$version'..."
gh release create "v$version" --notes-file .changelog_temp.md --title "Version $version" --repo "$GITHUB_REPO"

# Temporäre Changelog-Datei löschen
rm .changelog_temp.md

echo ""
echo "=========================================="
echo "✅ Release-Prozess für Version $version erfolgreich abgeschlossen!"
echo ""
echo "📦 GitHub Release: https://github.com/$GITHUB_REPO/releases/tag/v$version"
echo "🏷️  Git Tag: v$version"
echo "📝 Changelog: $CHANGELOG_FILE"
echo "🎨 Theme Version: $version (style.css)"
echo ""
echo "Die GitHub Action erstellt jetzt automatisch das Theme-ZIP-Paket."
echo "=========================================="