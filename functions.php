<?php

/**
 * 设置主题默认值并注册对各种WordPress功能的支持。
 *
 * 请注意，此函数已挂接到after_setup_theme挂钩中，该挂钩在init挂钩之前运行。 对于某些功能（例如表示支持帖子缩略图），init挂钩为时已晚。
 *
 * @package TingBiao Wang
 */
add_action( 'after_setup_theme', 'doc_theme_support' );

function doc_theme_support() {

	// 使主题可用于翻译，可以将翻译文件存储在/ languages /目录中
	load_theme_textdomain( 'doc-text', get_template_directory() . '/languages' );

	// 打开友情链接( wp_list_bookmarks(); )
	add_filter( 'pre_option_link_manager_enabled', '__return_true' );

	// 帖子格式
	add_theme_support(
		'post-formats',
		array(
			'status',
			'quote',
			'gallery',
			'image',
			'video',
			'audio',
			'link',
			'aside',
			'chat'
		)
	);

	// 在帖子和页面上启用缩略图的支持 https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	add_theme_support( 'post-thumbnails' );

	// 自定义背景
	add_theme_support( 'custom-background' );

	// 自定义Logo
	add_theme_support( 'custom-logo' );

	// 添加对全幅和宽幅对齐图像的支持
	add_theme_support( 'align-wide' );

	// 添加对响应式嵌入的支持
	add_theme_support( 'responsive-embeds' );

	// 将默认帖子和评论RSS feed链接添加到头部
	add_theme_support( 'automatic-feed-links' );

	// 切换搜索表单，注释表单和注释的默认核心标记，以输出有效的HTML5
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style'
		)
	);

	// 让WordPress管理文档标题。 通过添加主题支持，我们声明此主题在文档头中不使用硬编码的<title>标签，并希望WordPress为我们提供它
	add_theme_support( 'title-tag' );

	// 添加主题支持以选择性地刷新小部件
	add_theme_support( 'customize-selective-refresh-widgets' );

}

/**
 * 注册并加载CSS
 */
add_action( 'wp_enqueue_scripts', 'doc_register_styles' );

function doc_register_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 加载 style.css
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'style', 'rtl', 'replace' );

	// 加载 normalize.css
	wp_enqueue_style( 'normalize.min', get_template_directory_uri() . '/assets/css/normalize.min.css', $theme_version );

	// 加载 font-awesome.css
	wp_enqueue_style( 'awesome.min', get_template_directory_uri() . '/assets/css/font-awesome.min.css', $theme_version );

	// 加载 swiper.css
	if ( is_home() ) {
		wp_enqueue_style( 'swiper.min', get_template_directory_uri() . '/assets/css/swiper.min.css', $theme_version );
	}

	// 加载 share.css
	if ( is_single() || is_page() ) {
		wp_enqueue_style( 'share.min', get_template_directory_uri() . '/assets/css/share.min.css', $theme_version );
	}

}

/**
 * 注册并加载JS
 */
add_action( 'wp_enqueue_scripts', 'doc_register_scripts' );

function doc_register_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 加载 jquery
	wp_enqueue_script( 'jquery-min', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), $theme_version, true );
	wp_script_add_data( 'jquery-min', 'async', true );

	// 加载 allapp.js
	wp_enqueue_script( 'allapp', get_template_directory_uri() . '/assets/js/allapp.js', array(), $theme_version, true );

	// 加载 swiper.js
	if ( is_home() ) {
		wp_enqueue_script( 'swiper.min', get_template_directory_uri() . '/assets/js/swiper.min.js', array(), $theme_version, true );
	}

	// 加载 single.js 和 share.js 
	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'single', get_template_directory_uri() . '/assets/js/single.js', array(), $theme_version, true );
		wp_enqueue_script( 'share.min', get_template_directory_uri() . '/assets/js/share.min.js', array(), $theme_version, true );
	}

	if ( ( !is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * 注册导航菜单在自定义位置使用wp_nav_menu
 */
add_action( 'init', 'doc_menus' );

function doc_menus() {

	$locations = array(
		'topnav' => __( '顶部菜单', 'doc-text' ),
		'bottomnav' => __( '底部菜单', 'doc-text' ),
	);

	register_nav_menus( $locations );
}

/**
 * 加载其他PHP文件
 */

// 数据库清理
require get_template_directory() . '/inc/wp-clean-up/wp-clean-up.php';

// 核心代码
require get_template_directory() . '/inc/custom-core.php';

// 帖子相关
require get_template_directory() . '/inc/custom-article.php';

// 基本设置
require get_template_directory() . '/inc/custom-settings.php';

// 自定义帖子类型
require get_template_directory() . '/inc/custom-post-type.php';

// 自定义类别类型
require get_template_directory() . '/inc/custom-taxonomy.php';

// 主题设置
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * 显示上传设置，自定义媒体上传位置
 */
if ( get_option( 'upload_path' ) == 'wp-content/uploads' || get_option( 'upload_path' ) == null ) {
	update_option( 'upload_path', WP_CONTENT_DIR . '/uploads' );
}


/**
 * 填充wp_body_open，以确保与5.2之前的WordPress版本向后兼容
 */
if ( !function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}