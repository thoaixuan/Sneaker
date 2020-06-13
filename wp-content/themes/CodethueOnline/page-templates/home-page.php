<?php
/**
 * template name: Home Page
 */
get_header();
wp_reset_query();
get_template_part('sections/slider-main');
get_template_part('sections/features');
get_template_part('sections/product');
get_template_part('sections/latest-news');
get_footer();?>
