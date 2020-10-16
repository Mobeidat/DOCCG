<?php

/* Topic post */
add_action( 'init', 'doc_topic_init' );
/**
 * Register a book post type.
 */
function doc_topic_init() {
	$labels = array(
		'name' => __( 'Topic', 'doc-text' ),
		'singular_name' => __( 'Topic', 'doc-text' ),
		'menu_name' => __( 'Topic', 'doc-text' ),
		'name_admin_bar' => __( 'Topic', 'doc-text' ),
		'add_new' => __( 'Add New topic', 'doc-text' ),
		'add_new_item' => __( 'Add New topic', 'doc-text' ),
		'new_item' => __( 'New topic', 'doc-text' ),
		'edit_item' => __( 'Edit topic', 'doc-text' ),
		'view_item' => __( 'View topic', 'doc-text' ),
		'all_items' => __( 'All topic', 'doc-text' ),
		'search_items' => __( 'Search topic', 'doc-text' ),
		'parent_item_colon' => __( 'Parent topic', 'doc-text' ),
		'not_found' => __( 'No topic found', 'doc-text' ),
		'not_found_in_trash' => __( 'No topic found in Trash', 'doc-text' )
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'topic' ),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'topic', $args );
}


// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'doc_topicox_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function doc_topicox_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name' => __( 'Category', 'doc-text' ),
		'singular_name' => __( 'Category', 'doc-text' ),
		'search_items' => __( 'Search category', 'doc-text' ),
		'all_items' => __( 'All category', 'doc-text' ),
		'parent_item' => __( 'Parent category', 'doc-text' ),
		'parent_item_colon' => __( 'Parent category', 'doc-text' ),
		'edit_item' => __( 'Edit category', 'doc-text' ),
		'update_item' => __( 'Update category', 'doc-text' ),
		'add_new_item' => __( 'Add New category', 'doc-text' ),
		'new_item_name' => __( 'New category Name', 'doc-text' ),
		'menu_name' => __( 'Category', 'doc-text' ),
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'topicox' ),
	);

	register_taxonomy( 'topicox', array( 'topic' ), $args );

}