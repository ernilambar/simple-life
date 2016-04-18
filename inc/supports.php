<?php
/**
 * Theme supports.
 *
 * @package Simple_Life
 */

// Load Footer Widget Support.
require_if_theme_supports( 'footer-widgets', get_template_directory() . '/inc/supports/footer-widgets.php' );
