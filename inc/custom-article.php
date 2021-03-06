<?php
/**
 *
 * 帖子所属分类
 * 帖子浮动锚点
 * 帖子发布时间、阅读大概时间、评论数
 * 帖子内容阅读大概时间
 * 帖子浏览量（刷新+1）主要用于视频模板
 * 帖子内容版权-全局
 * 将alt和title属性添加到帖子图片的img标签中
 * 评论列表用户是否是当前帖子的作者
 * 所有版本的wordpress的垃圾邮件和删除链接
 * 回复评论自动添加@
 * 自定义评论列表
 *
 * @package TingBiao Wang
 */

/**
 * 帖子所属分类
 */
if ( !function_exists( 'doc_get_category' ) ) {
	function doc_get_category() {
		foreach ( ( get_the_category() ) as $category ) {
			echo '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>';
		}
	}
}

/**
 * 帖子浮动锚点
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
					$index .= __( '目录是非法的', 'doc-text' );
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
 * 帖子发布时间、阅读大概时间、评论数
 */
if ( !function_exists( 'doc_get_single_meta' ) ) {
	function doc_get_single_meta() {
		echo '<div class="single-meta">';
		echo '<time class="single-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished"><i class="fa fa-calendar-o"></i>' . get_the_time( 'Y-m-d' ) . '</time>';
		echo '<span class="single-read"><i class="fa fa-calendar-o"></i>';
		echo doc_get_reading_time( $content );
		echo '</span>';
		echo '<a class="comment-toggle single-comment" itemprop="comment""><i class="fa fa-comment"></i>' . get_comments_number() . '</a>';
		edit_post_link( __( '编辑', 'doctext' ) );
		echo '</div>';
	}
}

/**
 * 帖子内容阅读大概时间
 */
if ( !function_exists( 'doc_get_reading_time' ) ) {
	function doc_get_reading_time( $content ) {
		$doc_format = __( '%min%分%sec%秒阅读', 'doc-text' );
		$doc_chars_per_minute = 300;
		$doc_format = str_replace( '%num%', $doc_chars_per_minute, $doc_format );
		$words = mb_strlen( preg_replace( '/\s/', '', html_entity_decode( strip_tags( $content ) ) ), 'UTF-8' );
		$minutes = floor( $words / $doc_chars_per_minute );
		$seconds = floor( $words % $doc_chars_per_minute / ( $doc_chars_per_minute / 60 ) );
		return str_replace( '%sec%', $seconds, str_replace( '%min%', $minutes, $doc_format ) );
	}
}

/**
 * 帖子浏览量（刷新+1）主要用于视频模板
 */
function doc_get_post_views( $post_id ) {
	$count_key = 'views';
	$count = get_post_meta( $post_id, $count_key, true );
	if ( $count == '' ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, 0 );
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
			add_post_meta( $post_id, $count_key, 0 );
		} else {
			update_post_meta( $post_id, $count_key, $count + 1 );
		}

	}
}
add_action( 'get_header', 'doc_set_post_views' );

/**
 * 帖子内容版权-全局
 */
if ( !function_exists( 'doc_post_content_copytight' ) ) {
	function doc_post_content_copytight( $content ) {
		if ( is_singular( 'post' ) ) {
			$doc_sin_copytight_open = get_theme_mod( 'doc_sin_copytight_open', 1 );
			$doc_sin_copytight = get_theme_mod( 'doc_sin_copytight', __( '本文是从Internet上收集的，版权属于原始作者或组织。 如果此页面侵犯了您的权利，请通过电子邮件hi@doccg.com与我们联系！', 'doc-text' ) );
			if ( $doc_sin_copytight_open ) {
				$content .= '<p class="wp-block-copytight single-copytight" itemscope itemtype="http://schema.org/Organization" itemprop="copyrightHolder"><i class="fa fa-flag"></i><span>' . $doc_sin_copytight . '</span></p>';
			}
		}
		return $content;
	}
}
add_filter( 'the_content', 'doc_post_content_copytight' );

/**
 * 将alt和title属性添加到帖子图片的img标签中
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

/**
 * 评论列表用户是否是当前帖子的作者
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
 * 所有版本的wordpress的垃圾邮件和删除链接
 */
if ( !function_exists( 'doc_delete_comment_link' ) ) {
	function doc_delete_comment_link( $id ) {
		if ( current_user_can( 'edit_post' ) ) {
			echo '&nbsp;<a href="' . admin_url( 'comment.php?action=cdc&c=' ) . $id . '">' . __( '删除', 'doc-text' ) . '</a>';
			echo '&nbsp;<a href="' . admin_url( 'comment.php?action=cdc&dt=spam&c=' ) . $id . '">' . __( '垃圾', 'doc-text' ) . '</a>';
		}
	}
}

/**
 * 回复评论自动添加@
 */
function doc_comment_add_at( $comment_text, $comment = '' ) {
	if ( $comment->comment_parent > 0 ) {
		$comment_text = '<em>@' . get_comment_author( $comment->comment_parent ) . '</em> ' . $comment_text;
	}
	return $comment_text;
}
add_filter( 'comment_text', 'doc_comment_add_at', 20, 2 );

/**
 * 自定义评论列表
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
				echo '<span class="comment-post-user">' . __( '作者', 'doc-text' ) . '</span>';
			endif;
			?>
		</div>
		<div class="comment-body">
			<?php
			comment_text();
			if ( $comment->comment_approved == '0' ):
				echo '<i>' . __( '评论等待批准！', 'doc-text' ) . '</i>';
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
