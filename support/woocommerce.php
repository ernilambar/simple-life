<?php
add_theme_support( 'woocommerce' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'simple_life_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'simple_life_theme_wrapper_end', 10);

function simple_life_theme_wrapper_start() {
  echo '<section id="primary"';
  echo simple_life_content_class('content-area');
  echo ' >';
  echo '<main role="main" class="site-main" id="main">';
}

function simple_life_theme_wrapper_end() {
  echo '</main>';
  echo '</section>';
}
