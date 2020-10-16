<?php

/**
 * The first picture in the article is a thumbnail
 */
function doc_featured_image() {
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
add_action( 'the_post', 'doc_featured_image' );
add_action( 'save_post', 'doc_featured_image' );
add_action( 'draft_to_publish', 'doc_featured_image' );
add_action( 'new_to_publish', 'doc_featured_image' );
add_action( 'pending_to_publish', 'doc_featured_image' );
add_action( 'future_to_publish', 'doc_featured_image' );

/**
 * The category loop of the post
 */
if ( !function_exists( 'doc_category_foreach' ) ) {
	function doc_category_foreach() {
		foreach ( ( get_the_category() ) as $category ) {
			echo '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>';
		}
	}
}

/**
 * Statistic estimated reading time
 */
if ( !function_exists( 'doc_get_reading_time' ) ) {
	function doc_get_reading_time( $content ) {
		$doc_format = '%min%分%sec%秒阅读';
		$doc_chars_per_minute = 300; // 估算1分种阅读字数
		$doc_format = str_replace( '%num%', $doc_chars_per_minute, $doc_format );
		$words = mb_strlen( preg_replace( '/\s/', '', html_entity_decode( strip_tags( $content ) ) ), 'UTF-8' );
		$minutes = floor( $words / $doc_chars_per_minute );
		$seconds = floor( $words % $doc_chars_per_minute / ( $doc_chars_per_minute / 60 ) );
		return str_replace( '%sec%', $seconds, str_replace( '%min%', $minutes, $doc_format ) );
	}
}

/**
 * Add custom post content
 */
if ( !function_exists( 'doc_post_content_copytight' ) ) {
	function doc_post_content_copytight( $content ) {
		if ( is_singular( 'post' ) ) {
			$doc_single_copytight_open = get_theme_mod( 'doc_single_copytight_open', 'ture' );
			$doc_single_copytight = get_theme_mod( 'doc_single_copytight', __( 'This article is collected from the Internet, and the copyright belongs to the original author or organization. If this page violates your rights, please contact us via email hi@doccg.com!', 'doc-text' ) );
			if ( $doc_single_copytight_open ) {
				$content .= '<p class="wp-block-copytight single-copytight" itemscope itemtype="http://schema.org/Organization" itemprop="copyrightHolder"><i class="fa fa-flag"></i><span>' . $doc_single_copytight . '</span></p>';
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
