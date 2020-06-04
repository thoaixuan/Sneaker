<?php
/**
 *
 */
get_header();
get_template_part('sections/main-menu-chuyen-khoa');
?>
<section  id="for_doi_ngu_bac_si_title" class="page_wrapper">
    <div class="container_site">
        <?php if ( have_posts() ) : ?>
    		 <h3 class="the_post_type_titles the_post_type_titles_blog"><?php the_archive_title(  ); ?></h3>
    	<?php endif; ?>
    </div>
</section>
<section id="DoiNguBacSi_archive" class="page_wrapper DoiNguBacSi_archive_content_blog">
    <div class="container_site">
        <ul class="doi_ngu_bac_si_list_parent_items doi_ngu_bac_si_list_parent_items_blog_page">
            <?php if (have_posts()) : $count_dnbs=1; while (have_posts()) : the_post(); ?>
                <?php
                    if($count_dnbs%4==0){$class_no_margin="dnbs_no_margin_right";}else{$class_no_margin=" ";}
                    if($count_dnbs%4==1){$class_no_marginleft="dnbs_no_margin_left";}else{$class_no_marginleft=" ";}
                    ?>
                    <li class="doi_ngu_bac_si_list_parent_item doi_ngu_bac_si_list_parent_item_<?php echo $count_dnbs;?> <?php echo $class_no_margin;?>  <?php echo $class_no_marginleft;?>">

                        <div class="top_img_dnbs_item">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?>" class="d--block">
                                <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
                                <?php if($url){?>
                                <img src="<?php echo $url?>" alt="<?php the_title();?>" />
                                <?php }else{?>
                                <img   src="<?php echo get_template_directory_uri(); ?>/images/logo_no_image.jpg" />
                                <?php }?>
                                <div class="plus_con_for_hover"><div class="plus_con_for_hover_child"><img width="40" src="<?php echo get_template_directory_uri(); ?>/images/icon_plus.svg" /></div></div>
                            </a>
                        </div>

                        <div class="name_title_bscn">
                             <div class="padding_name_title_bscn">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                                    <h3 class="name_title_h3_bs"><?php the_title();?></h3>
                                    <h4 class="chuc_vu_bscn"><?php echo get_field('chuc_vu_bs');?></h4>
                                </a>
                             </div>
                        </div>
                        <div class="short_description_dnbs_list">
                            <div class="padding_name_title_bscn">
                                <?php //echo get_excerpt(158);?>
								<?php $text = str_replace('[sub-title]', '', get_excerpt(158)); echo $text;?>
                            </div>
                        </div>
                    </li>
                <?php $count_dnbs++; endwhile; ?>
           <?php endif; ?>
        </ul>
        <script src="<?php echo get_theme_file_uri('./js/lib/magic-grid.min.js') ?>"></script>
        <script>
            let magicGrid = new MagicGrid({
              container: document.querySelector('.doi_ngu_bac_si_list_parent_items.doi_ngu_bac_si_list_parent_items_blog_page'),
              animate: true,
              gutter: 30,
              static: true,
              useMin: true
            });
            magicGrid.listen();
        </script>
        <div class="navigation_archive">
            <?php  category_pagination();?>
        </div>
    </div>
</section>
<?php
get_footer();
 ?>
