<?php
if ( function_exists('acf_add_options_page') )
{
    acf_add_options_page(array(
        'page_title'    => 'Theme Options',
        'menu_title'    => 'Theme Options',
        'menu_slug'     => 'theme_options',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    // acf_add_options_page(array(
    //     'page_title'    => 'En',
    //     'menu_title'    => 'En',
    //     'menu_slug'     => 'En',
    //     'capability'    => 'edit_posts',
    //     'redirect'      => false
    // ));
    // acf_add_options_page(array(
    //     'page_title'    => 'Vi',
    //     'menu_title'    => 'Vi',
    //     'menu_slug'     => 'Vi',
    //     'capability'    => 'edit_posts',
    //     'redirect'      => false
    // ));
}
?>