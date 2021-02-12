<section class="main-content bio-block">
  <div class="columns">
    <div class="column is-12">
      <h1>
        {!! the_field('staff_name'); !!}@if(get_field('staff_title')), {!! get_field('staff_title') !!}@endif
      </h1>
      <div class="contact-info">
        @if(get_field('staff_phone') == 'york')
          <span class="cblock">
            {!! get_field('phone_icon', 'cpt_sitew') !!} {!! get_field('york_phone', 'cpt_sitew') !!}
            @if(get_field('staff_phone_extension'))
            / {!! get_field('staff_phone_extension') !!}
            @endif
          </span>
        @endif
        @if(get_field('staff_email'))
          <span class="cblock">{!! get_field('email_icon', 'cpt_sitew') !!}{!! get_field('staff_email') !!}</span>
        @endif
      </div>
      @if(get_field('photo') == 'yes')
        @if(get_field('staff_image'))
          <figure class="profile-photo alignright">
            <img src="{!! get_field('staff_image')['url'] !!}" alt="{!! the_field('staff_name'); !!}">
          </figure>
        @endif
      @endif
      @php(the_content())
    </div>
  </div>
</section>
