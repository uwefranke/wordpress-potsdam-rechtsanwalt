# Shortcode-Anleitung

Alle Customizer-Felder können im WordPress-Editor als Shortcodes verwendet werden.

## 🔹 Kontakt-Shortcodes

### Einzelne Felder

```
[kontakt field="title"]          → Rechtsanwalt
[kontakt field="firstname"]      → Matthias
[kontakt field="lastname"]       → Lange
[kontakt field="phone"]          → +49 331 123456
[kontakt field="fax"]            → (Fax-Nummer)
[kontakt field="email"]          → info@potsdam-rechtsanwalt.de
[kontakt field="street"]         → Schornsteinfegergasse
[kontakt field="housenumber"]    → 5
[kontakt field="zip"]            → 14482
[kontakt field="city"]           → Potsdam
[kontakt field="state"]          → Brandenburg
[kontakt field="country"]        → Deutschland
```

### Kombinierte Felder

```
[kontakt field="fullname"]       → Rechtsanwalt Matthias Lange
[kontakt field="address"]        → Schornsteinfegergasse 5
[kontakt field="shortaddress"]   → Schornsteinfegergasse 5, 14482 Potsdam
[kontakt field="fulladdress"]    → Schornsteinfegergasse 5, 14482 Potsdam, Brandenburg, Deutschland
```

### Mit Links

```
[kontakt field="phone" link="yes"]    → Klickbare Telefonnummer
[kontakt field="email" link="yes"]    → Klickbare E-Mail-Adresse
```

### HTML-Formatierung

```
[kontakt field="shortaddress" format="html"]  → Adresse mit <br> Zeilenumbrüchen
```

### Spam-Schutz (Verschleierung)

E-Mail, Telefon und Fax werden **automatisch** als HTML-Entities verschleiert – kein extra Parameter nötig.

Im Browser wird der Text normal angezeigt, im Quelltext steht z.B. `&#105;&#110;&#102;&#111;&#64;...` – schwer lesbar für Spam-Bots.

Mit `obfuscate="no"` kann die Verschleierung bei Bedarf deaktiviert werden:

```
[kontakt field="email" obfuscate="no"]  → E-Mail als Klartext
```

## 🏛️ Rechtsgebiete-Shortcodes

```
[rechtsgebiet number="1" field="title"]  → Titel des 1. Rechtsgebiets
[rechtsgebiet number="2" field="text"]   → Beschreibung des 2. Rechtsgebiets
[rechtsgebiet number="3" field="icon"]   → Icon-Klasse des 3. Rechtsgebiets
```

**Verfügbare Nummern:** 1 bis 6

**Verfügbare Felder:**
- `title` - Titel (z.B. "Familienrecht")
- `text` - Beschreibungstext
- `icon` - Font Awesome Icon-Klasse

## 🎯 Hero-Bereich Shortcodes

```
[hero field="title"]   → Hero-Überschrift
[hero field="text"]    → Hero-Text
[hero field="image"]   → Hero-Hintergrundbild (als <img> Tag)
```

## 🔧 Universeller Customizer-Shortcode

Für **alle** Customizer-Felder (auch zukünftige):

```
[customizer field="beliebiges_feld"]
[customizer field="beliebiges_feld" default="Standardwert"]
```

**Beispiele:**
```
[customizer field="hero_title"]
[customizer field="contact_phone"]
[customizer field="rechtsgebiet_1_title"]
```

## 🍪 Cookie-Einstellungen Shortcode

Erstellt einen Link, mit dem Besucher die Cookie-Einstellungen jederzeit öffnen können:

```
[cookie_einstellungen]
[cookie_einstellungen text="Cookies verwalten"]
[cookie_einstellungen text="Cookie-Präferenzen" class="custom-class"]
```

**Parameter:**
- `text` - Link-Text (Standard: "Cookie-Einstellungen")
- `class` - Zusätzliche CSS-Klasse für Styling

**Verwendung:**
```
<p>Weitere Informationen in der [cookie_einstellungen text="Cookie-Richtlinie"].</p>
```

**Automatisch im Footer:**
Der Link erscheint bereits automatisch im Footer neben "Impressum" und "Datenschutz".

## 📝 Verwendungsbeispiele

### Kontaktseite

```
<h2>Kontakt aufnehmen</h2>

<p><strong>Anwalt:</strong> [kontakt field="fullname"]</p>
<p><strong>Adresse:</strong><br>
[kontakt field="fulladdress" format="html"]</p>

<p><strong>Telefon:</strong> [kontakt field="phone" link="yes"]<br>
<strong>E-Mail:</strong> [kontakt field="email" link="yes"]</p>
```

### Rechtsgebiete-Übersicht

```
<h3>[rechtsgebiet number="1" field="title"]</h3>
<p>[rechtsgebiet number="1" field="text"]</p>

<h3>[rechtsgebiet number="2" field="title"]</h3>
<p>[rechtsgebiet number="2" field="text"]</p>
```

### Kompakte Kontaktbox

```
<div class="contact-box">
  <h4>[kontakt field="fullname"]</h4>
  <p>
    [kontakt field="address"]<br>
    [kontakt field="zip"] [kontakt field="city"]
  </p>
  <p>
    Tel: [kontakt field="phone" link="yes"]<br>
    E-Mail: [kontakt field="email" link="yes"]
  </p>
</div>
```

## 💡 Tipps

1. **Shortcodes funktionieren in:**
   - WordPress-Editor (Gutenberg & Classic)
   - Widgets (Text-Widgets)
   - Custom HTML Blöcke

2. **Updates automatisch:**
   - Änderungen im Customizer werden sofort in allen Shortcodes übernommen
   - Keine manuelle Aktualisierung nötig

3. **HTML-Editor:**
   - Shortcodes können auch direkt im HTML-Code eingefügt werden
   - Im HTML-Editor sieht man den Shortcode-Text
   - Im Frontend wird der Wert angezeigt

## 🔍 Fehlersuche

**Shortcode wird als Text angezeigt:**
- Prüfen, ob `inc/shortcodes.php` in `functions.php` inkludiert ist
- Theme-Cache löschen

**Falscher Wert:**
- Im Customizer den korrekten Wert setzen
- Seite neu laden

**"Unbekanntes Feld":**
- Feld-Name überprüfen (Kleinschreibung!)
- Verfügbare Felder siehe oben

---

**Erstellt:** Version 1.1.0
**Datei:** `src/inc/shortcodes.php`
