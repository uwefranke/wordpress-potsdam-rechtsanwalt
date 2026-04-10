<?php
/**
 * Haupttemplate-Datei
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
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
                    
                    <!-- Verkehrsrecht -->
                    <div class="service-card">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <h3>Verkehrsrecht</h3>
                        <p>Umfassende Beratung bei Verkehrsunfällen, Bußgeldern und Führerscheinentzug. Wir setzen Ihre Rechte durch.</p>
                    </div>
                    
                    <!-- Familienrecht -->
                    <div class="service-card">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3>Familienrecht</h3>
                        <p>Einfühlsame Unterstützung bei Scheidung, Sorgerecht, Unterhalt und allen familiären Angelegenheiten.</p>
                    </div>
                    
                    <!-- Vertragsrecht -->
                    <div class="service-card">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h3>Vertragsrecht</h3>
                        <p>Prüfung, Gestaltung und Durchsetzung von Verträgen aller Art. Professionelle rechtliche Absicherung.</p>
                    </div>
                    
                    <!-- Immobilienrecht -->
                    <div class="service-card">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <h3>Immobilienrecht</h3>
                        <p>Kompetente Beratung bei Kauf, Verkauf, Miete und allen immobilienrechtlichen Fragestellungen.</p>
                    </div>
                    
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
