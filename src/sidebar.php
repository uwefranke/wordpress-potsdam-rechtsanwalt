<aside class="sidebar">
    
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
    
    <!-- Terminvereinbarung Button -->
    <div class="widget appointment-widget">
        <a href="<?php echo esc_url(home_url('/termin')); ?>" class="btn btn-appointment">
            Online-Termin vereinbaren
        </a>
    </div>
    
    <!-- Kontaktinformationen -->
    <div class="widget contact-info-widget" style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px;">
        <h3>Kontaktdaten</h3>
        <p style="margin-bottom: 15px;">
            <strong>Telefon:</strong><br>
            <?php echo get_theme_mod('contact_phone', '+49 331 123456'); ?>
        </p>
        <p style="margin-bottom: 15px;">
            <strong>E-Mail:</strong><br>
            <a href="mailto:<?php echo get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de'); ?>" style="color: #d4af37;">
                <?php echo get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de'); ?>
            </a>
        </p>
        <p>
            <strong>Adresse:</strong><br>
            <?php echo nl2br(get_theme_mod('contact_address', 'Musterstraße 123<br>14467 Potsdam')); ?>
        </p>
    </div>
    
    <!-- Öffnungszeiten -->
    <div class="widget opening-hours-widget" style="margin-top: 20px; padding: 20px; background: white; border-radius: 8px;">
        <h3>Öffnungszeiten</h3>
        <table style="width: 100%; font-size: 14px;">
            <tr>
                <td><strong>Mo - Do:</strong></td>
                <td style="text-align: right;">09:00 - 18:00</td>
            </tr>
            <tr>
                <td><strong>Freitag:</strong></td>
                <td style="text-align: right;">09:00 - 16:00</td>
            </tr>
            <tr>
                <td><strong>Sa & So:</strong></td>
                <td style="text-align: right;">Nach Vereinbarung</td>
            </tr>
        </table>
    </div>
    
    <?php
    // WordPress-Widgets (falls definiert)
    if (is_active_sidebar('sidebar-1')) :
        dynamic_sidebar('sidebar-1');
    endif;
    ?>
    
</aside>
