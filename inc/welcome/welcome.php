<?php
/**
 * Welcome
 *
 * @package Simple_Life
 */

use Nilambar\Welcome\Welcome;

add_action(
	'wp_welcome_init',
	function () {
		$obj = new Welcome( 'theme', 'simple-life' );

		$obj->set_page(
			array(
				'menu_title'    => esc_html__( 'Simple Life', 'simple-life' ),
				'page_title'    => esc_html__( 'Simple Life', 'simple-life' ),
				/* translators: %s: Version. */
				'page_subtitle' => sprintf( esc_html__( 'Version: %s', 'simple-life' ), SIMPLE_LIFE_VERSION ),
				'menu_slug'     => 'simple-life-welcome',
				'parent_page'   => 'themes.php',
			)
		);

		$obj->set_admin_notice(
			array(
				'screens' => array( 'themes', 'dashboard' ),
			)
		);

		$obj->set_quick_links(
			array(
				array(
					'text' => 'Theme Details',
					'url'  => 'https://www.nilambar.net/2015/03/simple-life-free-wordpress-theme.html',
					'type' => 'primary',
				),
				array(
					'text' => 'Get Support',
					'url'  => 'https://wordpress.org/support/theme/simple-life/#new-post',
					'type' => 'secondary',
				),
				array(
					'text' => 'Leave a Review',
					'url'  => 'https://wordpress.org/support/theme/simple-life/reviews/#new-post',
					'type' => 'secondary',
				),
			)
		);

		$obj->add_tab(
			array(
				'id'    => 'getting-started',
				'title' => 'Getting Started',
				'type'  => 'grid',
				'items' => array(
					array(
						'title'       => 'Theme Options',
						'icon'        => 'dashicons dashicons-admin-customizer',
						'description' => 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.',
						'button_text' => 'Go to Customizer',
						'button_url'  => wp_customize_url(),
						'button_type' => 'primary',
					),
					array(
						'title'       => 'Get Support',
						'icon'        => 'dashicons dashicons-editor-help',
						'description' => 'Got theme support question or found bug or got some feedbacks? Please visit support forum in the WordPress.org directory.',
						'button_text' => 'Visit Support',
						'button_url'  => 'https://wordpress.org/support/theme/simple-life/#new-post',
						'button_type' => 'secondary',
						'is_new_tab'  => true,
					),
					array(
						'title'       => 'Recommended Plugins',
						'icon'        => 'dashicons dashicons-admin-plugins',
						'description' => '<ul>
													<li><a href="https://wordpress.org/plugins/woocommerce-product-tabs/" target="_blank">WooCommerce Product Tabs</a></li>
													<li><a href="https://wordpress.org/plugins/post-grid-elementor-addon/" target="_blank">Post Grid Elementor Addon</a></li>
													<li><a href="https://wordpress.org/plugins/advanced-google-recaptcha/" target="_blank">Advanced Google reCAPTCHA</a></li>
													<li><a href="https://wordpress.org/plugins/admin-customizer/" target="_blank">Admin Customizer</a></li>
													<li><a href="https://wordpress.org/plugins/nifty-coming-soon-and-under-construction-page/" target="_blank">Coming Soon & Maintenance Mode Page</a></li>
												</ul>',
					),
					array(
						'title'       => 'Recommended Themes',
						'icon'        => 'dashicons dashicons-desktop',
						'description' => '<ul><li><a href="https://wordpress.org/themes/simple-life/" target="_blank">Simple Life</a></li> <li><a href="https://wordpress.org/themes/obulma/" target="_blank">Obulma</a></li> <li><a href="https://wordpress.org/themes/blue-planet/" target="_blank">Blue Planet</a></li></ul>',
					),
				),
			)
		);

		$obj->set_sidebar(
			array(
				'render_callback' => 'simple_life_render_welcome_page_sidebar',
			)
		);

		$obj->run();
	}
);

/**
 * Return blog posts list.
 *
 * @since 1.0.0
 *
 * @return array Posts list.
 */
function simple_life_get_blog_feed_items() {
	$output = array();

	$rss = fetch_feed( 'https://www.nilambar.net/category/wordpress/feed' );

	$maxitems = 0;

	$rss_items = array();

	if ( ! is_wp_error( $rss ) ) {
		$maxitems  = $rss->get_item_quantity( 5 );
		$rss_items = $rss->get_items( 0, $maxitems );
	}

	if ( ! empty( $rss_items ) ) {
		foreach ( $rss_items as $item ) {
			$feed_item = array();

			$feed_item['title'] = $item->get_title();
			$feed_item['url']   = $item->get_permalink();

			$output[] = $feed_item;
		}
	}

	return $output;
}

/**
 * AJAX callback for blog posts.
 *
 * @since 1.0.0
 */
function simple_life_get_blog_posts_ajax_callback() {
	$output = array();

	$posts = simple_life_get_blog_feed_items();

	if ( ! empty( $posts ) ) {
		$output = $posts;
	}

	if ( ! empty( $output ) ) {
		wp_send_json_success( $output, 200 );
	} else {
		wp_send_json_error( $output, 404 );
	}
}

add_action( 'wp_ajax_nopriv_simple_life_nsbl_get_posts', 'simple_life_get_blog_posts_ajax_callback' );
add_action( 'wp_ajax_simple_life_nsbl_get_posts', 'simple_life_get_blog_posts_ajax_callback' );

/**
 * Render welcome page sidebar.
 *
 * @since 1.0.0
 *
 * @param Welcome $obj Instance of Welcome class.
 */
function simple_life_render_welcome_page_sidebar( $obj ) {
	$obj->render_sidebar_box(
		array(
			'title'        => 'Leave a Review',
			'content'      => $obj->get_stars() . sprintf( 'Are you are enjoying %s? We would appreciate a review.', $obj->get_name() ),
			'button_text'  => 'Submit Review',
			'button_url'   => 'https://wordpress.org/support/theme/simple-life/reviews/#new-post',
			'button_class' => 'button',
		),
		$obj
	);

	$obj->render_sidebar_box(
		array(
			'title'   => 'Recent Blog Posts',
			'content' => '<div class="ns-blog-list"></div>',
		),
		$obj
	);
}

/**
 * Load admin page assets.
 *
 * @since 1.0.0
 *
 * @param string $hook Hook name.
 */
function simple_life_load_welcome_assets( $hook ) {
	if ( 'appearance_page_simple-life-welcome' !== $hook ) {
		return;
	}

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'simple-life-blog-posts', get_template_directory_uri() . '/js/blog-posts' . $min . '.js', array( 'jquery' ), SIMPLE_LIFE_VERSION, true );
}

add_action( 'admin_enqueue_scripts', 'simple_life_load_welcome_assets' );
