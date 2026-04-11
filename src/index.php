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
    $hero_style = sprintf('style="background-image: linear-gradient(rgba(26, 58, 92, 0.7), rgba(26, 58, 92, 0.7)), url(%s);"', esc_url($hero_image));
}
?>
<section class="hero-section" <?php echo $hero_style; ?>>
    <div class="hero-content">
        <h1><?php echo get_theme_mod('hero_title', 'IHRE KANZLEI IN POTSDAM'); ?></h1>
        <p class="hero-subtitle"><?php echo get_theme_mod('hero_text', 'FÜR RECHT, DAS VERTRAUEN SCHAFFT. KOMPETENT & LOKAL.'); ?></p>
        <div class="hero-buttons">
            <a href="#rechtsgebiete" class="btn btn-primary">UNSERE LEISTUNGEN</a>
            <a href="#kontakt" class="btn btn-secondary">TERMIN VEREINBAREN</a>
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
                    
                    <!-- Miet- / Wohnungseigentumsrecht -->
                    <a href="<?php echo esc_url(home_url('/miet-wohnungseigentumsrecht')); ?>" class="service-card-link">
                        <div class="service-card">
                            <div class="service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 10h6M9 14h6M9 18h6M3 10v9a2 2 0 002 2h14a2 2 0 002-2v-9M3 5a2 2 0 012-2h14a2 2 0 012 2v5H3z"></path>
                                </svg>
                            </div>
                            <h3>Miet- / Wohnungseigentumsrecht</h3>
                            <p>Umfassende Beratung bei Wohnungs- und Gewerbemietrecht, Kündigungen, Mietminderungen und WEG-Recht.</p>
                            <span class="service-link-arrow">Mehr erfahren →</span>
                        </div>
                    </a>
                    
                    <!-- Grundstücks- / Immobilienrecht -->
                    <a href="<?php echo esc_url(home_url('/grundstuecks-immobilienrecht')); ?>" class="service-card-link">
                        <div class="service-card">
                            <div class="service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <h3>Grundstücks- / Immobilienrecht</h3>
                            <p>Kaufverträge, Förderdarlehen (ILB/IBB), Nachbarschaftsrecht und alle immobilienrechtlichen Angelegenheiten.</p>
                            <span class="service-link-arrow">Mehr erfahren →</span>
                        </div>
                    </a>
                    
                    <!-- Baurecht -->
                    <a href="<?php echo esc_url(home_url('/baurecht')); ?>" class="service-card-link">
                        <div class="service-card">
                            <div class="service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"></path>
                                </svg>
                            </div>
                            <h3>Baurecht</h3>
                            <p>Bauverträge (BGB/VOB), Baumängel, Gewährleistung, Architektenrecht und bauplanungsrechtliche Fragen.</p>
                            <span class="service-link-arrow">Mehr erfahren →</span>
                        </div>
                    </a>
                    
                    <!-- BU / Erwerbsminderungsrente -->
                    <a href="<?php echo esc_url(home_url('/bu-erwerbsminderungsrente')); ?>" class="service-card-link">
                        <div class="service-card">
                            <div class="service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h3>BU / Erwerbsminderungsrente</h3>
                            <p>Durchsetzung von Ansprüchen bei Berufsunfähigkeit und Erwerbsminderung gegenüber Versicherungen und Behörden.</p>
                            <span class="service-link-arrow">Mehr erfahren →</span>
                        </div>
                    </a>
                    
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
