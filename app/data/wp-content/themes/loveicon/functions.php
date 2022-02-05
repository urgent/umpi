<?php
/**
 * loveicon functions and definitions [loveicon]
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package loveicon  LOVEICON_THEME_URI LOVEICON
 */
defined( 'LOVEICON_THEME_URI' ) or define( 'LOVEICON_THEME_URI', get_template_directory_uri() ); // loveicon
define( 'LOVEICON_THEME_DRI', get_template_directory() );
define( 'LOVEICON_IMG_URL', LOVEICON_THEME_URI . '/assets/images/' );
define( 'LOVEICON_CSS_URL', LOVEICON_THEME_URI . '/assets/css/' );
define( 'LOVEICON_JS_URL', LOVEICON_THEME_URI . '/assets/js/' );
define( 'LOVEICON_FRAMEWORK_DRI', LOVEICON_THEME_DRI . '/framework/' );

require_once LOVEICON_FRAMEWORK_DRI . 'styles/index.php';
require_once LOVEICON_FRAMEWORK_DRI . 'styles/daynamic-style.php';
require_once LOVEICON_FRAMEWORK_DRI . 'scripts/index.php';
require_once LOVEICON_FRAMEWORK_DRI . 'redux/redux-config.php';
require_once LOVEICON_FRAMEWORK_DRI . 'meta-box/config-meta-box.php';
require_once LOVEICON_FRAMEWORK_DRI . 'plugin-list.php';
require_once LOVEICON_FRAMEWORK_DRI . 'tgm/class-tgm-plugin-activation.php';
require_once LOVEICON_FRAMEWORK_DRI . 'tgm/config-tgm.php';
require_once LOVEICON_FRAMEWORK_DRI . 'dashboard/class-loveicon-dashboard.php';
require_once LOVEICON_FRAMEWORK_DRI . 'classes/loveicon-int.php';
require_once LOVEICON_FRAMEWORK_DRI . 'classes/loveicon-act.php';



/**
 * Theme option compatibility.
 */
if ( ! function_exists( 'loveicon_get_options' ) ) :
	function loveicon_get_options( $key ) {
		global $loveicon_options;
		$opt_pref = 'loveicon_';
		if ( empty( $loveicon_options ) ) {
			$loveicon_options = get_option( $opt_pref . 'options' );
		}
		$index = $opt_pref . $key;
		if ( ! isset( $loveicon_options[ $index ] ) ) {
			return false;
		}
		return $loveicon_options[ $index ];
	}
endif;


if ( ! function_exists( 'loveicon_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function loveicon_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on love us, use a find and replace
		* to change 'loveicon' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'loveicon', get_template_directory() . '/languages' );

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
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'loveicon' ),
			)
		);

		function loveicon_upload_mimes( $existing_mimes ) {
			$existing_mimes['webp'] = 'image/webp';
			return $existing_mimes;
		}
		add_filter( 'mime_types', 'loveicon_upload_mimes' );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'loveicon_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://cloveicon.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_image_size( 'loveicon-recent-post-size', 80, 80, true );
		add_image_size( 'loveicon-blog-grid', 570, 320, true );
		add_image_size( 'loveicon-blog-grid-2', 250, 370, true );
	}
endif;
add_action( 'after_setup_theme', 'loveicon_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function loveicon_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'loveicon_content_width', 640 );
}
add_action( 'after_setup_theme', 'loveicon_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function loveicon_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'loveicon' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'loveicon' ),
			'before_widget' => '<div id="%1$s" class="single-sidebar-box"><div class=" %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="title"><h3>',
			'after_title'   => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'charity Sidebar', 'loveicon' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'loveicon' ),
			'before_widget' => '<div id="%1$s" class="single-sidebar-box"><div class=" %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="title"><h3>',
			'after_title'   => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'event Sidebar', 'loveicon' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add widgets here.', 'loveicon' ),
			'before_widget' => '<div id="%1$s" class="single-sidebar-box"><div class=" %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="title"><h3>',
			'after_title'   => '</h3></div>',
		)
	);
}
add_action( 'widgets_init', 'loveicon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function loveicon_scripts() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'loveicon_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * google font compatibility.
 */
function loveicon_google_font() {
	$protocol   = is_ssl() ? 'https' : 'http';
	$subsets    = 'latin,cyrillic-ext,latin-ext,cyrillic,greek-ext,greek,vietnamese';
	$variants   = ':300,400,500,600,700,800,900';
	$query_args = array(
		'family' => 'Inter|Great+Vibes' . $variants,
		'family' => 'Great+Vibes' . $variants . '%7CInter' . $variants,
		'subset' => $subsets,
	);
	$font_url   = add_query_arg( $query_args, $protocol . '://fonts.googleapis.com/css?display=swap' );
	wp_enqueue_style( 'loveicon-google-fonts', $font_url, array(), null );
}
add_action( 'init', 'loveicon_google_font' );
/**
 * is_blog compatibility.
 */
function is_blog() {
	if ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) ) {
		return true;
	} else {
		return false;
	}
}
/**
 * excerpt_length compatibility.
 */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function loveicon_elementor_library() {
	$pageslist = get_posts(
		array(
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
		)
	);
	$pagearray = array();
	if ( ! empty( $pageslist ) ) {
		foreach ( $pageslist as $page ) {
			$pagearray[ $page->ID ] = $page->post_title;
		}
	}
	return $pagearray;
}

function loveicon_add_query_vars_filter( $vars ) {
	$vars[] = 'blog_style';
	return $vars;
}
add_filter( 'query_vars', 'loveicon_add_query_vars_filter' );

function loveicon_posts_per_page( $query ) {
	$blog_style = get_query_var( 'blog_style' );

	if ( ! is_admin() && $query->is_main_query() && $blog_style != '' ) {

		if ( $blog_style == 1 ) :
			$blog_post_count = '9';
		elseif ( $blog_style == 2 ) :
			$blog_post_count = '9';
		elseif ( $blog_style == 3 ) :
			$blog_post_count = '8';
		endif;

		global $wp_the_query;
		$query->set( 'posts_per_page', $blog_post_count );

		return $query;
	}
	return $query;
}
add_action( 'pre_get_posts', 'loveicon_posts_per_page' );

function loveicon_custom_css() {
	 $loveicon_custom_inline_style = '';

	if ( function_exists( 'loveicon_get_custom_styles' ) ) {
		$loveicon_custom_inline_style = loveicon_get_custom_styles();
	}

	wp_add_inline_style( 'loveicon-theme-style', $loveicon_custom_inline_style );
}
add_action( 'wp_enqueue_scripts', 'loveicon_custom_css', 20 );


add_filter( 'comment_form_fields', 'loveicon_custom_field' );
function loveicon_custom_field( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	unset( $fields['cookies'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
