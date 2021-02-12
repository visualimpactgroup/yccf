<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
  // hero section
  public function hero_section()
  {
    return (object) array(
      'herovideo'         => get_field('hero_video'),
      'herocontent'       => get_field('hero_content'),
      'herocta'           => get_field('hero_cta'),
      'heroctalink'       => get_field('hero_cta_link'),
      'herofbimg'         => get_field('hero_fallback_image'),
    );
  }
}
