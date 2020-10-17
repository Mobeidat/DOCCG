<?php
/**
 * Post page template file.
 *
 * If the article format is not selected, this default template will be displayed.
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

			// Category
			$doc_sin_top_category_open = get_theme_mod( 'doc_sin_top_category_open', 'ture' );
			if ( $doc_sin_top_category_open ) {
				echo '<div class="single-category" itemprop="keywords">';
				doc_get_category();
				echo '</div> ';
			}

			// Time / Read time / Comment / Edit
			$doc_sin_top_meta_open = get_theme_mod( 'doc_sin_top_meta_open', 'ture' );
			if ( $doc_sin_top_meta_open ): doc_get_single_meta();
			endif;

			// Title
			the_title( '<h3 class="single-title" itemprop="headline">', '</h3>' );
			?>
		</header>
		<main class="single-content" itemprop="articleBody">
			<?php
			the_content();
			wp_link_pages();
			?>
		</main>
		<?php

		// Time / Read time / Comment / Edit
		$doc_sin_bottom_meta_open = get_theme_mod( 'doc_sin_bottom_meta_open', 'ture' );
		if ( $doc_sin_bottom_meta_open ): doc_get_single_meta();
		endif;

		// Single share
		$doc_sin_share_open = get_theme_mod( 'doc_sin_share_open', 'ture' );
		$doc_sin_share = get_theme_mod( 'doc_sin_share', 'weibo,qq,wechat,tencent,qzone,facebook,twitter,google' );
		if ( $doc_sin_share_open ): echo '<div class="single-share share-component" data-sites="' . $doc_sin_share . '"></div>';
		endif;

		// Single tags
		$doc_sin_tag_open = get_theme_mod( 'doc_sin_tag_open', 'ture' );
		if ( $doc_sin_tag_open ): the_tags( '<div class="single-tag">', ' ', '</div>' );
		endif;

		// Comment
		echo '<footer class="single-foo single-foo-fixed" itemprop="comment"><div class="single-foo-box max-width"><a class="single-foo-close comment-toggle"><span>' . _x( 'Comment', 'doc-text' ) . '</span><i class="fa fa-close"></i></a>';
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
