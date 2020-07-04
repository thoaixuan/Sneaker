<?php
/**
 * Template for displaying search forms in Phòng Khám Đa Khoa Phương Nam
 *
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">                                 		
     <div class="search_form_page_wrap">
        <input type="search" id="search_field_2" class="search-field search_field_form_page" placeholder="Điền từ khóa" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search_submit_page pos-rel">
            <img  class="img_search pos-ab" src="<?php echo get_template_directory_uri(); ?>/assets/images/search_icon.svg" />
        </button>
     </div>
</form>

