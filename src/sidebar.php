<aside class="sidebar" id="kontakt">
    
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
        
        <?php if (get_theme_mod('contact_name', 'Rechtsanwalt Matthias Lange')) : ?>
        <p style="margin-bottom: 15px;">
            <strong><?php echo esc_html(get_theme_mod('contact_name', 'Rechtsanwalt Matthias Lange')); ?></strong>
        </p>
        <?php endif; ?>
        
        <p style="margin-bottom: 15px;">
            <strong>Telefon:</strong><br>
            <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('contact_phone', '+49 331 123456'))); ?>" style="color: var(--color-navy); text-decoration: none;">
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
            <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de')); ?>" style="color: #d4af37;">
                <?php echo esc_html(get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de')); ?>
            </a>
        </p>
        
        <p style="margin-bottom: <?php echo get_theme_mod('show_qr_code', true) ? '20px' : '0'; ?>;">
            <strong>Adresse:</strong><br>
            <?php echo nl2br(esc_html(get_theme_mod('contact_address', 'Musterstraße 123\n14467 Potsdam'))); ?>
        </p>
        
        <?php if (get_theme_mod('show_qr_code', true)) : 
            // vCard-Daten generieren
            $name = get_theme_mod('contact_name', 'Rechtsanwalt Matthias Lange');
            $phone = get_theme_mod('contact_phone', '+49 331 123456');
            $fax = get_theme_mod('contact_fax', '');
            $email = get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de');
            $address = str_replace('\n', ', ', get_theme_mod('contact_address', 'Musterstraße 123, 14467 Potsdam'));
            
            // vCard 3.0 Format
            $vcard = "BEGIN:VCARD\n";
            $vcard .= "VERSION:3.0\n";
            $vcard .= "FN:" . $name . "\n";
            $vcard .= "TEL;TYPE=WORK,VOICE:" . $phone . "\n";
            if ($fax) {
                $vcard .= "TEL;TYPE=WORK,FAX:" . $fax . "\n";
            }
            $vcard .= "EMAIL:" . $email . "\n";
            $vcard .= "ADR;TYPE=WORK:;;" . $address . "\n";
            $vcard .= "END:VCARD";
            
            // QR-Code URL generieren (nutzt Plugin wenn verfügbar)
            $qr_url = potsdam_generate_qrcode_url($vcard, 200);
        ?>
        <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="font-size: 12px; color: #888; margin-bottom: 10px;">Kontakt speichern:</p>
            <?php if (strpos($qr_url, '<') === 0) : ?>
                <!-- Plugin gibt HTML/Shortcode zurück -->
                <?php echo $qr_url; ?>
            <?php else : ?>
                <!-- Plugin gibt URL/Data-URI zurück -->
                <img src="<?php echo esc_url($qr_url); ?>" alt="QR-Code Kontaktdaten" style="max-width: 150px; height: auto; border-radius: 4px;" loading="lazy">
            <?php endif; ?>
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
            <a href="<?php echo get_theme_mod('social_linkedin', '#'); ?>" class="social-icon" target="_blank" rel="noopener" title="LinkedIn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
            </a>
            <a href="<?php echo get_theme_mod('social_xing', '#'); ?>" class="social-icon" target="_blank" rel="noopener" title="XING">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
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
