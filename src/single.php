<?php
/**
 * Template für einzelne Beiträge
 */

get_header();
?>

<div class="container">
    <div class="wrapper">
        <main class="main-content">
            <div class="content-area">
                <?php
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h1><?php the_title(); ?></h1>
                        
                        <div class="post-meta" style="margin-bottom: 20px; color: #888; font-size: 14px;">
                            <span>Veröffentlicht am <?php echo get_the_date(); ?></span>
                            <?php if (has_category()) : ?>
                                <span> | Kategorie: <?php the_category(', '); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail" style="margin-bottom: 30px;">
                                <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 8px;')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php if (has_tag()) : ?>
                            <div class="post-tags" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                <strong>Tags:</strong> <?php the_tags('', ', ', ''); ?>
                            </div>
                        <?php endif; ?>
                    </article>
                    
                    <!-- Vorheriger/Nächster Beitrag -->
                    <nav class="post-navigation" style="margin-top: 40px; display: flex; justify-content: space-between;">
                        <div>
                            <?php previous_post_link('%link', '← %title'); ?>
                        </div>
                        <div>
                            <?php next_post_link('%link', '%title →'); ?>
                        </div>
                    </nav>
                    
                    <?php
                    // Kommentare anzeigen (falls aktiviert)
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                    <?php
                endwhile;
                ?>
            </div>
        </main>
        
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
