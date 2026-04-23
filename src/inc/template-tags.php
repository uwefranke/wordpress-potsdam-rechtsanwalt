<?php
/**
 * Template-Tags und Helper-Funktionen
 * 
 * Wiederverwendbare Funktionen für Templates
 */

/**
 * Service-Icon ausgeben
 */
function potsdam_get_service_icon($type) {
    $icons = array(
        'verkehrsrecht' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>',
        
        'familienrecht' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        
        'vertragsrecht' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>',
        
        'immobilienrecht' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
    );
    
    return isset($icons[$type]) ? $icons[$type] : '';
}

/**
 * Formatierte Adresse ausgeben
 */
function potsdam_get_formatted_address() {
    $street = get_theme_mod('contact_street', 'Schornsteinfegergasse');
    $housenumber = get_theme_mod('contact_housenumber', '5');
    $zip = get_theme_mod('contact_zip', '14482');
    $city = get_theme_mod('contact_city', 'Potsdam');
    
    return esc_html($street . ' ' . $housenumber) . '<br>' . esc_html($zip . ' ' . $city);
}

/**
 * Telefon-Link erstellen
 */
function potsdam_get_phone_link() {
    $phone = get_theme_mod('contact_phone', '+49 331 123456');
    $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
    return sprintf(
        '<a href="tel:%s">%s</a>',
        esc_attr($phone_clean),
        esc_html($phone)
    );
}

/**
 * E-Mail-Link erstellen
 */
function potsdam_get_email_link() {
    $email = get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de');
    return sprintf(
        '<a href="mailto:%s">%s</a>',
        esc_attr($email),
        esc_html($email)
    );
}

/**
 * Breadcrumbs ausgeben
 */
function potsdam_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="breadcrumbs">';
    echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
    
    if (is_category() || is_single()) {
        echo ' &raquo; ';
        the_category(' &bull; ');
        if (is_single()) {
            echo ' &raquo; ';
            the_title();
        }
    } elseif (is_page()) {
        echo ' &raquo; ';
        the_title();
    }
    
    echo '</nav>';
}

/**
 * Gibt ein Icon-SVG basierend auf dem Icon-Namen zurück
 */
function potsdam_get_service_icon($icon_name) {
    $icons = array(
        // Rechts-spezifische Icons
        'scale' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="22"></line><path d="M3 7l4-4 4 4M3 7h8M3 7v4c0 2.21 3 4 4 4s4-1.79 4-4V7M13 7l4-4 4 4M13 7h8M13 7v4c0 2.21 3 4 4 4s4-1.79 4-4V7"></path></svg>',
        'gavel' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2l-8.5 8.5M19 7l-8.5 8.5M10 10.5L3 17.5L6.5 21l7-7M21 15l-4 4M18 2l4 4"></path><rect x="2" y="19" width="20" height="2" rx="1"></rect></svg>',
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 12h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 14"></path><path d="m7 18 1.6-1.4c.3-.4.8-.6 1.4-.6h2"></path><path d="m16 8 3-3 3 3"></path><path d="m20 4-3 3-3-3"></path><path d="M7 10h2a2 2 0 0 1 0 4H6c-.6 0-1.1-.2-1.4-.6L0 8"></path></svg>',
        
        // Immobilien & Mietrecht
        'building' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 10h6M9 14h6M9 18h6M3 10v9a2 2 0 002 2h14a2 2 0 002-2v-9M3 5a2 2 0 012-2h14a2 2 0 012 2v5H3z"></path></svg>',
        'home' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
        'key' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>',
        
        // Familien- & Sozialrecht
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'heart' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>',
        
        // Arbeits- & Wirtschaftsrecht
        'briefcase' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
        'dollar' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
        
        // Verkehrs- & Baurecht
        'car' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"></path><circle cx="6.5" cy="16.5" r="2.5"></circle><circle cx="16.5" cy="16.5" r="2.5"></circle></svg>',
        'tool' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"></path></svg>',
        
        // Versicherungs- & Schutzrecht
        'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
        
        // Allgemein
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'bookmark' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
    );
    
    return isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['file-text']; // 'file-text' als Fallback
}

/**
 * Rechtsgebiete-Karten ausgeben
 * Dynamisch aus Customizer-Einstellungen
 */
function potsdam_display_service_cards() {
    $count = get_theme_mod('services_count', 4);
    
    // Default-Werte für die 4 Rechtsgebiete (falls noch nicht im Customizer gespeichert)
    $default_services = array(
        1 => array(
            'title' => 'Miet- / Wohnungseigentumsrecht',
            'description' => 'Umfassende Beratung bei Wohnungs- und Gewerbemietrecht, Kündigungen, Mietminderungen und WEG-Recht.',
            'link' => '/miet-wohnungseigentumsrecht',
            'icon' => 'scale',
        ),
        2 => array(
            'title' => 'Grundstücks- / Immobilienrecht',
            'description' => 'Kaufverträge, Förderdarlehen (ILB/IBB), Nachbarschaftsrecht und alle immobilienrechtlichen Angelegenheiten.',
            'link' => '/grundstuecks-immobilienrecht',
            'icon' => 'home',
        ),
        3 => array(
            'title' => 'Baurecht',
            'description' => 'Bauverträge (BGB/VOB), Baumängel, Gewährleistung, Architektenrecht und bauplanungsrechtliche Fragen.',
            'link' => '/baurecht',
            'icon' => 'tool',
        ),
        4 => array(
            'title' => 'BU / Erwerbsminderungsrente',
            'description' => 'Durchsetzung von Ansprüchen bei Berufsunfähigkeit und Erwerbsminderung gegenüber Versicherungen und Behörden.',
            'link' => '/bu-erwerbsminderungsrente',
            'icon' => 'shield',
        ),
    );
    
    for ($i = 1; $i <= $count; $i++) {
        // Default-Werte für dieses Rechtsgebiet (falls vorhanden)
        $default_title = isset($default_services[$i]) ? $default_services[$i]['title'] : '';
        $default_desc = isset($default_services[$i]) ? $default_services[$i]['description'] : '';
        $default_link = isset($default_services[$i]) ? $default_services[$i]['link'] : '';
        $default_icon = isset($default_services[$i]) ? $default_services[$i]['icon'] : 'file';
        
        // Customizer-Werte holen MIT Default als Fallback
        $title = get_theme_mod("service_{$i}_title", $default_title);
        $description = get_theme_mod("service_{$i}_description", $default_desc);
        $link = get_theme_mod("service_{$i}_link", $default_link);
        $icon_name = get_theme_mod("service_{$i}_icon", $default_icon);
        
        // Nur anzeigen wenn Titel vorhanden
        if (empty($title)) {
            continue;
        }
        
        // Link formatieren (relative oder absolute URL)
        $url = !empty($link) && (strpos($link, 'http') === 0) ? $link : esc_url(home_url($link));
        
        // Icon-SVG holen
        $icon_svg = potsdam_get_service_icon($icon_name);
        ?>
        
        <a href="<?php echo $url; ?>" class="service-card-link">
            <div class="service-card">
                <div class="service-icon">
                    <?php echo $icon_svg; ?>
                </div>
                <h3><?php echo esc_html($title); ?></h3>
                <p><?php echo esc_html($description); ?></p>
                <span class="service-link-arrow">Mehr erfahren →</span>
            </div>
        </a>
        
        <?php
    }
}