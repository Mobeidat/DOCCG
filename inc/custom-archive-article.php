<?php

/**
 * Register a book post type.
 */
function cutom_post_type_label_args( $name, $slugName ) {
	return $labels = array(
		'name' => $name,
		'singular_name' => $slugName,
		'add_new' => __( 'Add', 'doc-text' ),
		'add_new_item' => __( 'Add ', 'doc-text' ) . $name,
		'edit_item' => __( 'Edit', 'doc-text' ),
		'new_item' => __( 'News', 'doc-text' ),
		'all_items' => __( 'All ', 'doc-text' ) . $name,
		'view_item' => __( 'view ', 'doc-text' ) . $name,
		'search_items' => __( 'Search ', 'doc-text' ) . $name,
		'not_found' => __( 'Not found ', 'doc-text' ) . $name,
		'not_found_in_trash' => __( 'Not found in trash ', 'doc-text' ) . $name,
		'parent_item_colon' => '',
		'menu_name' => $name,
	);
}

// register post type args 
function custom_post_type_args( $name, $slugName, $postType = 'post', $public = true, $queryable = true, $show_ui = true, $show_menu = true, $query_var = true, $has_archive = true, $hierarchical = false, $menu_position = null, $supports = array(), $menu_icon = null ) {
	return $args = array(
		'labels' => cutom_post_type_label_args( $name, $slugName ),
		'public' => $public,
		'publicly_queryable' => $queryable,
		'show_ui' => $show_ui,
		'show_in_menu' => $show_menu,
		'query_var' => $query_var,
		'rewrite' => array( 'slug' => strtolower( $slugName ) ),
		'capability_type' => $postType,
		'has_archive' => $has_archive,
		'hierarchical' => $hierarchical,
		'menu_position' => $menu_position,
		'supports' => $supports,
		'menu_icon' => $menu_icon,
	);
}

function add_custom_post_type() {
	register_post_type( 'site',
		custom_post_type_args(
			__( 'Nice site', 'doc-text' ), //$name
			'site', //$slugName
			'post', //$postType
			false, //$public
			false, //$queryable
			true, //$show_ui
			true, //$show_menu
			true, //$query_var
			false, //$has_archive
			false, //$hierarchical
			8, //$menu_position
			array( 'title', 'thumbnail' ), //$supports
			'dashicons-images-alt2' //$menu_icon
		)
	);
}
add_action( 'init', 'add_custom_post_type' );

/**
 * Nice site metabox
 */
class nice_site {
	private $postTypes = array(
		'site',
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->postTypes as $postType ) {
			add_meta_box(
				'site',
				__( 'Nice site', 'doc-text' ),
				array( $this, 'site_callback' ),
				$postType,
				'normal',
				'default'
			);
		}
	}
	public function site_callback( $post ) {
		wp_nonce_field( 'nice_site_data', 'nice_site_nonce' );
		?>
<?php $meta_value = get_post_meta( $post->ID, 'site_vpn', true ); ?>
<textarea id="site_excerpt" name="site_excerpt" class="box-input" placeholder="<?php _e('Website Introduction', 'doc-text'); ?>"><?php echo get_post_meta( $post->ID, 'site_excerpt', true ); ?></textarea>
<p></p>
<input id="site_url" name="site_url" type="url" class="box-input" value="<?php echo get_post_meta( $post->ID, 'site_url', true ); ?>" placeholder="<?php _e('Site url', 'doc-text'); ?>"/>
<p></p>
<label for="site_vpn">
	<input id="site_vpn" name="site_vpn" type="checkbox" class="box-input" <?php if( $meta_value == 'on' ){ echo 'checked'; } ?> />
	<?php _e('Need VPN', 'doc-text'); ?>
</label>
<?php
}
public function save_fields( $post_id ) {
	if ( !isset( $_POST[ 'nice_site_nonce' ] ) )
		return $post_id;
	$nonce = $_POST[ 'nice_site_nonce' ];
	if ( !wp_verify_nonce( $nonce, 'nice_site_data' ) )
		return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;
	// Update metafields
	if ( isset( $_POST[ 'site_vpn' ] ) )
		update_post_meta( $post_id, 'site_vpn', $_POST[ 'site_vpn' ] );
	else
		update_post_meta( $post_id, 'site_vpn', null );
	if ( isset( $_POST[ 'site_url' ] ) )
		update_post_meta( $post_id, 'site_url', esc_url_raw( $_POST[ 'site_url' ] ) );
	if ( isset( $_POST[ 'site_excerpt' ] ) )
		update_post_meta( $post_id, 'site_excerpt', esc_attr( $_POST[ 'site_excerpt' ] ) );
}
public function admin_footer() {
	?>
<style>
            .box-input { width: 100%; padding: 10px; margin-bottom: 15px;} 
            .input-label { margin-bottom: 5px; display: block } 
            .editor-input { margin-bottom: 25px; }
            .delete-item { display: block; margin-bottom: 5px !important; }
            ::-webkit-input-placeholder { font-style: italic; }
            ::-moz-placeholder { font-style: italic; }
            :-ms-input-placeholder { font-style: italic; }
            :-moz-placeholder { font-style: italic; }
            </style>
<?php
}
}
new nice_site;


/*
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

}*/
