<?php
/**
 * Search page template files.
 *
 * No thumbnails are displayed on the search page, all posts on the website will be searched by default.
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
<?php wp_head();?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!--[if lt IE 11]>
	<div class="browse-happy" role="dialog">It is strongly recommended to upgrade the<a href="http://browsehappy.com/">browser</a> for a better experience</div>
<![endif]-->
<div id="warp">
<header id="site-hea">
	<div class="site-hea-left"><a href="#" id="menu-toggle" class="toggle"><i class="fa fa-bars"></i></a>
		<?php doc_custom_logo();?>
	</div>
	<div class="site-hea-right">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'topnav',
			'container' => 'nav',
			'container_id' => 'nav',
			'container_class' => 'nav',
			'depth' => 2,
			'fallback_cb' => 0,
		) );
		?>
		<a href="#" id="search-toggle" class="toggle"><i class="fa fa-search"></i></a> </div>
</header>
<main id="site-main">
<section class="breadcrumbs">
	<div class="max-width"> <a href="">首页</a><span> &raquo; </span><span>wordpress</span> </div>
</section>
