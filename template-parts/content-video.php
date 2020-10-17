<?php
/**
 * Video list template file.
 *
 * Selecting the current template by category will display a three-column video list template.
 *
 * @package TingBiao Wang
 */
?>
<article id="post-<?php the_ID(); ?>" class="media-list">
	<?php
	if ( has_post_thumbnail() ) {
		echo '<figure class="media-pic" itemprop="image"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a></figure>';
	}
	?>
	<div class="media-content">
		<?php
		the_title( '<h3 class="media-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		echo '<div class="media-meta">';
		echo '<span class="media-read"><i class="fa fa-eye"></i>';
		echo doc_get_post_views( $post->ID );
		echo '人学习</span>';
		echo '<time class="media-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished"><i class="fa fa-calendar-o"></i>' . get_the_time( 'Y-m-d' ) . '</time>';
		echo '</div>';
		?>
	</div>
</article>
