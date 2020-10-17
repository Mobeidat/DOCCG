<?php
/**
 * Pagination template file.
 *
 * Use digital paging by default.
 *
 * @package TingBiao Wang
 */
if ( $wp_query->max_num_pages > 1 ) {
	echo '<div class="site-next">';
	echo paginate_links( array( 'prev_text' => __( '上一页', 'doc-text' ), 'next_text' => __( '下一页', 'doc-text' ), 'mid_size' => 1 ) );
	/*if ( !is_paged() ) {
		next_posts_link( __( '下一页', 'doc-text' ) );
	} else {}*/
	echo '</div>';
}
?>