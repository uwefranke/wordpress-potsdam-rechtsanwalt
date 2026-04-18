<?php
/**
 * Customizer-Einstellungen
 * 
 * Wird von functions.php inkludiert
 */

function potsdam_rechtsanwalt_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero-Bereich', 'potsdam-rechtsanwalt'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default'   => 'IHRE KANZLEI IN POTSDAM',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'    => __('Hero Überschrift', 'potsdam-rechtsanwalt'),
        'section'  => 'hero_section',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('hero_text', array(
        'default'   => 'FÜR RECHT, DAS VERTRAUEN SCHAFFT. KOMPETENT & LOKAL.',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_text', array(
        'label'    => __('Hero Text', 'potsdam-rechtsanwalt'),
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));
    
    $wp_customize->add_setting('hero_image');
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label'    => __('Hero Hintergrundbild', 'potsdam-rechtsanwalt'),
        'section'  => 'hero_section',
    )));
    
    // Kontakt-Informationen
    $wp_customize->add_section('contact_info', array(
        'title'    => __('Kontakt-Informationen', 'potsdam-rechtsanwalt'),
        'priority' => 40,
    ));
    
    // Name strukturiert für vCard (N: und FN: Felder)
    $wp_customize->add_setting('contact_title', array(
        'default'   => 'Rechtsanwalt',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_title', array(
        'label'       => __('Titel / Berufsbezeichnung', 'potsdam-rechtsanwalt'),
        'description' => __('z.B. "Rechtsanwalt", "Dr.", "Prof. Dr."', 'potsdam-rechtsanwalt'),
        'section'     => 'contact_info',
        'type'        => 'text',
    ));
    
    $wp_customize->add_setting('contact_firstname', array(
        'default'   => 'Matthias',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_firstname', array(
        'label'    => __('Vorname', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_lastname', array(
        'default'   => 'Lange',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_lastname', array(
        'label'    => __('Nachname', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_phone', array(
        'default'   => '+49 331 123456',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Telefonnummer', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_fax', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_fax', array(
        'label'    => __('Fax', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_email', array(
        'default'   => 'info@potsdam-rechtsanwalt.de',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label'    => __('E-Mail', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    // Neue Section: Mail-Einstellungen
    $wp_customize->add_section('mail_settings', array(
        'title'       => __('Mail-Einstellungen', 'potsdam-rechtsanwalt'),
        'description' => __('Absender für automatische WordPress-Mails', 'potsdam-rechtsanwalt'),
        'priority'    => 41,
    ));
    
    $wp_customize->add_setting('mail_from_address', array(
        'default'   => 'info@potsdam-rechtsanwalt.de',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('mail_from_address', array(
        'label'       => __('Absender-E-Mail', 'potsdam-rechtsanwalt'),
        'description' => __('E-Mail-Adresse für WordPress-Systemmail', 'potsdam-rechtsanwalt'),
        'section'     => 'mail_settings',
        'type'        => 'email',
    ));
    
    $wp_customize->add_setting('mail_from_name', array(
        'default'   => 'Rechtsanwalt Lange',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('mail_from_name', array(
        'label'       => __('Absender-Name', 'potsdam-rechtsanwalt'),
        'description' => __('Anzeigename im "From:" Header', 'potsdam-rechtsanwalt'),
        'section'     => 'mail_settings',
        'type'        => 'text',
    ));
    
    // Adresse strukturiert
    $wp_customize->add_setting('contact_street', array(
        'default'   => 'Schornsteinfegergasse',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_street', array(
        'label'    => __('Straße', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_housenumber', array(
        'default'   => '5',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_housenumber', array(
        'label'    => __('Hausnummer', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_zip', array(
        'default'   => '14482',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_zip', array(
        'label'    => __('Postleitzahl', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_city', array(
        'default'   => 'Potsdam',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_city', array(
        'label'    => __('Stadt', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('contact_state', array(
        'default'   => 'Brandenburg',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_state', array(
        'label'       => __('Bundesland', 'potsdam-rechtsanwalt'),
        'description' => __('Optional - für vCard-Kompatibilität', 'potsdam-rechtsanwalt'),
        'section'     => 'contact_info',
        'type'        => 'text',
    ));
    
    $wp_customize->add_setting('contact_country', array(
        'default'   => 'Deutschland',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_country', array(
        'label'    => __('Land', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('show_qr_code', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_qr_code', array(
        'label'    => __('QR-Code mit Kontaktdaten anzeigen', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'checkbox',
        'description' => __('Zeigt einen vCard-QR-Code mit allen Kontaktdaten.', 'potsdam-rechtsanwalt'),
    ));
    
    // Social Media
    $wp_customize->add_section('social_media', array(
        'title'    => __('Social Media', 'potsdam-rechtsanwalt'),
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('social_linkedin', array(
        'default'   => '#',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_linkedin', array(
        'label'    => __('LinkedIn URL', 'potsdam-rechtsanwalt'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));
    
    $wp_customize->add_setting('social_xing', array(
        'default'   => '#',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('social_xing', array(
        'label'    => __('XING URL', 'potsdam-rechtsanwalt'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));
    
    // Layout-Optionen
    $wp_customize->add_section('layout_options', array(
        'title'    => __('Layout-Optionen', 'potsdam-rechtsanwalt'),
        'priority' => 60,
    ));
    
    $wp_customize->add_setting('show_contact_form', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_contact_form', array(
        'label'    => __('Kontaktformular anzeigen', 'potsdam-rechtsanwalt'),
        'section'  => 'layout_options',
        'type'     => 'checkbox',
    ));
    
    $wp_customize->add_setting('show_appointment_button', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_appointment_button', array(
        'label'    => __('Termin-Button anzeigen', 'potsdam-rechtsanwalt'),
        'section'  => 'layout_options',
        'type'     => 'checkbox',
    ));
    
    // Öffnungszeiten
    $wp_customize->add_section('opening_hours', array(
        'title'    => __('Öffnungszeiten', 'potsdam-rechtsanwalt'),
        'priority' => 70,
    ));
    
    $wp_customize->add_setting('hours_mon_thu', array(
        'default'   => 'Nach Vereinbarung',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hours_mon_thu', array(
        'label'    => __('Montag - Donnerstag', 'potsdam-rechtsanwalt'),
        'section'  => 'opening_hours',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('hours_friday', array(
        'default'   => 'Nach Vereinbarung',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hours_friday', array(
        'label'    => __('Freitag', 'potsdam-rechtsanwalt'),
        'section'  => 'opening_hours',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('hours_weekend', array(
        'default'   => 'Nach Vereinbarung',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hours_weekend', array(
        'label'    => __('Samstag & Sonntag', 'potsdam-rechtsanwalt'),
        'section'  => 'opening_hours',
        'type'     => 'text',
    ));
    
    // Rechtsgebiete
    $wp_customize->add_section('services', array(
        'title'       => __('Rechtsgebiete', 'potsdam-rechtsanwalt'),
        'description' => __('Bearbeiten Sie die Rechtsgebiets-Karten auf der Startseite.', 'potsdam-rechtsanwalt'),
        'priority'    => 50,
    ));
    
    // Anzahl der Rechtsgebiete
    $wp_customize->add_setting('services_count', array(
        'default'   => 4,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('services_count', array(
        'label'       => __('Anzahl Rechtsgebiete', 'potsdam-rechtsanwalt'),
        'description' => __('Wie viele Rechtsgebiets-Karten sollen angezeigt werden? (1-8)', 'potsdam-rechtsanwalt'),
        'section'     => 'services',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 8,
            'step' => 1,
        ),
    ));
    
    // Standardwerte für die 4 vorhandenen Rechtsgebiete
    $default_services = array(
        1 => array(
            'title' => 'Miet- / Wohnungseigentumsrecht',
            'description' => 'Umfassende Beratung bei Wohnungs- und Gewerbemietrecht, Kündigungen, Mietminderungen und WEG-Recht.',
            'link' => '/miet-wohnungseigentumsrecht',
        ),
        2 => array(
            'title' => 'Grundstücks- / Immobilienrecht',
            'description' => 'Kaufverträge, Förderdarlehen (ILB/IBB), Nachbarschaftsrecht und alle immobilienrechtlichen Angelegenheiten.',
            'link' => '/grundstuecks-immobilienrecht',
        ),
        3 => array(
            'title' => 'Baurecht',
            'description' => 'Bauverträge (BGB/VOB), Baumängel, Gewährleistung, Architektenrecht und bauplanungsrechtliche Fragen.',
            'link' => '/baurecht',
        ),
        4 => array(
            'title' => 'BU / Erwerbsminderungsrente',
            'description' => 'Durchsetzung von Ansprüchen bei Berufsunfähigkeit und Erwerbsminderung gegenüber Versicherungen und Behörden.',
            'link' => '/bu-erwerbsminderungsrente',
        ),
    );
    
    // Felder für bis zu 8 Rechtsgebiete
    for ($i = 1; $i <= 8; $i++) {
        $default_title = isset($default_services[$i]) ? $default_services[$i]['title'] : '';
        $default_desc = isset($default_services[$i]) ? $default_services[$i]['description'] : '';
        $default_link = isset($default_services[$i]) ? $default_services[$i]['link'] : '';
        
        // Titel
        $wp_customize->add_setting("service_{$i}_title", array(
            'default'   => $default_title,
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("service_{$i}_title", array(
            'label'    => sprintf(__('Rechtsgebiet %d - Titel', 'potsdam-rechtsanwalt'), $i),
            'section'  => 'services',
            'type'     => 'text',
        ));
        
        // Beschreibung
        $wp_customize->add_setting("service_{$i}_description", array(
            'default'   => $default_desc,
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("service_{$i}_description", array(
            'label'    => sprintf(__('Rechtsgebiet %d - Beschreibung', 'potsdam-rechtsanwalt'), $i),
            'section'  => 'services',
            'type'     => 'textarea',
        ));
        
        // Link
        $wp_customize->add_setting("service_{$i}_link", array(
            'default'   => $default_link,
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("service_{$i}_link", array(
            'label'       => sprintf(__('Rechtsgebiet %d - Link', 'potsdam-rechtsanwalt'), $i),
            'description' => __('Relativer Pfad (z.B. /baurecht) oder vollständige URL', 'potsdam-rechtsanwalt'),
            'section'     => 'services',
            'type'        => 'text',
        ));
    }
    
    // Footer
    $wp_customize->add_section('footer_content', array(
        'title'       => __('Footer', 'potsdam-rechtsanwalt'),
        'description' => __('Bearbeiten Sie den Footer-Bereich "Über uns"', 'potsdam-rechtsanwalt'),
        'priority'    => 60,
    ));
    
    // Footer Titel
    $wp_customize->add_setting('footer_about_title', array(
        'default'   => 'Über uns',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_about_title', array(
        'label'    => __('Überschrift', 'potsdam-rechtsanwalt'),
        'section'  => 'footer_content',
        'type'     => 'text',
    ));
    
    // Footer Text
    $wp_customize->add_setting('footer_about_text', array(
        'default'   => 'Ihre kompetenten Rechtsanwälte in Potsdam. Wir bieten professionelle Rechtsberatung in allen wichtigen Rechtsgebieten mit persönlichem Service und langjähriger Erfahrung.',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_about_text', array(
        'label'    => __('Beschreibungstext', 'potsdam-rechtsanwalt'),
        'section'  => 'footer_content',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'potsdam_rechtsanwalt_customizer');
