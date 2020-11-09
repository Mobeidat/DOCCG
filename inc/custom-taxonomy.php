<?php

/**
 * 注册自定义类别
 */
function taxonomy_box_label_args( $name, $slugName ) {
	return $labels = array(
		'name' => $name,
		'singular_name' => $slugName,
		'search_items' => __( '搜索', 'doc-text' ) . $name,
		'all_items' => __( '所有', 'doc-text' ) . $name,
		'parent_item' => __( '父级', 'doc-text' ) . $name,
		'parent_item_colon' => __( '父级', 'doc-text' ) . $name,
		'edit_item' => __( '编辑', 'doc-text' ) . $name,
		'update_item' => __( '更新', 'doc-text' ) . $name,
		'add_new_item' => __( '新建', 'doc-text' ) . $name,
		'new_item_name' => __( '新', 'doc-text' ) . $name,
		'menu_name' => $name,
	);
}

function taxonomy_box_args( $name, $slugName, $hierarchical = true, $show_ui = true, $show_admin_column = true, $query_var = true ) {
	return $args = array(
		'labels' => taxonomy_box_label_args( $name, $slugName ),
		'hierarchical' => true,
		'show_ui' => $show_ui,
		'show_admin_column' => $show_admin_column,
		'query_var' => $query_var,
		'rewrite' => array( 'slug' => strtolower( $slugName ) ),
	);
}

function add_taxonomy_box() {
	register_taxonomy( 'site-list', array( 'site-post' ),
		taxonomy_box_args(
			__( '站点目录', 'doc-text' ), //$name
			'站点目录', //$slugName
			true, //$hierarchical
			true, //$show_ui
			true, //show_admin_column
			true //$query_var
		)
	);
	// 添加多个类别 register_taxonomy( '', array( '' ),taxonomy_box_args( '' ));
}
add_action( 'init', 'add_taxonomy_box' );