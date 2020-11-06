<?php
/**
 * 页面
 *
 * 此页面是单独页面类型，专用于特殊文章
 *
 * @package TingBiao Wang
 */
get_header();
?>
<section class="single-box max-width" role="article" itemscope itemtype="http://schema.org/Article">
	<?php while ( have_posts() ):the_post();?>
	<article class="single-posts">
		<header class="single-hea">
			<?php
			// 编辑
			echo '<div class="single-meta">';
			edit_post_link( __( '编辑', 'doctext' ) );
			echo '</div>';

			//标题
			the_title( '<h3 class="single-title" itemprop="headline">', '</h3>' );
			?>
		</header>
		<main class="single-content" itemprop="articleBody">
			<?php
			the_content();
			wp_link_pages();
			?>
		</main>
		<?php
		// 评论列表
		echo '<footer class="single-foo" itemprop="comment"><div class="single-foo-box max-width"><a class="single-foo-close comment-toggle"><span>' . __( '评论', 'doc-text' ) . '</span><i class="fa fa-close"></i></a>';
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		echo '</div></footer>';
		?>
	</article>
	<?php endwhile;?>
</section>
<?php get_footer();?>
