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
        // Methode 1: Plugin "Kaya QR Code Generator" (kaya-qr-code-generator)
        if (shortcode_exists('kaya_qrcode')) {
            // Nutze Kaya Plugin-Shortcode mit content-Parameter
            return do_shortcode('[kaya_qrcode content="' . esc_attr($vcard) . '"]');
        }
        
        // Methode 2: Plugin "QR Code Generator" (qr-code-generator-for-wordpress)
        if (shortcode_exists('qrcode')) {
            // Nutze Plugin-Shortcode
            return do_shortcode('[qrcode]' . esc_html($vcard) . '[/qrcode]');
        }
        
        // Methode 3: Plugin "WP QR Code Generator"
        if (function_exists('wpqr_generate_code')) {
            return wpqr_generate_code($vcard, $size);
        }
        
        // Methode 4: Google Chart API (Fallback - extern)
        // HINWEIS: Für DSGVO-Konformität sollte ein lokales Plugin verwendet werden!
        return 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chl=' . urlencode($vcard) . '&choe=UTF-8';
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
