@include('partials.landing-page.landing-page-hero')
<section class="blog-content main-content fund-page">
  <div class="columns is-multiline is-mobile">
    <div class="column is-12-mobile is-12-tablet is-11-desktop is-11-widescreen">
      <h1>{!! get_field('fund_title') !!}</h1>
      <div class="fund-year-established internal">Established in {!! get_field('fund_established_year') !!}</div>
      @if(get_field('fund_image') != '')
      <img src="{!! get_field('fund_image')['url'] !!}" alt="{!! get_field('fund_title') !!}" class="alignright">
      @endif

      {!! get_field('fund_overview') !!}

      <div class="button-block">
        <a class="more ept Styled" href="/contact-us/" title="Contact Us">Contact Us to Learn More {!! $globalvalue->moreafter !!}</a>
        <a class="more ept Styled" href="/for-donors/ways-to-give/endowment-funds/fund-list/" title="Our Funds List">See Our Funds List {!! $globalvalue->moreafter !!}</a>
      </div>
    </div>
  </div>
  <div class="columns is-mobile is-multiline">
    <div class="column is-12">
      @include('partials.general.shortcodes')
    </div>
  </div>
</section>
