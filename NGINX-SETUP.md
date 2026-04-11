# Nginx WordPress Setup - Lösung für scriptbb.de

## Problem

Dein Server verwendet **Nginx**, nicht Apache. Daher funktioniert die `.htaccess`-Datei nicht!

Bei Nginx müssen Pretty Permalinks über die **Nginx-Konfiguration** aktiviert werden.

---

## Lösung 1: Hosting-Provider kontaktieren (EMPFOHLEN)

**Kontaktiere scriptbb.de Support** und bitte um:

### Anfrage-Text (kopieren & einfügen):

```
Hallo scriptbb.de Support,

ich nutze WordPress auf meinem Server (lawv8.scriptbb.de) und möchte 
Pretty Permalinks aktivieren (/seitenname/ statt ?page_id=123).

Da der Server Nginx verwendet, funktioniert .htaccess nicht.
Bitte fügt folgende Nginx-Rewrite-Regel hinzu:

location / {
    try_files $uri $uri/ /index.php?$args;
}

Vielen Dank!
```

**Der Support muss diese Regel in `/etc/nginx/sites-available/deine-site` einfügen.**

---

## Lösung 2: Prüfen ob scriptbb.de WordPress-Unterstützung hat

Viele Hosting-Provider haben **WordPress-spezifische Konfigurationen** bereits vorbereitet:

### Im Hosting-Panel prüfen:

1. **Einloggen ins scriptbb.de Control Panel**
2. **Suche nach:**
   - "WordPress optimieren"
   - "Pretty Permalinks"
   - "URL Rewrite"
   - "Nginx Konfiguration"
3. **Eventuell gibt es einen Schalter** zum Aktivieren von WordPress Pretty URLs

---

## Lösung 3: Permalinks auf "Standard" lassen (Workaround)

Falls der Support nicht hilft, kannst du temporär die **Standard-Permalinks** verwenden:

```
WordPress Admin
→ Einstellungen → Permalinks
→ "Einfach" auswählen (?p=123)
→ Speichern
```

**ABER:** Die Service-Card-Links im Theme funktionieren dann nicht! Du müsstest sie anpassen.

---

## Lösung 4: Server-Zugriff vorhanden?

Falls du **SSH-Zugriff** oder **Root-Rechte** hast:

### Nginx-Konfiguration bearbeiten:

```bash
sudo nano /etc/nginx/sites-available/lawv8.scriptbb.de
```

### Füge hinzu:

```nginx
server {
    # ... bestehende Konfiguration ...
    
    root /var/www/html;  # oder dein WordPress-Pfad
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # ... rest ...
}
```

### Nginx neu laden:

```bash
sudo nginx -t                # Konfiguration testen
sudo systemctl reload nginx  # Neu laden
```

Vollständiges Beispiel: [nginx.conf.example](nginx.conf.example)

---

## Test: Funktioniert es?

Nach der Konfigurationsänderung teste:

```
https://lawv8.scriptbb.de/kontakt/
https://lawv8.scriptbb.de/wp-admin/
```

✅ Sollten ohne 404-Fehler funktionieren

---

## Warum funktioniert .htaccess nicht?

| Feature | Apache | Nginx |
|---------|--------|-------|
| .htaccess | ✅ Funktioniert | ❌ Wird ignoriert |
| Dezentrale Config | ✅ Ja | ❌ Nein, nur zentral |
| Rewrite-Rules | In .htaccess | In nginx.conf |

Nginx ist schneller, aber weniger flexibel für einzelne Verzeichnisse.

---

## Weitere Hilfe

- [Nginx WordPress Dokumentation](https://www.nginx.com/resources/wiki/start/topics/recipes/wordpress/)
- [WordPress Codex: Nginx](https://wordpress.org/support/article/nginx/)
- scriptbb.de Support: Ticket erstellen

Bei Fragen: GitHub Issue erstellen oder Support kontaktieren!
