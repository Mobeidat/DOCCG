<?php

/**
 * Register multiple custom categories
 */
function custom_taxonomy_label_args( $name, $slugName ) {
	return $labels = array(
		'name' => $name,
		'singular_name' => $slugName,
		'search_items' => __( 'Search ', 'doc-text' ) . $name,
		'all_items' => __( 'All ', 'doc-text' ) . $name,
		'parent_item' => __( 'Parent ', 'doc-text' ) . $name,
		'parent_item_colon' => __( 'Parent ', 'doc-text' ) . $name,
		'edit_item' => __( 'Edit ', 'doc-text' ) . $name,
		'update_item' => __( 'Update ', 'doc-text' ) . $name,
		'add_new_item' => __( 'Add ', 'doc-text' ) . $name,
		'new_item_name' => __( 'News ', 'doc-text' ) . $name,
		'menu_name' => $name,
	);
}

function custom_taxonomy_args( $name, $slugName, $hierarchical = true, $show_ui = true, $show_admin_column = true, $query_var = true ) {
	return $args = array(
		'labels' => custom_taxonomy_label_args( $name, $slugName ),
		'hierarchical' => true,
		'show_ui' => $show_ui,
		'show_admin_column' => $show_admin_column,
		'query_var' => $query_var,
		'rewrite' => array( 'slug' => strtolower( $slugName ) ),
	);
}

function add_custom_taxonomy() {
	register_taxonomy( 'sites', array( 'site' ),
		custom_taxonomy_args(
			__( 'Category', 'doc-text' ), //$name
			'sites', //$slugName
			true, //$hierarchical
			true, //$show_ui
			true, //show_admin_column
			true //$query_var
		)
	);
	// add register_taxonomy 2,3,4
}
add_action( 'init', 'add_custom_taxonomy' );