# WordPress Theme-Struktur Best Practices

## ❌ Warum Template-Dateien NICHT in Unterordner gehören

### WordPress-Template-Hierarchie

WordPress sucht Template-Dateien **nur im Root-Verzeichnis** des Themes:

```
wp-content/themes/dein-theme/
├── style.css              ← WordPress erwartet diese hier
├── index.php              ← Fallback-Template (Pflicht)
├── header.php             ← Wird mit get_header() geladen
├── footer.php             ← Wird mit get_footer() geladen
├── sidebar.php            ← Wird mit get_sidebar() geladen
├── page.php               ← Template für Seiten
├── single.php             ← Template für Einzelbeiträge
└── ...
```

**Wenn Sie diese in `templates/` verschieben würden:**
- ❌ WordPress findet sie NICHT
- ❌ Theme funktioniert nicht
- ❌ Nur index.php im Root = Theme kaputt

## ✅ Richtige Theme-Organisation

### Empfohlene Struktur (WordPress Standard):

```
potsdam-rechtsanwalt/
│
├── style.css                    ← Pflicht: Theme-Header
├── functions.php                ← Pflicht: Theme-Funktionen
├── index.php                    ← Pflicht: Fallback-Template
├── screenshot.png               ← Optional: Theme-Screenshot
│
├── header.php                   ← Root: Header-Template
├── footer.php                   ← Root: Footer-Template
├── sidebar.php                  ← Root: Sidebar-Template
│
├── page.php                     ← Root: Seiten-Template
├── single.php                   ← Root: Beitrags-Template
├── archive.php                  ← Root: Archiv-Template
├── search.php                   ← Root: Such-Template
├── 404.php                      ← Root: Fehler-Template
│
├── inc/                         ← ✓ Unterordner: Zusätzliche Funktionen
│   ├── customizer.php           ← Customizer-Einstellungen
│   ├── template-tags.php        ← Helper-Funktionen
│   ├── widgets.php              ← Custom Widgets
│   └── custom-header.php        ← Custom Header
│
├── template-parts/              ← ✓ Unterordner: Wiederverwendbare Teile
│   ├── content.php              ← get_template_part('template-parts/content');
│   ├── content-page.php
│   ├── content-single.php
│   └── content-none.php
│
├── assets/                      ← ✓ Unterordner: Statische Dateien
│   ├── css/
│   │   ├── animations.css
│   │   └── custom.css
│   ├── js/
│   │   └── main.js
│   └── images/
│       └── potsdam-skyline.jpg
│
└── languages/                   ← ✓ Unterordner: Übersetzungen
    ├── de_DE.po
    └── de_DE.mo
```

## 📚 WordPress-Konventionen

### 1. Was MUSS im Root sein:

- ✅ `style.css` - Mit Theme-Header
- ✅ `functions.php` - Theme-Funktionen
- ✅ `index.php` - Fallback für alle Ansichten
- ✅ Alle Template-Dateien (`page.php`, `single.php`, etc.)
- ✅ `header.php`, `footer.php`, `sidebar.php`

### 2. Was in Unterordner KANN:

- ✅ `/inc/` - PHP-Includes (per `require`)
- ✅ `/template-parts/` - Wiederverwendbare Template-Teile (per `get_template_part()`)
- ✅ `/assets/` - CSS, JS, Bilder
- ✅ `/languages/` - Übersetzungsdateien
- ✅ `/woocommerce/` - WooCommerce-Templates

### 3. Wie man Includes nutzt:

**In functions.php:**
```php
// Dateien aus /inc/ laden
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
```

**In Template-Dateien:**
```php
// Template-Parts laden (aus /template-parts/)
get_template_part('template-parts/content', 'page');
get_template_part('template-parts/navigation');
```

## 🎯 Unser aktuelles Theme

### Optimierte Struktur:

```
potsdam-rechtsanwalt/
│
├── style.css                   ← Root (wie es sein muss)
├── functions.php               ← Root + lädt inc/-Dateien
├── index.php                   ← Root
├── header.php                  ← Root
├── footer.php                  ← Root
├── sidebar.php                 ← Root
├── page.php                    ← Root
├── single.php                  ← Root
├── archive.php                 ← Root
├── search.php                  ← Root
├── 404.php                     ← Root
│
├── inc/                        ← NEU: Organisierte Funktionen
│   ├── customizer.php          ← Customizer-Code
│   └── template-tags.php       ← Helper-Funktionen
│
├── assets/                     ← Wie gehabt
│   ├── css/
│   ├── js/
│   └── images/
│
└── Dokumentation...
```

## 💡 Vorteile dieser Struktur:

### ✅ Vorteile:

1. **WordPress-konform** - Funktioniert wie erwartet
2. **Organisiert** - Funktionen in `/inc/`, nicht alles in `functions.php`
3. **Wartbar** - Zusammengehöriger Code ist gruppiert
4. **Standard** - Andere Entwickler kennen die Struktur
5. **Erweiterbar** - Template-Parts können leicht hinzugefügt werden

### 🔧 Was wir verbessert haben:

**Vorher:**
```php
// functions.php (220 Zeilen)
// Alles in einer riesigen Datei
```

**Nachher:**
```php
// functions.php (übersichtlich)
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
// Nur noch Core-Funktionen hier
```

## 📖 Weitere Best Practices

### Child Themes

Wenn Sie ein Child Theme erstellen:
```
potsdam-rechtsanwalt-child/
├── style.css               ← Mit Template: potsdam-rechtsanwalt
├── functions.php           ← Nur Anpassungen
└── page.php                ← Überschreibt Parent-Template
```

### Template-Hierarchie (Beispiel: Seiten)

WordPress sucht in dieser Reihenfolge (alle im Root):
1. `page-{slug}.php` (z.B. `page-kontakt.php`)
2. `page-{id}.php` (z.B. `page-42.php`)
3. `page.php`
4. `index.php`

### Custom Page Templates

Diese MÜSSEN im Root oder in einem speziellen Ordner sein:

**Option 1: Root (klassisch)**
```
template-kontakt.php
```

**Option 2: `/page-templates/` (WordPress 4.7+)**
```
page-templates/template-kontakt.php
```

Mit Header:
```php
<?php
/**
 * Template Name: Kontakt-Seite
 */
```

## 🎓 Zusammenfassung

| Dateityp | Speicherort | Grund |
|----------|-------------|-------|
| Template-Dateien (`*.php`) | **Root** | WordPress-Hierachie |
| `style.css` | **Root** | WordPress-Anforderung (Pflicht) |
| `functions.php` | **Root** | WordPress-Anforderung (Pflicht) |
| PHP-Includes | `/inc/` | Organisation |
| Template-Parts | `/template-parts/` | Wiederverwendbarkeit |
| CSS/JS/Bilder | `/assets/` | Assets |
| Übersetzungen | `/languages/` | i18n |

**Faustregel:** 
- Templates im **Root** lassen ✅
- Funktionen in `/inc/` organisieren ✅
- Assets in `/assets/` ✅
