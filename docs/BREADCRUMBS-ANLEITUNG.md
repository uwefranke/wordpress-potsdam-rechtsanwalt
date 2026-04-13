# Rank Math Breadcrumbs - Anleitung

## ✅ Automatische Integration

Die Breadcrumbs sind bereits in allen Templates integriert:

- **page.php** - Alle statischen Seiten
- **single.php** - Alle Beiträge  
- **archive.php** - Alle Archiv-Seiten

## 🔧 Rank Math Plugin installieren

Damit die Breadcrumbs funktionieren, muss das **Rank Math SEO** Plugin installiert sein:

1. **WordPress-Admin** → Plugins → Installieren
2. Nach "**Rank Math**" suchen
3. **Rank Math SEO** installieren und aktivieren

## ⚙️ Breadcrumbs in Rank Math aktivieren

Nach Plugin-Installation:

1. **Rank Math** → Allgemeine Einstellungen → Breadcrumbs
2. Checkbox **"Breadcrumbs aktivieren"** setzen
3. Einstellungen anpassen:
   - **Trennzeichen**: z.B. `/` oder `→` oder `›`
   - **Startseite anzeigen**: ✓
   - **Verstecke Breadcrumbs auf Startseite**: ✓ (empfohlen)

## 🎨 Design-Anpassungen (optional)

Die Breadcrumbs haben bereits ein Basis-Styling:

```css
/* Aktuelles Styling in style.css */
.breadcrumbs {
    margin-bottom: 20px;
    font-size: 14px;
    color: #888;
}
```

### Erweiterte Anpassungen

Wenn du das Design ändern möchtest, füge in `src/style.css` hinzu:

```css
/* Breadcrumbs Links */
.breadcrumbs a {
    color: var(--color-navy);
    text-decoration: none;
}

.breadcrumbs a:hover {
    color: var(--color-gold);
}

/* Aktueller Breadcrumb (nicht klickbar) */
.breadcrumbs .last {
    color: #666;
    font-weight: 600;
}

/* Trennzeichen */
.breadcrumbs .separator {
    margin: 0 8px;
    color: #ccc;
}
```

## 📍 Position der Breadcrumbs

Die Breadcrumbs erscheinen **oberhalb** des Seitentitels:

```
Startseite / Rechtsgebiete / Mietrecht
───────────────────────────────────────
        [Seitentitel H1]
```

Falls du die Position ändern möchtest, verschiebe den Code in den Templates.

## 🔄 Alternative: Shortcode

Rank Math bietet auch einen Shortcode für manuelle Platzierung:

```
[rank_math_breadcrumb]
```

Dieser kann in jedem Beitrag/Seite oder Widget verwendet werden.

## ❌ Ohne Rank Math

Falls das Rank Math Plugin **nicht** installiert ist:

- Die Breadcrumbs werden **nicht** angezeigt
- Es gibt **keine** Fehlermeldung
- Das Theme funktioniert normal weiter

Die Integration ist durch `if (function_exists('rank_math_the_breadcrumbs'))` abgesichert.

## 📊 Beispiel-Ausgabe

**Homepage:** (keine Breadcrumbs)

**Unterseite:**
```
Startseite / Rechtsgebiete / Mietrecht
```

**Beitrag:**
```
Startseite / Blog / Neuigkeiten / Artikel-Titel
```

**Archiv:**
```
Startseite / Kategorie: Verkehrsrecht
```

## 🎯 Best Practices

- ✅ Breadcrumbs auf **allen** Seiten außer Homepage
- ✅ Klare Hierarchie (max. 4-5 Ebenen)
- ✅ Descriptive Namen statt URLs
- ✅ Schema.org Markup (macht Rank Math automatisch)
- ✅ Mobile-friendly (responsive)

## 🔗 Weitere Infos

Rank Math Dokumentation:  
https://rankmath.com/kb/configure-breadcrumbs/
