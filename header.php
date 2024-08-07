<?php
/**
 * The header for our theme
 *
 * @package Simple_Life
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'simple-life' ); ?></a>

	<?php do_action( 'simple_life_action_before_header' ); ?>

	<header id="masthead" class="site-header container" role="banner">
		<div class="site-branding">
			<?php simple_life_the_custom_logo(); ?>
			<h1 class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<p class="site-description text-center"><?php bloginfo( 'description' ); ?></p>
		</div>

		<?php if ( get_header_image() ) : ?>
			<div id="site-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				</a>
			</div>
		<?php endif; ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-hidden="true"><?php esc_html_e( 'Primary Menu', 'simple-life' ); ?></button>
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'fallback_cb'    => 'simple_life_primary_menu_fallback',
					)
				);
				?>
		</nav><!-- #site-navigation -->

	</header><!-- #masthead -->

	<?php do_action( 'simple_life_action_after_header' ); ?>

	<div id="content" class="site-content container">
		<div class="row">
