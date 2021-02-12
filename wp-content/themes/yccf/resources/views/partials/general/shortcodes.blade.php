<?php
$shortcode = get_field('shortcode');
if($shortcode):
  echo '<section class="main-content">';
  echo do_shortcode($shortcode);
  echo '</section>';
endif;
?>
