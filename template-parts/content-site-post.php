<?php
/**
 * Default list template file.
 *
 * By default, all published site-list use this list template.
 *
 * @package TingBiao Wang
 */
?>
<article id="post-<?php the_ID(); ?>" class="site-list-a" itemscope itemtype="http://schema.org/article">
	<?php
	$site_post_vpn = get_post_meta( $post->ID, 'site_post_vpn', true );
	if ( $site_post_vpn ) {
		echo '<span class="site-list-vpn">' . __( '需要VPN', 'doc-text' ) .
		'</span>';
	}
	if ( has_post_thumbnail() ) {
		echo '<figure class="site-list-pic" itemprop="image"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a></figure>';
	}
	?>
	<div class="site-list-content-box">
		<div class="site-list-content">
			<?php
			/*
			echo '<div class="site-list-meta">';
			// web cat
			echo '<span class="site-list-cat" itemprop="keywords">';
			echo doc_get_category();
			echo '</span>';
			
			// web time
			echo '<time class="site-list-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
			echo '</div>';
			*/

			// 标题
			the_title( '<h3 class="site-list-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );

			$site_post_excerpt = get_post_meta( $post->ID, 'site_post_excerpt', true );
			if ( $site_post_excerpt ) {
				echo '<p class="site-list-excerpt">' . $site_post_excerpt . '</p>';
			}
			?>
		</div>
		<?php

		// 链接
		$site_post_link = get_post_meta( $post->ID, 'site_post_url', true );
		if ( $site_post_link ) {
			echo '<div class="site-list-link" itemprop="url" ><a href="' . $site_post_link . '">' . __( '打开网站', 'doc-text' ) . '</a></div>';
		}
		?>
	</div>
</article>
