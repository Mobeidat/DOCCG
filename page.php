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
<section class="single-box" role="article" itemscope itemtype="http://schema.org/Article">
    <?php while ( have_posts() ):the_post();?>
    <article class="single-post">
        <header class="single-hea">
            <?php the_title( '<h3 class="single-title" itemprop="headline">', '</h3>' );?>
        </header>
        <main class="single-content" itemprop="articleBody">
            <?php
			the_content();
			wp_link_pages();
			?>
        </main>
        <?php
		echo '<footer class="single-foo" itemprop="comment"><div class="single-foo-box max-width"><a class="single-foo-close comment-toggle"><span>' . __( 'Comment', 'doc-text' ) . '</span><i class="fa fa-close"></i></a>';
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		echo '</div></footer>';
		?>
    </article>
    <?php endwhile;?>
</section>
<?php get_footer();?>
