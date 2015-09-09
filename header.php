<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Simple Life
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'simple-life' ); ?></a>

	<header id="masthead" class="site-header container" role="banner">
		<div class="site-branding">
      <?php
        $site_logo = simple_life_get_option( 'site_logo' );
        $replace_site_title = simple_life_get_option( 'replace_site_title' );
      ?>
      <?php if ( ! empty( $site_logo ) ) : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $site_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-logo"/></a>
      <?php endif ?>
      <?php if ( ( false == $replace_site_title && ! empty( $site_logo ) ) || empty( $site_logo ) ) : ?>
  			<h1 class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
      <?php endif ?>
			<h2 class="site-description text-center"><?php bloginfo( 'description' ); ?></h2>
		</div>
		<?php if ( get_header_image() ) : ?>
		<div id="site-header">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			</a>
		</div>
		<?php endif; ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="assistive-text skip-link">
				<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'simple-life' ); ?>">
					<?php esc_html_e( 'Skip to content', 'simple-life' ); ?>
				</a>
			</div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->


	<div id="content" class="site-content container">
		<div class="row">
