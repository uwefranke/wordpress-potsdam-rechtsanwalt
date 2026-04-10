<?php
/**
 * Setup-Script für Rechtsgebiete-Seiten
 * 
 * Führe dieses Script einmalig aus, um die 4 Rechtsgebiete-Seiten anzulegen.
 * 
 * VERWENDUNG:
 * 1. Lade diese Datei in das Theme-Verzeichnis hoch
 * 2. Rufe im Browser auf: https://deine-domain.de/wp-content/themes/potsdam-rechtsanwalt/setup-pages.php
 * 3. Lösche die Datei nach der Verwendung aus Sicherheitsgründen
 */

// WordPress laden
require_once('../../../wp-load.php');

// Prüfen ob Benutzer eingeloggt und Administrator ist
if (!is_user_logged_in() || !current_user_can('administrator')) {
    die('Zugriff verweigert. Bitte als Administrator einloggen.');
}

// Rechtsgebiete-Seiten definieren
$pages = array(
    array(
        'title'   => 'Verkehrsrecht',
        'slug'    => 'verkehrsrecht',
        'content' => '<h2>Verkehrsrecht in Potsdam</h2>
<p>Wir unterstützen Sie bei allen verkehrsrechtlichen Angelegenheiten:</p>
<ul>
<li><strong>Verkehrsunfälle:</strong> Schadensregulierung, Unfallschaden, Schmerzensgeld</li>
<li><strong>Bußgeldverfahren:</strong> Verteidigung gegen Bußgeldbescheide</li>
<li><strong>Führerscheinentzug:</strong> MPU-Beratung, Wiedererlangung der Fahrerlaubnis</li>
<li><strong>Verkehrsstrafrecht:</strong> Fahren ohne Fahrerlaubnis, Trunkenheit im Verkehr</li>
</ul>
<p>Kontaktieren Sie uns für eine kostenlose Erstberatung.</p>',
    ),
    array(
        'title'   => 'Familienrecht',
        'slug'    => 'familienrecht',
        'content' => '<h2>Familienrecht in Potsdam</h2>
<p>Einfühlsame rechtliche Begleitung in schwierigen familiären Situationen:</p>
<ul>
<li><strong>Scheidung:</strong> Einvernehmliche und streitige Scheidungen</li>
<li><strong>Sorgerecht:</strong> Beratung zu elterlicher Sorge und Umgangsrecht</li>
<li><strong>Unterhalt:</strong> Kindesunterhalt, Ehegattenunterhalt, Trennungsunterhalt</li>
<li><strong>Vermögensauseinandersetzung:</strong> Zugewinnausgleich, Hausratsteilung</li>
</ul>
<p>Wir vertreten Ihre Interessen mit Fachwissen und Empathie.</p>',
    ),
    array(
        'title'   => 'Vertragsrecht',
        'slug'    => 'vertragsrecht',
        'content' => '<h2>Vertragsrecht in Potsdam</h2>
<p>Professionelle Unterstützung bei allen vertraglichen Angelegenheiten:</p>
<ul>
<li><strong>Vertragsgestaltung:</strong> Erstellung individueller Verträge</li>
<li><strong>Vertragsprüfung:</strong> Analyse und Bewertung bestehender Verträge</li>
<li><strong>Vertragsverhandlung:</strong> Durchsetzung Ihrer Interessen</li>
<li><strong>Vertragsstreitigkeiten:</strong> Gerichtliche und außergerichtliche Vertretung</li>
</ul>
<p>Vermeiden Sie teure Fehler - lassen Sie Verträge vom Anwalt prüfen.</p>',
    ),
    array(
        'title'   => 'Immobilienrecht',
        'slug'    => 'immobilienrecht',
        'content' => '<h2>Immobilienrecht in Potsdam</h2>
<p>Kompetente Beratung rund um Ihre Immobilie:</p>
<ul>
<li><strong>Immobilienkauf/-verkauf:</strong> Kaufvertragsgestaltung, Kaufvertragsprüfung</li>
<li><strong>Mietrecht:</strong> Mietverträge, Mietminderung, Kündigungsschutz</li>
<li><strong>Wohnungseigentumsrecht:</strong> Eigentümerversammlungen, Instandhaltung</li>
<li><strong>Grundstücksrecht:</strong> Grundbucheintragungen, Nachbarschaftsrecht</li>
</ul>
<p>Schützen Sie Ihr Eigentum mit fachkundiger rechtlicher Beratung.</p>',
    ),
);

echo '<html><head><meta charset="UTF-8"><title>Seiten-Setup</title>';
echo '<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;} 
h1{color:#1a3a5c;} .success{background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;} 
.error{background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;} 
.info{background:#d1ecf1;color:#0c5460;padding:15px;border-radius:5px;margin:10px 0;}
a{color:#d4af37;text-decoration:none;font-weight:bold;}</style></head><body>';

echo '<h1>Rechtsgebiete-Seiten Setup</h1>';

$created = 0;
$skipped = 0;

foreach ($pages as $page_data) {
    // Prüfen ob Seite bereits existiert
    $existing_page = get_page_by_path($page_data['slug']);
    
    if ($existing_page) {
        echo '<div class="info">⚠️ Seite "' . $page_data['title'] . '" existiert bereits (ID: ' . $existing_page->ID . ')</div>';
        $skipped++;
        continue;
    }
    
    // Seite erstellen
    $page_id = wp_insert_post(array(
        'post_title'    => $page_data['title'],
        'post_name'     => $page_data['slug'],
        'post_content'  => $page_data['content'],
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
    ));
    
    if ($page_id && !is_wp_error($page_id)) {
        echo '<div class="success">✓ Seite "' . $page_data['title'] . '" erfolgreich erstellt (ID: ' . $page_id . ')<br>';
        echo '<a href="' . get_permalink($page_id) . '" target="_blank">→ Seite ansehen</a> | ';
        echo '<a href="' . admin_url('post.php?post=' . $page_id . '&action=edit') . '" target="_blank">→ Bearbeiten</a></div>';
        $created++;
    } else {
        echo '<div class="error">✗ Fehler beim Erstellen von "' . $page_data['title'] . '"</div>';
    }
}

echo '<hr><h2>Zusammenfassung</h2>';
echo '<p><strong>' . $created . '</strong> Seiten erstellt<br>';
echo '<strong>' . $skipped . '</strong> Seiten übersprungen (existieren bereits)</p>';

echo '<div class="info">';
echo '<h3>Nächste Schritte:</h3>';
echo '<ol>';
echo '<li><strong>Menü erstellen:</strong> WordPress Admin → Design → Menüs</li>';
echo '<li><strong>Seiten hinzufügen:</strong> Alle 4 Rechtsgebiete zum Menü hinzufügen</li>';
echo '<li><strong>Inhalte anpassen:</strong> Jede Seite mit spezifischen Inhalten füllen</li>';
echo '<li><strong>Diese Datei löschen:</strong> setup-pages.php aus Sicherheitsgründen entfernen</li>';
echo '</ol>';
echo '</div>';

echo '<p><a href="' . admin_url() . '">→ Zurück zum WordPress-Admin</a></p>';

echo '</body></html>';
