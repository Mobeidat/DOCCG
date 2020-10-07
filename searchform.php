<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group max-box">
		<input type="search" name="s" class="forminput" placeholder="<?php echo get_theme_mod('mrw_search_text',__( '来搜点什么', 'mrw-text' ));?>" value="<?php the_search_query(); ?>" />
		<button type="submit" class="btns formsubmit"><i class="fa fa-search"></i></button>
	</div>
</form>
