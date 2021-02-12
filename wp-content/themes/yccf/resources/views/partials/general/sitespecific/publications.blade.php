@if(have_rows('publications'))
<section class="publications main-content">
  <div class="columns is-multiline">
    <div class="column is-5 is-12-mobile">
      @if(get_field('document_title'))
        <div class="columns">
          <div class="column is-7 is-paddingless">
            <h4>{!! get_field('document_title') !!}</h4>
            {!! get_field('document_description') !!}
            <a href="{!! get_field('document_url')['url'] !!}" target="_blank" title="{!! get_field('document_url')['title'] !!}">
              <img class="mobile-report" src="{!! get_field('document_image')['url'] !!}" alt="{!! get_field('document_title') !!}">
            </a>
            <div class="button-block">
              <a class="more Styled" href="{!! get_field('document_url')['title'] !!}" title="Download {!! get_field('document_title') !!}" target="_blank">Download Now{!! $globalvalue->moreafter !!}</a>
            </div>
          </div>
          <div class="column is-1 is-hidden-mobile"></div>
          <div class="column is-4">
            <a href="{!! get_field('document_url')['title'] !!}" target="_blank" title="{!! get_field('document_title') !!}">
              <img class="report" src="{!! get_field('document_image')['url'] !!}" alt="{!! get_field('document_title') !!}">
            </a>
          </div>
        </div>
      @endif
    </div>
    <div class="column is-1 is-hidden-mobile"></div>
    <div class="column is-6 is-multiline is-12-mobile">
      @while (have_rows('publications'))@php(the_row())
        <div class="columns">
          <div class="column is-12 is-paddingless">
          <h4>{!! get_sub_field('publication_title') !!}</h4>
          <hr class="cb">
          @if(have_rows('available_publications'))
            <ul>
            @while (have_rows('available_publications'))@php(the_row())
              <li><a href="{!! get_sub_field('publication')['url'] !!}" target="_blank" alt="{!! get_sub_field('publication')['title'] !!}">{!! get_sub_field('publication')['title'] !!}</a></li>
            @endwhile
            </ul>
          @endif
          </div>
        </div>
      @endwhile
    </div>
  </div>
</section>
@endif
