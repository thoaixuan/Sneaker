<?php
/**
 * The template for displaying pages
 */
get_header();
?>
<?php wp_reset_query();?>
<section id="page" class="page_wrapper container">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="feature_image">
                    <?php the_post_thumbnail('full'); ?>
                </div>
                <div class="for_title_child_page">
                    <h1><?php the_title(); ?></h1>
                </div>
                <div class="for_content_child_page">
                <?php the_content(); ?>
                </div>
            <?php endwhile;   endif; ?>
</section>
<?php
get_footer();
 ?>