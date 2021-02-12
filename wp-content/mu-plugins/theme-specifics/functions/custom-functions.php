<?php
function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyBrVsSbgwd9ep-Gf7Es5z25mvB0denWxqU';
	return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyBrVsSbgwd9ep-Gf7Es5z25mvB0denWxqU');
}

add_action('acf/init', 'my_acf_init');


function page_in_menu( $menu = null, $object_id = null ) {
    $menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );
    if( ! $menu_object )
        return false;
    $menu_items = wp_list_pluck( $menu_object, 'object_id' );
    if( !$object_id ) {
        global $post;
        $object_id = get_queried_object_id();
    }
    return in_array( (int) $object_id, $menu_items );
}





add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
function my_wp_nav_menu_objects( $items, $args ) {
	// loop
	foreach( $items as $item ) {
		// vars
		$icon = get_field('page_icon', $item);
		// append icon
		if( $icon ) {
			$item->title.='<icon class="icon-'.$icon.'"></icon>';
		}
	}

	// return
	return $items;
}


function enollo_pagination( $args = array() ) {
	$defaults = array(
		'echo' => true,
		'query' => $GLOBALS['wp_query'],
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('Previous', 'enollo'),
		'next_text' => __('Next Page', 'enollo'),
	);

	$args = wp_parse_args( $args, $defaults );
	extract($args, EXTR_SKIP);
	// Stop execution if there's only 1 page
	if( $query->max_num_pages <= 1 ) {
		return;
	}

	$pagination = '';
	$links = array();

	$paged = max( 1, absint( $query->get( 'paged' ) ) );
	$max   = intval( $query->max_num_pages );

	if ( $show_all ) {
		$links = range(1, $max);
	} else {
		// Add the pages before the current page to the array
		if ( $paged >= 2 + 1 ) {
			$links[] = $paged - 2;
			$links[] = $paged - 1;
		}

		// Add current page to the array
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		// Add the pages after the current page to the array
		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 1;
			$links[] = $paged + 2;
		}
	}

	$pagination .= "\n" . '<nav class="pagination is-right" role="navigation" aria-label="pagination">' . "\n";
	// Previous Post Link
	if ( $prev_next && get_previous_posts_link() ) {
    $pagination .= sprintf( '<div class="pagination-previous">%s</div>', get_previous_posts_link($prev_text . '<span class="screen-reader-text">' . $prev_text . '</span>') );
    //$pagination .= sprintf( '<a class="pagination-previous prev">' . $prev_text . '</a>', get_previous_posts_link('<span class="screen-reader-text">' . $prev_text . '</span>') );
	}

  // Next Post Link
	if ( $prev_next && get_next_posts_link() && $paged <= $max ) {
		$pagination .= sprintf( '<div class="pagination-next">%s</div>' . "\n", get_next_posts_link($next_text . '<span class="screen-reader-text">' . $next_text . '</span>') );
	}

	$pagination .= "\n" . '<ul class="pagination-list">';
	// Link to first page, plus ellipses if necessary
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';
		$pagination .= sprintf( '<li%s><a class="pagination-link" href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );
		$pagination .= "\n";
		if ( ! in_array( 2, $links ) ) {
			$pagination .= '<li class="ellipsis"><span>' . __( '&hellip;' ) . '</span></li>';
		}
		$pagination .= "\n";
	}
	// Link to current page, plus $mid_size pages in either direction if necessary
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		$pagination .= sprintf( '<li%s><a class="pagination-link" href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );
		$pagination .= "\n";
	}
	// Link to last page, plus ellipses if necessary
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) ) {
			$pagination .= '<li><span class="pagination-ellipsis">' . __( '&hellip;' ) . '</span></li>';
			$pagination .= "\n";
		}
		$class = $paged == $max ? ' class="active"' : '';
		$pagination .= sprintf( '<li%s><a class="pagination-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		$pagination .= "\n";
	}

	$pagination .= "</ul></nav><!-- /.pagination -->\n";

	if ( $echo ) {
		echo $pagination;
	} else {
		return $pagination;
	}
}




function post_search( $form, $value = "Search Our Blog", $post_type = 'post' ) {
    $form_value = (isset($value)) ? $value : attribute_escape(apply_filters('the_search_query', get_search_query()));
    $searchicon = get_field('search_icon', 'cpt_sitew');
    $form = '
    <form class="search-styles" method="get" id="post-searchform" action="' . get_option('home') . '/" >
      <div class="inpage-search">
        <div class="search-form">
          <div class="positioned">
            <label class="search-for">
              <span class="screen-reader-text">Search for:</span>
              <input type="hidden" name="post_type" value="'.$post_type.'" />
              <input type="search" class="search-field input input--search" placeholder="' . $form_value . '" id="s" value="" name="s" title="Search for:">
            </label>
            <button type="submit" id="searchsubmit">
              '.$searchicon.'
              <span class="screen-reader-text">Search</span>
            </button>
          </div>
        </div>
      </div>
    </form>
    ';
    return $form;
}


function fund_search() {
	$searchicon = get_field('search_icon', 'cpt_sitew');
	$fundform = '
  <div class="search-styles">
    <div class="inpage-search">
      <div class="search-form">
        <div class="positioned">
          <label class="search-for">
            <span class="screen-reader-text">Search for:</span>
						<input type="text" id="search-input" class="search-field input input--search" placeholder="Search for funds.." title="Search for:">
          </label>
          <button type="submit" id="searchsubmit">
            '.$searchicon.'
            <span class="screen-reader-text">Search</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  ';
  return $fundform;
}


function get_video_thumbnail_uri( $video_uri ) {

		$thumbnail_uri = '';



		// determine the type of video and the video id
		$video = parse_video_uri( $video_uri );



		// get youtube thumbnail
		if ( $video['type'] == 'youtube' )
			$thumbnail_uri = 'http://img.youtube.com/vi/' . $video['id'] . '/hqdefault.jpg';

		// get vimeo thumbnail
		if( $video['type'] == 'vimeo' )
			$thumbnail_uri = get_vimeo_thumbnail_uri( $video['id'] );
		// get wistia thumbnail
		if( $video['type'] == 'wistia' )
			$thumbnail_uri = get_wistia_thumbnail_uri( $video_uri );
		// get default/placeholder thumbnail
		if( empty( $thumbnail_uri ) || is_wp_error( $thumbnail_uri ) )
			$thumbnail_uri = '';

		//return thumbnail uri
		return $thumbnail_uri;

	}


	/**
	 * Parse the video uri/url to determine the video type/source and the video id
	 */
	function parse_video_uri( $url ) {

		// Parse the url
		$parse = parse_url( $url );

		// Set blank variables
		$video_type = '';
		$video_id = '';

		// Url is http://youtu.be/xxxx
		if ( $parse['host'] == 'youtu.be' ) {

			$video_type = 'youtube';

			$video_id = ltrim( $parse['path'],'/' );

		}

		// Url is http://www.youtube.com/watch?v=xxxx
		// or http://www.youtube.com/watch?feature=player_embedded&v=xxx
		// or http://www.youtube.com/embed/xxxx
		if ( ( $parse['host'] == 'youtube.com' ) || ( $parse['host'] == 'www.youtube.com' ) ) {

			$video_type = 'youtube';

			parse_str( $parse['query'] );

			$video_id = $v;

			if ( !empty( $feature ) )
				$video_id = end( explode( 'v=', $parse['query'] ) );

			if ( strpos( $parse['path'], 'embed' ) == 1 )
				$video_id = end( explode( '/', $parse['path'] ) );

		}

		// Url is http://www.vimeo.com
		if ( ( $parse['host'] == 'vimeo.com' ) || ( $parse['host'] == 'www.vimeo.com' ) ) {

			$video_type = 'vimeo';

			$video_id = ltrim( $parse['path'],'/' );

		}
		$host_names = explode(".", $parse['host'] );
		$rebuild = ( ! empty( $host_names[1] ) ? $host_names[1] : '') . '.' . ( ! empty($host_names[2] ) ? $host_names[2] : '');
		// Url is an oembed url wistia.com
		if ( ( $rebuild == 'wistia.com' ) || ( $rebuild == 'wi.st.com' ) ) {

			$video_type = 'wistia';

			if ( strpos( $parse['path'], 'medias' ) == 1 )
					$video_id = end( explode( '/', $parse['path'] ) );

		}

		// If recognised type return video array
		if ( !empty( $video_type ) ) {

			$video_array = array(
				'type' => $video_type,
				'id' => $video_id
			);

			return $video_array;

		} else {

			return false;

		}

	}


	 /* Takes a Vimeo video/clip ID and calls the Vimeo API v2 to get the large thumbnail URL.
	 */
	function get_vimeo_thumbnail_uri( $clip_id ) {
		$vimeo_api_uri = 'http://vimeo.com/api/v2/video/' . $clip_id . '.php';
		$vimeo_response = wp_remote_get( $vimeo_api_uri );
		if( is_wp_error( $vimeo_response ) ) {
			return $vimeo_response;
		} else {
			$vimeo_response = unserialize( $vimeo_response['body'] );
			return $vimeo_response[0]['thumbnail_large'];
		}

	}
	/**
	 * Takes a wistia oembed url and gets the video thumbnail url.
	 */
	function get_wistia_thumbnail_uri( $video_uri ) {
		if ( empty($video_uri) )
			return false;
		$wistia_api_uri = 'http://fast.wistia.com/oembed?url=' . $video_uri;
		$wistia_response = wp_remote_get( $wistia_api_uri );
		if( is_wp_error( $wistia_response ) ) {
			return $wistia_response;
		} else {
			$wistia_response = json_decode( $wistia_response['body'], true );
			return $wistia_response['thumbnail_url'];
		}

	}



	function uam_user_in_group($groupName='', $userId='') {
		if (empty($userId)) {
			$userId = get_current_user_id();
		}

	    global $userAccessManager;
	    if (isset($userAccessManager)) {
	        $uamAccessHandler 	= $userAccessManager->getAccessHandler();
	        $userGroupsForUser 	= $uamAccessHandler->getUserGroupsForObject('_user_', $userId);
	        foreach($userGroupsForUser as $element) {
	            if ($element->getName() == $groupName) {
	                return true;
	            }
	        }
	    } else {
	        return false;
	    }
	}


	//fatal error check
	function vig_fatlity_function($log, $file, $line) {
    date_default_timezone_set('America/New_York');
    $message = '['.date('D M j Y g:i a').'] '.$log;
    $headers = 'From: noreply@yccf.org'."\r\n".
        //'Cc: gmigash@visimpact.com'."\r\n".
        'X-Mailer: PHP/'.phpversion();
    mail('webtech@visimpact.com', 'Fatal Error: '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], $message, $headers);
	}

	define( 'WPCF7_AUTOP', false );

?>
