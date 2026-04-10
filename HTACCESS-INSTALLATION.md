# .htaccess Installation - Anleitung

## So löst du das Problem manuell:

### Methode 1: Via FTP direkt erstellen (EMPFOHLEN)

1. **Verbinde per FTP** zu deinem Server (FileZilla, WinSCP, cPanel)
2. **Navigiere zum WordPress-Root-Verzeichnis**  
   (dort wo `wp-config.php`, `wp-admin`, `wp-content` liegen)
3. **Erstelle eine neue Datei** namens `.htaccess` (inkl. Punkt am Anfang!)
4. **Füge folgenden Inhalt ein:**

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

5. **Speichern** und Upload

### Methode 2: Vorlage umbenennen

Falls die Datei [.htaccess.example](.htaccess.example) auf dem Server vorhanden ist:

1. **Via FTP** ins WordPress-Root navigieren
2. **Finde** `.htaccess.example`
3. **Umbenennen** zu `.htaccess`
4. **Fertig!**

### Methode 3: Lokal erstellen + hochladen

1. **Öffne einen Texteditor** (Notepad++, VS Code)
2. **Erstelle neue Datei** mit Inhalt von oben
3. **Speichern als:** `.htaccess` (nicht .txt!)
4. **Via FTP hochladen** ins WordPress-Root

### Methode 4: WordPress automatisch erstellen lassen

Falls du Schreibrechte auf dem Server hast:

```
WordPress Admin
→ Einstellungen → Permalinks
→ "Beitragsname" auswählen
→ Änderungen speichern
```

WordPress versucht dann, die .htaccess selbst zu erstellen.

---

## Nach dem Upload testen:

```
https://lawv8.scriptbb.de/kontakt/
https://lawv8.scriptbb.de/miet-wohnungseigentumsrecht/
```

✅ Sollten jetzt **ohne 404-Fehler** funktionieren!

---

## Versteckte Dateien anzeigen

Falls `.htaccess` nicht sichtbar:

**FileZilla:**
- Server → Versteckte Dateien anzeigen

**WinSCP:**
- Optionen → Einstellungen → Panels → Versteckte Dateien anzeigen

**cPanel File Manager:**
- Einstellungen (oben rechts) → ✓ Versteckte Dateien anzeigen

---

## Problem: .htaccess existiert, aber Links funktionieren nicht?

Dann ist wahrscheinlich **mod_rewrite nicht aktiviert** auf dem Server.

**Lösung:** Kontaktiere deinen Hosting-Provider (scriptbb.de) und bitte um:
- Aktivierung von `mod_rewrite` (Apache-Modul)
- `AllowOverride All` in Apache-Konfiguration

Oder nutze den Test aus [TROUBLESHOOTING.md](TROUBLESHOOTING.md).

