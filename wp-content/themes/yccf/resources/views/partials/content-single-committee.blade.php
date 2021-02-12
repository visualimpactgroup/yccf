<section class="blog-content main-content">
  <div class="columns">
    <div class="column is-9">
      <article @php(post_class())>
        <h1 class="entry-title">{{ get_the_title() }}</h1>
        <div class="entry-content">
          @php(the_content())
            @if(get_field('page_type') == 'resources')
              @if(have_rows('resources'))
              <ul class="resources">
                @while (have_rows('resources'))@php(the_row())
                  <li><a href="{!! get_sub_field('resource')['url'] !!}" target="_blank" title="{!! get_sub_field('resource')['title'] !!}">{!! get_sub_field('resource')['title'] !!}</a></li>
                @endwhile
              </ul>
              @endif
            @elseif(get_field('page_type') == 'sections')
              @if(have_rows('sections'))
                @while (have_rows('sections'))@php(the_row())
                  <div class="section-block">
                    <h4>{!! get_sub_field('section_date') !!}: {!! get_sub_field('section_title') !!}</h4>
                    @if(have_rows('section_resources'))
                    <ul class="resources">
                      @while (have_rows('section_resources'))@php(the_row())
                        <li><a href="{!! get_sub_field('section_resource')['url'] !!}" target="_blank" title="{!! get_sub_field('section_resource')['title'] !!}">{!! get_sub_field('section_resource')['title'] !!}</a></li>
                      @endwhile
                    </ul>
                    @endif
                  </div>
                @endwhile
              @endif
          @else
          <p>There are no documents at this time.</p>
          @endif
        </div>
      </article>
    </div>
    <div class="column is-3">
      @php(comments_template('/partials/committee/column.blade.php'))
    </div>
  </div>
</section>
