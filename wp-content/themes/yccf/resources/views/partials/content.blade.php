<div class="column is-5 is-full-mobile">
  <a href="{{ get_permalink() }}" title="{{ get_the_title() }}">
  @if(get_field('cropped_cover_image') != '')
    <img src="{{ get_field('cropped_cover_image') }}" alt="{{ get_the_title() }}">
  @else
    <img src="{{ get_field('blog_small_placeholder','cpt_sitew') }}" alt="{{ get_the_title() }}">
  @endif
  </a>
</div>
<div class="column is-7 is-full-mobile">
  <div class="content no-spacing">
    <h3><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h3>
    @include('partials/blog/entry-meta')
    <div class="entry-content">
      @php(the_excerpt())
    </div>
    <div class="single-links">
      <div>
        <a class="more-link before-icon" href="{{ get_permalink() }}" title="'.$title.'">Continue Reading{!! $globalvalue->moreafter !!}</a>
      </div>
    </div>
  </div>
</div>
<hr class="thin-grey">
