@if(is_page('donor-list'))
<section class="section-donor-list main-content">
  <div class="columns is-paddingless">
    <div class="column">
      <!--Tab Titles-->
      <div id="tabs" class="tabs is-left is-toggle is-boxed">
        <ul>
          @if(have_rows('individual'))
          <li class="is-active" data-tab="1"><a>Individuals</a></li>
          @endif
          @if(have_rows('in_memory_of'))
          <li data-tab="2"><a>In Memory Of</a></li>
          @endif
          @if(have_rows('in_kind'))
          <li data-tab="3"><a>In-Kind</a></li>
          @endif
          @if(have_rows('estate_gifts'))
          <li data-tab="4"><a>Estate Gifts</a></li>
          @endif
          @if(have_rows('corporations'))
          <li data-tab="5"><a>Corporations / Institutions / Nonprofits</a></li>
          @endif
        </ul>
      </div><!--/Tab Titles-->
      <!--Tab Content-->
      <div id="tab-content">
        @if(have_rows('individual'))
        <div class="tab-container is-active" data-content="1">
          <table class="table is-striped is-fullwidth is-responsive tablesorter1">
            <thead>
              <tr>
                <th>Donor Name</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('individual'))@php(the_row())
              <tr>
                <td>{!! get_sub_field('donor_name') !!}</td>
              </tr>
              @endwhile
            </tbody>
          </table>
        </div>
        @endif
        @if(have_rows('in_memory_of'))
        <div class="tab-container" data-content="2">
          <table class="table is-striped is-fullwidth is-responsive tablesorter2">
            <thead>
              <tr>
                <th>Donor Name</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('in_memory_of'))@php(the_row())
              <tr>
                <td>{!! get_sub_field('donor_name') !!}</td>
              </tr>
              @endwhile
            </tbody>
          </table>
        </div>
        @endif

        @if(have_rows('in_kind'))
        <div class="tab-container" data-content="3">
          <table class="table is-striped is-fullwidth is-responsive tablesorter3">
            <thead>
              <tr>
                <th>Donor Name</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('in_kind'))@php(the_row())
              <tr>
                <td>{!! get_sub_field('donor_name') !!}</td>
              </tr>
              @endwhile
            </tbody>
          </table>
        </div>
        @endif

        @if(have_rows('estate_gifts'))
        <div class="tab-container" data-content="4">
          <table class="table is-striped is-fullwidth is-responsive tablesorter4">
            <thead>
              <tr>
                <th>Donor Name</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('estate_gifts'))@php(the_row())
              <tr>
                <td>{!! get_sub_field('donor_name') !!}</td>
              </tr>
              @endwhile
            </tbody>
          </table>
        </div>
        @endif

        @if(have_rows('corporations'))
        <div class="tab-container" data-content="5">
          <table class="table is-striped is-fullwidth is-responsive tablesorter5">
            <thead>
              <tr>
                <th>Donor Name</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('corporations'))@php(the_row())
              <tr>
                <td>{!! get_sub_field('donor_name') !!}</td>
              </tr>
              @endwhile
            </tbody>
          </table>
        </div>
        @endif
      </div><!--/Tab Content-->
    </div>
  </div>
</section>
@endif
