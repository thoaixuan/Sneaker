<?php
/**
 * The template for displaying search results pages
 *
 */

get_header();
?>
<?php if ( have_posts() ) : ?>
<section  id="for_doi_ngu_bac_si_title" class="page_wrapper">
    <div class="container_site">
        <?php if ( have_posts() ) : ?>
             <h1 class="the_post_type_titles the_post_type_titles_blog"><?php printf( __( 'Kết quả tìm kiếm: %s', 'Codethue' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
             <img   src="<?php echo get_template_directory_uri(); ?>/assets/images/result-search.png" />
             <h1 class="page_title_search"><?php _e( 'Không có kết quả phù hợp', 'Codethue' ); ?></h1>
             <p><?php _e( 'Xin lỗi, không có kết quả tìm kiếm phù hợp với yêu cầu của bạn!', 'Codethue' ); ?></p>
             <?php get_search_form(); ?>
    	<?php endif; ?>
    </div>
</section>
<?php		
    endif;
?>
<?php
get_footer();
 ?>