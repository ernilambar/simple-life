<?php
/**
 * Helper functions
 *
 * @package Simple_Life
 */

if ( ! function_exists( 'simple_life_get_image_alignment_options' ) ) :

	/**
	 * Returns image alignment options.
	 *
	 * @since 2.0
	 */
	function simple_life_get_image_alignment_options() {

		$choices = array(
			'none'   => _x( 'None', 'Alignment', 'simple-life' ),
			'left'   => _x( 'Left', 'Alignment', 'simple-life' ),
			'center' => _x( 'Center', 'Alignment', 'simple-life' ),
			'right'  => _x( 'Right', 'Alignment', 'simple-life' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'simple_life_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.2
	 *
	 * @param bool  $add_disable    Add disable option or not.
	 * @param array $allowed        Allowed array.
	 * @param bool  $show_dimension Show or hide dimension.
	 */
	function simple_life_get_image_sizes_options( $add_disable = true, $allowed = array(), $show_dimension = true ) {
		global $_wp_additional_image_sizes;

		$get_intermediate_image_sizes = get_intermediate_image_sizes();

		$choices = array();

		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'simple-life' );
		}

		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'simple-life' );
		$choices['medium']    = esc_html__( 'Medium', 'simple-life' );
		$choices['large']     = esc_html__( 'Large', 'simple-life' );
		$choices['full']      = esc_html__( 'Full (original)', 'simple-life' );

		if ( true === $show_dimension ) {
			foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ) {
					$choices[ $key ] .= ' (' . $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed, true ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;
	}

endif;
