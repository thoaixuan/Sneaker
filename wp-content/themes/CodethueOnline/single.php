<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Codethue.xyz
 * @since ThoaiXuan 1.0
 */

get_header();
?>
<?php if ($post->post_type == "product") {?>
<?php get_template_part('sections/details-product');} else{ ?>

<section class="ct-post-details pd-top-bot-20">
    <div class="container">
        <div class="row">
            <?php if (have_posts()) : while(have_posts()) : the_post() ?>
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
                <div class="ct--widget">
                    <img src="<?=get_template_directory_uri()?>/assets/images/banner-ads-01.jpg" class="" alt="" title="<?=get_the_title()?>">
                    <hr>
                    <h3 class="text-up">tin tức mới</h3>
                    awdawd
                    <hr>
                    <h3 class="text-up">sản phẩm mới</h3>
                    <div class="ct-widget-post">
                        <?php echo do_shortcode('[show_widget_product][/show_widget_product]'); ?>
                    </div>
                    <hr>
                    <h3 class="text-up d--block">Danh mục</h3>
                    <div class="ct-widget-cat">
                        <?php $categories = get_categories( array( 'orderby' => 'name', 'order'   => 'ASC' ) );
                        foreach( $categories as $category ) {
                        echo '<div class="d-inline-block"><a href="'.get_category_link($category->term_id).'">'.$category->name.'</a></div>'; } ?>
                    </div>
                </div>
            </div> 
            <?php endwhile; endif; ?>    
        </div>
    </div>
</section>
<?php } get_footer(); ?>