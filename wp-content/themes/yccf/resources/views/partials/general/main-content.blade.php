@if(!is_page('grant-programs'))
<section class="main-content">
  <div class="columns">
    @if($globalvalue->featuredimg)
    <div class="column is-5 is-12-mobile">
      @php(the_content())
      @include('partials.global.buttons')
    </div>
    <div class="column is-1 is-hidden-mobile">
      &nbsp;
    </div>
    <div class="column is-6 ft-img is-hidden-mobile">
      {!! $globalvalue->featuredimg !!}
    </div>
    @else
    <div class="column is-11 is-12-mobile">
      @if(get_field('donor_image'))
        <img src="{!! get_field('donor_image')['url'] !!}" alt="" class="alignright">
      @endif
      @php(the_content())
      @include('partials.global.buttons')
    </div>
    <div class="column is-1 is-hidden-mobile">
      &nbsp;
    </div>
    @endif
  </div>
</section>
@endif
