# WordPress Theme Version & Release Management

## Überblick

Das Skript `scripts/git_new_version.sh` automatisiert den kompletten Release-Prozess für neue Theme-Versionen:

- ✅ Automatische Versionsnummer-Erhöhung
- ✅ Aktualisierung der `style.css` Version
- ✅ Changelog-Generierung aus Git-Commits
- ✅ Git-Tag Erstellung
- ✅ GitHub Release-Erstellung
- ✅ Triggert automatisch Theme-ZIP-Paket-Build

## Voraussetzungen

### 1. Git Bash (Windows)

**Bereits installiert mit Git für Windows:**
```bash
# Version prüfen
git --version
```

Falls nicht installiert: https://git-scm.com/downloads

### 2. Node.js & npm

**Installation prüfen:**
```bash
node --version
npm --version
```

**Falls nicht installiert:**
- Download: https://nodejs.org/ (LTS Version)
- Installiert automatisch npm

### 3. conventional-changelog-cli

**Installation (global):**
```bash
npm install -g conventional-changelog-cli
```

**Version prüfen:**
```bash
conventional-changelog --version
```

### 4. GitHub CLI (gh)

**Installation:**
```bash
# Windows (mit winget):
winget install GitHub.cli

# Oder Download von: https://cli.github.com/
```

**Authentifizierung:**
```bash
gh auth login
```

Wählen Sie:
- GitHub.com
- HTTPS
- Login with a web browser
- Folgen Sie den Anweisungen im Browser

**Authentifizierung prüfen:**
```bash
gh auth status
```

## Verwendung

### Standard-Release (Patch-Update)

Erhöht die letzte Zahl: `2.1.3` → `2.1.4`

```bash
# Im Git Bash Terminal
cd /c/Users/uwefr/OneDrive/Dokumente/web/potsdam-rechtsanwalt
cd scripts
./git_new_version.sh
```

**Ablauf:**
1. Skript zeigt: `Letzer Tag: 2.1.3 → Neue Version: 2.1.4 (Modus: auto)`
2. Sie bestätigen: `Version 2.1.4 verwenden? (y/n): y`
3. Skript aktualisiert automatisch:
   - `src/style.css` → `Version: 2.1.4`
   - `CHANGELOG.md` → Neuer Eintrag mit Commits
   - Git Commit & Tag `v2.1.4`
   - Push zu GitHub
   - GitHub Release erstellt

### Minor-Release (Feature-Update)

Erhöht die mittlere Zahl: `2.1.3` → `2.2.0`

```bash
./git_new_version.sh --minor
```

**Wann verwenden:**
- Neue Features hinzugefügt
- Größere Änderungen
- Nicht-breaking Changes

### Major-Release (Breaking Changes)

Erhöht die erste Zahl: `2.1.3` → `3.0.0`

```bash
./git_new_version.sh --major
```

**Wann verwenden:**
- Breaking Changes (Inkompatible Änderungen)
- Komplettes Redesign
- API-Änderungen

### Spezifische Version

Setzt eine bestimmte Version:

```bash
./git_new_version.sh --version 2.5.0
```

## Semantic Versioning (SemVer)

Das Projekt folgt [Semantic Versioning](https://semver.org/):

```
MAJOR.MINOR.PATCH
  |     |     |
  |     |     └─ Bug-Fixes, kleine Korrekturen
  |     └─────── Neue Features, kompatibel
  └───────────── Breaking Changes, inkompatibel
```

**Beispiele:**
- `2.1.4` → `2.1.5`: Bug-Fix (Button-Farbe korrigiert)
- `2.1.4` → `2.2.0`: Feature (Neue Widget-Funktion)
- `2.1.4` → `3.0.0`: Breaking (Komplettes neues Layout-System)

## Conventional Commits

Das Skript analysiert Ihre Commit-Messages nach dem [Conventional Commits](https://www.conventionalcommits.org/) Standard:

### Commit-Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- **feat**: Neue Funktion
  ```
  feat: Füge Cookie-Consent-Banner hinzu
  ```

- **fix**: Bug-Fix
  ```
  fix: Dark Mode Button Kontrast verbessert
  ```

- **docs**: Dokumentation
  ```
  docs: AI Content Generator Anleitung erstellt
  ```

- **style**: Code-Stil (keine funktionalen Änderungen)
  ```
  style: Formatierung in customizer.php korrigiert
  ```

- **refactor**: Code-Refactoring
  ```
  refactor: Hero-Section Bilddarstellung optimiert
  ```

- **perf**: Performance-Verbesserung
  ```
  perf: CSS minifiziert für schnelleres Laden
  ```

- **test**: Tests hinzufügen/ändern
  ```
  test: Unit-Tests für Shortcodes
  ```

- **chore**: Build-Prozess, Dependencies
  ```
  chore: Update WordPress auf 6.9.4
  ```

### Scope (Optional)

Bereich der Änderung:

```
fix(dark-mode): Button-Farbe in Hero-Section
feat(ai-content): Tag-Generierung implementiert
docs(readme): Installation-Anleitung aktualisiert
```

### Breaking Changes

Kennzeichnung inkompatibler Änderungen:

```
feat!: Neues Customizer-API

BREAKING CHANGE: Alte Customizer-Funktionen entfernt
```

## Workflow für neue Version

### Schritt 1: Entwicklung & Commits

Arbeiten Sie normal an Ihrem Theme und erstellen Sie Commits:

```bash
# Entwicklung
git add src/style.css
git commit -m "fix: Dark Mode Button Kontrast verbessert"
git push origin main
```

### Schritt 2: Release vorbereiten

Wenn Sie bereit für eine neue Version sind:

```bash
cd scripts
./git_new_version.sh
```

### Schritt 3: Bestätigung

Das Skript zeigt Ihnen die neue Version:

```
Letzer Tag: 2.1.3 → Neue Version: 2.1.4 (Modus: auto)
Version 2.1.4 verwenden? (y/n):
```

Geben Sie `y` ein und drücken Sie Enter.

### Schritt 4: Automatischer Ablauf

Das Skript führt automatisch aus:

```
✓ Aktualisiere style.css
✓ Generiere Changelog
✓ Erstelle Commit
✓ Erstelle Git-Tag v2.1.4
✓ Push zu GitHub
✓ Erstelle GitHub Release
```

### Schritt 5: GitHub Action

Die GitHub Action (`release.yml`) wird automatisch getriggert und:

1. Baut Theme-ZIP: `potsdam-rechtsanwalt-theme-v2.1.4.zip`
2. Erstellt SHA256-Checksumme
3. Fügt ZIP zum GitHub Release hinzu

### Schritt 6: WordPress Installation

**Option A: GitHub Updater (automatisch)**
- Gehen Sie zu WordPress → Dashboard → Updates
- Theme-Update sollte erscheinen
- Klicken Sie auf "Aktualisieren"

**Option B: Manuell**
1. Download ZIP von: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases
2. WordPress → Design → Themes → Theme hochladen
3. ZIP-Datei auswählen und installieren

## Beispiel-Workflow

### Szenario: Bug-Fix für Hero-Bild

**1. Problem beheben:**
```bash
# Änderungen in index.php
git add src/index.php src/page.php
git commit -m "fix: Hero-Bild doppelt in Edge Browser

Inline-style nutzt jetzt 'background' statt 'background-image'
Verhindert Doppel-Darstellung in Microsoft Edge"

git push origin main
```

**2. Release erstellen:**
```bash
cd scripts
./git_new_version.sh
```

**3. Ausgabe:**
```
Letzer Tag: 2.1.3 → Neue Version: 2.1.4 (Modus: auto)
Version 2.1.4 verwenden? (y/n): y

Aktualisiere Version in style.css...
style.css aktualisiert: Version 2.1.4

Generiere Changelog für Version 2.1.4...
CHANGELOG.md erfolgreich aktualisiert.

Commit für Release erstellt.
Erstelle Git-Tag 'v2.1.4'...
Pushe 'main'-Branch...
Pushe Git-Tag 'v2.1.4'...
Erstelle GitHub Release für 'v2.1.4'...

==========================================
✅ Release-Prozess für Version 2.1.4 erfolgreich abgeschlossen!

📦 GitHub Release: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases/tag/v2.1.4
🏷️  Git Tag: v2.1.4
📝 Changelog: CHANGELOG.md
🎨 Theme Version: 2.1.4 (style.css)

Die GitHub Action erstellt jetzt automatisch das Theme-ZIP-Paket.
==========================================
```

**4. Prüfen:**
- GitHub Actions: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/actions
- Release: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases

## Changelog-Struktur

Das Skript generiert automatisch einen Changelog in `CHANGELOG.md`:

```markdown
# Changelog

## [2.1.4](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases/tag/v2.1.4)

### Bug Fixes

* Hero-Bild doppelt in Edge Browser ([4f14201](https://github.com/.../commit/4f14201))

## [2.1.3](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases/tag/v2.1.3)

### Features

* Automatische Tag-Generierung für WordPress-Beiträge ([0964817](https://github.com/.../commit/0964817))

### Bug Fixes

* Dark Mode Button Kontrast verbessert ([49fe88d](https://github.com/.../commit/49fe88d))
```

## Fehlerbehebung

### Fehler: "Tag bereits existiert"

```
FEHLER: Tag 'v2.1.4' existiert bereits!
```

**Lösung:**
```bash
# Tag löschen (lokal und remote)
git tag -d v2.1.4
git push origin :refs/tags/v2.1.4

# Erneut ausführen
./git_new_version.sh
```

### Fehler: "conventional-changelog: command not found"

```bash
# Installieren Sie conventional-changelog-cli
npm install -g conventional-changelog-cli
```

### Fehler: "gh: command not found"

```bash
# Installieren Sie GitHub CLI
winget install GitHub.cli

# Oder: https://cli.github.com/
```

### Fehler: "gh auth required"

```bash
# Authentifizieren Sie sich bei GitHub
gh auth login
```

### Fehler: "style.css nicht gefunden"

```
Warnung: style.css nicht gefunden unter ../src/style.css
```

**Lösung:**
- Stellen Sie sicher, dass Sie das Skript aus dem `scripts/` Verzeichnis ausführen
- Pfad zur style.css ist relativ: `../src/style.css`

### Fehler: "Permission denied"

```bash
# Machen Sie das Skript ausführbar
chmod +x scripts/git_new_version.sh
```

### Changelog leer oder fehlerhaft

**Ursache:** Commits folgen nicht dem Conventional Commits Standard

**Lösung:**
- Verwenden Sie `feat:`, `fix:`, etc. in Commit-Messages
- Oder setzen Sie einen Start-Tag im Skript:
  ```bash
  start_from_this_tag="2.1.3"
  ```

## Best Practices

### 1. Regelmäßige kleine Releases

Besser:
- `2.1.4` → Bug-Fix
- `2.1.5` → Weiterer Bug-Fix
- `2.2.0` → Feature-Release

Statt:
- `2.1.4` → Alles auf einmal (schwer nachvollziehbar)

### 2. Aussagekräftige Commit-Messages

✅ **Gut:**
```
fix: Dark Mode Button nicht lesbar im Hero-Bereich

- Button 'Unsere Leistungen' hatte zu wenig Kontrast
- Textfarbe auf #000000 gesetzt für maximale Lesbarkeit
- Betrifft nur Dark Mode (html.dark-mode .btn-primary)
```

❌ **Schlecht:**
```
button fix
```

### 3. Testen vor Release

```bash
# Lokale Änderungen testen
# Dann committen
git add .
git commit -m "fix: ..."
git push

# Erst dann Release erstellen
./git_new_version.sh
```

### 4. Dokumentation aktualisieren

Vor Major-Releases:
- README.md aktualisieren
- Migrations-Guide erstellen (bei Breaking Changes)
- Changelog manuell ergänzen falls nötig

### 5. Backup vor Major-Release

Bei Major-Updates (3.0.0):
```bash
# WordPress-Datenbank-Backup erstellen
# Theme-Backup via Synology Hyper Backup
# Dann erst Release durchführen
```

## Integration mit anderen Tools

### Mit AI Content Generator

```bash
# 1. Script-Änderungen committen
git add scripts/wordpress-ai-content-generator.ps1
git commit -m "feat: Berlin als Zielregion hinzugefügt"
git push

# 2. Release erstellen
cd scripts
./git_new_version.sh --minor  # 2.1.4 → 2.2.0
```

### Mit Theme-Package-Creator

```bash
# Der create-theme-package.ps1 ist nicht mehr nötig
# GitHub Action erstellt automatisch das ZIP bei jedem Tag-Push
```

### Mit GitHub Updater Plugin

Das WordPress-Plugin GitHub Updater erkennt automatisch neue Releases:

1. In `style.css` muss vorhanden sein:
   ```css
   Update URI: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt
   ```

2. Plugin prüft GitHub nach neuen Tags
3. Zeigt Update-Benachrichtigung in WordPress
4. Lädt ZIP vom GitHub Release

## Alternatives Workflow (ohne Skript)

Falls Sie manuell versionieren möchten:

```bash
# 1. style.css manuell anpassen
# Version: 2.1.4

# 2. Committen
git add src/style.css
git commit -m "chore(release): Version 2.1.4"

# 3. Tag erstellen
git tag v2.1.4

# 4. Pushen
git push origin main --tags
```

Die GitHub Action wird trotzdem getriggert und erstellt das Theme-ZIP.

## Weitere Ressourcen

- **Semantic Versioning:** https://semver.org/
- **Conventional Commits:** https://www.conventionalcommits.org/
- **GitHub Releases:** https://docs.github.com/en/repositories/releasing-projects-on-github
- **conventional-changelog:** https://github.com/conventional-changelog/conventional-changelog
- **GitHub CLI:** https://cli.github.com/manual/

## Support

Bei Problemen:
1. Diese Anleitung durchlesen
2. `docs/TROUBLESHOOTING.md` prüfen
3. GitHub Issues: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/issues

---

**Version:** 1.0  
**Letzte Aktualisierung:** 23. April 2026  
**Autor:** WordPress Theme Development Team
