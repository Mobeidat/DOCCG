<?php
/**
 * Settings page after installing the theme.
 *
 * Add a getting started page in the management menu
 * Load the starter style in the admin
 * The callback function of the management page 
 * Administrator notice
 *
 * @package TingBiao Wang
 */
/**
 * Add a getting started page in the management menu
 */
if ( !function_exists( 'doc_getting_started_menu' ) ):
	function doc_getting_started_menu() {

		$plugin_count = '<span class="awaiting-mod action-count">' . esc_html( DOCCG_THEME_VERSION ) . '</span>';
		$title = sprintf( esc_html__( '%1$s %2$s', 'doc-text' ), esc_html( DOCCG_THEME_NAME ), $plugin_count );

		add_theme_page( sprintf( esc_html__( 'Welcome to %1$s ', 'doc-text' ), esc_html( DOCCG_THEME_NAME ), esc_html( DOCCG_THEME_VERSION ) ), $title, 'edit_theme_options', 'docgetting-started', 'doc_getting_started_page' );
	}
endif;
add_action( 'admin_menu', 'doc_getting_started_menu' );

/**
 * Load the starter style in the admin
 */
if ( !function_exists( 'doc_getting_started_admin_scripts' ) ):
	function doc_getting_started_admin_scripts( $hook ) {

		if ( 'appearance_page_docgetting-started' != $hook ) return;
		wp_enqueue_style( 'docgetting-started', get_template_directory_uri() . '/inc/admin/getting-started.css', false, DOCCG_THEME_VERSION );
		wp_enqueue_script( 'updates' );

	}
endif;
add_action( 'admin_enqueue_scripts', 'doc_getting_started_admin_scripts' );

/**
 * The callback function of the management page 
 */
if ( !function_exists( 'doc_getting_started_page' ) ):
	function doc_getting_started_page() {
		?>
<div class="wrap getting-started">
	<div class="intro">
		<h3> <?php printf( esc_html__( 'Welcome to %1$s - version %2$s', 'doc-text' ), esc_html( DOCCG_THEME_NAME ), esc_html( DOCCG_THEME_VERSION ) ); ?> </h3>
		<p> <?php printf( esc_html__( '%1$s is a clean, modern and fast loading responsive WordPress blog theme. The theme supports custom title, logo or background, easy to use.', 'doc-text' ),esc_html( DOCCG_THEME_NAME )); ?> </p>
	</div>
	<div class="clearfix"></div>
	<div class="panels">
		<div class="panel">
			<div class="panel-aside panel-column">
				<h4>
					<?php esc_html_e( 'Related settings', 'doc-text' ); ?>
				</h4>
				<a class="button button-primary" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">
				<?php esc_html_e( 'Go to custom', 'doc-text' ); ?>
				</a></div>
			<div class="panel-aside panel-column">
				<h4>
					<?php esc_html_e( 'Use documentation', 'doc-text' ); ?>
				</h4>
				<a class="button button-primary" target="_blank" href="https://www.wangtingbiao.com/docdocs/">
				<?php esc_html_e( 'See details', 'doc-text' ); ?>
				</a> </div>
			<div class="panel-aside panel-column">
				<h4>
					<?php esc_html_e( 'Your feedback is valuable to us', 'doc-text' ); ?>
				</h4>
				<a class="button button-primary" target="_blank" href="https://www.wangtingbiao.com/docdocs/#comment">
				<?php esc_html_e( 'Submit feedback', 'doc-text' ); ?>
				</a> </div>
		</div>
	</div>
</div>
<?php
}
endif;

/**
 * Administrator notice
 */
class doc_screen {
	public function __construct() {
		add_action( 'load-themes.php', array( $this, 'doc_activation_admin_notice' ) );
	}
	public function doc_activation_admin_notice() {
		global $pagenow;
		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET[ 'activated' ] ) ) {
			add_action( 'admin_notices', array( $this, 'doc_admin_notice' ), 99 );
		}
	}
	public function doc_admin_notice() {
		?>
<div class="updated notice is-dismissible docnotice">
	<h1>
		<?php
		$theme_info = wp_get_theme();
		printf( esc_html__( 'Congratulations on the successful installation, welcome to use %1$s theme version %2$s', 'doc-text' ), esc_html( $theme_info->Name ), esc_html( $theme_info->Version ) );
		?>
	</h1>
	<p><?php echo sprintf( esc_html__("Thank you for your choice. To make full use of all the features of the theme, you have to go to our %1\$s welcome page %2\$s", 'doc-text'), '<a href="' . esc_url( admin_url( 'themes.php?page=docgetting-started' ) ) . '">', '</a>' ); ?></p>
	<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=docgetting-started' ) ); ?>" class="button button-blue-secondary button_info" style="text-decoration: none;"><?php echo esc_html__('Start using','doc-text'); ?></a></p>
</div>
<?php
}
}
$GLOBALS[ 'doc_screen' ] = new doc_screen();
