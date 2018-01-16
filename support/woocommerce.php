<?php
/**
 * Implement WooCommerce support.
 *
 * @package Simple_Life
 */

add_action( 'after_setup_theme', 'simple_life_add_woocommerce_support' );

/**
 * Declare WooCommerce support.
 */
function simple_life_add_woocommerce_support() {

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-lightbox' );

}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'simple_life_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'simple_life_theme_wrapper_end', 10 );

/**
 * WooCommerce wrapper start.
 */
function simple_life_theme_wrapper_start() {
	echo '<section id="primary"';
	echo simple_life_content_class( 'content-area' );
	echo ' >';
	echo '<main role="main" class="site-main" id="main">';
}

/**
 * WooCommerce wrapper end.
 */
function simple_life_theme_wrapper_end() {
	echo '</main>';
	echo '</section>';
}

/**
 * Hooking WooCommerce.
 */
function simple_life_hooking_woo() {

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

	if ( is_woocommerce() && true === simple_life_get_option( 'enable_breadcrumb' ) ) {
		add_action( 'simple_life_action_after_header', 'woocommerce_breadcrumb' );
		remove_action( 'simple_life_action_after_header', 'simple_life_add_breadcrumb' );
	}

}

add_action( 'wp', 'simple_life_hooking_woo' );


/**
 * WooCommerce Breadcrumb defaults.
 */
function simple_life_woo_breadcrumbs_defaults( $args ) {

	$args['wrap_before'] = '<div id="breadcrumb" itemprop="breadcrumb"><div class="container"><div class="row"><div class="col-sm-12">';
	$args['wrap_after']  = '</div></div></div></div>';

	return $args;

}

add_filter( 'woocommerce_breadcrumb_defaults', 'simple_life_woo_breadcrumbs_defaults' );
