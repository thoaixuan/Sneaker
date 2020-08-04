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
    if (!$filePath = locate_template($file)) { trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR); }
    require_once $filePath;
}


unset($file, $filePath);
/*Custome login admin  */
function my_login_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );  $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );?>
    <style type="text/css">
        #login h1 a, .login h1 a { background-image: url(<?php echo $image[0]; ?>);background-position: center; height:70px; width:320px; background-size: 320px auto;background-repeat: no-repeat;}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
/*Click login logo */
function my_login_logo_url() { return home_url(); } add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url_title() { return 'Design by Thoại Xuân! Fb: fb.com/thoaixuan97';} add_filter( 'login_headertext', 'my_login_logo_url_title' );
/*Product */
// Our custom post type function
function create_posttype() {
	register_post_type( 'product',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Sản phẩm' ),
                'singular_name' => __( 'product' ),
                'add_new_item' => __('Thêm sản phẩm'),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'san-pham'),
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-cart',
            'supports' => array('title','thumbnail'),
            'taxonomies'  => array( 'category' ),
		)
	);
}
/*Custom Taxonomy*/
// Hook into the 'init' action
//add_action( 'init', 'tao_taxonomy', 0 );
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
/*Show product by Category */
add_action( 'init', 'wpa58471_category_base' );
function wpa58471_category_base() {
    add_rewrite_rule(
        'blog/([^/]+)/page/(\d+)/?$',
        'index.php?category_name=$matches[1]&paged=$matches[2]',
        'top' 
    );
    add_rewrite_rule( 
        'blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$',
        'index.php?category_name=$matches[1]&feed=$matches[2]', 
        'top' 
    );
}
function show_product_by_cat($cat_id) {	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
    global $result;
    $discount=0;
    global $old_price;
    /*Paganation*/
    $args = array(
        'nopaging'               => false,
        'paged'                  => $paged,
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'cat' => $cat_id,
    );
    $loop = new WP_Query($args);
	if ( $loop->have_posts() && $loop->is_category() ) {
    while ( $loop->have_posts() ) {
        $loop->the_post();
        $result .= '<div class="col-lg-3 col-md-3 col-sm-3 col-12 mb-3">';
        $result .= '<div class="ct-product__column">';
        $result .= '<a href="'.get_permalink().'"><div class="pos-rel">';
        $result .=      '<img class="ct-img-shoes pos-rel" src="'.wp_get_attachment_url(get_post_thumbnail_id(), 'thumbnail').'" alt="" title="'.get_the_title().'">';

        $price_shoes=get_field("price");
        $discount_price=get_field("discount_price");
        $check_product_new = get_field('check-new-shoes');
        $check_product_discount =get_field('discount');
        if($check_product_new){$result .=  '<div class="ct-new-shoes pos-ab"><span class="pos-ab text-up">new</span></div>';}else{}
        if($check_product_discount){
            (int)$discount=(($price_shoes-$discount_price)*100)/$price_shoes;
            $result .=  '<div class="ct-discount-shoes pos-ab"><span class="pos-ab text-up">'.round($discount,0).'%</span></div>'; 
            $price_shoes=get_field("discount_price");
            $old_price ='<del>'.format_Money(get_field("price")).' VNĐ</del>';
        }
        else{$old_price='';}
        
        $result .= '</div></a>';

        $result .='<div class="ct-shoes-content">';
        $result .= '<a href="'.get_permalink().'" class="ct-shoes-name text-up">'.get_the_title().'</a>';
        $result .= '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star un-checked"></span>';
        $result .=  '<div class="price-product">'.format_Money($price_shoes).' VNĐ'.$old_price.'</div>';
        
        $result .='</div>';

        $result .= '</div>';
        $result .= '</div>';
    } 
    echo '<div class="d-inline-block col-codethue-12 paganation-style text-right">';
        previous_posts_link( '« Trang trước |' ).next_posts_link( '| Trang sau »', $loop->max_num_pages );
    echo '</div>';
    return $result;  
	} else {
            // no posts found
            echo '<h1 class="page-title screen-reader-text">Không tìm thấy bài viết</h1>';
        }
    
}
/*Show product*/
function show_Product() {
    global $result;
    $discount=0;
    global $old_price;
    /*$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;*/
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 8,
        /*'paged' => $paged,*/
    );
    $loop = new WP_Query($args);
    while ( $loop->have_posts() ) {
        $loop->the_post();
        $result .= '<div class="col-lg-3 col-md-3 col-sm-3 col-12 mb-3">';
        $result .= '<div class="ct-product__column">';
        $result .= '<a href="'.get_permalink().'"><div class="pos-rel">';
        $result .=      '<img class="ct-img-shoes pos-rel" src="'.wp_get_attachment_url(get_post_thumbnail_id(), 'thumbnail').'" alt="" title="'.get_the_title().'">';

        $price_shoes=get_field("price");
        $discount_price=get_field("discount_price");
        $check_product_new = get_field('check-new-shoes');
        $check_product_discount =get_field('discount');
        if($check_product_new){$result .=  '<div class="ct-new-shoes pos-ab"><span class="pos-ab text-up">new</span></div>';}else{}
        if($check_product_discount){
            (int)$discount=(($price_shoes-$discount_price)*100)/$price_shoes;
            $result .=  '<div class="ct-discount-shoes pos-ab"><span class="pos-ab text-up">'.round($discount,0).'%</span></div>'; 
            $price_shoes=get_field("discount_price");
            $old_price ='<del>'.format_Money(get_field("price")).' VNĐ</del>';
        }
        else{$old_price='';}
        
        $result .= '</div></a>';

        $result .='<div class="ct-shoes-content">';
        $result .= '<a href="'.get_permalink().'" class="ct-shoes-name text-up">'.get_the_title().'</a>';
        $result .= '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star un-checked"></span>';
        $result .=  '<div class="price-product">'.format_Money($price_shoes).' VNĐ'.$old_price.'</div>';
        
        $result .='</div>';

        $result .= '</div>';
        $result .= '</div>';
    }
    /*Paganition */  
    return $result;
    
}
add_shortcode('show_product', 'show_Product');
function show_widget_Product(){
    global $result;
    $discount=0;
    global $old_price;
    $post_per_page=5;
    if(isMobile()){$post_per_page=3;}else{$post_per_pag=5;}
    /*$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;*/
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $post_per_page,
        /*'paged' => $paged,*/
    );
    $loop = new WP_Query($args);
    while ( $loop->have_posts() ) {
        $loop->the_post();
        $result .= '<div class="col-md-12 padding-left-u">';/*col-lg-3 col-md-3 col-sm-3 col-12 mb-3*/
        $result .= '<div class="ct-product__widget">';
        $result .= '<div class="col-codethue-3 padding-left-u"><a href="'.get_permalink().'"><div class="pos-rel">';
        $result .=      '<img src="'.wp_get_attachment_url(get_post_thumbnail_id(), 'thumbnail').'" class="pos-rel" alt="" title="'.get_the_title().'">';

        $price_shoes=get_field("price");
        $discount_price=get_field("discount_price");
        $check_product_new = get_field('check-new-shoes');
        $check_product_discount =get_field('discount');
        if($check_product_new){$result .=  '<div class="ct-new-shoes pos-ab"><span class="pos-ab text-up">new</span></div>';}else{}
        if($check_product_discount){
            (int)$discount=(($price_shoes-$discount_price)*100)/$price_shoes;
            $result .=  '<div class="ct-discount-shoes pos-ab"><span class="pos-ab text-up">'.round($discount,0).'%</span></div>'; 
            $price_shoes=get_field("discount_price");
            $old_price ='<del>'.format_Money(get_field("price")).' VNĐ</del>';
        }
        else{$old_price='';}
        
        $result .= '</div></a></div>';

        $result .='<div class="col-codethue-9 padding__left--15 ct-shoes-content">';
        $result .= '<a href="'.get_permalink().'" class="ct-shoes-name d--block text-up hover--primary__Color">'.get_the_title().'</a>';
        $result .= '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star un-checked"></span>';
        $result .=  '<div class="price-product">'.format_Money($price_shoes).' VNĐ'.$old_price.'</div>';
  
        $result .='</div></div></div>';
    }
    /*Paganition */  
    return $result;
}
add_shortcode('show_widget_product', 'show_widget_Product');
/*Func phan trang */

/*format money product */
function format_Money($money){
    $result= number_format($money);
    return  $result;
}

// Limit Excerpt
function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = ($the_post ? $the_post->post_content : null); //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 35; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    return $the_excerpt;
}
// End Limit Excerpt

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

function getTheFirstImageContent() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];
  return $first_img;
}

// Create the function, so you can use it>> If the user is on a mobile device, redirect them
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

// Remove update notification
/*function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
*/
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

function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
	/*
	 * Nonce verification
	 */
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;
 
	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
/*--------------------------------- */

/*Dropdown menu*/
class CSS_Menu_Maker_Walker extends Walker {

    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
  
    function start_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "\n$indent<ul>\n";
    }
  
    function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
    }
  
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
  
      global $wp_query;
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
  
      /* Add active class */
      if(in_array('current-menu-item', $classes)) {
        $classes[] = 'active';
        unset($classes['current-menu-item']);
      }
  
      /* Check for children */
      $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
      if (!empty($children)) {
        $classes[] = 'has-sub';
      }
  
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
  
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
  
      $output .= $indent . '<li' . $id . $value . $class_names .'>';
  
      $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
      $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
      $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
      $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
  
      $item_output = $args->before;
      $item_output .= '<a'. $attributes .'><span>';
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= '</span></a>';
      $item_output .= $args->after;
  
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
  
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
      $output .= "</li>\n";
    }
}
/*Phan trang bai viet */
// Ham tao phan trang
if (!function_exists( 'post_Pagination' ))
{
    function post_Pagination(){
        $category = get_queried_object();
        $cat_id =   $category->term_id;
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
        $args = array (
            'nopaging'               => false,
            'paged'                  => $paged,
            'posts_per_page'         => '3',
            'post_type'              => 'post',
            'cat' => $cat_id,
        );

        // The Query
        $query = new WP_Query( $args );
        // The Loop
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                echo '<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">'.
                            '<a href="'.get_permalink(get_the_ID()) .'">'.
                                '<img class="ct-img-post-latest" src="'.get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail').'">'.
                                '<div class=""><p class="ct-title-post-latest">'.get_the_title().'</p>'.
                                    '<p class="ct-date-post-latest"><i class="fa fa-calendar" aria-hidden="true"></i>  '.get_the_date().'</p>'.
                                    '<span class="ct-excerpt-post-latest">'.get_excerpt_by_id(get_the_ID())."</span>".
                                    '<span class="text-up">đọc tiếp <i class="fa fa-arrow-right" aria-hidden="true"></i></span>'.
                                '</div>
                            </a>

                    </div>';
            }
            echo '<div class="d-inline-block col-codethue-12 paganation-style text-right">';
            previous_posts_link( '« Trang trước |' );
            next_posts_link( '| Trang sau »', $query->max_num_pages );
            echo '</div>';
        } else {
            // no posts found
            echo '<h1 class="page-title screen-reader-text">Không tìm thấy bài viết</h1>';
        }

        // Restore original Post Data
        wp_reset_postdata();
     }
}

/*----------------------------------------------------End---------------------------------------------------------------- */
