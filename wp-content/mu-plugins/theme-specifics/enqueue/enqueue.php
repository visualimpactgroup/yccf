<?php

add_action('wp_head', function () {
  global $wp_scripts;

  foreach ($wp_scripts->queue as $handle) {
    $script = $wp_scripts->registered[$handle];
    $source = $script->src . ($script->ver ? "?ver={$script->ver}" : "");
    echo "<link rel='preload' href='{$source}' as='script'/>\n";
  }
}, 1);

function custom_scripts() {
  //wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBrVsSbgwd9ep-Gf7Es5z25mvB0denWxqU');
  //wp_enqueue_script('google-map', get_template_directory_uri() .'/assets/scripts/routes/google-maps.js');
  wp_enqueue_style( 'site-overrides', get_template_directory_uri() .'/assets/styles/overrides.css');
  wp_enqueue_script('youtube-api', '//www.youtube.com/iframe_api');
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );


add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
function my_enqueue_scripts() {
  wp_enqueue_style('icon-library', 'https://s3.amazonaws.com/icomoon.io/141886/VIGIconLibrary/style.css?not2pc', array(), null);
}
add_filter('style_loader_tag', 'my_style_loader_tag_filter', 10, 2);

function my_style_loader_tag_filter($html, $handle) {
  if ($handle === 'icon-library') {
    return str_replace("rel='stylesheet'", "rel='preload' as='font'", $html);
  }
  return $html;
}

?>
