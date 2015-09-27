<?php
/**
 * The sidebar containing the main widget areas.
 *
 * @package Simple_Life
 */

?>
	<div id="secondary" <?php echo simple_life_sidebar_class( 'widget-area container clearfix' ); ?> role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<?php

		// Search Widget.
		$args = array(
		  'before_title'  => '<h3 class="widget-title">',
		  'after_title'   => '</h3>',
		);
		the_widget( 'WP_Widget_Search', array(), $args );

		// Archives Widget.
		$args = array(
		  'before_title'  => '<h3 class="widget-title">',
		  'after_title'   => '</h3>',
		);
		the_widget( 'WP_Widget_Archives', array(), $args );

		// Meta Widget.
		$args = array(
		  'before_title'  => '<h3 class="widget-title">',
		  'after_title'   => '</h3>',
		);
		the_widget( 'WP_Widget_Meta', array(), $args );

		?>

		<?php endif; // End sidebar widget area. ?>
	</div><!-- #secondary -->
