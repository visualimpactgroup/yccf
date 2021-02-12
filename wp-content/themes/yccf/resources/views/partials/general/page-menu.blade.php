<?php
  if($post->post_parent):
    $children = wp_list_pages('title_li=&child_of='.$post->post_parent.'&echo=0');
  else:
    $children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0');
  endif;

  if(page_in_menu('main nav', $post->post_parent)){
    if ($children) {
      echo '<nav class="solid-dropdown is-hidden-touch">';
      echo '<ul class="subpage-list">'.$children.'</ul>';
      echo '</nav>';
    }
  }
?>
