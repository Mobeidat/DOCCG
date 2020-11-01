<?php
/**
 * Global basic settings.
 *
 * Exclude all pages from search results
 * Hide the black bar at the top of WordPress to remove the administrator login toolbar
 * Delete the Class selector
 * Website keyword description
 * Website custom logo
 * Custom breadcrumb navigation
 * Global information at the top of the site
 * Website social and custom QRcode
 * The copyright year will be updated automatically
 * Website copyright notice and bottom menu
 * Website statistics and floating buttons
 *
 * @package TingBiao Wang
 */

/**
 * Exclude all pages from search results
 */
function search_filter_page( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', 'post' );
	}
	return $query;
}
add_filter( 'pre_get_posts', 'search_filter_page' );

/**
 * Hide the black bar at the top of WordPress to remove the administrator login toolbar
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Delete the Class selector
 */
function doc_css_attributes_filter( $var ) {
	return is_array( $var ) ? array_intersect( $var, array( 'current-menu-item', 'current-post-ancestor', 'current-menu-ancestor' ) ) : '';
}
add_filter( 'nav_menu_css_class', 'doc_css_attributes_filter', 100, 1 );
add_filter( 'nav_menu_item_id', 'doc_css_attributes_filter', 100, 1 );
add_filter( 'page_css_class', 'doc_css_attributes_filter', 100, 1 );

/**
 * Website keyword description
 */
if ( !function_exists( 'doc_keywords' ) ) {
	function doc_keywords() {
		if ( is_home() || is_front_page() ) {
			echo get_theme_mod( 'doc_keywords' );
		} elseif ( is_category() ) {
			single_cat_title();
		} elseif ( is_single() ) {
			echo trim( wp_title( '', false ) ) . ',';
			if ( has_tag() ) {
				foreach ( get_the_tags() as $tag ) {
					echo $tag->name . ',';
				}
			}
			foreach ( get_the_category() as $category ) {
				echo $category->cat_name . ',';
			}
		} elseif ( is_search() ) {
			the_search_query();
		} else {
			echo trim( wp_title( '', false ) );
		}
	}
}

function doc_keywords_description() {
	?>
<meta name="keywords" content="<?php doc_keywords(); ?>">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<?php
}
add_action( 'wp_head', 'doc_keywords_description' );

/**
 * Website custom logo
 */
if ( !function_exists( 'doc_custom_logo' ) ) {
	function doc_custom_logo() {

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		$custom_logo_text_open = get_theme_mod( 'custom_logo_text_open', 1 );
		$custom_logo_text_span_open = get_theme_mod( 'custom_logo_text_span_open', 1 );
		$custom_logo_text_span = get_theme_mod( 'custom_logo_text_span', '2020' );

		echo '<h1 itemscope itemtype="http://schema.org/Organization" class="site-title"><a itemprop="url" rel="home" class="custom-logo-text" href="' . esc_url( home_url( '/' ) ) . '">';
		if ( has_custom_logo() ) {
			echo '<img itemprop="logo" src="' . esc_url( $logo[ 0 ] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		}
		if ( $custom_logo_text_open ) {
			echo '<span>' . get_bloginfo( 'name' ) . '</span>';
		}
		echo '</a>';
		if ( $custom_logo_text_span_open ) {
			echo '<p class="site-title-p">' . $custom_logo_text_span . '</p>';
		}
		echo '</h1>';
	}
}

/**
 * Custom breadcrumb navigation
 */
if ( !function_exists( 'doc_breadcrumbs' ) ) {
	function doc_breadcrumbs() {

		$delimiter = '<span>&nbsp;&raquo;&nbsp;</span>';
		$before = '<span class="current">';
		$after = '</span>';

		if ( !is_home() && !is_front_page() || is_paged() ) {
			echo '<section class="breadcrumbs" itemscope itemtype="https://schema.org/WebPage"><div class="max-width">';
			global $post;
			$homeLink = home_url();
			echo ' <a itemprop="name" href="' . $homeLink . '">' . __( '首页', 'doc-text' ) . '</a> ' . $delimiter;
			if ( is_category() ) {
				global $wp_query;

				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category( $thisCat );
				$parentCat = get_category( $thisCat->parent );

				if ( $thisCat->parent != 0 ) {
					$cat_code = get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ' );
					echo $cat_code = str_replace( '<a', '<a itemprop="breadcrumb"', $cat_code );
				}
				echo $before . '' . single_cat_title( '', false ) . '' . $after;
			} elseif ( is_day() ) {
				echo '<a itemprop="breadcrumb" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo '<a itemprop="breadcrumb"  href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
				echo $before . get_the_time( 'd' ) . $after;
			}
			elseif ( is_month() ) {
				echo '<a itemprop="breadcrumb" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo $before . get_the_time( 'F' ) . $after;
			}
			elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;
			}
			elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug = $post_type->rewrite;
					echo '<a itemprop="breadcrumb" href="' . $homeLink . '/' . $slug[ 'slug' ] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
					echo $before . get_the_title() . $after;
				} else {
					$cat = get_the_category();
					$cat = $cat[ 0 ];
					$cat_code = get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
					echo $cat_code = str_replace( '<a', '<a itemprop="breadcrumb"', $cat_code );
					echo $before . get_the_title() . $after;
				}
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->singular_name . $after;
			}
			elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat = get_the_category( $parent->ID );
				$cat = $cat[ 0 ];
				echo '<a itemprop="breadcrumb" href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			}
			elseif ( is_page() && !$post->post_parent ) {
				echo $before . get_the_title() . $after;
			}
			elseif ( is_page() && $post->post_parent ) {
				$parent_id = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = '<a itemprop="breadcrumb" href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb )echo $crumb . ' ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			}
			elseif ( is_search() ) {
				echo $before;
				printf( __( '搜索“%s”结果', 'doc-text' ), get_search_query() );
				echo $after;
			}
			elseif ( is_tag() ) {
				echo $before;
				printf( __( '标签“%s”归档', 'doc-text' ), single_tag_title( '', false ) );
				echo $after;
			}
			elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before;
				printf( __( '作者"%s"归档', 'doc-text' ), $userdata->display_name );
				echo $after;
			}
			elseif ( is_404() ) {
				echo $before;
				_e( 'Not Found', 'doc-text' );
				echo $after;
			}
			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo sprintf( __( '(页面 %s )', 'doc-text' ), get_query_var( 'paged' ) );
			}
			echo '</div></section>';
		}
	}
}

/**
 * Homepage Carousel Picture
 */
if ( !function_exists( 'doc_banner' ) ) {
	function doc_banner() {
		$doc_banner_open = get_theme_mod( 'doc_banner_open', 0 );
		if ( $doc_banner_open ) {
			echo '<section class="swiper-container"><div class="swiper-wrapper">';
			$doc_banner_select = get_theme_mod( 'doc_banner_select' );
			$doc_banner_number = get_theme_mod( 'doc_banner_number', '3' );
			$doc_banner_category_id = explode( ",", get_theme_mod( 'doc_banner_category_id' ) );
			$doc_banner_post_id = explode( ",", get_theme_mod( 'doc_banner_post_id' ) );

			if ( $doc_banner_select == 'category' ) {

				$banner_query = array( 'ignore_sticky_posts' => 1, 'posts_per_page' => $doc_banner_number, 'cat' => $doc_banner_category_id );

			} elseif ( $doc_banner_select == 'article' ) {

				$banner_query = array( 'ignore_sticky_posts' => 1, 'posts_per_page' => $doc_banner_number, 'post__in' => $doc_banner_post_id );

			};
			$banners_query = new WP_Query( $banner_query );
			if ( $banners_query->have_posts() ):
				while ( $banners_query->have_posts() ):
					$banners_query->the_post();
			if ( has_post_thumbnail() ) {
				echo '<figure class="swiper-slide" itemprop="image"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a></figure>';
			}
			endwhile;
			endif;
			wp_reset_postdata();
			echo '</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
				<div class="swiper-next"><i class="fa fa-angle-right"></i></div>
			</section>';
		}
	}
}

/**
 * Global information at the top of the site
 */
if ( !function_exists( 'doc_sort_box' ) ) {
	function doc_sort_box() {

		$h2_before = '<h2 itemprop="category">';
		$h2_after = '</h2>';
		$p_before = '<p>';
		$p_after = '</p>';

		echo '<section class="sort-box max-width" itemscope itemtype="https://schema.org/Text">';
		if ( is_search() ) {
			get_search_form();
			if ( have_posts() ) {
				global $wp_query;
				echo $p_before . sprintf( __( '找到与<span>" %1$s "</span>相关的文章<span>" %2$s "</span>篇！', 'doc-text' ), get_search_query(), $wp_query->found_posts ) . $p_after;
			} else {
				echo $p_before . sprintf( __( '未找到与<span>" %s "</span>相关文章，请换一个关键词重新尝试！', 'doc-text' ), get_search_query() ) . $p_after;
			};
		} elseif ( is_tag() ) {
			echo $h2_before . '" ';
			single_tag_title();
			echo ' "' . $h2_after;
		} elseif ( is_date() ) {
			echo $h2_before . esc_html__( get_the_date() ) . $h2_after;
		} else {
			echo $h2_before;
			single_cat_title();
			echo $h2_after;
			echo category_description();
		}
		echo '</section>';
	}
}

/**
 * Website social and custom QRcode
 */
if ( !function_exists( 'doc_bottom_link' ) ) {
	function doc_bottom_link() {

		$doc_socialization_open = get_theme_mod( 'doc_socialization_open', 1 );
		$doc_socialization_title = get_theme_mod( 'doc_socialization_title', __( '关注我们', 'doc-text' ) );
		if ( $doc_socialization_open ) {
			echo '<div class="site-bottom-list bottom-link" itemprop="about"><h3 class="site-bottom-title">' . $doc_socialization_title . '</h3>';

			$doc_link_qq = get_theme_mod( 'doc_link_qq' );
			$doc_link_weibo = get_theme_mod( 'doc_link_weibo' );
			$doc_link_behance = get_theme_mod( 'doc_link_behance' );
			$doc_link_dribbble = get_theme_mod( 'doc_link_dribbble' );
			$doc_link_linkedin = get_theme_mod( 'doc_link_linkedin' );
			$doc_link_reddit = get_theme_mod( 'doc_link_reddit' );
			$doc_link_facebook = get_theme_mod( 'doc_link_facebook' );
			$doc_link_twitter = get_theme_mod( 'doc_link_twitter' );
			$doc_link_telegram = get_theme_mod( 'doc_link_telegram' );
			$doc_link_pinterest = get_theme_mod( 'doc_link_pinterest' );
			$doc_link_500px = get_theme_mod( 'doc_link_500px' );
			$doc_link_instagram = get_theme_mod( 'doc_link_instagram' );
			$doc_link_tumblr = get_theme_mod( 'doc_link_tumblr' );
			$doc_link_twitch = get_theme_mod( 'doc_link_twitch' );
			$doc_link_vimeo = get_theme_mod( 'doc_link_vimeo' );
			$doc_link_youtube = get_theme_mod( 'doc_link_youtube' );
			$doc_link_github = get_theme_mod( 'doc_link_github' );
			$doc_link_steam = get_theme_mod( 'doc_link_steam' );

			if ( $doc_link_qq || $doc_link_weibo || $doc_link_behance || $doc_link_dribbble || $doc_link_linkedin || $doc_link_reddit || $doc_link_facebook || $doc_link_twitter || $doc_link_telegram || $doc_link_pinterest || $doc_link_500px || $doc_link_instagram || $doc_link_tumblr || $doc_link_twitch || $doc_link_vimeo || $doc_link_youtube || $doc_link_github || $doc_link_steam ) {
				echo '<p class="link-icon">';

				if ( $doc_link_qq ) {
					echo '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=' . $doc_link_qq . '&site=qq&menu=yes"><i class="fa fa-qq"></i></a>';
				}
				if ( $doc_link_weibo ) {
					echo '<a target="_blank" href="' . $doc_link_weibo . '"><i class="fa fa-weibo"></i></a>';
				}
				if ( $doc_link_behance ) {
					echo '<a target="_blank" href="' . $doc_link_behance . '"><i class="fa fa-behance"></i></a>';
				}
				if ( $doc_link_dribbble ) {
					echo '<a target="_blank" href="' . $doc_link_dribbble . '"><i class="fa fa-dribbble"></i></a>';
				}
				if ( $doc_link_linkedin ) {
					echo '<a target="_blank" href="' . $doc_link_linkedin . '"><i class="fa fa-linkedin"></i></a>';
				}
				if ( $doc_link_reddit ) {
					echo '<a target="_blank" href="' . $doc_link_reddit . '"><i class="fa fa-reddit-alien"></i></a>';
				}
				if ( $doc_link_facebook ) {
					echo '<a target="_blank" href="' . $doc_link_facebook . '"><i class="fa fa-facebook"></i></a>';
				}
				if ( $doc_link_twitter ) {
					echo '<a target="_blank" href="' . $doc_link_twitter . '"><i class="fa fa-twitter"></i></a>';
				}
				if ( $doc_link_telegram ) {
					echo '<a target="_blank" href="' . $doc_link_telegram . '"><i class="fa fa-telegram"></i></a>';
				}
				if ( $doc_link_pinterest ) {
					echo '<a target="_blank" href="' . $doc_link_pinterest . '"><i class="fa fa-pinterest"></i></a>';
				}
				if ( $doc_link_500px ) {
					echo '<a target="_blank" href="' . $doc_link_500px . '"><i class="fa fa-500px"></i></a>';
				}
				if ( $doc_link_instagram ) {
					echo '<a target="_blank" href="' . $doc_link_instagram . '"><i class="fa fa-instagram"></i></a>';
				}
				if ( $doc_link_tumblr ) {
					echo '<a target="_blank" href="' . $doc_link_tumblr . '"><i class="fa fa-tumblr"></i></a>';
				}
				if ( $doc_link_twitch ) {
					echo '<a target="_blank" href="' . $doc_link_twitch . '"><i class="fa fa-twitch"></i></a>';
				}
				if ( $doc_link_vimeo ) {
					echo '<a target="_blank" href="' . $doc_link_vimeo . '"><i class="fa fa-vimeo"></i></a>';
				}
				if ( $doc_link_youtube ) {
					echo '<a target="_blank" href="' . $doc_link_youtube . '"><i class="fa fa-youtube-play"></i></a>';
				}
				if ( $doc_link_github ) {
					echo '<a target="_blank" href="' . $doc_link_github . '"><i class="fa fa-github"></i></a>';
				}
				if ( $doc_link_steam ) {
					echo '<a target="_blank" href="' . $doc_link_steam . '"><i class="fa fa-steam"></i></a>';
				}

				echo '</p>';
			}

			$doc_qrcode_open = get_theme_mod( 'doc_qrcode_open', 0 );
			$doc_qrcode_title = get_theme_mod( 'doc_qrcode_title', __( '扫一扫', 'doc-text' ) );
			$doc_qrcode_img = get_theme_mod( 'doc_qrcode_img' );
			$doc_qrcode_img_2 = get_theme_mod( 'doc_qrcode_img_2' );
			$doc_qrcode_img_3 = get_theme_mod( 'doc_qrcode_img_3' );
			if ( $doc_qrcode_open ) {
				echo '<p class="link-img">';
				if ( $doc_qrcode_title ) {
					echo '<span>' . $doc_qrcode_title . '</span>';
				}
				echo '<img src="' . $doc_qrcode_img . '" alt="">';
				echo '<img src="' . $doc_qrcode_img_2 . '" alt="">';
				echo '<img src="' . $doc_qrcode_img_3 . '" alt="">';
				echo '</p>';
			}
			echo '</div>';
		}
	}
}

/**
 * The copyright year will be updated automatically
 */
if ( !function_exists( 'doc_copyright_date' ) ) {
	function doc_copyright_date() {
		global $wpdb;
		$copyright_dates = $wpdb->get_results( " SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
		if ( $copyright_dates ) {
			$date = date( 'Y-m-d' );
			$date = explode( '-', $date );
			$copyright = "&copy; " . $copyright_dates[ 0 ]->firstdate;
			if ( $copyright_dates[ 0 ]->firstdate != $date[ 0 ] ) {
				$copyright .= '-' . $date[ 0 ];
			}
			echo $copyright . ' ';
		}
	}
}

/**
 * Website copyright notice and bottom menu
 */
if ( !function_exists( 'doc_copyright_menu' ) ) {
	function doc_copyright_menu() {
		echo '<section class="copyright"><p><span itemprop="copyrightYear">';

		doc_copyright_date();
		bloginfo( 'name' );
		echo ' | ' . __( '程序', 'doc-text' ) . ' </span><a href="https://cn.wordpress.org/" target="_blank">Wordpress</a><span> | ' . __( '主题', 'doc-text' ) . ' </span><a href="https://www.wangtingbiao.com" target="_blank" itemprop="copyrightHolder">TingBiao Wang</a>';
		$doc_record = get_theme_mod( 'doc_record' );
		if ( $doc_record ) {
			echo '<span> | </span><a href="http://www.beian.miit.gov.cn/" class="docrecord" target="_blank">' . $doc_record . '</a>';
		}

		echo get_theme_mod( 'doc_statistics' );
		echo '</p>';

		$bottomnav = array(
			'theme_location' => 'bottomnav',
			'container' => 'div',
			'echo' => false,
			'items_wrap' => '%3$s',
			'depth' => 1,
			'fallback_cb' => 0,
		);
		echo strip_tags( wp_nav_menu( $bottomnav ), '<div><a>' );

		echo '</section>';
	}
}

/**
 * Website statistics and floating buttons
 */
if ( !function_exists( 'doc_statistics_fixed_box' ) ) {
	function doc_statistics_fixed_box() {
		echo '<div id="fixed-box">';

		if ( is_single() ) {
			while ( have_posts() ): the_post();
			echo '<a class="single-comment comment-toggle"><i class="fa fa-comment"></i><span>' . get_comments_number() . '</span></a>';
			endwhile;
		}

		$doc_bell_url = get_theme_mod( 'doc_bell_url' );
		$doc_bell_js = get_theme_mod( 'doc_bell_js' );
		$doc_back_totop_open = get_theme_mod( 'doc_back_totop_open', 1 );
		if ( $doc_bell_url ) {
			echo '<a href="' . $doc_bell_url . '" id="bell"><i class="fa fa-bell"></i></a>';
		}
		if ( $doc_bell_js ) {
			echo '<a id="bell"><i class="fa fa-bell"></i><div>' . $doc_bell_js . '</div></a>';
		}
		if ( $doc_back_totop_open ) {
			echo '<a id="totop"><i class="fa fa-angle-up"></i></a>';
		}

		echo '</div>';
	}
}
add_action( 'wp_footer', 'doc_statistics_fixed_box' );
