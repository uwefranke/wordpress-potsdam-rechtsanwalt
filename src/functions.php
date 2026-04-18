<?php
/**
 * Potsdam Rechtsanwalt Theme Functions
 */

// Include zusätzlicher Funktionsdateien
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/github-updater.php';
require get_template_directory() . '/inc/mail-settings.php';
require get_template_directory() . '/inc/qrcode-generator.php';
require get_template_directory() . '/inc/shortcodes.php';

// Theme-Setup
function potsdam_rechtsanwalt_setup() {
    // Theme-Support hinzufügen
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Navigationmenüs registrieren
    register_nav_menus(array(
        'primary' => __('Hauptmenü', 'potsdam-rechtsanwalt'),
        'footer' => __('Footer-Menü', 'potsdam-rechtsanwalt'),
    ));
}
add_action('after_setup_theme', 'potsdam_rechtsanwalt_setup');

// Sidebar registrieren
function potsdam_rechtsanwalt_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'potsdam-rechtsanwalt'),
        'id'            => 'sidebar-1',
        'description'   => __('Sidebar-Widget-Bereich', 'potsdam-rechtsanwalt'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'potsdam-rechtsanwalt'),
        'id'            => 'footer-1',
        'description'   => __('Footer Widget Bereich 1', 'potsdam-rechtsanwalt'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'potsdam-rechtsanwalt'),
        'id'            => 'footer-2',
        'description'   => __('Footer Widget Bereich 2', 'potsdam-rechtsanwalt'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget 3', 'potsdam-rechtsanwalt'),
        'id'            => 'footer-3',
        'description'   => __('Footer Widget Bereich 3', 'potsdam-rechtsanwalt'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'potsdam_rechtsanwalt_widgets_init');

// Skripte und Styles einbinden
function potsdam_rechtsanwalt_scripts() {
    // Theme-Version automatisch aus style.css lesen
    $theme = wp_get_theme();
    $theme_version = $theme->get('Version');
    
    // Lokale Fonts (DSGVO-konform)
    wp_enqueue_style('potsdam-rechtsanwalt-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), $theme_version);
    
    // Cookie-Consent Stylesheet
    wp_enqueue_style('potsdam-cookie-consent', get_template_directory_uri() . '/assets/css/cookie-consent.css', array(), $theme_version);
    
    // Haupt-Stylesheet
    wp_enqueue_style('potsdam-rechtsanwalt-style', get_stylesheet_uri(), array('potsdam-rechtsanwalt-fonts'), $theme_version);
    
    // jQuery (ist bereits in WordPress enthalten)
    wp_enqueue_script('jquery');
    
    // Dark Mode Script (im <head> laden, damit es sofort verfügbar ist und kein Flackern entsteht)
    wp_enqueue_script('potsdam-darkmode', get_template_directory_uri() . '/assets/js/darkmode.js', array(), $theme_version, false);
    
    // Cookie-Consent Script
    wp_enqueue_script('potsdam-cookie-consent', get_template_directory_uri() . '/assets/js/cookie-consent.js', array(), $theme_version, true);
    
    // Custom JavaScript
    wp_enqueue_script('potsdam-rechtsanwalt-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $theme_version, true);
}
add_action('wp_enqueue_scripts', 'potsdam_rechtsanwalt_scripts');

// Kontaktformular verarbeiten
function potsdam_rechtsanwalt_process_contact_form() {
    if (isset($_POST['potsdam_contact_nonce']) && wp_verify_nonce($_POST['potsdam_contact_nonce'], 'potsdam_contact_form')) {
        
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $phone = sanitize_text_field($_POST['contact_phone']);
        $subject = sanitize_text_field($_POST['contact_subject']);
        $message = sanitize_textarea_field($_POST['contact_message']);
        
        // E-Mail an den Administrator senden
        $to = get_option('admin_email');
        $email_subject = 'Neue Kontaktanfrage: ' . $subject;
        $email_body = "Name: $name\n";
        $email_body .= "E-Mail: $email\n";
        $email_body .= "Telefon: $phone\n\n";
        $email_body .= "Nachricht:\n$message";
        
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $name . ' <' . $email . '>',
            'Reply-To: ' . $email
        );
        
        if (wp_mail($to, $email_subject, $email_body, $headers)) {
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
            exit;
        } else {
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
            exit;
        }
    }
}
add_action('admin_post_nopriv_contact_form', 'potsdam_rechtsanwalt_process_contact_form');
add_action('admin_post_contact_form', 'potsdam_rechtsanwalt_process_contact_form');

// Excerpt-Länge anpassen
function potsdam_rechtsanwalt_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'potsdam_rechtsanwalt_excerpt_length');

// Custom Excerpt More
function potsdam_rechtsanwalt_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'potsdam_rechtsanwalt_excerpt_more');

// Browser-Titel für Homepage anpassen (nur Website-Name, ohne "Home")
function potsdam_rechtsanwalt_custom_document_title($title_parts) {
    // Nur auf der Startseite
    if (is_front_page() && is_home()) {
        // Nur Website-Name, ohne Seitentitel
        unset($title_parts['title']);
    }
    return $title_parts;
}
add_filter('document_title_parts', 'potsdam_rechtsanwalt_custom_document_title', 999);

// Rank Math SEO Plugin Support - Homepage-Titel ohne "Home" (sehr hohe Priority)
function potsdam_rechtsanwalt_rankmath_title($title) {
    if (is_front_page() && is_home()) {
        // Entferne "Home - " oder " - Home" oder "Home | " etc.
        $title = preg_replace('/^Home\s*[-|]\s*/', '', $title);
        $title = preg_replace('/\s*[-|]\s*Home$/', '', $title);
    }
    return $title;
}
add_filter('rank_math/frontend/title', 'potsdam_rechtsanwalt_rankmath_title', 999);

// Alternativ: wp_title Filter für ältere Plugins
add_filter('wp_title', 'potsdam_rechtsanwalt_rankmath_title', 999);

// Pre-get document title Filter (läuft vor allen anderen)
add_filter('pre_get_document_title', function($title) {
    if (is_front_page() && is_home()) {
        return get_bloginfo('name');
    }
    return $title;
}, 999);

// Letzter Ausweg: Output Buffer für Homepage-Titel
function potsdam_rechtsanwalt_fix_homepage_title() {
    if (is_front_page() && is_home()) {
        ob_start(function($buffer) {
            // Ersetze "Home - " im <title> Tag
            $site_name = get_bloginfo('name');
            $buffer = preg_replace(
                '/<title>Home\s*[-|]\s*([^<]+)<\/title>/i',
                '<title>$1</title>',
                $buffer
            );
            // Auch in Meta-Tags
            $buffer = preg_replace(
                '/(property="og:title"\s+content=")Home\s*[-|]\s*([^"]+)(")/i',
                '$1$2$3',
                $buffer
            );
            $buffer = preg_replace(
                '/(name="twitter:title"\s+content=")Home\s*[-|]\s*([^"]+)(")/i',
                '$1$2$3',
                $buffer
            );
            return $buffer;
        });
    }
}
add_action('template_redirect', 'potsdam_rechtsanwalt_fix_homepage_title', 1);
