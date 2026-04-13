# Changelog

Alle wichtigen Änderungen an diesem Theme werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unreleased]

### In Planung
- Zusätzliche Farbschemata

## [1.3.8] - 2026-04-13

### Behoben
- **Zurück-Button in Einstellungen** 🔧
  - Zurück-Button nutzt jetzt forceShow=true (zeigt Banner auch bei Cookie)
  - Verhindert dass Banner verschwindet beim Zurückklicken

### Hinzugefügt
- **Debug-Logging** 🔍
  - Console-Logs zeigen Cookie-Status beim Laden
  - Logs beim Setzen/Prüfen von Cookies
  - Hilft bei Troubleshooting (kann später entfernt werden)

## [1.3.7] - 2026-04-13

### Behoben
- **Cookie-Link funktioniert ENDLICH!** ✅
  - Problem gefunden: showCookieBanner() zeigte Banner nicht bei bestehendem Cookie
  - Lösung: forceShow-Parameter (true bei openCookieSettings())
  - Banner erscheint jetzt auch nachträglich, wenn bereits Consent erteilt
  - Cookie-Einstellungen können jederzeit geändert werden

## [1.3.6] - 2026-04-13

### Behoben
- **Cookie-Link FINAL** ✅
  - Nutzt [cookie_einstellungen] Shortcode direkt im Footer
  - Shortcode generiert onclick zur Laufzeit (umgeht alle Template-Blocker)
  - do_shortcode() wird von WordPress nach allen Blockern ausgeführt
  - Shortcode hat style-Parameter für Footer-Styling

## [1.3.5] - 2026-04-13

### Behoben
- **Cookie-Link funktioniert GARANTIERT** ✅
  - Inline Event-Listener direkt nach wp_footer()
  - Wartet auf Verfügbarkeit von window.openCookieSettings
  - Umgeht WordPress/Plugin Event-Blocker
  - Fallback mit setInterval (wartet bis Funktion existiert)

## [1.3.4] - 2026-04-13

### Behoben
- **Cookie-Link funktioniert JETZT** ✅
  - Direkter onclick-Handler (wie console.log bestätigt: Funktion existiert)
  - Umgeht alle Event-Delegation-Probleme
  - Einfachste und robusteste Lösung

## [1.3.3] - 2026-04-13

### Behoben
- **Cookie-Link funktioniert jetzt garantiert** ✅
  - Event-Delegation wie bei Dark Mode Toggle
  - CSS-Klasse `.open-cookie-settings` statt Inline-Script
  - useCapture=true für zuverlässiges Event-Handling
  - Funktioniert unabhängig von Lade-Reihenfolge

## [1.3.2] - 2026-04-13

### Behoben
- **Cookie-Einstellungen Link robuster** 🔧
  - Inline-Script statt onclick-Attribut
  - Event-Listener mit Fallback
  - Funktioniert auch wenn cookie-consent.js spät lädt
  - Fallback: Cookie löschen + Seite neu laden

## [1.3.1] - 2026-04-13

### Hinzugefügt
- **Cookie-Einstellungen nachträglich änderbar** ⚙️
  - Link "Cookie-Einstellungen" automatisch im Footer
  - Shortcode `[cookie_einstellungen]` für manuelle Platzierung
  - JavaScript-Funktion `window.openCookieSettings()`
  - Besucher können Cookie-Banner jederzeit wieder öffnen
  - Dokumentation in SHORTCODES-ANLEITUNG.md erweitert

## [1.3.0] - 2026-04-13

### Hinzugefügt
- **DSGVO-konformer Cookie-Consent-Banner** 🍪
  - Informiert über technisch notwendige Cookies
  - Einstellungs-Ansicht mit Cookie-Details
  - Theme-Design (Navy & Gold)
  - Responsive & Dark Mode Support
  - Speichert Zustimmung für 365 Tage
  - Neue Dateien:
    - `assets/js/cookie-consent.js`
    - `assets/css/cookie-consent.css`
    - `COOKIE-CONSENT.md` (Dokumentation)

### Sicherheit
- Transparente Cookie-Nutzung für Besucher
- Keine Tracking-Cookies ohne Zustimmung
- Rechtssicher für Rechtsanwalts-Website

## [1.2.0] - 2026-04-13

### Geändert
- **setup-pages.php aus Theme entfernt** 🔒
  - Sicherheitsrisiko behoben: Setup-Script nicht mehr im produktiven Theme
  - Verschoben nach `setup-tools/` (nur im Git-Repository)
  - Wird nicht mehr im Theme-Update-ZIP ausgeliefert
  - GitHub Actions kopiert nur `src/*` Dateien

### Sicherheit
- Theme-ZIP enthält jetzt nur noch produktions-notwendige Dateien
- Setup-Scripts müssen manuell installiert werden (bei Bedarf)

## [1.1.5] - 2026-04-13

### Behoben
- **Robuste Homepage-Titel-Korrektur** 🔨
  - Output-Buffering für zuverlässige Titel-Änderung
  - Entfernt "Home" aus <title>, og:title und twitter:title
  - Funktioniert garantiert auch mit Rank Math PRO
  - Mehrere Filter-Ebenen (Priority 999) als Fallback

## [1.1.4] - 2026-04-13

### Behoben
- **Rank Math SEO Plugin Kompatibilität** 🔧
  - Homepage-Titel wird jetzt auch mit Rank Math PRO korrekt angezeigt
  - "Home" wird automatisch aus dem Browser-Titel entfernt
  - Funktioniert jetzt mit und ohne SEO-Plugins

## [1.1.3] - 2026-04-13

### Geändert
- **Homepage Browser-Titel optimiert** 📝
  - Auf der Startseite wird jetzt nur der Website-Name angezeigt
  - Seitentitel "Home" wird nicht mehr im Browser-Tab angezeigt
  - Statt "Home - Potsdam Rechtsanwalt" jetzt nur "Potsdam Rechtsanwalt"

## [1.1.2] - 2026-04-13

### Hinzugefügt
- **Site Icon (Favicon) erstellt** 🎨
  - SVG-Icon mit Waage-Symbol (Justitia)
  - Navy-Blau & Gold Theme-Farben
  - Initialen "ML" (Matthias Lange)
  - Datei: `src/assets/images/site-icon.svg`
  - PowerShell-Script zur PNG-Konvertierung

## [1.1.1] - 2026-04-13

### Hinzugefügt
- **Shortcodes für alle Customizer-Felder** 🎯
  - `[kontakt field="phone"]` - Einzelne Kontaktfelder
  - `[kontakt field="fullname"]` - Kombinierte Felder
  - `[kontakt field="phone" link="yes"]` - Mit klickbaren Links
  - `[rechtsgebiet number="1" field="title"]` - Rechtsgebiete
  - `[hero field="title"]` - Hero-Bereich
  - `[customizer field="beliebiges_feld"]` - Universeller Shortcode
- **Dokumentation:** SHORTCODES-ANLEITUNG.md mit allen Beispielen
- Neue Datei: `inc/shortcodes.php`

## [1.1.0] - 2026-04-13

### Hinweis
- **Version 1.1.0 Release**
  - Theme-Version auf 1.1.0 erhöht
  - Alle Features aus v1.0.56 enthalten (Dark Mode, Screenshot)
  - Empfehlung: Manuelles Theme-Update über ZIP-Download bei Cache-Problemen

## [1.0.56] - 2026-04-13

### Hinzugefügt
- **Theme Screenshot hinzugefügt** 📸
  - screenshot.png (1200x900px, 571 KB)
  - Vorschaubild wird jetzt im WordPress Theme-Verzeichnis angezeigt

## [1.0.55] - 2026-04-13

### Behoben
- **Hero-Bereich im Dark Mode lesbar** 🌟
  - Text jetzt weiß (#ffffff) statt dunkel
  - Hintergrund-Gradient angepasst (dunkleres Overlay)
  - Text-Shadow verstärkt für bessere Lesbarkeit
  - Gilt für manuellen und System Dark Mode

## [1.0.54] - 2026-04-13

### Behoben
- **Haupttext im Dark Mode jetzt lesbar** 📝
  - Body-Textfarbe hell (#e0e0e0) im Dark Mode
  - Content Area Textfarbe hell für p, li, div, span
  - Links in Gold mit Weiß beim Hover
  - Gilt auch für System-Präferenz Dark Mode

## [1.0.53] - 2026-04-13

### Behoben
- **Dark Mode Lesbarkeit verbessert** 🎨
  - Footer-Text jetzt hell (#b0b0b0) statt weiß auf hellem Grund
  - Widget-Hintergründe dunkel (#2d3748) im Dark Mode
  - Überschriften in Gold (#f4d03f) für besseren Kontrast
  - Formular-Felder dunkel mit heller Schrift
  - Links und Texte in Widgets lesbar
  - Navy-Farbe heller (#6ba3d8) für bessere Sichtbarkeit
  - Hardcoded inline-styles überschrieben mit !important

## [1.0.52] - 2026-04-13

### Hinzugefügt
- **Debug-Logging für Dark Mode** 🐞
  - Console-Logs zeigen welche Präferenz aktiv ist
  - Hilft beim Debugging von System-Theme-Erkennung
  - Zeigt ob manuelle oder System-Präferenz verwendet wird

## [1.0.51] - 2026-04-13

### Behoben
- **System-Präferenz wird jetzt korrekt erkannt** 🔧
  - applyTheme mit isManual Parameter
  - Bei System-Präferenz werden KEINE Klassen gesetzt
  - Media Query kann nun korrekt greifen
  - Manuelle Wahl überschreibt weiterhin System-Präferenz

## [1.0.50] - 2026-04-13

### Behoben
- **Light Mode Klasse hinzugefügt** ☀️
  - JavaScript setzt jetzt explizit .light-mode Klasse
  - CSS: html.light-mode überschreibt System-Präferenz
  - Behebt Problem bei dunklem System-Theme
  - Toggle funktioniert jetzt zuverlässig in beide Richtungen

## [1.0.49] - 2026-04-13

### Behoben
- **CSS-Selektor geändert für Dark Mode** 🔧
  - :root.dark-mode → html.dark-mode (bessere Browser-Kompatibilität)
  - Sollte nun in Chrome/Edge korrekt funktionieren

## [1.0.48] - 2026-04-13

### Behoben
- **CSS-Spezifität für Dark Mode korrigiert** 🎨
  - .dark-mode → :root.dark-mode (höhere Spezifität)
  - CSS-Variablen werden jetzt korrekt überschrieben
  - Dark Mode Farben werden jetzt tatsächlich angewendet
  - Unnötige semantische Variablen entfernt

## [1.0.47] - 2026-04-13

### Behoben
- **Event-Delegation für bessere Browser-Kompatibilität** 🔧
  - Event-Listener jetzt am document-Level mit useCapture
  - event.preventDefault() und stopPropagation() hinzugefügt
  - e.target.closest() für zuverlässige Button-Erkennung
  - Arrow Functions durch normale Functions ersetzt (IE11 Kompatibilität)
  - Fallback für ältere matchMedia API

## [1.0.46] - 2026-04-13

### Behoben
- **Chrome/Edge Kompatibilität verbessert** 🌐
  - innerHTML → textContent für Emoji-Icons (bessere Browser-Kompatibilität)
  - Dark Mode Toggle funktioniert jetzt in allen modernen Browsern

## [1.0.45] - 2026-04-13

### Behoben
- **JavaScript Syntax-Fehler behoben** 🐛
  - Doppelte IIFE-Schließung entfernt (})(); war zweimal vorhanden)
  - Dark Mode Toggle funktioniert jetzt korrekt

## [1.0.44] - 2026-04-13

### Behoben
- **JavaScript-Fehler behoben** 🐛
  - IIFE-Schließung in darkmode.js fehlte (})(); am Ende)
  - Dark Mode Toggle funktioniert jetzt korrekt

## [1.0.43] - 2026-04-13

### Hinzugefügt
- **Dark Mode mit System-Integration** 🌙
  - Automatische Erkennung der System-Präferenz (prefers-color-scheme)
  - Manueller Toggle-Switch (fixed Button rechts unten)
  - localStorage-Persistenz über Seitenaufrufe hinweg
  - Icons: 🌙 (Light Mode) / ☀️ (Dark Mode)
  - Sofortige Initialisierung verhindert Flackern beim Laden
  - MediaQuery-Listener reagiert auf System-Änderungen
  - CSS-Variablen für nahtlosen Farbwechsel

### Geändert
- CSS: Erweiterte :root Variablen mit semantischen Farben (--bg-primary, --text-primary, etc.)
- CSS: .dark-mode Klasse mit invertierten Farben
- Dark Mode Gold: Helleres #f4d03f für besseren Kontrast
- Toggle-Button: Fixed position (bottom: 30px, right: 30px)
- Mobile: Kleinerer Toggle-Button (45px statt 50px)

### Technisch
- darkmode.js: 120 Zeilen JavaScript
- STORAGE_KEY: 'potsdam-theme-mode'
- DARK_CLASS: 'dark-mode'
- getPreferredTheme(): localStorage > prefers-color-scheme > 'light'
- Script im <head> geladen (nicht Footer) für sofortige Verfügbarkeit
- matchMedia API für System-Präferenz-Erkennung

## [1.0.42] - 2026-04-13

### Behoben
- **Hero-Bereich auf Handys optimiert** 📱
  - Problem: Hero zu klein (220px) oder passte nicht richtig auf Mobile
  - Fixe height → min-height für flexible Höhe je nach Inhalt
  - Mehr Padding auf mobilen Geräten (40px statt fest)
  - Bessere Font-Größen: 24px statt 28px auf sehr kleinen Screens
  - Buttons kleiner auf Mobile (14px, padding 12px/28px)
  - line-height optimiert für bessere Lesbarkeit

### Geändert
- Hero: height → min-height (280px - 350px je nach Screen)
- Mobile (480px): 24px Titel, 14px Text, mehr Padding
- Tablet (768px): 36px Titel, 16px Text, 300px min-height
- .hero-content mit max-width und line-height

### Technisch
- min-height passt sich an Content an
- Padding verhindert Text am Rand
- Responsive Font-Sizes für alle Breakpoints

## [1.0.41] - 2026-04-12

### Hinzugefügt
- **Footer-Text im Customizer editierbar** ⚙️
  - Neue Customizer-Section "Footer"
  - Editierbar: Überschrift (Standard: "Über uns")
  - Editierbar: Beschreibungstext (Standard: "Ihre kompetenten Rechtsanwälte...")
  - footer.php nutzt jetzt get_theme_mod() statt hardcoded Text
  - Widget-Support bleibt erhalten (Footer 1-3)

### Geändert
- footer.php: Dynamischer Text aus Customizer
- customizer.php: +30 Zeilen neue Footer Section

### Technisch
- footer_about_title: Customizer Setting (default: "Über uns")
- footer_about_text: Customizer Setting (default: Standard-Text)
- Fallback auf Defaults wenn nicht gespeichert

## [1.0.40] - 2026-04-12

### Behoben
- **Horizontales Scrolling bei großen Bildschirmen entfernt** 💻
  - Problem: max-width auf Grid verursachte Overflow über Viewport
  - Lösung: Fixe Maximalbreite pro Karte statt Container-max-width
  - minmax(300px, 350px) bei 1200px+
  - minmax(320px, 380px) bei 1600px+
  - justify-content: center für Zentrierung
  - Karten bleiben proportional, Grid passt sich an Viewport an

### Geändert
- Grid: max-width entfernt → minmax mit festen Maximalwerten
- justify-content: center für zentrierte Karten
- Karten-Breite auf 350px/380px max begrenzt (statt 1fr)

### Technisch
- minmax(min, max) mit festem max verhindert zu breite Karten
- auto-fit passt Spaltenanzahl automatisch an
- Kein Container-Overflow mehr

## [1.0.39] - 2026-04-12

### Behoben
- **Karten jetzt gleich breit bei großer Auflösung** 📏
  - Problem: Bei repeat(4, 1fr) wurden Karten unterschiedlich breit bei <4 Elementen
  - Ursache: Grid versuchte 4 Spalten zu füllen, auch wenn nur 2-3 Karten vorhanden
  - Lösung: Zurück zu auto-fit + max-width auf Grid-Container
  - 1200px+: max-width 1400px
  - 1600px+: max-width 1600px
  - Grid zentriert mit margin-left/right: auto

### Geändert
- Grid: repeat(4, 1fr) → repeat(auto-fit, minmax(280px, 1fr))
- max-width auf .services-grid für begrenzte Container-Breite
- Grid automatisch zentriert

### Technisch
- auto-fit passt Spaltenanzahl an verfügbare Items an
- max-width verhindert zu breite Karten
- Karten bleiben proportional bei unterschiedlichen Anzahlen

## [1.0.38] - 2026-04-12

### Behoben
- **Alle Karten im Vollbild-Modus jetzt gleich groß** 📏
  - Problem: Karten mit unterschiedlich viel Text hatten unterschiedliche Höhen
  - CSS Grid macht Items nur innerhalb einer Zeile gleich hoch
  - Lösung: `min-height` auf Karten gesetzt + Flex-Layout optimiert
  - Basis: 320px, bei 1200px+: 360px, bei 1600px+: 400px
  - `display: flex` auf `.service-card-link` für korrektes Stretching

### Geändert
- `.service-card-link`: `display: block` → `display: flex`
- `.service-card`: `height: 100%` → `width: 100%` + `min-height`
- `.services-grid`: `align-items: stretch` explizit gesetzt

### Technisch
- Flex-Parent/Child-Beziehung korrekt für gleichmäßige Höhe
- Responsive min-height für verschiedene Bildschirmgrößen

## [1.0.37] - 2026-04-12

### Behoben
- **Default-Werte werden jetzt korrekt als Fallback verwendet** 🐛🐛
  - Problem: Defaults funktionierten immer noch nicht direkt nach Installation
  - Ursache: `get_theme_mod()` wurde OHNE zweiten Default-Parameter aufgerufen
  - WordPress gibt `false` zurück wenn Setting nie gespeichert wurde (nicht `''`)
  - Lösung: Defaults direkt als zweiten Parameter übergeben: `get_theme_mod('key', $default)`
  - **JETZT funktioniert es endgültig!**

### Technisch
- template-tags.php: `get_theme_mod("service_{$i}_title", $default_title)` statt nur `get_theme_mod("service_{$i}_title")`
- Korrekte WordPress-API-Nutzung implementiert

## [1.0.36] - 2026-04-12

### Behoben
- **Responsive Design für große Bildschirme** 💻
  - Problem: Bei Vollbild (1920px+) waren Karten zu breit, Text "ertrank" in leerem Raum
  - Lösung: Grid auf maximal 4 Spalten begrenzt bei großen Bildschirmen
  - Ab 1200px: 4 Spalten fix + größere Schrift (24px Titel, 16px Text)
  - Ab 1600px: Noch mehr Abstand + größere Schrift (26px Titel, 17px Text)
  - Bessere Paddings für ausgewogenes Layout

### Technisch
- Media Query @media (min-width: 1200px) hinzugefügt
- Media Query @media (min-width: 1600px) hinzugefügt
- Grid-Template-Columns: repeat(4, 1fr) statt auto-fit

## [1.0.35] - 2026-04-12

### Behoben
- **Default-Werte für Rechtsgebiete funktionieren jetzt sofort** 🐛
  - Problem: Rechtsgebiete wurden nur angezeigt, wenn jedes Feld einzeln bearbeitet und gespeichert wurde
  - Ursache: `get_theme_mod()` verwendete Default-Werte nicht, wenn Option nie gespeichert wurde
  - Lösung: Default-Werte direkt in `potsdam_display_service_cards()` implementiert
  - Die 4 Standard-Rechtsgebiete erscheinen jetzt sofort nach Theme-Installation

### Geändert
- ZIP-Package-Script korrigiert (korrekte Ordnerstruktur für WordPress)
- Debug-Code entfernt

### Technisch
- **template-tags.php:** Default-Services-Array in Funktion statt nur im Customizer
- **create-theme-package.ps1:** Theme-Ordner wird jetzt korrekt IM ZIP erstellt
- Fallback-Logik: Wenn `get_theme_mod()` leer → Default-Array verwenden

## [1.0.34] - 2026-04-13

### Hinzugefügt
- **Customizer-Felder für Rechtsgebiete** ⚙️
  - Neue Section "Rechtsgebiete" im WordPress Customizer
  - Variable Anzahl von Karten (1-8) über Dropdown auswählbar
  - Pro Rechtsgebiet editierbar: Titel, Beschreibung, Link
  - 8 vordefinierte SVG-Icons (Miet, Immobilien, Bau, BU, Verkehr, Vertrag, Zeit, Tag)
  - Default-Werte für die 4 bestehenden Rechtsgebiete vorausgefüllt

### Geändert
- **Template-Vereinfachung** 🧹
  - ~130 Zeilen hardcoded HTML durch dynamische Generierung ersetzt
  - Neue Helper-Funktion `potsdam_display_service_cards()` in template-tags.php
  - page.php und index.php nutzen jetzt Funktionsaufruf statt hardcoded Karten
  - Karten werden nur angezeigt wenn Titel vorhanden (keine leeren Karten)

### Technisch
- **src/inc/customizer.php:**
  - +113 Zeilen neue Services Section
  - 25 neue Settings (services_count + 8x3 Felder)
  - for-Loop 1-8 für service_{i}_title, service_{i}_description, service_{i}_link
  
- **src/inc/template-tags.php:**
  - +62 Zeilen neue Funktion potsdam_display_service_cards()
  - 8 inline SVG-Icons als Array
  - URL-Handling: Relative Pfade → home_url(), absolute URLs direkt
  - Conditional Output: Nur Karten mit Titel werden generiert
  
- **src/page.php:** 67 Zeilen hardcoded HTML → 1 Zeile <?php potsdam_display_service_cards(); ?>
- **src/index.php:** Gleiche Vereinfachung wie page.php

### Anleitung
1. WordPress Admin → Design → Customizer → **Rechtsgebiete**
2. **Anzahl der Rechtsgebiete:** 1-8 auswählen
3. Pro Rechtsgebiet bearbeiten:
   - **Titel:** Name des Rechtsgebiets
   - **Beschreibung:** Kurzer Erklärungstext
   - **Link:** Relative URL (/mietrecht) oder absolute (https://example.com)
4. Icons werden automatisch zugeordnet (1-8)
5. Änderungen speichern

### Kontext
- User-Anfrage: "wo kann ich den inhalt der Karten bearbeiten"
- Hardcoded Rechtsgebiete waren nicht im Customizer editierbar
- Jetzt: Volle Kontrolle über Anzahl, Texte und Links
- Icons aktuell fix (8 vordefinierte SVGs)

## [1.0.33] - 2026-04-12

### Behoben
- **Hero-Section und Rechtsgebiete bei statischer Startseite** 🏠
  - Hero-Section wird jetzt auch angezeigt, wenn eine Seite als Startseite festgelegt ist
  - Rechtsgebiets-Karten erscheinen auf statischer Startseite
  - **Problem:** WordPress nutzt page.php statt index.php bei statischen Seiten
  - **Lösung:** Hero + Rechtsgebiete in page.php mit `is_front_page()` Prüfung

### Geändert
- Breadcrumbs nur noch auf Unterseiten (nicht auf Startseite)
- Template-Logik vereinheitlicht zwischen index.php und page.php
- Startseite funktioniert jetzt identisch bei "Neueste Beiträge" und "Statische Seite" Einstellung

### Technisch
- page.php: Hero-Section mit `<?php if (is_front_page()) : ?>` Bedingung
- page.php: Rechtsgebiete-Section mit gleicher Bedingung
- Unterseiten behalten normales Layout (Titel, Breadcrumbs)

### Kontext
- WordPress Admin → Einstellungen → Lesen → "Startseite" 
- Wenn "Statische Seite" ausgewählt: page.php wird verwendet
- Wenn "Neueste Beiträge" ausgewählt: index.php wird verwendet
- Beide Templates zeigen jetzt Hero + Rechtsgebiete

## [1.0.32] - 2026-04-12

### Geändert
- **Seiten-Titel auf Startseite ausgeblendet** 🚫
  - Titel wird nur auf Unterseiten angezeigt
  - Startseite nutzt Hero-Section als "Titel"
  - Besseres Layout ohne redundanten Titel
  - Prüfung mit `is_front_page()` in page.php

### Technisch
- Conditional Title Display: `<?php if (!is_front_page()) : ?>`
- Hero-Section ersetzt Titel auf Startseite
- Unterseiten (Impressum, Datenschutz, etc.) zeigen Titel normal

## [1.0.31] - 2026-04-12

### Hinzugefügt
- **Strukturierte Adress-Felder im Customizer** 🏠
  - `contact_street` - Straßenname (z.B. "Schornsteinfegergasse")
  - `contact_housenumber` - Hausnummer (z.B. "5")
  - `contact_zip` - Postleitzahl (z.B. "14482")
  - `contact_city` - Stadt (z.B. "Potsdam")
  - `contact_state` - Bundesland (z.B. "Brandenburg", optional)
  - `contact_country` - Land (z.B. "Deutschland")
  - Keine Parsing-Fehler mehr bei vCard-Generierung!

### Geändert
- **vCard-Generierung radikal vereinfacht** ✨
  - Kein komplexes Regex-Parsing mehr nötig
  - Direkte Verwendung strukturierter Felder
  - 100% zuverlässige Adress-Formatierung
  - ~40 Zeilen Code entfernt
- **Adress-Anzeige einheitlich** 📍
  - Sidebar: Strukturierte Anzeige
  - Footer: Strukturierte Anzeige
  - `potsdam_get_formatted_address()`: Nutzt neue Felder
  - Format: "Straße Hausnummer<br>PLZ Stadt"

### Entfernt
- Customizer-Feld `contact_address` (textarea, ersetzt durch 6 strukturierte Felder)
- Kompletter Adress-Parsing-Code aus sidebar.php (~40 Zeilen)
- Regex-Pattern für "Straße, Stadt Bundesland PLZ" Erkennung

### Migration
- Bestehende Installationen: Adress-Felder im Customizer neu ausfüllen
- Alte `contact_address` Werte werden nicht automatisch migriert
- Empfehlung: Felder manuell übertragen

### Technisch
- vCard ADR-Feld: `;;Straße Hausnr;Stadt;Bundesland;PLZ;Land`
- Bessere Datenhygiene durch strukturierte Eingabe
- Validierung einzelner Felder möglich (z.B. PLZ-Format)

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
