<?php
/**
 * Template für einzelne Seiten
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
