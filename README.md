# Potsdam Rechtsanwalt - WordPress Theme

Ein elegantes, professionelles WordPress-Theme für Rechtsanwaltskanzleien in Potsdam.

## 📁 Repository-Struktur

```
potsdam-rechtsanwalt/
│
├── src/                         # Theme-Quellcode
│   ├── style.css                # Theme-Stylesheet
│   ├── functions.php            # Theme-Funktionen
│   ├── index.php                # Haupt-Template
│   ├── header.php               # Header-Template
│   ├── footer.php               # Footer-Template
│   ├── sidebar.php              # Sidebar-Template
│   ├── *.php                    # Weitere Templates
│   ├── assets/                  # CSS, JS, Bilder
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── inc/                     # Zusätzliche PHP-Funktionen
│       ├── customizer.php
│       └── template-tags.php
│
├── .github/                     # GitHub Actions Workflows
│   └── workflows/
│       ├── release.yml          # Automatisches Release
│       └── build.yml            # Build & Test
│
├── config/                      # Konfigurationsdateien (.env, .htaccess, etc.)
├── docs/                        # Dokumentation
├── scripts/                     # PowerShell Scripts
│   └── create-theme-package.ps1    # Lokales Build-Skript
├── setup-tools/                 # Einmalige Setup-Scripts
├── src/                         # WordPress Theme Dateien
├── README.md                    # Diese Datei
└── CHANGELOG.md                 # Versions-Historie
```

**Hinweis:** Alle Theme-Dateien befinden sich im `/src` Ordner. Die GitHub Workflows erstellen automatisch ein installationsfähiges ZIP-Paket daraus.

## Features

- **Modernes Design**: Klares, professionelles Layout mit zweispaltiger Struktur
- **Responsive**: Vollständig responsive für alle Geräte (Desktop, Tablet, Mobile)
- **Farbschema**: Elegantes Marineblau, Anthrazitgrau mit Gold/Beige-Akzenten
- **Hero-Bereich**: Eindrucksvoller Hero mit Hintergrundbild und Call-to-Action
- **Service-Grid**: 4 Rechtsdienstleistungsfelder mit Icons
- **Kontaktformular**: Integriertes Kontaktformular in der Sidebar
- **Customizer-Support**: Einfache Anpassung über WordPress Customizer
- **SEO-freundlich**: Sauberer, semantischer HTML5-Code
- **Performance**: Optimiert für schnelle Ladezeiten

## Installation

### Option 1: GitHub Release herunterladen (empfohlen)

1. Gehe zu [Releases](https://github.com/DEIN-USERNAME/potsdam-rechtsanwalt/releases)
2. Lade die neueste `potsdam-rechtsanwalt-theme-vX.X.X.zip` herunter
3. In WordPress: **Design → Themes → Installieren → Theme hochladen**
4. ZIP-Datei auswählen und installieren
5. Theme aktivieren

### Option 2: Lokal mit PowerShell-Skript

1. Repository klonen:
   ```bash
   git clone https://github.com/DEIN-USERNAME/potsdam-rechtsanwalt.git
   cd potsdam-rechtsanwalt
   ```

2. Build-Skript ausführen:
   ```powershell
   .\scripts\create-theme-package.ps1
   ```

3. Die ZIP-Datei befindet sich im übergeordneten Verzeichnis
4. In WordPress hochladen und aktivieren

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

- **Contact Form 7** oder **WPForms**: Für erweiterte Formulare
- **Yoast SEO**: Für Suchmaschinenoptimierung
- **UpdraftPlus**: Für Backups
- **WP Mail SMTP**: Für zuverlässigen E-Mail-Versand
- **Really Simple SSL**: Für HTTPS-Verschlüsselung
- **GDPR Cookie Consent**: Für DSGVO-konforme Cookie-Hinweise

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

### Theme-Version
Aktuelle Version: 1.0

### Changelog
- **1.0** (2026-04-10): Initiale Veröffentlichung

## Browser-Kompatibilität

- Chrome (neueste Version)
- Firefox (neueste Version)
- Safari (neueste Version)
- Edge (neueste Version)
- Mobile Browser (iOS Safari, Chrome Mobile)

## Technische Anforderungen

- WordPress 5.0 oder höher
- PHP 7.4 oder höher
- MySQL 5.6 oder höher

## Lizenz

Dieses Theme ist unter der GNU General Public License v2 oder höher lizenziert.

## Credits

- Theme-Entwicklung: Ihre Kanzlei
- Icons: Line Icons (SVG)
- Schriftarten: Google Fonts (Roboto, Merriweather)

## Hilfe & Dokumentation

Bei Fragen zur Einrichtung oder Anpassung wenden Sie sich an Ihren WordPress-Administrator oder Theme-Entwickler.

---

**Wichtig für den rechtssicheren Betrieb:**

- Impressum anlegen (gesetzliche Pflicht)
- Datenschutzerklärung erstellen (DSGVO)
- Cookie-Consent einrichten
- SSL-Zertifikat installieren
- Regelmäßige Backups durchführen
