@if(is_page('our-donors'))
<section class="dual-grid main-content">
  <div class="columns is-paddingless">
    <div class="column is-6 stories is-12-mobile">
      <div class="cont">
        <h3>{!! get_field('featured_donor_stories_title') !!}</h3>
        @php
          echo do_shortcode('[donorsmallblock]');
        @endphp
        <hr class="cb">
        <a class="more fr" href="{!! get_field('donor_stories_link')['url'] !!}" title="{!! get_field('donor_stories_link')['title'] !!}">{!! get_field('donor_stories_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
      </div>
    </div>
    <div class="column is-6 is-12-mobile">
      <div class="cont">
        <h3>{!! get_field('list_of_donors_title') !!}</h3>
        {!! get_field('list_of_donors_content') !!}
        <div class="button-block">
          <a class="more Styled" href="{!! get_field('list_of_donors_link')['url'] !!}" title="{!! get_field('list_of_donors_link')['title'] !!}" target="{!! get_field('list_of_donors_link')['target'] !!}">{!! get_field('list_of_donors_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
        </div>
      </div>
    </div>
  </div>
  <hr class="cb">
</section>
@endif
