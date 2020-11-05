<?php
/**
 * 帖子页-站点
 *
 * 站点详细介绍，用于详细了解
 *
 * @package TingBiao Wang
 */
get_header();
?>
<section class="web-box max-width" role="article" itemscope itemtype="http://schema.org/Article">
	<?php while ( have_posts() ):the_post();?>
	<article class="web-posts">
		<header class="web-hea">
			<?php

			// Category
			$doc_sin_top_category_open = get_theme_mod( 'doc_sin_top_category_open', 1 );
			if ( $doc_sin_top_category_open ) {
				echo '<div class="web-category" itemprop="keywords">';
				doc_get_category();
				echo '</div> ';
			}

			// Time / Read time / Comment / Edit
			$doc_sin_meta_open = get_theme_mod( 'doc_sin_meta_open', 1 );
			if ( $doc_sin_meta_open ): doc_get_single_meta();
			endif;

			// Title
			the_title( '<h3 class="web-title" itemprop="headline">', '</h3>' );
			?>
		</header>
		<main id="web-content" class="web-content" itemprop="articleBody">
			<?php
			the_content();
			wp_link_pages();
			?>
		</main>
		<?php

		// Comment
		$doc_sin_comment_button_open = get_theme_mod( 'doc_sin_comment_button_open', 1 );
		if ( $doc_sin_comment_button_open ): echo '<div class="web-comment-button"><a class="comment-toggle"><i class="fa fa-comment"></i>' . get_comments_number() . __( '查看评论', 'doc-text' ) . '</a></div>';
		endif;

		// Single share
		$doc_sin_share_open = get_theme_mod( 'doc_sin_share_open', 1 );
		$doc_sin_share = get_theme_mod( 'doc_sin_share', 'weibo,qq,wechat,tencent,qzone' );
		if ( $doc_sin_share_open ): echo '<div class="web-share share-component" data-sites="' . $doc_sin_share . '"></div>';
		endif;

		// Single tags
		$doc_sin_tag_open = get_theme_mod( 'doc_sin_tag_open', 1 );
		if ( $doc_sin_tag_open ): the_tags( '<div class="web-tag">', ' ', '</div>' );
		endif;

		// Comment
		echo '<footer class="web-foo web-foo-fixed" itemprop="comment"><div class="web-foo-box max-width"><a class="web-foo-close comment-toggle"><span>' . _x( '评论', 'doc-text' ) . '</span><i class="fa fa-close"></i></a>';
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		echo '</div></footer>';
		?>
	</article>
	<?php endwhile;?>
</section>
<section class="web-previous-next">
	<?php
	previous_post_link( '<p class="web-previous"><i class="fa fa-arrow-left"></i> %link </p>', ' %title', true );
	next_post_link( '<p class="web-next"> %link <i class="fa fa-arrow-right"></i></p>', '%title', true );
	?>
</section>
<?php get_footer();?>
