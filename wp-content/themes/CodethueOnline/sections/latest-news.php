<section class="ct__latest_news padding-bot-40">
    <div class="container">
        <div class="ct-title pos-rel" data-mask="News">
            <h3 class="ct-tile-product"> - tin tức mới</h3>
        </div>
        <!--Get post ct = codethue.xyz -->
        <div class="ct-recent-post">
            <div id="ct-slider-tiny" class="ct-slider-tiny row">
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 3, // Number of recent posts thumbnails to display
                    'post_status' => 'publish' // Show only the published posts
                ));
                foreach($recent_posts as $post) : ?>
                
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
                
                <?php endforeach; wp_reset_query(); ?>
            </div>
        </div>
        <!--End-->
    </div>
</section>