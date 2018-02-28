<?php

/********** DESSKY DEFINITION *************/
global $themeoptionsvalue, $themedata, $themename ; 

$themename 			=  'WooShop';
$admin_path 		= get_template_directory() . '/framework/adminoptions/';
$includes_path 		= get_template_directory() . '/framework/';
define('DESSKY_THEMENAME', $themename);
define('DESSKY_SHORTNAME', "dessky");
define('DESSKY_PARENTMENU_SLUG', 'desskytheme-settings');
define('DESSKY_FRAMEWORKPATH', get_template_directory() . '/framework/');

/********** END DESSKY DEFINITION *************/

//Theme Options
require_once get_template_directory() . '/options.php';

//Theme init
require_once $includes_path . 'theme-init.php';

//Metaboxes
require_once $includes_path . 'metaboxes.php';

//Widget and Sidebar
require_once $includes_path . 'sidebar-init.php';

require_once $includes_path . 'register-widgets.php';

//Additional function
require_once $includes_path . 'theme-function.php';

//Header function
require_once $includes_path . 'header-function.php';

//Footer function
require_once $includes_path . 'footer-function.php';

//Additional function
require_once $includes_path . 'theme-shortcode.php';

//Loading jQuery
require_once $includes_path . 'theme-scripts.php';

//Loading Style Css
require_once $includes_path . 'theme-styles.php';

require_once $includes_path . 'getqtycart.php';

// New Version Theme Update Notifier
require_once $includes_path . 'theme-update.php';

add_action( 'wp_enqueue_scripts', 'superfish_libs' );
function superfish_libs()
{
        // đăng kí những file js cần load ở header
 wp_enqueue_script('superfish', get_stylesheet_directory_uri() . '/superfish/js/superfish.js');
 wp_enqueue_script('supersubs', get_stylesheet_directory_uri() . '/superfish/js/supersubs.js');
// đăng kí những file css cần load ở header
 wp_enqueue_script('superfish', get_stylesheet_directory_uri() . '/superfish/css/superfish.css');
 wp_enqueue_script('supersubs', get_stylesheet_directory_uri() . '/superfish/css/superfish-navbar.css');}


if ( ! function_exists( '_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function shouse_kego_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on shouse_kego, use a find and replace
		 * to change 'shouse_kego' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'shouse_kego', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/* Post format*/
		add_theme_support( 'post-formats', array(
			'image',
			'video',
			'gallery',
			'quote',
			'link'
		) );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_theme_support('menus');
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
        array(
                'menu' => 'Menu',
                'top-menu' => 'top menu'
        )
);

		add_theme_support( 'featured-thumb', 250, 250, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'shouse_kego_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'shouse_kego_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shouse_kego_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shouse_kego_content_width', 640 );
}
add_action( 'after_setup_theme', 'shouse_kego_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shouse_kego_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'sidebar', 'shouse_kego' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'shouse_kego' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );}
// 	register_sidebar( array(
// 		'name'          => esc_html__( 'Header-left', 'shouse_kego' ),
// 		'id'            => 'sidebar-2',
// 		'description'   => esc_html__( 'Add widgets here.', 'shouse_kego' ),
// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</section>',
// 		'before_title'  => '<h3>',
// 		'after_title'   => '</h3>',
// 	) );
// 	register_sidebar( array(
// 		'name'          => esc_html__( 'Trang dịch vụ phải', 'shouse_kego' ),
// 		'id'            => 'sidebar-right',
// 		'description'   => esc_html__( 'Add widgets here.', 'shouse_kego' ),
// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</section>',
// 		'before_title'  => '<h3>',
// 		'after_title'   => '</h3>',
// 	) );
// 	register_sidebar( array(
// 		'name'          => esc_html__( 'Trang dịch vụ trái', 'shouse_kego' ),
// 		'id'            => 'sidebar-left',
// 		'description'   => esc_html__( 'Add widgets here.', 'shouse_kego' ),
// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</section>',
// 		'before_title'  => '<h3>',
// 		'after_title'   => '</h3>',
// 	) );
// }
add_action( 'widgets_init', 'shouse_kego_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function shouse_kego_scripts() {
	wp_enqueue_style( 'shouse_kego-style', get_stylesheet_uri() );
	

	wp_enqueue_script( 'shouse_kego-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'shouse_kego-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shouse_kego_scripts' );

$theme              = wp_get_theme( 'shouse_kego' );
$shouse_kego_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$shouse_kego = (object) array(
	'version' => $shouse_kego_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-shouse_kego.php',
	'customizer' => require 'inc/customizer/class-shouse_kego-customizer.php',
);

require 'inc/shouse_kego-functions.php';
require 'inc/shouse_kego-template-hooks.php';
require 'inc/shouse_kego-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$shouse_kego->jetpack = require 'inc/jetpack/class-shouse_kego-jetpack.php';
}

if ( shouse_kego_is_woocommerce_activated() ) {
	$shouse_kego->woocommerce = require 'inc/woocommerce/class-shouse_kego-woocommerce.php';

	require 'inc/woocommerce/shouse_kego-woocommerce-template-hooks.php';
	require 'inc/woocommerce/shouse_kego-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$shouse_kego->admin = require 'inc/admin/class-shouse_kego-admin.php';

	require 'inc/admin/class-shouse_kego-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-shouse_kego-nux-admin.php';
	require 'inc/nux/class-shouse_kego-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-shouse_kego-nux-starter-content.php';
	}
}

/**
ham tao phan trang
 **/
if(!function_exists('shouse_kego')) {
	function shouse_kego_pagination() {
		if ($GLOBALS['wp_query'] ->max_num_pages < 2 ) {
			return '' ;
		} ?>
		<nav class="pagination" role="navigation">
			<?php if(get_next_post_link()) : ?>
				<div class="next"><?php next_posts_link(__('Trang sau ' , 'shouse_kego')); ?> </div>
			<?php endif; ?>
			<?php if(get_previous_post_link()) : ?>
				<div class="prev"><?php previous_posts_link(__('Trang trước ' , 'shouse_kego')); ?> </div>
			<?php endif; ?>
		</nav>
	<?php }
}

/**
ham hien thi thumbnail
**/
if(!function_exists('shouse_kego_thumbnail')) {
	function shouse_kego_thumbnail($size) {
		if(!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('images')) : ?>
		<figure class="post_thumbnail"><?php the_post_thumbnail($size); ?> </figure>
	<?php endif; ?>
			
<?php
	}
}

/**
ham hien thi tieu de post
**/
if(!function_exists('shouse_kego_entry_header')) {
	function shouse_kego_entry_header() { ?>
		<?php if(is_single()) : ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title ="<?php the_title(); ?>" ><?php the_title(); ?> </a></h1>
		<?php else : ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title ="<?php the_title(); ?>" ><?php the_title(); ?> </a></h2>
		<?php endif; ?>
	<?php }
}

/**
lay du lieu post
**/
if(!function_exists('shouse_kego_entry_meta')) {
	function shouse_kego_entry_meta() { ?>
	<?php if(!is_page()) : ?>
		<div class="entry-meta">
			<?php 
				printf(__('<span class="author"> Đăng bởi %1$s ' , ' shouse_kego '),
					get_the_author());
				printf(__('<span class="date-published"> at %1$s ' , ' shouse_kego '),
					get_the_date()); 
				echo postviews_get(get_the_ID());
				printf(__('<span class="category"> %1$s ' , ' shouse_kego '),
					get_the_category_list());
				if(comments_open()) :
					echo '<span class="meta-reply">';
					comments_popup_link(
						__('Để lại bình luận ' , 'shouse_kego'),
						__('One comment ' , 'shouse_kego'),
						__('% comments ' , 'shouse_kego'),
						__('Read all comments ' , 'shouse_kego') );
					echo'</span>';
				endif;
			 ?>
			</div>
		<?php endif; ?>
		<?php 
}
}

/**
hien thi noi dung post/page
**/
if(!function_exists('shouse_kego_entry_content')) {
	function shouse_kego_entry_content() {
		if(!is_single() && !is_page()) {
			the_excerpt();
		}
		else {
			the_content();
			// phan trang trong single
			$link_pages = array (
				'before' => __('<p>Page: ' , 'shouse_kego'),
				'after' => '</p>',
				'nestpagelink' => __('Next Page ' , 'shouse_kego'),
				'previouspagelink' => __('Previous Page ' , 'shouse_kego')
			);
			wp_link_pages($link_pages);
		}
	}}
// 	function shouse_kego_readmore(){
// 		return '<a class="read-more" href="' .get_permalink(get_the_ID()) . '">' .__(' READ MORE', 'shouse_kego') . '</a>';
// 	}
// 	add_filter('excerpt_more', 'shouse_kego_readmore');
// }

/**
hien thi tag
**/
if(!function_exists('shouse_kego_entry_tag')) {
	function shouse_kego_entry_tag() {
		if(has_tag()) :
			echo '<div class="entry-tag">';
			printf(__('Tagged in %1$s ' , 'shouse_kego'), get_the_tag_list('',','));
			echo '</div>';
		endif;
	}
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns($num) {
        return 3; // 3 products per row
    }
}

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 20 );
/**
hiển thị view
**/
function postviews_get($postID){
    $count_key = 'postviews_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return " 0 lượt xem";
    }
    return 'Lượt xem: '.$count;
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
/** hàm thiết lập views **/
function postviews_set($postID) {
    $count_key = 'postviews_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


