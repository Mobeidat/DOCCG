<?php
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php
	if ( have_comments() ): ?>
	<div class="comment-box">
		<h3 class="comment-title" itemprop="commentCount">
			<?php
			comments_number( __( '0 Comment', 'doctext' ), __( '1 Comment', 'doctext' ), '% ' . __( 'Comments', 'doctext' ) );
			echo '<a href="#respond">' . __( 'To comment', 'doc-text' ) . '</a>';
			?>
		</h3>
		<ol class="comment-ol"  itemprop="comment">
			<?php
			wp_list_comments( array(
				'avatar_size' => 50,
				'style' => 'ul',
				'callback' => 'doc_theme_comments',
				'type' => 'all'
			) );
			?>
		</ol>
		<?php
		the_comments_pagination( array(
			'prev_text' => __( '&laquo;', 'doctext' ),
			'next_text' => __( '&raquo;', 'doctext' ),
		) );
		?>
	</div>
	<?php
	endif;
	if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
		?>
	<p class="no-comments">
		<?php _e( 'Comments are closed.', 'doctext'); ?>
	</p>
	<?php
	}
	comment_form( array(
		'title_reply_before' => '<h3 class="comment-title" itemprop="comment">',
		'title_reply_after' => '</h3>',
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true"></textarea></p>',
	) );
	?>
</div>
