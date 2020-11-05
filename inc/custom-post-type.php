<?php

/**
 * Register multiple custom article types
 */
function custom_post_type_label_args( $name, $slugName ) {
	return $labels = array(
		'name' => $name,
		'singular_name' => $slugName,
		'add_new' => __( '添加', 'doc-text' ),
		'all_items' => __( '所有', 'doc-text' ) . $name,
		'add_new_item' => __( '添加新', 'doc-text' ) . $name,
		'edit_item' => __( '编辑', 'doc-text' ) . $name,
		'new_item' => __( '新', 'doc-text' ) . $name,
		'view_item' => __( '查看', 'doc-text' ) . $name,
		'search_items' => __( '搜索', 'doc-text' ) . $name,
		'not_found' => __( '未找到', 'doc-text' ) . $name,
		'not_found_in_trash' => __( '回收站未找到', 'doc-text' ) . $name,
		'parent_item_colon' => '',
		'menu_name' => $name,
	);
}

function custom_post_type_args( $name, $slugName, $public = true, $show_in_nav_menus = true, $show_in_menu = true, $menu_position = null, $capability_type = 'post', $hierarchical = false, $supports = array(), $taxonomies = array(), $has_archive = true ) {
	return $args = array(
		'labels' => custom_post_type_label_args( $name, $slugName ),
		'public' => $public,
		'show_in_nav_menus' => $show_in_nav_menus,
		'show_in_menu' => $show_in_menu,
		'menu_position' => $menu_position,
		'capability_type' => $capability_type,
		'hierarchical' => $hierarchical,
		'supports' => $supports,
		'taxonomies' => $taxonomies,
		'has_archive' => $has_archive,
		'rewrite' => array( 'slug' => strtolower( $slugName ) )
	);
}

function add_custom_post_type() {
	register_post_type( 'web',
		custom_post_type_args(
			__( '站点', 'doc-text' ), //$name
			'web', //$slugName
			true, //$public
			true, //$show_in_nav_menus
			true, //show_in_menu
			null, //$menu_position
			'post', //$capability_type
			false, //$hierarchical
			array( 'title', 'editor', 'thumbnail' ), //$supports
			array( 'webs' ), //taxonomies
			true //$has_archive
		)
	);
	// 添加register_post_type 2,3,4
}
add_action( 'init', 'add_custom_post_type' );

/**
 * Nice web metabox
 */
class nice_web {
	private $postTypes = array(
		'web',
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->postTypes as $postType ) {
			add_meta_box(
				'web',
				__( '站点', 'doc-text' ),
				array( $this, 'web_callback' ),
				$postType,
				'normal',
				'default'
			);
		}
	}
	public function web_callback( $post ) {
		wp_nonce_field( 'nice_web_data', 'nice_web_nonce' );
		?>
<?php $meta_value = get_post_meta( $post->ID, 'web_vpn', true ); ?>
<p></p>
<label for="web_vpn">
	<input id="web_vpn" name="web_vpn" type="checkbox" class="box-input" <?php if( $meta_value == 'on' ){ echo 'checked'; } ?> />
	<?php _e('需要VPN', 'doc-text'); ?>
</label>
<p></p>
<textarea id="web_excerpt" name="web_excerpt" class="box-input" placeholder="<?php _e('网站介绍', 'doc-text'); ?>"><?php echo get_post_meta( $post->ID, 'web_excerpt', true ); ?></textarea>
<input id="web_url" name="web_url" type="url" class="box-input" value="<?php echo get_post_meta( $post->ID, 'web_url', true ); ?>" placeholder="<?php _e('网站链接', 'doc-text'); ?>"/>
<?php
}
public function save_fields( $post_id ) {
	if ( !isset( $_POST[ 'nice_web_nonce' ] ) )
		return $post_id;
	$nonce = $_POST[ 'nice_web_nonce' ];
	if ( !wp_verify_nonce( $nonce, 'nice_web_data' ) )
		return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;
	// Update metafields
	if ( isset( $_POST[ 'web_vpn' ] ) )
		update_post_meta( $post_id, 'web_vpn', $_POST[ 'web_vpn' ] );
	else
		update_post_meta( $post_id, 'web_vpn', null );
	if ( isset( $_POST[ 'web_url' ] ) )
		update_post_meta( $post_id, 'web_url', esc_url_raw( $_POST[ 'web_url' ] ) );
	if ( isset( $_POST[ 'web_excerpt' ] ) )
		update_post_meta( $post_id, 'web_excerpt', esc_attr( $_POST[ 'web_excerpt' ] ) );
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
new nice_web;
