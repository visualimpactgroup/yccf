@if(have_rows('locations'))
<section class="section-donor-list fund-list main-content">
  <div class="columns">
    <div class="column is-paddingless">
      <div id="tab-content">
        <div class="tab-container is-active" data-content="1">
          <table class="table is-striped is-fullwidth is-responsive tablesorter1">
            <thead>
              <tr>
                <th>School</th>
                <!--th>Phone</th-->
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              @while (have_rows('locations'))@php(the_row())
                <tr>
                  <td>
                    @if(get_sub_field('school_name') != '')
                      {!! get_sub_field('school_name') !!}
                    @endif
                  </td>
                  <!--td>
                    @if(get_sub_field('contact_number') != '')
                      {!! get_sub_field('contact_number') !!}
                    @endif
                  </td-->
                  <td>
                    @if(get_sub_field('contact_email') != '')
                      {!! get_sub_field('contact_email') !!}
                    @endif
                  </td>
                </tr>
              @endwhile
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endif
