<?php
/**
 * Article related code.
 *
 * Category selection template
 * The first picture in the article is a thumbnail
 * The category loop of the post
 * Article content directory
 * Article page metadata
 * Statistic estimated reading time
 * Number of articles read
 * Add custom post content
 * Add alt and title attributes to the img tag of the post picture
 * Post page custom comment submission/list function
 *
 *
 * @package TingBiao Wang
 */

/**
 * Category selection template
 */
class Select_Category_Template {
	public function __construct() {
		add_filter( 'category_template', array( $this, 'get_custom_category_template' ) );
		add_action( 'edit_category_form_fields', array( $this, 'category_template_meta_box' ) );
		add_action( 'category_add_form_fields', array( & $this, 'category_template_meta_box' ) );
		add_action( 'created_category', array( & $this, 'save_category_template' ) );
		add_action( 'edited_category', array( $this, 'save_category_template' ) );
		do_action( 'Custom_Category_Template_constructor', $this );
	}
	public function category_template_meta_box( $tag ) {
		$t_id = $tag->term_id;
		$cat_meta = get_option( "category_templates" );
		$template = isset( $cat_meta[ $t_id ] ) ? $cat_meta[ $t_id ] : false;
		?>
<tr class="form-field">
	<th scope="row" valign="top"><label for="term-template">
			<?php _e('Category Template','doc-text'); ?>
		</label></th>
	<td><select name="select" id="term-template">
			<option value='default'>
			<?php _e('Default Template','doc-text'); ?>
			</option>
			<?php page_template_dropdown($template); ?>
		</select>
		<p></p></td>
</tr>
<?php
do_action( 'Custom_Category_Template_ADD_FIELDS', $tag );
}
public function save_category_template( $term_id ) {
	if ( isset( $_POST[ 'cat_template' ] ) ) {
		$cat_meta = get_option( "category_templates" );
		$cat_meta[ $term_id ] = $_POST[ 'cat_template' ];
		update_option( "category_templates", $cat_meta );
		do_action( 'Custom_Category_Template_SAVE_FIELDS', $term_id );
	}
}

function get_custom_category_template( $category_template ) {
	$cat_ID = absint( get_query_var( 'cat' ) );
	$cat_meta = get_option( 'category_templates' );
	if ( isset( $cat_meta[ $cat_ID ] ) && $cat_meta[ $cat_ID ] != 'default' ) {
		$temp = locate_template( $cat_meta[ $cat_ID ] );
		if ( !empty( $temp ) )
			return apply_filters( "Custom_Category_Template_found", $temp );
	}
	return $category_template;
}
}

$cat_template = new Select_Category_Template();

/**
 * The first picture in the article is a thumbnail
 */
function doc_first_thumbnail() {
	global $post;
	$already_has_thumb = has_post_thumbnail( $post->ID );
	if ( !$already_has_thumb ) {
		$attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
		if ( $attached_image ) {
			foreach ( $attached_image as $attachment_id => $attachment ) {
				set_post_thumbnail( $post->ID, $attachment_id );
			}
		}
	}
}
add_action( 'the_post', 'doc_first_thumbnail' );
add_action( 'save_post', 'doc_first_thumbnail' );
add_action( 'draft_to_publish', 'doc_first_thumbnail' );
add_action( 'new_to_publish', 'doc_first_thumbnail' );
add_action( 'pending_to_publish', 'doc_first_thumbnail' );
add_action( 'future_to_publish', 'doc_first_thumbnail' );

/**
 * The category loop of the post
 */
if ( !function_exists( 'doc_get_category' ) ) {
	function doc_get_category() {
		foreach ( ( get_the_category() ) as $category ) {
			echo '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>';
		}
	}
}

/**
 * Article content directory
 */
function doc_single_menu( $content ) {
	if ( !is_singular() ) {
		return $content;
	}
	$index = '';
	$ol = '';
	$arr = array();
	$pattern = '/<h([2-6]).*?\>(.*?)<\/h[2-6]>/is';
	if ( preg_match_all( $pattern, $content, $arr ) ): $count = count( $arr[ 0 ] );
	foreach ( $arr[ 1 ] as $k => $v ) {
		if ( $k <= 0 ) {
			$index = '<ol>';
		} else {
			if ( $v > $arr[ 1 ][ $k - 1 ] ) {
				if ( $v - $arr[ 1 ][ $k - 1 ] == 1 ) {
					$index .= '<ol>';
				} elseif ( $v == $arr[ 1 ][ $k - 1 ] ) {

				}
				else {
					$index .= __( 'Directory is illegal', 'doc-text' );
					return false;
				}
			}
		}

		$title = strip_tags( $arr[ 2 ][ $k ] );
		$content = str_replace( $arr[ 0 ][ $k ], '<h' . $v . ' id="index-' . $k . '">' . $title . '</h' . $v . '>', $content );
		$index .= '<li class="h' . $v . '"><a rel="contents chapter" href="#index-' . $k . '">' . $title . '</a></li>';
		if ( $k < $count - 1 ) {
			if ( $v > $arr[ 1 ][ $k + 1 ] ) {
				$c = $v - $arr[ 1 ][ $k + 1 ];
				for ( $i = 0; $i < $c; $i++ ) {
					$ol .= '</ol>';
					$index .= $ol;
					$ol = '';
				}
			}
		} else {
			$index .= '</ol>';
		}
	}
	$index = '<div id="single-float" class="single-float"><div class="single-toggle"><a id="single-toggle"><i class="fa fa-bars"></i></a></div><nav class="single-menu" role="navigation">' . $index . '</nav></div>';
	$content = $index . $content;
	endif;
	return $content;
}
add_filter( "the_content", "doc_single_menu" );

/**
 * Article page metadata
 */
if ( !function_exists( 'doc_get_single_meta' ) ) {
	function doc_get_single_meta() {
		echo '<div class="single-meta">';
		echo '<time class="single-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished"><i class="fa fa-calendar-o"></i>' . get_the_time( 'Y-m-d' ) . '</time>';
		echo '<span class="single-read"><i class="fa fa-calendar-o"></i>';
		echo doc_get_reading_time( $content );
		echo '</span>';
		echo '<a class="comment-toggle single-comment" itemprop="comment""><i class="fa fa-comment"></i>' . get_comments_number() . '</a>';
		edit_post_link( __( 'Edit', 'doctext' ) );
		echo '</div>';
	}
}

/**
 * Statistic estimated reading time
 */
if ( !function_exists( 'doc_get_reading_time' ) ) {
	function doc_get_reading_time( $content ) {
		$doc_format = __( '%min%min%sec%seconds reading', 'doc-text' );
		$doc_chars_per_minute = 300;
		$doc_format = str_replace( '%num%', $doc_chars_per_minute, $doc_format );
		$words = mb_strlen( preg_replace( '/\s/', '', html_entity_decode( strip_tags( $content ) ) ), 'UTF-8' );
		$minutes = floor( $words / $doc_chars_per_minute );
		$seconds = floor( $words % $doc_chars_per_minute / ( $doc_chars_per_minute / 60 ) );
		return str_replace( '%sec%', $seconds, str_replace( '%min%', $minutes, $doc_format ) );
	}
}

/**
 * Number of articles read
 */
function doc_get_post_views( $post_id ) {
	$count_key = 'views';
	$count = get_post_meta( $post_id, $count_key, true );
	if ( $count == '' ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		$count = '0';
	}
	echo number_format_i18n( $count );
}

function doc_set_post_views() {
	global $post;
	$post_id = $post->ID;
	$count_key = 'views';
	$count = get_post_meta( $post_id, $count_key, true );
	if ( is_single() || is_page() ) {
		if ( $count == '' ) {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
		} else {
			update_post_meta( $post_id, $count_key, $count + 1 );
		}

	}
}
add_action( 'get_header', 'doc_set_post_views' );

/**
 * Add custom post content
 */
if ( !function_exists( 'doc_post_content_copytight' ) ) {
	function doc_post_content_copytight( $content ) {
		if ( is_singular( 'post' ) ) {
			$doc_sin_copytight_open = get_theme_mod( 'doc_sin_copytight_open', 'ture' );
			$doc_sin_copytight = get_theme_mod( 'doc_sin_copytight', __( 'This article is collected from the Internet, and the copyright belongs to the original author or organization. If this page violates your rights, please contact us via email hi@doccg.com!', 'doc-text' ) );
			if ( $doc_sin_copytight_open ) {
				$content .= '<p class="wp-block-copytight single-copytight" itemscope itemtype="http://schema.org/Organization" itemprop="copyrightHolder"><i class="fa fa-flag"></i><span>' . $doc_sin_copytight . '</span></p>';
			}
		}
		return $content;
	}
}
add_filter( 'the_content', 'doc_post_content_copytight' );

/**
 * Add alt and title attributes to the img tag of the post picture
 */
if ( !function_exists( 'doc_post_img_gesalt' ) ) {
	function doc_post_img_gesalt( $content ) {
		global $post;
		$pattern = "/<img(.*?)src=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
		$replacement = '<img$1src=$2$3.$4$5 alt="' . $post->post_title . '" title="' . $post->post_title . '"$6>';
		$content = preg_replace( $pattern, $replacement, $content );
		return $content;
	}
}
add_filter( 'the_content', 'doc_post_img_gesalt' );

/* -------------------------------------------------------------------------- */
/*	Post page custom comment submission/list function
/* -------------------------------------------------------------------------- */

/**
 * Whether the comment list user is the author of the current article
 */
if ( !function_exists( 'doc_comment_by_post_user' ) ) {
	function doc_comment_by_post_user( $comment = null ) {
		if ( is_object( $comment ) && $comment->user_id > 0 ) {
			$user = get_userdata( $comment->user_id );
			$post = get_post( $comment->comment_post_ID );
			if ( !empty( $user ) && !empty( $post ) ) {
				return $comment->user_id === $post->post_author;
			}
		}
		return false;
	}
}

/**
 * Spam & Delete links for all versions of wordpress
 */
if ( !function_exists( 'doc_delete_comment_link' ) ) {
	function doc_delete_comment_link( $id ) {
		if ( current_user_can( 'edit_post' ) ) {
			echo '&nbsp;<a href="' . admin_url( 'comment.php?action=cdc&c=' ) . $id . '">' . __( 'Delete', 'doc-text' ) . '</a>';
			echo '&nbsp;<a href="' . admin_url( 'comment.php?action=cdc&dt=spam&c=' ) . $id . '">' . __( 'Rubbish', 'doc-text' ) . '</a>';
		}
	}
}

/**
 * Reply to comments automatically add @reviewers
 */
function doc_comment_add_at( $comment_text, $comment = '' ) {
	if ( $comment->comment_parent > 0 ) {
		$comment_text = '<em>@' . get_comment_author( $comment->comment_parent ) . '</em> ' . $comment_text;
	}
	return $comment_text;
}
add_filter( 'comment_text', 'doc_comment_add_at', 20, 2 );

/**
 * Custom comment list
 */
function doc_theme_comments( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	<div class="comment-wrap">
		<div class="comment-admin">
			<figure class="comment-img"><?php echo get_avatar($comment,$args['avatar_size'],null,null,array('class' => array('img-responsive', 'img-circle') )); ?></figure>
			<span class="comment-author"><?php echo get_comment_author_link(); ?></span>
			<?php
			$post_author = doc_comment_by_post_user( $comment );
			if ( $post_author ):
				echo '<span class="comment-post-user">' . __( 'Author', 'doc-text' ) . '</span>';
			endif;
			?>
		</div>
		<div class="comment-body">
			<?php
			comment_text();
			if ( $comment->comment_approved == '0' ):
				echo '<i>' . __( 'Comments waiting for approval!', 'doc-text' ) . '</i>';
			endif;
			?>
			<div class="comment-meta">
				<p class="left">
					<?php
					echo '<span>' . get_comment_date( 'Y-m-d A G:i:s' ) . '</span>';
					doc_delete_comment_link( get_comment_ID() );
					?>
				</p>
				<p class="comment-reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ), $comment->comment_ID ); ?>
				</p>
			</div>
		</div>
	</div>
	<?php
	}
