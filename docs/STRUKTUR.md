# Repository-Struktur

## 📂 Aktuelle Struktur (optimiert)

```
potsdam-rechtsanwalt/
│
├── 📁 src/                          ← Theme-Quellcode
│   ├── style.css                    WordPress Theme-Stylesheet
│   ├── functions.php                Theme-Funktionen
│   ├── index.php                    Haupt-Template
│   ├── header.php                   Header
│   ├── footer.php                   Footer
│   ├── sidebar.php                  Sidebar
│   ├── page.php                     Seiten-Template
│   ├── single.php                   Beitrags-Template
│   ├── archive.php                  Archiv-Template
│   ├── search.php                   Such-Template
│   ├── 404.php                      Fehlerseite
│   │
│   ├── 📁 assets/                   Assets (CSS, JS, Bilder)
│   │   ├── css/
│   │   │   ├── animations.css
│   │   │   └── custom.css
│   │   ├── js/
│   │   │   └── main.js
│   │   └── images/
│   │       └── README.md
│   │
│   └── 📁 inc/                      Zusätzliche PHP-Funktionen
│       ├── customizer.php           Customizer-Einstellungen
│       └── template-tags.php        Helper-Funktionen
│
├── 📁 .github/                      GitHub-Konfiguration
│   ├── workflows/
│   │   ├── release.yml              Automatisches Release
│   │   └── build.yml                Build & Test
│   └── WORKFLOW-GUIDE.md            Workflow-Dokumentation
│
├── 📄 .gitignore                    Git-Ignores
├── 📄 README.md                     ⭐ Haupt-Dokumentation
├── 📄 INSTALLATION.md               Theme-Installation
├── 📄 CHANGELOG.md                  Versions-Historie
├── 📄 DEVELOPMENT.md                Entwickler-Guide
├── 📄 RELEASE.md                    Release-Kurzanleitung
├── 📄 THEME-STRUKTUR.md             WordPress-Struktur Erklärung
├── 📄 PACKAGE-ANLEITUNG.md          Paket-Erstellung
├── 📄 SCREENSHOT-INFO.md            Screenshot-Info
├── 📁 scripts/
│   └── 📄 create-theme-package.ps1      Lokales Build-Skript
├── 📁 config/
├── 📁 docs/
```

## 🎯 Vorteile dieser Struktur

### ✅ Code vs. Dokumentation getrennt

- **`/src`** = Nur Theme-Code (PHP, CSS, JS)
- **Root** = Nur Dokumentation (.md) und Config

### ✅ Sauberes Git-Repository

- Keine Build-Artefakte im Repo
- Klare Struktur
- Leicht zu navigieren

### ✅ CI/CD-freundlich

GitHub Workflows arbeiten mit `/src`:
```yaml
# Workflow kopiert src/* für Build
cp -r src/* build/potsdam-rechtsanwalt/
```

### ✅ Entwickler-freundlich

- Alle Code-Dateien in einem Ordner
- Dokumentation im Root schnell auffindbar
- Keine Vermischung

## 📦 Build-Prozess

```
Repository:
  src/
    ├── style.css
    ├── functions.php
    └── ...
        ↓
    [Build]
        ↓
potsdam-rechtsanwalt-theme.zip
  └── potsdam-rechtsanwalt/  ← Installationsfähiges Theme
      ├── style.css
      ├── functions.php
      └── ...
```

## 🔄 Workflows

### Automatisches Release (GitHub)

1. Tag erstellen: `git tag v1.0.0`
2. Pushen: `git push origin v1.0.0`
3. GitHub Actions:
   - Kopiert `src/*`
   - Erstellt ZIP
   - Veröffentlicht Release

### Lokaler Build (PowerShell)

```powershell
.\scripts\create-theme-package.ps1
```

- Liest aus `src/`
- Erstellt ZIP eine Ebene höher
- Öffnet Explorer mit Datei

## 📚 Dokumentation

| Datei | Beschreibung |
|-------|--------------|
| [README.md](README.md) | Haupt-Dokumentation, Features, Installation |
| [INSTALLATION.md](INSTALLATION.md) | Detaillierte Installations-Anleitung |
| [DEVELOPMENT.md](DEVELOPMENT.md) | Entwickler-Guide, Best Practices |
| [CHANGELOG.md](CHANGELOG.md) | Versions-Historie |
| [RELEASE.md](RELEASE.md) | Schnellanleitung für Releases |
| [THEME-STRUKTUR.md](THEME-STRUKTUR.md) | WordPress Theme-Struktur Erklärung |
| [.github/WORKFLOW-GUIDE.md](.github/WORKFLOW-GUIDE.md) | GitHub Actions Guide |

## 🚀 Quick Start

### Als Entwickler

```bash
# Repository klonen
git clone https://github.com/DEIN-USERNAME/potsdam-rechtsanwalt.git
cd potsdam-rechtsanwalt

# In src/ entwickeln
cd src
# ... Code-Änderungen ...

# Lokal testen
cd ..
.\create-theme-package.ps1
```

### Als Nutzer

1. Gehe zu [Releases](https://github.com/DEIN-USERNAME/potsdam-rechtsanwalt/releases)
2. Lade ZIP herunter
3. In WordPress installieren

## 🔍 Vergleich: Vorher vs. Nachher

### ❌ Vorher (unorganisiert)

```
potsdam-rechtsanwalt/
├── style.css               ← Code
├── functions.php           ← Code
├── README.md               ← Doku
├── INSTALLATION.md         ← Doku
├── assets/                 ← Code
└── ...                     ← Alles durcheinander
```

### ✅ Nachher (organisiert)

```
potsdam-rechtsanwalt/
├── src/                    ← Alles Code hier
│   ├── style.css
│   ├── functions.php
│   └── assets/
├── README.md               ← Alle Doku hier
├── INSTALLATION.md
└── ...
```

## 💡 Best Practices

1. **Nie direkt Releases committen** - nur Quellcode in `src/`
2. **Dokumentation im Root** - leichter auffindbar
3. **Workflows nutzen `src/`** - automatisches Build
4. **ZIP-Dateien in .gitignore** - keine Build-Artefakte

## 🎓 Hinweis für WordPress

Das finale ZIP-Paket hat die korrekte WordPress-Struktur:

```
potsdam-rechtsanwalt-theme.zip
└── potsdam-rechtsanwalt/      ← Theme-Ordner
    ├── style.css              ← Im Root (WordPress-Anforderung)
    ├── functions.php
    ├── index.php
    └── ...
```

Die `/src` Struktur ist nur für das Repository - im finalen Theme ist alles im Root!
