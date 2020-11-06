<?php
/**
 * 自定义类别-站点推荐
 *
 * 后台可添加自定义站点所属于什么类型 /wp-admin/edit-tags.php?taxonomy=site-list&post_type=site-post
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
<section itemprop="article" class="site-list-box max-width">
	<?php
	while ( have_posts() ): the_post();
	get_template_part( 'template-parts/content', 'site-post' );
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
