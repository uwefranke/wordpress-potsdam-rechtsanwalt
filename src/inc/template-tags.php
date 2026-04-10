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
    $address = get_theme_mod('contact_address', 'Musterstraße 123, 14467 Potsdam');
    return nl2br(esc_html($address));
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
