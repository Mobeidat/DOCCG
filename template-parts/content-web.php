<?php
/**
 * Default list template file.
 *
 * By default, all published webs use this list template.
 *
 * @package TingBiao Wang
 */
?>
<article id="post-<?php the_ID(); ?>" class="webs-list" itemscope itemtype="http://schema.org/article">
	<?php
	$web_vpn = get_post_meta( $post->ID, 'web_vpn', true );
	if ( $web_vpn ) {
		echo '<span class="webs-vpn">' . __( '需要VPN', 'doc-text' ) .
		'</span>';
	}
	if ( has_post_thumbnail() ) {
		echo '<figure class="webs-pic" itemprop="image"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a></figure>';
	}
	?>
	<div class="webs-content-box">
		<div class="webs-content">
			<?php
			/*
			echo '<div class="webs-meta">';
			// web cat
			echo '<span class="webs-cat" itemprop="keywords">';
			echo doc_get_category();
			echo '</span>';
			// web time
			echo '<time class="webs-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
			echo '</div>';
			*/
			// Title
			the_title( '<h3 class="webs-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

			$web_excerpt = get_post_meta( $post->ID, 'web_excerpt', true );
			if ( $web_excerpt ) {
				echo '<p class="webs-excerpt">' . $web_excerpt . '</p>';
			}
			?>
		</div>
		<?php
		// Link
		$web_link = get_post_meta( $post->ID, 'web_url', true );
		if ( $web_link ) {
			echo '<div class="webs-link" itemprop="url" ><a href="' . $web_link . '">' . __( '打开网站', 'doc-text' ) . '</a></div>';
		}
		?>
	</div>
</article>
