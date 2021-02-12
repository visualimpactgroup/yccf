<section class="main-content">
  <div class="columns">
    <div class="column is-12">
      <h2>{!! get_field('donor_names') !!}: {!! get_field('donor_subtitle') !!}</h2>
      @if(get_field('donor_image'))
        <figure class="wp-caption alignright">
          <img src="{!! get_field('donor_image')['url'] !!}" alt="{!! get_field('donor_image')['alt'] !!}" class="alignright">
          <figcaption class="wp-caption-text">{!! get_field('donor_image')['caption'] !!}</figcaption>
        </figure>
      @endif
      @php(the_content())
    </div>
  </div>
</section>
