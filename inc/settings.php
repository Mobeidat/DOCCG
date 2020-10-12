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

		echo '<h1 class="site-title">';
		if ( has_custom_logo() ) {
			the_custom_logo();
		};
		echo '<a class="custom-logo-text" href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a><span>2020</span>';
		echo '</h1>';

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

		$h2_before = '<h2>';
		$h2_after = '</h2>';
		$p_before = '<p>';
		$p_after = '</p>';

		echo '<section class="sort-box max-width">';
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

/* Web bottom setting */
if ( !function_exists( 'doc_copyright_menu' ) ) {
	function doc_copyright_menu() {
		echo '<section class="copyright">';

		/*
		 * Copyright, record number, and theme copyright on the bottom left
		 */
		echo '<p>';
		// Copyright date
		doc_copyright_date();

		// Web title
		bloginfo( 'name' );

		// Powered by
		echo ' | Powered by <a href="https://cn.wordpress.org/" target="_blank">Wordpress</a>';

		// Theme by
		echo ' | Theme by <a href="https://www.wangtingbiao.com" target="_blank">TingBiao Wang</a>';

		// Record
		$doc_record = get_theme_mod( 'doc_record' );
		if ( $doc_record ) {
			echo ' | <a href="http://www.beian.miit.gov.cn/" class="mrw-record" target="_blank">' . $doc_record . '</a>';
		}
		echo '</p>';

		/* Bottom menu */
		wp_nav_menu( array(
			'theme_location' => 'bottomnav',
			'container' => 'div',
			'depth' => 1,
			'fallback_cb' => 0,
		) );

		echo '</section>';
	}
}

/* Site statistics and totop */
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

/* Auto copyright date */
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
