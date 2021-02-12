<div class="columns">
  <div class="column is-full">
    <article @php(post_class())>
      <h3 class="entry-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
      <div class="search-url"><icon class="icon-link"></icon>{{ get_permalink() }}</div>
      <div class="entry-summary">
        @php(the_excerpt())
      </div>
      <a class="more" href="{{ get_permalink() }}" title="{{ get_the_title() }}">Visit Page{!! $globalvalue->moreafter !!}</a>
    </article>
  </div>
</div>
