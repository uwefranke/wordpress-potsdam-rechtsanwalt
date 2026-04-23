<?php
/**
 * Theme Shortcodes
 * 
 * Ermöglicht Verwendung von Customizer-Feldern im WordPress-Editor
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcode: [kontakt field="phone"]
 * 
 * Verfügbare Felder:
 * - title, firstname, lastname, fullname
 * - phone, fax, email
 * - street, housenumber, zip, city, state, country
 * - address (Straße + Hausnummer)
 * - fulladdress (komplette Adresse)
 * 
 * Optionale Parameter:
 * - link="yes" - Telefon/E-Mail als klickbarer Link
 * - format="html" - Zeilenumbrüche mit <br>
 * - obfuscate="yes" - E-Mail/Telefon als HTML-Entities verschleiern (Spam-Schutz)
 */
function potsdam_rechtsanwalt_kontakt_shortcode($atts) {
    $atts = shortcode_atts(array(
        'field'      => '',
        'link'       => 'no',
        'format'     => 'text',
        'obfuscate'  => 'auto',
    ), $atts, 'kontakt');
    
    $field = strtolower($atts['field']);
    $link = ($atts['link'] === 'yes' || $atts['link'] === 'true');
    $format_html = ($atts['format'] === 'html');
    // auto = verschleiern bei phone/email, manuell überschreibbar mit yes/no
    $sensitive_field = in_array($field, array('phone', 'fax', 'email'), true);
    $obfuscate = ($atts['obfuscate'] === 'yes') || ($atts['obfuscate'] === 'auto' && $sensitive_field);
    
    // Einzelfelder
    $values = array(
        'title'        => get_theme_mod('contact_title', 'Rechtsanwalt'),
        'firstname'    => get_theme_mod('contact_firstname', 'Matthias'),
        'lastname'     => get_theme_mod('contact_lastname', 'Lange'),
        'phone'        => get_theme_mod('contact_phone', '+49 331 123456'),
        'fax'          => get_theme_mod('contact_fax', ''),
        'email'        => get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de'),
        'street'       => get_theme_mod('contact_street', 'Schornsteinfegergasse'),
        'housenumber'  => get_theme_mod('contact_housenumber', '5'),
        'zip'          => get_theme_mod('contact_zip', '14482'),
        'city'         => get_theme_mod('contact_city', 'Potsdam'),
        'state'        => get_theme_mod('contact_state', 'Brandenburg'),
        'country'      => get_theme_mod('contact_country', 'Deutschland'),
    );
    
    // Kombinierte Felder
    switch ($field) {
        case 'fullname':
            $output = trim($values['title'] . ' ' . $values['firstname'] . ' ' . $values['lastname']);
            break;
            
        case 'address':
            $output = $values['street'] . ' ' . $values['housenumber'];
            break;
            
        case 'shortaddress':
            $separator = $format_html ? '<br>' : ', ';
            $output = $values['street'] . ' ' . $values['housenumber'] . $separator . $values['zip'] . ' ' . $values['city'];
            break;
            
        case 'fulladdress':
            $parts = array(
                $values['street'] . ' ' . $values['housenumber'],
                $values['zip'] . ' ' . $values['city'],
            );
            if (!empty($values['state'])) {
                $parts[] = $values['state'];
            }
            if (!empty($values['country'])) {
                $parts[] = $values['country'];
            }
            $separator = $format_html ? '<br>' : ', ';
            $output = implode($separator, $parts);
            break;
            
        default:
            // Einzelfeld
            if (isset($values[$field])) {
                $output = $values[$field];
            } else {
                return '<em>[Unbekanntes Feld: ' . esc_html($field) . ']</em>';
            }
            break;
    }
    
    // Optional: Als Link formatieren
    if ($link) {
        if ($field === 'phone') {
            $clean_phone = str_replace(array(' ', '-', '(', ')'), '', $output);
            $href = 'tel:' . $clean_phone;
            $label = esc_html($output);
            if ($obfuscate) {
                $href = potsdam_rechtsanwalt_obfuscate($href);
                $label = potsdam_rechtsanwalt_obfuscate($output);
            }
            $output = '<a href="' . $href . '">' . $label . '</a>';
        } elseif ($field === 'email') {
            $href = 'mailto:' . $output;
            $label = esc_html($output);
            if ($obfuscate) {
                $href = potsdam_rechtsanwalt_obfuscate($href);
                $label = potsdam_rechtsanwalt_obfuscate($output);
            }
            $output = '<a href="' . $href . '">' . $label . '</a>';
        } else {
            $output = esc_html($output);
        }
    } elseif ($obfuscate && in_array($field, array('phone', 'fax', 'email'), true)) {
        $output = potsdam_rechtsanwalt_obfuscate($output);
    } else {
        $output = $format_html ? wp_kses_post($output) : esc_html($output);
    }
    
    return $output;
}
add_shortcode('kontakt', 'potsdam_rechtsanwalt_kontakt_shortcode');

/**
 * Hilfsfunktion: String als HTML-Entities verschleiern
 */
function potsdam_rechtsanwalt_obfuscate($string) {
    $result = '';
    $chars = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($chars as $char) {
        $unpacked = unpack('N', mb_convert_encoding($char, 'UCS-4BE', 'UTF-8'));
        $result .= '&#' . $unpacked[1] . ';';
    }
    return $result;
}


/**
 * Shortcode: [rechtsgebiet number="1"]
 * 
 * Zeigt Rechtsgebiet-Informationen aus dem Customizer
 * 
 * Parameter:
 * - number (1-6)
 * - field: title, text, icon (Standard: title)
 */
function potsdam_rechtsanwalt_rechtsgebiet_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => '1',
        'field'  => 'title',
    ), $atts, 'rechtsgebiet');
    
    $number = absint($atts['number']);
    $field = strtolower($atts['field']);
    
    if ($number < 1 || $number > 6) {
        return '<em>[Rechtsgebiet-Nummer muss zwischen 1 und 6 liegen]</em>';
    }
    
    $field_name = 'rechtsgebiet_' . $number . '_' . $field;
    
    if ($field === 'title') {
        $default = 'Rechtsgebiet ' . $number;
    } elseif ($field === 'text') {
        $default = '';
    } elseif ($field === 'icon') {
        $default = 'fas fa-balance-scale';
    } else {
        return '<em>[Unbekanntes Feld: ' . esc_html($field) . ']</em>';
    }
    
    $value = get_theme_mod($field_name, $default);
    
    if ($field === 'icon') {
        return '<i class="' . esc_attr($value) . '"></i>';
    }
    
    return esc_html($value);
}
add_shortcode('rechtsgebiet', 'potsdam_rechtsanwalt_rechtsgebiet_shortcode');


/**
 * Shortcode: [hero field="title"]
 * 
 * Zeigt Hero-Bereich Inhalte
 * 
 * Felder: title, text, image
 */
function potsdam_rechtsanwalt_hero_shortcode($atts) {
    $atts = shortcode_atts(array(
        'field' => 'title',
    ), $atts, 'hero');
    
    $field = strtolower($atts['field']);
    
    switch ($field) {
        case 'title':
            $value = get_theme_mod('hero_title', 'IHRE KANZLEI IN POTSDAM');
            return esc_html($value);
            
        case 'text':
            $value = get_theme_mod('hero_text', 'FÜR RECHT, DAS VERTRAUEN SCHAFFT. KOMPETENT & LOKAL.');
            return esc_html($value);
            
        case 'image':
            $image_url = get_theme_mod('hero_image');
            if ($image_url) {
                return '<img src="' . esc_url($image_url) . '" alt="Hero Bild" class="hero-image">';
            }
            return '';
            
        default:
            return '<em>[Unbekanntes Hero-Feld: ' . esc_html($field) . ']</em>';
    }
}
add_shortcode('hero', 'potsdam_rechtsanwalt_hero_shortcode');


/**
 * Shortcode: [customizer field="beliebiges_feld"]
 * 
 * Universeller Shortcode für ALLE Customizer-Felder
 */
function potsdam_rechtsanwalt_customizer_shortcode($atts) {
    $atts = shortcode_atts(array(
        'field'   => '',
        'default' => '',
    ), $atts, 'customizer');
    
    if (empty($atts['field'])) {
        return '<em>[Customizer: Feld-Name erforderlich]</em>';
    }
    
    $value = get_theme_mod($atts['field'], $atts['default']);
    
    return esc_html($value);
}
add_shortcode('customizer', 'potsdam_rechtsanwalt_customizer_shortcode');


/**
 * Shortcode: [cookie_einstellungen]
 * 
 * Erzeugt einen Link zum Öffnen der Cookie-Einstellungen
 * 
 * Parameter:
 * - text: Link-Text (Standard: "Cookie-Einstellungen")
 * - class: Zusätzliche CSS-Klasse
 */
function potsdam_rechtsanwalt_cookie_settings_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text'  => 'Cookie-Einstellungen',
        'class' => '',
        'style' => '',
    ), $atts, 'cookie_einstellungen');
    
    $class = !empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '';
    $style = !empty($atts['style']) ? ' style="' . esc_attr($atts['style']) . '"' : '';
    
    return '<a href="#" class="cookie-settings-link' . $class . '"' . $style . ' tabindex="-1" onclick="event.preventDefault(); window.openCookieSettings();">' 
           . esc_html($atts['text']) 
           . '</a>';
}
add_shortcode('cookie_einstellungen', 'potsdam_rechtsanwalt_cookie_settings_shortcode');
