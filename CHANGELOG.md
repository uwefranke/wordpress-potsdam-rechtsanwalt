# Changelog

Alle wichtigen Änderungen an diesem Theme werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unreleased]

### In Planung
- Zusätzliche Farbschemata

## [1.0.30] - 2026-04-12

### Hinzugefügt
- **Strukturierte Namen-Felder im Customizer** 📋
  - `contact_title` - Titel/Berufsbezeichnung (z.B. "Rechtsanwalt")
  - `contact_firstname` - Vorname (z.B. "Matthias")
  - `contact_lastname` - Nachname (z.B. "Lange")
  - Bessere Sortierung in Smartphone-Adressbüchern

### Geändert
- **vCard 3.0 jetzt RFC-konform strukturiert** ✅
  - `N:` Feld (strukturiert): `Lange;Matthias;;;`
  - `FN:` Feld (Anzeigename): `Rechtsanwalt Matthias Lange`
  - `TITLE:` Feld (Berufsbezeichnung): `Rechtsanwalt`
  - vCard-Download-Dateiname dynamisch: `kontakt-matthias-lange.vcf`
  - Kontaktdaten-Widget zeigt zusammengesetzten Namen

### Entfernt
- Customizer-Feld `contact_name` (ersetzt durch 3 strukturierte Felder)

### Migration
- Bestehende Installationen: Customizer-Felder neu ausfüllen
- Titel, Vorname, Nachname werden jetzt getrennt gespeichert

## [1.0.29] - 2026-04-12

### Behoben
- **Font-Pfade korrigiert** 🔠
  - 404-Fehler bei allen Font-Dateien behoben
  - Pfade von `url('fonts/...')` auf `url('../fonts/...')` korrigiert
  - Betroffen: Open Sans (300/400/600) + Playfair Display (400/600/700)
  - **Ursache:** fonts.css liegt in `assets/css/`, Fonts in `assets/fonts/`
  - **Problem:** Fehlende Fonts könnten auch Kaya QR-Plugin JavaScript beeinträchtigt haben

### Technisch
- Alle 6 @font-face Regeln in fonts.css aktualisiert
- Relative Pfade jetzt korrekt: `../fonts/dateiname.woff2`

## [1.0.28] - 2026-04-12

### Hinzugefügt
- **vCard-Download-Button** 📥
  - Alternativer Download-Link (.vcf) falls QR-Code nicht funktioniert
  - Direkt ins Adressbuch importierbar (iOS/Android/Desktop)
  - Data-URI-basiert, keine Server-Datei nötig
  - Button-Design: Navy (#1a3a5c) passend zum Theme

### Entfernt
- Google Chart API Fallback (Service wurde abgeschaltet, 404-Fehler)
- Google Chart API Test-Link aus Debug-Modus

### Geändert
- Debug-Modus: Hinweis auf abgeschaltete Google API
- Debug-Modus: Empfehlung Browser-Konsole zu prüfen
- QR-Code Fallback zeigt jetzt Plugin-Installations-Hinweis statt defekter Google API

## [1.0.27] - 2026-04-12

### Behoben
- **Kaya QR Code Generator vCard-Übergabe** 🔧
  - Zeilenumbrüche (\r\n) werden jetzt als HTML-Entities (&amp;#13;&amp;#10;) escapiert
  - vCard-Daten bleiben beim Übergeben an Kaya Plugin erhalten
  - **Problem:** HTML-Attribute können keine echten Zeilenumbrüche enthalten
  - **Lösung:** Entity-Encoding für Shortcode-Attribut `content="..."`

### Geändert
- Debug-Modus zeigt jetzt vollständigen QR-Code-Output (nicht nur 300 Zeichen)
- Bessere Diagnose bei leerem QR-Code

## [1.0.26] - 2026-04-12

### Geändert
- **Debug-Modus erweitert** 🔍
  - Zeigt verwendete QR-Code-Generierungsmethode (Plugin oder Fallback)
  - Zeigt QR-Code Output (erste 300 Zeichen)
  - Direkter Google Chart API Test-Link zum Vergleich
  - Bessere visuelle Darstellung (gelber Hinweis-Kasten)
  - Hilft bei Diagnose wenn QR-Code leer ist

## [1.0.25] - 2026-04-12

### Behoben
- **Adress-Parsing Stadt/Bundesland-Trennung** 📍
  - Letztes Wort vor PLZ wird als Bundesland erkannt
  - Korrekte Trennung: "Potsdam Brandenburg" → Stadt: "Potsdam", State: "Brandenburg"
  - **Vorher:** `ADR:;;Straße;Potsdam Brandenburg;;14482;Germany` (falsch)
  - **Jetzt:** `ADR:;;Straße;Potsdam;Brandenburg;14482;Germany` (richtig)
  - Unterstützt mehrere Formate:
    * "Straße, Stadt Bundesland PLZ" (Standard)
    * "Straße, PLZ Stadt" (Alternative)
    * "Straße, Stadt PLZ" (ohne Bundesland)

### Geändert
- Adress-Parsing nutzt `array_pop()` für intelligente Wort-Trennung
- Regex optimiert für häufigste Adress-Formate

## [1.0.24] - 2026-04-12

### Behoben
- **Telefonnummern-Normalisierung für vCard** 📞
  - Automatische Konvertierung: `0331 / 74 09 860` → `+493317409860`
  - Deutsche 0-Vorwahl wird zu +49 (international)
  - Leerzeichen, Schrägstriche, Bindestriche werden entfernt
  - E.164-Format für maximale Kompatibilität
  - **Problem:** Smartphones erkannten deutsche Nummern nicht
  - **Lösung:** Internationale Formatierung (RFC 3966)
  
- **Adress-Parsing verbessert** 🏠
  - Intelligentes Parsing: "Straße, PLZ Stadt Bundesland"
  - Korrekte ADR-Felder: Street;City;State;ZIP;Country
  - Regex-basierte Extraktion von PLZ, Stadt, Bundesland
  - "Germany" als Standard-Land hinzugefügt
  - **Beispiel:** "Schornsteinfegergasse 5, Potsdam Brandenburg 14482" wird korrekt getrennt

### Geändert
- vCard nutzt jetzt strukturierte Adress-Komponenten statt einem String
- Telefon/Fax-Felder werden vor vCard-Generierung sanitisiert

## [1.0.23] - 2026-04-12

### Behoben
- **QR-Code Encoding-Problem gelöst** 🔧
  - `esc_attr()` und `esc_html()` entfernt - beschädigten vCard-Zeilenumbrüche!
  - Kaya Plugin: Nur manuelle Quote-Escapierung statt esc_attr()
  - QR Code Generator Plugin: Kein esc_html() mehr
  - Shortcodes escapen automatisch - doppeltes Escaping verhinderte Funktion
  - **Problem:** esc_attr() wandelt `\r\n` in HTML-Entities um
  - **Lösung:** Minimales Escaping nur für Anführungszeichen

### Hinzugefügt
- **Debug-Modus** für vCard-Daten
  - URL-Parameter: `?debug_vcard` (nur für Admins)
  - Zeigt rohe vCard-Daten unter QR-Code an
  - Hilft bei Troubleshooting

## [1.0.22] - 2026-04-12

### Behoben
- **QR-Code jetzt scanbar** 🐞
  - vCard-Format korrigiert: `\r\n` (CRLF) statt `\n` (LF)
  - Adress-Parsing repariert: `"\n"` statt `'\n'` (war nicht funktional)
  - ADR-Feld vervollständigt: `;;street;city;state;zip;country;;;;`
  - Doppelte Kommas in Adressen werden entfernt
  - vCard 3.0 Standard-konform
  - **Problem:** QR-Code war leer beim Scannen
  - **Lösung:** Korrekte vCard-Kodierung mit CRLF-Zeilenumbrüchen

## [1.0.21] - 2026-04-12

### Hinzugefügt
- **Kaya QR Code Generator Plugin-Unterstützung** ⭐
  - Primäre Empfehlung: "Kaya QR Code Generator"
  - Shortcode-Integration: `[kaya_qrcode content="..."]`
  - Automatische Erkennung via `shortcode_exists('kaya_qrcode')`
  - Keine Dependencies, leichtgewichtig
  - Widgets + Shortcode-Generator verfügbar

### Geändert
- Plugin-Priorität: Kaya → QR Code Generator → WP QR Code Generator → Fallback
- Admin-Notice zeigt jetzt beide Plugin-Optionen (Kaya + QR Code Generator)
- qrcode-generator.php erweitert um Kaya-Support

## [1.0.20] - 2026-04-12

### Geändert
- **QR-Code jetzt Plugin-kompatibel** 🔌
  - Unterstützt WordPress-Plugin "QR Code Generator" (lokal, DSGVO-konform)
  - Unterstützt "WP QR Code Generator" Plugin
  - Automatische Erkennung installierter Plugins
  - Fallback auf Google Chart API nur wenn kein Plugin installiert
  - Admin-Hinweis wenn externes API genutzt wird
  
### Hinzugefügt
- qrcode-generator.php mit Plugin-Detection-Logik
- Admin-Notice mit Plugin-Empfehlung für DSGVO-Konformität
- Flexibles Rendering (HTML-Shortcode oder URL/Data-URI)

### EMPFEHLUNG
**Installiere:** "QR Code Generator" Plugin für 100% lokale QR-Code-Generierung  
Plugin-Link: https://wordpress.org/plugins/qr-code-generator-for-wordpress/

## [1.0.19] - 2026-04-12

### Hinzugefügt
- **Erweiterte Kontaktdaten** 📇
  - Name/Kanzleiname im Customizer (Default: "Rechtsanwalt Matthias Lange")
  - Fax-Nummer optional (nur angezeigt wenn ausgefüllt)
  - Telefonnummer jetzt klickbar (tel: Link)
  
- **QR-Code mit vCard-Kontaktdaten** 📱
  - Automatisch generierter QR-Code mit allen Kontaktdaten
  - vCard 3.0 Format (kompatibel mit allen Smartphones)
  - Deaktivierbar über Customizer-Checkbox
  - Nutzt api.qrserver.com (DSGVO-konform, keine Speicherung)
  - 150px Größe, responsive, lazy loading
  - Text "Kontakt speichern" über QR-Code

### Geändert
- Kontaktdaten-Widget neu strukturiert mit Name prominent dargestellt
- E-Mail und Telefon-Links für bessere Mobile-UX

## [1.0.18] - 2026-04-12

### Hinzugefügt
- **Öffnungszeiten im Customizer editierbar** ⏰
  - Neue Section "Öffnungszeiten" im Customizer
  - Textfelder für Mo-Do, Freitag und Sa & So
  - Default: "Nach Vereinbarung" für alle Tage
  - Einfache Anpassung ohne Code-Änderung

## [1.0.17] - 2026-04-12

### Geändert
- **Termin-Buttons vollständig steuerbar** 🎛️
  - Header-CTA "TERMIN VEREINBAREN" nutzt jetzt show_appointment_button
  - Hero-Button "TERMIN VEREINBAREN" nutzt jetzt show_appointment_button
  - "UNSERE LEISTUNGEN" Button bleibt immer sichtbar (reine Navigation)
  - Konsistente Steuerung aller Termin-CTAs über eine Customizer-Option

## [1.0.16] - 2026-04-12

### Hinzugefügt
- **Rank Math Breadcrumbs-Integration** 🍞
  - Automatische Breadcrumbs auf allen Seiten, Beiträgen und Archiven
  - Nutzt rank_math_the_breadcrumbs() wenn Rank Math Plugin aktiv
  - Graues Styling (14px, color: #888) für dezente Darstellung
  
- **Customizer Layout-Optionen** ⚙️
  - Neue Section "Layout-Optionen" im Customizer
  - Kontaktformular deaktivierbar (show_contact_form)
  - Termin-Button deaktivierbar (show_appointment_button)
  - Beide Optionen standardmäßig aktiviert

### Geändert
- sidebar.php nutzt jetzt get_theme_mod() für bedingte Anzeige
- Bessere Code-Organisation mit conditional wrappers

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
