# Cookie-Consent Banner Dokumentation

## 🍪 Übersicht

Das Theme enthält einen **DSGVO-konformen Cookie-Consent-Banner**, der beim ersten Besuch angezeigt wird.

## ✅ Features

- **DSGVO-konform** - Entspricht deutschen Datenschutzrichtlinien
- **Transparent** - Zeigt genau, welche Cookies gesetzt werden
- **Technisch notwendig** - Keine Tracking-Cookies
- **Theme-Design** - Navy & Gold Farben, passt zum Theme
- **Responsive** - Funktioniert auf Desktop, Tablet, Mobile
- **Dark Mode Support** - Passt sich dem Dark Mode an
- **Einstellungen** - Detaillierte Cookie-Übersicht

## 📋 Was der Banner anzeigt

### Standardansicht:
```
🍪 Cookie-Hinweis

Diese Website verwendet ausschließlich technisch notwendige Cookies 
für die Kernfunktionen (Dark Mode, Session-Verwaltung). 
Es werden keine Tracking-Cookies gesetzt.

[✓ Verstanden] [Einstellungen]
```

### Einstellungs-Ansicht:
- **Technisch notwendig** (Pflicht):
  - `potsdam-theme-mode` - Dark Mode localStorage
  - `wordpress_*` - WordPress Session
  - `potsdam-cookie-consent` - Cookie-Zustimmung
  
- **Analytics & Tracking** (Nicht aktiv):
  - Wird nicht verwendet

## 🔧 Technische Details

### Dateien:
```
src/assets/js/cookie-consent.js    - Banner-Logik
src/assets/css/cookie-consent.css  - Banner-Styling
```

### Cookie-Name:
```
potsdam-cookie-consent = accepted
```

### Speicherdauer:
```
365 Tage
```

### Eigenschaften:
```
Path: /
SameSite: Lax
HttpOnly: false (JavaScript muss auslesen können)
Secure: automatisch bei HTTPS
```

## 📝 Anpassungen

### Link zur Datenschutzerklärung ändern:

In `cookie-consent.js` Zeile ~44:
```javascript
<a href="/datenschutz">Datenschutzerklärung</a>
```

Ersetze `/datenschutz` mit deiner Datenschutz-Seite.

### Text ändern:

In `cookie-consent.js` die innerHTML-Texte anpassen:
```javascript
banner.innerHTML = `
    <div class="cookie-consent-content">
        <div class="cookie-consent-text">
            <h3>Dein Titel</h3>
            <p>Dein Text...</p>
        </div>
    </div>
`;
```

### Farben anpassen:

In `cookie-consent.css`:
```css
.cookie-consent-banner {
    background: linear-gradient(135deg, #1a3a5c 0%, #2d4a6c 100%);
}

.cookie-btn-accept {
    background: #d4af37;  /* Gold */
    color: #1a3a5c;       /* Navy */
}
```

### Speicherdauer ändern:

In `cookie-consent.js` Zeile 7:
```javascript
const CONSENT_DURATION = 365; // Tage (Standard: 1 Jahr)
```

## 🧪 Testing

### Banner zurücksetzen (für Tests):

**Browser-Konsole:**
```javascript
document.cookie = 'potsdam-cookie-consent=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
location.reload();
```

**Oder:**
- Chrome DevTools → Application → Cookies → `potsdam-cookie-consent` löschen
- Seite neu laden

### Verschiedene Szenarien testen:

1. **Erster Besuch:** Banner wird angezeigt
2. **Nach Zustimmung:** Banner wird nicht mehr angezeigt
3. **Mobile:** Banner responsive
4. **Dark Mode:** Farben passen
5. **Einstellungen:** Detailansicht funktioniert

## 🔒 DSGVO-Konformität

### Was macht den Banner DSGVO-konform:

✅ **Informiert** über alle gesetzten Cookies  
✅ **Transparent** - zeigt Cookie-Namen und Zweck  
✅ **Widerrufbar** - Cookie kann gelöscht werden  
✅ **Vor Nutzung** - Banner erscheint vor Cookie-Setzung  
✅ **Kein Tracking** - nur technisch notwendige Cookies  

### Wichtig für Rechtsanwälte:

- **Datenschutzerklärung** muss alle Cookies auflisten
- **Link zur Datenschutzerklärung** im Banner vorhanden
- **Cookie ohne Opt-In** nur für technisch notwendige Zwecke
- **Tracking-Cookies** brauchen explizite Zustimmung (hier nicht vorhanden)

## 📖 Rechtliche Hinweise

### Technisch notwendige Cookies (ohne Zustimmung erlaubt):

- Session-Cookies (Login, Warenkorb)
- Sprach-Präferenzen
- Dark Mode Einstellung
- Cookie-Consent selbst

### Tracking-Cookies (brauchen Opt-In):

- Google Analytics
- Facebook Pixel
- YouTube-Videos
- Social Media Widgets

**Deine Website verwendet aktuell NUR technisch notwendige Cookies!**

## 🚀 Go-Live Checkliste

Vor Produktivgang:

- [ ] Link zur Datenschutzerklärung korrekt
- [ ] Datenschutzerklärung erwähnt Cookie-Banner
- [ ] Impressum vorhanden
- [ ] Banner auf Mobile getestet
- [ ] Banner im Dark Mode getestet
- [ ] Cookie-Speicherdauer geprüft (365 Tage ok?)

## 📞 Support

Bei Fragen zum Cookie-Banner:
- Dokumentation: `COOKIE-CONSENT.md`
- Code: `src/assets/js/cookie-consent.js`
- Styling: `src/assets/css/cookie-consent.css`

---

**Version:** 1.3.0  
**Status:** Produktionsbereit  
**DSGVO:** Konform (Stand: April 2026)
