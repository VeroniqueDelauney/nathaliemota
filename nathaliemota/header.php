<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nathaliemota
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'my-body-class' ); ?>>
<?php wp_body_open(); ?>
<div id="page">
	<header id="masthead" class="site-header">

		<div class="topnav">
			<div class="logo">
				<a href="/" title="Page d'accueil du site de Nathalie Mota">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.png'; ?> " alt="Nathalie Mota" />
				</a>
			</div>
			<div class="links">

				<!-- Nouvelle zone de menu -->
				<div id="topMenu">
					<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'container_class' => 'header' ) ); ?>
				</div>

				<div class="menu-hamburger">
					<div class="hamburger-icon">☰</div>
				</div>

			</div>

		</div>		

	</header><!-- #masthead -->