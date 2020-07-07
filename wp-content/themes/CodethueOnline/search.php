<?php
/**
 * The template for displaying search results pages
 *
 */

get_header(); ?>
<div class="container">
<div class="row">
<div class="col-md-12">
<?php
$s= htmlspecialchars(get_search_query());
if($s==null){ $s="(T T)"; }else{}
$args = array(
                's' =>$s,
                'post_type'      => 'product',
                'posts_per_page' => 1,
            );
    // The Query
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
        _e("<h2>Kết quả tìm kiếm: ".get_query_var('s')."</h2>");
        while ( $the_query->have_posts() ) {
           $the_query->the_post();
                 ?>
                    <div class="d-inline-block cat_page_wrapper"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                 <?php
        }
    } else{
?>  
        <div class="alert alert-info"><p> <?php _e( 'Xin lỗi, không có kết quả tìm kiếm phù hợp với yêu cầu của bạn! Không tìm thấy', 'Codethue' ); ?></p>
        </div>
        <div class="col-md-12">Không tìm thấy:  <?php echo $s; ?></div>
<?php } ?>
    <div class="text--center cat_page_wrapper">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">                                 		
        <div class="search_form_page_wrap">
            <input type="search" id="search_field_2" class="search-field search_field_form_page" placeholder="Điền từ khóa" value="<?php echo get_search_query(); ?>" name="s" />
            <button type="submit" class="search_submit_page pos-rel">
                <img  class="img_search pos-ab" src="<?php echo get_template_directory_uri(); ?>/assets/images/search_icon.svg" />
            </button>
        </div>
    </form>
    </div>
</div>

</div>
</div>
<?php get_footer(); ?>
