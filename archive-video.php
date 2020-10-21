<?php
/**
 * Template Name: Video[视频]
 *
 * Video template file.
 *
 * If the category selects this template, it will be displayed as a video list effect.
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
