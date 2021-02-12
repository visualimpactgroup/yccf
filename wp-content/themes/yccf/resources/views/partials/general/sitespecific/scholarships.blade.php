@if(have_rows('scholarships'))
<section class="fund-list main-content">
  <div class="columns">
    <div class="column is-12">
      <ul class="funds">
      @while (have_rows('scholarships'))@php(the_row())
        <li>
          <div class="fund-title"><h4>{!! get_sub_field('scholarship_name') !!}</h4></div>
          <div class="fund-content">
            {!! get_sub_field('scholarship_description') !!}
          </div>
          @if(have_rows('links'))
            <div class="button-block">
              @while (have_rows('links'))@php(the_row())
                @if(get_sub_field('link') == 'page')
                <a class="more Styled" href="{!! get_sub_field('page')['url'] !!}" title="{!! get_sub_field('page')['title'] !!}" target="{!! get_sub_field('page')['target'] !!}">{!! get_sub_field('page')['title'] !!}{!! $globalvalue->moreafter !!}</a>
                @else
                <a class="more Styled" href="{!! get_sub_field('document')['url'] !!}" target="_blank" title="{!! get_sub_field('document')['title'] !!}">{!! get_sub_field('document')['title'] !!}{!! $globalvalue->moreafter !!}</a>
                @endif
              @endwhile
            </div>
          @endif
        </li>
      @endwhile
      </ul>
    </div>
  </div>
</section>
@endif
