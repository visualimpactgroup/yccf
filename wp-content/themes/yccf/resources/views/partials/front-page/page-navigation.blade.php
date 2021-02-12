<section class="page-navigation" id="main-content">
  <section class="set-001">
    @if(have_rows('image_navigation'))
    @php
      $i = '0';
    @endphp
    <div class="columns">
      @while (have_rows('image_navigation'))@php(the_row())
        @php
          $i++;
        @endphp
        @if($i <= '3')
        <div class="column is-4 is-paddingless">
          <a href="{!! get_sub_field('link') !!}">
            <div class="cont">
              <span>{!! get_sub_field('text_001') !!}</span>
              <div>{!! get_sub_field('text_002') !!}</div>
            </div>
            <div class="img">
              <img src="{!! get_sub_field('image') !!}" alt="">
            </div>
          </a>
        </div>
        @endif
      @endwhile
    </div>
    @endif
  </section>

  <!--section class="set-002">
    @if(have_rows('image_navigation'))
    @php
      $i = '0';
    @endphp
    <div class="columns">
      @while (have_rows('image_navigation'))@php(the_row())
        @php
          $i++;
        @endphp
        @if($i == '4')
        <div class="column is-7 is-paddingless">
          <a href="{!! get_sub_field('link') !!}">
            <div class="cont">
              <span>{!! get_sub_field('text_001') !!}</span>
              <div>{!! get_sub_field('text_002') !!}</div>
            </div>
            <div class="img">
              <img src="{!! get_sub_field('image') !!}" alt="{!! get_sub_field('text_001') !!}{!! get_sub_field('text_002') !!}">
            </div>
          </a>
        </div>
        @endif

        @if($i == '5')
        <div class="column is-5 is-paddingless">
          <a href="{!! get_sub_field('link') !!}">
            <div class="cont">
              <span>{!! get_sub_field('text_001') !!}</span>
              <div>{!! get_sub_field('text_002') !!}</div>
            </div>
            <div class="img">
              <img src="{!! get_sub_field('image') !!}" alt="{!! get_sub_field('text_001') !!} {!! get_sub_field('text_002') !!}">
            </div>
          </a>
        </div>
        @endif
      @endwhile
    </div>
    @endif
  </section-->
</section>
