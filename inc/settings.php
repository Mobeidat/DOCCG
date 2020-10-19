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
if ( !function_exists( 'doc_get_custom_logo' ) ) {
	function doc_get_custom_logo() {

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		$custom_logo_text_open = get_theme_mod( 'custom_logo_text_open', 'true' );
		$custom_logo_text_span_open = get_theme_mod( 'custom_logo_text_span_open', 'true' );
		$custom_logo_text_span = get_theme_mod( 'custom_logo_text_span', '2020' );

		echo '<h1 itemscope itemtype="http://schema.org/Organization" class="site-title"><a itemprop="url" rel="home" class="custom-logo-text" href="' . esc_url( home_url( '/' ) ) . '">';
		if ( has_custom_logo() ) {
			echo '<img itemprop="logo" src="' . esc_url( $logo[ 0 ] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		}
		if ( $custom_logo_text_open ) {
			echo bloginfo( 'name' );
		}
		echo '</a>';
		if ( $custom_logo_text_span_open ) {
			echo '<span class="site-title-span">' . $custom_logo_text_span . '</span>';
		}
		echo '</h1>';
	}
}

/**
 * Custom breadcrumb navigation
 */
if ( !function_exists( 'doc_get_breadcrumbs' ) ) {
	function doc_get_breadcrumbs() {

		$delimiter = '<span>&nbsp;&raquo;&nbsp;</span>';
		$before = '<span class="current">';
		$after = '</span>';

		if ( !is_home() && !is_front_page() || is_paged() ) {
			echo '<section class="breadcrumbs" itemscope itemtype="https://schema.org/WebPage"><div class="max-width">';
			global $post;
			$homeLink = home_url();
			echo ' <a itemprop="name" href="' . $homeLink . '">' . __( 'Home', 'doc-text' ) . '</a> ' . $delimiter;
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
				printf( __( 'Search Results for: %s', 'doc-text' ), get_search_query() );
				echo $after;
			}
			elseif ( is_tag() ) {
				echo $before;
				printf( __( 'Tag Archives: %s', 'doc-text' ), single_tag_title( '', false ) );
				echo $after;
			}
			elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before;
				printf( __( 'Author Archives: %s', 'doc-text' ), $userdata->display_name );
				echo $after;
			}
			elseif ( is_404() ) {
				echo $before;
				_e( 'Not Found', 'doc-text' );
				echo $after;
			}
			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo sprintf( __( '( Page %s )', 'doc-text' ), get_query_var( 'paged' ) );
			}
			echo '</div></section>';
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
				echo $p_before . sprintf( __( '<span>" %1$s "</span>found articles, there are<span>" %2$s "</span>articles in total.', 'doc-text' ), get_search_query(), $wp_query->found_posts ) . $p_after;
			} else {
				echo $p_before . sprintf( __( 'No<span>" %s "</span>related articles were found, please fill in the keywords again and search again!', 'doc-text' ), get_search_query() ) . $p_after;
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
		$doc_socialization_open = get_theme_mod( 'doc_socialization_open', 'true' );
		$doc_socialization_title = get_theme_mod( 'doc_socialization_title', __( 'Follow us', 'doc-text' ) );

		$doc_link_behance = get_theme_mod( 'doc_link_behance' );

		$doc_qrcode_open = get_theme_mod( 'doc_qrcode_open', 'true' );
		$doc_qrcode_title = get_theme_mod( 'doc_qrcode_title', __( 'Scan it', 'doc-text' ) );
		$doc_qrcode_img = get_theme_mod( 'doc_qrcode_img' );
		$doc_qrcode_img_2 = get_theme_mod( 'doc_qrcode_img_2' );
		$doc_qrcode_img_3 = get_theme_mod( 'doc_qrcode_img_3' );
		if ( $doc_socialization_open ) {

			echo '<div class="site-bottom-list bottom-link" itemprop="about"><h3 class="site-bottom-title">' . $doc_socialization_title . '</h3>';

			if ( $doc_link_behance ) {
				echo '<p class="link-icon">';

				if ( $doc_link_behance ) {
					echo '<a href="' . $doc_link_behance . '"><i class="fa fa-behance"></i></a>';
				}

				echo '</p>';
			}

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
		echo ' | ' . __( 'Powered by', 'doc-text' ) . ' </span><a href="https://cn.wordpress.org/" target="_blank">Wordpress</a><span> | ' . __( 'Theme by', 'doc-text' ) . ' </span><a href="https://www.wangtingbiao.com" target="_blank" itemprop="copyrightHolder">TingBiao Wang</a>';
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
		$doc_back_totop_open = get_theme_mod( 'doc_back_totop_open', 'true' );
		if ( $doc_bell_url ) {
			echo '<a href="' . $doc_bell_url . '" id="bell"><i class="fa fa-bell"></i></a>';
		} elseif ( $doc_bell_js ) {
			echo '<a id="bell"><i class="fa fa-bell"></i><div>' . $doc_bell_js . '</div></a>';
		}
		if ( $doc_back_totop_open ) {
			echo '<a id="totop"><i class="fa fa-angle-up"></i></a>';
		}

		echo '</div>';
	}
}
add_action( 'wp_footer', 'doc_statistics_fixed_box' );
