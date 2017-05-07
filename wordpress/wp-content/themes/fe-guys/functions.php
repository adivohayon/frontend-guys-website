<?php
/**
 * Frontend Guys functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Frontend_Guys
 */

if ( ! function_exists( 'fe_guys_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fe_guys_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Frontend Guys, use a find and replace
	 * to change 'fe-guys' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'fe-guys', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'fe-guys' ),
	) );

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
	add_theme_support( 'custom-background', apply_filters( 'fe_guys_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	//Remove admin panel from front-facing pages
	add_filter('show_admin_bar', '__return_false');

	//Add data-text attribute to all menu links for fixed width solution
	function add_menu_atts( $atts, $item, $args ) {
		$atts['data-text'] = $item->title;
	    return $atts;
	}
	add_filter( 'nav_menu_link_attributes', 'add_menu_atts', 10, 3 );

	
}
endif;
add_action( 'after_setup_theme', 'fe_guys_setup' );





/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fe_guys_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fe_guys_content_width', 640 );
}
add_action( 'after_setup_theme', 'fe_guys_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fe_guys_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fe-guys' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'fe-guys' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'fe_guys_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fe_guys_scripts() {
	wp_enqueue_style( 'fe-guys-style', get_stylesheet_uri() );

	wp_enqueue_script( 'fe-guys-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'fe-guys-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if( is_front_page() ) {
		wp_enqueue_script('jquery', get_template_directory_uri() . '/js/vendor/jquery-3.2.1.slim.min.js', array());
		wp_enqueue_script('fullpage-js', get_template_directory_uri() . '/js/vendor/jquery.fullpage.min.js', array('jquery'));
		wp_enqueue_script('swiper', get_template_directory_uri() . '/js/vendor/swiper.jquery.min.js', array('jquery'), '20160501', true);
		wp_enqueue_script('front-page', get_template_directory_uri() . '/js/front-page.js', array('fullpage-js'));
		wp_localize_script('front-page', 'wpAjaxObj', array(
		  // URL to wp-admin/admin-ajax.php to process the request
		  'url' => admin_url( 'admin-ajax.php' ),
		  // generate a nonce with a unique ID "myajax-post-comment-nonce"
		  // so that you can check it later when an AJAX request is sent
		  'security' => wp_create_nonce( 'my-special-string' )
		));
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fe_guys_scripts' );

/**
 * Filters
 */
require get_template_directory() . '/inc/filters.php';

/**
 * Custom Menu
 */
require get_template_directory() . '/inc/menu.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
