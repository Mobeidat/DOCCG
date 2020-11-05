<?php
/**
 * 全局页尾
 *
 * 在所有页面上共享显示
 *
 * @package TingBiao Wang
 */
?>
</main>

<footer id="site-foo" role="footer" itemscope itemtype="http://schema.org/WPFooter">
	<?php
	$doc_global_bottom_ad_open = get_theme_mod( 'doc_global_bottom_ad_open', 0 );
	$doc_global_bottom_ad_title = get_theme_mod( 'doc_global_bottom_ad_title' );
	$doc_global_bottom_ad_p = get_theme_mod( 'doc_global_bottom_ad_p' );
	$doc_global_bottom_ad_url_text = get_theme_mod( 'doc_global_bottom_ad_url_text' );
	$doc_global_bottom_ad_url = get_theme_mod( 'doc_global_bottom_ad_url' );
	$doc_global_bottom_ad_img = get_theme_mod( 'doc_global_bottom_ad_img' );
	if ( $doc_global_bottom_ad_open ) {
		if ( is_single() || is_page() ) {} else {
			echo '<section class="site-bottom-ad" itemscope itemtype="http://schema.org/WPAdBlock" style="background-image: url(' . $doc_global_bottom_ad_img . ')">';
			if ( $doc_global_bottom_ad_title ) {
				echo '<h2>' . $doc_global_bottom_ad_title . '</h2>';
			}
			if ( $doc_global_bottom_ad_p ) {
				echo '<p>' . $doc_global_bottom_ad_p . '</p>';
			}
			if ( $doc_global_bottom_ad_url ) {
				echo '<div class="site-bottom-ad-link"><a href="' . $doc_global_bottom_ad_url . '">' . $doc_global_bottom_ad_url_text . '</a></div>';
			}
			echo '</section>';
		}
	}
	?>
	<section class="site-bottom">
		<?php
		echo '<div class="site-bottom-list bottom-about">';
		doc_custom_logo();
		$doc_bottom_about = get_theme_mod( 'doc_bottom_about', __( '感谢您访问我的小栈！我是个普通的设计师，也是前端开发爱好者。在这里您可以找到高品质的教程、资源、优秀工具推荐。没有付费、帐户注册或电子邮件垃圾。只需下载您想要的，然后使用它。如果您喜欢并有收获，想保持这个网站正常运行，请考虑 ♥捐赠♥ 支持我。', 'doc-text' ) );
		if ( $doc_bottom_about ) {
			echo '<p>' . $doc_bottom_about . '</p>';
		}
		echo '</div>';

		$new_query = array( 'posts_per_page' => 3 );
		$news_query = new WP_Query( $new_query );
		if ( $news_query->have_posts() ): ?>
		<div class="site-bottom-list news-posts">
			<?php
			$doc_express_title = get_theme_mod( 'doc_express_title', __( '快讯', 'doc-text' ) );
			echo '<h3 class="site-bottom-title">' . $doc_express_title . '</h3>';
			?>
			<div class="news-box">
				<?php
				while ( $news_query->have_posts() ): $news_query->the_post();
				echo '<article class="news-list">';
				the_title( '<h3 class="news-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
				echo '<time class="news-time" datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '" itemprop="datePublished">' . get_the_time( 'Y-m-d' ) . '</time>';
				echo '</article>';
				endwhile;
				?>
			</div>
		</div>
		<?php
		endif;
		wp_reset_postdata();
		doc_bottom_link();
		?>
	</section>
	<?php doc_copyright_menu();?>
</footer>
</div>
<?php
wp_footer();
if ( is_home() ) {
	?>
<script>
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		centeredSlides: true,
		autoplay: {
			delay: 6000,
			disableOnInteraction: false,
		},
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-next',
			prevEl: '.swiper-prev',
		},
	});
</script>
<?php } ?>
</body></html>