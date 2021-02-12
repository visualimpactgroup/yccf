<section class="column-content main-content">
  <div class="search-block">
    <?php echo post_search( null, 'Search Our Blog', 'post'); ?>
  </div>

  <div class="block">
    <div class="column-title">
      Recent Articles & News
    </div>
    <ul>
      <?php
      $post_id = get_the_ID();

      query_posts(array(
        'category_name' 	=> 'news',
        'showposts' 			=> 4,
        'post_status' 		=> 'publish',
        'post__not_in' 		=> array($post_id),
        'orderby'         => 'date',
        'order'           => 'DESC',
      ));
      while ( have_posts() ) : the_post();
        $title 				= get_the_title();
        $permalink 		= get_the_permalink();
        echo '<li><a href="'.$permalink.'" title="'.$title.'">'.$title.'</a></li>';
      endwhile;
      wp_reset_query();
      ?>
    </ul>
  </div>

  <div class="block">
    <div class="column-title">
      Categories
    </div>
    <ul>
      <?php
      $categories = get_categories();
      foreach($categories as $category) {
       echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
      }
      ?>
    </ul>
  </div>
</section>
