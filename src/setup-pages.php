<?php
/**
 * Setup-Script für WordPress Theme - Vollständiges Setup
 * 
 * Erstellt automatisch:
 * - Alle Seiten basierend auf der Joomla-Website www.potsdam-rechtsanwalt.de
 * - Hauptmenü mit korrekter Struktur
 * - Footer-Menü
 * 
 * VERWENDUNG:
 * 1. Lade diese Datei in das Theme-Verzeichnis hoch
 * 2. Rufe im Browser auf: https://deine-domain.de/wp-content/themes/potsdam-rechtsanwalt/setup-pages.php
 * 3. Lösche die Datei nach der Verwendung aus Sicherheitsgründen!
 */

// WordPress laden
require_once('../../../wp-load.php');

// Prüfen ob Benutzer eingeloggt und Administrator ist
if (!is_user_logged_in() || !current_user_can('administrator')) {
    die('Zugriff verweigert. Bitte als Administrator einloggen.');
}

// HTML-Header
echo '<html><head><meta charset="UTF-8"><title>WordPress Setup</title>';
echo '<style>
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Arial,sans-serif;max-width:1000px;margin:50px auto;padding:30px;background:#f5f5f5;} 
h1{color:#1a3a5c;border-bottom:3px solid #d4af37;padding-bottom:15px;font-size:32px;} 
h2{color:#2d3436;margin-top:30px;font-size:24px;border-left:4px solid #d4af37;padding-left:15px;}
.success{background:#d4edda;color:#155724;padding:15px 20px;border-radius:5px;margin:10px 0;border-left:4px solid #28a745;} 
.error{background:#f8d7da;color:#721c24;padding:15px 20px;border-radius:5px;margin:10px 0;border-left:4px solid #dc3545;} 
.info{background:#d1ecf1;color:#0c5460;padding:15px 20px;border-radius:5px;margin:10px 0;border-left:4px solid #17a2b8;}
.warning{background:#fff3cd;color:#856404;padding:15px 20px;border-radius:5px;margin:10px 0;border-left:4px solid #ffc107;}
a{color:#d4af37;text-decoration:none;font-weight:600;} a:hover{text-decoration:underline;color:#1a3a5c;}
.summary{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);margin:25px 0;}
ul{line-height:2;}
.btn{background:#1a3a5c;color:#fff;padding:12px 24px;border-radius:4px;display:inline-block;margin:10px 5px 0 0;text-decoration:none;}
.btn:hover{background:#d4af37;color:#1a3a5c;}
</style></head><body>';

echo '<h1>🚀 WordPress Theme - Vollständiges Setup</h1>';
echo '<p style="font-size:16px;color:#666;">Basierend auf der Joomla-Website <strong>www.potsdam-rechtsanwalt.de</strong></p>';

// --- SEITEN DEFINIEREN ---

// Parent-Seiten (für Menü-Hierarchie)
$parent_pages = array(
    'rechtsgebiete' => array(
        'title'   => 'Rechtsgebiete',
        'slug'    => 'rechtsgebiete',
        'content' => '<h2>Rechtsgebiete</h2><p>Wählen Sie eines der Rechtsgebiete für detaillierte Informationen.</p>',
    ),
    'informationen' => array(
        'title'   => 'Informationen',
        'slug'    => 'informationen',
        'content' => '<h2>Informationen</h2><p>Informationen über die Kanzl ei.</p>',
    ),
);

// Alle Seiten
$pages = array(
    // Rechtsgebiete (Unterseiten)
    array(
        'title'   => 'Miet- / Wohnungseigentumsrecht',
        'slug'    => 'miet-wohnungseigentumsrecht',
        'content' => '<h2>Miet- und Wohnungseigentumsrecht in Potsdam</h2>
<p>Ich berate Sie umfassend und kompetent auf den Feldern des:</p>
<ul>
<li><strong>Wohnungsmietrechts</strong></li>
<li><strong>Geschäftsraummietrechts</strong></li>
<li><strong>Gewerberaummietrechts</strong></li>
<li><strong>Kündigungen</strong> - Durchsetzung und Abwehr</li>
<li><strong>Mietmängel und Mietminderung</strong> - Durchsetzung und Abwehr von Ansprüchen</li>
<li><strong>Schadensersatzansprüche</strong> - Durchsetzung und Abwehr</li>
<li><strong>Forderungsmanagements</strong></li>
<li><strong>Pachtrechts</strong></li>
</ul>
<p>Kontaktieren Sie mich für eine umfassende Beratung in allen mietrechtlichen Angelegenheiten.</p>',
        'parent'  => 'rechtsgebiete',
    ),
    array(
        'title'   => 'Grundstücks- / Immobilienrecht',
        'slug'    => 'grundstuecks-immobilienrecht',
        'content' => '<h2>Grundstücks- und Immobilienrecht</h2>
<p><strong>Kurz gesagt: Rund um die Immobilie!</strong></p>
<p>Bei Fragen rund um Förderdarlehen der Investitionsbank des Landes Brandenburg (ILB) oder der Investitionsbank Berlin (IBB) stehe ich Ihnen helfend zur Seite.</p>
<p>Als Kaufmann in der Grundstücks- und Wohnungswirtschaft verfüge ich über fundierte praktische Erfahrung im Immobilienbereich und bin Mitglied der Arbeitsgemeinschaft Mietrecht und Immobilien im Deutschen Anwaltsverein (DAV).</p>
<h3>Leistungen:</h3>
<ul>
<li>Immobilienkaufverträge - Gestaltung und Prüfung</li>
<li>Grundstücksrecht und Nachbarschaftsrecht</li>
<li>Grundbucheintragungen</li>
<li>Förderdarlehen (ILB, IBB)</li>
<li>Wohnungseigentümergemeinschaften</li>
</ul>
<p>Die praktische Erfahrung hilft mir, Ihre Ansprüche schnell und effizient durchzusetzen.</p>',
        'parent'  => 'rechtsgebiete',
    ),
    array(
        'title'   => 'Baurecht',
        'slug'    => 'baurecht',
        'content' => '<h2>Baurecht</h2>
<p>Kompetente Beratung in allen baurechlichen Angelegenheiten:</p>
<ul>
<li>Bauverträge nach BGB und VOB</li>
<li>Baumängel und Gewährleistung</li>
<li>Architekten- und Ingenieurrecht</li>
<li>Bauplanungsrecht</li>
<li>Nachbarschaftsrecht</li>
</ul>
<p>Die praktische Erfahrung hilft mir, Ihre Ansprüche schnell und effizient durchzusetzen.</p>',
        'parent'  => 'rechtsgebiete',
    ),
    array(
        'title'   => 'BU / Erwerbsminderungsrente',
        'slug'    => 'bu-erwerbsminderungsrente',
        'content' => '<h2>Berufsunfähigkeit und Erwerbsminderungsrente</h2>
<p>Unterstützung bei Anträgen und Klagen zur:</p>
<ul>
<li>Berufsunfähigkeitsrente</li>
<li>Erwerbsminderungsrente</li>
<li>Durchsetzung von Ansprüchen gegenüber Versicherungen</li>
<li>Widerspruchsverfahren</li>
<li>Sozialgerichtliche Vertretung</li>
</ul>
<p>Ich helfe Ihnen, Ihre Ansprüche durchzusetzen.</p>',
        'parent'  => 'rechtsgebiete',
    ),
    
    // Informationsseiten (Unterseiten)
    array(
        'title'   => 'Kontakt',
        'slug'    => 'kontakt',
        'content' => '<h2>Kontakt</h2>
<p><strong>Rechtsanwalt Matthias Lange</strong><br>
Schornsteinfegergasse 5<br>
14482 Potsdam-Babelsberg</p>
<p><strong>Telefon:</strong> (0331) 74 09 86 0<br>
<strong>Fax:</strong> (0331) 74 09 86 1<br>
<strong>E-Mail:</strong> <a href="mailto:lange@potestas.de">lange@potestas.de</a></p>
<h3>Öffnungszeiten</h3>
<p>Nach Vereinbarung</p>
<h3>Anfahrt</h3>
<p>Parkplatz auf dem Innenhof vorhanden</p>',
        'parent'  => 'informationen',
    ),
    array(
        'title'   => 'Über mich',
        'slug'    => 'ueber-mich',
        'content' => '<h2>Rechtsanwalt Matthias Lange</h2>
<h3>Beruflicher Werdegang</h3>
<p>Rechtsanwalt Matthias Lange war langjährig bei der Investitionsbank Berlin (IBB) tätig. Er ist Kaufmann in der Grundstücks- und Wohnungswirtschaft, verfügt über fundierte praktische Erfahrung im Immobilienbereich und ist Mitglied der Arbeitsgemeinschaft Mietrecht und Immobilien im Deutschen Anwaltsverein (DAV).</p>
<p>Die praktische Erfahrung hilft ihm, Ihre Ansprüche schnell und effizient durchzusetzen.</p>',
        'parent'  => 'informationen',
    ),
    
    // Standalone-Seiten
    array(
        'title'   => 'Impressum',
        'slug'    => 'impressum',
        'content' => '<h2>Impressum</h2>
<p><strong>Angaben gemäß § 5 TMG:</strong></p>
<p>Rechtsanwalt Matthias Lange<br>
Schornsteinfegergasse 5<br>
14482 Potsdam-Babelsberg</p>
<p><strong>Kontakt:</strong><br>
Telefon: (0331) 74 09 86 0<br>
E-Mail: lange@potestas.de</p>
<p><em style="color:#856404;">⚠️ Bitte passen Sie diese Seite mit Ihren vollständigen Impressumsdaten an (Generator: e-recht24.de).</em></p>',
        'parent'  => null,
    ),
    array(
        'title'   => 'Datenschutz',
        'slug'    => 'datenschutz',
        'content' => '<h2>Datenschutzerklärung</h2>
<p><em style="color:#dc3545;">⚠️ Diese Seite muss mit einer DSGVO-konformen Datenschutzerklärung gefüllt werden!</em></p>
<p>Nutzen Sie einen Generator wie:</p>
<ul>
<li><a href="https://www.e-recht24.de/muster-datenschutzerklaerung.html" target="_blank">→ e-recht24.de Datenschutz-Generator</a></li>
<li><a href="https://www.anwalt.de/rechtsanwalt/datenschutz-generator" target="_blank">→ anwalt.de Generator</a></li>
</ul>',
        'parent'  => null,
    ),
);

// --- SEITEN ERSTELLEN ---

$created_pages = array();
$created = 0;
$skipped = 0;

echo '<h2>📄 Seiten erstellen</h2>';

// 1. Parent-Seiten erstellen
echo '<h3>Parent-Seiten (Menü-Kategorien)</h3>';
foreach ($parent_pages as $key => $parent_data) {
    $existing = get_page_by_path($parent_data['slug']);
    
    if ($existing) {
        echo '<div class="info">ℹ️ "' . $parent_data['title'] . '" existiert bereits</div>';
        $created_pages[$key] = $existing->ID;
        $skipped++;
        continue;
    }
    
    $page_id = wp_insert_post(array(
        'post_title'    => $parent_data['title'],
        'post_name'     => $parent_data['slug'],
        'post_content'  => $parent_data['content'],
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
    ));
    
    if ($page_id && !is_wp_error($page_id)) {
        echo '<div class="success">✓ "' . $parent_data['title'] . '" erstellt</div>';
        $created_pages[$key] = $page_id;
        $created++;
    } else {
        echo '<div class="error">✗ Fehler: "' . $parent_data['title'] . '"</div>';
    }
}

// 2. Alle Seiten erstellen
echo '<h3>Unterseiten</h3>';
$created_page_ids = array();

foreach ($pages as $page_data) {
    $existing_page = get_page_by_path($page_data['slug']);
    
    if ($existing_page) {
        echo '<div class="info">⚠️ "' . $page_data['title'] . '" existiert bereits</div>';
        $created_page_ids[$page_data['slug']] = $existing_page->ID;
        $skipped++;
        continue;
    }
    
    // Parent-ID ermitteln
    $parent_id = 0;
    if (isset($page_data['parent']) && isset($created_pages[$page_data['parent']])) {
        $parent_id = $created_pages[$page_data['parent']];
    }
    
    $page_id = wp_insert_post(array(
        'post_title'    => $page_data['title'],
        'post_name'     => $page_data['slug'],
        'post_content'  => $page_data['content'],
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
        'post_parent'   => $parent_id,
    ));
    
    if ($page_id && !is_wp_error($page_id)) {
        echo '<div class="success">✓ "' . $page_data['title'] . '" erstellt | ';
        echo '<a href="' . get_permalink($page_id) . '" target="_blank">Ansehen</a> | ';
        echo '<a href="' . admin_url('post.php?post=' . $page_id . '&action=edit') . '" target="_blank">Bearbeiten</a></div>';
        $created_page_ids[$page_data['slug']] = $page_id;
        $created++;
    } else {
        echo '<div class="error">✗ Fehler: "' . $page_data['title'] . '"</div>';
    }
}

// --- MENÜ ERSTELLEN ---

echo '<h2>📱 Menü erstellen</h2>';

$menu_name = 'Hauptmenü';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
    echo '<div class="success">✓ Menü "' . $menu_name . '" erstellt</div>';
} else {
    $menu_id = $menu_exists->term_id;
    echo '<div class="info">ℹ️ Menü "' . $menu_name . '" existiert bereits. Erweitere es...</div>';
}

if ($menu_id) {
    // Startseite hinzufügen
    $home_page = get_page_by_path('startseite');
    if (!$home_page) {
        $home_page = get_page_by_path('home');
    }
    if ($home_page) {
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Start',
            'menu-item-object-id' => $home_page->ID,
            'menu-item-object' => 'page',
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 1,
        ));
    }
    
    // Rechtsgebiete (Parent)
    if (isset($created_pages['rechtsgebiete'])) {
        $rechtsgebiete_item = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Rechtsgebiete',
            'menu-item-object-id' => $created_pages['rechtsgebiete'],
            'menu-item-object' => 'page',
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 2,
        ));
        
        // Unterseiten
        $rechtsgebiete_children = array(
            'miet-wohnungseigentumsrecht' => 'Miet- / Wohnungseigentumsrecht',
            'grundstuecks-immobilienrecht' => 'Grundstücks- / Immobilienrecht',
            'baurecht' => 'Baurecht',
            'bu-erwerbsminderungsrente' => 'BU / Erwerbsminderungsrente'
        );
        $pos = 1;
        foreach ($rechtsgebiete_children as $child_slug => $child_title) {
            if (isset($created_page_ids[$child_slug])) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $child_title,
                    'menu-item-object-id' => $created_page_ids[$child_slug],
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $rechtsgebiete_item,
                    'menu-item-position' => $pos++,
                ));
            }
        }
    }
    
    // Informationen (Parent)
    if (isset($created_pages['informationen'])) {
        $info_item = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Informationen',
            'menu-item-object-id' => $created_pages['informationen'],
            'menu-item-object' => 'page',
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 3,
        ));
        
        // Unterseiten
        $info_children = array(
            'kontakt' => 'Kontakt',
            'ueber-mich' => 'Über mich'
        );
        $pos = 1;
        foreach ($info_children as $child_slug => $child_title) {
            if (isset($created_page_ids[$child_slug])) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $child_title,
                    'menu-item-object-id' => $created_page_ids[$child_slug],
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $info_item,
                    'menu-item-position' => $pos++,
                ));
            }
        }
    }
    
    // Menü-Position zuweisen (Primary Menu)
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    echo '<div class="success">✓ Menü-Struktur erstellt und als "Primary Menu" zugewiesen</div>';
}

// Footer-Menü
$footer_menu_name = 'Footer Menu';
$footer_menu_exists = wp_get_nav_menu_object($footer_menu_name);

if (!$footer_menu_exists) {
    $footer_menu_id = wp_create_nav_menu($footer_menu_name);
    
    if ($footer_menu_id) {
        // Impressum und Datenschutz hinzufügen
        if (isset($created_page_ids['impressum'])) {
            wp_update_nav_menu_item($footer_menu_id, 0, array(
                'menu-item-title' => 'Impressum',
                'menu-item-object-id' => $created_page_ids['impressum'],
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ));
        }
        if (isset($created_page_ids['datenschutz'])) {
            wp_update_nav_menu_item($footer_menu_id, 0, array(
                'menu-item-title' => 'Datenschutz',
                'menu-item-object-id' => $created_page_ids['datenschutz'],
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ));
        }
        
        // Footer Menu Position zuweisen
        $locations = get_theme_mod('nav_menu_locations');
        $locations['footer'] = $footer_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        
        echo '<div class="success">✓ Footer-Menü erstellt (Impressum, Datenschutz)</div>';
    }
} else {
    echo '<div class="info">ℹ️ Footer-Menü existiert bereits</div>';
}

// --- ZUSAMMENFASSUNG ---

echo '<div class="summary">';
echo '<h2>✅ Setup abgeschlossen!</h2>';
echo '<p><strong>Erstellte Seiten:</strong> ' . $created . '</p>';
echo '<p><strong>Übersprungene Seiten:</strong> ' . $skipped . ' (existierten bereits)</p>';
echo '<p><strong>Menü:</strong> Hauptmenü mit Hierarchie erstellt</p>';
echo '</div>';

echo '<div class="warning">';
echo '<h3>⚠️ WICHTIG - Nächste Schritte:</h3>';
echo '<ol>';
echo '<li><strong>Diese Datei JETZT löschen!</strong> (Sicherheitsrisiko)</li>';
echo '<li><strong>Impressum anpassen:</strong> Vollständige Daten eintragen</li>';
echo '<li><strong>Datenschutz erstellen:</strong> DSGVO-Generator nutzen</li>';
echo '<li><strong>Inhalte aus Joomla übertragen:</strong> Texte pro Seite kopieren</li>';
echo '<li><strong>Customizer konfigurieren:</strong> Logo, Hero-Bild, Kontaktdaten</li>';
echo '</ol>';
echo '</div>';

echo '<p style="text-align:center;margin-top:30px;">';
echo '<a href="' . admin_url() . '" class="btn">→ Zum WordPress-Admin</a> ';
echo '<a href="' . admin_url('nav-menus.php') . '" class="btn">→ Menüs bearbeiten</a>';
echo '</p>';

echo '</body></html>';
