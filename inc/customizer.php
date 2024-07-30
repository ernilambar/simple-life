<?php
/**
 * Theme Customizer
 *
 * @package Simple_Life
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function simple_life_customize_register( $wp_customize ) {
	global $simple_life_default_options;

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'            => '.site-title a',
			'container_inclusive' => false,
			'render_callback'     => function () {
				bloginfo( 'name' );
			},
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector'            => '.site-description',
			'container_inclusive' => false,
			'render_callback'     => function () {
				bloginfo( 'description' );
			},
		)
	);

	// Add Panel.
	$wp_customize->add_panel(
		'simple_life_options_panel',
		array(
			'title'      => esc_html__( 'Simple Life Options', 'simple-life' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
		)
	);

	// General Section.
	$wp_customize->add_section(
		'simple_life_options_general',
		array(
			'title'      => esc_html__( 'General Options', 'simple-life' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'simple_life_options_panel',
		)
	);

	// Setting - site_layout.
	$wp_customize->add_setting(
		'simple_life_options[site_layout]',
		array(
			'default'           => $simple_life_default_options['site_layout'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[site_layout]',
		array(
			'label'    => esc_html__( 'Site Layout', 'simple-life' ),
			'section'  => 'simple_life_options_general',
			'type'     => 'select',
			'priority' => 105,
			'choices'  => array(
				'content-sidebar' => esc_html__( 'Content-Sidebar', 'simple-life' ),
				'sidebar-content' => esc_html__( 'Sidebar-Content', 'simple-life' ),
				'full-width'      => esc_html__( 'Full Width', 'simple-life' ),
			),
		)
	);

	// Setting - content_layout.
	$wp_customize->add_setting(
		'simple_life_options[content_layout]',
		array(
			'default'           => $simple_life_default_options['content_layout'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[content_layout]',
		array(
			'label'    => esc_html__( 'Content Layout', 'simple-life' ),
			'section'  => 'simple_life_options_general',
			'type'     => 'select',
			'priority' => 115,
			'choices'  => array(
				'full'          => esc_html__( 'Full Post (with image)', 'simple-life' ),
				'excerpt'       => esc_html__( 'Excerpt Only', 'simple-life' ),
				'excerpt-thumb' => esc_html__( 'Excerpt with thumbnail', 'simple-life' ),
			),
		)
	);

	// Setting - archive_image_thumbnail_size.
	$wp_customize->add_setting(
		'simple_life_options[archive_image_thumbnail_size]',
		array(
			'default'           => $simple_life_default_options['archive_image_thumbnail_size'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[archive_image_thumbnail_size]',
		array(
			'label'           => esc_html__( 'Archive Image Size', 'simple-life' ),
			'section'         => 'simple_life_options_general',
			'type'            => 'select',
			'priority'        => 120,
			'choices'         => simple_life_get_image_sizes_options( false ),
			'active_callback' => 'simple_life_is_non_excerpt_content_layout_active',
		)
	);

	// Setting - archive_image_alignment.
	$wp_customize->add_setting(
		'simple_life_options[archive_image_alignment]',
		array(
			'default'           => $simple_life_default_options['archive_image_alignment'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[archive_image_alignment]',
		array(
			'label'           => esc_html__( 'Archive Image Alignment', 'simple-life' ),
			'section'         => 'simple_life_options_general',
			'type'            => 'select',
			'priority'        => 125,
			'choices'         => simple_life_get_image_alignment_options(),
			'active_callback' => 'simple_life_is_non_excerpt_content_layout_active',
		)
	);

	// Setting - enable_breadcrumb.
	$wp_customize->add_setting(
		'simple_life_options[enable_breadcrumb]',
		array(
			'default'           => $simple_life_default_options['enable_breadcrumb'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[enable_breadcrumb]',
		array(
			'label'    => esc_html__( 'Enable Breadcrumb', 'simple-life' ),
			'section'  => 'simple_life_options_general',
			'type'     => 'checkbox',
			'priority' => 130,
		)
	);

	// Blog Section.
	$wp_customize->add_section(
		'simple_life_options_blog',
		array(
			'title'      => esc_html__( 'Blog Options', 'simple-life' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'simple_life_options_panel',
		)
	);

	// Setting - read_more_text.
	$wp_customize->add_setting(
		'simple_life_options[read_more_text]',
		array(
			'default'           => $simple_life_default_options['read_more_text'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[read_more_text]',
		array(
			'label'    => esc_html__( 'Read more text', 'simple-life' ),
			'section'  => 'simple_life_options_blog',
			'type'     => 'text',
			'priority' => 210,
		)
	);

	// Setting - excerpt_length.
	$wp_customize->add_setting(
		'simple_life_options[excerpt_length]',
		array(
			'default'              => $simple_life_default_options['excerpt_length'],
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'simple_life_sanitize_number_absint',
			'sanitize_js_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[excerpt_length]',
		array(
			'label'    => esc_html__( 'Excerpt Length', 'simple-life' ),
			'section'  => 'simple_life_options_blog',
			'type'     => 'text',
			'priority' => 220,
		)
	);

	// Search Section.
	$wp_customize->add_section(
		'simple_life_options_search',
		array(
			'title'      => esc_html__( 'Search Options', 'simple-life' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'simple_life_options_panel',
		)
	);

	// Setting - search_placeholder.
	$wp_customize->add_setting(
		'simple_life_options[search_placeholder]',
		array(
			'default'           => $simple_life_default_options['search_placeholder'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[search_placeholder]',
		array(
			'label'    => esc_html__( 'Search Placeholder', 'simple-life' ),
			'section'  => 'simple_life_options_search',
			'type'     => 'text',
			'priority' => 220,
		)
	);

	// Pagination Section.
	$wp_customize->add_section(
		'simple_life_options_pagination',
		array(
			'title'      => esc_html__( 'Pagination Options', 'simple-life' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'simple_life_options_panel',
		)
	);
	// Setting - pagination_type.
	$wp_customize->add_setting(
		'simple_life_options[pagination_type]',
		array(
			'default'           => $simple_life_default_options['pagination_type'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[pagination_type]',
		array(
			'label'    => esc_html__( 'Pagination Type', 'simple-life' ),
			'section'  => 'simple_life_options_pagination',
			'type'     => 'select',
			'priority' => 220,
			'choices'  => array(
				'default' => esc_html__( 'Default', 'simple-life' ),
				'numeric' => esc_html__( 'Numeric', 'simple-life' ),
			),
		)
	);

	// Footer Section.
	$wp_customize->add_section(
		'simple_life_options_footer',
		array(
			'title'      => esc_html__( 'Footer Options', 'simple-life' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'simple_life_options_panel',
		)
	);

	// Setting - copyright_text.
	$wp_customize->add_setting(
		'simple_life_options[copyright_text]',
		array(
			'default'           => $simple_life_default_options['copyright_text'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[copyright_text]',
		array(
			'label'    => esc_html__( 'Copyright text', 'simple-life' ),
			'section'  => 'simple_life_options_footer',
			'type'     => 'text',
			'priority' => 910,
		)
	);

	// Setting - powered_by.
	$wp_customize->add_setting(
		'simple_life_options[powered_by]',
		array(
			'default'           => $simple_life_default_options['powered_by'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[powered_by]',
		array(
			'label'    => esc_html__( 'Show Powered By', 'simple-life' ),
			'section'  => 'simple_life_options_footer',
			'type'     => 'checkbox',
			'priority' => 920,
		)
	);

	// Setting - go_to_top.
	$wp_customize->add_setting(
		'simple_life_options[go_to_top]',
		array(
			'default'           => $simple_life_default_options['go_to_top'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'simple_life_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'simple_life_options[go_to_top]',
		array(
			'label'    => esc_html__( 'Enable Go To Top', 'simple-life' ),
			'section'  => 'simple_life_options_footer',
			'type'     => 'checkbox',
			'priority' => 920,
		)
	);
}
add_action( 'customize_register', 'simple_life_customize_register' );

if ( ! function_exists( 'simple_life_is_non_excerpt_content_layout_active' ) ) :

	/**
	 * Check if non excerpt content layout is active.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function simple_life_is_non_excerpt_content_layout_active( $control ) {

		if ( 'excerpt' !== $control->manager->get_setting( 'simple_life_options[content_layout]' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

endif;

// Sanitization callback functions.
if ( ! function_exists( 'simple_life_sanitize_number_absint' ) ) {
	/**
	 * Sanitize positive integer.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $number Number to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized number; otherwise, the setting default.
	 */
	function simple_life_sanitize_number_absint( $number, $setting ) {
		$number = absint( $number );
		return ( $number ? $number : $setting->default );
	}
}

if ( ! function_exists( 'simple_life_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function simple_life_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}
}

if ( ! function_exists( 'simple_life_sanitize_select' ) ) {
	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function simple_life_sanitize_select( $input, $setting ) {
		$input = sanitize_text_field( $input );

		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Customizer partials.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function simple_life_customizer_partials( WP_Customize_Manager $wp_customize ) {
	$wp_customize->selective_refresh->add_partial(
		'copyright-text',
		array(
			'selector'            => '.copyright-text',
			'settings'            => array( 'simple_life_options[copyright_text]' ),
			'container_inclusive' => false,
			'render_callback'     => function () {
				echo wp_kses_post( simple_life_get_option( 'copyright_text' ) );
			},
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'read-more-text',
		array(
			'selector'            => 'a.readmore',
			'settings'            => array( 'simple_life_options[read_more_text]' ),
			'container_inclusive' => false,
			'render_callback'     => function () {
				echo esc_html( simple_life_get_option( 'read_more_text' ) );
			},
		)
	);
}

add_action( 'customize_register', 'simple_life_customizer_partials', 99 );
