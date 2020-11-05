<?php
/**
 * 站点推荐
 *
 * 后台自定义文章类型添加共享站点，可分类
 *
 * @package TingBiao Wang
 */
get_header();
if ( get_category_children( get_category_root_id( the_category_ID( false ) ) ) != "" ) {
	echo '<ul>';
	echo wp_list_categories( "child_of=" . get_category_root_id( the_category_ID( false ) ) . "&depth=0&hide_empty=0&title_li=&orderby=id&order=ASC" );
	echo '</ul>';
}
if ( have_posts() ):
	?>
<section itemprop="article" class="webs-box max-width">
	<?php
	while ( have_posts() ): the_post();
	get_template_part( 'template-parts/content', 'web' );
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
