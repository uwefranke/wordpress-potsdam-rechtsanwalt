<?php
/**
 * Template für einzelne Seiten
 */

get_header();
?>

<?php if (is_front_page()) : ?>
    <!-- Hero Section (nur auf Startseite) -->
    <?php 
    $hero_image = get_theme_mod('hero_image');
    $hero_style = '';
    if ($hero_image) {
        $hero_style = sprintf('style="background: linear-gradient(rgba(26, 58, 92, 0.7), rgba(26, 58, 92, 0.7)), url(%s) center center / cover no-repeat;"', esc_url($hero_image));
    }
    ?>
    <section class="hero-section" <?php echo $hero_style; ?>>
        <div class="hero-content">
            <h1><?php echo get_theme_mod('hero_title', 'IHRE KANZLEI IN POTSDAM'); ?></h1>
            <p class="hero-subtitle"><?php echo get_theme_mod('hero_text', 'FÜR RECHT, DAS VERTRAUEN SCHAFFT. KOMPETENT & LOKAL.'); ?></p>
            <div class="hero-buttons">
                <a href="#rechtsgebiete" class="btn btn-primary">UNSERE LEISTUNGEN</a>
                <?php if (get_theme_mod('show_appointment_button', true)) : ?>
                <a href="#kontakt" class="btn btn-secondary">TERMIN VEREINBAREN</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<div class="container">
    <div class="wrapper">
        <main class="main-content" id="main-content" role="main">
            
            <?php if (is_front_page()) : ?>
                <!-- Rechtsgebiete (nur auf Startseite) -->
                <section class="services-section" id="rechtsgebiete">
                    <h2 class="section-title">Unsere Rechtsgebiete</h2>
                    <div class="services-grid">
                        <?php potsdam_display_service_cards(); ?>
                    </div>
                </section>
            <?php endif; ?>
            
            <div class="content-area">
                <?php
                // Rank Math Breadcrumbs (nur auf Unterseiten)
                if (!is_front_page() && function_exists('rank_math_the_breadcrumbs')) {
                    echo '<div class="breadcrumbs" style="margin-bottom: 20px; font-size: 14px; color: #888;">';
                    rank_math_the_breadcrumbs();
                    echo '</div>';
                }
                
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php if (!is_front_page()) : ?>
                            <h1><?php the_title(); ?></h1>
                        <?php endif; ?>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>
        </main>
        
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
