<?php

/**
 * Register multiple custom article types
 */
function custom_post_type_label_args( $name, $slugName ) {
	return $labels = array(
		'name' => $name,
		'singular_name' => $slugName,
		'add_new' => __( '添加', 'doc-text' ),
		'add_new_item' => __( '添加', 'doc-text' ) . $name,
		'edit_item' => __( '编辑', 'doc-text' ) . $name,
		'new_item' => __( '新', 'doc-text' ) . $name,
		'all_items' => __( '所有', 'doc-text' ) . $name,
		'view_item' => __( '查看', 'doc-text' ) . $name,
		'search_items' => __( '搜索', 'doc-text' ) . $name,
		'not_found' => __( '未找到', 'doc-text' ) . $name,
		'not_found_in_trash' => __( '回收站未找到', 'doc-text' ) . $name,
		'parent_item_colon' => '',
		'menu_name' => $name,
	);
}

function custom_post_type_args( $name, $slugName, $postType = 'post', $public = true, $queryable = true, $show_ui = true, $show_menu = true, $query_var = true, $has_archive = true, $hierarchical = false, $menu_position = null, $supports = array(), $menu_icon = null ) {
	return $args = array(
		'labels' => custom_post_type_label_args( $name, $slugName ),
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
		'supports' => $supports
	);
}

function add_custom_post_type() {
	register_post_type( 'site',
		custom_post_type_args(
			__( '站点', 'doc-text' ), //$name
			'site', //$slugName
			'post', //$postType
			true, //$public
			true, //$queryable
			true, //$show_ui
			true, //$show_menu
			true, //$query_var
			true, //$has_archive
			false, //$hierarchical
			null, //$menu_position
			array( 'title', 'thumbnail' ) //$supports
		)
	);
	// 添加register_post_type 2,3,4
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
				__( '站点', 'doc-text' ),
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
<p></p>
<label for="site_vpn">
	<input id="site_vpn" name="site_vpn" type="checkbox" class="box-input" <?php if( $meta_value == 'on' ){ echo 'checked'; } ?> />
	<?php _e('需要VPN', 'doc-text'); ?>
</label>
<p></p>
<textarea id="site_excerpt" name="site_excerpt" class="box-input" placeholder="<?php _e('网站介绍', 'doc-text'); ?>"><?php echo get_post_meta( $post->ID, 'site_excerpt', true ); ?></textarea>
<input id="site_url" name="site_url" type="url" class="box-input" value="<?php echo get_post_meta( $post->ID, 'site_url', true ); ?>" placeholder="<?php _e('网站链接', 'doc-text'); ?>"/>
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
