<?php
/**
 * Haupttemplate-Datei
 */

get_header();
?>

<!-- Hero Section -->
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

<!-- Main Content -->
<div class="container">
    <div class="wrapper">
        <!-- Main Content Area -->
        <main class="main-content">
            
            <!-- Services Section -->
            <section class="services-section" id="rechtsgebiete">
                <h2 class="section-title">Unsere Rechtsgebiete</h2>
                <div class="services-grid">
                    <?php potsdam_display_service_cards(); ?>
                </div>
            </section>
            
            <!-- Content Area -->
            <div class="content-area">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <h2><?php the_title(); ?></h2>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </article>
                        <?php
                    endwhile;
                else :
                    ?>
                    <article>
                        <h2>Willkommen bei Ihrer Kanzlei in Potsdam</h2>
                        <p>Wir sind Ihre kompetenten Ansprechpartner für alle rechtlichen Angelegenheiten in Potsdam und Umgebung. Mit langjähriger Erfahrung und persönlichem Engagement setzen wir uns für Ihre Interessen ein.</p>
                        
                        <h3 class="mt-40">Warum unsere Kanzlei?</h3>
                        <ul>
                            <li><strong>Erfahrung:</strong> Über 15 Jahre Praxis in verschiedenen Rechtsgebieten</li>
                            <li><strong>Persönlich:</strong> Individuelle Betreuung und direkte Ansprechpartner</li>
                            <li><strong>Kompetent:</strong> Spezialisierte Rechtsanwälte für Ihr Anliegen</li>
                            <li><strong>Transparent:</strong> Klare Kostenstruktur und verständliche Beratung</li>
                        </ul>
                        
                        <h3 class="mt-40">Vereinbaren Sie einen Termin</h3>
                        <p>Nutzen Sie unser Kontaktformular oder rufen Sie uns direkt an. Wir freuen uns auf Ihre Anfrage und beraten Sie gerne in einem persönlichen Gespräch.</p>
                    </article>
                    <?php
                endif;
                ?>
            </div>
            
        </main>
        
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
        
    </div>
</div>

<?php get_footer(); ?>
