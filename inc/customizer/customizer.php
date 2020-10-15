<?php


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

			// Ranking keywords
			$wp_customize->add_setting(
				'doc_keywords',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_textarea_field',
					'transport' => 'false',
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
					'title' => __( '主题设置', 'doc-text' ),
					'priority' => 0,
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	Site post list
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_site_post_list_menu',
				array(
					'title' => __( '帖子列表', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			/* Show share open */
			$wp_customize->add_setting( 'doc_list_pic_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_pic_open',
				array(
					'label' => __( '显示缩略图', 'doc-text' ),
					'section' => 'doc_site_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Show share open */
			$wp_customize->add_setting( 'doc_list_card_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_card_open',
				array(
					'label' => __( '显示所属分类', 'doc-text' ),
					'section' => 'doc_site_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Show share open */
			$wp_customize->add_setting( 'doc_list_excerpt_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_excerpt_open',
				array(
					'label' => __( '显示摘要', 'doc-text' ),
					'section' => 'doc_site_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Show author open */
			$wp_customize->add_setting( 'doc_list_author_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_author_open',
				array(
					'label' => __( '显示作者', 'doc-text' ),
					'section' => 'doc_site_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Show read open */
			$wp_customize->add_setting( 'doc_list_read_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_read_open',
				array(
					'label' => __( '显示阅读时间', 'doc-text' ),
					'section' => 'doc_site_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Show time open */
			$wp_customize->add_setting( 'doc_list_time_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_list_time_open',
				array(
					'label' => __( '显示发布时间', 'doc-text' ),
					'section' => 'doc_site_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site post page
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_site_post_page_menu',
				array(
					'title' => __( '帖子页面', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			/* Show share open */
			$wp_customize->add_setting( 'doc_sin_share_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_sin_share_open',
				array(
					'label' => __( '显示分享', 'doc-text' ),
					'section' => 'doc_site_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Show share */
			$wp_customize->add_setting( 'doc_sin_share',
				array(
					'default' => 'weibo,qzone,qq,wechat',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_sin_share',
				array(
					'label' => __( '自定义分享', 'doc-text' ),
					'description' => __( '微博、QQ空间、QQ好友、微信、腾讯微博、豆瓣、Facebook、Twitter、Linkedin、Google+、点点等社交网站', 'doc-text' ),
					'section' => 'doc_site_post_page_menu',
					'priority' => '',
					'type' => 'text',
				) );

			/* Global tips at the bottom open */
			$wp_customize->add_setting( 'doc_single_copytight_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_single_copytight_open',
				array(
					'label' => __( '显示帖子底部全局提示', 'doc-text' ),
					'section' => 'doc_site_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* Global tips at the bottom */
			$wp_customize->add_setting( 'doc_single_copytight',
				array(
					'default' => __( '本文是从网络上收集的，版权属于原始作者或组织。 如果此页面侵犯了您的权益，请通过电子邮件 hi@wangtingbiao.com 与我们联系！', 'doc-text' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_single_copytight',
				array(
					'label' => __( '帖子底部全局提示', 'doc-text' ),
					'section' => 'doc_site_post_page_menu',
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

			/* -------------------------------------------------------------------------- */
			/*	Global site bottom
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_global_site_footer_menu',
				array(
					'title' => __( '站点页尾与浮动', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			/* China record number */
			$wp_customize->add_setting( 'doc_record',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_record',
				array(
					'label' => __( '备案号', 'doc-text' ),
					'section' => 'doc_global_site_footer_menu',
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

			/* Statistical code */
			$wp_customize->add_setting( 'doc_statistics',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_html_class',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_statistics',
				array(
					'label' => __( '统计代码', 'doc-text' ),
					'section' => 'doc_global_site_footer_menu',
					'priority' => '',
					'type' => 'textarea',
				) );

			/* Display QR code */
			$wp_customize->add_setting( 'doc_qrcode_open',
				array(
					'default' => false,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_qrcode_open',
				array(
					'label' => __( '显示二维码', 'doc-text' ),
					'section' => 'doc_global_site_footer_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* QR code for site/company/person */
			$wp_customize->add_setting( 'doc_qrcode',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_image',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode',
				array(
					'label' => __( '微信/小程序/公众号二维码', 'doc-text' ),
					'section' => 'doc_global_site_footer_menu',
					'priority' => '',
				) ) );

			/* Display back to top */
			$wp_customize->add_setting( 'doc_back_totop_open',
				array(
					'default' => true,
					'sanitize_callback' => array( __CLASS__, 'doc_sanitize_checkbox' ),
				) );
			$wp_customize->add_control( 'doc_back_totop_open',
				array(
					'label' => __( '返回顶部', 'doc-text' ),
					'section' => 'doc_global_site_footer_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

		}

		/* Sanitize boolean for checkbox. */
		public static function doc_sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

	}

	add_action( 'customize_register', array( 'doc_customizer', 'register' ) );

}

/* Partial refresh function */
if ( !function_exists( 'doc_custom_logo_text' ) ) {
	function doc_custom_logo_text() {
		bloginfo( 'name' );
	}
}