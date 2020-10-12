<article class="topic-list">
	<div class="topic-box">
		<div class="topic-con">
			<?php
			the_title( '<h3 class="topic-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
			doc_topic_meta();
			doc_topic_tag();
			the_excerpt();
			doc_topic_link();
			?>
		</div>
		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="topic-pic" style="background-image: url(<?php echo the_post_thumbnail_url();?>)"><a href="<?php the_permalink();?>"></a></figure>
		<?php endif;?>
	</div>
</article>
