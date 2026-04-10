# Migration von Joomla zu WordPress - Anleitung

## 1. Rechtsgebiete-Seiten automatisch erstellen

Die 4 Service-Cards verlinken jetzt automatisch zu:
- `/verkehrsrecht/`
- `/familienrecht/`
- `/vertragsrecht/`
- `/immobilienrecht/`

### Schnelle Einrichtung (Empfohlen)

**Variante A: Setup-Script nutzen**

1. Lade `setup-pages.php` auf deinen Server:
   ```
   wp-content/themes/potsdam-rechtsanwalt/setup-pages.php
   ```

2. Rufe im Browser auf:
   ```
   https://deine-domain.de/wp-content/themes/potsdam-rechtsanwalt/setup-pages.php
   ```

3. Das Script erstellt automatisch alle 4 Seiten mit Platzhalter-Inhalten

4. **WICHTIG:** Lösche `setup-pages.php` nach der Verwendung!

**Variante B: Manuell erstellen**

WordPress Admin → **Seiten** → **Erstellen**

Erstelle diese Seiten:
- **Titel:** Verkehrsrecht | **Permalink:** verkehrsrecht
- **Titel:** Familienrecht | **Permalink:** familienrecht
- **Titel:** Vertragsrecht | **Permalink:** vertragsrecht
- **Titel:** Immobilienrecht | **Permalink:** immobilienrecht

## 2. Inhalte aus Joomla übertragen

### Option A: Plugin "FG Joomla to WordPress" (Automatisch)

**Vorteile:**
- Automatischer Import aller Artikel
- Medien werden mit übertragen
- Kategorien werden konvertiert

**Nachteile:**
- Formatierung muss nachgearbeitet werden
- Nicht immer 100% kompatibel

**Installation:**

```
WordPress Admin
→ Plugins → Installieren
→ Suche: "FG Joomla to WordPress"
→ Installieren & Aktivieren
→ Werkzeuge → Import → Joomla (FG)
```

**Einrichtung:**

1. Joomla-Datenbank-Zugangsdaten eingeben
2. Auswählen was importiert werden soll:
   - [x] Artikel
   - [x] Kategorien
   - [x] Medien/Bilder
   - [ ] Benutzer (optional)
3. Import starten
4. Nacharbeiten: Formatierung prüfen, Bilder kontrollieren

### Option B: Manuelles Kopieren (Empfohlen für Anwälte)

**Warum manuell besser ist:**
- Saubere, kontrollierte Inhalte
- Ideal für rechtliche Texte
- Qualitätssicherung bei Übertragung
- Keine veralteten Inhalte

**Vorgehen pro Rechtsgebiet:**

1. **Joomla öffnen:**
   - Melde dich bei http://www.potsdam-rechtsanwalt.de/administrator an
   - Gehe zu Inhalt → Beiträge
   - Öffne z.B. "Verkehrsrecht"-Artikel

2. **Inhalt kopieren:**
   - Wechsle in HTML-Ansicht (wenn möglich)
   - Kopiere den gesamten Text (Strg+A, Strg+C)

3. **WordPress einfügen:**
   - WordPress Admin → Seiten → "Verkehrsrecht" bearbeiten
   - Füge Text ein (Strg+V)
   - Im Block-Editor: Formatierung kontrollieren
   
4. **Bilder übertragen:**
   - Lade Bilder aus Joomla herunter (FTP oder Media Manager)
   - WordPress: Medien → Datei hinzufügen
   - Bilder in Seite einfügen

5. **Veröffentlichen:**
   - Prüfen mit "Vorschau"
   - "Aktualisieren" klicken

6. **Wiederholen für:**
   - Familienrecht
   - Vertragsrecht
   - Immobilienrecht

## 3. Pflichtseiten erstellen

Rechtlich erforderlich nach DSGVO und TMG:

### Impressum

WordPress Admin → Seiten → Erstellen

```
Titel: Impressum
Permalink: impressum

Inhalt:
- Anbieter (Name, Adresse)
- Kontakt (Telefon, E-Mail)
- Berufshaftpflichtversicherung
- Zuständige Rechtsanwaltskammer
- Berufsrechtliche Regelungen
```

**Wichtig:** Nutze einen Impressum-Generator:
- https://www.e-recht24.de/impressum-generator.html
- https://www.anwalt.de/rechtsanwalt/impressum-generator

### Datenschutzerklärung

```
Titel: Datenschutz
Permalink: datenschutz

Inhalt:
- Verantwortlicher
- Datenverarbeitung auf der Website
- Kontaktformular (Zweck, Rechtsgrundlage)
- Rechte der Betroffenen
- Server-Log-Dateien
```

**Wichtig:** Nutze einen DSGVO-Generator:
- https://www.e-recht24.de/muster-datenschutzerklaerung.html
- Aktiviere Plugin "Borlabs Cookie" für Cookie-Consent

### Kontakt-Seite

```
Titel: Kontakt
Permalink: kontakt

Inhalt:
- Anschrift mit Google Maps
- Öffnungszeiten
- Telefon, E-Mail, Fax
- Optional: Kontaktformular (zusätzlich zur Sidebar)
- Anfahrtsbeschreibung (ÖPNV, Parkmöglichkeiten)
```

## 4. Menü einrichten

WordPress Admin → **Design** → **Menüs**

```
Menü erstellen: "Hauptmenü"

Struktur:
├─ Start (Standard-Startseite)
├─ Rechtsgebiete (#) - Eigener Link zu #rechtsgebiete
│  ├─ Verkehrsrecht
│  ├─ Familienrecht
│  ├─ Vertragsrecht
│  └─ Immobilienrecht
├─ Team (falls vorhanden)
├─ Aktuelles (Blog-Seite)
├─ Kontakt
├─ Impressum (im Footer)
└─ Datenschutz (im Footer)
```

**Einrichtung:**
1. Neues Menü anlegen: "Hauptmenü"
2. Seiten hinzufügen (links ankreuzen, "Zum Menü hinzufügen")
3. Per Drag & Drop ordnen (Einrücken = Untermenü)
4. **Position:** Primary Menu
5. Speichern

**Footer-Menü** (optional):
- Separates Menü "Footer" anlegen
- Nur: Impressum, Datenschutz, Kontakt
- Position: Footer Menu

## 5. WordPress-Einstellungen optimieren

### Permalinks einstellen

```
Einstellungen → Permalinks
Auswählen: "Beitragsname"
→ Änderungen speichern
```

Dies erzeugt schöne URLs: `/verkehrsrecht/` statt `/?page_id=123`

### Startseite festlegen

```
Einstellungen → Lesen
→ Homepage zeigt: "Eine statische Seite"
→ Homepage: "Startseite" auswählen
→ Beitragsseite: "Aktuelles" auswählen (falls Blog gewünscht)
→ Speichern
```

### Medien-Einstellungen

```
Einstellungen → Medien
Große Größe: 1920 x 1080 (für Hero-Bilder)
→ Speichern
```

## 6. Theme-Anpassungen im Customizer

WordPress Admin → **Design** → **Customizer**

### Website-Identität
- **Logo hochladen:** Kanzlei-Logo (empfohlen: 250x80 px, PNG)
- **Site Icon:** Favicon (512x512 px)

### Hero-Bereich
- **Hero Überschrift:** "IHRE KANZLEI IN POTSDAM"
- **Hero Text:** "FÜR RECHT, DAS VERTRAUEN SCHAFFT. KOMPETENT & LOKAL."
- **Hero Hintergrundbild:** Potsdam Skyline (1920x500 px)

### Kontakt-Informationen
- **Telefon:** +49 331 xxxxx
- **E-Mail:** info@potsdam-rechtsanwalt.de
- **Adresse:** Straße Nr., 14467 Potsdam

### Social Media
- **LinkedIn:** https://linkedin.com/company/xxx
- **XING:** https://xing.com/profile/xxx

## 7. SEO optimieren (Optional)

**Plugin installieren: Yoast SEO**

```
Plugins → Installieren → "Yoast SEO"
→ Installieren & Aktivieren
```

**Für jede Seite:**
- Meta-Beschreibung (155 Zeichen)
- Fokus-Keyphrase (z.B. "Verkehrsrecht Potsdam")
- SEO-Titel optimieren

## 8. Performance & Sicherheit

### Empfohlene Plugins

**Performance:**
- WP Rocket oder W3 Total Cache (Caching)
- ShortPixel (Bildkompression)

**Sicherheit:**
- Wordfence Security (Firewall)
- UpdraftPlus (Backups)

**DSGVO:**
- Borlabs Cookie (Cookie-Consent)
- Antispam Bee (Spam-Schutz ohne Google)

## 9. Checkliste vor Go-Live

- [ ] Alle 4 Rechtsgebiete-Seiten erstellt
- [ ] Inhalte aus Joomla übertragen
- [ ] Impressum vollständig & aktuell
- [ ] Datenschutzerklärung DSGVO-konform
- [ ] Menü eingerichtet & getestet
- [ ] Hero-Bild hochgeladen (Potsdam Skyline)
- [ ] Logo & Favicon gesetzt
- [ ] Kontaktdaten im Customizer eingetragen
- [ ] Social Media Links konfiguriert
- [ ] Mobile Ansicht getestet
- [ ] Kontaktformular getestet
- [ ] SSL-Zertifikat aktiv (https://)
- [ ] Google Search Console eingerichtet
- [ ] Backup-System eingerichtet

## Support & Hilfe

Bei Fragen zur Migration:
- WordPress-Dokumentation: https://wordpress.org/documentation/
- Theme-Dokumentation: README.md im Theme-Ordner
- GitHub Issues: https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt/issues
