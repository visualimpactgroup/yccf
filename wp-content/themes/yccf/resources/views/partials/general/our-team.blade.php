@if(have_rows('our_team'))
<section class="our-team main-content">
    <div class="column is-multiline">
      @while (have_rows('our_team'))@php(the_row())
      <div class="column team-member">
        @if(get_sub_field('team_member_photo') != '')
        <img src="{!! get_sub_field('team_member_photo')['url'] !!}" alt="{!! get_sub_field('team_member_name') !!}">
        @endif

        @if(get_sub_field('team_member_name') != '')
        <div class="name">{!! get_sub_field('team_member_name') !!}</div>
        @endif

        @if(get_sub_field('team_member_title') != '')
        <div class="title">{!! get_sub_field('team_member_title') !!}</div>
        @endif

        @if(get_sub_field('team_member_email') != '')
        <a href="mailto:{!! get_sub_field('team_member_email') !!}" class="name">Contact {!! get_sub_field('team_member_name') !!}</a>
        @endif
      </div>
      @endwhile;
    </div>
</section>
@endif
