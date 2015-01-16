<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Museum
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="<?php echo esc_url( get_template_directory_uri(). '/assets/js/html5shiv.js' ); ?>"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle"><?php _e( 'Menu', 'museum' ); ?></button>
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'museum' ); ?></a>
		<div class="nav-wrapper <?php museum_menu_class(); ?>">
			<?php
				wp_nav_menu( array(
					'theme_location'  => 'primary',
					'container_class' => 'main-menu'
				) );

				wp_nav_menu( array(
					'theme_location'  => 'social',
					'container_class' => 'social-menu',
					'fallback_cb' => false
				) );
			?>
		</div>
	</nav><!-- #site-navigation -->

	<header id="masthead" class="site-header" role="banner">
		<?php $header_position = get_theme_mod( 'header_position', 'right' ); ?>
		<div class="site-branding text-<?php echo esc_attr( $header_position ); ?>">

			<?php if ( get_header_image() ) : ?>
			<div class="site-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>">
				</a>
			</div>
			<?php endif; // End header image check. ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
