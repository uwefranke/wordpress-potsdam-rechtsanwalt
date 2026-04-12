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
}
add_action('customize_register', 'potsdam_rechtsanwalt_customizer');
