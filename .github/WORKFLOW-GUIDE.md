# GitHub Release Workflow - Anleitung

## Übersicht

Dieses Repository nutzt GitHub Actions, um automatisch installationsfähige Theme-Pakete zu erstellen und zu veröffentlichen.

## 🚀 Automatische Releases

### Release erstellen

1. **Änderungen committen und pushen:**
   ```bash
   git add .
   git commit -m "Release v1.0.0 vorbereiten"
   git push origin main
   ```

2. **Version-Tag erstellen:**
   ```bash
   git tag -a v1.0.0 -m "Version 1.0.0"
   git push origin v1.0.0
   ```

3. **Automatischer Workflow:**
   - GitHub Actions wird automatisch ausgelöst
   - Theme-Paket wird erstellt
   - ZIP-Datei wird als Release-Asset hochgeladen
   - Release-Notes werden generiert

### Release-Download

Nach erfolgreichem Workflow:
1. Gehe zu **Releases** auf GitHub
2. Finde die neue Version
3. Lade `potsdam-rechtsanwalt-theme-vX.X.X.zip` herunter
4. Installiere in WordPress

## 🔧 Workflow-Dateien

### 1. Release Workflow (`.github/workflows/release.yml`)

**Wird ausgelöst bei:**
- Push eines Version-Tags (v1.0.0, v2.1.5, etc.)
- Manueller Auslösung über GitHub UI

**Was passiert:**
1. Repository wird ausgecheckt
2. Version wird aus Tag ermittelt
3. Theme-Dateien werden kopiert (ohne .git, etc.)
4. Version in style.css wird aktualisiert
5. ZIP-Archiv wird erstellt
6. SHA-256 Prüfsumme wird generiert
7. GitHub Release wird erstellt mit:
   - ZIP-Datei
   - Prüfsumme
   - Release-Notes

### 2. Build & Test Workflow (`.github/workflows/build.yml`)

**Wird ausgelöst bei:**
- Push auf main/master/develop Branch
- Pull Requests

**Was passiert:**
1. Theme-Struktur wird validiert
2. Pflichtdateien werden geprüft
3. style.css Header wird validiert
4. PHP-Syntax wird geprüft
5. Test-Build wird erstellt
6. Test-Artifact wird hochgeladen

## 📝 Versionierung

Nutzen Sie [Semantic Versioning](https://semver.org/):

- **v1.0.0** - Major Release (Breaking Changes)
- **v1.1.0** - Minor Release (neue Features)
- **v1.0.1** - Patch Release (Bugfixes)

### Beispiel-Workflow:

```bash
# Feature entwickeln
git checkout -b feature/neue-funktion
# ... Entwicklung ...
git commit -m "Neue Funktion hinzugefügt"

# Zurück zu main
git checkout main
git merge feature/neue-funktion

# CHANGELOG.md aktualisieren
# Version in style.css aktualisieren (optional, wird automatisch gemacht)

# Committen
git add .
git commit -m "Version 1.1.0"
git push origin main

# Tag erstellen und pushen
git tag -a v1.1.0 -m "Version 1.1.0 - Neue Funktion"
git push origin v1.1.0

# Workflow läuft automatisch
# Nach 1-2 Minuten: Release ist verfügbar!
```

## 🔍 Workflow-Status prüfen

1. Gehe zu **Actions** Tab auf GitHub
2. Sieh den Status des laufenden Workflows
3. Bei Fehlern: Klicke auf den Workflow für Details

## 🎯 Manueller Workflow-Start

Du kannst den Release-Workflow auch manuell starten:

1. Gehe zu **Actions** Tab
2. Wähle "WordPress Theme Release"
3. Klicke: **Run workflow**
4. Wähle Branch
5. Klicke: **Run workflow**

Dies erstellt ein Artifact (kein Release), das du 30 Tage lang herunterladen kannst.

## 📦 Build-Artifacts

Bei manuellen Builds oder Test-Builds:
1. Gehe zu **Actions**
2. Wähle den abgeschlossenen Workflow
3. Im Abschnitt **Artifacts** findest du:
   - `test-theme-build` (von build.yml)
   - `potsdam-rechtsanwalt-theme-vXXXXXXXX` (von manuellem release.yml)

## 🔐 Prüfsummen verifizieren

Nach dem Download kannst du die Integrität prüfen:

```bash
# Windows PowerShell
$hash = Get-FileHash potsdam-rechtsanwalt-theme-v1.0.0.zip -Algorithm SHA256
echo $hash.Hash

# Vergleiche mit der .sha256 Datei
```

## ⚙️ Workflow anpassen

### Ausgeschlossene Dateien ändern

In `.github/workflows/release.yml` Zeile 31-40:
```yaml
--exclude='.git' \
--exclude='.github' \
--exclude='deine-datei' \
```

### Release-Notes anpassen

In `.github/workflows/release.yml` Zeile 58-78:
Bearbeite den `body:` Abschnitt.

## 🐛 Troubleshooting

### Workflow schlägt fehl

**Häufige Probleme:**

1. **PHP Syntax-Fehler:**
   - Prüfe alle PHP-Dateien lokal
   - Nutze `php -l datei.php`

2. **Fehlende Pflichtdateien:**
   - style.css, functions.php, index.php müssen vorhanden sein

3. **Ungültiger style.css Header:**
   - Muss Theme Name und Version enthalten

4. **GitHub Token fehlt:**
   - Sollte automatisch verfügbar sein
   - Bei privaten Repos: Prüfe Repository Settings → Actions

### Release wird nicht erstellt

- Stelle sicher, dass der Tag mit `v` beginnt (v1.0.0)
- Prüfe, ob der Workflow-Run erfolgreich war
- Schaue in Actions → Workflow-Details

## 📚 Weitere Ressourcen

- [GitHub Actions Dokumentation](https://docs.github.com/de/actions)
- [Semantic Versioning](https://semver.org/lang/de/)
- [Keep a Changelog](https://keepachangelog.com/de/)

## 🎉 Schnellstart

```bash
# 1. Änderungen vorbereiten
git add .
git commit -m "Bereit für Release v1.0.0"

# 2. CHANGELOG.md aktualisieren
# 3. Push
git push origin main

# 4. Tag erstellen
git tag -a v1.0.0 -m "Version 1.0.0"
git push origin v1.0.0

# 5. Warten (1-2 Minuten)
# 6. Gehe zu GitHub Releases
# 7. ZIP herunterladen
# 8. In WordPress installieren
```

Fertig! 🚀
