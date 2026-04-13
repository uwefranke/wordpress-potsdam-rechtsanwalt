# Entwickler-Dokumentation

## Repository-Aufbau

Dieses Repository nutzt eine organisierte Struktur:

```
potsdam-rechtsanwalt/
│
├── src/                    # Theme-Quellcode (wird zu WordPress-Theme)
│   ├── *.php               # Template-Dateien
│   ├── style.css           # Haupt-Stylesheet
│   ├── assets/             # Assets (CSS, JS, Bilder)
│   └── inc/                # PHP-Includes
│
├── .github/                # GitHub Actions & Workflows
│
└── *.md                    # Dokumentation im Root
```

## Warum diese Struktur?

### ✅ Vorteile

1. **Klare Trennung**: Code (src/) vs. Dokumentation (Root)
2. **Git-freundlich**: Nur Quellcode im src/, keine Build-Artefakte
3. **Übersichtlich**: Dokumentation auf einen Blick
4. **CI/CD ready**: Workflows bauen aus src/ das deploybare Theme

### 🔄 Build-Prozess

```
src/
  ├── style.css
  ├── functions.php
  ├── index.php
  └── ...
      ↓
  [GitHub Workflow / Lokales Skript]
      ↓
potsdam-rechtsanwalt-theme.zip
  └── potsdam-rechtsanwalt/
      ├── style.css
      ├── functions.php
      ├── index.php
      └── ...
```

## Entwicklung

### Lokales Setup

1. **Repository klonen**
   ```bash
   git clone https://github.com/DEIN-USERNAME/potsdam-rechtsanwalt.git
   cd potsdam-rechtsanwalt
   ```

2. **Theme-Dateien bearbeiten**
   - Alle Änderungen im `/src` Ordner vornehmen
   - Neue PHP-Dateien in `src/`
   - Assets in `src/assets/`
   - Includes in `src/inc/`

3. **Lokal testen**
   
   **Option A: Direktlink (Entwicklung)**
   ```bash
   # Windows (als Administrator)
   mklink /D "C:\xampp\htdocs\wordpress\wp-content\themes\potsdam-rechtsanwalt" "C:\Pfad\zum\Repo\src"
   
   # Linux/Mac
   ln -s /pfad/zum/repo/src /var/www/html/wp-content/themes/potsdam-rechtsanwalt
   ```

   **Option B: Build-ZIP erstellen**
   ```powershell
   .\scripts\create-theme-package.ps1
   ```

### Datei hinzufügen

```bash
# Template-Datei hinzufügen
cd src
# Erstelle z.B. page-kontakt.php

# Committen
git add src/page-kontakt.php
git commit -m "Template für Kontakt-Seite hinzugefügt"
git push
```

### Release erstellen

1. **CHANGELOG.md aktualisieren**
   ```markdown
   ## [1.1.0] - 2026-04-11
   ### Hinzugefügt
   - Neues Kontakt-Seiten Template
   ```

2. **Version in style.css aktualisieren**
   ```css
   /*
   Version: 1.1.0
   */
   ```

3. **Git-Tag erstellen**
   ```bash
   git add .
   git commit -m "Release v1.1.0 vorbereitet"
   git push
   
   git tag -a v1.1.0 -m "Version 1.1.0"
   git push origin v1.1.0
   ```

4. **Automatischer Build**
   - GitHub Actions erstellt automatisch ZIP
   - Release wird auf GitHub veröffentlicht
   - ZIP kann heruntergeladen werden

## GitHub Workflows

### release.yml

**Trigger:** Git-Tag `v*.*.*`

**Funktion:**
1. Checkout Repository
2. Kopiere `src/*` nach `build/potsdam-rechtsanwalt/`
3. Aktualisiere Version in style.css
4. Erstelle ZIP
5. Erstelle GitHub Release mit ZIP-Download

### build.yml

**Trigger:** Push auf main/master/develop, Pull Requests

**Funktion:**
1. Validiere Theme-Struktur
2. Prüfe PHP-Syntax
3. Prüfe style.css Header
4. Erstelle Test-Build
5. Upload als Artifact

## Dateistruktur im Detail

### `/src` - Theme-Quellcode

```
src/
├── style.css               # Theme-Hauptdatei mit Header
├── functions.php           # Theme-Funktionen, lädt /inc
├── index.php               # Fallback-Template
├── header.php              # Header-Template
├── footer.php              # Footer-Template
├── sidebar.php             # Sidebar-Template
├── page.php                # Seiten-Template
├── single.php              # Einzelbeitrags-Template
├── archive.php             # Archiv-Template
├── search.php              # Such-Template
├── 404.php                 # Fehler-Template
│
├── assets/
│   ├── css/
│   │   ├── animations.css  # Animationen
│   │   └── custom.css      # Eigene Anpassungen
│   ├── js/
│   │   └── main.js         # Haupt-JavaScript
│   └── images/
│       └── README.md       # Platzhalter für Hero-Bild
│
└── inc/
    ├── customizer.php      # Customizer-Einstellungen
    └── template-tags.php   # Helper-Funktionen
```

### Root - Dokumentation & Config

```
/
├── .github/
│   ├── workflows/          # CI/CD Workflows
│   └── WORKFLOW-GUIDE.md   # Workflow-Dokumentation
│
├── .gitignore              # Git-Ignores
├── README.md               # Haupt-README
├── INSTALLATION.md         # Installationsanleitung
├── CHANGELOG.md            # Versions-Historie
├── RELEASE.md              # Release-Kurzanleitung
├── THEME-STRUKTUR.md       # WordPress Theme-Struktur Erklärung
├── scripts/
│   └── create-theme-package.ps1 # Lokales Build-Skript
├── config/
```

## Best Practices

### 1. Nie direkt in `/src` entwickeln

Verwende einen Feature-Branch:
```bash
git checkout -b feature/neue-funktion
# Entwicklung in src/
git commit -m "Neue Funktion implementiert"
git push origin feature/neue-funktion
# Pull Request erstellen
```

### 2. Tests vor Release

```bash
# Syntax prüfen
php -l src/functions.php

# Lokal bauen
.\create-theme-package.ps1

# In WordPress testen
```

### 3. Versionsnummern

- `1.0.0` → Erste stabile Version
- `1.1.0` → Neue Features (Minor)
- `1.0.1` → Bugfixes (Patch)
- `2.0.0` → Breaking Changes (Major)

### 4. Commit-Nachrichten

```bash
git commit -m "feat: Service-Karten Animation hinzugefügt"
git commit -m "fix: Kontaktformular Validierung behoben"
git commit -m "docs: README aktualisiert"
```

## Deployment

### Automatisch (empfohlen)

1. Tag erstellen: `git tag v1.0.0`
2. Pushen: `git push origin v1.0.0`
3. GitHub Actions baut ZIP
4. ZIP von Releases herunterladen
5. In WordPress installieren

### Manuell

1. Skript ausführen: `.\create-theme-package.ps1`
2. ZIP hochladen zu WordPress
3. Aktivieren

## Troubleshooting

### Workflow schlägt fehl

**Problem:** PHP-Syntax-Fehler
```bash
# Lokal prüfen
find src -name "*.php" -exec php -l {} \;
```

**Problem:** style.css Header fehlt
```bash
# Prüfen in src/style.css:
head -20 src/style.css
```

### Symlink funktioniert nicht

**Windows:** Als Administrator ausführen
**Linux/Mac:** Prüfe Berechtigungen

## Weitere Infos

- [WordPress Theme-Entwicklung](https://developer.wordpress.org/themes/)
- [Semantic Versioning](https://semver.org/)
- [GitHub Actions](https://docs.github.com/actions)
