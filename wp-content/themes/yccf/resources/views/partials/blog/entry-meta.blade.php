<section class="post-information">
  <div class="cont">
    <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
  </div>
  <div class="cont">
    <p class="byline author vcard">
      {{ __('By', 'sage') }} {{ get_the_author() }}
    </p>
  </div>
</section>
