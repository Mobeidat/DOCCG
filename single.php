<?php
/**
 * 帖子页
 *
 * 如果未选择帖子格式、也不是自定义帖子类型，则所有已发布的帖子都使用此模板
 *
 * @package TingBiao Wang
 */
get_header();
?>
<section class="single-box max-width" role="article" itemscope itemtype="http://schema.org/Article">
	<?php while ( have_posts() ):the_post();?>
	<article class="single-posts">
		<header class="single-hea">
			<?php

			// 所属分类
			$doc_sin_top_category_open = get_theme_mod( 'doc_sin_top_category_open', 1 );
			if ( $doc_sin_top_category_open ) {
				echo '<div class="single-category" itemprop="keywords">';
				doc_get_category();
				echo '</div> ';
			}

			// 发布时间 / 阅读大概时间 / 评论 / 编辑
			$doc_sin_meta_open = get_theme_mod( 'doc_sin_meta_open', 1 );
			if ( $doc_sin_meta_open ): doc_get_single_meta();
			endif;

			// 标题
			the_title( '<h3 class="single-title" itemprop="headline">', '</h3>' );
			?>
		</header>
		<main id="single-content" class="single-content" itemprop="articleBody">
			<?php
			the_content();
			wp_link_pages();
			?>
		</main>
		<?php

		// 评论按钮
		$doc_sin_comment_button_open = get_theme_mod( 'doc_sin_comment_button_open', 1 );
		if ( $doc_sin_comment_button_open ): echo '<div class="single-comment-button"><a class="comment-toggle"><i class="fa fa-comment"></i>' . get_comments_number() . __( '查看评论', 'doc-text' ) . '</a></div>';
		endif;

		// 分享
		$doc_sin_share_open = get_theme_mod( 'doc_sin_share_open', 1 );
		$doc_sin_share = get_theme_mod( 'doc_sin_share', 'weibo,qq,wechat,tencent,qzone' );
		if ( $doc_sin_share_open ): echo '<div class="single-share share-component" data-sites="' . $doc_sin_share . '"></div>';
		endif;

		// 标签
		$doc_sin_tag_open = get_theme_mod( 'doc_sin_tag_open', 1 );
		if ( $doc_sin_tag_open ): the_tags( '<div class="single-tag">', ' ', '</div>' );
		endif;

		// 评论列表
		echo '<footer class="single-foo single-foo-fixed" itemprop="comment"><div class="single-foo-box max-width"><a class="single-foo-close comment-toggle"><span>' . _x( '评论', 'doc-text' ) . '</span><i class="fa fa-close"></i></a>';
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		echo '</div></footer>';
		?>
	</article>
	<?php endwhile;?>
</section>
<section class="single-previous-next">
	<?php
	previous_post_link( '<p class="single-previous"><i class="fa fa-arrow-left"></i> %link </p>', ' %title', true );
	next_post_link( '<p class="single-next"> %link <i class="fa fa-arrow-right"></i></p>', '%title', true );
	?>
</section>
<?php get_footer();?>
