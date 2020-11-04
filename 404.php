<?php
/**
 * Single page template file.
 *
 * This page is a single page type, dedicated to special articles and feature articles.
 *
 * @package TingBiao Wang
 */
get_header();
?>
<section class="doc-404 max-width">
	<h3 class="doc-404-title">
		<?php _e('404','doc-text');?>
	</h3>
	<p class="doc-404-text">
		<?php _e('好遗憾，文章飞走了，但不要灰心，请尝试搜索或看一看以下文章有没有感兴趣的。','doc-text');?>
	</p>
	<?php
	get_search_form();
	doc_sort_box();
	$search_query = array( 'posts_per_page' => 3, 'orderby' => 'rand' );
	$searchs_query = new WP_Query( $search_query );
	if ( $searchs_query->have_posts() ):
		?>
	<section itemprop="search" class="article-box max-width">
		<?php while ( $searchs_query->have_posts() ): $searchs_query->the_post();?>
		<article id="post-<?php the_ID(); ?>" class="article-list" itemscope itemtype="http://schema.org/article">
			<?php get_template_part( 'template-parts/content', '' );?>
		</article>
		<?php endwhile;?>
	</section>
	<?php
	endif;
	wp_reset_postdata();
	?>
</section>
<?php get_footer();?>
