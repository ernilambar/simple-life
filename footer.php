<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Simple_Life
 */

?>
    </div> <!-- .row -->
	</div><!-- #content -->

	<?php do_action( 'simple_life_action_before_footer' ); ?>

	<footer id="colophon" class="site-footer container" role="contentinfo">

		<?php
		$footer_nav = wp_nav_menu( array(
			'theme_location'  => 'footer',
			'depth'           => 1,
			'container'       => 'div',
			'container_class' => 'footer-nav-wrapper',
			'menu_class'      => 'footer-nav',
			'fallback_cb'     => '',
			'link_after'      => '',
			'echo'            => false,
			)
		);
		?>
		<?php if ( ! empty( $footer_nav ) ) : ?>
			<nav class="social-navigation" role="navigation" aria-label="<?php _e( 'Footer Menu', 'simple-life' ); ?>">
			<?php echo $footer_nav; ?>
			</nav>
		<?php endif ?>

	<?php
	$copyright_text = simple_life_get_option( 'copyright_text' );
	?>
	<?php if ( ! empty( $copyright_text ) ) : ?>

    <div id="copyright-wrap">
      <div class="copyright-text"><?php echo wp_kses_post( $copyright_text ); ?></div>
    </div>

	<?php endif ?>

	<?php
		$powered_by = simple_life_get_option( 'powered_by' );
	?>

	<?php if ( true === $powered_by ) : ?>

  		<div class="site-info" id="powered-by-wrap">
  			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'simple-life' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'simple-life' ), 'WordPress' ); ?></a>
  			<span class="sep"> | </span>
  			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'simple-life' ), 'Simple Life', '<a href="' . esc_url( 'http://nilambar.net/' ) . '" rel="designer">Nilambar</a>' ); ?>
  		</div><!-- .site-info -->

	<?php endif ?>

	</footer><!-- #colophon -->
	<?php do_action( 'simple_life_action_after_footer' ); ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
