# Changelog

Alle wichtigen Änderungen an diesem Theme werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unreleased]

### In Planung
- Erweiterte Customizer-Optionen
- Zusätzliche Farbschemata

## [1.0.4] - 2026-04-11

### Geändert
- **Rechtsgebiete angepasst an tatsächliche Joomla-Website** (www.potsdam-rechtsanwalt.de)
  - Miet- / Wohnungseigentumsrecht (statt Verkehrsrecht)
  - Grundstücks- / Immobilienrecht (erweitert)
  - Baurecht (statt Vertragsrecht)
  - BU / Erwerbsminderungsrente (statt Familienrecht)
- Service-Cards auf der Startseite mit korrekten Inhalten und Links
- **setup-pages.php komplett überarbeitet** mit:
  - Automatischer Seitenerstellung basierend auf Joomla-Struktur
  - Automatischer Menü-Erstellung mit Hierarchie (Hauptmenü + Footer)
  - Korrekte Parent-Child-Beziehungen (Rechtsgebiete, Informationen)
  - Vollständig ausgefüllte Inhalte:
    - Miet-/Wohnungseigentumsrecht mit allen Services
    - Grundstücks-/Immobilienrecht mit ILB/IBB-Referenz
    - Baurecht mit VOB/BGB
    - BU/Erwerbsminderungsrente
    - Kontakt-Seite mit echter Anschrift (Matthias Lange, Schornsteinfegergasse 5)
    - Über-mich-Seite mit Vita
    - Impressum und Datenschutz (Platzhalter)

### Hinzugefügt
- Automatische Menü-Erstellung in setup-pages.php
- Hierarchische Seitenstruktur (Parent-Seiten: Rechtsgebiete, Informationen)
- Vollständiges Setup mit einem Skript-Aufruf

### Verbessert
- Bessere Übereinstimmung mit der ursprünglichen Joomla-Website
- Einfachere Migration durch automatisiertes Setup
- Professionelle Bedienoberfläche im Setup-Skript

## [1.0.3] - 2026-04-11

### Hinzugefügt
- **Anklickbare Service-Cards** auf der Startseite
- Automatische Verlinkung zu Rechtsgebiete-Seiten:
  - `/verkehrsrecht/`
  - `/familienrecht/`
  - `/vertragsrecht/`
  - `/immobilienrecht/`
- **"Mehr erfahren →" Links** in jeder Service-Card
- **setup-pages.php** - Automatisches Setup-Script für Rechtsgebiete-Seiten
- **MIGRATION.md** - Umfassende Migrations-Anleitung von Joomla

### Geändert
- Service-Cards sind jetzt komplett anklickbar
- Hover-Effekt: Icon färbt sich Gold, Border wird Navy

### Verbessert
- Bessere UX durch intuitive Klickflächen
- Card-Layout mit Flexbox für gleichmäßige Höhen
- CSS-Optimierung für anklickbare Elemente

## [1.0.2] - 2026-04-11

### Hinzugefügt
- **Playfair Display-Schrift** für Überschriften (elegante Serifenschrift)
- **CTA-Button "TERMIN VEREINBAREN"** im Header
- **Hero-Section Buttons**: "UNSERE LEISTUNGEN" und "TERMIN VEREINBAREN"
- **Social Media Icons** in der Sidebar (LinkedIn & XING)
- **Customizer-Einstellungen** für Social Media URLs
- **Gold-Umrandung** bei Service-Card Hover
- **Sticky Header** für bessere Navigation

### Geändert
- **Hero-Standardtexte** aktualisiert:
  - Überschrift: "IHRE KANZLEI IN POTSDAM"
  - Untertitel: "FÜR RECHT, DAS VERTRAUEN SCHAFFT. KOMPETENT & LOKAL."
- **Typografie** verbessert mit Open Sans und Playfair Display
- **Navigation** nutzt jetzt Serifenschrift für edleren Look
- **Mobile Responsiveness** für neue Button-Elemente optimiert

### Verbessert
- Design entspricht modernem Kanzlei-Konzept 2024
- Vertrauensbildende visuelle Elemente
- Professionellere Farbakzente mit Gold
- Bessere Call-to-Action Platzierung

## [1.0.1] - 2026-04-11

### Hinzugefügt
- GitHub Auto-Update Funktionalität
- Update URI im Theme-Header
- Automatische Versions-Prüfung

## [1.0.0] - 2026-04-10

### Hinzugefügt
- Initiale Theme-Version
- Zweispaltiges Layout mit Hauptbereich und Sidebar
- Hero-Bereich mit anpassbarem Hintergrundbild
- Service-Grid mit 4 Rechtsgebieten (Verkehrsrecht, Familienrecht, Vertragsrecht, Immobilienrecht)
- Integriertes Kontaktformular in der Sidebar
- Responsive Design für Desktop, Tablet und Mobile
- Farbschema: Marineblau, Anthrazit, Gold und Beige
- WordPress Customizer-Integration
- Template-Dateien:
  - index.php (Startseite)
  - page.php (Einzelseiten)
  - single.php (Einzelbeiträge)
  - archive.php (Archiv)
  - search.php (Suchergebnisse)
  - 404.php (Fehlerseite)
- Widget-Bereiche:
  - Sidebar
  - 3 Footer-Widget-Bereiche
- JavaScript-Features:
  - Smooth Scrolling
  - Mobile Navigation
  - Formular-Validierung
  - Scroll-to-Top Button
  - Service-Card Animationen
- Umfassende Dokumentation:
  - README.md
  - INSTALLATION.md
  - PACKAGE-ANLEITUNG.md
  - SCREENSHOT-INFO.md

### Theme-Features
- Custom Logo Support
- Post Thumbnails
- HTML5 Support
- Navigationmenüs (Haupt- und Footer-Menü)
- E-Mail-Versand für Kontaktformular
- Customizer-Einstellungen für:
  - Hero-Bereich (Überschrift, Text, Bild)
  - Kontaktinformationen (Telefon, E-Mail, Adresse)

### Design-Highlights
- Goldumrandete Service-Icons
- Hover-Effekte auf Service-Karten
- Sticky Header
- Parallax-Effekt im Hero-Bereich (leicht)
- Fade-in Animationen beim Scrollen
- Professionelle Typografie

### Browser-Kompatibilität
- Chrome (neueste Version)
- Firefox (neueste Version)
- Safari (neueste Version)
- Edge (neueste Version)
- Mobile Browser (iOS, Android)

### Technische Anforderungen
- WordPress 5.0+
- PHP 7.4+
- MySQL 5.6+

---

## Versionen-Format

- **[X.0.0]** - Major Release (große Änderungen, Breaking Changes)
- **[X.Y.0]** - Minor Release (neue Features, rückwärtskompatibel)
- **[X.Y.Z]** - Patch Release (Bugfixes, kleine Verbesserungen)

### Kategorien

- **Hinzugefügt** - Neue Features
- **Geändert** - Änderungen an bestehenden Features
- **Veraltet** - Features, die bald entfernt werden
- **Entfernt** - Entfernte Features
- **Behoben** - Bugfixes
- **Sicherheit** - Sicherheitsrelevante Änderungen
