<section class="hero">
  <!-- <section class="main-slider">
    <div class="item vimeo" data-video-start="4">
      <iframe class="embed-player slide-media" src="https://player.vimeo.com/video/217885864?api=1&byline=0&portrait=0&title=0&background=1&mute=1&loop=1&autoplay=0&id=217885864" width="980" height="520" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
      <p class="caption">Vimeo</p>
    </div>
    <div class="item youtube">
      <iframe class="embed-player slide-media" width="980" height="520" src="https://www.youtube.com/embed/tdwbYGe8pv8?enablejsapi=1&controls=0&fs=0&iv_load_policy=3&rel=0&showinfo=0&loop=1&playlist=tdwbYGe8pv8&start=102" frameborder="0" allowfullscreen></iframe>
      <p class="caption">YouTube</p>
    </div>
  </section> -->
@if(have_rows('hero_slideshow'))
<?php $slideCount = '0'; ?>
<div class="sshow">
  @while (have_rows('hero_slideshow'))@php(the_row())
    @if(get_sub_field('slide_status') != 'deactivate')
      @if(get_sub_field('slide_type') == 'normal')
      <div class="slide slide<?php echo $slideCount++; ?>">
        <div class="circles-main">
          <div class="columns">
            <div class="column">
              <span>
                <a href="{!! get_sub_field('hero_slideshow_link') !!}" title="{!! get_sub_field('hero_slideshow_cta') !!}"><img src="{!! get_sub_field('hero_slideshow_text_graphic')['url'] !!}" alt="{!! get_sub_field('hero_slideshow_text_graphic')['alt'] !!}"></a>
              </span>
              <span>
                <a class="link" href="{!! get_sub_field('hero_slideshow_link') !!}" title="{!! get_sub_field('hero_slideshow_cta') !!}">{!! get_sub_field('hero_slideshow_cta') !!}{!! $globalvalue->moreafter !!}</a>
              </span>
            </div>
          </div>
        </div>
        <div class="main-img">
          <img src="{!! get_sub_field('hero_slideshow_image') !!}" alt="{!! get_sub_field('hero_slideshow_text_graphic')['alt'] !!}">
        </div>
      </div>
      @elseif(get_sub_field('slide_type') == 'video')
      <div class="slide slide<?php echo $slideCount++; ?> video-slide">
        <div class="circles-main">
          <div class="columns">
            <div class="column">
              <span>
                <a href="{!! get_sub_field('hero_slideshow_link') !!}?fancybox=true&id={!! get_sub_field('vidid') !!}" title="{!! get_sub_field('hero_slideshow_cta') !!}"><img src="{!! get_sub_field('hero_slideshow_text_graphic')['url'] !!}" alt="{!! get_sub_field('hero_slideshow_text_graphic')['alt'] !!}"></a>
              </span>
              <span>
                <a class="link" href="{!! get_sub_field('hero_slideshow_link') !!}?fancybox=true&id={!! get_sub_field('vidid') !!}" title="{!! get_sub_field('hero_slideshow_cta') !!}">{!! get_sub_field('hero_slideshow_cta') !!}{!! $globalvalue->moreafter !!}</a>
              </span>
            </div>
          </div>
        </div>
        <div class="vid">
          <video width="100%" height="100%" class="video" muted playsinline>
  					<source src="{!! get_sub_field('video_id') !!}" type="video/mp4" />
  				</video>
        </div>
        <div class="main-img">
          <img src="{!! $globalvalue->videobg !!}">
        </div>
      </div>
      @elseif(get_sub_field('slide_type') == 'promotional')
      <div class="slide slide<?php echo $slideCount++; ?> promotional-slide">
        <div class="columns">
          <div class="column is-2">&nbsp;</div>
          <div class="column">
            <div class="main-text">{!! get_sub_field('promotional_text') !!}</div>
            <a class="link" href="{!! get_sub_field('promotional_link')['url'] !!}" title="{!! get_sub_field('promotional_link')['title'] !!}">{!! get_sub_field('promotional_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
          </div>
          <div class="column is-2">&nbsp;</div>
        </div>
        <div class="main-img">
          <div class="shaded"></div>
          <img src="{!! get_sub_field('promotional_image')['url'] !!}" alt="{!! get_sub_field('promotional_text') !!}">
        </div>
      </div>
      @elseif(get_sub_field('slide_type') == 'fullscreen')
      <div class="slide slide<?php echo $slideCount++; ?>">
        <a class="link" href="{!! get_sub_field('promotional_link')['url'] !!}" title="{!! get_sub_field('promotional_link')['title'] !!}">
          <div class="main-img">
            <img src="{!! get_sub_field('promotional_image')['url'] !!}" alt="{!! get_sub_field('promotional_text') !!}">
          </div>
        </a>
      </div>
      @else
      <div class="slide slide<?php echo $slideCount++; ?> charitable-slide">
        <div class="columns">
          <div class="column">
            <h3>{!! get_sub_field('charitable_title') !!}</h3>
          </div>
        </div>
        <div class="columns icon-columns is-multiline is-centered">
        @while (have_rows('charitable_icons'))@php(the_row())
          <div class="column is-2">
            <div class="type-icon">
              {!! get_sub_field('charitable_icon') !!}
            </div>
            <div class="type-title">
              {!! get_sub_field('charitable_title') !!}
            </div>
            {!! get_sub_field('charitable_content') !!}
          </div>
        @endwhile
        </div>
        <div class="columns char-signoff">
          <div class="column">
            <p>{!! get_sub_field('charitable_signoff') !!}</p>
          </div>
        </div>
        <div class="main-img">
          <div class="shaded blueshade"></div>
        </div>
      </div>
      @endif
    @endif
  @endwhile
</div>
<!--div class="hero-bottom-shadow"></div-->
@endif
</section>
