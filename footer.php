<?php
/**
 * Global footer template file.
 *
 * Show on all pages, share template.
 *
 * @package TingBiao Wang
 */
?>
</main>

<footer id="site-foo" role="footer" itemscope itemtype="http://schema.org/WPFooter">
	<?php if ( is_single() || is_page() ) {} else {?>
	<section class="site-bottom-ad" itemscope itemtype="http://schema.org/WPAdBlock">
		<h2>非常棒的主题</h2>
		<p>你想要这些吗</p>
		<div class="site-bottom-ad-link"><a href="">查看更多</a></div>
	</section>
	<?php } ?>
	<section class="site-bottom">
		<?php
		echo '<div class="site-bottom-list bottom-about">';
		doc_get_custom_logo();
		$doc_bottom_about = get_theme_mod( 'doc_bottom_about', __( 'Thank you for visiting my small site. I am a designer and front-end development enthusiast. These are some resources and materials that I usually collect. hope it helps you.', 'doc-text' ) );
		if ( $doc_bottom_about ) {
			echo '<p>' . $doc_bottom_about . '</p>';
		}
		echo '</div>';

		$new_query = array( 'posts_per_page' => 3 );
		$news_query = new WP_Query( $new_query );
		if ( $news_query->have_posts() ): ?>
		<div class="site-bottom-list news-posts">
			<?php
			$doc_express_title = get_theme_mod( 'doc_express_title', __( 'Express', 'doc-text' ) );
			echo '<h3 class="site-bottom-title">' . $doc_express_title . '</h3>';
			?>
			<div class="news-box">
				<?php
				while ( $news_query->have_posts() ): $news_query->the_post();
				echo '<article class="news-list">';
				the_title( '<h3 class="news-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
				echo '<time class="news-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
				echo '</article>';
				endwhile;
				?>
			</div>
		</div>
		<?php
		endif;
		wp_reset_postdata();
		doc_bottom_link();
		?>
	</section>
	<?php doc_copyright_menu();?>
</footer>
</div>
<?php wp_footer(); ?>
</body></html>