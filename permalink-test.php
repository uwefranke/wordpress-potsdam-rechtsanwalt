<?php
/**
 * WordPress Permalink Test-Script
 * 
 * Zeigt alle wichtigen Informationen für die Fehlersuche bei nicht funktionierenden Links
 * 
 * VERWENDUNG:
 * 1. In WordPress-Root hochladen (neben wp-config.php)
 * 2. Im Browser aufrufen: https://deine-domain.de/permalink-test.php
 * 3. Danach SOFORT wieder löschen!
 */

echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Permalink Test</title>';
echo '<style>
body{font-family:Arial,sans-serif;max-width:900px;margin:40px auto;padding:20px;background:#f5f5f5;}
h1{color:#1a3a5c;border-bottom:3px solid #d4af37;padding-bottom:10px;}
h2{color:#2d3436;margin-top:25px;border-left:4px solid #d4af37;padding-left:12px;}
.box{background:#fff;padding:20px;margin:15px 0;border-radius:5px;box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.ok{color:#28a745;font-weight:bold;}
.error{color:#dc3545;font-weight:bold;}
.warning{color:#ffc107;font-weight:bold;}
code{background:#f0f0f0;padding:2px 6px;border-radius:3px;font-family:monospace;}
pre{background:#2d3436;color:#fff;padding:15px;border-radius:5px;overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
td{padding:8px;border-bottom:1px solid #ddd;}
td:first-child{font-weight:bold;width:40%;}
</style></head><body>';

echo '<h1>🔍 WordPress Permalink Diagnose</h1>';
echo '<p><strong>Server:</strong> ' . $_SERVER['HTTP_HOST'] . '</p>';

// WordPress laden
$wp_load = dirname(__FILE__) . '/wp-load.php';
if (!file_exists($wp_load)) {
    echo '<div class="box"><p class="error">❌ FEHLER: wp-load.php nicht gefunden!</p>';
    echo '<p>Stelle sicher, dass diese Datei im WordPress-Root liegt (neben wp-config.php)</p></div>';
    echo '</body></html>';
    exit;
}

require_once($wp_load);

// --- 1. WEBSERVER PRÜFEN ---
echo '<div class="box">';
echo '<h2>1️⃣ Webserver-Software</h2>';
echo '<table>';
echo '<tr><td>Software</td><td><code>' . $_SERVER['SERVER_SOFTWARE'] . '</code></td></tr>';

$is_apache = stripos($_SERVER['SERVER_SOFTWARE'], 'apache') !== false;
$is_nginx = stripos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false;

if ($is_apache) {
    echo '<tr><td>Erkannt als</td><td><span class="ok">✅ Apache</span> (.htaccess sollte funktionieren)</td></tr>';
} elseif ($is_nginx) {
    echo '<tr><td>Erkannt als</td><td><span class="error">❌ Nginx</span> (.htaccess funktioniert NICHT!)</td></tr>';
} else {
    echo '<tr><td>Erkannt als</td><td><span class="warning">⚠️ Unbekannt</span></td></tr>';
}
echo '</table>';
echo '</div>';

// --- 2. MOD_REWRITE PRÜFEN ---
echo '<div class="box">';
echo '<h2>2️⃣ mod_rewrite Status</h2>';

if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo '<p class="ok">✅ mod_rewrite ist AKTIVIERT</p>';
    } else {
        echo '<p class="error">❌ mod_rewrite ist NICHT aktiviert!</p>';
        echo '<p><strong>Lösung:</strong> Hosting-Provider kontaktieren und mod_rewrite aktivieren lassen</p>';
    }
} else {
    echo '<p class="warning">⚠️ Kann mod_rewrite nicht überprüfen (CGI/FastCGI)</p>';
    echo '<p>mod_rewrite könnte trotzdem aktiv sein.</p>';
}
echo '</div>';

// --- 3. .HTACCESS PRÜFEN ---
echo '<div class="box">';
echo '<h2>3️⃣ .htaccess Datei</h2>';

$htaccess_path = ABSPATH . '.htaccess';
echo '<table>';
echo '<tr><td>Pfad</td><td><code>' . $htaccess_path . '</code></td></tr>';

if (file_exists($htaccess_path)) {
    echo '<tr><td>Existiert</td><td><span class="ok">✅ Ja</span></td></tr>';
    
    $htaccess_content = file_get_contents($htaccess_path);
    $has_wordpress = strpos($htaccess_content, '# BEGIN WordPress') !== false;
    $has_rewrite = strpos($htaccess_content, 'RewriteEngine On') !== false;
    
    echo '<tr><td>WordPress-Regeln</td><td>' . ($has_wordpress ? '<span class="ok">✅ Vorhanden</span>' : '<span class="error">❌ Fehlen</span>') . '</td></tr>';
    echo '<tr><td>RewriteEngine</td><td>' . ($has_rewrite ? '<span class="ok">✅ Aktiviert</span>' : '<span class="error">❌ Nicht aktiviert</span>') . '</td></tr>';
    echo '<tr><td>Größe</td><td>' . filesize($htaccess_path) . ' Bytes</td></tr>';
    
    if (is_writable($htaccess_path)) {
        echo '<tr><td>Schreibrechte</td><td><span class="ok">✅ Beschreibbar</span></td></tr>';
    } else {
        echo '<tr><td>Schreibrechte</td><td><span class="warning">⚠️ Nicht beschreibbar</span></td></tr>';
    }
    
    echo '</table>';
    
    echo '<h3>Inhalt:</h3>';
    echo '<pre>' . htmlspecialchars($htaccess_content) . '</pre>';
    
    if (!$has_wordpress) {
        echo '<p class="error">❌ .htaccess enthält keine WordPress-Rewrite-Rules!</p>';
        echo '<p><strong>Lösung:</strong> Gehe zu <code>Einstellungen → Permalinks</code> und klicke "Änderungen speichern"</p>';
    }
} else {
    echo '<tr><td>Existiert</td><td><span class="error">❌ NEIN</span></td></tr>';
    echo '</table>';
    echo '<p class="error">❌ .htaccess-Datei fehlt komplett!</p>';
    echo '<p><strong>Lösung:</strong> Gehe zu <code>Einstellungen → Permalinks</code> und klicke "Änderungen speichern"</p>';
}
echo '</div>';

// --- 4. WORDPRESS PERMALINKS ---
echo '<div class="box">';
echo '<h2>4️⃣ WordPress Permalink-Einstellungen</h2>';
echo '<table>';

$permalink_structure = get_option('permalink_structure');
echo '<tr><td>Struktur</td><td><code>' . ($permalink_structure ?: 'Leer (Standard)') . '</code></td></tr>';

if ($permalink_structure === '/%postname%/') {
    echo '<tr><td>Status</td><td><span class="ok">✅ Korrekt (Beitragsname)</span></td></tr>';
} elseif (empty($permalink_structure)) {
    echo '<tr><td>Status</td><td><span class="error">❌ Standard-Permalinks aktiv (?p=123)</span></td></tr>';
    echo '</table>';
    echo '<p class="error">❌ Pretty Permalinks sind NICHT aktiviert!</p>';
    echo '<p><strong>Lösung:</strong></p>';
    echo '<ol><li>Gehe zu <code>Einstellungen → Permalinks</code></li>';
    echo '<li>Wähle "Beitragsname"</li>';
    echo '<li>Klicke "Änderungen speichern"</li></ol>';
} else {
    echo '<tr><td>Status</td><td><span class="warning">⚠️ Andere Struktur</span></td></tr>';
}
echo '</table>';
echo '</div>';

// --- 5. TESTSEITE ---
echo '<div class="box">';
echo '<h2>5️⃣ Test-Seiten</h2>';

$test_pages = get_pages(array('number' => 5));

if ($test_pages) {
    echo '<p>Teste diese Links (sollten OHNE 404 funktionieren):</p><ul>';
    foreach ($test_pages as $page) {
        $url = get_permalink($page->ID);
        echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($page->post_title) . '</a><br>';
        echo '<code>' . esc_html($url) . '</code></li>';
    }
    echo '</ul>';
} else {
    echo '<p class="warning">⚠️ Keine Seiten gefunden zum Testen</p>';
}
echo '</div>';

// --- 6. ZUSAMMENFASSUNG & LÖSUNGEN ---
echo '<div class="box">';
echo '<h2>🔧 Diagnose & Lösungen</h2>';

$problems = array();

if ($is_nginx) {
    $problems[] = '<strong>NGINX-SERVER:</strong> .htaccess funktioniert nicht! Siehe NGINX-SETUP.md';
}

if (function_exists('apache_get_modules') && !in_array('mod_rewrite', apache_get_modules())) {
    $problems[] = '<strong>mod_rewrite deaktiviert:</strong> Hosting-Provider kontaktieren';
}

if (!file_exists($htaccess_path)) {
    $problems[] = '<strong>.htaccess fehlt:</strong> Einstellungen → Permalinks → Speichern';
}

if (empty($permalink_structure)) {
    $problems[] = '<strong>Permalinks nicht aktiviert:</strong> Einstellungen → Permalinks → "Beitragsname" wählen';
}

if (file_exists($htaccess_path) && !strpos(file_get_contents($htaccess_path), '# BEGIN WordPress')) {
    $problems[] = '<strong>.htaccess ohne WordPress-Regeln:</strong> Einstellungen → Permalinks → Speichern';
}

if (empty($problems)) {
    echo '<p class="ok">✅ Keine offensichtlichen Probleme gefunden!</p>';
    echo '<p>Falls Links trotzdem nicht funktionieren:</p>';
    echo '<ul>';
    echo '<li><strong>AllowOverride:</strong> Hosting-Provider muss AllowOverride All setzen</li>';
    echo '<li><strong>VirtualHost:</strong> .htaccess wird möglicherweise ignoriert</li>';
    echo '<li><strong>Cache:</strong> Browser-Cache leeren (Strg+F5)</li>';
    echo '</ul>';
} else {
    echo '<p class="error">❌ Gefundene Probleme:</p><ol>';
    foreach ($problems as $problem) {
        echo '<li>' . $problem . '</li>';
    }
    echo '</ol>';
}

echo '</div>';

echo '<div class="box">';
echo '<h2>⚠️ WICHTIG</h2>';
echo '<p class="error"><strong>LÖSCHE DIESE DATEI JETZT!</strong></p>';
echo '<p>permalink-test.php ist ein Sicherheitsrisiko und sollte nach dem Test gelöscht werden.</p>';
echo '</div>';

echo '<p style="text-align:center;margin-top:30px;">';
echo '<a href="' . admin_url('options-permalink.php') . '" style="background:#1a3a5c;color:#fff;padding:12px 24px;border-radius:4px;text-decoration:none;display:inline-block;">→ Zu Permalink-Einstellungen</a>';
echo '</p>';

echo '</body></html>';
