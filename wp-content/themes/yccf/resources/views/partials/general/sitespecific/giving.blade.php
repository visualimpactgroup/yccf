<!-- @if(have_rows('giving_block_ways'))
<section class="giving-block main-content">
  <div class="columns">
    <div class="column">
      <h3>{!! get_field('giving_block_title') !!}<h3>
    </div>
  </div>
  <div class="columns is-multiline">
  @while (have_rows('giving_block_ways'))@php(the_row())
    <div class="column">
      <div class="type-icon">
        {!! get_sub_field('giving_icon') !!}
      </div>
      <div class="type-title">
        {!! get_sub_field('giving_title') !!}
      </div>
      {!! get_sub_field('giving_content') !!}
    </div>
  @endwhile
  </div>
  <div class="columns">
    <div class="column">
      {!! get_field('signoff_content') !!}
    </div>
  </div>
</section>
@endif -->
@if(is_page('why-endowment') || (is_page('the-story-of-the-grotto')))
<section class="endowment-mblock main-content" style="background-image: url({!! get_field('endowment_background_image') !!});">
  <div class="columns">
    <div class="column is-7">
      <h3>{!! get_field('endowment_title') !!}</h3>
      <div class="medium-subtitle">{!! get_field('endowment_content') !!}</div>
      {!! get_field('endowment_paragraph') !!}
    </div>
    <div class="column is-5">
      @if(get_field('endowment_image') != '')
        <img src="{!! get_field('endowment_image') !!}" alt="{!! get_field('endowment_title') !!}">
      @endif
    </div>
  </div>
</section>
@endif
