<?php
  /**
  *theme specifics
  **/
  //functions
  require_once(dirname(__FILE__) . '/theme-specifics/functions/filetypes.php');
  require_once(dirname(__FILE__) . '/theme-specifics/functions/custom-functions.php');

  //post types
  require_once(dirname(__FILE__) . '/theme-specifics/post-types/custom-post-types.php');

  //shortcodes
  require_once(dirname(__FILE__) . '/theme-specifics/shortcodes/shortcodes.php');

  //enqueue
  require_once(dirname(__FILE__) . '/theme-specifics/enqueue/enqueue.php');
  //wp_register_script( 'youtube-api', '//www.youtube.com/iframe_api', array('main'), null, true );
?>
