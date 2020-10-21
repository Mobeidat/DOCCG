<?php
/**
 * Default list template file.
 *
 * By default, all published articles use this list template.
 *
 * @package TingBiao Wang
 */
?>
<article id="post-<?php the_ID(); ?>" class="article-list article-first-list" itemscope itemtype="http://schema.org/article">
	<?php
	$doc_list_pic_open = get_theme_mod( 'doc_list_pic_open', 1 );
	if ( $doc_list_pic_open ) {
		if ( has_post_thumbnail() ) {
			echo '<figure class="article-pic" itemprop="image"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a></figure>';
		}
	}
	?>
	<div class="article-content">
		<?php

		$doc_list_category_open = get_theme_mod( 'doc_list_category_open', 1 );
		$doc_list_time_open = get_theme_mod( 'doc_list_time_open', 1 );
		$doc_list_excerpt_open = get_theme_mod( 'doc_list_excerpt_open', 1 );
		$doc_list_link_text_open = get_theme_mod( 'doc_list_link_text_open', 1 );
		$doc_list_link_text = get_theme_mod( 'doc_list_link_text', __( 'Read more', 'doc-text' ) );

		echo '<div class="article-meta">';

		// Article cat
		if ( $doc_list_category_open ) {
			echo '<span class="article-cat" itemprop="keywords">';
			echo doc_get_category();
			echo '</span>';
		}

		// Article time
		if ( $doc_list_time_open ) {
			echo '<time class="article-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
		}

		echo '</div>';

		// Title
		the_title( '<h3 class="article-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

		// Excerpt
		if ( $doc_list_excerpt_open ) {
			the_excerpt();
		}

		// Link
		if ( $doc_list_link_text_open ) {
			echo '<div class="article-link" itemprop="url" ><a href="' . get_the_permalink() . '">' . $doc_list_link_text . '</a></div>';
		}

		?>
	</div>
</article>
