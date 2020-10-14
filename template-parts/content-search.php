<article id="post-<?php the_ID(); ?>" class="article-list">
	<div class="article-content">
		<?php

		$doc_list_card_open = get_theme_mod( 'doc_list_card_open', 'true' );
		$doc_list_time_open = get_theme_mod( 'doc_list_time_open', 'true' );
		$doc_list_excerpt_open = get_theme_mod( 'doc_list_excerpt_open', 'true' );
		$doc_list_link_text = get_theme_mod( 'doc_list_link_text', __( '查看全文', 'doc-text' ) );

		echo '<div class="article-meta">';

		// Article cat
		if ( $doc_list_card_open ) {
			echo '<span class="article-cat">';
			echo doc_category_foreach();
			echo '</span>';
		}

		// Article time
		if ( $doc_list_time_open ) {
			echo '<time class="article-time">' . get_the_time( 'Y/m/d' ) . '</time>';
		}

		echo '</div>';

		// Title
		the_title( '<h3 class="article-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

		// Excerpt
		if ( $doc_list_excerpt_open ) {
			the_excerpt();
		}

		?>
	</div>
</article>
