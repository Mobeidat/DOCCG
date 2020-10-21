<?php
/**
 * Search list template file.
 *
 * Search page setting independent search list template.
 *
 * @package TingBiao Wang
 */
?>
<article id="post-<?php the_ID(); ?>" class="article-list" itemscope itemtype="http://schema.org/article">
	<div class="article-content">
		<?php
		echo '<div class="article-meta">';

		// Article cat
		$doc_list_category_open = get_theme_mod( 'doc_list_category_open', 1 );
		if ( $doc_list_category_open ) {
			echo '<span class="article-cat" itemprop="keywords">';
			echo doc_get_category();
			echo '</span>';
		}

		// Article time
		$doc_list_time_open = get_theme_mod( 'doc_list_time_open', 1 );
		if ( $doc_list_time_open ): echo '<time class="article-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
		endif;

		echo '</div>';

		// Title
		the_title( '<h3 class="article-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

		// Excerpt
		$doc_list_excerpt_open = get_theme_mod( 'doc_list_excerpt_open', 1 );
		if ( $doc_list_excerpt_open ) {
			the_excerpt();
		}
		?>
	</div>
</article>
