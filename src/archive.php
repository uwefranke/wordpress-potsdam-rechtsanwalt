<?php
/**
 * Archive Template
 */

get_header();
?>

<div class="container">
    <div class="wrapper">
        <main class="main-content">
            <div class="content-area">
                
                <?php
                // Archive-Titel
                the_archive_title('<h1>', '</h1>');
                the_archive_description('<div class="archive-description" style="margin-bottom: 40px;">', '</div>');
                ?>
                
                <?php if (have_posts()) : ?>
                    
                    <div class="archive-posts">
                        <?php
                        while (have_posts()) : the_post();
                            ?>
                            <article class="archive-post" style="margin-bottom: 40px; padding-bottom: 40px; border-bottom: 1px solid #eee;">
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail" style="margin-bottom: 20px;">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: auto; border-radius: 8px;')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <h2 style="margin-bottom: 10px;">
                                    <a href="<?php the_permalink(); ?>" style="color: var(--color-navy); text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <div class="post-meta" style="margin-bottom: 15px; font-size: 14px; color: #888;">
                                    <span>Veröffentlicht am <?php echo get_the_date(); ?></span>
                                    <?php if (has_category()) : ?>
                                        <span> | <?php the_category(', '); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="post-excerpt" style="margin-bottom: 20px;">
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
                        ?>
                    </div>
                    
                <?php else : ?>
                    
                    <div style="text-align: center; padding: 60px 20px;">
                        <h2>Keine Beiträge gefunden</h2>
                        <p>In diesem Archiv sind derzeit keine Beiträge vorhanden.</p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn" style="margin-top: 20px;">
                            Zur Startseite
                        </a>
                    </div>
                    
                <?php endif; ?>
                
            </div>
        </main>
        
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
