<?php
if ( $wp_query->max_num_pages > 1 ) {
	echo '<div class="site-next">';
	echo paginate_links( array( 'prev_text' => '上一页', 'next_text' => '下一页', 'mid_size' => 1 ) );
	/*if ( !is_paged() ) {
		next_posts_link( '下一页' );
	} else {}*/
	echo '</div>';
}
?>