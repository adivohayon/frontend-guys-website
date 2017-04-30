<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Frontend_Guys
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site container-fluid">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fe-guys' ); ?></a>

	<header id="masthead" class="site-header row" role="banner">
		<div class="site-branding col-sm-4 col-xs-12">
			<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' ); echo ' - ' . get_bloginfo( 'description', 'display' ); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/frontend-guys-logo-dark_bg.svg' ?>" alt="Frontend Guys Logo">
			</a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation col-sm-8 col-xs-12" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'fe-guys' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'walker' => new Nav_Main_Walker() ) ); ?>
			<?php //wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu') ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
