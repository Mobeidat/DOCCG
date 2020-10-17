<?php
/**
 * Search box template.
 *
 * Customize the search box to fit the current theme style
 *
 * @package TingBiao Wang
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<input type="search" name="s" class="searchinput" placeholder="<?php _e( 'Try to search', 'doc-text' );?>" value="<?php the_search_query(); ?>" />
	<button type="submit" class="searchsubmit"><i class="fa fa-search"></i></button>
</form>
