# Troubleshooting: Links funktionieren nicht (404-Fehler)

## Problem
Nach der Installation zeigen alle Seiten **404-Fehler**, obwohl die URLs richtig aussehen (`/kontakt/` statt `?page_id=123`).

## Ursache
Die `.htaccess`-Datei fehlt oder hat keine Schreibrechte im WordPress-Root-Verzeichnis.

## Lösungen (in dieser Reihenfolge versuchen)

### 1. setup-pages.php erneut ausführen
Ab Version 1.0.6 erstellt das Setup-Script automatisch die .htaccess-Datei.

```
https://deine-domain.de/wp-content/themes/potsdam-rechtsanwalt/setup-pages.php
```

### 2. Permalinks in WordPress neu speichern
Manchmal reicht es, die Permalinks neu zu speichern:

```
WordPress Admin
→ Einstellungen → Permalinks
→ "Beitragsname" auswählen
→ Änderungen speichern
```

WordPress versucht dann automatisch, die .htaccess zu erstellen.

### 3. .htaccess manuell erstellen
Falls WordPress keine Schreibrechte hat:

**Schritt 1:** Erstelle eine neue Datei mit dem Namen `.htaccess`  
**Schritt 2:** Speichere sie im **WordPress-Root-Verzeichnis** (dort wo auch `wp-config.php` liegt)  
**Schritt 3:** Füge folgenden Inhalt ein:

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

**⚠️ WICHTIG:**
- Die Datei muss genau `.htaccess` heißen (inkl. Punkt am Anfang)
- Sie muss im WordPress-Root liegen, **NICHT** im Theme-Ordner!
- Bei manchen FTP-Programmen ist die Datei versteckt (Einstellung "versteckte Dateien anzeigen")

### 4. WordPress in Unterverzeichnis?
Falls WordPress in einem Unterverzeichnis installiert ist (z.B. `/wordpress/`), passe `RewriteBase` an:

```apache
RewriteBase /wordpress/
```

Ersetze `/wordpress/` durch dein tatsächliches Unterverzeichnis.

### 5. Server-Konfiguration prüfen (Hosting-Provider)

Falls die .htaccess existiert, aber Links trotzdem nicht gehen:

**mod_rewrite nicht aktiviert:**
- Kontaktiere deinen Hosting-Provider
- Bitte um Aktivierung von `mod_rewrite` (Apache-Modul)
- Bei Nginx: Andere Konfiguration erforderlich (siehe unten)

**AllowOverride deaktiviert:**
- Hosting-Provider muss `AllowOverride All` in Apache-Config setzen
- Sonst werden .htaccess-Dateien ignoriert

### 6. Nginx statt Apache?
Falls dein Server **Nginx** verwendet (statt Apache), funktioniert .htaccess nicht!

**Nginx-Konfiguration** (in `/etc/nginx/sites-available/deine-site`):

```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}

location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
}
```

Kontaktiere deinen Hosting-Provider oder Server-Administrator.

---

## Schnelltest: Funktioniert mod_rewrite?

Erstelle eine Test-Datei `test-rewrite.php` im WordPress-Root:

```php
<?php
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "✅ mod_rewrite ist aktiviert!";
    } else {
        echo "❌ mod_rewrite ist NICHT aktiviert!";
    }
} else {
    echo "⚠️ Kann mod_rewrite nicht überprüfen (möglicherweise Nginx oder CGI)";
}
?>
```

Rufe auf: `https://deine-domain.de/test-rewrite.php`

**Lösche die Datei danach wieder!**

---

## Weitere Hilfe

- [WordPress Codex: Using Permalinks](https://wordpress.org/support/article/using-permalinks/)
- [.htaccess-Beispiel im Repository](.htaccess.example)
- [Vollständige Migration Guide](MIGRATION.md)

Bei weiteren Problemen: GitHub Issue erstellen oder Hosting-Provider kontaktieren.
