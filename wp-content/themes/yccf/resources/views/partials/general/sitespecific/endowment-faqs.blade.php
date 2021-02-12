@if(get_field('give_now_title') != '')
<section class="dual-grid main-content">
  <div class="columns is-paddingless">
    @if(get_field('give_later_title') != '')
    <div class="column is-6">
      <div class="cont">
        <h3>{!! get_field('give_now_title') !!}</h3>
        @if(have_rows('give_now_tabs'))
        <section class="faq-block">
          @while (have_rows('give_now_tabs'))@php(the_row())
            <div class="toggle">
              <div class="toggle-title">
                <div class="title">
                  <i></i>
                  <span class="title-name">{!! get_sub_field('give_now_title') !!}</span>
                </div>
              </div>
              <div class="toggle-inner">
                {!! get_sub_field('give_now_content') !!}
              </div>
            </div>
          @endwhile
        </section>
        @endif
      </div>
    </div>
    <div class="column is-6">
      <div class="cont">
        <h3>{!! get_field('give_later_title') !!}</h3>
        @if(have_rows('give_later_tabs'))
        <section class="faq-block">
          @while (have_rows('give_later_tabs'))@php(the_row())
            <div class="toggle">
              <div class="toggle-title">
                <div class="title">
                  <i></i>
                  <span class="title-name">{!! get_sub_field('give_later_tab_title') !!}</span>
                </div>
              </div>
              <div class="toggle-inner">
                {!! get_sub_field('give_later_tab_content') !!}
              </div>
            </div>
          @endwhile
        </section>
        @endif
      </div>
    </div>
    @else
    <div class="column is-12">
      <h3>{!! get_field('give_now_title') !!}</h3>
      @if(have_rows('give_now_tabs'))
      <section class="faq-block">
        @while (have_rows('give_now_tabs'))@php(the_row())
          <div class="toggle">
            <div class="toggle-title">
              <div class="title">
                <i></i>
                <span class="title-name">{!! get_sub_field('give_now_title') !!}</span>
              </div>
            </div>
            <div class="toggle-inner">
              {!! get_sub_field('give_now_content') !!}
            </div>
          </div>
        @endwhile
      </section>
      @endif
    </div>
    @endif
  </div>
</section>
@endif
