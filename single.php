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
	<article class="single-post">
		<header class="single-hea">
			<div class="single-meta">
				<?php
				// Time
				echo '<time class="single-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished"><i class="fa fa-calendar-o"></i>' . get_the_time( 'Y-m-d' ) . '</time>';

				// Read time
				echo '<span class="single-read"><i class="fa fa-calendar-o"></i>';
				echo doc_get_reading_time( $content );
				echo '</span>';

				// Comment
				echo '<span class="single-comment" itemprop="comment"><i class="fa fa-comment"></i>' . get_comments_number() . '</span>';

				// Category
				echo '<span class="single-cat" itemprop="keywords">';
				doc_category_foreach();
				echo '</span> ';

				?>
			</div>
			<?php
			the_title( '<h3 class="single-title" itemprop="headline">', '</h3>' );
			edit_post_link( __( 'Edit', 'mrw-text' ) );
			?>
		</header>
		<main class="single-content" itemprop="articleBody">
			<?php
			the_content();
			wp_link_pages();
			?>
		</main>
		<?php
		$mrw_sin_share_open = get_theme_mod( 'mrw_sin_share_open', 'ture' );
		$mrw_sin_share = get_theme_mod( 'mrw_sin_share', 'weibo,qzone,qq,wechat' );

		// Single share
		if ( $mrw_sin_share_open ) {
			echo '<div class="single-share share-component" data-sites="' . $mrw_sin_share . '"></div>';
		}

		// Single tags
		the_tags( '<div class="single-tag">', ' ', '</div>' );
		?>
		<footer class="single-foo">
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</footer>
	</article>
	<?php endwhile;?>
</section>
<section class="single-pnext"> <a href="">50+最好的WordPress插件免费和高级50+最好的WordPress插件免费和高级</a><a href="">50+最好的WordPress插件免费和高级50+最好的WordPress插件免费和高级</a> </section>
<?php get_footer();?>
