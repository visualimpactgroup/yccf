@if(get_field('visible_call_out_block') != 'Yes')
  <section class="impact news-bar main-content">
    <div class="columns is-multiline is-mobile">
      <div class="column is-6-desktop is-6-tablet is-12-mobile">
        <div class="impact-title">Recent News at YCCF</div>
      </div>
      <div class="column is-6-desktop is-6-tablet is-12-mobile">
        <a class="more fr" href="/news/" title="See All News">See All News{!! $globalvalue->moreafter !!}</a>
      </div>
      @php
        do_shortcode('[newsfeed]');
      @endphp
    </div>
  </section>
@else
  @php
  do_shortcode('[assistancebar]');
  @endphp
@endif
</div>
<footer class="footer-block main-content">
  <div class="columns">
    <div class="column is-3">
      <div class="footer-logo">
        <a class="brand" href="{{ home_url('/') }}"><img src="{!! $globalvalue->hlogo !!}" alt="{{ get_bloginfo('name') }}"></a>
      </div>
      <ul class="footer-info cinfo">
        @if($globalvalue->address)
        <li class="address-list double-line">
          {!! $globalvalue->locationicon !!}
          <div class="address-line">{!! $globalvalue->address !!}</div>
          <div class="city-line">{!! $globalvalue->city !!}, {!! $globalvalue->state !!} {!! $globalvalue->zip !!}</div>
        </li>
        @endif

        @if($globalvalue->email)
        <li class="email-list">
          {!! $globalvalue->emailicon !!}
          <div class="email-line"><a href="mailto:{!! $globalvalue->email !!}">{!! $globalvalue->email !!}</a></div>
        </li>
        @endif

        <li class="parking">
          {!! $globalvalue->car !!}
          <div class="parking-line"><a href="http://yccf.org/parking/" title"Parking Options">Parking Options</a></div>
        </li>
      </ul>
    </div>
    <div class="column is-1 is-hidden-mobile">
      &nbsp;
    </div>
    <div class="column is-5">
      <div class="columns">
        <div class="column is-6 is-paddingless">
          <div class="office">
            <span>York Office</span>
            {!! $globalvalue->phoneicon !!}{!! $globalvalue->yorkphone !!}
          </div>
        </div>
        <div class="column is-6 is-paddingless">
          <div class="office">
            <span>Hanover Office</span>
            {!! $globalvalue->phoneicon !!}{!! $globalvalue->hanoverphone !!}
          </div>
        </div>
      </div>
      <div class="columns">
        <div class="column is-12 is-paddingless">
          <nav class="explore">
          {!! wp_nav_menu(['theme_location' => 'Footer Nav', 'menu_class' => 'footer-nav']) !!}
          </nav>
        </div>
      </div>
    </div>
    <div class="column is-3">
      <section class="enewsletter-signup">
        <div class="footer-title">
          {!! $globalvalue->enewsicon !!}{!! $globalvalue->enewstitle !!}
        </div>
        {!! $globalvalue->enewscontent !!}

        <!-- <script>
        jQuery(function($) {
          $(".enews-signup input#email").focusout(function() {
            if($('input#email').val() ) {
              $(".enews-signup label").css('opacity','0');
              $(".enews-signup button").css('opacity','1');
            } else {
              $(".enews-signup label").css('opacity','1');
              $(".enews-signup button").css('opacity','0');
            }
          })
        });
        </script>
        <form class="enews-signup">
          <input type="email" id="email"/>
          <label for="email">email address</label>
          <button id="button">{!! $globalvalue->moreafter !!}</button>
        </form> -->

        @if(have_rows('social_media_outlets','cpt_sitew'))
        <section class="social-media">
          <ul class="social-media">
            @while (have_rows('social_media_outlets','cpt_sitew'))@php(the_row())
            <li><a href="{!! get_sub_field('social_link') !!}" target="_blank">{!! get_sub_field('social_icon') !!}</a></li>
            @endwhile
          </ul>
        </section>
        @endif
      </section>
    </div>
  </div>
</footer>
<section class="copyright">
  <div class="columns is-block-touch">
    <div class="column">
      <span>{!! $globalvalue->sitecopyright !!}</span>
      <nav class="copyright-menu">
        @if (has_nav_menu('Copyright Nav'))
          {!! wp_nav_menu(['theme_location' => 'Copyright Nav', 'menu_class' => 'copyright-nav']) !!}
        @endif
      </nav>
    </div>
    <div class="column">
      <div class="logo-blocks">
        @if(have_rows('footer_image_menu','cpt_sitew'))
          @while (have_rows('footer_image_menu','cpt_sitew'))@php(the_row())
            @if(get_sub_field('footer_image_link', 'cpt_sitew'))
              <a href="{!! get_sub_field('footer_image_link', 'cpt_sitew') !!}" title="{!! get_sub_field('footer_image')['alt'] !!}" target="_blank">
                <img src="{!! get_sub_field('footer_image')['url'] !!}" alt="{!! get_sub_field('footer_image')['alt'] !!}">
              </a>
            @else
            <img src="{!! get_sub_field('footer_image')['url'] !!}" alt="{!! get_sub_field('footer_image')['alt'] !!}">
            @endif
          @endwhile
        @endif
      </div>
    </div>
  </div>
</section>
<section class="site-bar is-hidden-touch">
  <div class="columns is-mobile">
    <div class="column is-5-desktop is-5-tablet">
      <!--a class="main-site site-block active" href="{{ home_url('/') }}"><img src="{!! $globalvalue->hlogo !!}" alt="{{ get_bloginfo('name') }}"></a-->
    </div>
    <div class="column is-7-desktop is-7-tablet">
      @if(have_rows('header_image_menu','cpt_sitew'))
        <nav class="img-menu">
          <ul>
            @while (have_rows('header_image_menu','cpt_sitew'))@php(the_row())
            <li><a href="{!! get_sub_field('header_image_link','cpt_sitew') !!}" target="_blank" title="{!! get_sub_field('header_image','cpt_sitew')['alt'] !!}"><img src="{!! get_sub_field('header_image','cpt_sitew')['url'] !!}" alt="{!! get_sub_field('header_image','cpt_sitew')['alt'] !!}"></a></li>
            @endwhile
          </ul>
        </nav>
      @endif
    </div>
  </div>
</section>
</div><!--/Page-->
@if (has_nav_menu('Mobile Nav'))
<nav id="menu">
  <div>
   {!! wp_nav_menu(['theme_location' => 'Mobile Nav', 'menu_class' => 'mobile-nav']) !!}
   <div>
       @if(have_rows('header_image_menu','cpt_sitew'))
        <span class="sites">Visit Our Other Sites</span>
         <nav class="logo-nav">
           <ul>
             @while (have_rows('header_image_menu','cpt_sitew'))@php(the_row())
             <li><a href="{!! get_sub_field('header_image_link','cpt_sitew') !!}" target="_blank" title="{!! get_sub_field('header_image','cpt_sitew')['alt'] !!}"><img src="{!! get_sub_field('header_image','cpt_sitew')['url'] !!}" alt="{!! get_sub_field('header_image','cpt_sitew')['alt'] !!}"></a></li>
             @endwhile
           </ul>
         </nav>
       @endif
   </div>
 </div>
</nav>
@endif
