<?php
/**
 * Default list template file.
 *
 * By default, all published webs use this list template.
 *
 * @package TingBiao Wang
 */
?>
<article id="post-<?php the_ID(); ?>" class="web-list" itemscope itemtype="http://schema.org/article">
	<?php
	$site_vpn = get_post_meta( $post->ID, 'site_vpn', true );
	if ( $site_vpn ) {
		echo '<span class="web-vpn">' . __( '需要VPN', 'doc-text' ) .
		'</span>';
	}
	if ( has_post_thumbnail() ) {
		echo '<figure class="web-pic" itemprop="image">' . get_the_post_thumbnail() . '</figure>';
	}
	?>
	<div class="web-content-box">
		<div class="web-content">
			<?php
			/*
			echo '<div class="web-meta">';
			// web cat
			echo '<span class="web-cat" itemprop="keywords">';
			echo doc_get_category();
			echo '</span>';
			// web time
			echo '<time class="web-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
			echo '</div>';
			*/
			// Title
			the_title( '<h3 class="web-title" itemprop="headline">', '</h3>' );
			$web_excerpt = get_post_meta( $post->ID, 'site_excerpt', true );
			if ( $web_excerpt ) {
				echo '<p class="web-excerpt">' . $web_excerpt . '</p>';
			}
			?>
		</div>
		<?php
		// Link
		$web_link = get_post_meta( $post->ID, 'site_url', true );
		if ( $web_link ) {
			echo '<div class="web-link" itemprop="url" ><a href="' . $web_link . '">' . __( '新窗口打开', 'doc-text' ) . '</a></div>';
		}
		?>
	</div>
</article>
