<?php

/**
 * 注册自定义帖子
 */
function post_box_label_args( $name, $slugName ) {
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

function post_box_args( $name, $slugName, $public = true, $show_in_nav_menus = true, $show_in_menu = true, $menu_position = null, $capability_type = 'post', $hierarchical = false, $supports = array(), $taxonomies = array(), $has_archive = true ) {
	return $args = array(
		'labels' => post_box_label_args( $name, $slugName ),
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

function add_post_box() {
	register_post_type( 'site-post',
		post_box_args(
			__( '站点', 'doc-text' ), //$name
			'site-post', //$slugName
			true, //$public
			true, //$show_in_nav_menus
			true, //show_in_menu
			null, //$menu_position
			'post', //$capability_type
			false, //$hierarchical
			array( 'title', 'editor', 'thumbnail' ), //$supports
			array( 'site-list' ), //taxonomies
			true //$has_archive
		)
	);
	// 添加register_post_type 2,3,4
}
add_action( 'init', 'add_post_box' );

/**
 * 帖子元框
 */
class post_box_metabox {
	private $postTypes = array(
		'site-post',
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->postTypes as $postType ) {
			add_meta_box(
				'site-post',
				__( '站点', 'doc-text' ),
				array( $this, 'post_box_callback' ),
				$postType,
				'normal',
				'default'
			);
		}
	}
	public function post_box_callback( $post ) {
		wp_nonce_field( 'post_box_data', 'post_box_nonce' );
		?>
<?php $meta_value = get_post_meta( $post->ID, 'site_post_vpn', true ); ?>
<p></p>
<label for="post_box_vpn">
	<input id="post_box_vpn" name="post_box_vpn" type="checkbox" class="box-input" <?php if( $meta_value == 'on' ){ echo 'checked'; } ?> />
	<?php _e('需要VPN', 'doc-text'); ?>
</label>
<p></p>
<textarea id="post_box_excerpt" name="post_box_excerpt" class="box-input" placeholder="<?php _e('网站介绍', 'doc-text'); ?>"><?php echo get_post_meta( $post->ID, 'site_post_excerpt', true ); ?></textarea>
<input id="post_box_url" name="post_box_url" type="url" class="box-input" value="<?php echo get_post_meta( $post->ID, 'site_post_url', true ); ?>" placeholder="<?php _e('网站链接', 'doc-text'); ?>"/>
<?php
}
public function save_fields( $post_id ) {
	if ( !isset( $_POST[ 'post_box_nonce' ] ) )
		return $post_id;
	$nonce = $_POST[ 'post_box_nonce' ];
	if ( !wp_verify_nonce( $nonce, 'post_box_data' ) )
		return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;
	// Update metafields
	if ( isset( $_POST[ 'post_box_vpn' ] ) )
		update_post_meta( $post_id, 'post_box_vpn', $_POST[ 'post_box_vpn' ] );
	else
		update_post_meta( $post_id, 'post_box_vpn', null );
	if ( isset( $_POST[ 'post_box_url' ] ) )
		update_post_meta( $post_id, 'post_box_url', esc_url_raw( $_POST[ 'post_box_url' ] ) );
	if ( isset( $_POST[ 'post_box_excerpt' ] ) )
		update_post_meta( $post_id, 'post_box_excerpt', esc_attr( $_POST[ 'post_box_excerpt' ] ) );
}
public function admin_footer() {
	?>
<style>
	.box-input { width: 100%; padding: 10px; margin-bottom: 15px;} 
	.input-label { margin-bottom: 5px; display: block } 
	.editor-input { margin-bottom: 25px; }
	.delete-item { display: block; margin-bottom: 5px !important; }
	</style>
<?php
}
}
new post_box_metabox;
