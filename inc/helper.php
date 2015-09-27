<?php
/**
 * Theme helper functions.
 *
 * @package Simple_Life
 */

if ( ! function_exists( 'simple_life_get_image_alignment_options' ) ) :

	/**
	 * Returns image alignment options.
	 *
	 * @since Simple Life 2.0
	 */
	function simple_life_get_image_alignment_options() {

		$choices = array(
		'none'   => __( 'None', 'simple-life' ),
		'left'   => __( 'Left', 'simple-life' ),
		'center' => __( 'Center', 'simple-life' ),
		'right'  => __( 'Right', 'simple-life' ),
		);
		return $choices;

	}

endif;

if ( ! function_exists( 'simple_life_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since Simple Life 2.0
	 *
	 * @param bool $add_disable Add whether disable option or not.
	 */
	function simple_life_get_image_sizes_options( $add_disable = true ) {

		global $_wp_additional_image_sizes;
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
		$choices = array();
		if ( true === $add_disable ) {
			$choices['disable'] = __( 'No Image', 'simple-life' );
		}
		foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
			$choices[ $_size ] = $_size . ' ('. get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
		}
		$choices['full'] = __( 'full (original)', 'simple-life' );
		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {

			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key . ' ('. $size['width'] . 'x' . $size['height'] . ')';
			}
		}
		return $choices;

	}

endif;
