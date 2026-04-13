# WordPress Theme-Paket erstellen

## Übersicht

Um das Theme in WordPress installieren zu können, muss es als ZIP-Datei verpackt werden. Es gibt mehrere Möglichkeiten, dies zu tun.

## Methode 1: Automatisches PowerShell-Skript (Empfohlen)

### Schritt 1: Skript ausführen

1. Öffnen Sie PowerShell im Theme-Verzeichnis
2. Führen Sie aus:
   ```powershell
   .\scripts\create-theme-package.ps1
   ```

Das Skript erstellt automatisch eine `potsdam-rechtsanwalt-theme.zip` im übergeordneten Verzeichnis.

### Was das Skript macht:

- ✓ Sammelt alle notwendigen Theme-Dateien
- ✓ Schließt unnötige Dateien aus (.git, node_modules, etc.)
- ✓ Erstellt eine optimierte ZIP-Datei
- ✓ Zeigt die Dateigröße an
- ✓ Bietet Option zum Öffnen des Ordners

## Methode 2: Manuell mit PowerShell

```powershell
# Im Theme-Verzeichnis ausführen
$themeName = "potsdam-rechtsanwalt"
$outputPath = "..\$themeName-theme.zip"

# Temporäres Verzeichnis erstellen
$temp = "$env:TEMP\$themeName"
New-Item -ItemType Directory -Path $temp -Force

# Dateien kopieren (ohne .git, etc.)
Get-ChildItem -Path . -Exclude ".git",".github","*.ps1" | Copy-Item -Destination $temp -Recurse

# ZIP erstellen
Compress-Archive -Path "$temp\*" -DestinationPath $outputPath -Force

# Aufräumen
Remove-Item $temp -Recurse -Force

Write-Host "ZIP erstellt: $outputPath"
```

## Methode 3: Manuell mit Windows Explorer

1. **Vorbereitung**
   - Erstellen Sie einen neuen Ordner: `potsdam-rechtsanwalt`
   - Kopieren Sie alle Theme-Dateien hinein

2. **Zu kopierende Dateien/Ordner:**
   ```
   ✓ style.css
   ✓ functions.php
   ✓ header.php
   ✓ footer.php
   ✓ index.php
   ✓ sidebar.php
   ✓ page.php
   ✓ single.php
   ✓ archive.php
   ✓ search.php
   ✓ 404.php
   ✓ assets/ (kompletter Ordner)
   ✓ README.md
   ✓ INSTALLATION.md
   ✓ screenshot.png (falls vorhanden)
   ```

3. **NICHT kopieren:**
   ```
   ✗ .git/
   ✗ .github/
   ✗ .gitignore
   ✗ scripts/
      ✗ create-theme-package.ps1
   ✗ config/
   ✗ PACKAGE-ANLEITUNG.md
   ✗ node_modules/
   ```

4. **ZIP erstellen**
   - Rechtsklick auf den Ordner `potsdam-rechtsanwalt`
   - "Senden an" → "ZIP-komprimierter Ordner"
   - ODER: Ordner auswählen, dann im Ribbon "Freigeben" → "Zip"
   - Umbenennen in: `potsdam-rechtsanwalt-theme.zip`

## Methode 4: Mit 7-Zip oder WinRAR

Falls installiert:

1. **Ordner vorbereiten** (siehe Methode 3)
2. **Mit 7-Zip:**
   - Rechtsklick auf Ordner
   - "7-Zip" → "Zu einem Archiv hinzufügen..."
   - Format: ZIP
   - Komprimierung: Normal oder Maximum
   - OK klicken

3. **Mit WinRAR:**
   - Rechtsklick auf Ordner
   - "Zu einem Archiv hinzufügen..."
   - Format: ZIP
   - OK klicken

## Wichtige Hinweise

### ✅ Checkliste vor dem Verpacken

- [ ] `style.css` enthält Theme-Header
- [ ] Alle PHP-Dateien sind vorhanden
- [ ] `functions.php` ist korrekt
- [ ] Assets-Ordner mit JS und CSS ist enthalten
- [ ] Keine .git oder IDE-Dateien enthalten
- [ ] Optional: `screenshot.png` hinzugefügt (1200x900px)

### 📏 ZIP-Struktur

Die ZIP-Datei sollte folgende Struktur haben:

```
potsdam-rechtsanwalt-theme.zip
├── 404.php
├── archive.php
├── assets/
│   ├── css/
│   │   ├── animations.css
│   │   └── custom.css
│   ├── images/
│   │   └── README.md
│   └── js/
│       └── main.js
├── footer.php
├── functions.php
├── header.php
├── index.php
├── INSTALLATION.md
├── page.php
├── README.md
├── screenshot.png (optional)
├── search.php
├── sidebar.php
├── single.php
└── style.css
```

### ⚠️ Häufige Fehler vermeiden

1. **Doppelter Ordner**: 
   - ❌ Falsch: `theme.zip/potsdam-rechtsanwalt/potsdam-rechtsanwalt/style.css`
   - ✓ Richtig: `theme.zip/potsdam-rechtsanwalt/style.css`
   - **Lösung**: Ordnerinhalt zippen, nicht den Ordner selbst

2. **Fehlende style.css**:
   - WordPress erkennt Theme nur mit gültiger `style.css` im Root

3. **.git-Ordner eingeschlossen**:
   - Macht ZIP unnötig groß
   - Kann Sicherheitsprobleme verursachen

## Installation in WordPress

### Nach dem Erstellen der ZIP-Datei:

1. **WordPress-Dashboard öffnen**
2. Navigieren zu: **Design → Themes**
3. Klicken auf: **Installieren** (oben)
4. Klicken auf: **Theme hochladen**
5. **ZIP-Datei auswählen**
6. Klicken auf: **Jetzt installieren**
7. Nach Installation: **Aktivieren**

### Alternative: FTP-Upload

Falls ZIP-Upload nicht funktioniert:

1. ZIP-Datei lokal entpacken
2. Per FTP verbinden
3. Ordner hochladen nach: `/wp-content/themes/`
4. In WordPress: Design → Themes → Theme aktivieren

## Troubleshooting

### Problem: "Das Theme fehlt die Stylesheet style.css"

**Ursache**: ZIP-Struktur falsch

**Lösung**:
- ZIP-Datei öffnen
- Prüfen: Liegt `style.css` direkt im Root?
- Falls nicht: Neu verpacken ohne verschachtelten Ordner

### Problem: "ZIP-Upload schlägt fehl"

**Mögliche Ursachen:**
1. Datei zu groß (Server-Limit)
2. Falsches Format

**Lösung**:
1. Überprüfen Sie die `upload_max_filesize` in PHP
2. Verwenden Sie FTP-Upload als Alternative
3. Komprimieren Sie Assets (Bilder optimieren)

### Problem: Theme wird nicht erkannt

**Lösung**:
- Prüfen Sie den Theme-Header in `style.css`
- Muss mit `/*` beginnen und `Theme Name:` enthalten
- Stellen Sie sicher, dass alle Pflichtdateien vorhanden sind

## Validierung

Vor der Distribution sollten Sie das Theme validieren:

1. **Theme Check Plugin**
   - Installieren Sie "Theme Check" in WordPress
   - Prüfen Sie Ihr Theme auf Fehler

2. **Manuelle Prüfung**
   ```
   ✓ Theme aktiviert sich ohne Fehler
   ✓ Keine PHP-Warnings oder Errors
   ✓ Alle Seiten werden korrekt angezeigt
   ✓ Responsive Design funktioniert
   ✓ Formulare funktionieren
   ```

## Versioning

Für Updates sollten Sie Versionsnummern verwenden:

```
potsdam-rechtsanwalt-theme-v1.0.zip
potsdam-rechtsanwalt-theme-v1.1.zip
potsdam-rechtsanwalt-theme-v2.0.zip
```

Aktualisieren Sie die Version auch in `style.css`:
```css
/*
Theme Name: Potsdam Rechtsanwalt
Version: 1.0
*/
```

## Weitergabe

Falls Sie das Theme weitergeben möchten:

1. Stellen Sie sicher, dass alle Lizenzen korrekt sind
2. Fügen Sie eine `LICENSE.txt` hinzu (GPL)
3. Dokumentation ist vollständig
4. Kontaktinformationen aktualisieren
5. Testen Sie die Installation auf frischer WordPress-Installation

---

**Tipp**: Bewahren Sie die ZIP-Datei als Backup auf! So können Sie das Theme jederzeit wiederherstellen.
