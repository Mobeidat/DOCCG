<?php
/**
 * 默认类别
 *
 * 如果未选择类别模板，则将显示此列表
 *
 * @package TingBiao Wang
 */
get_header();
doc_sort_box();
if ( have_posts() ):
	?>
<section itemprop="article" class="article-box max-width">
	<?php
	$serial = 0;
	while ( have_posts() ): the_post();
	$serial++;
	?>
	<article id="post-<?php the_ID(); ?>" class="article-list <?php if ( $serial == 1 ) { echo 'article-first-list'; }?>" itemscope itemtype="http://schema.org/article">
		<?php get_template_part( 'template-parts/content', '' );?>
	</article>
	<?php endwhile;	?>
</section>
<?php
get_template_part( 'template-parts/content', 'next' );
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
get_footer();
?>
