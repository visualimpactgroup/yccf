@if(!is_page('donor-stories'))
<section class="breadcrumbs main-content">
  <div class="columns">
    <div class="column">
      @php
        echo do_shortcode('[wpseo_breadcrumb]');
      @endphp
    </div>
  </div>
</section>
@endif
