</main>

<footer id="site-foo">
	<?php if ( is_single() ) {} else {?>
	<section class="site-bottom-ad">
		<h2>非常棒的主题</h2>
		<p>你想要这些吗</p>
		<div class="site-bottom-ad-link"><a href="">查看更多</a></div>
	</section>
	<?php } ?>
	<section class="site-bottom">
		<div class="site-bottom-list bottom-about">
			<?php doc_custom_logo();?>
			<p>10多年来，我一直为你们做，并分享我的萝卜的各种程序和实用程序，这是深受互联网用户的欢迎。在网站上，lrepacks.ru你会发现我的最新作品 - 来自埃尔丘帕卡布拉的 repkas 。</p>
		</div>
		<div class="site-bottom-list news-posts">
			<h3 class="site-bottom-title">快讯</h3>
			<div class="news-box">
				<article class="news-list">
					<h3 class="news-title"><a href="">RaimerSoft RadioMaximus 2.28.3 （重新包装和便携式）</a></h3>
					<time class="news-time"><i class="fa fa-calendar-o"></i>2020年3月2日</time>
				</article>
			</div>
		</div>
		<div class="site-bottom-list bottom-link">
			<h3 class="site-bottom-title">联系我</h3>
			<p class="link-icon"><a href=""><i class="fa fa-behance"></i></a><a href=""><i class="fa fa-dribbble"></i></a><a href=""><i class="fa fa-github"></i></a></p>
			<p class="link-img"><span>小程序</span><img src="assets/images/buy_02.jpg" alt=""></p>
		</div>
	</section>
	<?php doc_copyright_menu();?>
</footer>
</div>
<?php wp_footer(); ?>
</body></html>