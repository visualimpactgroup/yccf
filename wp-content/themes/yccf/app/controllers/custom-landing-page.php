<?php

namespace App;

use Sober\Controller\Controller;

class LandingPage extends Controller
{
  // hero section
  public function landing_page()
  {
    return (object) array(
      'maintitle'         => get_field('main_title'),
      'maincontent'       => get_field('main_title_content'),
      'mainimage'         => get_field('main_image'),
      'mainlink'          => get_field('main_link'),
    );
  }
}
