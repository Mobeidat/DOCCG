<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <input type="search" name="s" class="searchinput" placeholder="<?php echo get_theme_mod('mrw_search_text',__( '试试找点什么', 'mrw-text' ));?>" value="<?php the_search_query(); ?>" />
    <button type="submit" class="searchsubmit"><i class="fa fa-search"></i></button>
</form>
