<?php
/**
 * 搜索框
 *
 * 自定义搜索框以适合当前主题样式
 *
 * @package TingBiao Wang
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<input type="search" name="s" class="searchinput" placeholder="<?php _e( '搜索一下', 'doc-text' );?>" value="<?php the_search_query(); ?>" />
	<button type="submit" class="searchsubmit"><i class="fa fa-search"></i></button>
</form>
