<?php
/**
 * Template Name: Video[视频]
 *
 * 视频列表
 *
 * 如果类别选择此模板，它将显示为视频列表效果
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
