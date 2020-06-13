<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>
<?php if ($post->post_type == "product") {?>
<?php get_template_part('sections/details-product');} else{?>

<section class="ct-post-details pd-top-bot-20">
    <div class="container">
        <div class="row">
        <?php 
        if (have_posts()) : while(have_posts()) : the_post()
        ?>
            <div class="col-lg-8 col-12">
                <div class="album-product">
					<!--<img class="ct-img-post" src="//get_the_post_thumbnail_url()" alt="" title="">-->
                    <p class="ct-date-post-latest"><i class="fa fa-calendar" aria-hidden="true"></i>  <?=get_the_date()?></p>
				</div>
				<div class="ct-content-post">
				<h1 class="text-up"><?=get_the_title()?></h1>
					<?=get_the_content() ?>
				</div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="details-product">
                <h1 class="text-up"><?=get_the_title()?></h1>
                
                </div>
            </div> 
        <?php endwhile; endif; ?>    
        </div>
    </div>
</section>
<?php
}
get_footer();
?>