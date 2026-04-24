<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    // Meta-Description: Fallback falls kein SEO-Plugin aktiv ist
    if (is_front_page() || is_home()) {
        $description = get_theme_mod('site_meta_description', 'Rechtsanwalt Matthias Lange in Potsdam - Kompetente Rechtsberatung in Mietrecht, Immobilienrecht, Baurecht und Berufsunfähigkeitsversicherung.');
    } elseif (is_singular()) {
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 25);
    } else {
        $description = get_bloginfo('description');
    }
    if (!empty($description)) {
        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n    ";
    }
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip Link für Accessibility -->
<a href="#main-content" class="skip-link">Zum Hauptinhalt springen</a>


<header class="site-header" role="banner">
    <div class="header-container">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>
        
        <button class="menu-toggle" aria-label="Menü öffnen" aria-expanded="false">
            <span class="menu-toggle-icon"></span>
        </button>
        
        <nav class="main-navigation" role="navigation" aria-label="Hauptnavigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => 'potsdam_rechtsanwalt_fallback_menu',
            ));
            ?>
            <?php if (get_theme_mod('show_appointment_button', true)) : ?>
            <a href="#kontakt" class="cta-button">TERMIN VEREINBAREN</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<?php
// Fallback-Menü falls kein Menü definiert ist
function potsdam_rechtsanwalt_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Startseite</a></li>';
    echo '<li><a href="' . esc_url(home_url('/rechtsgebiete')) . '">Rechtsgebiete</a></li>';
    echo '<li><a href="' . esc_url(home_url('/team')) . '">Team</a></li>';
    echo '<li><a href="' . esc_url(home_url('/kontakt')) . '">Kontakt</a></li>';
    echo '</ul>';
}
?>
