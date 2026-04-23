<aside class="sidebar" id="kontakt" role="complementary">
    
    <?php if (get_theme_mod('show_contact_form', true)) : ?>
    <!-- Kontaktformular -->
    <div class="widget contact-widget">
        <h3>Kontaktieren Sie uns</h3>
        
        <?php
        // Erfolgsmeldung anzeigen
        if (isset($_GET['contact']) && $_GET['contact'] === 'success') :
            ?>
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                Vielen Dank! Ihre Nachricht wurde erfolgreich versendet.
            </div>
            <?php
        endif;
        
        // Fehlermeldung anzeigen
        if (isset($_GET['contact']) && $_GET['contact'] === 'error') :
            ?>
            <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                Es gab ein Problem beim Versenden. Bitte versuchen Sie es erneut.
            </div>
            <?php
        endif;
        ?>
        
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
            <input type="hidden" name="action" value="contact_form">
            <?php wp_nonce_field('potsdam_contact_form', 'potsdam_contact_nonce'); ?>
            
            <div class="form-group">
                <label for="contact_name">Name *</label>
                <input type="text" id="contact_name" name="contact_name" required>
            </div>
            
            <div class="form-group">
                <label for="contact_email">E-Mail *</label>
                <input type="email" id="contact_email" name="contact_email" required>
            </div>
            
            <div class="form-group">
                <label for="contact_phone">Telefon</label>
                <input type="tel" id="contact_phone" name="contact_phone">
            </div>
            
            <div class="form-group">
                <label for="contact_subject">Betreff *</label>
                <select id="contact_subject" name="contact_subject" required>
                    <option value="">Bitte wählen...</option>
                    <option value="Verkehrsrecht">Verkehrsrecht</option>
                    <option value="Familienrecht">Familienrecht</option>
                    <option value="Vertragsrecht">Vertragsrecht</option>
                    <option value="Immobilienrecht">Immobilienrecht</option>
                    <option value="Sonstiges">Sonstiges</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="contact_message">Ihre Nachricht *</label>
                <textarea id="contact_message" name="contact_message" required></textarea>
            </div>
            
            <button type="submit" class="btn">Nachricht senden</button>
        </form>
    </div>
    <?php endif; ?>
    
    <?php if (get_theme_mod('show_appointment_button', true)) : ?>
    <!-- Terminvereinbarung Button -->
    <div class="widget appointment-widget">
        <a href="<?php echo esc_url(home_url('/termin')); ?>" class="btn btn-appointment">
            Online-Termin vereinbaren
        </a>
    </div>
    <?php endif; ?>
    
    <!-- Kontaktinformationen -->
    <div class="widget contact-info-widget" style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px;">
        <h3>Kontaktdaten</h3>
        
        <?php 
        $display_title = get_theme_mod('contact_title', 'Rechtsanwalt');
        $display_firstname = get_theme_mod('contact_firstname', 'Matthias');
        $display_lastname = get_theme_mod('contact_lastname', 'Lange');
        $display_fullname = trim($display_title . " " . $display_firstname . " " . $display_lastname);
        
        if ($display_fullname) : ?>
        <p style="margin-bottom: 15px;">
            <strong><?php echo esc_html($display_fullname); ?></strong>
        </p>
        <?php endif; ?>
        
        <p style="margin-bottom: 15px;">
            <strong>Telefon:</strong><br>
            <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('contact_phone', '+49 331 123456'))); ?>" style="color: var(--color-navy); text-decoration: underline;">
                <?php echo esc_html(get_theme_mod('contact_phone', '+49 331 123456')); ?>
            </a>
        </p>
        
        <?php if (get_theme_mod('contact_fax')) : ?>
        <p style="margin-bottom: 15px;">
            <strong>Fax:</strong><br>
            <?php echo esc_html(get_theme_mod('contact_fax')); ?>
        </p>
        <?php endif; ?>
        
        <p style="margin-bottom: 15px;">
            <strong>E-Mail:</strong><br>
            <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de')); ?>" style="color: #1a3a5c; text-decoration: underline;"> <!-- Navy statt Gold für besseren Kontrast -->
                <?php echo esc_html(get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de')); ?>
            </a>
        </p>
        
        <p style="margin-bottom: <?php echo get_theme_mod('show_qr_code', true) ? '20px' : '0'; ?>;">
            <strong>Adresse:</strong><br>
            <?php 
            $street = get_theme_mod('contact_street', 'Schornsteinfegergasse');
            $housenumber = get_theme_mod('contact_housenumber', '5');
            $zip = get_theme_mod('contact_zip', '14482');
            $city = get_theme_mod('contact_city', 'Potsdam');
            
            echo esc_html($street . ' ' . $housenumber) . '<br>';
            echo esc_html($zip . ' ' . $city);
            ?>
        </p>
        
        <?php if (get_theme_mod('show_qr_code', true)) : 
            // vCard-Daten generieren
            $title = get_theme_mod('contact_title', 'Rechtsanwalt');
            $firstname = get_theme_mod('contact_firstname', 'Matthias');
            $lastname = get_theme_mod('contact_lastname', 'Lange');
            $phone_raw = get_theme_mod('contact_phone', '+49 331 123456');
            $fax_raw = get_theme_mod('contact_fax', '');
            $email = get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de');
            
            // Adresse aus strukturierten Feldern
            $street = get_theme_mod('contact_street', 'Schornsteinfegergasse');
            $housenumber = get_theme_mod('contact_housenumber', '5');
            $zip = get_theme_mod('contact_zip', '14482');
            $city = get_theme_mod('contact_city', 'Potsdam');
            $state = get_theme_mod('contact_state', 'Brandenburg');
            $country = get_theme_mod('contact_country', 'Deutschland');
            
            // Telefonnummern für vCard normalisieren (E.164-Format)
            // Entfernt Leerzeichen, Schrägstriche, Bindestriche
            // Wandelt deutsche 0-Vorwahl in +49 um
            $phone = preg_replace('/[\s\/\-().]/', '', $phone_raw); // Entferne Formatierung
            if (substr($phone, 0, 1) === '0' && substr($phone, 0, 2) !== '00') {
                $phone = '+49' . substr($phone, 1); // 0331 -> +49331
            }
            
            $fax = '';
            if ($fax_raw) {
                $fax = preg_replace('/[\s\/\-().]/', '', $fax_raw);
                if (substr($fax, 0, 1) === '0' && substr($fax, 0, 2) !== '00') {
                    $fax = '+49' . substr($fax, 1);
                }
            }
            
            // vCard 3.0 Format mit korrekten Zeilenumbrüchen (CRLF)
            $vcard = "BEGIN:VCARD\r\n";
            $vcard .= "VERSION:3.0\r\n";
            
            // N: Strukturierter Name (Nachname;Vorname;Weitere Namen;Präfix;Suffix)
            $vcard .= "N:" . $lastname . ";" . $firstname . ";;;\r\n";
            
            // FN: Vollständiger Anzeigename (wie er erscheinen soll)
            $fullname = trim($title . " " . $firstname . " " . $lastname);
            $vcard .= "FN:" . $fullname . "\r\n";
            
            // TITLE: Berufsbezeichnung
            if (!empty($title)) {
                $vcard .= "TITLE:" . $title . "\r\n";
            }
            
            $vcard .= "TEL;TYPE=WORK,VOICE:" . $phone . "\r\n";
            if ($fax) {
                $vcard .= "TEL;TYPE=WORK,FAX:" . $fax . "\r\n";
            }
            $vcard .= "EMAIL:" . $email . "\r\n";
            
            // ADR-Format: PO-Box;Extended;Street;City;State;ZIP;Country
            // Straße inkl. Hausnummer für bessere Kompatibilität
            $full_street = trim($street . ' ' . $housenumber);
            $vcard .= "ADR;TYPE=WORK:;;" . $full_street . ";" . $city . ";" . $state . ";" . $zip . ";" . $country . "\r\n";
            $vcard .= "END:VCARD";
            
            // QR-Code URL generieren (nutzt Plugin wenn verfügbar)
            $qr_url = potsdam_generate_qrcode_url($vcard, 200);
        ?>
        <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="font-size: 12px; color: #555; margin-bottom: 10px;">Kontakt speichern:</p> <!-- Dunkleres Grau für WCAG AA (7.5:1) -->
            
            <?php 
            // Debug: vCard-Daten anzeigen (zum Testen)
            if (isset($_GET['debug_vcard']) && current_user_can('manage_options')) {
                echo '<div style="text-align: left; font-size: 11px; background: #fff3cd; padding: 15px; margin: 10px 0; border: 2px solid #ffc107; max-width: 90%;">';
                echo '<strong style="font-size: 13px;">🔍 DEBUG-MODUS</strong><br><br>';
                
                // Zeige verwendete QR-Code-Methode
                echo '<strong>QR-Code-Methode:</strong> ';
                if (shortcode_exists('kaya_qrcode')) {
                    echo '✅ Kaya QR Code Generator Plugin<br>';
                } elseif (shortcode_exists('qrcode')) {
                    echo '✅ QR Code Generator Plugin<br>';
                } elseif (function_exists('wpqr_generate_code')) {
                    echo '✅ WP QR Code Generator Plugin<br>';
                } else {
                    echo '⚠️ Google Chart API (Fallback - extern)<br>';
                }
                
                echo '<br><strong>vCard-Daten:</strong><br>';
                echo '<pre style="font-size: 10px; background: #f5f5f5; padding: 10px; margin: 5px 0; overflow-x: auto;">';
                echo esc_html($vcard);
                echo '</pre>';
                
                echo '<br><strong>QR-Code Output (vollständig):</strong><br>';
                echo '<pre style="font-size: 9px; background: #f5f5f5; padding: 10px; margin: 5px 0; overflow-x: auto; word-wrap: break-word; white-space: pre-wrap; max-height: 400px;">';
                echo esc_html($qr_url);
                echo '</pre>';
                
                echo '<br><strong>💡 Hinweis:</strong> Google Chart API wurde abgeschaltet (404-Fehler).<br>';
                echo 'QR-Code wird vom Plugin per JavaScript clientseitig generiert.<br>';
                echo 'Prüfe Browser-Konsole (F12) auf JavaScript-Fehler.<br>';
                
                echo '</div>';
            }
            
            if (strpos($qr_url, '<') === 0) : ?>
                <!-- Plugin gibt HTML/Shortcode zurück -->
                <?php echo $qr_url; ?>
            <?php else : ?>
                <!-- Plugin gibt URL/Data-URI zurück -->
                <img src="<?php echo esc_url($qr_url); ?>" alt="QR-Code Kontaktdaten" style="max-width: 150px; height: auto; border-radius: 4px;" loading="lazy">
            <?php endif; ?>
            
            <!-- Alternativer Download-Link für vCard (falls QR-Code nicht funktioniert) -->
            <div style="margin-top: 15px;">
                <?php
                // Data-URI für vCard-Download
                $vcard_data_uri = 'data:text/vcard;charset=utf-8,' . rawurlencode($vcard);
                
                // Dynamischer Dateiname basierend auf Namen
                $filename_slug = sanitize_title($firstname . '-' . $lastname);
                $filename = 'kontakt-' . $filename_slug . '.vcf';
                ?>
                <a href="<?php echo $vcard_data_uri; ?>" 
                   download="<?php echo esc_attr($filename); ?>"
                   style="display: inline-block; padding: 8px 16px; background: #1a3a5c; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
                    📥 Kontakt herunterladen (.vcf)
                </a>
                <p style="font-size: 11px; color: #495057; margin-top: 8px; margin-bottom: 0;">
                    Alternative: vCard-Datei direkt ins Adressbuch importieren
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Öffnungszeiten -->
    <div class="widget opening-hours-widget" style="margin-top: 20px; padding: 20px; background: white; border-radius: 8px;">
        <h3>Öffnungszeiten</h3>
        <table style="width: 100%; font-size: 14px;">
            <tr>
                <td><strong>Mo - Do:</strong></td>
                <td style="text-align: right;"><?php echo esc_html(get_theme_mod('hours_mon_thu', 'Nach Vereinbarung')); ?></td>
            </tr>
            <tr>
                <td><strong>Freitag:</strong></td>
                <td style="text-align: right;"><?php echo esc_html(get_theme_mod('hours_friday', 'Nach Vereinbarung')); ?></td>
            </tr>
            <tr>
                <td><strong>Sa & So:</strong></td>
                <td style="text-align: right;"><?php echo esc_html(get_theme_mod('hours_weekend', 'Nach Vereinbarung')); ?></td>
            </tr>
        </table>
    </div>
    
    <!-- Social Media -->
    <div class="widget social-media-widget">
        <h4>Folgen Sie uns</h4>
        <div class="social-icons">
            <a href="<?php echo get_theme_mod('social_linkedin', '#'); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="LinkedIn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" role="presentation">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
            </a>
            <a href="<?php echo get_theme_mod('social_xing', '#'); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="XING">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" role="presentation">
                    <path d="M18.188 0c-.517 0-.741.325-.927.66 0 0-7.455 13.224-7.702 13.657.015.024 4.919 9.023 4.919 9.023.17.308.436.66.967.66h3.454c.211 0 .375-.078.463-.22.089-.151.089-.346-.009-.536l-4.879-8.916c-.004-.006-.004-.016 0-.022L22.139.756c.095-.191.097-.387.006-.535C22.056.078 21.894 0 21.686 0h-3.498zM3.648 4.74c-.211 0-.385.074-.473.216-.09.149-.078.339.02.531l2.34 4.05c.004.01.004.016 0 .021L1.86 16.051c-.099.188-.093.381 0 .529.085.142.239.234.45.234h3.461c.518 0 .766-.348.945-.667l3.734-6.609-2.378-4.155c-.172-.315-.434-.659-.962-.659H3.648v.016z"/>
                </svg>
            </a>
        </div>
    </div>
    
    <?php
    // WordPress-Widgets (falls definiert)
    if (is_active_sidebar('sidebar-1')) :
        dynamic_sidebar('sidebar-1');
    endif;
    ?>
    
</aside>
