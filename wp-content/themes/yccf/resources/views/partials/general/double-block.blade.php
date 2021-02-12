<section class="main-content ept">
<?php
  $rowCount = 0;
?>
  @if(have_rows('children_pages'))
    @while (have_rows('children_pages'))@php(the_row())
    @php
      if($rowCount % 2 === 0):
    @endphp

      @if(is_page('grant-programs') && ($rowCount == '0'))
      <section class="double-block even-block">
        <div class="halves columns is-marginless">
          <div class="column is-6 is-paddingless half">
            <div class="half-cont">
              <div class="block-content backed-up">
                @php(the_content())
              </div>
            </div>
          </div>
          <div class="column is-6 is-paddingless half fs-img">
            {!! $globalvalue->featuredimg !!}
          </div>
        </div>  
      </section>
      <section class="double-block odd-block">
        <div class="halves columns is-marginless">
          <div class="column is-6 is-paddingless half fs-img">
            <img src="{!! get_sub_field('image')['url'] !!}" alt="{!! get_sub_field('image')['alt'] !!}">
          </div>
          <div class="column is-6 is-paddingless half">
            <div class="half-cont">
              <div class="block-content">
                <h3>{!! get_sub_field('page_title') !!}</h3>
                {!! get_sub_field('page_content') !!}
                @include('partials.global.buttons')
              </div>
            </div>
          </div>
        </div>
      </section>
      @else
        <section class="double-block odd-block">
          <div class="halves columns is-marginless">
            <div class="column is-6 is-paddingless half fs-img">
              <img src="{!! get_sub_field('image')['url'] !!}" alt="{!! get_sub_field('page_title') !!}">
            </div>
            <div class="column is-6 is-paddingless half">
              <div class="half-cont">
                <div class="block-content">
                  <h3>{!! get_sub_field('page_title') !!}</h3>
                  {!! get_sub_field('page_content') !!}
                  @include('partials.global.buttons')
                </div>
              </div>
            </div>
          </div>
        </section>
      @endif
    @php
      else :
    @endphp
    <section class="double-block even-block">
      <div class="halves columns is-marginless">
        <div class="column is-6 is-paddingless half">
          <div class="half-cont">
            <div class="block-content">
              <h3>{!! get_sub_field('page_title') !!}</h3>
              {!! get_sub_field('page_content') !!}
              @include('partials.global.buttons')
            </div>
          </div>
        </div>
        <div class="column is-6 is-paddingless half fs-img">
          <img src="{!! get_sub_field('image')['url'] !!}" alt="{!! get_sub_field('page_title') !!}">
        </div>
      </div>
    </section>
    @php
      endif;
      $rowCount++;
    @endphp
    @endwhile
  @endif
</section>
@include('partials.general.shortcodes')
