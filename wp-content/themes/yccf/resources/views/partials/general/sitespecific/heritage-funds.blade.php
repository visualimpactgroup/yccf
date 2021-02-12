@if(have_rows('heritage_fund_list'))
<section class="section-donor-list fund-list main-content">
  <div class="columns">
    <div class="column is-paddingless">
      <div id="tab-content">
        <div class="tab-container is-active" data-content="1">
          <!--table class="table is-striped is-fullwidth is-responsive tablesorter1">
            <thead>
              <tr>
                <th>Fund Name</th>
                <th>Year Established</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('heritage_fund_list'))@php(the_row())
                <tr>
                  <td>{!! get_sub_field('fund_name') !!}</td>
                  <td>{!! get_sub_field('year_established') !!}</td>
                </tr>
              @endwhile
            </tbody>
          </table-->
          <ul id="list-nav-name">
            <div class="fund-name-title">Fund Name</div>
            <div class="fund-year-established">Year Established</div>
          @while (have_rows('heritage_fund_list'))@php(the_row())
            <li>
              <div class="fund-name">{!! get_sub_field('fund_name') !!}</div>
              <span class="fund-year fr">{!! get_sub_field('year_established') !!}</span>
            </li>
          @endwhile
        </div>
      </div>
    </div>
  </div>
</section>
@endif
