<?php
/**
 * Theme functions and definitions
 *
 * @package Simple_Life
 */

if ( ! defined( 'SIMPLE_LIFE_VERSION' ) ) {
	define( 'SIMPLE_LIFE_VERSION', '3.0.0' );
}

// Load autoload.
if ( file_exists( get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
	require_once get_parent_theme_file_path( 'vendor/autoload.php' );
	require_once get_parent_theme_file_path( 'vendor/ernilambar/wp-welcome/init.php' );
	require_once get_parent_theme_file_path( 'vendor/wptt/webfont-loader/wptt-webfont-loader.php' );
}

if ( ! function_exists( 'simple_life_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function simple_life_setup() {

		global $content_width;

		/**
		 * Set the content width based on the theme's design and stylesheet.
		 */
		if ( ! isset( $content_width ) ) {
			$content_width = 800;
		}

		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'simple-life' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Enable support for Title Tag.
		*/
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		/*
		 * Enable support for partial refresh in Customizer widgets.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'simple-life' ),
				'footer'  => esc_html__( 'Footer Menu', 'simple-life' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		/*
		 * Enable support for Post Formats.
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'audio',
				'quote',
				'status',
				'link',
				'chat',
				'gallery',
			)
		);

		// Editor style.
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		add_editor_style( 'css/editor-style' . $min . '.css', wptt_get_webfont_url( 'https://fonts.googleapis.com/css?family=Open+Sans' ) );

		// Setup the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'simple_life_custom_background_args',
				array(
					'default-color' => 'f0f3f5',
					'default-image' => '',
				)
			)
		);

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Load Supports.
		require get_template_directory() . '/inc/supports.php';

		global $simple_life_default_options;
		$simple_life_default_options = simple_life_get_theme_option_defaults();
	}
endif;

add_action( 'after_setup_theme', 'simple_life_setup' );

/**
 * Register widget area.
 */
function simple_life_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'simple-life' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'simple-life' ),
			'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'simple_life_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function simple_life_scripts() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'simple-life-style-open-sans', wptt_get_webfont_url( 'https://fonts.googleapis.com/css?family=Open+Sans' ), array(), SIMPLE_LIFE_VERSION );
	wp_enqueue_style( 'simple-life-style-bootstrap', get_template_directory_uri() . '/third-party/bootstrap/css/bootstrap' . $min . '.css', false, '3.3.6' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/third-party/font-awesome/css/font-awesome' . $min . '.css', false, '4.7.0' );
	wp_enqueue_style( 'simple-life-style-meanmenu', get_template_directory_uri() . '/third-party/meanmenu/meanmenu' . $min . '.css', false, '2.0.8' );

	wp_enqueue_style( 'simple-life-style', get_stylesheet_uri(), array(), SIMPLE_LIFE_VERSION );

	wp_enqueue_script( 'simple-life-navigation', get_template_directory_uri() . '/js/navigation' . $min . '.js', array(), SIMPLE_LIFE_VERSION, true );

	wp_enqueue_script( 'simple-life-meanmenu-script', get_template_directory_uri() . '/third-party/meanmenu/jquery.meanmenu' . $min . '.js', array( 'jquery' ), '2.0.8', true );
	wp_enqueue_script( 'simple-life-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery', 'simple-life-meanmenu-script' ), SIMPLE_LIFE_VERSION, true );

	wp_localize_script(
		'simple-life-custom',
		'simpleLifeScreenReaderText',
		array(
			'expand'   => esc_html__( 'expand menu', 'simple-life' ),
			'collapse' => esc_html__( 'collapse menu', 'simple-life' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'simple_life_scripts' );

/**
 * Include helper.
 */
require get_template_directory() . '/inc/helper.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom theme functions.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Custom theme custom.
 */
require get_template_directory() . '/inc/theme-custom.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load welcome.
 */
require get_template_directory() . '/inc/welcome/welcome.php';

/**
 * Third Party Compatibility.
 */
if ( class_exists( 'WooCommerce', false ) ) {
	require get_template_directory() . '/support/woocommerce.php';
}
