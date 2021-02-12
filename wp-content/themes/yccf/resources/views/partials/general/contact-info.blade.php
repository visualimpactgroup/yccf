@if(is_page('contact-us'))
<div class="columns is-multiline is-mobile is-contact">
    <div class="column is-12-mobile is-5-tablet is-5-desktop is-5-widescreen">
      <div class="content no-spacing">
        <ul class="cinfo">
          @if($globalvalue->address)
          <li>
            <div class="address-line">{!! $globalvalue->address !!}</div>
            <div class="city-line">{!! $globalvalue->city !!}, {!! $globalvalue->state !!} {!! $globalvalue->zip !!}</div>
          </li>
          @endif
          &nbsp;
          @if($globalvalue->yorkphone)
          <li>
            <div><strong>Tel:</strong> {!! $globalvalue->yorkphone !!} <em>(York)</em></div>
          </li>
          @endif
          @if($globalvalue->hanoverphone)
          <li>
            <div><strong>Tel:</strong> {!! $globalvalue->hanoverphone !!} <em>(Hanover)</em></div>
          </li>
          @endif
          @if($globalvalue->fax)
          <li class="fax-list">
            <div><strong>Fax:</strong> {!! $globalvalue->fax !!}</div>
          </li>
          @endif
          &nbsp;
          @if($globalvalue->email)
          <li class="email-list">
            <div class="email-line"><strong>General Inquiries</strong>: <a href="mailto:{!! $globalvalue->email !!}">{!! $globalvalue->email !!}</a></div>
          </li>
          @endif
          &nbsp;
          @if(have_rows('operation_hours', 'cpt_sitew'))
            @while (have_rows('operation_hours', 'cpt_sitew'))@php(the_row())
            <li class="hours">
              <div><strong>Office Hours:</strong><br>{!! get_sub_field('operation_day') !!} - {!! get_sub_field('operation_time') !!}</div>
            </li>
            @endwhile
          @endif
        </ul>

        @if(have_rows('buttons'))
          <div class="button-block">
            @while (have_rows('buttons'))@php(the_row())
              <a class="more ept {!! get_sub_field('cta_type') !!}" href="{!! get_sub_field('cta_link')['url'] !!}" title="{!! get_sub_field('cta_link')['title'] !!}" target="{!! get_sub_field('cta_link')['target'] !!}">{!! get_sub_field('cta_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
            @endwhile
          </div>
        @endif
      </div>
    </div>
    <div class="column is-12-mobile is-7-tablet is-7-desktop is-7-widescreen">
      <?php
      $formTitle  = get_field('form_instructions');
      $formShort  = get_field('form_shortcode');
      if($formTitle != ''){
        echo '<h2>'.$formTitle.'</h2>';
      }

      if($formShort != ''){
        echo do_shortcode($formShort);
      }
      ?>
    </div>
  </div>
</div>
@endif
