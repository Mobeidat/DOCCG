<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function doc_theme_support() {

	/*
	 * Make theme available for translation. Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'doc-text', get_template_directory() . '/languages' );

	/* 
	 * Open bookmarks
	 *
	 * Front-end use function ( wp_list_bookmarks(); )
	 */
	add_filter( 'pre_option_link_manager_enabled', '__return_true' );

	// Post Formats
	add_theme_support( 'post-formats', array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat' ) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Custom background
	add_theme_support( 'custom-background' );

	// Custom Logo
	add_theme_support( 'custom-logo' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Let WordPress manage the document title. By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );


}
add_action( 'after_setup_theme', 'doc_theme_support' );

/**
 * Register and Enqueue Styles.
 */
function doc_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'mrwstyle', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'mrwtyle', 'rtl', 'replace' );

	// Add import normalize.css
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/assets/css/normalize.min.css', $theme_version );

	// Add import random color
	wp_enqueue_style( 'awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', $theme_version );

	// Add introduction share css
	if ( is_single() ) {
		wp_enqueue_style( 'share', get_template_directory_uri() . '/assets/css/share.min.css', $theme_version );
	}

}

add_action( 'wp_enqueue_scripts', 'doc_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function doc_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'jquerymin', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), $theme_version, true );
	wp_script_add_data( 'jquerymin', 'async', true );

	wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', array(), $theme_version, true );

	// Add introduction share js
	if ( is_single() ) {
		wp_enqueue_script( 'share', get_template_directory_uri() . '/assets/js/jquery.share.min.js', array(), $theme_version, true );
	}

	if ( ( !is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'doc_register_scripts' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function doc_menus() {

	$locations = array(
		'topnav' => __( 'Top Menu', 'doc-text' ),
		'bottomnav' => __( 'Bottom Menu', 'doc-text' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'doc_menus' );

/**
 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
 */
if ( !function_exists( 'wp_body_open' ) ) {

	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

require get_template_directory() . '/inc/wp-clean-up/wp-clean-up.php';

require get_template_directory() . '/inc/core.php';

require get_template_directory() . '/inc/article.php';

require get_template_directory() . '/inc/settings.php';

//require get_template_directory() . '/custom-login-register.php' );

require get_template_directory() . '/inc/custom-archive-article.php';

require get_template_directory() . '/inc/admin/getting-started.php';

require get_template_directory() . '/inc/customizer/customizer.php';

/* 1. customizer-preview.js
function doc_customize_preview_js() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_script( 'doc_customizer_preview', get_template_directory() . '/inc/customizer/customizer-preview.js', array( 'customize-preview' ), $theme_version, true );
}
add_action( 'customize_preview_init', 'doc_customize_preview_js' );

// 2. customizer-control.js
function doc_customize_control_js() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_script( 'doc_customizer_control', get_template_directory() . '/inc/customizer/customizer-control.js', array( 'customize-controls', 'jquery' ), $theme_version, true );
}
add_action( 'customize_controls_enqueue_scripts', 'doc_customize_control_js' );
*/

// After installing the theme, jump to the theme introduction
$doc_theme_start = wp_get_theme();
if ( 'DOCCG' == $doc_theme_start->name ) {
	if ( is_admin() ) {
		require get_template_directory() . '/admin/getting-started.php';
	}
}

// Theme name and version
$doc_theme = wp_get_theme();
define( 'DOCCG_THEME_VERSION', $doc_theme->get( 'Version' ) );
define( 'DOCCG_THEME_NAME', $doc_theme->get( 'Name' ) );