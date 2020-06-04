<?php
/*
 *  GLOBAL VARIABLES
 */
define('THEME_DIR', get_stylesheet_directory());
define('THEME_URL', get_stylesheet_directory_uri());

/*
 *  INCLUDED FILES
 */

$file_includes = [
    'inc/theme-assets.php',                 // Style and JS
    'inc/theme-setup.php',                  // General theme setting
    'inc/acf-options.php',                  // ACF Option page
    'inc/theme-shortcode.php'             // Theme Shortcode
];

foreach ($file_includes as $file) {
    if (!$filePath = locate_template($file)) {
        trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR);
    }

    require_once $filePath;
}

unset($file, $filePath);

/*Product */
// Our custom post type function
function create_posttype() {

	register_post_type( 'product',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Sản phẩm' ),
				'singular_name' => __( 'product' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'san-pham'),
			'show_in_rest' => true,

		)
	);
}
/*Custom Taxonomy*/
// Hook into the 'init' action
add_action( 'init', 'tao_taxonomy', 0 );
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
/*Func process form*/

/**/

add_action('login_head', 'login_css');

//404
/*
add_action('wp', 'redirect_404_to_homepage', 1);
function redirect_404_to_homepage()
{
    global $wp_query;
    if ($wp_query->is_404) {
        wp_redirect(get_bloginfo('url') . '/loi-404', 301);
        exit;
    }
}*/

// Limit Excerpt
function get_excerpt( $count ) {
    global $post;
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
   $excerpt = '<p>'.$excerpt.'... <a href="'.$permalink.'">Đọc thêm</a></p>';
return $excerpt;
}
function get_excerpt_dnbs( $count ) {
    $excerpt = get_the_content();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = '<p>'.$excerpt.'</p>';
return $excerpt;
}
// End Limit Excerpt

// Category Panigation
function category_pagination() {

	if( is_singular() ) return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="navigation navigation-category"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>...</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>...</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link() );

	echo '</ul></div>' . "\n";

}
// End category pagination
function getPostViews($postID){
    global $post;
    $postID = $post->ID;
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "<span class='counter'>0</span> view";
    }
    return "<span class='counter'>".$count.'</span> views';
}

function setPostViews($postID) {
   // global $post;
   // $postID = $post->ID;
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
   return $count;
}
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);

function posts_column_views($defaults){
      $defaults['post_views'] = __('Views');
     return $defaults;
        }
function posts_custom_column_views($column_name, $id){
if($column_name === 'post_views'){
    echo getPostViews(get_the_ID());
      }
}

function get_wp_content(){?>
			<?php
                global $post;
                while ( have_posts() ) : the_post();
                $postID = $post->ID;
                $categories = get_the_category($postID);
                $author_id=$post->post_author;

            ?>
            <div class="latest_home_pages">
                <div class="images_thumbnail">
                    <a class="post-title-img" href="<?php the_permalink(); ?>">
                        <?php getTheFirstImage(); ?>
                    </a>
                 </div>
              <div class="right_content_latest">
                <h3 class="title_code"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                 <div class="author_detail">
                    <span class="post_in"><?php the_time("d F , Y"); ?> </span>
                    <span class="posted_by">written by
                        <a target="_blank" href="<?php echo get_author_posts_url( $author_id, $author_nicename ); ?> ">
                            <?php echo the_author_meta( 'user_nicename' , $author_id ); ?>
                        </a>
                    </span>
                    <span class="posted_in">
                        <?php
                        $n=1; foreach($categories as $cat){
                        ?>
                        <?php if($n==1){?>
                        <a target="_blank" class="category_name <?php echo $n?>" href="<?php echo get_category_link( $cat->cat_ID ); ?>"><?php echo $cat->name;?></a>
                        <?php }else{echo ", ";?>
                        <a target="_blank" class="category_name <?php echo $n?>" href="<?php echo get_category_link( $cat->cat_ID ); ?> "><?php  echo $cat->name;?></a>
                        <?php }?>
                        <?php $n++;}?>
                    </span>
                    <?php  echo getPostViews(get_the_ID());?>
                 </div>
                <div class="content_des"><?php
                    $string1=str_replace("[hidden]"," ",$post->post_content);
                    $string1=str_replace("[/hidden]"," ",$string1);
                    $string1=strip_shortcodes($string1);
                    $content_show=strip_tags($string1);
                    $arr=explode(" ", $content_show);
                    $n1=count($arr);
                    $arr1=" ";
                    for($i=0; $i<=$n1; $i++){ $arr1.=$arr[$i]." "; if($i==85){ break;} }
                    echo strip_shortcodes($arr1)."[..]";?>
                    <a class="readmore_button" href="<?php echo the_permalink();?>">Read more...</a>
                </div>
             </div>
            </div>
            <?php
            endwhile;
            category_pagination();
			?>
<?php }

function getTheFirstImageContent() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];
  return $first_img;
}
function getTheFirstImage(){
    if ( has_post_thumbnail() ) {
        the_post_thumbnail();
    }else{
        echo '<img src="';
        echo getTheFirstImageContent();
        echo '" alt="" />';
    }
}


// Create the function, so you can use it
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
// If the user is on a mobile device, redirect them

// Remove update notification
/*function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
*/
/*
function filter_plugin_updatesider( $value ) {
    unset( $value->response['revslider/revslider.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updatesider' );*/

/*
function filter_plugin_updateyoast( $value ) {
    unset( $value->response['wordpress-seo-premium/wp-seo-premium.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updateyoast' );


function filter_plugin_updateyoast_primeum( $value ) {
    unset( $value->response['wordpress-seo-premium/wp-seo-main.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updateyoast_primeum' );

*/

/*function remove_update_notifications( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response['advanced-custom-fields-pro/acf.php'] )
        unset( $value->response['revslider/revslider.php'] );
        unset( $value->response['wordpress-seo-premium/wp-seo-premium.php'] );
    }
    return $value;
}
add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );

*/

function order_admin_custom_post_type($query) {
  if($query->is_admin) {

        if ($query->get('post_type') == 'chuoi-co-so')
        {
          $query->set('orderby', 'title');
          $query->set('order', 'ASC');
        }
  }
  return $query;
}
add_filter('pre_get_posts', 'order_admin_custom_post_type');


function order_font_page_custom_post_type($query)
{
    if ($query->get('post_type') == 'chuoi-co-so')
        {
          $query->set('orderby', 'ID');
          $query->set('order', 'ASC');
        }
    if ( is_post_type_archive( 'chuoi-co-so' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', 50 );
        return;
    }
}
add_action('pre_get_posts', 'order_font_page_custom_post_type');



// Set classic editor
add_filter( 'use_block_editor_for_post', '__return_false' );
// End set classic editor

// Su sung file svg

add_filter('upload_mimes','add_custom_mime_types');
function add_custom_mime_types($mimes) {
	return array_merge($mimes, array(
		'ac3' => 'audio/ac3',
		'mpa' => 'audio/MPA',
		'flv' => 'video/x-flv',
		'svg' => 'image/svg+xml',
        'svgz' => 'image/svgz+xml'
	));
}
/*Custome Logo theme */
add_theme_support( 'custom-logo' );
add_theme_support( 'custom-logo', array(
	'height'      => 70,
	'width'       => 220,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );
/*Footer */
function codethue_customize_register($wp_customize) 
{
//Footer logo
 $wp_customize->add_setting("footer_logo", array(
    'transport' => 'postMessage',
    )); 
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize,'footer_logo',array(
    'label' => __('Footer Logo', 'codethue'),
    'section' => 'footer',
    'settings' => 'footer_logo',
    )));
//Footer text
$wp_customize->add_setting("footer_text", array(
    'default' => '',
    'transport' => 'postMessage',
    )); 
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,"footer_text",array(
    'label' => __("Footer text here.(Col-1)", "codethue"),
    'section' => 'footer',
    'settings' => 'footer_text',
    'type' => 'textarea',
    )));
//Footer text Fanpage
$wp_customize->add_setting("footer_text_fanpage", array(
    'default' => '',
    'transport' => 'postMessage',
    )); 
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,"footer_text_fanpage",array(
    'label' => __("Footer embed Fanpage", "codethue"),
    'section' => 'footer',
    'settings' => 'footer_text_fanpage',
    'type' => 'textarea',
    )));
// Add Footer in Wp customizer
 $wp_customize->add_section("footer", array(
 'title' => __("Footer", "codethue"),
 'priority' => 130,
 'description' => __( 'Description Custom footer here. Design by Codethue.xyz' ),
 )); 
}
add_action("customize_register","codethue_customize_register");

/*Get main menu */
function get_menu($args){
    $menu = isset($atts['menu']) ? $atts['menu'] : '';
    ob_start();
    wp_nav_menu(array(
        'menu' => $menu
    ) );
    return ob_get_clean();
}
add_shortcode('get_menu', 'get_menu');
/*Custome Locate theme menu */
function register_my_menus() {
    register_nav_menus(
      array(
        'support' => __( 'Support Menu' ),
        'policy-menu' => __( 'Policy Menu' )
      ));
}
add_action( 'init', 'register_my_menus' );