<?php
/**
 * Search Results Template
 */

get_header();
?>

<div class="container">
    <div class="wrapper">
        <main class="main-content" id="main-content" role="main">
            <div class="content-area">
                <h1>Suchergebnisse für: "<?php echo get_search_query(); ?>"</h1>
                
                <?php if (have_posts()) : ?>
                    
                    <p style="margin-bottom: 30px; color: var(--color-dark-gray);">
                        <?php
                        global $wp_query;
                        echo $wp_query->found_posts . ' Ergebnis(se) gefunden.';
                        ?>
                    </p>
                    
                    <?php
                    while (have_posts()) : the_post();
                        ?>
                        <article class="search-result" style="padding: 30px 0; border-bottom: 1px solid #eee;">
                            <h2 style="margin-bottom: 10px;">
                                <a href="<?php the_permalink(); ?>" style="color: var(--color-navy); text-decoration: none;">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div style="margin-bottom: 15px; font-size: 14px; color: #888;">
                                <span><?php echo get_the_date(); ?></span>
                                <?php if (get_post_type() === 'post' && has_category()) : ?>
                                    <span> | <?php the_category(', '); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="excerpt" style="margin-bottom: 15px;">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="btn" style="display: inline-block; padding: 10px 20px; font-size: 14px;">
                                Weiterlesen →
                            </a>
                        </article>
                        <?php
                    endwhile;
                    
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('← Zurück', 'potsdam-rechtsanwalt'),
                        'next_text' => __('Weiter →', 'potsdam-rechtsanwalt'),
                    ));
                    
                else :
                    ?>
                    <div style="text-align: center; padding: 60px 20px;">
                        <h2>Keine Ergebnisse gefunden</h2>
                        <p style="margin-bottom: 30px;">
                            Leider konnten wir keine Ergebnisse für Ihre Suche finden. 
                            Versuchen Sie es mit anderen Suchbegriffen.
                        </p>
                        
                        <!-- Neue Suche -->
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form" style="max-width: 500px; margin: 0 auto;">
                            <div class="form-group">
                                <input type="search" 
                                       name="s" 
                                       placeholder="Erneut suchen..." 
                                       value=""
                                       style="width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 4px; font-size: 16px;">
                            </div>
                            <button type="submit" class="btn" style="margin-top: 15px;">Suchen</button>
                        </form>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </main>
        
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
