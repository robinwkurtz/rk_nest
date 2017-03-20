<!doctype html>
<!--[if lt IE 7 ]>
<html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>
<html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>

	<title><?php wp_title('|'); ?></title>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_theme_path(); ?>/images/ico/favicon.ico"/>
	<link rel="shortcut icon" type="image/png" href="<?php echo get_theme_path(); ?>/images/ico/favicon.png"/>
	<link rel="apple-touch-icon" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon.png"/>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-57x57.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-72x72.png"/>
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-76x76.png"/>
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-114x114.png"/>
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-120x120.png"/>
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-144x144.png"/>
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_theme_path(); ?>/images/ico/apple-touch-icon-152x152.png"/>

	<?php wp_head();?>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-31515020-3', 'auto');
		ga('send', 'pageview');
	</script>

	<!----------------------
    .______   ____    ____
    |   _  \  \   \  /   /
    |  |_)  |  \   \/   /
    |   _  <    \_    _/
    |  |_)  |     |  |
    |______/      |__|

    .______        ______   .______    __  .__   __.
    |   _  \      /  __  \  |   _  \  |  | |  \ |  |
    |  |_)  |    |  |  |  | |  |_)  | |  | |   \|  |
    |      /     |  |  |  | |   _  <  |  | |  . `  |
    |  |\  \----.|  `--'  | |  |_)  | |  | |  |\   |
    | _| `._____| \______/  |______/  |__| |__| \__|

     __  ___  __    __  .______     .___________.________
    |  |/  / |  |  |  | |   _  \    |           |       /
    |  '  /  |  |  |  | |  |_)  |   `---|  |----`---/  /
    |    <   |  |  |  | |      /        |  |       /  /
    |  .  \  |  `--'  | |  |\  \----.   |  |      /  /----.
    |__|\__\  \______/  | _| `._____|   |__|     /________|

    --------------------------------------------------------!>

</head>

<?php

$id = get_the_ID();
$post_bg_color = get_meta($id, 'post_bg_color');
?>

<body <?php body_class(); echo (!empty($post_bg_color)) ? 'style="background-color:' . $post_bg_color . ';"' : ''; ?>">

	<header class="header small-padding-all">
		<div class="inner-wrapper flex-column">
			<a href="<?php echo get_home_url(); ?>" class="logo js-logo">
				<?php include(locate_template('parts/svg-logo.php')); ?>
			</a>
			<div class="flex-bottom">
				<?php
				$nav = array(
					'theme_location' => 'menu-header',
					'walker' => new navWalker_button
				);
				wp_nav_menu($nav);
				?>
			</div>
		</div>
	</header>

	<div class="site">
