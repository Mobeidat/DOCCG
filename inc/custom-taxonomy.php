<?php

/**
 * Register multiple custom categories
 */
function custom_taxonomy_label_args( $name, $slugName ) {
	return $labels = array(
		'name' => $name,
		'singular_name' => $slugName,
		'search_items' => __( '搜索', 'doc-text' ) . $name,
		'all_items' => __( '所有', 'doc-text' ) . $name,
		'parent_item' => __( '父类别', 'doc-text' ) . $name,
		'parent_item_colon' => __( '父类别', 'doc-text' ) . $name,
		'edit_item' => __( '编辑', 'doc-text' ) . $name,
		'update_item' => __( '更新', 'doc-text' ) . $name,
		'add_new_item' => __( '添加', 'doc-text' ) . $name,
		'new_item_name' => __( '新', 'doc-text' ) . $name,
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
	register_taxonomy( 'webs', array( 'web' ),
		custom_taxonomy_args(
			__( '类别', 'doc-text' ), //$name
			'webs', //$slugName
			true, //$hierarchical
			true, //$show_ui
			true, //show_admin_column
			true //$query_var
		)
	);
	// add register_taxonomy 2,3,4
}
add_action( 'init', 'add_custom_taxonomy' );