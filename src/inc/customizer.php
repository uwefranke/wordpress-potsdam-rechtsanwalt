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
    
    $wp_customize->add_setting('contact_phone', array(
        'default'   => '+49 331 123456',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Telefonnummer', 'potsdam-rechtsanwalt'),
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
    
    $wp_customize->add_setting('contact_address', array(
        'default'   => 'Musterstraße 123, 14467 Potsdam',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_address', array(
        'label'    => __('Adresse', 'potsdam-rechtsanwalt'),
        'section'  => 'contact_info',
        'type'     => 'textarea',
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
}
add_action('customize_register', 'potsdam_rechtsanwalt_customizer');
