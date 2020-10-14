<?php
/**
 * Post page template file.
 *
 * If the article format is not selected, this default template will be displayed.
 *
 * @package TingBiao Wang
 */
get_header();
doc_sort_box();
if ( have_posts() ):
	?>
<section class="article-box max-width">
	<?php
	while ( have_posts() ): the_post();
	get_template_part( 'template-parts/content', '' );
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
