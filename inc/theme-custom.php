<?php
/**
 * Simple Life custom functions.
 *
 * @package Simple_Life
 */

if ( ! function_exists( 'simple_life_custom_content_classes' ) ) :
	/**
	 * Modify content classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $input Array of content classes.
	 * @return array Modified array of content classes.
	 */
	function simple_life_custom_content_classes( $input ) {

		if ( is_page_template( 'template/content-sidebar.php' ) ) {
			$input[] = 'col-sm-8';
			$input[] = 'pull-left';
		} else if ( is_page_template( 'template/sidebar-content.php' ) ) {
			$input[] = 'col-sm-8';
			$input[] = 'pull-right';
		} else if ( is_page_template( 'template/full-width.php' ) ) {
			$input[] = 'col-sm-12';
		} else {
			$site_layout = simple_life_get_option( 'site_layout' );

			if ( 'content-sidebar' === $site_layout ) {
				$input[] = 'col-sm-8';
				$input[] = 'pull-left';
			} else if ( 'sidebar-content' === $site_layout ) {
				$input[] = 'col-sm-8';
				$input[] = 'pull-right';
			} else if ( 'full-width' === $site_layout ) {
				$input[] = 'col-sm-12';
			}
		}

		// For Mobile.
		$input[] = 'col-xs-12';

		return $input;
	}
endif;
add_filter( 'simple_life_filter_content_class', 'simple_life_custom_content_classes' );


if ( ! function_exists( 'simple_life_custom_sidebar_classes' ) ) :
	/**
	 * Modify sidebar classes.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $input Array of sidebar classes.
	 * @return array Modified array of sidebar classes.
	 */
	function simple_life_custom_sidebar_classes( $input ) {

		if ( is_page_template( 'template/content-sidebar.php' ) ) {
			$input[] = 'col-sm-4';
		} else if ( is_page_template( 'template/sidebar-content.php' ) ) {
			$input[] = 'col-sm-4';
		} else if ( is_page_template( 'template/full-width.php' ) ) {
			$input[] = 'hidden';
		} else {

			$site_layout = simple_life_get_option( 'site_layout' );

			if ( 'content-sidebar' === $site_layout ) {
				$input[] = 'col-sm-4';
			} else if ( 'sidebar-content' === $site_layout ) {
				$input[] = 'col-sm-4';
			} else if ( 'full-width' === $site_layout ) {
				$input[] = 'hidden';
			}
		}

		return $input;
	}
endif;
add_filter( 'simple_life_filter_sidebar_class', 'simple_life_custom_sidebar_classes' );


if ( ! function_exists( 'simple_life_custom_post_classes' ) ) :
	/**
	 * Modify post classes.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $input Array of post classes.
	 * @return array Modified array of post classes.
	 */
	function simple_life_custom_post_classes( $input ) {

		if ( 'post' === get_post_type() ) {
			$content_layout = simple_life_get_option( 'content_layout' );
			if ( 'full' === $content_layout ) {
				$input[] = 'content-layout-full';
			} else if ( 'excerpt' === $content_layout ) {
				$input[] = 'content-layout-excerpt';
			} else if ( 'excerpt-thumb' === $content_layout ) {
				$input[] = 'content-layout-excerpt-thumb';
			}
		}
		return $input;

	}
endif;

add_filter( 'post_class', 'simple_life_custom_post_classes' );

if ( ! function_exists( 'simple_life_custom_excerpt_length' ) ) :

	/**
	 * Implement excerpt length.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length The number of words.
	 * @return int Excerpt length.
	 */
	function simple_life_custom_excerpt_length( $length ) {
		$excerpt_length = simple_life_get_option( 'excerpt_length' );
		$excerpt_length = apply_filters( 'simple_life_filter_excerpt_length', esc_attr( $excerpt_length ) );
		if ( empty( $excerpt_length ) ) {
			$excerpt_length = $length;
		}
		return $excerpt_length;
	}

endif;

add_filter( 'excerpt_length', 'simple_life_custom_excerpt_length', 999 );

if ( ! function_exists( 'simple_life_excerpt_readmore' ) ) :
	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function simple_life_excerpt_readmore( $more ) {
		global $post;

		$flag_apply_excerpt_readmore = apply_filters( 'simple_life_filter_excerpt_readmore', true );
		if ( true !== $flag_apply_excerpt_readmore ) {
			return $more;
		}

		$read_more_text = simple_life_get_option( 'read_more_text' );
		if ( empty( $read_more_text ) ) {
			return $more;
		}
		$output = '... <a href="'. esc_url( get_permalink( $post->ID ) ) . '" class="readmore">' . esc_attr( $read_more_text )  . '<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span><span class="fa fa-angle-double-right" aria-hidden="true"></span></a>';
		$output = apply_filters( 'simple_life_filter_read_more_content' , $output );
		return $output;
	}
endif;
add_filter( 'excerpt_more', 'simple_life_excerpt_readmore' );

if ( ! function_exists( 'simple_life_add_go_to_top' ) ) :
	/**
	 * Add go to top icon.
	 *
	 * @since 1.0.0
	 */
	function simple_life_add_go_to_top() {

		$go_to_top = simple_life_get_option( 'go_to_top' );
		if ( true !== $go_to_top ) {
			return;
		}
		echo '<a href="#" class="scrollup" id="btn-scrollup"><span class="fa-stack"> <i class="fa fa-square fa-stack-2x" aria-hidden="true"></i><i class="fa fa-angle-up fa-stack-1x fa-inverse" aria-hidden="true"></i></span><span class="screen-reader-text">' . __( 'Go to top', 'simple-life' ) . '</span></a>';

	}
endif;
add_action( 'wp_footer', 'simple_life_add_go_to_top' );

if ( ! function_exists( 'simple_life_custom_content_width' ) ) :

	/**
	 * Custom content width.
	 *
	 * @since 1.3
	 */
	function simple_life_custom_content_width() {

		global $post, $content_width;
		if ( is_page() ) {
			if ( is_page_template( 'template/full-width.php' ) ) {
				$content_width = 1128;
			} elseif ( is_page_template( array( 'template/content-sidebar.php', 'template/sidebar-content.php' ) ) ) {
				$content_width = 800;
			}
		}
	}
endif;

add_filter( 'template_redirect', 'simple_life_custom_content_width' );

/**
 * Import existing logo URL and set it to Custom Logo.
 *
 * @since 1.8
 */
function simple_life_import_logo_field() {

    // Bail if Custom Logo feature is not available.
    if ( ! function_exists( 'the_custom_logo' ) ) {
        return;
    }

    // Fetch old logo URL.
    $site_logo = simple_life_get_option( 'site_logo' );

    // Bail if there is no existing logo.
    if ( empty( $site_logo ) ) {
        return;
    }

    // Get attachment ID.
    $attachment_id = attachment_url_to_postid( $site_logo );

    if ( $attachment_id > 0 ) {
        // We got valid attachment ID.
        set_theme_mod( 'custom_logo', $attachment_id );
        // Remove old logo value.
        $all_options = simple_life_get_options();
        $all_options['site_logo'] = '';
        set_theme_mod( 'simple_life_options', $all_options );

    }

}
add_action( 'after_setup_theme', 'simple_life_import_logo_field', 20 );

if ( ! function_exists( 'simple_life_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.9
	 */
	function simple_life_add_breadcrumb() {

		// Bail if Home Page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		// Bail if Breadcrumb disabled.
		$enable_breadcrumb = simple_life_get_option( 'enable_breadcrumb' );

		if ( true !== $enable_breadcrumb ) {
			return;
		}

		echo '<div id="breadcrumb"><div class="container"><div class="row"><div class="col-sm-12">';

		$breadcrumb_args = array(
			'show_trail_end' => true,
			'labels'         => array(
				'title' => '',
			),
		);

		\Hybrid\Breadcrumbs\Trail::display( $breadcrumb_args );

		echo '</div><!-- .col-sm-12 --></div></div><!-- .row --></div><!-- .container --></div><!-- #breadcrumb -->';

	}

endif;

add_action( 'simple_life_action_after_header', 'simple_life_add_breadcrumb' );


/**
 * Add admin notice.
 *
 * @since 2.5.1
 */
function simple_life_add_admin_notice() {
	// Setup notice.
	\Nilambar\AdminNotice\Notice::init(
		array(
			'slug' => 'simple-life',
			'type' => 'theme',
			'name' => esc_html__( 'Simple Life', 'simple-life' ),
		)
	);
}

add_action( 'admin_init', 'simple_life_add_admin_notice' );
