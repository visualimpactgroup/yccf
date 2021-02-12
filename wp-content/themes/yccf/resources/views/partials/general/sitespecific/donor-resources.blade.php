@if(have_rows('donor_resources'))
<section class="donor-resources faq-block main-content">
  <div class="columns">
    <div class="column is-12">
      @while (have_rows('donor_resources'))@php(the_row())
      <div class="toggle">
        <div class="toggle-title">
          <div class="title">
            <i></i>
            <span class="title-name">{!! get_sub_field('resource_tab_title') !!}</span>
          </div>
        </div>
        <div class="toggle-inner">
          @if(have_rows('resource_tab_links'))
            <ul class="resource-links">
            @while (have_rows('resource_tab_links'))@php(the_row())
              @if(get_sub_field('resource_type') == 'link')
              <li><a class="more more-after" href="{!! get_sub_field('resource_link')['url'] !!}" target="{!! get_sub_field('resource_link')['target'] !!}" title="{!! get_sub_field('resource_link')['title'] !!}">{!! get_sub_field('resource_link')['title'] !!}{!! $globalvalue->morebefore !!}</a></li>
              @else
              <li><a class="more more-after" href="{!! get_sub_field('resource_document')['url'] !!}" target="_blank" title="{!! get_sub_field('resource_document')['title'] !!}">{!! get_sub_field('resource_document')['title'] !!}{!! $globalvalue->morebefore !!}</a></li>
              @endif
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
