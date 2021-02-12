<?php
function custom_scripts() {
  wp_enqueue_style( 'icon-library', 'https://s3.amazonaws.com/icomoon.io/141886/VIGIconLibrary/style.css?not2pc', array(), '1.0', 'all');
  wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBrVsSbgwd9ep-Gf7Es5z25mvB0denWxqU');
  //wp_enqueue_script('google-map', get_template_directory_uri() .'/assets/scripts/routes/google-maps.js');
  wp_enqueue_style( 'site-overrides', get_template_directory_uri() .'/assets/styles/overrides.css');
  wp_enqueue_script('youtube-api', '//www.youtube.com/iframe_api');
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

?>
