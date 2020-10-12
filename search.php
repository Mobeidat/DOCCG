<?php
/**
 * Search page template files.
 *
 * No thumbnails are displayed on the search page, all posts on the website will be searched by default.
 *
 * @package TingBiao Wang
 */
get_header();?>
<section class="search-box max-width">
    <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
        <input type="search" name="s" class="searchinput" placeholder="<?php echo get_theme_mod('mrw_search_text',__( '来搜点什么', 'mrw-text' ));?>" value="<?php the_search_query(); ?>" />
        <button type="submit" class="searchsubmit"><i class="fa fa-search"></i></button>
    </form>
    <p>找到与<span>“ 世界 ”</span>相关文章<span>66</span>篇</p>
</section>
<section class="article-box max-width">
    <article class="article-list">
        <div class="article-content">
            <div class="article-meta">
                <span class="article-cat"><a href="">wordpress</a></span>
                <time class="article-time"><i class="fa fa-calendar-o"></i>2020-09-30</time>
            </div>
            <h3 class="article-title"><a href="">50+最好的WordPress插件免费和高级50+最好的WordPress插件免费和高级</a></h3>
            <p>最好的WordPress插件。具有内置的WordPress主题功能并非总是一个选择（或最佳选择），因此我们编制了免费和高级的最佳WordPress插件列表</p>
            <div class="article-link"><a href="">查看全文</a></div>
        </div>
    </article>
</section>
<div class="site-next">
    <a href="">上一页</a>
    <a href="">1</a>
    <span>...</span>
    <a href="">3</a>
    <a href="">下一页</a>
</div>
<?php get_footer();?>
