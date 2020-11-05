<?php
/**
 * 搜索结果
 *
 * 搜索结果没有缩略图显示，默认情况下将搜索网站上的所有帖子
 *
 * @package TingBiao Wang
 */
get_header();
doc_sort_box();
if ( have_posts() ):
	?>
<section itemprop="search" class="article-box max-width">
	<?php
	while ( have_posts() ): the_post();
	get_template_part( 'template-parts/content', 'search' );
	endwhile;
	?>
</section>
<?php
get_template_part( 'template-parts/content', 'next' );
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
get_footer();
?>
