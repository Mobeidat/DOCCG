<?php

// Hide the black bar at the top of WordPress to remove the administrator login toolbar
add_filter( 'show_admin_bar', '__return_false' );

// Delete the Class selector
function doc_css_attributes_filter( $var ) {
	return is_array( $var ) ? array_intersect( $var, array( 'current-menu-item', 'current-post-ancestor', 'current-menu-ancestor' ) ) : '';
}
add_filter( 'nav_menu_css_class', 'doc_css_attributes_filter', 100, 1 );
add_filter( 'nav_menu_item_id', 'doc_css_attributes_filter', 100, 1 );
add_filter( 'page_css_class', 'doc_css_attributes_filter', 100, 1 );

/**
 * Website keyword description.
 *
 * SEO keywords and simple description of the website.
 *
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
 * Website custom logo.
 *
 * Set the display in "Site Settings"> "Customize".
 *
 */
if ( !function_exists( 'doc_custom_logo' ) ) {
	function doc_custom_logo() {

		echo '<h1 itemscope itemtype="http://schema.org/Organization" class="site-title">';

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );

		echo '<a itemprop="url" rel="home" class="custom-logo-text" href="' . esc_url( home_url( '/' ) ) . '">';
		if ( has_custom_logo() ) {
			echo '<img itemprop="logo" src="' . esc_url( $logo[ 0 ] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		};

		echo bloginfo( 'name' );

		echo '</a><span>2020</span></h1>';

	}
}

/**
 * Website custom logo.
 *
 * Set the display in "Site Settings"> "Customize".
 *
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
			echo ' <a itemprop="name" href="' . $homeLink . '">' . __( 'Home', 'doc-text' ) . '</a> ' . $delimiter;
			// Category
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
			}
			// Day
			elseif ( is_day() ) {
					echo '<a itemprop="breadcrumb" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
					echo '<a itemprop="breadcrumb"  href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
					echo $before . get_the_time( 'd' ) . $after;
				}
				// Month
			elseif ( is_month() ) {
					echo '<a itemprop="breadcrumb" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
					echo $before . get_the_time( 'F' ) . $after;
				}
				// Year
			elseif ( is_year() ) {
					echo $before . get_the_time( 'Y' ) . $after;
				}
				// Article
			elseif ( is_single() && !is_attachment() ) {
				// Custom article
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
				// Attachment
			elseif ( is_attachment() ) {
					$parent = get_post( $post->post_parent );
					$cat = get_the_category( $parent->ID );
					$cat = $cat[ 0 ];
					echo '<a itemprop="breadcrumb" href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
					echo $before . get_the_title() . $after;
				}
				// Page	
			elseif ( is_page() && !$post->post_parent ) {
					echo $before . get_the_title() . $after;
				}
				// Parent page
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
				// Search
			elseif ( is_search() ) {
					echo $before;
					printf( __( 'Search Results for: %s', 'doc-text' ), get_search_query() );
					echo $after;
				}
				// Tag
			elseif ( is_tag() ) {
					echo $before;
					printf( __( 'Tag Archives: %s', 'doc-text' ), single_tag_title( '', false ) );
					echo $after;
				}
				// Author
			elseif ( is_author() ) {
					global $author;
					$userdata = get_userdata( $author );
					echo $before;
					printf( __( 'Author Archives: %s', 'doc-text' ), $userdata->display_name );
					echo $after;
				}
				// 404
			elseif ( is_404() ) {
					echo $before;
					_e( 'Not Found', 'doc-text' );
					echo $after;
				}
				// paged
			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo sprintf( __( '( Page %s )', 'doc-text' ), get_query_var( 'paged' ) );
			}
			echo '</div></section>';
		}
	}
}
/**
 * Global information at the top of the site.
 *
 * Custom display category, label, search, date page.
 *
 */
if ( !function_exists( 'doc_sort_box' ) ) {
	function doc_sort_box() {

		$h2_before = '<h2 itemprop="category">';
		$h2_after = '</h2>';
		$p_before = '<p>';
		$p_after = '</p>';

		echo '<section class="sort-box max-width" itemscope itemtype="https://schema.org/Text">';
		// Search
		if ( is_search() ) {
			get_search_form();
			if ( have_posts() ) {
				global $wp_query;
				echo $p_before . sprintf( esc_html__( '<span>" %s "</span>found articles, there are<span>" %s "</span>articles in total.', 'doc-text' ), get_search_query(), $wp_query->found_posts ) . $p_after;
			} else {
				echo $p_before . sprintf( esc_html__( 'No<span>" %s "</span>related articles were found, please fill in the keywords again and search again!', 'doc-text' ), get_search_query() ) . $p_after;
			};
		}
		// Tag Archive
		elseif ( is_tag() ) {
				echo $h2_before . '" ';
				single_tag_title();
				echo ' "' . $h2_after;
			}
			// Date archive
		elseif ( is_date() ) {
				echo $h2_before . esc_html( get_the_date() ) . $h2_after;
			}
			// Default archive
		else {
			echo $h2_before;
			single_cat_title();
			echo $h2_after;
			echo category_description();
		}

		echo '</section>';

	}
}

/*
 * Copyright, record number, and theme copyright on the bottom left
 */
if ( !function_exists( 'doc_copyright_menu' ) ) {
	function doc_copyright_menu() {
		echo '<section class="copyright">';

		echo '<p>';
		// Copyright date
		doc_copyright_date();

		// Web title
		bloginfo( 'name' );

		// Powered by
		echo ' | Powered by <a href="https://cn.wordpress.org/" target="_blank">Wordpress</a>';

		// Theme by
		echo ' | Theme by <a href="https://www.wangtingbiao.com" target="_blank" itemprop="copyrightHolder">TingBiao Wang</a>';

		// Record
		$doc_record = get_theme_mod( 'doc_record' );
		if ( $doc_record ) {
			echo ' | <a href="http://www.beian.miit.gov.cn/" class="mrw-record" target="_blank">' . $doc_record . '</a>';
		}
		echo '</p>';

		// Bottom menu
		wp_nav_menu( array(
			'theme_location' => 'bottomnav',
			'container' => 'div',
			'depth' => 1,
			'fallback_cb' => 0,
		) );

		echo '</section>';
	}
}

// Site statistics and totop
if ( !function_exists( 'doc_statistics_fixed_box' ) ) {
	function doc_statistics_fixed_box() {

		echo '<div id="fixed-box">';

		echo get_theme_mod( 'doc_statistics' );

		$doc_back_totop_bell = get_theme_mod( 'doc_back_totop_bell', 'true' );
		$doc_back_totop_open = get_theme_mod( 'doc_back_totop_open', 'true' );
		if ( $doc_back_totop_bell ) {
			echo '<a href="#" id="bell"><i class="fa fa-bell"></i></a>';
		}
		if ( $doc_back_totop_open ) {
			echo '<a href="#" id="totop"><i class="fa fa-angle-up"></i></a>';
		}

		echo '</div>';

	}
}
add_action( 'wp_footer', 'doc_statistics_fixed_box' );

// Auto copyright date
if ( !function_exists( 'doc_copyright_date' ) ) {
	function doc_copyright_date() {
		global $wpdb;
		$copyright_dates = $wpdb->get_results( " SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
		if ( $copyright_dates ) {
			echo '<span itemprop="copyrightYear">';
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
