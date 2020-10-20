<?php
/**
 * Theme customization settings.
 *
 * wp default menu and add custom attributes
 * Add panel
 * Article list
 * Article page
 * Site float
 * Site Socialization
 * Site advertisement
 * 
 * @package TingBiao Wang
 */
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
					'render_callback' => 'doc_get_custom_logo_text',
				)
			);

			// Show site title
			$wp_customize->add_setting( 'custom_logo_text_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'custom_logo_text_open',
				array(
					'label' => __( 'Show site title', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => '9',
					'type' => 'checkbox',
				) );

			// Show site title annotation
			$wp_customize->add_setting( 'custom_logo_text_span_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'custom_logo_text_span_open',
				array(
					'label' => __( 'Show site title annotation', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => '10',
					'type' => 'checkbox',
				) );

			// Site title annotation content
			$wp_customize->add_setting( 'custom_logo_text_span',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'custom_logo_text_span',
				array(
					'label' => __( 'Site title annotation content', 'doc-text' ),
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

			// Site keywords
			$wp_customize->add_setting( 'doc_keywords',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_textarea_field',
					'transport' => '',
				)
			);
			$wp_customize->add_control( 'doc_keywords',
				array(
					'label' => __( 'Site keywords', 'doc-text' ),
					'description' => __( 'Good keywords can improve rankings, use English commas to separate each word', 'doc-text' ),
					'section' => 'title_tagline',
					'type' => 'textarea',
					'priority' => '10',
					'input_attrs' => array(
						'placeholder' => __( 'WordPress,Web Design,DOCCG.COM', 'doc-text' ),
					),
				)
			);


			/* -------------------------------------------------------------------------- */
			/*	Add panel
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_panel( 'doc_panels',
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

			// Show thumbnail
			$wp_customize->add_setting( 'doc_list_pic_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_pic_open',
				array(
					'label' => __( 'Show thumbnail', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show category
			$wp_customize->add_setting( 'doc_list_category_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_category_open',
				array(
					'label' => __( 'Show category', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show release time
			$wp_customize->add_setting( 'doc_list_time_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_time_open',
				array(
					'label' => __( 'Show release time', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show excerpt
			$wp_customize->add_setting( 'doc_list_excerpt_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_excerpt_open',
				array(
					'label' => __( 'Show excerpt', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show button
			$wp_customize->add_setting( 'doc_list_link_text_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_link_text_open',
				array(
					'label' => __( 'Show button', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Button text content
			$wp_customize->add_setting( 'doc_list_link_text',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_list_link_text',
				array(
					'label' => __( 'Button text content', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '10',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( 'Read more', 'doc-text' ),
					),
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

			// Show article category
			$wp_customize->add_setting( 'doc_sin_top_category_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_top_category_open',
				array(
					'label' => __( 'Show article category', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show article date, readings, comments, etc
			$wp_customize->add_setting( 'doc_sin_meta_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_meta_open',
				array(
					'label' => __( 'Show article date, readings, comments, etc', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show article copyright
			$wp_customize->add_setting( 'doc_sin_copytight_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_copytight_open',
				array(
					'label' => __( 'Show article copyright', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Article copyright content
			$wp_customize->add_setting( 'doc_sin_copytight',
				array(
					'default' => '',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_sin_copytight',
				array(
					'label' => __( 'Article copyright content', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'textarea',
					'input_attrs' => array(
						'placeholder' => __( 'This article is collected from the Internet, and the copyright belongs to the original author or organization. If this page violates your rights, please contact us via email hi@doccg.com!', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_sin_copytight',
				array(
					'selector' => '.single-copytight span',
					'settings' => 'doc_sin_copytight',
					'render_callback' => function () {
						return get_theme_mod( 'doc_sin_copytight' );
					},
				) );

			// Show article comment button
			$wp_customize->add_setting( 'doc_sin_comment_button_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_comment_button_open',
				array(
					'label' => __( 'Show article comment button', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show article sharing
			$wp_customize->add_setting( 'doc_sin_share_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_share_open',
				array(
					'label' => __( 'Show article sharing', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Article sharing button settings
			$wp_customize->add_setting( 'doc_sin_share',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_sin_share',
				array(
					'label' => __( 'Article sharing button settings', 'doc-text' ),
					'description' => __( 'Optional[ weibo,qq,wechat,tencent,douban,qzone ] [ linkedin,diandian,facebook,twitter,google ] https://github.com/overtrue/share.js/', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'weibo,qq,wechat,tencent,qzone',
					),
				) );

			// Show article tags
			$wp_customize->add_setting( 'doc_sin_tag_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_tag_open',
				array(
					'label' => __( 'Show article tags', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site footer
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
					'default' => '',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_bottom_about',
				array(
					'label' => __( 'Site footer introductiont', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'textarea',
					'input_attrs' => array(
						'placeholder' => __( 'Thank you for visiting my small site. I am a designer and front-end development enthusiast. These are some resources and materials that I usually collect. hope it helps you.', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_bottom_about',
				array(
					'selector' => '.bottom-about p',
					'settings' => 'doc_bottom_about',
					'render_callback' => function () {
						return get_theme_mod( 'doc_bottom_about' );
					},
				) );

			// Latest article title
			$wp_customize->add_setting( 'doc_express_title',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_express_title',
				array(
					'label' => __( 'Latest article title', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( 'Express', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_express_title',
				array(
					'selector' => '.news-posts .site-bottom-title',
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
					'input_attrs' => array(
						'placeholder' => '京ICP备xxxxxxxx号',
					),
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
					'description' => __( 'Choose one of URL and JS, Recommend https://yzf.qq.com/', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://yzf.qq.com/xv/web/static/chat/index.html?sign=37ef9b97d173059221459eeb1ab4b0608894ad265104845809fd80aa56ed7cae727195f2bd226dae3115d3f705d291c3dcd4185e',
					),
				) );

			// Statistical code JS
			$wp_customize->add_setting( 'doc_back_totop_bell_js',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_html_class',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_back_totop_bell_js',
				array(
					'label' => __( 'Online service js', 'doc-text' ),
					'description' => __( 'Choose one of URL and JS, Recommend https://yzf.qq.com/', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'textarea',
				) );

			// Show back to top
			$wp_customize->add_setting( 'doc_back_totop_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_back_totop_open',
				array(
					'label' => __( 'Show back to top', 'doc-text' ),
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

			// Show social
			$wp_customize->add_setting( 'doc_socialization_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_socialization_open',
				array(
					'label' => __( 'Show social', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Social title
			$wp_customize->add_setting( 'doc_socialization_title',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_socialization_title',
				array(
					'label' => __( 'Social title', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( 'Follow us', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_socialization_title',
				array(
					'selector' => '.bottom-link .site-bottom-title',
					'settings' => 'doc_socialization_title',
					'render_callback' => function () {
						return get_theme_mod( 'doc_socialization_title' );
					},
				) );

			// QQ
			$wp_customize->add_setting( 'doc_link_qq',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_qq',
				array(
					'label' => 'QQ',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => '1234567',
					),
				) );

			// Weibo
			$wp_customize->add_setting( 'doc_link_weibo',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_weibo',
				array(
					'label' => __( 'Weibo', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://twitter.com/yourname',
					),
				) );

			// Behance
			$wp_customize->add_setting( 'doc_link_behance',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_behance',
				array(
					'label' => 'Behance',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.behance.net/yourname',
					),
				) );

			// Dribbble
			$wp_customize->add_setting( 'doc_link_dribbble',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_dribbble',
				array(
					'label' => 'Dribbble',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://dribbble.com/yourname',
					),
				) );

			// Linkedin
			$wp_customize->add_setting( 'doc_link_linkedin',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_linkedin',
				array(
					'label' => 'Linkedin',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.linkedin.com/in/yourname/',
					),
				) );

			// Reddit
			$wp_customize->add_setting( 'doc_link_reddit',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_reddit',
				array(
					'label' => 'Reddit',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.reddit.com/user/yourname',
					),
				) );

			// Facebook
			$wp_customize->add_setting( 'doc_link_facebook',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_facebook',
				array(
					'label' => 'Facebook',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.facebook.com/yourname',
					),
				) );

			// Twitter
			$wp_customize->add_setting( 'doc_link_twitter',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_twitter',
				array(
					'label' => 'Tumblr',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://twitter.com/yourname',
					),
				) );

			// Telegram
			$wp_customize->add_setting( 'doc_link_telegram',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_telegram',
				array(
					'label' => 'Telegram',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://t.me/yourname',
					),
				) );

			// Pinterest
			$wp_customize->add_setting( 'doc_link_pinterest',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_pinterest',
				array(
					'label' => 'Pinterest',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.pinterest.com/yourname/',
					),
				) );

			// 500px
			$wp_customize->add_setting( 'doc_link_500px',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_500px',
				array(
					'label' => '500px',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://500px.com/p/yourname?view=photos',
					),
				) );

			// Instagram
			$wp_customize->add_setting( 'doc_link_instagram',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_instagram',
				array(
					'label' => 'Instagram',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.instagram.com/yourname/',
					),
				) );

			// Tumblr
			$wp_customize->add_setting( 'doc_link_tumblr',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_tumblr',
				array(
					'label' => 'Tumblr',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.tumblr.com/blog/yourname',
					),
				) );

			// Twitch
			$wp_customize->add_setting( 'doc_link_twitch',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_twitch',
				array(
					'label' => 'Twitch',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.twitch.tv/yourname',
					),
				) );

			// Vimeo
			$wp_customize->add_setting( 'doc_link_vimeo',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_vimeo',
				array(
					'label' => 'Vimeo',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://vimeo.com/yourname',
					),
				) );

			// Youtube
			$wp_customize->add_setting( 'doc_link_youtube',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_youtube',
				array(
					'label' => 'Youtube',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://www.youtube.com/channel/yourname',
					),
				) );

			// Github
			$wp_customize->add_setting( 'doc_link_github',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_github',
				array(
					'label' => 'Github',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://github.com/yourname/projectname',
					),
				) );

			// Steam
			$wp_customize->add_setting( 'doc_link_steam',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_steam',
				array(
					'label' => 'Steam',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'https://steamcommunity.com/id/yourname/',
					),
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site QR code
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_qrcode_menu',
				array(
					'title' => __( 'Site QR code', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Show QR code
			$wp_customize->add_setting( 'doc_qrcode_open',
				array(
					'default' => false,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_qrcode_open',
				array(
					'label' => __( 'Show QR code', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// QR code title
			$wp_customize->add_setting( 'doc_qrcode_title',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_qrcode_title',
				array(
					'label' => __( 'QR code title', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( 'Scan it', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_qrcode_title',
				array(
					'selector' => '.link-img span',
					'settings' => 'doc_qrcode_title',
					'render_callback' => function () {
						return get_theme_mod( 'doc_qrcode_title' );
					},
				) );

			// QR code image
			$wp_customize->add_setting( 'doc_qrcode_img',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_image',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode_img',
				array(
					'label' => __( 'QR code image', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
				) ) );

			// QR code image 2
			$wp_customize->add_setting( 'doc_qrcode_img_2',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_image',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode_img_2',
				array(
					'label' => __( 'QR code image 2', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
				) ) );

			// QR code image 3
			$wp_customize->add_setting( 'doc_qrcode_img_3',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_image',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode_img_3',
				array(
					'label' => __( 'QR code image 3', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
				) ) );

			/* -------------------------------------------------------------------------- */
			/*	Site advertisement
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_advertisement_menu',
				array(
					'title' => __( 'Site advertisement', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Show global bottom ads
			$wp_customize->add_setting( 'doc_global_bottom_ad_open',
				array(
					'default' => false,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_open',
				array(
					'label' => __( 'Show global bottom ads', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Ad title
			$wp_customize->add_setting( 'doc_global_bottom_ad_title',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_title',
				array(
					'label' => __( 'Ad title', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'DOCCG 2020',
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_global_bottom_ad_title',
				array(
					'selector' => '.site-bottom-ad h2',
					'settings' => 'doc_global_bottom_ad_title',
					'render_callback' => function () {
						return get_theme_mod( 'doc_global_bottom_ad_title' );
					},
				) );

			// Ad description
			$wp_customize->add_setting( 'doc_global_bottom_ad_p',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_p',
				array(
					'label' => __( 'Ad description', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( 'Super easy to use WordPress theme', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_global_bottom_ad_p',
				array(
					'selector' => '.site-bottom-ad p',
					'settings' => 'doc_global_bottom_ad_p',
					'render_callback' => function () {
						return get_theme_mod( 'doc_global_bottom_ad_p' );
					},
				) );

			// Ad url text
			$wp_customize->add_setting( 'doc_global_bottom_ad_url_text',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_url_text',
				array(
					'label' => __( 'Ad url text', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( 'Get it for free', 'doc-text' ),
					),
				) );
			$wp_customize->selective_refresh->add_partial( 'doc_global_bottom_ad_url_text',
				array(
					'selector' => '.site-bottom-ad-link a',
					'settings' => 'doc_global_bottom_ad_url_text',
					'render_callback' => function () {
						return get_theme_mod( 'doc_global_bottom_ad_url_text' );
					},
				) );

			// Ad url
			$wp_customize->add_setting( 'doc_global_bottom_ad_url',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_url',
				array(
					'label' => __( 'Ad url', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => get_bloginfo( 'url' ),
					),
				) );

			// Ad background image
			$wp_customize->add_setting( 'doc_global_bottom_ad_img',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_image',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_global_bottom_ad_img',
				array(
					'label' => __( 'Ad background image', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
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
if ( !function_exists( 'doc_get_custom_logo_text' ) ) {
	function doc_get_custom_logo_text() {
		bloginfo( 'name' );
	}
}