<?php
/**
 * 全局页头
 *
 * 在所有页面上共享显示
 *
 * @package TingBiao Wang
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php wp_head();?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!--[if lt IE 11]>
	<div class="browse-happy" role="dialog">It is strongly recommended to upgrade the<a href="http://browsehappy.com/">browser</a> for a better experience</div>
<![endif]-->
<div id="warp">
<header id="site-hea" role="header" itemscope itemtype="http://schema.org/WPHeader">
	<div class="site-hea-left"><a id="menu-toggle" class="toggle"><i class="fa fa-bars"></i></a>
		<?php doc_custom_logo();?>
	</div>
	<div class="site-hea-right" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'topnav',
			'container' => 'nav',
			'container_id' => 'nav',
			'container_class' => 'nav',
			'depth' => 2,
			'fallback_cb' => 0,
		) );
		echo '<a href="' . esc_url( home_url( '/?s=' ) ) . '" id="search-toggle" class="toggle"><i class="fa fa-search"></i></a>';
		?>
	</div>
</header>
<main id="site-main" role="main" itemscope itemtype="http://schema.org/Blog">
<?php doc_breadcrumbs();?>
