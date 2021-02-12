<section class="about-block">
  <div class="halves columns is-marginless">
    <div class="column is-6 is-paddingless half fs-img" style="background-image: url({!! get_field('about_bg_image') !!})">
    </div>
    <div class="column is-6 is-paddingless half">
      <div class="half-cont">
        <div class="block-content">
          <div class="logo-circle"></div>
          <h1>{!! get_field('about_title') !!}</h1>
          <span class="mission-title">Our Mission</span>
          <div class="divider"></div>
          @php(the_content())
          @include('partials.global.buttons')
        </div>
      </div>
    </div>
  </div>
</section>
<section class="about-block vision-block">
  <div class="halves columns is-marginless">
    <div class="column is-6 is-paddingless half">
      <div class="half-cont">
        <div class="block-content">
          <h2>{!! get_field('vision_title') !!}</h2>
          {!! get_field('vision_content') !!}
        </div>
      </div>
    </div>
    <div class="column is-6 is-paddingless half fs-img" style="background-image: url({!! get_field('vision_image') !!})">
    </div>
  </div>
</section>
