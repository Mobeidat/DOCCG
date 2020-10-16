<?php
/*refresh*/

if ( !class_exists( 'doc_customizer' ) ) {

	class doc_customizer {

		public static function register( $wp_customize ) {

			/* -------------------------------------------------------------------------- */
			/*	wp default menu and add custom attributes
			/* -------------------------------------------------------------------------- */
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector' => '.custom-logo-text',
					'render_callback' => 'doc_custom_logo_text',
				)
			);

			// Website title display
			$wp_customize->add_setting( 'custom_logo_text_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'custom_logo_text_open',
				array(
					'label' => __( 'Website title display', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => '9',
					'type' => 'checkbox',
				) );

			// Site title annotation display
			$wp_customize->add_setting( 'custom_logo_text_span_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'custom_logo_text_span_open',
				array(
					'label' => __( 'Website title display', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => '10',
					'type' => 'checkbox',
				) );

			// Site title annotation
			$wp_customize->add_setting( 'custom_logo_text_span',
				array(
					'default' => '2020',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'custom_logo_text_span',
				array(
					'label' => __( 'Site title annotation', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => '10',
					'type' => 'text',
				) );
			$wp_customize->selective_refresh->add_partial( 'custom_logo_text_span',
				array(
					'selector' => '.site-title-span',
					'settings' => 'custom_logo_text_span',
					'render_callback' => function () {
						return get_theme_mod( 'custom_logo_text_span' );
					},
				) );

			// Ranking keywords
			$wp_customize->add_setting(
				'doc_keywords',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_textarea_field',
					'transport' => '',
				)
			);
			$wp_customize->add_control(
				'doc_keywords',
				array(
					'label' => __( '排名关键词', 'doc-text' ),
					'description' => __( '好的关键字可以提高排名，使用英文逗号分隔每个单词', 'doc-text' ),
					'section' => 'title_tagline',
					'type' => 'textarea',
					'priority' => '10',
				)
			);


			/* -------------------------------------------------------------------------- */
			/*	Add panel
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_panel(
				'doc_panels',
				array(
					'title' => __( 'Theme setting', 'doc-text' ),
					'priority' => 0,
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	Article list
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_post_list_menu',
				array(
					'title' => __( 'Article list', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			// Display thumbnail
			$wp_customize->add_setting( 'doc_list_pic_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_pic_open',
				array(
					'label' => __( 'Display thumbnail', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display category
			$wp_customize->add_setting( 'doc_list_card_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_card_open',
				array(
					'label' => __( 'Display category', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display time
			$wp_customize->add_setting( 'doc_list_time_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_time_open',
				array(
					'label' => __( 'Display time', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display excerpt
			$wp_customize->add_setting( 'doc_list_excerpt_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_excerpt_open',
				array(
					'label' => __( 'Display excerpt', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display button
			$wp_customize->add_setting( 'doc_list_link_text_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_link_text_open',
				array(
					'label' => __( 'Display button', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display button text
			$wp_customize->add_setting( 'doc_list_link_text',
				array(
					'default' => __( 'Read more', 'doc-text' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_list_link_text',
				array(
					'label' => __( 'Display button text', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '10',
					'type' => 'text',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_list_link_text',
				array(
					'selector' => '.article-link a',
					'settings' => 'doc_list_link_text',
					'render_callback' => function () {
						return get_theme_mod( 'doc_list_link_text' );
					},
				) );

			/* -------------------------------------------------------------------------- */
			/*	Article page
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_post_page_menu',
				array(
					'title' => __( 'Article page', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			// Display top category
			$wp_customize->add_setting( 'doc_single_top_category_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_single_top_category_open',
				array(
					'label' => __( 'Display top category', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display top meta
			$wp_customize->add_setting( 'doc_single_top_meta_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_single_top_meta_open',
				array(
					'label' => __( 'Display top meta', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display copyright
			$wp_customize->add_setting( 'doc_single_copytight_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_single_copytight_open',
				array(
					'label' => __( 'Display copyright', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Copyrighted content
			$wp_customize->add_setting( 'doc_single_copytight',
				array(
					'default' => __( 'This article is collected from the Internet, and the copyright belongs to the original author or organization. If this page violates your rights, please contact us via email hi@doccg.com!', 'doc-text' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_single_copytight',
				array(
					'label' => __( 'Copyrighted content', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'textarea',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_single_copytight',
				array(
					'selector' => '.single-copytight span',
					'settings' => 'doc_single_copytight',
					'render_callback' => function () {
						return get_theme_mod( 'doc_single_copytight' );
					},
				) );

			// Display bottom meta
			$wp_customize->add_setting( 'doc_single_bottom_meta_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_single_bottom_meta_open',
				array(
					'label' => __( 'Display bottom meta', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Display share
			$wp_customize->add_setting( 'doc_sin_share_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_share_open',
				array(
					'label' => __( 'Display share', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Shared site
			$wp_customize->add_setting( 'doc_sin_share',
				array(
					'default' => 'weibo,qzone,qq,wechat',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_sin_share',
				array(
					'label' => __( 'Shared site', 'doc-text' ),
					'description' => __( 'weibo、QQqone、QQ、WeChat、Douban、Facebook、Twitter、Linkedin、Google+、diandian', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'text',
				) );

			// Display tag
			$wp_customize->add_setting( 'doc_sin_tag_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_tag_open',
				array(
					'label' => __( 'Display tag', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site float
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_footer_menu',
				array(
					'title' => __( 'Site footer', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Site footer introduction
			$wp_customize->add_setting( 'doc_bottom_about',
				array(
					'default' => __( 'Thank you for visiting my small site. I am a designer and front-end development enthusiast. These are some resources and materials that I usually collect. hope it helps you.', 'doc-text' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_bottom_about',
				array(
					'label' => __( 'Site footer introductiont', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'textarea',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_bottom_about',
				array(
					'selector' => '.bottom-about p',
					'settings' => 'doc_bottom_about',
					'render_callback' => function () {
						return get_theme_mod( 'doc_bottom_about' );
					},
				) );

			// Express title
			$wp_customize->add_setting( 'doc_express_title',
				array(
					'default' => __( 'Express', 'doc-text' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_express_title',
				array(
					'label' => __( 'Express title', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'text',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_express_title',
				array(
					'selector' => '.news-posts h3',
					'settings' => 'doc_express_title',
					'render_callback' => function () {
						return get_theme_mod( 'doc_express_title' );
					},
				) );

			// China record number
			$wp_customize->add_setting( 'doc_record',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_record',
				array(
					'label' => __( 'China record number', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'text',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_record',
				array(
					'selector' => '.docrecord',
					'settings' => 'doc_record',
					'render_callback' => function () {
						return get_theme_mod( 'doc_record' );
					},
				) );

			// Statistical code
			$wp_customize->add_setting( 'doc_statistics',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_html_class',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_statistics',
				array(
					'label' => __( 'Statistical code', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'textarea',
				) );


			/* -------------------------------------------------------------------------- */
			/*	Site float
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_float_menu',
				array(
					'title' => __( 'Site float', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Online service url
			$wp_customize->add_setting( 'doc_back_totop_bell_url',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_back_totop_bell_url',
				array(
					'label' => __( 'Online service url', 'doc-text' ),
					'description' => __( 'Recommend https://yzf.qq.com/', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'text',
				) );

			/* Statistical code JS */
			$wp_customize->add_setting( 'doc_back_totop_bell_js',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_html_class',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_back_totop_bell_js',
				array(
					'label' => __( 'Online service js', 'doc-text' ),
					'description' => __( 'Recommend https://yzf.qq.com/', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'textarea',
				) );

			/* Display back to top */
			$wp_customize->add_setting( 'doc_back_totop_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_back_totop_open',
				array(
					'label' => __( 'Display back to top', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site Socialization
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_socialization_menu',
				array(
					'title' => __( 'Site Socialization', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Socialization title
			$wp_customize->add_setting( 'doc_socialization_title',
				array(
					'default' => __( 'Socialization', 'doc-text' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_socialization_title',
				array(
					'label' => __( 'Socialization title', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_socialization_title',
				array(
					'selector' => '.bottom-link h3',
					'settings' => 'doc_socialization_title',
					'render_callback' => function () {
						return get_theme_mod( 'doc_socialization_title' );
					},
				) );

			// Behance
			$wp_customize->add_setting( 'doc_link_behance',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_link_behance',
				array(
					'label' => __( 'Behance', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
				) );

			// Display QR code
			$wp_customize->add_setting( 'doc_qrcode_open',
				array(
					'default' => false,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_qrcode_open',
				array(
					'label' => __( 'Display QR code', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Socialization title
			$wp_customize->add_setting( 'doc_qrcode_title',
				array(
					'default' => __( 'QR code', 'doc-text' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_qrcode_title',
				array(
					'label' => __( 'QR code title', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_qrcode_title',
				array(
					'selector' => '.link-img span',
					'settings' => 'doc_qrcode_title',
					'render_callback' => function () {
						return get_theme_mod( 'doc_qrcode_title' );
					},
				) );

			// QR code for site/company/person
			$wp_customize->add_setting( 'doc_qrcode',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_image',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode',
				array(
					'label' => __( 'QRcode', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
				) ) );


		}

		/**
		 * Sanitize boolean for checkbox
		 */
		public static function doc_sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

	}

	add_action( 'customize_register', array( 'doc_customizer', 'register' ) );

}

require get_template_directory() . '/inc/customizer/customizer-sanitize.php';

/**
 * Partial refresh function
 */
if ( !function_exists( 'doc_custom_logo_text' ) ) {
	function doc_custom_logo_text() {
		bloginfo( 'name' );
	}
}