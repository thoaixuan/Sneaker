<?php
/**
 *Show post by Cat
 */
get_header();
?>
<?php 
$category = get_queried_object();
$cat_id =   $category->term_id;
$cat_name=get_cat_name($cat_id);
?>
<section class="cat_page_wrapper ct__latest_news">
    <div class="container">
        <div class="ct-title pos-rel" data-mask="<?=$cat_name?>">
            <h1 class="d-none"><?=$cat_name?></h1>
            <h3 class="ct-tile-product"> - <?=$cat_name?></h3>
        </div>
        <div class="row pd-top-bot-20">
        <?php
                $recent_posts = wp_get_recent_posts(array(
                    'posts_per_page' => 1,
                    'post_status' => 'publish',
                    'post_type' => array('post', 'product'),
                    'cat' => $cat_id,
                    
                ));
                foreach($recent_posts as $post) : ?>
                <?php  if($post['post_type'] == 'product') { 
                    /*Display product*/
                    echo show_product_by_cat($cat_id); 
                ?>   
                <?php break;} else { /*Display news */ post_Pagination();} endforeach; wp_reset_query(); ?>
        </div>
    </div>
</section>
<?php
get_footer();
 ?>
