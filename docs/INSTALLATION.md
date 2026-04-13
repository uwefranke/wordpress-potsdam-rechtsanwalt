# Installations- und Migrations-Anleitung

## Von Joomla zu WordPress migrieren

### Schritt 1: Vorbereitung

1. **Backup erstellen**
   - Sichern Sie Ihre aktuelle Joomla-Website
   - Exportieren Sie alle Inhalte, Bilder und Dateien

2. **WordPress installieren**
   - Installieren Sie WordPress auf Ihrem Server
   - Richten Sie eine neue Datenbank ein
   - Führen Sie die WordPress-Installation durch

### Schritt 2: Theme installieren

1. **Theme hochladen**
   ```
   - Navigieren Sie zu wp-content/themes/
   - Erstellen Sie einen Ordner: potsdam-rechtsanwalt
   - Laden Sie alle Theme-Dateien in diesen Ordner hoch
   ```

2. **Theme aktivieren**
   - WordPress Dashboard → Design → Themes
   - Aktivieren Sie "Potsdam Rechtsanwalt"

### Schritt 3: Inhalte migrieren

#### Automatische Migration (empfohlen)

1. **Plugin installieren**
   - Installieren Sie "FG Joomla to WordPress" Plugin
   - Aktivieren Sie das Plugin

2. **Migration durchführen**
   - Gehen Sie zu Werkzeuge → Import → Joomla (FG)
   - Geben Sie die Joomla-Datenbank-Zugangsdaten ein
   - Wählen Sie aus, was importiert werden soll:
     * Artikel
     * Kategorien
     * Medien
     * Menüs
   - Starten Sie den Import

#### Manuelle Migration

1. **Seiten erstellen**
   - Erstellen Sie neue Seiten in WordPress
   - Kopieren Sie Inhalte aus Joomla
   - Verwenden Sie den Block-Editor oder Classic Editor

2. **Bilder hochladen**
   - Medien → Datei hinzufügen
   - Laden Sie alle Bilder aus Joomla hoch
   - Fügen Sie Bilder in Ihre Seiten ein

3. **Menüs einrichten**
   - Design → Menüs
   - Erstellen Sie Hauptmenü und Footer-Menü
   - Ordnen Sie die Positionen zu

### Schritt 4: Theme konfigurieren

1. **Customizer öffnen**
   - Design → Customizer

2. **Hero-Bereich einstellen**
   - Hero-Bereich → Hero Überschrift: "Kompetente Rechtsberatung in Potsdam"
   - Hero Text: Ihr Slogan
   - Hero Hintergrundbild: Potsdam Skyline hochladen

3. **Kontaktinformationen**
   - Kontakt-Informationen → Telefonnummer eintragen
   - E-Mail-Adresse eintragen
   - Adresse eintragen

4. **Logo hochladen**
   - Website-Identität → Logo auswählen
   - Logo hochladen (empfohlen: 300x100px)

### Schritt 5: Wichtige Seiten erstellen

Erstellen Sie folgende Seiten:

1. **Startseite**
   - Titel: "Willkommen"
   - Template: Automatisch (verwendet index.php)

2. **Rechtsgebiete**
   - Verkehrsrecht
   - Familienrecht
   - Vertragsrecht
   - Immobilienrecht

3. **Team**
   - Vorstellung Ihrer Anwälte

4. **Kontakt**
   - Kontaktformular (bereits in Sidebar)
   - Zusätzliche Kontaktinformationen
   - Google Maps einbetten

5. **Impressum** (Pflicht!)
   - Vollständiges Impressum nach TMG

6. **Datenschutz** (Pflicht!)
   - DSGVO-konforme Datenschutzerklärung
   - Generator nutzen: https://datenschutz-generator.de/

### Schritt 6: Menüs konfigurieren

1. **Hauptmenü erstellen**
   ```
   Design → Menüs → Neues Menü erstellen
   Name: Hauptmenü
   
   Seiten hinzufügen:
   - Startseite
   - Rechtsgebiete (mit Untermenü)
     |- Verkehrsrecht
     |- Familienrecht
     |- Vertragsrecht
     |- Immobilienrecht
   - Team
   - Kontakt
   
   Position zuweisen: Hauptmenü
   ```

2. **Footer-Menü erstellen**
   ```
   Name: Footer-Menü
   
   Seiten hinzufügen:
   - Impressum
   - Datenschutz
   - AGB
   
   Position zuweisen: Footer-Menü
   ```

### Schritt 7: Plugins installieren (empfohlen)

1. **Essentiell**
   - Yoast SEO oder Rank Math (SEO)
   - Really Simple SSL (HTTPS)
   - UpdraftPlus (Backup)

2. **Erweiterte Funktionen**
   - WP Mail SMTP (zuverlässiger E-Mail-Versand)
   - Contact Form 7 (erweiterte Formulare)
   - Borlabs Cookie (DSGVO Cookie-Consent)

3. **Performance**
   - WP Super Cache oder W3 Total Cache
   - Autoptimize
   - ShortPixel oder Smush (Bildoptimierung)

### Schritt 8: SEO & Weiterleitungen

1. **Alte URLs weiterleiten**
   - Installieren Sie "Redirection" Plugin
   - Richten Sie 301-Weiterleitungen ein von:
     ```
     alte-joomla-url → neue-wordpress-url
     ```

2. **SEO optimieren**
   - Yoast SEO konfigurieren
   - Meta-Beschreibungen für alle Seiten
   - XML-Sitemap generieren
   - Google Search Console einrichten

### Schritt 9: Bilder und Medien

1. **Hero-Bild hochladen**
   - Medien → Datei hinzufügen
   - Potsdam Skyline-Bild (1920x500px)
   - Im Customizer als Hero-Hintergrundbild setzen

2. **Weitere Bilder**
   - Team-Fotos
   - Office-Bilder
   - Rechtsgebiet-Illustrationen

### Schritt 10: Testen

1. **Funktionstest**
   - [ ] Alle Seiten erreichbar
   - [ ] Navigation funktioniert
   - [ ] Kontaktformular sendet E-Mails
   - [ ] Responsive auf Mobile/Tablet
   - [ ] Bilder werden korrekt angezeigt

2. **Browser-Test**
   - [ ] Chrome
   - [ ] Firefox
   - [ ] Safari
   - [ ] Edge
   - [ ] Mobile Browser

3. **Performance-Test**
   - Google PageSpeed Insights
   - GTmetrix

### Schritt 11: Live-Schaltung

1. **Finale Checks**
   - SSL-Zertifikat aktiv
   - Impressum und Datenschutz vorhanden
   - Cookie-Consent funktioniert
   - Backup erstellt

2. **DNS umstellen**
   - Domain auf neuen WordPress-Server zeigen lassen
   - Alte Joomla-Seite als Backup behalten

3. **Nach der Migration**
   - Alle Links testen
   - 404-Fehler beheben
   - Google Analytics einrichten
   - Google Search Console aktualisieren

## Troubleshooting

### Problem: Kontaktformular sendet keine E-Mails

**Lösung:**
1. WP Mail SMTP Plugin installieren
2. SMTP-Server konfigurieren (z.B. Gmail, SendGrid)
3. Test-E-Mail senden

### Problem: Seite lädt langsam

**Lösung:**
1. Cache-Plugin installieren (WP Super Cache)
2. Bilder komprimieren (ShortPixel)
3. Hosting optimieren oder upgraden

### Problem: Hero-Bild wird nicht angezeigt

**Lösung:**
1. Prüfen Sie den Dateipfad in style.css
2. Laden Sie das Bild nach /assets/images/ hoch
3. Oder setzen Sie es im Customizer

## Support-Kontakte

- **WordPress.org Support**: https://wordpress.org/support/
- **Theme-Dokumentation**: Siehe README.md
- **Joomla zu WordPress Migration**: https://de.wordpress.org/

---

**Wichtig**: Testen Sie alles erst auf einer Staging-Umgebung, bevor Sie live gehen!
