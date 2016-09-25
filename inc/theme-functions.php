<?php
/**
 * Custom theme functions.
 *
 * @package Simple_Life
 */

if ( ! function_exists( 'simple_life_get_option' ) ) :
	/**
	 * Get option.
	 *
	 * @param string $key Option key.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	function simple_life_get_option( $key, $default = '' ) {

		global $simple_life_default_options;

		if ( empty( $key ) ) {
			return;
		}
		$default = ( isset( $simple_life_default_options[ $key ] ) ) ? $simple_life_default_options[ $key ] : '';

		$theme_options = get_theme_mod( 'simple_life_options', $simple_life_default_options );

		$theme_options = array_merge( $simple_life_default_options, $theme_options );

		$value = '';
		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}
		return $value;

	}
endif;

if ( ! function_exists( 'simple_life_get_theme_option_defaults' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @return array
	 */
	function simple_life_get_theme_option_defaults() {

		$defaults = array(
			'site_logo'                    => '',
			'replace_site_title'           => false,
			'site_layout'                  => 'content-sidebar',
			'content_layout'               => 'excerpt-thumb',
			'archive_image_thumbnail_size' => 'large',
			'archive_image_alignment'      => 'center',
			'enable_breadcrumb'            => false,
			'read_more_text'               => esc_html__( 'Read more', 'simple-life' ),
			'search_placeholder'           => esc_html__( 'Search...', 'simple-life' ),
			'excerpt_length'               => 40,
			'pagination_type'              => 'default',
			'footer_widgets'               => 0,
			'copyright_text'               => '&copy; ' . date_i18n( 'Y' ) . ' ' .  esc_html__( 'All rights reserved', 'simple-life' ),
			'powered_by'                   => true,
			'go_to_top'                    => true,
			);
		$defaults = apply_filters( 'simple_life_filter_default_theme_options', $defaults );
		return $defaults;

	}
endif;

if ( ! function_exists( 'simple_life_get_options' ) ) :

	/**
	 * Get theme options.
	 *
	 * @since 1.8
	 */
	function simple_life_get_options() {

		$value = array();

		$value = get_theme_mod( 'simple_life_options' );

		return $value;

	}

endif;


/**
 * Render content class.
 *
 * @since 1.0.0
 *
 * @param  string|array $class Class to be added.
 */
function simple_life_content_class( $class = '' ) {

	$classes = array();
	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class ); }
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );
	$classes = apply_filters( 'simple_life_filter_content_class', $classes, $class );
	echo 'class="' . join( ' ', $classes ) . '"'; // WPCS: XSS OK.

}

/**
 * Render sidebar class.
 *
 * @since 1.0.0
 *
 * @param  string|array $class Class to be added.
 */
function simple_life_sidebar_class( $class = '' ) {

	$classes = array();
	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class ); }
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );
	$classes = apply_filters( 'simple_life_filter_sidebar_class', $classes, $class );
	echo 'class="' . join( ' ', $classes ) . '"'; // WPCS: XSS OK.
}

if ( ! function_exists( 'simple_life_primary_menu_fallback' ) ) :

	/**
	 * Primary menu callback.
	 *
	 * @since 1.0.0
	 */
	function simple_life_primary_menu_fallback() {

		echo '<ul>';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'simple-life' ) . '</a></li>';
		$args = array(
			'number'       => 8,
			'hierarchical' => false,
			'sort_column'  => 'menu_order, post_title',
			);
		$pages = get_pages( $args );
		if ( is_array( $pages ) && ! empty( $pages ) ) {
			foreach ( $pages as $page ) {
				echo '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a></li>';
			}
		}
		echo '</ul>';

	}
endif;
