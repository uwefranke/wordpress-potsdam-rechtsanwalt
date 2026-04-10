<?php
/**
 * 404 Error Page Template
 */

get_header();
?>

<div class="container">
    <div class="wrapper">
        <main class="main-content">
            <div class="content-area" style="text-align: center; padding: 80px 40px;">
                <h1 style="font-size: 120px; color: var(--color-navy); margin-bottom: 20px;">404</h1>
                <h2 style="font-size: 36px; color: var(--color-anthracite); margin-bottom: 30px;">Seite nicht gefunden</h2>
                <p style="font-size: 18px; margin-bottom: 40px; color: var(--color-dark-gray);">
                    Die von Ihnen gesuchte Seite existiert leider nicht oder wurde verschoben.
                </p>
                
                <div style="margin-bottom: 40px;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">
                        Zurück zur Startseite
                    </a>
                </div>
                
                <div style="max-width: 600px; margin: 60px auto 0;">
                    <h3 style="margin-bottom: 20px;">Vielleicht finden Sie hier, was Sie suchen:</h3>
                    
                    <!-- Suchformular -->
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
                        <div class="form-group">
                            <input type="search" 
                                   name="s" 
                                   placeholder="Seite durchsuchen..." 
                                   value="<?php echo get_search_query(); ?>"
                                   style="width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 4px; font-size: 16px;">
                        </div>
                        <button type="submit" class="btn" style="margin-top: 15px;">Suchen</button>
                    </form>
                    
                    <!-- Beliebte Seiten -->
                    <div style="margin-top: 50px; text-align: left;">
                        <h4>Beliebte Seiten:</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 10px;">
                                <a href="<?php echo esc_url(home_url('/rechtsgebiete')); ?>" style="color: var(--color-gold); text-decoration: none;">
                                    → Rechtsgebiete
                                </a>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <a href="<?php echo esc_url(home_url('/team')); ?>" style="color: var(--color-gold); text-decoration: none;">
                                    → Unser Team
                                </a>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" style="color: var(--color-gold); text-decoration: none;">
                                    → Kontakt
                                </a>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <a href="<?php echo esc_url(home_url('/termin')); ?>" style="color: var(--color-gold); text-decoration: none;">
                                    → Termin vereinbaren
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
