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
/*Func process form*/

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
            $result .=  '<div class="ct-discount-shoes pos-ab"><span class="pos-ab text-up">'.$discount.'%</span></div>'; 
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
    /*$total_pages = $loop->max_num_pages;
    
    if ($total_pages > 1){

        $current_page = max(1, get_query_var('paged'));
        echo '<div>';
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => __('« prev'),
            'next_text'    => __('next »'),
        ));
        echo '</div>';
    } */   
       
    return $result;
    
}
add_shortcode('show_product', 'show_Product');
/*Func phan trang */

/*format money product */
function format_Money($money){
    $result= number_format($money);
    return  $result;
}
/*add_action('login_head', 'login_css');*/

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
/*-------------------------------------------End---------------------------------------------------------------- */