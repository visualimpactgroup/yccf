<section class="hero bottom-shadow internal-hero">
  <div class="fade">
    <div class="columns">
      <div class="column">
        <h1>{!! get_field('hero_title') !!}</h1>
        {!! get_field('hero_content') !!}
      </div>
    </div>
    <div class="colored"></div>
    <img src="{!! get_field('hero_image')['url'] !!}" alt="{!! get_field('hero_image')['alt'] !!}">
  </div>
</section>
