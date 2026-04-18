<?php
/**
 * Mail-Einstellungen
 * 
 * Filter für WordPress wp_mail() Absender-Einstellungen
 * Wird von functions.php inkludiert
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter: Absender-E-Mail für WordPress-Mails
 */
function potsdam_rechtsanwalt_mail_from($email) {
    $mail_from = get_theme_mod('mail_from_address', '');
    
    if (!empty($mail_from) && is_email($mail_from)) {
        return sanitize_email($mail_from);
    }
    
    return $email;
}
add_filter('wp_mail_from', 'potsdam_rechtsanwalt_mail_from');

/**
 * Filter: Absender-Name für WordPress-Mails
 */
function potsdam_rechtsanwalt_mail_from_name($name) {
    $mail_name = get_theme_mod('mail_from_name', '');
    
    if (!empty($mail_name)) {
        return sanitize_text_field($mail_name);
    }
    
    return $name;
}
add_filter('wp_mail_from_name', 'potsdam_rechtsanwalt_mail_from_name');
