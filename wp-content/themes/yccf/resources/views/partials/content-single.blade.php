<section class="blog-content main-content">
  <div class="columns">
    <div class="column is-9">
      <article @php(post_class())>
        @if(get_field('full_image') != '')
        <img class="main-img" src="{{ get_field('full_image') }}" alt="{{ get_the_title() }}">
        @else
        <img class="main-img" src="{{ get_field('blog_placeholder','cpt_sitew') }}" alt="{{ get_the_title() }}">
        @endif
        <h1 class="entry-title">{{ get_the_title() }}</h1>
        @include('partials/blog/entry-meta')
        <div class="entry-content">
          @php(the_content())
        </div>
        {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
      </article>
      @php(comments_template('/partials/blog/signoff.blade.php'))
      @php(comments_template('/partials/blog/comments.blade.php'))
    </div>
    <div class="column is-3">
      @php(comments_template('/partials/blog/column.blade.php'))
    </div>
  </div>
</section>
