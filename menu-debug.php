<?php
/**
 * Menü Diagnose-Script
 * 
 * Zeigt alle Menü-Informationen zur Fehlersuche
 * 
 * VERWENDUNG:
 * 1. In WordPress-Root oder Theme-Ordner hochladen
 * 2. Im Browser aufrufen: https://deine-domain.de/menu-debug.php
 * 3. Danach SOFORT wieder löschen!
 */

// WordPress laden
$wp_load = dirname(__FILE__) . '/wp-load.php';
if (!file_exists($wp_load)) {
    $wp_load = dirname(__FILE__) . '/../../../wp-load.php';
}
require_once($wp_load);

if (!is_user_logged_in() || !current_user_can('administrator')) {
    die('Zugriff verweigert. Bitte als Administrator einloggen.');
}

echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Menü Debug</title>';
echo '<style>
body{font-family:Arial,sans-serif;max-width:1000px;margin:40px auto;padding:20px;background:#f5f5f5;}
h1{color:#1a3a5c;border-bottom:3px solid #d4af37;padding-bottom:10px;}
h2{color:#2d3436;margin-top:25px;border-left:4px solid #d4af37;padding-left:12px;}
.box{background:#fff;padding:20px;margin:15px 0;border-radius:5px;box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.ok{color:#28a745;font-weight:bold;}
.error{color:#dc3545;font-weight:bold;}
.warning{color:#ffc107;font-weight:bold;}
code{background:#f0f0f0;padding:2px 6px;border-radius:3px;font-family:monospace;}
pre{background:#2d3436;color:#fff;padding:15px;border-radius:5px;overflow-x:auto;font-size:12px;}
table{width:100%;border-collapse:collapse;margin:15px 0;}
td,th{padding:8px;border-bottom:1px solid #ddd;text-align:left;}
th{background:#1a3a5c;color:#fff;}
ul{line-height:1.8;}
.indent{margin-left:30px;color:#666;}
</style></head><body>';

echo '<h1>🔍 WordPress Menü Diagnose</h1>';

// --- 1. REGISTRIERTE MENÜ-LOCATIONS ---
echo '<div class="box">';
echo '<h2>1️⃣ Registrierte Menü-Locations</h2>';

$locations = get_registered_nav_menus();
if (!empty($locations)) {
    echo '<table><tr><th>Location Key</th><th>Beschreibung</th></tr>';
    foreach ($locations as $location => $description) {
        echo '<tr><td><code>' . $location . '</code></td><td>' . $description . '</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p class="error">❌ Keine Menü-Locations registriert!</p>';
}
echo '</div>';

// --- 2. ZUGEWIESENE MENÜS ---
echo '<div class="box">';
echo '<h2>2️⃣ Menü-Zuweisungen</h2>';

$nav_menu_locations = get_nav_menu_locations();
if (!empty($nav_menu_locations)) {
    echo '<table><tr><th>Location</th><th>Zugewiesenes Menü</th><th>Status</th></tr>';
    foreach ($locations as $location => $description) {
        echo '<tr><td><code>' . $location . '</code></td>';
        if (isset($nav_menu_locations[$location])) {
            $menu = wp_get_nav_menu_object($nav_menu_locations[$location]);
            if ($menu) {
                echo '<td>' . $menu->name . ' (ID: ' . $menu->term_id . ')</td>';
                echo '<td><span class="ok">✅ Zugewiesen</span></td>';
            } else {
                echo '<td class="error">Menü-ID ' . $nav_menu_locations[$location] . ' existiert nicht!</td>';
                echo '<td><span class="error">❌ Fehler</span></td>';
            }
        } else {
            echo '<td class="warning">Nicht zugewiesen</td>';
            echo '<td><span class="warning">⚠️ Leer</span></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p class="error">❌ Keine Menüs zugewiesen!</p>';
}
echo '</div>';

// --- 3. ALLE MENÜS ---
echo '<div class="box">';
echo '<h2>3️⃣ Alle existierenden Menüs</h2>';

$menus = wp_get_nav_menus();
if (!empty($menus)) {
    echo '<p>Gefundene Menüs: <strong>' . count($menus) . '</strong></p>';
    foreach ($menus as $menu) {
        echo '<h3>' . $menu->name . ' (ID: ' . $menu->term_id . ')</h3>';
        echo '<p>Anzahl Items: ' . $menu->count . '</p>';
        
        // Menü-Items abrufen
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        
        if ($menu_items) {
            echo '<ul style="list-style:none;padding:0;">';
            
            // Items hierarchisch anzeigen
            $menu_tree = array();
            $menu_by_id = array();
            
            foreach ($menu_items as $item) {
                $menu_by_id[$item->ID] = $item;
                if ($item->menu_item_parent == 0) {
                    $menu_tree[] = $item;
                }
            }
            
            foreach ($menu_tree as $parent_item) {
                echo '<li>';
                echo '<strong>' . $parent_item->title . '</strong> ';
                echo '<code>' . $parent_item->url . '</code>';
                echo ' (ID: ' . $parent_item->ID . ', Type: ' . $parent_item->object . ')';
                
                // Untermenüs finden
                $children = array_filter($menu_items, function($item) use ($parent_item) {
                    return $item->menu_item_parent == $parent_item->ID;
                });
                
                if (!empty($children)) {
                    echo '<ul class="indent">';
                    foreach ($children as $child_item) {
                        echo '<li>';
                        echo $child_item->title . ' ';
                        echo '<code>' . $child_item->url . '</code>';
                        echo ' (ID: ' . $child_item->ID . ')';
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
            
            // Zeige alle Items als Debug
            echo '<details><summary>Alle Items (Debug)</summary><pre>';
            foreach ($menu_items as $item) {
                echo 'ID: ' . $item->ID . ' | ';
                echo 'Title: "' . $item->title . '" | ';
                echo 'Parent: ' . $item->menu_item_parent . ' | ';
                echo 'Type: ' . $item->object . ' | ';
                echo 'URL: ' . $item->url . "\n";
            }
            echo '</pre></details>';
        } else {
            echo '<p class="warning">⚠️ Keine Menü-Items in diesem Menü!</p>';
        }
    }
} else {
    echo '<p class="error">❌ Keine Menüs vorhanden!</p>';
    echo '<p><strong>Lösung:</strong> Führe setup-pages.php aus oder erstelle ein Menü unter Design → Menüs</p>';
}
echo '</div>';

// --- 4. PROBLEME & LÖSUNGEN ---
echo '<div class="box">';
echo '<h2>🔧 Diagnose & Lösungen</h2>';

$problems = array();

if (empty($menus)) {
    $problems[] = '<strong>Keine Menüs vorhanden:</strong> Führe setup-pages.php aus';
}

if (!isset($nav_menu_locations['primary']) || empty($nav_menu_locations['primary'])) {
    $problems[] = '<strong>Primary-Menü nicht zugewiesen:</strong> Gehe zu Design → Menüs → Verwaltung der Positionen';
}

if (isset($nav_menu_locations['primary'])) {
    $primary_menu = wp_get_nav_menu_object($nav_menu_locations['primary']);
    if ($primary_menu && $primary_menu->count == 0) {
        $problems[] = '<strong>Primary-Menü ist leer:</strong> Füge Menü-Items hinzu';
    }
}

if (empty($problems)) {
    echo '<p class="ok">✅ Keine offensichtlichen Probleme gefunden!</p>';
    echo '<p>Falls das Menü auf der Website trotzdem nicht angezeigt wird:</p>';
    echo '<ul>';
    echo '<li>Browser-Cache leeren (Strg+F5)</li>';
    echo '<li>Theme-Cache leeren (falls Caching-Plugin aktiv)</li>';
    echo '<li>CSS-Konflikt prüfen (Menü eventuell unsichtbar durch CSS)</li>';
    echo '</ul>';
} else {
    echo '<p class="error">❌ Gefundene Probleme:</p><ol>';
    foreach ($problems as $problem) {
        echo '<li>' . $problem . '</li>';
    }
    echo '</ol>';
    
    echo '<h3>Schnelle Lösungen:</h3>';
    echo '<ol>';
    echo '<li><strong>Menü zuweisen:</strong> <a href="' . admin_url('nav-menus.php?action=locations') . '">Design → Menüs → Positionen verwalten</a></li>';
    echo '<li><strong>Menü bearbeiten:</strong> <a href="' . admin_url('nav-menus.php') . '">Design → Menüs</a></li>';
    echo '<li><strong>setup-pages.php erneut ausführen:</strong> Erstellt Menü automatisch</li>';
    echo '</ol>';
}

echo '</div>';

echo '<div class="box">';
echo '<h2>⚠️ WICHTIG</h2>';
echo '<p class="error"><strong>LÖSCHE DIESE DATEI JETZT!</strong></p>';
echo '<p>menu-debug.php ist ein Sicherheitsrisiko und sollte nach dem Test gelöscht werden.</p>';
echo '</div>';

echo '<p style="text-align:center;margin-top:30px;">';
echo '<a href="' . admin_url('nav-menus.php') . '" style="background:#1a3a5c;color:#fff;padding:12px 24px;border-radius:4px;text-decoration:none;display:inline-block;margin:5px;">→ Zu Menü-Verwaltung</a> ';
echo '<a href="' . home_url() . '" style="background:#d4af37;color:#1a3a5c;padding:12px 24px;border-radius:4px;text-decoration:none;display:inline-block;margin:5px;">→ Zur Website</a>';
echo '</p>';

echo '</body></html>';
