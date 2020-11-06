<?php
/**
 * 无帖子
 *
 * 根据各个页面查询无结果时显示自定义信息
 *
 * @package TingBiao Wang
 */
?>
<section class="article-box max-width">
	<p>
		<?php
		if ( is_search() ) {
			__( '抱歉，暂无当前搜索词帖子。请尝试更换其他搜索词。', 'doc-text' );
		} elseif ( is_single() ) {
			__( '抱歉，没有相关联的帖子。', 'doc-text' );
		} else {
			__( '抱歉，没有符合条件帖子。', 'doc-text' );
		}
		?>
	</p>
</section>
