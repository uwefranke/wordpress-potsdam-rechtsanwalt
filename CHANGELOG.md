# Changelog

Alle wichtigen Änderungen an diesem Theme werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unreleased]

### In Planung
- Erweiterte Customizer-Optionen
- Zusätzliche Farbschemata

## [1.0.15] - 2026-04-11

### Behoben
- **Menü-Kontrast verbessert** - Kein blau auf blau mehr! 🎨
  - Alle Menü-Links explizit weiß (.main-navigation a)
  - Dropdown-Links weiß mit expliziter Farbdefinition
  - Hover-Effekt Gold mit stärkerem Hintergrund (20% statt 10%)
  - text-decoration: none für alle Links

## [1.0.14] - 2026-04-11

### Geändert
- **Hero-Section für 1040x233px Bilder optimiert**
  - Höhe: 350px (Desktop), 280px (Tablet), 220px (Mobile)
  - Leichteres Overlay (60-75% statt 85%) für bessere Bildsichtbarkeit
  - background-position: center center
  - overflow: hidden hinzugefügt

## [1.0.13] - 2026-04-11

### Behoben
- **Mobile-Menü funktioniert jetzt!** 📱
  - Toggle-Button hinzugefügt (Hamburger-Menü)
  - Menü klappt auf Mobile korrekt auf/zu
  - ESC-Taste schließt Menü
  - Menü schließt automatisch nach Link-Klick
  - Toggle-Button nur auf Mobile sichtbar

### Geändert
- **Hero-Image jetzt dynamisch**
  - Kein hardcodierter Pfad mehr
  - Upload über Customizer: Design → Anpassen → Hero-Bereich
  - Fallback auf Navy-Farbe wenn kein Bild hochgeladen

### Hinzugefügt
- Mobile-Toggle-Button im Header
- JavaScript für Mobile-Menü (Toggle, ESC-Support, Auto-Close)
- CSS für Hamburger-Icon-Animation
- Responsive Mobile-Navigation

## [1.0.12] - 2026-04-11

### Behoben
- **KRITISCHER FIX: Version-Cache Problem gelöst** 🔥
  - functions.php liest Version jetzt automatisch aus style.css
  - Keine hardcodierten Versionen mehr in wp_enqueue_style/script
  - Verhindert "alte CSS wird geladen" Problem nach Updates

### Geändert
- Auto-Versioning in functions.php implementiert
- Über wp_get_theme()->get('Version') aus style.css

## [1.0.11] - 2026-04-11

### Behoben
- **Footer-Links korrigiert** - zeigen jetzt auf echte Rechtsgebiete:
  - /rechtsgebiete/miet-wohnungseigentumsrecht/
  - /rechtsgebiete/grundstuecks-immobilienrecht/
  - /rechtsgebiete/baurecht/
  - /rechtsgebiete/bu-erwerbsminderungsrente/
- Alte ungültige Links entfernt (verkehrsrecht, familienrecht, vertragsrecht)

## [1.0.10] - 2026-04-11

### Behoben
- **Menü-Hierarchie wird jetzt korrekt erstellt** 🔧
  - setup-pages.php löscht altes Menü komplett vor Neuaufbau
  - Verhindert flache Menü-Struktur bei mehrfachem Ausführen
  - Korrigierte Menu-Positionen (Rechtsgebiete=1, Informationen=2)

### Verbessert
- Besseres Debugging in setup-pages.php
  - Zeigt Parent IDs für jedes Menu-Item
  - Zeigt Item IDs für Child-Items
  - Detaillierte Hierarchie-Ausgabe beim Erstellen

## [1.0.9] - 2026-04-11

### Behoben
- **Dropdown-Menü funktioniert jetzt!** ⭐
  - CSS für hierarchische Menüs hinzugefügt
  - `.sub-menu` Styles für Untermenüs
  - Hover-States für Dropdowns
  - Dropdown-Indikator (▾) bei Menüs mit Kindern
  - Position: absolute für schwebende Untermenüs
  - Box-Shadow für bessere Sichtbarkeit

### Geändert
- Navigation CSS komplett überarbeitet:
  - `.main-navigation > ul` statt `.main-navigation ul` (spezifischer)
  - Separate Styles für Top-Level und Dropdown-Items
  - Responsive Dropdown-Styles für Mobile
  - Untermenüs auf Mobile: static statt absolute

### Hinzugefügt
- **menu-debug.php** - Diagnose-Tool für Menü-Probleme
  - Zeigt alle Menüs und Zuweisungen
  - Prüft hierarchische Struktur
  - Debug-Ausgabe aller Menü-Items

## [1.0.8] - 2026-04-11

### Hinzugefügt
- **NGINX-SETUP.md** - Anleitung für Nginx-Server
  - Erklärung warum .htaccess nicht funktioniert bei Nginx
  - 4 Lösungsansätze (Hosting-Support, Control Panel, Workaround, SSH)
  - Anfrage-Template für scriptbb.de Support
  - Nginx-Konfigurationsbeispiel
- **nginx.conf.example** - Vollständige Nginx-Konfiguration für WordPress

### Dokumentation
- Hinweis dass .htaccess nur bei Apache funktioniert
- Nginx benötigt andere Konfiguration (server-seitig)

## [1.0.7] - 2026-04-11

### Hinzugefügt
- **Automatische .htaccess-Erstellung** in setup-pages.php
  - Erstellt WordPress Rewrite-Rules automatisch
  - Prüft ob .htaccess bereits existiert und gültig ist
  - Zeigt Fehler mit manueller Lösung bei fehlenden Schreibrechten
  - Behebt 404-Fehler bei Pretty Permalinks
- **.htaccess.example** - Vorlage für manuelle Installation
- **TROUBLESHOOTING.md** - Umfassende Fehlerbehebungs-Anleitung
  - 404-Fehler bei Links
  - mod_rewrite-Prüfung
  - Nginx-Konfiguration
  - Schritt-für-Schritt-Lösungen

### Geändert
- **MIGRATION.md** erweitert mit .htaccess-Sektion
  - Automatische vs. manuelle Erstellung
  - Unterverzeichnis-Konfiguration
  - mod_rewrite-Hinweise

### Behoben
- **Links funktionieren jetzt** - .htaccess behebt 404-Fehler
- Service-Card-Links auf Startseite navigieren korrekt

## [1.0.6] - 2026-04-11

### Behoben
- **Menü-Hierarchie funktioniert jetzt korrekt**
  - `menu-item-parent-id` korrigiert zu `menu-item-parent`
  - Unterseiten erscheinen jetzt als Dropdown unter Rechtsgebiete und Informationen
  - Flaches Menü-Problem behoben

### Hinzugefügt
- **Automatische Permalink-Aktivierung** in setup-pages.php
  - Pretty Permalinks werden automatisch auf "Beitragsname" gesetzt
  - URLs sind jetzt `/seitenname/` statt `?page_id=123`
  - flush_rewrite_rules() nach Aktivierung
  - Card-Links funktionieren jetzt korrekt

## [1.0.5] - 2026-04-11

### Behoben
- **Tippfehler in setup-pages.php** behoben:
  - Leerzeichen vor 'title' entfernt (Zeile 245)
  - 'menu-it em-status' korrigiert zu 'menu-item-status' (Zeile 332)
- **Menü-Titel fehlen nicht mehr** - Zeigen jetzt korrekt:
  - "Miet- / Wohnungseigentumsrecht" (statt "#14 (kein Titel)")
  - "Grundstücks- / Immobilienrecht" (statt "#15 (kein Titel)")
  - "Baurecht" (statt "#16 (kein Titel)")
  - "BU / Erwerbsminderungsrente" (statt "#17 (kein Titel)")
  - "Kontakt" und "Über mich" im Informationen-Menü
- Arrays mit Slug => Titel Mapping für korrekte Menüanzeige

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
