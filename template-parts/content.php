<article id="post-<?php the_ID(); ?>" class="default-list">
	<?php
	$doc_list_pic_open = get_theme_mod( 'doc_list_pic_open', 'true' );
	if ( $doc_list_pic_open ) {
		if ( has_post_thumbnail() ) {
			echo '<figure class="default-pic"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a></figure>';
		}
	}
	?>
	<div class="default-content">
		<?php
		/* card */
		$doc_list_card_open = get_theme_mod( 'doc_list_card_open', 'true' );
		if ( $doc_list_card_open ) {
			echo '<div class="default-card">';
			echo doc_category_foreach();
			echo '</div>';
		}

		/* title */
		the_title( '<h3 class="default-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

		/* excerpt */
		$doc_list_excerpt_open = get_theme_mod( 'doc_list_excerpt_open', 'true' );
		if ( $doc_list_excerpt_open ) {
			the_excerpt();
		}
		?>
		<div class="default-meta">
			<?php
			$doc_list_author_open = get_theme_mod( 'doc_list_author_open', 'true' );
			$doc_list_read_open = get_theme_mod( 'doc_list_read_open', 'true' );
			$doc_list_time_open = get_theme_mod( 'doc_list_time_open', 'true' );
			if ( $doc_list_author_open ) {
				echo '<span class="default-author">By <a href="">Mr Wang</a></span>';
			}
			if ( $doc_list_read_open ) {
				echo '<span class="default-read">';
				echo doc_get_reading_time( get_the_content() );
				echo '</span>';
			}
			if ( $doc_list_time_open ) {
				echo '<time class="default-date">' . get_the_time( 'Y/m/d' ) . '</time>';
			}
			?>
		</div>
	</div>
</article>
