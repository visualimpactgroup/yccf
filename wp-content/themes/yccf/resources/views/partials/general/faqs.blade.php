@if(have_rows('faqs'))
<section class="faq-block">
  @while (have_rows('faqs'))@php(the_row())
    <div class="toggle">
      <div class="toggle-title">
        <div class="title">
          <i></i>
          <span class="title-name">{!! get_sub_field('faq_title') !!}</span>
        </div>
      </div>
      <div class="toggle-inner">
        {!! get_sub_field('faq_content') !!}
      </div>
    </div>
  @endwhile
</section>
@endif
