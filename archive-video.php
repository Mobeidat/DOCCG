<?php
/**
 * Template Name: Video[视频]
 *
 * 视频类别
 *
 * 如果选择视频类别模板，它将显示为视频列表效果（3列自适应）
 *
 * @package TingBiao Wang
 */
get_header();
doc_sort_box();
if ( have_posts() ):
	?>
<section itemprop="article" class="media-box max-width">
	<?php
	while ( have_posts() ): the_post();
	get_template_part( 'template-parts/content', 'video' );
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
