<?php
/**
 * The template for displaying pages
 */
get_header();
?>
<?php wp_reset_query();?>
<?php get_template_part('sections/');?>
<section id="breckcrum" class="page_wrapper">
    <div class="container_site"> 
        <h1 class="title_child_page"><?php the_title(); ?></h1>
        <div class="content_breadcrumen_item">
			<span><i class="fas fa-home"></i></span>
			<span><a href="<?php echo get_home_url();?>">Home</a></span>
			<span class="breckcrum_space">/</span>
			<?php the_title(); ?>
		</div>
    </div>
</section>
<section id="chuyen_khoa_page" class="page_wrapper">
    <div class="container_site"> 
    <div class="left_chuyen_khoa_page">
        <?php get_template_part('sections/chuyen_khoa_left_colum_all');?>
    </div>
    <div class="right_chuyen_khoa_page">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="feature_image">
                    <?php the_post_thumbnail('full'); ?>
                </div>
                <div class="for_title_child_page">
                    <h3><?php the_title(); ?></h3>
                </div>
                <div class="for_content_child_page">
                <?php the_content(); ?>
                </div>
            <?php endwhile;   endif; ?>
		<div class="dlk_form_child_page"><?php get_template_part('sections/dat-lich-kham-blue'); //echo do_shortcode('[contact-form-7 id="443"]');?></div>
    </div>
    <div class="left_chuyen_khoa_page hidden_desktop">
    <?php get_template_part('sections/chuyen_khoa_left_colum_all');?>
    </div>
    </div>
</section>
<?php
get_footer();
 ?>