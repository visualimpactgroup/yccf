<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M7QVFCP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="page">
@php
echo do_shortcode('[assistancebarblock]');
echo do_shortcode('[contentjump]');
@endphp

  @php
  $event_start_date = get_field('alert_bar_start', 'cpt_sitew', false, false);
  $event_end_date   = get_field('alert_bar_end', 'cpt_sitew', false, false);

  $date = get_field('alert_bar_start', 'cpt_sitew', false, false);
  if (( is_front_page() && ( $event_start_date <= date('Ymd') && ($event_end_date >= date('Ymd'))))) {
  @endphp
  <section class="alert-bar">
    <div class="columns is-mobile">
      <div class="column is-12-fullhd is-12-widescreen is-12-desktop is-12-tablet is-12-mobile">
        @if(get_field('alert_bar_title', 'cpt_sitew'))
        <div class="alert-title">{!! get_field('alert_bar_title', 'cpt_sitew') !!}</div>
        @endif
        @if(get_field('alert_bar_content', 'cpt_sitew'))
        <div class="alert-content">{!! get_field('alert_bar_content', 'cpt_sitew') !!}</div>
        @endif
      </div>
    </div>
  </section>
  @php
  }
  @endphp
  <header class="banner">
    <a href="#main-content" class="skip-link" tabindex="0" aria-label="Click to Skip to Content">Skip to content</a>
    <div class="columns is-mobile" aria-label="Welcome. If you have any questions, please contact us by phone at {!! $globalvalue->yorkphone !!}">
      <div class="column is-4-fullhd is-3-widescreen is-3-desktop is-3-tablet is-half-mobile">
        <a class="brand" href="{{ home_url('/') }}"><img src="{!! $globalvalue->hlogo !!}" alt="{{ get_bloginfo('name') }}"></a>
      </div>
      <div class="column is-hidden-touch">
        <nav class="top-tier">
          <div class="search-trigger"><a data-fancybox data-animation-duration="700" data-src="#search" href="javascript:;">{!! $globalvalue->searchicon !!}</a></div>
          @if (has_nav_menu('Top Tier'))
            {!! wp_nav_menu(['theme_location' => 'Top Tier', 'menu_class' => 'top-tier']) !!}
          @endif
        </nav>
        <nav class="nav-primary">
          @if (has_nav_menu('Main Nav'))
            {!! wp_nav_menu(['theme_location' => 'Main Nav', 'menu_class' => 'main-nav']) !!}
          @endif
          <!--mobileNav-->
        </nav>
      </div>
      <div class="column is-hidden-desktop is-pulled-right">
        <button id="my-icon" class="hamburger hamburger--collapse is-flex-touch navigation_button js-menuToggle fr" type="button">
           <span class="hamburger-box">
              <span class="hamburger-inner"></span>
              <span class="screen-reader-text">Menu</span>
           </span>
        </button>
      </div>
    </div>
  </header>
  <div id="jumptocontent">
