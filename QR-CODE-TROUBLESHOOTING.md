# QR-Code Troubleshooting Guide

## 🐛 Problem: QR-Code ist leer beim Scannen

### 🔍 Schritt-für-Schritt Diagnose

#### 1️⃣ Debug-Modus aktivieren

Hänge `?debug_vcard` an die URL an (nur als eingeloggter Admin):

```
https://deine-seite.de/?debug_vcard
```

**Du siehst dann:**
- Die rohen vCard-Daten unter dem QR-Code
- Format sollte sein:
  ```
  BEGIN:VCARD
  VERSION:3.0
  FN:Rechtsanwalt Matthias Lange
  TEL;TYPE=WORK,VOICE:+49 331 123456
  EMAIL:lange@potestas.de
  ADR;TYPE=WORK:;;Schornsteinfegergasse 5, 14482 Potsdam;;;;
  END:VCARD
  ```

**Prüfe:**
- ✅ Sind alle Felder ausgefüllt?
- ✅ Sind Zeilenumbrüche sichtbar (oder nur eine Zeile)?
- ✅ Sind Sonderzeichen korrekt (keine HTML-Entities wie `&quot;`)?

---

#### 2️⃣ Welches Plugin wird genutzt?

**Rechtsklick auf QR-Code → Bild-URL kopieren**

**Wenn URL beginnt mit:**

- `data:image/svg+xml` oder ähnlich → **Kaya QR Code Generator** ✅
- `chart.googleapis.com` → **Kein Plugin installiert!** ⚠️

**Falls Google Chart API:**
Installiere ein lokales Plugin:
```
WordPress-Admin → Plugins → Installieren → "Kaya QR Code Generator"
```

---

#### 3️⃣ Test mit externem QR-Code-Generator

Kopiere die vCard-Daten aus dem Debug-Modus und teste sie bei:

**https://www.qr-code-generator.com/**

1. Type: "vCard"
2. Daten einfügen
3. QR-Code generieren lassen
4. Scannen mit Smartphone

**Funktioniert es hier?**
- ✅ **Ja** → Problem liegt am WordPress-Plugin, nicht an vCard-Daten
- ❌ **Nein** → vCard-Daten sind fehlerhaft

---

#### 4️⃣ vCard-Format manuell prüfen

**Minimale funktionierende vCard:**
```
BEGIN:VCARD
VERSION:3.0
FN:Test Name
TEL:+49123456789
EMAIL:test@example.com
END:VCARD
```

**Häufige Fehler:**
- ❌ Fehlende Zeilenumbrüche (alles in einer Zeile)
- ❌ Falsche Zeilenumbrüche (LF statt CRLF)
- ❌ Sonderzeichen (Umlaute in Telefonnummern)
- ❌ HTML-Entities (`&amp;`, `&quot;`, `&#13;`)
- ❌ Fehlende `END:VCARD`

---

#### 5️⃣ Smartphone QR-Scanner testen

**Nicht alle Scanner unterstützen vCard!**

**Empfohlene Apps:**
- **iOS:** Native Kamera-App (iOS 11+) ✅
- **Android:** Google Lens ✅
- **Alternative:** "QR & Barcode Scanner" (kostenlos)

**Test:** Scanne diesen Test-QR-Code
<https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=BEGIN:VCARD%0D%0AVERSION:3.0%0D%0AFN:Test%0D%0ATEL:+49123456789%0D%0AEND:VCARD>

**Funktioniert der Test-QR-Code?**
- ✅ **Ja** → Dein Scanner funktioniert, Problem ist im Theme
- ❌ **Nein** → Scanner unterstützt keine vCards

---

### 🔧 Lösungen für häufige Probleme

#### Problem: Plugin installiert, aber Google Chart API wird genutzt

**Ursache:** Plugin nicht aktiviert oder Theme erkennt es nicht

**Lösung:**
```php
// Prüfe in WordPress was verfügbar ist
WordPress-Admin → Plugins → Installierte Plugins

Suche: "Kaya QR Code Generator" oder "QR Code Generator"
Status: Muss "Aktiviert" sein
```

**Test ob Plugin erkannt wird:**
```php
// Füge in functions.php ein (temporär):
add_action('wp_footer', function() {
    if (current_user_can('manage_options')) {
        echo '<!-- QR Plugin Test: ';
        echo shortcode_exists('kaya_qrcode') ? 'Kaya OK' : 'Kaya fehlt';
        echo ' -->';
    }
});
```

Dann: Seitenquelltext ansehen (STRG+U) und nach "QR Plugin Test" suchen.

---

#### Problem: vCard-Daten sind Einzeiler (keine Zeilenumbrüche)

**Ursache:** WordPress-Sanitization entfernt Zeilenumbrüche

**Lösung:** Bereits in v1.0.23 behoben durch:
```php
// Kein esc_attr() mehr - beschädigte \r\n
str_replace('"', '&quot;', $vcard)  // Nur Quotes escapen
```

---

#### Problem: QR-Code zeigt HTML statt Bild

**Symptom:** Im Browser siehst du `<div class="qr">...</div>` statt Bild

**Ursache:** Plugin gibt HTML zurück, aber Theme erwartet URL

**Lösung:** Bereits implementiert in v1.0.20+
```php
if (strpos($qr_url, '<') === 0) {
    echo $qr_url; // HTML direkt ausgeben
} else {
    echo '<img src="' . $qr_url . '">'; // URL als Bild
}
```

---

#### Problem: Kontaktdaten sind falsch/leer im QR-Code

**Ursache:** Customizer-Daten nicht gespeichert oder Default-Werte

**Lösung:**
1. WordPress-Admin → Design → Anpassen
2. Section "Kontakt-Informationen" öffnen
3. Alle Felder ausfüllen:
   - Name / Kanzleiname
   - Telefonnummer (mit Ländercode, z.B. +49)
   - E-Mail
   - Adresse (kann mehrzeilig sein)
4. **"Veröffentlichen" klicken!** (nicht nur Vorschau)

---

### 📱 Manuelle QR-Code-Tests

#### Test 1: Minimale vCard

Erstelle einen einfachen Test-QR-Code:

```
https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=BEGIN:VCARD%0D%0AVERSION:3.0%0D%0AFN:Test%0D%0AEND:VCARD
```

Öffne diese URL im Browser → QR-Code sollte erscheinen → Scannen

**Funktioniert?**
- ✅ Ja → Google Chart API funktioniert, Problem liegt woanders
- ❌ Nein → Netzwerkproblem oder Scanner-Problem

---

#### Test 2: Vollständige vCard

Mit allen Feldern:

```
https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=BEGIN:VCARD%0D%0AVERSION:3.0%0D%0AFN:Rechtsanwalt%20Matthias%20Lange%0D%0ATEL:+493311234567%0D%0AEMAIL:test@example.com%0D%0AADR:;;Teststrasse%201,%2014467%20Potsdam;;;;%0D%0AEND:VCARD
```

---

### 🛠️ Advanced Debugging

#### Server-Log überprüfen

Falls Debug-Modus in `qrcode-generator.php` aktiviert (Zeile 24):

```php
// Auskommentieren entfernen:
error_log('vCard-Daten: ' . $vcard);
```

**Log finden:**
- Synology NAS: `/volume1/@appstore/WebStation/log/`
- Standard WordPress: `wp-content/debug.log`

**Suche nach:** `vCard-Daten:`

---

#### Browser-Konsole

Rechtsklick auf QR-Code → "Element untersuchen"

**Prüfe:**
```html
<!-- Sollte sein: -->
<img src="data:image/svg+xml;base64,..." alt="QR-Code">

<!-- Oder: -->
<img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=BEGIN:VCARD...">

<!-- Nicht: -->
<img src="">  <!-- Leeres src! -->
```

Kopiere `src=` URL und öffne sie direkt im Browser → Was siehst du?

---

### ✅ Checkliste

Gehe diese Liste durch:

- [ ] **Plugin installiert?** (Kaya QR Code Generator empfohlen)
- [ ] **Plugin aktiviert?** (WordPress → Plugins)
- [ ] **Kontaktdaten ausgefüllt?** (Design → Anpassen → Kontakt-Informationen)
- [ ] **QR-Code aktiviert?** (Design → Anpassen → Kontakt-Informationen → QR-Code Checkbox)
- [ ] **Debug-Modus getestet?** (`?debug_vcard` an URL)
- [ ] **vCard-Daten korrekt?** (BEGIN:VCARD ... END:VCARD)
- [ ] **Zeilenumbrüche vorhanden?** (nicht alles in einer Zeile)
- [ ] **Smartphone-Scanner funktioniert?** (Test-QR-Code scannen)
- [ ] **Theme-Version aktuell?** (mindestens v1.0.23)

---

### 📞 Letzte Rettung

Falls nichts funktioniert:

**Temporärer Workaround:**

Deaktiviere QR-Code im Customizer und erstelle manuell einen bei:
- https://www.qr-code-generator.com/
- https://goqr.me/de/

Download als PNG und hochladen in WordPress Media Library.

Dann in `sidebar.php` ersetzen:
```php
<img src="<?php echo wp_get_attachment_url(123); ?>" alt="QR-Code">
```
(Ersetze `123` mit Media-ID)

---

### 📊 Erwartetes Ergebnis

**Beim Scannen sollte das Smartphone:**

1. **vCard erkennen** 
2. **Aktion anbieten:** "Kontakt hinzufügen" oder "Zu Kontakten"
3. **Daten anzeigen:**
   - Name: Rechtsanwalt Matthias Lange
   - Telefon: +49 331 123456
   - E-Mail: lange@potestas.de
   - Adresse: Schornsteinfegergasse 5, 14482 Potsdam

**Nicht:** Leerer Kontakt, Fehler, oder "Ungültiger QR-Code"

---

**Viel Erfolg beim Debugging!** 🚀

Bei weiteren Problemen: Aktiviere Debug-Modus und schicke Screenshot der vCard-Daten.
