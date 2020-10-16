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
			$doc_single_top_category_open = get_theme_mod( 'doc_single_top_category_open', 'ture' );
			$doc_single_top_meta_open = get_theme_mod( 'doc_single_top_meta_open', 'ture' );

			// Category
			if ( $doc_single_top_category_open ) {
				echo '<div class="single-category" itemprop="keywords">';
				doc_category_foreach();
				echo '</div> ';
			}

			// Time / Read time / Comment / Edit
			echo '<div class="single-meta">';
			if ( $doc_single_top_meta_open ) {
				echo '<time class="single-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished"><i class="fa fa-calendar-o"></i>' . get_the_time( 'Y-m-d' ) . '</time>';

				echo '<span class="single-read"><i class="fa fa-calendar-o"></i>';
				echo doc_get_reading_time( $content );
				echo '</span>';

				echo '<a class="comment-toggle single-comment" itemprop="comment""><i class="fa fa-comment"></i>' . get_comments_number() . '</a>';
			}
			edit_post_link( __( 'Edit', 'doctext' ) );
			echo '</div>';

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
		$doc_single_bottom_meta_open = get_theme_mod( 'doc_single_bottom_meta_open', 'ture' );
		$doc_sin_share_open = get_theme_mod( 'doc_sin_share_open', 'ture' );
		$doc_sin_share = get_theme_mod( 'doc_sin_share', 'weibo,qq,wechat,tencent,qzone,facebook,twitter,google' );
		$doc_sin_tag_open = get_theme_mod( 'doc_sin_tag_open', 'ture' );

		// Time / Read time / Comment / Edit
		if ( $doc_single_bottom_meta_open ) {
			echo '<div class="single-meta">';
			echo '<time class="single-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished"><i class="fa fa-calendar-o"></i>' . get_the_time( 'Y-m-d' ) . '</time>';

			echo '<span class="single-read"><i class="fa fa-calendar-o"></i>';
			echo doc_get_reading_time( $content );
			echo '</span>';

			echo '<a class="comment-toggle single-comment" itemprop="comment""><i class="fa fa-comment"></i>' . get_comments_number() . '</a>';

			edit_post_link( __( 'Edit', 'doctext' ) );
			echo '</div>';
		}

		// Single share
		if ( $doc_sin_share_open ) {
			echo '<div class="single-share share-component" data-sites="' . $doc_sin_share . '"></div>';
		}

		// Single tags
		if ( $doc_sin_tag_open ) {
			the_tags( '<div class="single-tag">', ' ', '</div>' );
		}

		// Comment
		echo '<footer class="single-foo single-foo-fixed" itemprop="comment"><div class="single-foo-box max-width"><a class="single-foo-close comment-toggle"><span>' . __( 'Comment', 'doc-text' ) . '</span><i class="fa fa-close"></i></a>';
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
