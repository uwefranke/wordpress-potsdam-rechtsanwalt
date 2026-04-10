# Google Fonts - Lokale Installation

## Warum lokale Fonts?

Gemäß DSGVO sollten keine Daten an Google-Server übertragen werden. Daher lädt dieses Theme alle Schriftarten lokal vom eigenen Server.

## Verwendete Schriftarten

- **Playfair Display** (400, 600, 700) - Elegante Serifenschrift für Überschriften
- **Open Sans** (300, 400, 600) - Moderne serifenlose Schrift für Fließtext

## Aktuelle Fonts

Die aktuell enthaltenen Font-Dateien in `src/assets/fonts/` sind funktionsfähig. Für optimale Darstellung empfehlen wir jedoch, die vollständigen Gewichte von Playfair Display herunterzuladen:

### Optimale Fonts herunterladen

**Methode 1: Google Webfonts Helper (Empfohlen)**

1. Besuche: https://gwfh.mranftl.com/fonts
2. **Playfair Display**:
   - Wähle Gewichte: **400**, **600**, **700**
   - Charset: **latin**
   - Modern Browsers auswählen
3. **Open Sans**:
   - Wähle Gewichte: **300**, **400**, **600**
   - Charset: **latin**
   - Modern Browsers auswählen
4. Download ZIP für beide Fonts
5. Entpacke folgende Dateien nach `src/assets/fonts/`:
   ```
   playfair-display-v36-latin-regular.woff2  → playfair-display.woff2
   playfair-display-v36-latin-600.woff2     → playfair-display-600.woff2
   playfair-display-v36-latin-700.woff2     → playfair-display-700.woff2
   open-sans-v40-latin-300.woff2            → open-sans-300.woff2
   open-sans-v40-latin-regular.woff2        → open-sans.woff2
   open-sans-v40-latin-600.woff2            → open-sans-600.woff2
   ```

**Methode 2: PowerShell Script**

```powershell
.\download-fonts.ps1
```

Dieses Script lädt die Fonts automatisch von Google herunter.

## Technische Details

Die Fonts werden über `src/assets/css/fonts.css` eingebunden, welche in `functions.php` geladen wird:

```php
wp_enqueue_style('potsdam-rechtsanwalt-fonts', 
    get_template_directory_uri() . '/assets/css/fonts.css', 
    array(), '1.0.2');
```

## Fallback-Fonts

Falls die WOFF2-Dateien nicht laden, verwendet das Theme System-Fonts:

- **Playfair Display** → Georgia, serif
- **Open Sans** → -apple-system, Arial, sans-serif

## Lizenz

Beide Schriftarten sind unter der **SIL Open Font License** lizenziert und können frei verwendet werden.
