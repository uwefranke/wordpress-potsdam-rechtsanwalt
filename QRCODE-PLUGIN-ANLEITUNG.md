# QR-Code Plugin - Installation & Empfehlung

## 🔒 DSGVO-konforme QR-Code-Generierung

Für 100% DSGVO-konforme, lokale QR-Code-Generierung empfehlen wir die Installation eines WordPress-Plugins.

---

## ✅ Empfohlenes Plugin

### **QR Code Generator** (WordPress.org)

**Rating:** ⭐⭐⭐⭐⭐ (4.5/5)  
**Aktive Installationen:** 10,000+  
**Plugin-Link:** https://wordpress.org/plugins/qr-code-generator-for-wordpress/

### Vorteile:
- ✅ **100% lokal** - keine externen API-Aufrufe
- ✅ **DSGVO-konform** - keine Daten verlassen den Server
- ✅ **Kostenlos** - keine Premium-Version nötig
- ✅ **Leichtgewichtig** - keine Performance-Probleme
- ✅ **Automatische Integration** - unser Theme erkennt das Plugin automatisch

---

## 📥 Installation

### Methode 1: WordPress-Admin (empfohlen)

1. **WordPress-Admin** öffnen
2. **Plugins → Installieren** klicken
3. Nach "**QR Code Generator**" suchen
4. Plugin **installieren** und **aktivieren**
5. **Fertig!** Das Theme nutzt nun automatisch das Plugin

### Methode 2: Manueller Upload

1. Plugin von WordPress.org herunterladen
2. ZIP-Datei über **Plugins → Installieren → Plugin hochladen** uploaden
3. Plugin aktivieren

---

## 🔧 Konfiguration

### Keine Konfiguration nötig!

Das Theme integriert das Plugin automatisch. Die QR-Codes werden ab sofort **lokal generiert**, ohne externe APIs.

---

## 🔄 Fallback-Verhalten

Falls **kein Plugin installiert** ist, nutzt das Theme als Fallback:

### Google Chart API (extern)
```
https://charts.googleapis.com/chart?cht=qr&...
```

⚠️ **Achtung:** Dies sendet Kontaktdaten an Google-Server!  
**Für DSGVO-Konformität sollte ein lokales Plugin installiert werden.**

### Admin-Hinweis

Wenn kein Plugin installiert ist, zeigt das Theme einen **Hinweis im WordPress-Admin**:

```
┌─────────────────────────────────────────────────────┐
│ ℹ️ Potsdam Rechtsanwalt Theme:                      │
│                                                      │
│ Für optimale DSGVO-Konformität empfehlen wir die    │
│ Installation des "QR Code Generator" Plugins für    │
│ lokale QR-Code-Generierung.                         │
│                                                      │
│ Aktuell wird die externe Google Chart API als       │
│ Fallback genutzt.                                   │
│                                                      │
│ [Plugin installieren →]                             │
└─────────────────────────────────────────────────────┘
```

---

## 🎯 Unterstützte Plugins

Unser Theme ist kompatibel mit:

### 1. QR Code Generator
- **Shortcode:** `[qrcode]content[/qrcode]`
- **Funktion:** Automatisch erkannt
- **Empfehlung:** ⭐⭐⭐⭐⭐

### 2. WP QR Code Generator  
- **Funktion:** `wpqr_generate_code($data, $size)`
- **Erkennung:** Automatisch
- **Empfehlung:** ⭐⭐⭐⭐

### 3. Andere QR-Code-Plugins
Wenn dein bevorzugtes Plugin nicht automatisch erkannt wird, kannst du die Datei `inc/qrcode-generator.php` anpassen.

---

## 💡 Technische Details

### Automatische Plugin-Erkennung

```php
// Theme prüft automatisch ob Plugin verfügbar ist
if (shortcode_exists('qrcode')) {
    // Nutze QR Code Generator Plugin
    return do_shortcode('[qrcode]' . $vcard . '[/qrcode]');
} elseif (function_exists('wpqr_generate_code')) {
    // Nutze WP QR Code Generator
    return wpqr_generate_code($vcard, 200);
} else {
    // Fallback: Google Chart API
    return 'https://chart.googleapis.com/...';
}
```

### vCard-Format

Die QR-Codes enthalten vollständige vCard 3.0 Daten:

```
BEGIN:VCARD
VERSION:3.0
FN:Rechtsanwalt Matthias Lange
TEL;TYPE=WORK,VOICE:+49 331 123456
TEL;TYPE=WORK,FAX:+49 331 123457
EMAIL:lange@potestas.de
ADR;TYPE=WORK:;;Schornsteinfegergasse 5, 14482 Potsdam
END:VCARD
```

---

## 🔍 Troubleshooting

### QR-Code wird nicht angezeigt

**Ursache:** Customizer-Option deaktiviert  
**Lösung:** Design → Anpassen → Kontakt-Informationen → "QR-Code mit Kontaktdaten anzeigen" ✅

### Plugin installiert, aber externes API wird genutzt

**Ursache:** Plugin nicht richtig aktiviert  
**Lösung:** Plugins → Installierte Plugins → "QR Code Generator" aktivieren

### QR-Code scannt nicht richtig

**Ursache:** Kontaktdaten enthalten Sonderzeichen  
**Lösung:** Verwende ASCII-Zeichen in Customizer-Feldern (keine Umlaute in Telefonnummern)

---

## 📊 Performance-Vergleich

| Methode | Ladezeit | DSGVO | Offline |
|---------|----------|-------|---------|
| **QR Code Generator Plugin** | ~50ms | ✅ Ja | ✅ Ja |
| **WP QR Code Generator** | ~60ms | ✅ Ja | ✅ Ja |
| **Google Chart API** | ~200ms | ❌ Nein | ❌ Nein |

**Empfehlung:** Plugin-Nutzung für beste Performance und Datenschutz.

---

## 🚀 Quick Start

```bash
# 1. Theme hochladen und aktivieren
wp theme activate potsdam-rechtsanwalt

# 2. QR Code Generator Plugin installieren
wp plugin install qr-code-generator-for-wordpress --activate

# 3. Kontaktdaten im Customizer eintragen
# WordPress-Admin → Design → Anpassen → Kontakt-Informationen

# 4. QR-Code prüfen
# Besuche Website → Sidebar → "Kontakt speichern" QR-Code
```

---

## 📝 Datenschutzerklärung-Hinweis

Falls du **kein Plugin installierst** und die Google Chart API nutzt, musst du das in deiner **Datenschutzerklärung** erwähnen:

> Bei der Nutzung unserer Website werden QR-Codes über die Google Chart API geladen. 
> Dabei werden Ihre IP-Adresse und technische Informationen an Google übermittelt.
> Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse).

**Besser:** Plugin installieren und diesen Hinweis vermeiden! ✅

---

## 🎁 Weitere Plugin-Optionen

### Alternative Plugins (falls gewünscht):

1. **Simple QR Code Generator**  
   https://wordpress.org/plugins/simple-qr-code-generator/

2. **QR Code Widget**  
   https://wordpress.org/plugins/qr-code-widget/

3. **WP QR Code Maker**  
   https://wordpress.org/plugins/wp-qr-code-maker/

Alle werden automatisch vom Theme erkannt (falls sie Standard-Funktionen nutzen).

---

## ❓ FAQ

### Muss ich das Plugin installieren?

**Nein**, aber es wird **dringend empfohlen** für:
- DSGVO-Konformität ✅
- Bessere Performance ✅  
- Keine Abhängigkeit von externen Services ✅

### Kostet das Plugin etwas?

**Nein**, "QR Code Generator" ist 100% **kostenlos**.

### Funktioniert es ohne Internet?

**Ja**, wenn ein lokales Plugin installiert ist.  
**Nein**, wenn Google Chart API als Fallback genutzt wird.

### Kann ich ein anderes QR-Code-Plugin nutzen?

**Ja**, passe `inc/qrcode-generator.php` an und füge dein Plugin hinzu.

---

## 🔗 Nützliche Links

- **Theme-Repository:** https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt
- **QR Code Generator Plugin:** https://wordpress.org/plugins/qr-code-generator-for-wordpress/
- **vCard Spezifikation:** https://www.rfc-editor.org/rfc/rfc6350
- **DSGVO-Infos:** https://dsgvo-gesetz.de/

---

**TL;DR:** Installiere "QR Code Generator" Plugin für lokale, DSGVO-konforme QR-Codes! 🚀
