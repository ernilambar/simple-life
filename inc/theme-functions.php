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
		'replace_site_title'           => true,
		'site_layout'                  => 'content-sidebar',
		'content_layout'               => 'excerpt-thumb',
		'archive_image_thumbnail_size' => 'large',
		'archive_image_alignment'      => 'center',
		'read_more_text'               => esc_html__( 'Read more', 'simple-life' ),
		'search_placeholder'           => esc_html__( 'Search...', 'simple-life' ),
		'excerpt_length'               => 40,
		'pagination_type'              => 'default',
		'footer_widgets'               => 0,
		'copyright_text'               => '&copy; ' . esc_html__( '2015 All rights reserved', 'simple-life' ),
		'powered_by'                   => true,
		'go_to_top'                    => true,
		);
		$defaults = apply_filters( 'simple_life_filter_default_theme_options', $defaults );
		return $defaults;

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

if ( ! function_exists( 'simple_life_footer_widgets' ) ) :
	/**
	 * Render footer widgets.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $args Arguments for footer widgets.
	 */
	function simple_life_footer_widgets( $args = array() ) {

		$flag_apply_footer_widgets_content = apply_filters( 'simple_life_filter_footer_widgets_content', true );
		if ( true !== $flag_apply_footer_widgets_content ) {
			return false;
		}

		$footer_widgets = simple_life_get_option( 'footer_widgets' );
		if (  0 === $footer_widgets  ) {
			return;
		}
		$number_of_footer_widgets = $footer_widgets;
		// Defaults.
		$args = wp_parse_args( (array) $args, array(
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'wrap_class'      => 'footer-widget-area',
			'before'          => '',
			'after'           => '',
		) );
		$args = apply_filters( 'simple_life_filter_footer_widgets_args', $args );

		$container_open = '';
		$container_close = '';

		if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
			$container_open = sprintf(
				'<%s %s %s>',
				$args['container'],
				( $args['container_class'] ) ? 'class="' . $args['container_class'] . '"':'',
				( $args['container_id'] ) ? 'id="' . $args['container_id'] . '"':''
			);
		}
		if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
			$container_close = sprintf(
				'</%s>',
				$args['container']
			);
		}

		echo $container_open; // WPCS: XSS OK.

		echo $args['before']; // WPCS: XSS OK.

		for ( $i = 1; $i <= $number_of_footer_widgets ;$i++ ) {
			$item_class = apply_filters( 'simple_life_filter_footer_widget_class', '', $i );
			$div_classes = implode( ' ', array( $args['wrap_class'], $item_class ) );
			echo '<div class="' . $div_classes .  '">'; // WPCS: XSS OK.
			$sidebar_name = ( 1 === $i ) ? 'footer-sidebar' : "footer-sidebar-$i" ;
			dynamic_sidebar( $sidebar_name );
			echo '</div><!-- .' . $args['wrap_class'] . ' -->'; // WPCS: XSS OK.
		} // end for loop

		echo $args['after']; // WPCS: XSS OK.

		echo $container_close; // WPCS: XSS OK.

	} // End function simple_life_footer_widgets.
endif;

if ( ! function_exists( 'simple_life_primary_menu_fallback' ) ) :

	/**
	 * Primary menu callback.
	 *
	 * @since 1.0.0
	 */
	function simple_life_primary_menu_fallback() {

		echo '<ul>';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'simple-life' ). '</a></li>';
		wp_list_pages( array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 10,
		) );
		echo '</ul>';

	}
endif;
