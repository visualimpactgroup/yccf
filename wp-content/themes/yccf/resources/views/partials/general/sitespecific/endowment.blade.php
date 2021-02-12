@if(is_page('why-endowment') || (is_page('the-story-of-the-grotto')))
  @if(get_field('endowment_block_title') != '')
  <section class="endowment-funds main-content">
    <div class="columns">
      <div class="column is-6 is-12-mobile">
        <h3>{!! get_field('endowment_block_title') !!}</h3>
        {!! get_field('endowment_block_content') !!}
        @if(have_rows('endowment_links'))
          <div class="button-block">
            @while (have_rows('endowment_links'))@php(the_row())
              <a class="more Styled" href="{!! get_sub_field('link')['url'] !!}" title="{!! get_sub_field('link')['title'] !!}" target="{!! get_sub_field('cta_link')['target'] !!}">{!! get_sub_field('link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
            @endwhile
          </div>
        @endif
      </div>
      <div class="column is-1 is-hidden-mobile">
        &nbsp;
      </div>
      <div class="column is-5 is-12-mobile is-hidden-mobile">
        <img src="{!! get_field('endowment_block_image')['url'] !!}" alt="{!! get_field('endowment_block_image')['alt'] !!}">
      </div>
    </div>
  </section>
  @endif
@endif
