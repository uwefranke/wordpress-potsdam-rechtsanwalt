<?php
/**
 * Minimale PHP QR-Code-Generierung für vCards
 * Basis-Implementation für DSGVO-konforme lokale QR-Codes
 * 
 * Verwendet die qrcode.php Library (Public Domain)
 * Download: https://github.com/chillerlan/php-qrcode
 */

if (!function_exists('potsdam_generate_qrcode_svg')) {
    /**
     * Generiert einen QR-Code als Data-URI SVG
     * FALLBACK wenn kein Plugin verfügbar
     * 
     * @param string $data Zu kodierende Daten (vCard)
     * @return string SVG Data-URI
     */
    function potsdam_generate_qrcode_svg($data) {
        // Prüfe ob chillerlan/php-qrcode verfügbar ist
        if (file_exists(get_template_directory() . '/vendor/autoload.php')) {
            require_once get_template_directory() . '/vendor/autoload.php';
            
            if (class_exists('chillerlan\QRCode\QRCode')) {
                $qrcode = new \chillerlan\QRCode\QRCode();
                return $qrcode->render($data);
            }
        }
        
        // Fallback: Hinweis anzeigen
        return null;
    }
}
