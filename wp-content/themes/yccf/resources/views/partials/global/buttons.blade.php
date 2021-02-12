@if(!is_page(array ('contact-us','ways-to-give','why-endowment')))
  @if(have_rows('buttons'))
    <div class="button-block">
      @while (have_rows('buttons'))@php(the_row())
        <a class="more ept {!! get_sub_field('cta_type') !!}" href="{!! get_sub_field('cta_link')['url'] !!}" title="{!! get_sub_field('cta_link')['title'] !!}" target="{!! get_sub_field('cta_link')['target'] !!}">{!! get_sub_field('cta_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
      @endwhile
    </div>
  @endif

  @if(have_rows('page_links'))
    <div class="button-block">
      @while (have_rows('page_links'))@php(the_row())
        <a class="more Styled" href="{!! get_sub_field('link')['url'] !!}" title="{!! get_sub_field('link')['title'] !!}" target="{!! get_sub_field('cta_link')['target'] !!}">{!! get_sub_field('link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
      @endwhile
    </div>
  @endif
@endif
