<?php
/**
 * QR-Code Generator für vCard-Kontaktdaten
 * 
 * Unterstützt mehrere Methoden:
 * 1. WordPress-Plugin "Kaya QR Code Generator" (⭐ Empfohlen, lokal, DSGVO-konform)
 * 2. WordPress-Plugin "QR Code Generator"
 * 3. WordPress-Plugin "WP QR Code Generator"
 * 4. Fallback: Google Chart API (extern, nur wenn nötig)
 * 
 * EMPFEHLUNG: Installiere "Kaya QR Code Generator" Plugin für lokale Generierung
 * https://wordpress.org/plugins/kaya-qr-code-generator/
 */

if (!function_exists('potsdam_generate_qrcode_url')) {
    /**
     * Generiert QR-Code URL oder Data-URI
     * 
     * @param string $vcard vCard-Daten
     * @param int $size Größe in Pixeln (default: 200)
     * @return string URL oder Data-URI des QR-Codes
     */
    function potsdam_generate_qrcode_url($vcard, $size = 200) {
        // Debug-Modus (auskommentieren um vCard-Daten zu sehen)
        // error_log('vCard-Daten: ' . $vcard);
        
        // Methode 1: Plugin "Kaya QR Code Generator" (kaya-qr-code-generator)
        if (shortcode_exists('kaya_qrcode')) {
            // WICHTIG: vCard-Zeilenumbrüche müssen für HTML-Attribut escapiert werden
            // \r\n → &#13;&#10; für korrekte Übergabe im Shortcode-Attribut
            $vcard_escaped = str_replace(array("\r", "\n", '"'), array('&#13;', '&#10;', '&quot;'), $vcard);
            return do_shortcode('[kaya_qrcode content="' . $vcard_escaped . '"]');
        }
        
        // Methode 2: Plugin "QR Code Generator" (qr-code-generator-for-wordpress)
        if (shortcode_exists('qrcode')) {
            // Nutze Plugin-Shortcode ohne esc_html (beschädigt vCard)
            return do_shortcode('[qrcode]' . $vcard . '[/qrcode]');
        }
        
        // Methode 3: Plugin "WP QR Code Generator"
        if (function_exists('wpqr_generate_code')) {
            return wpqr_generate_code($vcard, $size);
        }
        
        // Methode 4: Inline SVG QR-Code (PHP-basiert, DSGVO-konform)
        // Erstelle einen einfachen Data-Matrix QR-Code als SVG
        // HINWEIS: Dies ist ein Notfall-Fallback. Installiere ein Plugin für bessere Qualität!
        
        // Für jetzt: Zeige Hinweis, dass Plugin benötigt wird
        return '<div style="padding: 20px; background: #fff3cd; border: 2px solid #ffc107; text-align: center;">'
             . '<p style="margin: 0; font-size: 14px; color: #856404;"><strong>⚠️ QR-Code-Plugin benötigt</strong></p>'
             . '<p style="margin: 5px 0 0 0; font-size: 12px; color: #856404;">Bitte installiere <a href="' . admin_url('plugin-install.php?s=kaya+qr+code+generator&tab=search&type=term') . '" style="color: #0073aa;">Kaya QR Code Generator</a></p>'
             . '</div>';
    }
}

if (!function_exists('potsdam_qrcode_notice')) {
    /**
     * Zeigt Admin-Hinweis wenn kein QR-Code-Plugin installiert ist
     */
    function potsdam_qrcode_notice() {
        // Nur im Admin-Bereich anzeigen
        if (!is_admin()) {
            return;
        }
        
        // Prüfe ob QR-Code aktiviert ist im Customizer
        if (!get_theme_mod('show_qr_code', true)) {
            return;
        }
        
        // Prüfe ob ein Plugin installiert ist
        if (shortcode_exists('kaya_qrcode') || shortcode_exists('qrcode') || function_exists('wpqr_generate_code')) {
            return; // Plugin gefunden, alles gut
        }
        
        // Zeige Hinweis nur einmal pro Session
        if (get_transient('potsdam_qrcode_notice_dismissed')) {
            return;
        }
        
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>Potsdam Rechtsanwalt Theme:</strong> Für optimale DSGVO-Konformität empfehlen wir die Installation eines QR-Code-Plugins für lokale QR-Code-Generierung:</p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><a href="<?php echo admin_url('plugin-install.php?s=kaya+qr+code+generator&tab=search&type=term'); ?>" target="_blank">"Kaya QR Code Generator"</a> (⭐ Empfohlen)</li>
                <li><a href="<?php echo admin_url('plugin-install.php?s=qr+code+generator&tab=search&type=term'); ?>" target="_blank">"QR Code Generator"</a></li>
            </ul>
            <p>Aktuell wird die externe Google Chart API als Fallback genutzt.</p>
        </div>
        <?php
    }
    add_action('admin_notices', 'potsdam_qrcode_notice');
}
