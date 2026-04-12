# Rechtsgebiete im Customizer bearbeiten

## Übersicht

Seit Version 1.0.34 können Sie die Rechtsgebiete-Karten auf der Startseite direkt im WordPress Customizer bearbeiten.

## Funktionen

- **Variable Anzahl:** 1-8 Rechtsgebiets-Karten anzeigen
- **Vollständig editierbar:** Titel, Beschreibung und Link jeder Karte
- **Vordefinierte Icons:** 8 verschiedene SVG-Icons werden automatisch zugeordnet
- **Live-Vorschau:** Änderungen sofort sehen (ohne Speichern)

## Anleitung

### 1. Customizer öffnen

1. WordPress **Dashboard** öffnen
2. Menü: **Design** → **Customizer**
3. Section **Rechtsgebiete** auswählen

### 2. Anzahl festlegen

- **Anzahl der Rechtsgebiete:** Dropdown (1-8)
- Standard: 4 Rechtsgebiete
- Nur gefüllte Karten (Titel vorhanden) werden angezeigt

### 3. Karten bearbeiten

Für jedes Rechtsgebiet (1-8) können Sie bearbeiten:

#### Titel
```
Beispiel: Miet- / Wohnungseigentumsrecht
```
- **Pflichtfeld** (Karte wird nur mit Titel angezeigt)
- Wird als Überschrift der Karte angezeigt

#### Beschreibung
```
Beispiel: Umfassende Beratung bei Wohnungs- und Gewerbemietrecht, 
Kündigungen, Mietminderungen und WEG-Recht.
```
- Optional
- Kurze Beschreibung (2-3 Sätze empfohlen)
- Wird als Text unter dem Titel angezeigt

#### Link
```
Beispiele:
/miet-wohnungseigentumsrecht         (relative URL)
https://www.example.com/mietrecht    (absolute URL)
```
- Optional
- **Relative URLs** (beginnen mit `/`):
  - Werden automatisch mit Ihrer Domain ergänzt
  - Beispiel: `/mietrecht` → `https://lawv8.scriptbb.de/mietrecht`
  
- **Absolute URLs** (beginnen mit `http://` oder `https://`):
  - Werden direkt verwendet
  - Für externe Links oder spezielle URLs

### 4. Icons

Die Icons werden automatisch zugeordnet:

| Karte | Icon | Passt zu |
|-------|------|----------|
| 1 | 📋 Ordner | Mietrecht, Aktenordner |
| 2 | 🏠 Haus | Immobilien, Grundstücke |
| 3 | 🔧 Werkzeug | Baurecht, Handwerk |
| 4 | 👥 Personen | BU, Sozialrecht, Rente |
| 5 | 🚗 Auto | Verkehrsrecht |
| 6 | 📄 Dokument | Vertragsrecht |
| 7 | ⏱️ Uhr | Arbeitsrecht, Fristen |
| 8 | ⚖️ Waage | Allgemeines Recht |

**Hinweis:** Icons sind aktuell fix und können nicht geändert werden.

### 5. Änderungen speichern

1. Im Customizer bearbeiten
2. **Live-Vorschau** rechts prüfen
3. Button **Veröffentlichen** klicken

## Standard-Konfiguration

Nach der Installation sind 4 Rechtsgebiete vorkonfiguriert:

### Rechtsgebiet 1: Miet- / Wohnungseigentumsrecht
- **Titel:** Miet- / Wohnungseigentumsrecht
- **Beschreibung:** Umfassende Beratung bei Wohnungs- und Gewerbemietrecht, Kündigungen, Mietminderungen und WEG-Recht.
- **Link:** `/miet-wohnungseigentumsrecht`
- **Icon:** 📋 Ordner

### Rechtsgebiet 2: Grundstücks- / Immobilienrecht
- **Titel:** Grundstücks- / Immobilienrecht
- **Beschreibung:** Kaufverträge, Förderdarlehen (ILB/IBB), Nachbarschaftsrecht und alle immobilienrechtlichen Angelegenheiten.
- **Link:** `/grundstuecks-immobilienrecht`
- **Icon:** 🏠 Haus

### Rechtsgebiet 3: Baurecht
- **Titel:** Baurecht
- **Beschreibung:** Bauverträge (BGB/VOB), Baumängel, Gewährleistung, Architektenrecht und bauplanungsrechtliche Fragen.
- **Link:** `/baurecht`
- **Icon:** 🔧 Werkzeug

### Rechtsgebiet 4: BU / Erwerbsminderungsrente
- **Titel:** BU / Erwerbsminderungsrente
- **Beschreibung:** Durchsetzung von Ansprüchen bei Berufsunfähigkeit und Erwerbsminderung gegenüber Versicherungen und Behörden.
- **Link:** `/bu-erwerbsminderungsrente`
- **Icon:** 👥 Personen

## Tipps

### Karten ausblenden
- Titel-Feld **leer lassen** → Karte wird nicht angezeigt
- Oder: **Anzahl der Rechtsgebiete** reduzieren

### Karten neu sortieren
- Inhalte zwischen den Karten manuell kopieren
- Beispiel: Karte 3 nach oben verschieben:
  1. Karte 3 Inhalte kopieren
  2. Karte 3 Inhalte in Karte 1 einfügen
  3. Alte Karte 1 in Karte 3 verschieben

### Ohne Link
- Link-Feld **leer lassen**
- Karte ist dann nicht klickbar
- Nur für Informations-Karten geeignet

### Externe Links
- Vollständige URL mit `https://` angeben
- Beispiel: `https://www.gesetze-im-internet.de/`
- Link öffnet sich im gleichen Tab

## Technische Details

### Customizer Settings
- **services_count:** Anzahl (1-8)
- **service_1_title** bis **service_8_title:** Titel
- **service_1_description** bis **service_8_description:** Beschreibung
- **service_1_link** bis **service_8_link:** Link

### Template-Funktion
```php
<?php potsdam_display_service_cards(); ?>
```

Verwendet in:
- **src/page.php** (Zeile ~40, nur bei `is_front_page()`)
- **src/index.php** (Zeile ~40)

### Dateien
- **src/inc/customizer.php:** Customizer Settings (Zeilen 287-400)
- **src/inc/template-tags.php:** Helper-Funktion (Zeilen 82-143)

## Häufige Fragen

**Q: Kann ich mehr als 8 Rechtsgebiete anzeigen?**  
A: Aktuell ist das Maximum 8 Karten. Bei Bedarf kann dies erweitert werden.

**Q: Kann ich eigene Icons hochladen?**  
A: Aktuell nicht. Die 8 Icons sind fest im Code definiert. Ein zukünftiges Update könnte Icon-Upload ermöglichen.

**Q: Wo werden die Karten angezeigt?**  
A: Nur auf der **Startseite** (index.php bei "Neueste Beiträge" oder page.php bei "Statische Seite").

**Q: Kann ich die Karten-Reihenfolge ändern?**  
A: Nur durch manuelles Kopieren der Inhalte zwischen Karten 1-8. Drag & Drop wird aktuell nicht unterstützt.

**Q: Was passiert, wenn ich nur Titel angebe (ohne Beschreibung/Link)?**  
A: Karte wird angezeigt mit Titel und Icon, aber ohne Text und nicht klickbar.

## Changelog

### Version 1.0.34 (2026-04-13)
- ✨ Initiales Release
- ⚙️ Customizer Section "Rechtsgebiete"
- 🔢 Variable Anzahl 1-8
- 📝 Editierbar: Titel, Beschreibung, Link
- 🎨 8 vordefinierte SVG-Icons

## Support

Bei Fragen oder Problemen:
- **GitHub Issues:** https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/issues
- **E-Mail:** siehe Theme-Autor (Uwe Franke)
