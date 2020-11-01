<?php
/**
 * Theme customization settings.
 *
 * wp default menu and add custom attributes
 * Add panel
 * Site home
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
			$wp_customize->selective_refresh->add_partial( 'blogname',
				array(
					'selector' => '.custom-logo-text',
					'render_callback' => 'doc_custom_logo_text',
				)
			);

			// Show site title
			$wp_customize->add_setting( 'custom_logo_text_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'custom_logo_text_open',
				array(
					'label' => __( '显示站点标题', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => '9',
					'type' => 'checkbox',
				) );

			// Show site title annotation
			$wp_customize->add_setting( 'custom_logo_text_span_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'custom_logo_text_span_open',
				array(
					'label' => __( '显示站点标题注释', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => 10,
					'type' => 'checkbox',
				) );

			// Site title annotation content
			$wp_customize->add_setting( 'custom_logo_text_span',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'custom_logo_text_span',
				array(
					'label' => __( '站点标题注释内容', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => 10,
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
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => '',
				)
			);
			$wp_customize->add_control( 'doc_keywords',
				array(
					'label' => __( '站点关键词', 'doc-text' ),
					'description' => esc_html__( '好的关键字可以提高排名，使用英文逗号分隔每个单词', 'doc-text' ),
					'section' => 'title_tagline',
					'priority' => 10,
					'type' => 'textarea',
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
					'title' => __( '主题设置', 'doc-text' ),
					'priority' => 0,
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	Site home
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_home_menu',
				array(
					'title' => __( '站点首页', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			// Show carousel pictures
			$wp_customize->add_setting( 'doc_banner_open',
				array(
					'default' => 0,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_banner_open',
				array(
					'label' => __( '显示轮播', 'doc-text' ),
					'section' => 'doc_home_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Number of Carousel Pictures
			$wp_customize->add_setting( 'doc_banner_number',
				array(
					'default' => '3',
					'sanitize_callback' => 'absint',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_banner_number',
				array(
					'label' => __( '轮播数量', 'doc-text' ),
					'section' => 'doc_home_menu',
					'priority' => '',
					'type' => 'text',
				) );

			// Carousel picture display mode
			$wp_customize->add_setting( 'doc_banner_select',
				array(
					'default' => 'article',
					'sanitize_callback' => 'doc_sanitize_radio',
					'transport' => 'refresh',
				)
			);

			$wp_customize->add_control( 'doc_banner_select',
				array(
					'label' => __( '轮播显示模式', 'doc-text' ),
					'section' => 'doc_home_menu',
					'priority' => '',
					'type' => 'select',
					'choices' => array(
						'category' => __( '分类模式', 'doc-text' ),
						'article' => __( '文章模式', 'doc-text' )
					)
				)
			);

			// Category ID
			$wp_customize->add_setting( 'doc_banner_category_id',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_banner_category_id',
				array(
					'label' => __( '分类ID', 'doc-text' ),
					'description' => esc_html__( '您可以填写多个ID，以逗号分隔', 'doc-text' ),
					'section' => 'doc_home_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => '1,2,3',
					),
				) );

			// Article ID
			$wp_customize->add_setting( 'doc_banner_post_id',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_banner_post_id',
				array(
					'label' => __( '文章ID', 'doc-text' ),
					'description' => esc_html__( '您可以填写多个ID，以逗号分隔', 'doc-text' ),
					'section' => 'doc_home_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => '1,2,3',
					),
				) );
			/* -------------------------------------------------------------------------- */
			/*	Article list
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_post_list_menu',
				array(
					'title' => __( '分类列表', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			// Show thumbnail
			$wp_customize->add_setting( 'doc_list_pic_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_list_pic_open',
				array(
					'label' => __( '显示缩略图', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show category
			$wp_customize->add_setting( 'doc_list_category_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_list_category_open',
				array(
					'label' => __( '显示分类', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show release time
			$wp_customize->add_setting( 'doc_list_time_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_list_time_open',
				array(
					'label' => __( '显示发布时间', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show excerpt
			$wp_customize->add_setting( 'doc_list_excerpt_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_list_excerpt_open',
				array(
					'label' => __( '显示摘要', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show button
			$wp_customize->add_setting( 'doc_list_link_text_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_list_link_text_open',
				array(
					'label' => __( '显示按钮', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Button text content
			$wp_customize->add_setting( 'doc_list_link_text',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_list_link_text',
				array(
					'label' => __( '按钮文字', 'doc-text' ),
					'section' => 'doc_post_list_menu',
					'priority' => '',
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => __( '阅读更多', 'doc-text' ),
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
					'title' => __( '文章页', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => ''
				) );

			// Show article category
			$wp_customize->add_setting( 'doc_sin_top_category_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_sin_top_category_open',
				array(
					'label' => __( '显示文章分类', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show article date, readings, comments, etc
			$wp_customize->add_setting( 'doc_sin_meta_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_sin_meta_open',
				array(
					'label' => __( '显示文章日期，阅读，评论等', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show article copyright
			$wp_customize->add_setting( 'doc_sin_copytight_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_sin_copytight_open',
				array(
					'label' => __( '显示文章版权', 'doc-text' ),
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
					'label' => __( '文章版权内容', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'textarea',
					'input_attrs' => array(
						'placeholder' => __( '本文是从Internet上收集的，版权属于原始作者或组织。 如果此页面侵犯了您的权利，请通过电子邮件hi@doccg.com与我们联系！', 'doc-text' ),
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
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_sin_comment_button_open',
				array(
					'label' => __( '显示文章评论按钮', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Show article sharing
			$wp_customize->add_setting( 'doc_sin_share_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_sin_share_open',
				array(
					'label' => __( '显示文章分享', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Article sharing button settings
			$wp_customize->add_setting( 'doc_sin_share',
				array(
					'default' => 'weibo,qq,wechat,tencent,qzone',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_sin_share',
				array(
					'label' => __( '分享按钮设置', 'doc-text' ),
					'description' => esc_html__( '可选[ weibo,qq,wechat,tencent,douban,qzone ] [ linkedin,diandian,facebook,twitter,google ] <a target="_blank" href="https://github.com/overtrue/share.js/">https://github.com/overtrue/share.js/</a>', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'text',
				) );

			// Show article tags
			$wp_customize->add_setting( 'doc_sin_tag_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_sin_tag_open',
				array(
					'label' => __( '显示文章标签', 'doc-text' ),
					'section' => 'doc_post_page_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site footer
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_footer_menu',
				array(
					'title' => __( '站点底部', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Site footer introduction
			$wp_customize->add_setting( 'doc_bottom_about',
				array(
					'default' => __( '感谢您访问我的小栈。我是设计师，也是前端开发爱好者。这些是我通常收集的一些资源和材料。希望对您有帮助。', 'doc-text' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_bottom_about',
				array(
					'label' => __( '站点页脚介绍', 'doc-text' ),
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

			// Latest article title
			$wp_customize->add_setting( 'doc_express_title',
				array(
					'default' => __( '快讯', 'doc-text' ),
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_express_title',
				array(
					'label' => __( '底部文章标题', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'text',
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
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_record',
				array(
					'label' => __( '备案号', 'doc-text' ),
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
					'label' => __( '统计代码', 'doc-text' ),
					'section' => 'doc_footer_menu',
					'priority' => '',
					'type' => 'textarea',
				) );


			/* -------------------------------------------------------------------------- */
			/*	Site float
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_float_menu',
				array(
					'title' => __( '站点浮动', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Online service url
			$wp_customize->add_setting( 'doc_back_totop_bell_url',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_back_totop_bell_url',
				array(
					'label' => __( '在线服务url版', 'doc-text' ),
					'description' => esc_html__( '建议只选择选择URL和JS之一，推荐 <a target="_blank" href="https://yzf.qq.com/">https://yzf.qq.com/</a>', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'text'
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
					'label' => __( '在线服务js版', 'doc-text' ),
					'description' => esc_html__( '建议只选择选择URL和JS之一，推荐 <a target="_blank" href="https://yzf.qq.com/">https://yzf.qq.com/</a>', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'textarea',
				) );

			// Show back to top
			$wp_customize->add_setting( 'doc_back_totop_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_back_totop_open',
				array(
					'label' => __( '显示返回顶部', 'doc-text' ),
					'section' => 'doc_float_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			/* -------------------------------------------------------------------------- */
			/*	Site Socialization
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_socialization_menu',
				array(
					'title' => __( '站点社交', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Show social
			$wp_customize->add_setting( 'doc_socialization_open',
				array(
					'default' => 1,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_socialization_open',
				array(
					'label' => __( '显示社会化', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Social title
			$wp_customize->add_setting( 'doc_socialization_title',
				array(
					'default' => __( '关注我们', 'doc-text' ),
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_socialization_title',
				array(
					'label' => __( '社会化标题', 'doc-text' ),
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
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
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'refresh',
				) );
			$wp_customize->add_control( 'doc_link_qq',
				array(
					'label' => 'QQ',
					'section' => 'doc_socialization_menu',
					'priority' => '',
					'type' => 'text',
				) );

			// Weibo
			$wp_customize->add_setting( 'doc_link_weibo',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'sanitize_callback' => 'doc_sanitize_text',
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
					'title' => __( '站点二维码', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Show QR code
			$wp_customize->add_setting( 'doc_qrcode_open',
				array(
					'default' => 0,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_qrcode_open',
				array(
					'label' => __( '显示二维码', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// QR code title
			$wp_customize->add_setting( 'doc_qrcode_title',
				array(
					'default' => __( '扫一扫', 'doc-text' ),
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_qrcode_title',
				array(
					'label' => __( '二维码标题', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
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

			// QR code image
			$wp_customize->add_setting( 'doc_qrcode_img',
				array(
					'default' => '',
					'sanitize_callback' => 'esc_url_raw',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode_img',
				array(
					'label' => __( '二维码图片', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
				) ) );

			// QR code image 2
			$wp_customize->add_setting( 'doc_qrcode_img_2',
				array(
					'default' => '',
					'sanitize_callback' => 'esc_url_raw',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode_img_2',
				array(
					'label' => __( '二维码图片 2', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
				) ) );

			// QR code image 3
			$wp_customize->add_setting( 'doc_qrcode_img_3',
				array(
					'default' => '',
					'sanitize_callback' => 'esc_url_raw',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_qrcode_img_3',
				array(
					'label' => __( '二维码图片 3', 'doc-text' ),
					'section' => 'doc_qrcode_menu',
					'priority' => '',
				) ) );

			/* -------------------------------------------------------------------------- */
			/*	Site advertisement
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section( 'doc_advertisement_menu',
				array(
					'title' => __( '站点广告', 'doc-text' ),
					'panel' => 'doc_panels',
					'priority' => '',
				) );

			// Show global bottom ads
			$wp_customize->add_setting( 'doc_global_bottom_ad_open',
				array(
					'default' => 0,
					'sanitize_callback' => 'doc_sanitize_switch',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_open',
				array(
					'label' => __( '显示全局底部广告', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'checkbox',
				) );

			// Ad title
			$wp_customize->add_setting( 'doc_global_bottom_ad_title',
				array(
					'default' => '',
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_title',
				array(
					'label' => __( '广告标题', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
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
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_p',
				array(
					'label' => __( '广告描述', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
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
					'default' => __( '免费获取', 'doc-text' ),
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => 'postMessage',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_url_text',
				array(
					'label' => __( '广告链接文字', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
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
					'sanitize_callback' => 'doc_sanitize_text',
					'transport' => '',
				) );
			$wp_customize->add_control( 'doc_global_bottom_ad_url',
				array(
					'label' => __( '广告链接', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
					'type' => 'text',
				) );

			// Ad background image
			$wp_customize->add_setting( 'doc_global_bottom_ad_img',
				array(
					'default' => '',
					'sanitize_callback' => 'esc_url_raw',
				) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'doc_global_bottom_ad_img',
				array(
					'label' => __( '广告背景图片', 'doc-text' ),
					'section' => 'doc_advertisement_menu',
					'priority' => '',
				) ) );

		}

	}
	add_action( 'customize_register', array( 'doc_customizer', 'register' ) );

	require get_template_directory() . '/inc/customizer/customizer-sanitize.php';
}

/**
 * Partial refresh function
 */
if ( !function_exists( 'doc_custom_logo_text' ) ) {
	function doc_custom_logo_text() {
		bloginfo( 'name' );
	}
}