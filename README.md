# Potsdam Rechtsanwalt - WordPress Theme

[![Version](https://img.shields.io/github/v/release/uwefranke/wordpress-potsdam-rechtsanwalt)](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases)
[![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-purple.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-GPLv2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![AI Powered](https://img.shields.io/badge/AI-Claude%20Sonnet%204.6-orange.svg)](https://www.anthropic.com/)

Ein elegantes, professionelles WordPress-Theme für Rechtsanwaltskanzleien in Potsdam und Berlin mit AI-gestützter Content-Erstellung, Dark Mode und umfangreichen Customizer-Optionen.

## ✨ Highlights

- 🤖 **AI-Content-Generator** mit Claude AI (Anthropic)
- 🌙 **Dark Mode** mit persistenter Speicherung
- 📊 **SEO-optimiert** mit Rank Math PRO Integration
- 🔄 **Automatische Updates** über GitHub
- 📱 **Vollständig responsive** für alle Geräte
- 🎨 **Umfangreicher Customizer** für einfache Anpassungen
- 🎨 **Icon-Auswahl** für Rechtsgebiete (20 rechtsspezifische Icons)
- ♿ **Barrierefrei** nach WCAG 2.1 Level AA
- 🔐 **DSGVO-konform** mit Cookie Consent System

## 📁 Repository-Struktur

```
potsdam-rechtsanwalt/
│
├── src/                         # Theme-Quellcode (WordPress Theme)
│   ├── *.php                    # Template-Dateien
│   ├── style.css                # Theme-Stylesheet mit Metadaten
│   ├── functions.php            # Theme-Funktionen
│   ├── assets/                  # Frontend-Assets
│   │   ├── css/                 # Stylesheets (animations, cookie-consent, custom, fonts)
│   │   ├── js/                  # JavaScript (main, darkmode, cookie-consent)
│   │   ├── images/              # Theme-Bilder
│   │   └── fonts/               # Lokale Schriftarten (DSGVO)
│   └── inc/                     # PHP-Funktionsbibliotheken
│       ├── customizer.php       # WordPress Customizer Integration
│       ├── template-tags.php    # Template-Hilfsfunktionen
│       ├── shortcodes.php       # Custom Shortcodes
│       ├── qrcode-generator.php # QR-Code-Funktionen
│       ├── phpqrcode.php        # QR-Code-Bibliothek
│       ├── github-updater.php   # Theme-Update über GitHub
│       └── mail-settings.php    # SMTP-Konfiguration
│
├── scripts/                     # Automatisierungs-Scripts
│   ├── wordpress-ai-content-generator.ps1  # AI Content Generator
│   ├── update-post-tags.ps1                # Bulk Tag Update
│   ├── git_new_version.sh                  # Version Management (Bash)
│   ├── create-theme-package.ps1            # Theme-ZIP erstellen
│   ├── download-fonts.ps1                  # Google Fonts Download
│   ├── convert-site-icon.ps1               # Favicon-Konvertierung
│   ├── show-categories.ps1                 # WordPress-Kategorien
│   └── test-gemini.ps1                     # Gemini API Test
│
├── docs/                        # Umfangreiche Dokumentation (22 Dateien)
│   ├── INSTALLATION.md          # Theme-Installation
│   ├── AI-CONTENT-GENERATOR-ANLEITUNG.md
│   ├── UPDATE-POST-TAGS-ANLEITUNG.md
│   ├── VERSION-RELEASE-ANLEITUNG.md
│   ├── CUSTOMIZER-LAYOUT-OPTIONEN.md
│   ├── SHORTCODES-ANLEITUNG.md
│   ├── COOKIE-CONSENT.md
│   └── ...                      # Weitere Dokumentation
│
├── .github/                     # GitHub Actions Workflows
│   └── workflows/
│       ├── release.yml          # Automatisches Release (bei Tags)
│       └── build.yml            # Build & Test (bei Push)
│
├── config/                      # Konfigurationsdateien
│   ├── .env.example             # Umgebungsvariablen-Template
│   └── nginx.conf.example       # Nginx-Konfiguration
│
├── setup-tools/                 # Einmalige Setup-Scripts
│   └── setup-pages.php          # WordPress-Seiten erstellen
│
├── README.md                    # Diese Datei
├── CHANGELOG.md                 # Versions-Historie (Auto-generiert)
└── .gitignore                   # Git-Ignore-Regeln
```

**Hinweis:** Alle Theme-Dateien befinden sich im `/src` Ordner. Die GitHub Workflows erstellen automatisch ein installationsfähiges ZIP-Paket daraus.

## 🤖 Automatisierung & Scripts

Das Theme enthält umfangreiche PowerShell- und Bash-Scripts zur Automatisierung:

### Content-Erstellung
- **`wordpress-ai-content-generator.ps1`**: Automatische Artikelerstellung mit Claude AI
  - Generiert SEO-optimierte Rechtsartikel mit lokalem Bezug (Potsdam/Berlin)
  - Automatische Tag-Generierung (5 Keywords pro Artikel)
  - Konfigurierbar über `.env` Datei
  - Dokumentation: [AI-CONTENT-GENERATOR-ANLEITUNG.md](docs/AI-CONTENT-GENERATOR-ANLEITUNG.md)

- **`update-post-tags.ps1`**: Bulk-Update für bestehende Posts
  - AI-gestützte Tag-Generierung für alle vorhandenen Artikel
  - DryRun-Modus zum Testen
  - Kategoriefilter und Status-Filter
  - Dokumentation: [UPDATE-POST-TAGS-ANLEITUNG.md](docs/UPDATE-POST-TAGS-ANLEITUNG.md)

### Version Management
- **`git_new_version.sh`**: Automatisierte Versionsverwaltung
  - Semantic Versioning (Major/Minor/Patch)
  - Automatische `style.css` Version-Update
  - Changelog-Generierung mit Conventional Commits
  - GitHub Release-Erstellung
  - Dokumentation: [VERSION-RELEASE-ANLEITUNG.md](docs/VERSION-RELEASE-ANLEITUNG.md)

### Theme-Deployment
- **`create-theme-package.ps1`**: Lokales Theme-ZIP erstellen
  - Bereinigt temporäre Dateien
  - Erstellt installationsfähiges ZIP-Paket
  - Dokumentation: [PACKAGE-ANLEITUNG.md](docs/PACKAGE-ANLEITUNG.md)

### Weitere Tools
- **`download-fonts.ps1`**: Google Fonts lokal herunterladen (DSGVO)
- **`convert-site-icon.ps1`**: Favicon-Konvertierung
- **`show-categories.ps1`**: WordPress-Kategorien anzeigen
- **`test-gemini.ps1`**: Google Gemini API testen

Detaillierte Anleitungen finden Sie im [`docs/`](docs/) Verzeichnis.

## 📚 Dokumentation

Umfangreiche Dokumentation im [`docs/`](docs/) Verzeichnis:

### Setup & Installation
- [INSTALLATION.md](docs/INSTALLATION.md) - Theme-Installation
- [MIGRATION.md](docs/MIGRATION.md) - Migration von anderen Themes
- [HTACCESS-INSTALLATION.md](docs/HTACCESS-INSTALLATION.md) - .htaccess Konfiguration
- [NGINX-SETUP.md](docs/NGINX-SETUP.md) - Nginx Server Setup

### Features & Anpassung
- [CUSTOMIZER-LAYOUT-OPTIONEN.md](docs/CUSTOMIZER-LAYOUT-OPTIONEN.md) - Customizer-Einstellungen
- [RECHTSGEBIETE-CUSTOMIZER-ANLEITUNG.md](docs/RECHTSGEBIETE-CUSTOMIZER-ANLEITUNG.md) - Rechtsgebiete konfigurieren
- [ICON-AUSWAHL-ANLEITUNG.md](docs/ICON-AUSWAHL-ANLEITUNG.md) - Icon-Auswahl für Rechtsgebiete
- [SHORTCODES-ANLEITUNG.md](docs/SHORTCODES-ANLEITUNG.md) - Alle verfügbaren Shortcodes
- [COOKIE-CONSENT.md](docs/COOKIE-CONSENT.md) - Cookie-Consent System
- [BREADCRUMBS-ANLEITUNG.md](docs/BREADCRUMBS-ANLEITUNG.md) - Breadcrumb-Navigation

### Content & AI
- [AI-CONTENT-GENERATOR-ANLEITUNG.md](docs/AI-CONTENT-GENERATOR-ANLEITUNG.md) - AI Content Generator
- [UPDATE-POST-TAGS-ANLEITUNG.md](docs/UPDATE-POST-TAGS-ANLEITUNG.md) - Bulk Tag Update
- [QRCODE-PLUGIN-ANLEITUNG.md](docs/QRCODE-PLUGIN-ANLEITUNG.md) - QR-Code Generator
- [QR-CODE-TROUBLESHOOTING.md](docs/QR-CODE-TROUBLESHOOTING.md) - QR-Code Problemlösung

### Entwicklung & Release
- [DEVELOPMENT.md](docs/DEVELOPMENT.md) - Entwicklungsrichtlinien
- [VERSION-RELEASE-ANLEITUNG.md](docs/VERSION-RELEASE-ANLEITUNG.md) - Version Management
- [RELEASE.md](docs/RELEASE.md) - Release-Prozess
- [PACKAGE-ANLEITUNG.md](docs/PACKAGE-ANLEITUNG.md) - Theme-Package erstellen

### Technische Dokumentation
- [STRUKTUR.md](docs/STRUKTUR.md) - Projekt-Struktur
- [THEME-STRUKTUR.md](docs/THEME-STRUKTUR.md) - Theme-Dateistruktur
- [FONTS.md](docs/FONTS.md) - Font-Integration
- [ACCESSIBILITY.md](docs/ACCESSIBILITY.md) - Barrierefreiheit (WCAG 2.1)
- [TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md) - Problemlösungen
- [SCREENSHOT-INFO.md](docs/SCREENSHOT-INFO.md) - Screenshot-Anforderungen

**Hinweis:** Alle Theme-Dateien befinden sich im `/src` Ordner. Die GitHub Workflows erstellen automatisch ein installationsfähiges ZIP-Paket daraus.

## Features

### Design & Usability
- **Modernes Design**: Klares, professionelles Layout mit zweispaltiger Struktur
- **Responsive**: Vollständig responsive für alle Geräte (Desktop, Tablet, Mobile)
- **Dark Mode**: Umschaltbarer Dark Mode mit persistenter Speicherung
- **Farbschema**: Elegantes Marineblau, Anthrazitgrau mit Gold/Beige-Akzenten
- **Hero-Bereich**: Eindrucksvoller Hero mit Hintergrundbild und Call-to-Action
- **Service-Grid**: 1-8 Rechtsdienstleistungsfelder mit individuellen Icons
- **Icon-Auswahl**: 20 rechtsspezifische Icons (Waage, Hammer, Vertrag, etc.)
- **Breadcrumbs**: Automatische Breadcrumb-Navigation
- **Custom Animations**: Fade-In und Slide-Up Effekte

### Content & SEO
- **AI-Content-Generator**: Automatische Artikelerstellung mit Claude AI (Anthropic)
- **AI-Tag-Generierung**: Intelligente Keyword-Vergabe für neue und bestehende Posts
- **SEO-freundlich**: Sauberer, semantischer HTML5-Code, optimiert für Rank Math PRO
- **QR-Code-Generator**: Integrierte QR-Code-Erstellung für Seiten und Posts
- **Shortcodes**: Umfangreiche Custom Shortcodes (Buttons, Boxes, Icons, etc.)

### Funktionalität
- **Kontaktformular**: Integriertes Kontaktformular mit SMTP-Unterstützung in der Sidebar
- **Cookie Consent**: DSGVO-konformes Cookie-Consent-System
- **Customizer-Support**: Umfangreiche Anpassungsoptionen über WordPress Customizer
- **GitHub Updater**: Automatische Theme-Updates über GitHub Releases
- **Performance**: Optimiert für schnelle Ladezeiten, lokale Font-Hosting

## Installation

### 🚀 Quick Start

1. **GitHub Release herunterladen**: [Releases](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases)
2. **Theme hochladen**: WordPress → Design → Themes → Installieren → Theme hochladen
3. **Aktivieren**: Theme aktivieren
4. **Customizer konfigurieren**: Design → Customizer
5. **Fertig!** 🎉

Detaillierte Anleitung: [INSTALLATION.md](docs/INSTALLATION.md)

### Option 1: GitHub Release herunterladen (empfohlen)

1. Gehe zu [Releases](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases)
2. Lade die neueste `potsdam-rechtsanwalt-theme-vX.X.X.zip` herunter
3. In WordPress: **Design → Themes → Installieren → Theme hochladen**
4. ZIP-Datei auswählen und installieren
5. Theme aktivieren

### Option 2: Lokal mit PowerShell-Skript

1. Repository klonen:
   ```bash
   git clone https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt.git
   cd potsdam-rechtsanwalt
   ```

2. Build-Skript ausführen:
   ```powershell
   .\scripts\create-theme-package.ps1
   ```

3. Die ZIP-Datei befindet sich im übergeordneten Verzeichnis
4. In WordPress hochladen und aktivieren

## 🔄 Automatische Updates & CI/CD

### GitHub Actions

Das Theme verwendet GitHub Actions für automatisierte Builds und Releases:

**Release Workflow** (`.github/workflows/release.yml`)
- Wird ausgelöst bei Git-Tags mit Format `v*.*.*` (z.B., `v2.1.4`)
- Erstellt automatisch installationsfähiges ZIP-Paket
- Veröffentlicht als GitHub Release
- Download-Link: [Releases](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases)

**Build Workflow** (`.github/workflows/build.yml`)
- Wird bei jedem Push auf `main` Branch ausgeführt
- Validiert Theme-Struktur
- Überprüft PHP-Syntax
- Stellt Code-Qualität sicher

### GitHub Theme Updater

Das Theme unterstützt automatische Updates über GitHub:
- Eingebaut in `inc/github-updater.php`
- Prüft automatisch auf neue Releases
- Update-Benachrichtigung in WordPress-Admin
- Ein-Klick-Update möglich

**Update URI**: `https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt`

### Version Management für Entwickler

Für neue Releases verwenden Sie das `git_new_version.sh` Script:

```bash
# Im Git Bash Terminal
cd scripts
./git_new_version.sh              # Auto-Increment Patch (2.1.4 → 2.1.5)
./git_new_version.sh --minor      # Increment Minor (2.1.4 → 2.2.0)
./git_new_version.sh --major      # Increment Major (2.1.4 → 3.0.0)
./git_new_version.sh --version 2.5.0  # Spezifische Version
```

Das Script:
- Aktualisiert `src/style.css` Version automatisch
- Generiert Changelog aus Git-Commits
- Erstellt Git-Tag (triggert GitHub Action)
- Veröffentlicht GitHub Release

Dokumentation: [VERSION-RELEASE-ANLEITUNG.md](docs/VERSION-RELEASE-ANLEITUNG.md)

## Konfiguration

### Hero-Bereich anpassen

1. Navigieren Sie zu **Design > Customizer**
2. Wählen Sie **Hero-Bereich**
3. Passen Sie folgende Einstellungen an:
   - **Hero Überschrift**: Die Hauptüberschrift im Hero-Bereich
   - **Hero Text**: Der Beschreibungstext unter der Überschrift
   - **Hero Hintergrundbild**: Laden Sie ein hochwertiges Bild der Potsdamer Skyline hoch (empfohlene Größe: 1920x500px)

### Kontaktinformationen

1. Navigieren Sie zu **Design > Customizer**
2. Wählen Sie **Kontakt-Informationen**
3. Tragen Sie ein:
   - Telefonnummer
   - E-Mail-Adresse
   - Adresse der Kanzlei

### Logo hochladen

1. Gehen Sie zu **Design > Customizer > Website-Identität**
2. Klicken Sie auf **Logo auswählen**
3. Laden Sie Ihr Kanzlei-Logo hoch (empfohlene Größe: 300x100px)

### Menüs einrichten

#### Hauptmenü (Header)

1. Navigieren Sie zu **Design > Menüs**
2. Erstellen Sie ein neues Menü namens "Hauptmenü"
3. Fügen Sie folgende Seiten hinzu:
   - Startseite
   - Rechtsgebiete
   - Team
   - Über uns
   - Kontakt
4. Weisen Sie das Menü der Position **Hauptmenü** zu

#### Footer-Menü

1. Erstellen Sie ein weiteres Menü für den Footer
2. Fügen Sie hinzu:
   - Impressum
   - Datenschutz
   - AGB
3. Weisen Sie das Menü der Position **Footer-Menü** zu

## Erforderliche Seiten

Erstellen Sie folgende Seiten für die vollständige Funktionalität:

### 1. Startseite
- Wird automatisch mit Hero und Services angezeigt

### 2. Rechtsgebiete-Seiten
- Verkehrsrecht
- Familienrecht
- Vertragsrecht
- Immobilienrecht

### 3. Rechtliche Seiten
- **Impressum** (gesetzlich erforderlich)
- **Datenschutz** (DSGVO-konform)
- AGB

### 4. Zusätzliche Seiten
- Team / Über uns
- Kontakt
- Termin (für Online-Terminvereinbarung)

## Hero-Bild einfügen

1. **Bild vorbereiten**:
   - Empfohlene Größe: 1920x500px
   - Format: JPG oder PNG
   - Zeigt die Potsdamer Skyline mit Nikolaikirche
   - Leicht unscharf für bessere Textlesbarkeit

2. **Bild hochladen**:
   - Gehen Sie zu **Medien > Datei hinzufügen**
   - Laden Sie das Bild hoch
   - Oder nutzen Sie den Customizer (siehe oben)

3. **Manuell einfügen** (optional):
   - Speichern Sie das Bild als `potsdam-skyline.jpg`
   - Laden Sie es nach `/wp-content/themes/potsdam-rechtsanwalt/assets/images/` hoch

## Kontaktformular

Das integrierte Kontaktformular sendet E-Mails an die in WordPress hinterlegte Admin-E-Mail-Adresse.

### E-Mail-Einstellungen optimieren

Für zuverlässigen E-Mail-Versand empfehlen wir ein SMTP-Plugin:

1. Installieren Sie **WP Mail SMTP** oder **Easy WP SMTP**
2. Konfigurieren Sie Ihre SMTP-Einstellungen
3. Testen Sie den E-Mail-Versand

## Widgets

Das Theme unterstützt folgende Widget-Bereiche:

1. **Sidebar**: Hauptseitenleiste (wird automatisch mit Kontaktformular gefüllt)
2. **Footer Widget 1**: Erste Spalte im Footer
3. **Footer Widget 2**: Zweite Spalte im Footer
4. **Footer Widget 3**: Dritte Spalte im Footer

**Hinweis**: Die Sidebar hat bereits ein integriertes Kontaktformular. Widgets werden unterhalb angezeigt.

## Empfohlene Plugins

### SEO & Performance
- **Rank Math PRO**: Für professionelle Suchmaschinenoptimierung (aktuell im Einsatz)
- **WP Rocket** oder **W3 Total Cache**: Für Caching und Performance
- **Imagify** oder **ShortPixel**: Für Bildoptimierung

### Funktionalität
- **Contact Form 7** oder **WPForms**: Für erweiterte Formulare
- **UpdraftPlus**: Für automatische Backups
- **Really Simple SSL**: Für HTTPS-Verschlüsselung
- **WP Mail SMTP**: Für zuverlässigen E-Mail-Versand

### DSGVO & Datenschutz
- **Cookie Consent**: Bereits im Theme integriert
- **Complianz** oder **Real Cookie Banner**: Für erweiterte Cookie-Verwaltung
- **Borlabs Cookie**: Premium-Alternative für DSGVO-Compliance

### Entwicklung
- **Query Monitor**: Für Performance-Debugging
- **Debug Bar**: Für Entwickler-Tools

## Anpassungen

### Farben ändern

Bearbeiten Sie die CSS-Variablen in `style.css` (ab Zeile 15):

```css
:root {
    --color-navy: #1a3a5c;          /* Hauptfarbe Marineblau */
    --color-anthracite: #2d3436;    /* Dunkelgrau */
    --color-gold: #d4af37;          /* Goldakzent */
    --color-beige: #f5e6d3;         /* Beige-Akzent */
    /* ... */
}
```

### Rechtsgebiete anpassen

Bearbeiten Sie `index.php` (ab Zeile 25) um die Service-Karten zu ändern:
- Icon
- Überschrift
- Beschreibungstext

## Support & Updates

### Aktuelle Version
Die neueste Version finden Sie unter [GitHub Releases](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases) – der Release-Badge oben zeigt die aktuelle Version automatisch an.

### Changelog
Vollständige Versionshistorie mit allen Änderungen: **[CHANGELOG.md](CHANGELOG.md)**

Die CHANGELOG.md wird automatisch durch das `git_new_version.sh` Script generiert und enthält alle Features, Bugfixes und Änderungen basierend auf den Git-Commits (Conventional Commits Standard).

## Browser-Kompatibilität

- Chrome (neueste Version)
- Firefox (neueste Version)
- Safari (neueste Version)
- Edge (neueste Version)
- Mobile Browser (iOS Safari, Chrome Mobile)

## Technische Anforderungen

### Server
- WordPress 5.0 oder höher (getestet bis 6.9.4)
- PHP 8.2 oder höher (empfohlen: PHP 8.4)
- MySQL 5.6 oder höher / MariaDB 10.3 oder höher
- HTTPS (SSL-Zertifikat) für sichere Verbindungen

### Lokal (Entwicklung)
- PowerShell 7+ für Scripts
- Git und Git Bash für Version Management
- Node.js und npm für Changelog-Generierung
- GitHub CLI (`gh`) für Release-Automatisierung

### AI-Features (optional)
- Anthropic API Key für Claude AI (Content-Generator)
- Mindestens $5 API-Guthaben empfohlen

## Lizenz

Dieses Theme ist unter der GNU General Public License v2 oder höher lizenziert.

## 🤖 AI-Features Setup

Das Theme bietet AI-gestützte Content-Erstellung mit **Claude AI (Anthropic)**:

### Voraussetzungen
1. **Anthropic API Key** beantragen: https://console.anthropic.com/
2. **API-Guthaben** aufladen (Empfehlung: $5+)
3. **`.env` Datei** im `config/` Ordner erstellen (siehe `.env.example`)

### Konfiguration

Erstellen Sie `config/.env` mit folgendem Inhalt:

```env
# WordPress API
WORDPRESS_API_URL=https://ihre-domain.de/wp-json/wp/v2
WORDPRESS_APP_USER=ihr-username
WORDPRESS_APP_PASSWORD=xxxx xxxx xxxx xxxx xxxx xxxx

# AI Provider (Claude/Anthropic)
AI_PROVIDER=anthropic
ANTHROPIC_API_KEY=sk-ant-xxxxxxxxxxxxx
ANTHROPIC_MODEL=claude-sonnet-4.6-20241022

# Content Settings
CONTENT_TAG_COUNT=5
```

### Verwendung

**Neue Artikel erstellen:**
```powershell
.\scripts\wordpress-ai-content-generator.ps1
```

**Bestehende Artikel mit Tags aktualisieren:**
```powershell
.\scripts\update-post-tags.ps1 -CategoryId 5 -ReplaceExisting
```

**Kosten:** ~$0.001-0.002 pro Artikel (sehr günstig!)

Detaillierte Anleitungen:
- [AI-CONTENT-GENERATOR-ANLEITUNG.md](docs/AI-CONTENT-GENERATOR-ANLEITUNG.md)
- [UPDATE-POST-TAGS-ANLEITUNG.md](docs/UPDATE-POST-TAGS-ANLEITUNG.md)

## Credits

- **Theme-Entwicklung**: Uwe Franke
- **Repository**: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt
- **Icons**: Line Icons, Font Awesome
- **Schriftarten**: Google Fonts (Roboto, Merriweather) - lokal gehostet für DSGVO
- **AI-Integration**: Claude AI (Anthropic)
- **QR-Code-Bibliothek**: PHP QR Code Library

## 📞 Hilfe & Support

### Dokumentation
Umfangreiche Dokumentation im [`docs/`](docs/) Verzeichnis mit 22 Anleitungen.

### Problemlösung
- [TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md) - Allgemeine Problemlösungen
- [QR-CODE-TROUBLESHOOTING.md](docs/QR-CODE-TROUBLESHOOTING.md) - QR-Code spezifisch
- [DEVELOPMENT.md](docs/DEVELOPMENT.md) - Entwicklungsrichtlinien

### GitHub
- **Issues**: [GitHub Issues](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/issues)
- **Releases**: [GitHub Releases](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/releases)
- **Actions**: [GitHub Actions](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/actions)

Bei Fragen zur Einrichtung oder Anpassung wenden Sie sich an Ihren WordPress-Administrator oder Theme-Entwickler.

---

**Wichtig für den rechtssicheren Betrieb:**

- Impressum anlegen (gesetzliche Pflicht)
- Datenschutzerklärung erstellen (DSGVO)
- Cookie-Consent einrichten
- SSL-Zertifikat installieren
- Regelmäßige Backups durchführen
