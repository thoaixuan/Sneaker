<?php
function theme_setup() 
{
    // Language loading
    // load_theme_text_domain('Theme Domain', trailingslashit( get_template_directory()).'languages' );

    // HTML5 support; mainly here to get rid of some nasty default styling that WordPress used to inject
    add_theme_support( 'html5', array( 'search-form', 'gallery' ) );

    // Automatic feed links
    add_theme_support( 'automatic-feed-links' );

    /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
    add_theme_support( 'title-tag' );

    /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    */
    add_theme_support( 'post-thumbnails' );

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
    */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );

    /*
    * Register Menus
    */
    register_nav_menu('main_menu', __( 'Main Menu', 'halozend' ) );

}
add_action( 'after_setup_theme', 'theme_setup', 11);

/* REGISTER PLUGINS. */
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins()
{
    $plugins = array(
        array(
            'name'         => 'ACF Pro', // The plugin name.
            'slug'         => 'acf-pro', // The plugin slug (typically the folder name).
            'source'       => 'http://ro-public.s3.amazonaws.com/advanced-custom-fields-pro-RO.zip?AWSAccessKeyId=AKIAIWSC4LNM5ZYR2WFA&Expires=1781924754&Signature=aSMEPQ6kWOvRJ7BswM8zYPY4nuU%3D', // The plugin source.
            'required'     => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url' => '', // If set, overrides default API URL and points to an external URL.
        ),
    );
    /*
    * Array of configuration settings. Amend each line as needed.
    *
    * TGMPA will start providing localized text strings soon. If you already have translations of our standard
    * strings available, please help us make TGMPA even better by giving us access to these translations or by
    * sending in a pull-request with .po file(s) with the translations.
    *
    * Only uncomment the strings in the config array if you want to customize the strings.
    */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}

/* SET ACTIVE MENU. */
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item)
{
    if( in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

/* GRAGITY FORM - REGISTER HIDE LABEL. */
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

?>