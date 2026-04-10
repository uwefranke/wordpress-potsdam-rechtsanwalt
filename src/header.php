<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
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
        
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => 'potsdam_rechtsanwalt_fallback_menu',
            ));
            ?>
            <a href="#kontakt" class="cta-button">TERMIN VEREINBAREN</a>
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
