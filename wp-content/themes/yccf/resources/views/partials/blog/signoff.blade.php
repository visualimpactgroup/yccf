@if(get_field('signoff_title'))
<section class="signoff main-content">
  <div class="columns">
    <div class="column is-paddingless">
      <h4>{!! get_field('signoff_title') !!}</h4>
      @if(get_field('signoff_content'))
      {!! get_field('signoff_content') !!}
      @endif

      @if(have_rows('buttons'))
        <div class="button-block">
          @while (have_rows('buttons'))@php(the_row())
            <a class="more ept {!! get_sub_field('cta_type') !!}" href="{!! get_sub_field('cta_link')['url'] !!}" title="{!! get_sub_field('cta_link')['title'] !!}" target="{!! get_sub_field('cta_link')['target'] !!}">{!! get_sub_field('cta_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
          @endwhile
        </div>
      @endif
    </div>
  </div>
  <div class="columns">
    <div class="column is-paddingless">
    </div>
  </div>
</section>
@endif
