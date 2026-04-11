<footer class="site-footer">
    <div class="footer-content">
        
        <!-- Footer Widget 1: Über uns -->
        <div class="footer-section">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <?php dynamic_sidebar('footer-1'); ?>
            <?php else : ?>
                <h4>Über uns</h4>
                <p>Ihre kompetenten Rechtsanwälte in Potsdam. Wir bieten professionelle Rechtsberatung in allen wichtigen Rechtsgebieten mit persönlichem Service und langjähriger Erfahrung.</p>
            <?php endif; ?>
        </div>
        
        <!-- Footer Widget 2: Rechtsgebiete -->
        <div class="footer-section">
            <?php if (is_active_sidebar('footer-2')) : ?>
                <?php dynamic_sidebar('footer-2'); ?>
            <?php else : ?>
                <h4>Rechtsgebiete</h4>
                <a href="<?php echo esc_url(home_url('/rechtsgebiete/miet-wohnungseigentumsrecht/')); ?>">Miet- / Wohnungseigentumsrecht</a>
                <a href="<?php echo esc_url(home_url('/rechtsgebiete/grundstuecks-immobilienrecht/')); ?>">Grundstücks- / Immobilienrecht</a>
                <a href="<?php echo esc_url(home_url('/rechtsgebiete/baurecht/')); ?>">Baurecht</a>
                <a href="<?php echo esc_url(home_url('/rechtsgebiete/bu-erwerbsminderungsrente/')); ?>">BU / Erwerbsminderungsrente</a>
            <?php endif; ?>
        </div>
        
        <!-- Footer Widget 3: Kontakt -->
        <div class="footer-section">
            <?php if (is_active_sidebar('footer-3')) : ?>
                <?php dynamic_sidebar('footer-3'); ?>
            <?php else : ?>
                <h4>Kontakt</h4>
                <p>
                    <strong>Telefon:</strong><br>
                    <?php echo get_theme_mod('contact_phone', '+49 331 123456'); ?>
                </p>
                <p>
                    <strong>E-Mail:</strong><br>
                    <a href="mailto:<?php echo get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de'); ?>">
                        <?php echo get_theme_mod('contact_email', 'info@potsdam-rechtsanwalt.de'); ?>
                    </a>
                </p>
                <p>
                    <strong>Adresse:</strong><br>
                    <?php echo nl2br(get_theme_mod('contact_address', 'Musterstraße 123<br>14467 Potsdam')); ?>
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Footer Widget 4: Links -->
        <div class="footer-section">
            <h4>Weitere Links</h4>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => 'potsdam_rechtsanwalt_footer_fallback_menu',
            ));
            ?>
        </div>
        
    </div>
    
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Alle Rechte vorbehalten. | 
        <a href="<?php echo esc_url(home_url('/impressum')); ?>" style="color: rgba(255, 255, 255, 0.6); text-decoration: none;">Impressum</a> | 
        <a href="<?php echo esc_url(home_url('/datenschutz')); ?>" style="color: rgba(255, 255, 255, 0.6); text-decoration: none;">Datenschutz</a></p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

<?php
// Fallback Footer-Menü
function potsdam_rechtsanwalt_footer_fallback_menu() {
    echo '<ul style="list-style: none; padding: 0;">';
    echo '<li><a href="' . esc_url(home_url('/impressum')) . '">Impressum</a></li>';
    echo '<li><a href="' . esc_url(home_url('/datenschutz')) . '">Datenschutz</a></li>';
    echo '<li><a href="' . esc_url(home_url('/agb')) . '">AGB</a></li>';
    echo '</ul>';
}
?>
