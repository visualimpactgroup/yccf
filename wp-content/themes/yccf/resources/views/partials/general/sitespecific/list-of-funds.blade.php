@if(have_rows('our_funds'))
<section class="fund-list main-content">
  <div class="columns is-multiline">
    <!--div class="column is-12">
      <div class="fund-filter">Filter Funds:</div>
      <div class="search-block">
        <?php echo fund_search(); ?>
      </div>
    </div-->
    <!-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.."> -->
    <div class="column is-12">
      <div id="fund-listings">
        <div class="filter-bar">
          <span>Filter</span>
          <input class="search" placeholder="Filter by Name, Established, etc." />
        </div>
        <ul class="funds list">
        @php
        $query = new WP_Query(array(
          'post_type' => 'funders',
          'post_status' => 'publish',
          'posts_per_page' => -1,
          'meta_key'      => 'alphabetized_letter',
          'orderby'       => 'meta_value',
          'order'         => 'ASC'
        ));


        while ($query->have_posts()) {
          $query->the_post();
          $post_id = get_the_ID();
          //echo $post_id;
        @endphp
          <!--li class="{!! get_field('alphabetized_letter') !!}">
            <a href="{!! the_permalink() !!}" title="{!! get_field('fund_title') !!}">
              <div class="filtered-letter">{!! get_field('alphabetized_letter') !!}</div>
              <div class="fund-title"><h4>{!! get_field('fund_title') !!}</h4></div>
              <div class="established">Established: {!! get_field('fund_established_year') !!}</div>
              <div class="fund-content">
                @if(get_field('fund_image') != '')
                <img src="{!! get_field('fund_image')['url'] !!}" alt="{!! get_field('fund_image')['alt'] !!}" class="alignright">
                @endif
                {!! get_field('fund_overview') !!}
              </div>
            </a>
          </li-->
          <li class="{!! get_field('alphabetized_letter') !!}">
            <a href="{!! the_permalink() !!}" title="{!! get_field('fund_title') !!}">
              <div class="fund-image"><img src="{!! get_field('fund_image')['url'] !!}"></div>
              <div class="filtered-letter">{!! get_field('alphabetized_letter') !!}</div>
              <div class="fund-title"><h4>{!! get_field('fund_title') !!}</h4></div>
              <div class="established">Established: {!! get_field('fund_established_year') !!}</div>
            </a>
          </li>
        @php
        }
        wp_reset_query();
        @endphp
        </ul>
      </div>
    </div>
  </div>
</section>
@endif

@if(have_rows('interest_funds'))
<section class="section-donor-list fund-list main-content">
  <div class="columns">
    <div class="column is-paddingless">
      <div id="tab-content">
        <div class="tab-container is-active" data-content="1">
          <ul class="funds">
          @while (have_rows('interest_funds'))@php(the_row())
            <li>
              <div class="fund-title"><h4>{!! get_sub_field('fund_title') !!}</h4></div>
              <div class="fund-content">
                @if(get_sub_field('fund_image') != '')
                <img src="{!! get_field('fund_image')['url'] !!}" alt="{!! get_field('fund_image')['alt'] !!}" class="alignright">
                @endif
                {!! get_sub_field('fund_description') !!}
              </div>
            </li>
          @endwhile
        </div>
      </div>
    </div>
  </div>
</section>
@endif
