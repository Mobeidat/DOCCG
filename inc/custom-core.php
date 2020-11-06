<?php
/**
 * 后台登录/注册显示修改站点Logo链接
 * Login in the background to register and display the logo name
 * Customize admin footer text
 * Protect your website from malicious requests
 * Only show articles from current user
 * Kill the admin nag
 * Remove nofollow from comments
 * There is only one search result directly enter
 * Remove Query String from Static Resources
 * Remove Emojis
 * Remove Shortlink
 * Disable Embed
 * Disable XML-RPC
 * Remove RSD Link
 * Hide Version
 * Remove WLManifest Link
 * Disable Self Pingback
 * Disable Dashicons in Front-end
 * Disable Contact Form 7 CSS/JS on Every Page
 *
 * @package TingBiao Wang
 */

/**
 * 后台登录/注册显示修改站点Logo链接
 */
function doc_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'doc_login_logo_url' );

/**
 * Login in the background to register and display the logo name
 */
function doc_login_logo_url_title() {
	$doc_login_logo_url_title_a = get_bloginfo( 'name' );
	return $doc_login_logo_url_title_a;
}
add_filter( 'login_headertitle', 'doc_login_logo_url_title' );

/**
 * Customize admin footer text
 */
function doc_custom_admin_footer() {
	echo '<a href="' . get_home_url() . '">' . get_bloginfo( 'name' ) . '</a>';
}
add_filter( 'admin_footer_text', 'doc_custom_admin_footer' );

/**
 * Protect your website from malicious requests
 */
global $user_ID;
if ( $user_ID ) {
	if ( !current_user_can( 'administrator' ) ) {
		if ( strlen( $_SERVER[ 'REQUEST_URI' ] ) > 255 ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "eval(" ) ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "CONCAT" ) ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "UNION+SELECT" ) ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "base64" ) ) {
			@header( "HTTP/1.1 414 Request-URI Too Long" );
			@header( "Status: 414 Request-URI Too Long" );
			@header( "Connection: Close" );
			@exit;
		}
	}
}

/**
 * Only show articles from current user
 */
function doc_check_user_role() {
	global $current_user;
	if ( $current_user->roles[ 0 ] != 'administrator' ) {

		// Only show pictures of logged-in users
		add_action( 'pre_get_posts', 'doc_restrict_media_library' );

		function doc_restrict_media_library( $wp_query_obj ) {
			global $current_user, $pagenow;
			if ( !is_a( $current_user, 'WP_User' ) )
				return;
			if ( 'admin-ajax.php' != $pagenow || $_REQUEST[ 'action' ] != 'query-attachments' )
				return;
			if ( !current_user_can( 'manage_media_library' ) )
				$wp_query_obj->set( 'author', $current_user->ID );
			return;
		}
	}
}
add_action( 'init', 'doc_check_user_role' );

/**
 * Kill the admin nag
 */
if ( !current_user_can( 'edit_users' ) ) {
	add_action( 'init', create_function( '$a', "remove_action('init', 'wp_version_check');" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

/**
 * Remove junk from head
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

/**
 * Remove nofollow from comments
 */
function doc_xwp_dofollow( $str ) {
	$str = preg_replace(
		'~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
		'<a ${1}${2}${3}>', $str );
	return str_replace( array( ' rel=""', " rel=''" ), '', $str );
}
remove_filter( 'pre_comment_content', 'wp_rel_nofollow' );
add_filter( 'get_comment_author_link', 'doc_xwp_dofollow' );
add_filter( 'post_comments_link', 'doc_xwp_dofollow' );
add_filter( 'comment_reply_link', 'doc_xwp_dofollow' );
add_filter( 'comment_text', 'doc_xwp_dofollow' );

/**
 * There is only one search result directly enter
 */
function doc_sin_result() {
	if ( is_search() ) {
		global $wp_query;
		if ( $wp_query->post_count == 1 ) {
			wp_redirect( get_permalink( $wp_query->posts[ '0' ]->ID ) );
		}
	}
}
add_action( 'template_redirect', 'doc_sin_result' );

/**
 * Remove Query String from Static Resources
 */
function doc_remove_cssjs_ver( $src ) {
	if ( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'doc_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'doc_remove_cssjs_ver', 10, 2 );

/**
 * Remove Emojis
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Remove Shortlink
 */
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

/**
 * Disable Embed
 */
function doc_disable_embed() {
	wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'doc_disable_embed' );

/**
 * Disable XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove RSD Link
 */
remove_action( 'wp_head', 'rsd_link' );

/**
 * Hide Version
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Remove WLManifest Link
 */
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * Disable Self Pingback
 */
function doc_disable_pingback( & $links ) {
	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, get_option( 'home' ) ) )
			unset( $links[ $l ] );
}
add_action( 'pre_ping', 'doc_disable_pingback' );

/**
 * Disable Dashicons in Front-end
 */
function doc_docs_dequeue_dashicon() {
	if ( current_user_can( 'update_core' ) ) {
		return;
	}
	wp_deregister_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'doc_docs_dequeue_dashicon' );

/**
 * Disable Contact Form 7 CSS/JS on Every Page
 */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );