<?php

namespace App;

use Sober\Controller\Controller;

class App extends Controller
{
    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }


    // global fields
    public function globalvalue()
    {

      $copyright = '&copy; ' . date('Y') .'. '. get_bloginfo('name') . '. All Rights Reserved.';
      $thumbnail = get_the_post_thumbnail();

      return (object) array(
        'sitecopyright'     => $copyright,
        'hlogo'             => get_field('logo', 'cpt_sitew'),
        'addressicon'       => get_field('address_icon', 'cpt_sitew'),
        'address'           => get_field('address', 'cpt_sitew'),
        'city'              => get_field('city', 'cpt_sitew'),
        'state'             => get_field('state', 'cpt_sitew'),
        'zip'               => get_field('zip', 'cpt_sitew'),
        'map'               => get_field('location_map', 'cpt_sitew'),
        'phoneicon'         => get_field('phone_icon', 'cpt_sitew'),
        'yorkphone'         => get_field('york_phone', 'cpt_sitew'),
        'hanoverphone'      => get_field('hanover_phone', 'cpt_sitew'),
        'faxicon'           => get_field('fax_icon', 'cpt_sitew'),
        'fax'               => get_field('fax', 'cpt_sitew'),
        'emailicon'         => get_field('email_icon', 'cpt_sitew'),
        'email'             => get_field('email_address', 'cpt_sitew'),
        'hours'             => get_field('hours_of_operation', 'cpt_sitew'),
        'day'               => get_sub_field('day', 'cpt_sitew'),
        'time'              => get_sub_field('time', 'cpt_sitew'),
        'enewsicon'         => get_field('enews_icon', 'cpt_sitew'),
        'enewstitle'        => get_field('enews_title', 'cpt_sitew'),
        'enewscontent'      => get_field('enews_content', 'cpt_sitew'),
        'morebefore'        => get_field('more_link_before', 'cpt_sitew'),
        'moreafter'         => get_field('more_link_after', 'cpt_sitew'),
        'searchicon'        => get_field('search_icon', 'cpt_sitew'),
        'locationicon'      => get_field('location_icon', 'cpt_sitew'),
        'blogplaceholder'   => get_field('blog_placeholder', 'cpt_sitew'),
        'returnarrow'       => get_field('return_arrow', 'cpt_sitew'),
        'videobg'           => get_field('video_background', 'cpt_sitew'),
        'car'               => get_field('car_icon', 'cpt_sitew'),
        'pageicon'          => get_field('page_icon'),
        'placeimg'          => 'http://via.placeholder.com/',
        'featuredimg'       => $thumbnail,
        'shortcode'         => get_field('shortcode'),
        'imagepath'         => get_template_directory(),
      );
    }

    //
    public function internal_page()
    {
      return (object) array(
        'headerimage'       => get_field('header_image'),
        'headertitle'       => get_field('header_title'),
        'headercontent'     => get_field('header_content')
      );
    }

}
