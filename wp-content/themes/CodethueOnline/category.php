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
                    'numberposts' => 6, 
                    'post_status' => 'publish',
                    'post_type' => array('post', 'product'),
                    'cat' => $cat_id,
                    
                ));
                foreach($recent_posts as $post) : ?>
                <?php  if($post['post_type'] == 'product') { 
                    /*show produt*/
                    echo show_product_by_cat($cat_id); 
                ?>   
                <?php break;} else { /*show news */ ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                            <a href="<?php echo get_permalink($post['ID']) ?>">
                                <img class="ct-img-post-latest" src="<?php echo get_the_post_thumbnail_url($post['ID'], 'post-thumbnail'); ?>">
                                <div class=""><p class="ct-title-post-latest"><?php echo $post['post_title'] ?></p>
                                    <p class="ct-date-post-latest"><i class="fa fa-calendar" aria-hidden="true"></i>  <?=get_the_date()?></p>
                                    <span class="ct-excerpt-post-latest"><?=get_excerpt_by_id($post['ID'])?></span>
                                    <span class="text-up">đọc tiếp <i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                                </div>
                            </a>

                    </div>
                    
        <?php  } endforeach; wp_reset_query(); ?>
        </div>
        <div class="navigation_archive">
            Tổng số bài viết 
            <?php
            $postsInCat = get_term_by('id',$cat_id ,'category');//Thay ID_CAT bằng ID mà bạn muốn đếm số bài viết
            echo $postsInCat = $postsInCat->count; // Số bài viết
            ?>
        </div>
    </div>
</section>
<?php
get_footer();
 ?>
