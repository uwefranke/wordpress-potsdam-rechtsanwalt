# Layout-Optionen - Customizer-Anleitung

## ⚙️ Neue Customizer-Section

Ab Version **1.0.16** gibt es eine neue Section im Customizer:

**WordPress-Admin → Design → Anpassen → Layout-Optionen**

## 🎛️ Verfügbare Optionen

### 1️⃣ Kontaktformular anzeigen

**Einstellung:** `show_contact_form`  
**Standard:** ✅ Aktiviert  
**Beschreibung:** Zeigt/versteckt das Kontaktformular in der Sidebar

#### Wann deaktivieren?

- Wenn ein externes Kontaktformular-Plugin verwendet wird (z.B. Contact Form 7, WPForms)
- Wenn Kontaktaufnahme nur per E-Mail/Telefon gewünscht
- Wenn die Sidebar schlanker sein soll

#### Was passiert beim Deaktivieren?

Das gesamte Kontaktformular-Widget wird ausgeblendet:

```html
<!-- Wird NICHT angezeigt wenn deaktiviert -->
<div class="widget contact-widget">
    <h3>Kontaktieren Sie uns</h3>
    <form class="contact-form">...</form>
</div>
```

---

### 2️⃣ Termin-Button anzeigen

**Einstellung:** `show_appointment_button`  
**Standard:** ✅ Aktiviert  
**Beschreibung:** Zeigt/versteckt den "Online-Termin vereinbaren" Button

#### Wann deaktivieren?

- Wenn keine Online-Terminvereinbarung angeboten wird
- Wenn ein externes Buchungssystem verwendet wird (z.B. Calendly, Acuity)
- Wenn Termine nur telefonisch vergeben werden

#### Was passiert beim Deaktivieren?

Der Termin-Button wird komplett ausgeblendet:

```html
<!-- Wird NICHT angezeigt wenn deaktiviert -->
<div class="widget appointment-widget">
    <a href="/termin" class="btn btn-appointment">
        Online-Termin vereinbaren
    </a>
</div>
```

---

## 🔧 Verwendung im Customizer

### Schritt-für-Schritt:

1. **WordPress-Admin** öffnen
2. **Design → Anpassen** klicken
3. Section **"Layout-Optionen"** öffnen
4. Checkboxen nach Bedarf setzen/entfernen:
   - ☑️ **Kontaktformular anzeigen**
   - ☑️ **Termin-Button anzeigen**
5. **"Veröffentlichen"** klicken

### Beispiel-Konfigurationen:

#### Nur Kontaktinformationen (keine Formulare)
```
☐ Kontaktformular anzeigen
☐ Termin-Button anzeigen
```
→ Sidebar zeigt nur Kontaktdaten und Öffnungszeiten

#### Nur Termin-Button (kein Formular)
```
☐ Kontaktformular anzeigen
☑️ Termin-Button anzeigen
```
→ Besucher können Termin buchen, aber nicht direkt schreiben

#### Nur Kontaktformular (kein Termin)
```
☑️ Kontaktformular anzeigen
☐ Termin-Button anzeigen
```
→ Klassisches Setup für reine E-Mail-Kontaktaufnahme

#### Alles aktiviert (Standard)
```
☑️ Kontaktformular anzeigen
☑️ Termin-Button anzeigen
```
→ Maximale Kontaktmöglichkeiten für Besucher

---

## 📍 Was bleibt IMMER sichtbar?

Folgende Sidebar-Widgets können **nicht** deaktiviert werden:

✅ **Kontaktinformationen**
- Telefonnummer
- E-Mail
- Adresse

✅ **Öffnungszeiten**
- Mo-Do / Fr Zeiten
- Individuelle Notizen

Diese sind essenzielle Informationen und sollten immer verfügbar sein.

---

## 💻 Technische Details

### Code-Implementierung

```php
<?php if (get_theme_mod('show_contact_form', true)) : ?>
    <!-- Kontaktformular HTML -->
<?php endif; ?>

<?php if (get_theme_mod('show_appointment_button', true)) : ?>
    <!-- Termin-Button HTML -->
<?php endif; ?>
```

### Standard-Werte

Die Optionen sind **standardmäßig aktiviert** (true):

- `'default' => true` im Customizer
- Beim ersten Theme-Upload sind beide sichtbar
- Absichtlich aktiviert für maximale "First-Impression"

### Betroffene Dateien

- **src/inc/customizer.php** - Customizer-Settings & Controls
- **src/sidebar.php** - Conditional Widget-Anzeige

---

## 🎨 CSS bleibt unverändert

Auch wenn Widgets deaktiviert sind, bleibt das CSS geladen.  
Das hat keinen Performance-Impact, da die Styles sehr schlank sind.

Falls du CSS für deaktivierte Widgets komplett entfernen möchtest, kannst du in `style.css` mit `body` Klassen arbeiten (erfordert zusätzlichen Code).

---

## 🔄 Migration von alter Version

Falls du von **v1.0.15 oder älter** updatest:

1. Theme hochladen und aktivieren
2. Customizer öffnen
3. **Beide Optionen sind standardmäßig aktiviert** ✅
4. Keine Änderungen nötig - alles funktioniert wie vorher

Um Widgets zu verstecken, musst du **aktiv** die Checkboxen deaktivieren.

---

## 🚀 Use Cases

### Anwaltskanzlei mit Calendly
```
☐ Termin-Button anzeigen
☑️ Kontaktformular anzeigen
```
Füge Calendly-Widget manuell auf /termin Seite ein, verstecke nativen Button.

### Nur Telefonische Beratung
```
☐ Kontaktformular anzeigen
☐ Termin-Button anzeigen
```
Zeige nur Telefonnummer prominent an, keine Online-Kontakte.

### Maximale Erreichbarkeit
```
☑️ Kontaktformular anzeigen
☑️ Termin-Button anzeigen
```
Jeder Besucher findet seinen bevorzugten Kontaktweg.

---

## ❓ Häufige Fragen

### Kann ich die Reihenfolge ändern?

Ja, in `sidebar.php` die Widget-Blöcke neu sortieren.

### Kann ich eigene Widgets hinzufügen?

Ja, mehr Customizer-Optionen in `inc/customizer.php` hinzufügen.

### Wird der Termin-Link angepasst?

Nein, er zeigt immer auf `/termin`. Passe `href` in sidebar.php an.

### Funktioniert es mit WordPress Widgets?

Ja, die nativen WordPress-Widgets werden nicht beeinflusst.

---

## 📊 Vergleich

| Feature | Aktiviert | Deaktiviert |
|---------|-----------|-------------|
| **Kontaktformular** | ✅ Formular sichtbar + funktional | ❌ Komplett ausgeblendet |
| **Termin-Button** | ✅ Button sichtbar + klickbar | ❌ Komplett ausgeblendet |
| **Kontaktdaten** | ✅ Immer sichtbar | ✅ Immer sichtbar |
| **Öffnungszeiten** | ✅ Immer sichtbar | ✅ Immer sichtbar |

---

## 🎯 Empfehlung

Für **Rechtsanwaltskanzleien** empfehle ich:

```
☑️ Kontaktformular anzeigen
☑️ Termin-Button anzeigen
```

**Warum?**
- Verschiedene Mandanten bevorzugen verschiedene Kontaktwege
- Jüngere Mandanten buchen online
- Ältere Mandanten schreiben lieber E-Mails
- Maximale Conversion-Rate durch mehrere CTAs

Nur bei **sehr spezifischen Workflows** solltest du Widgets deaktivieren.
