<section class="block-cta main-content">
  <div class="columns">
    <div class="column is-half">
      <div class="block-title">
        {!! $globalvalue->findtitle !!}
      </div>
      <div class="block-content">
        {!! $globalvalue->findcont !!}
        <div class="single-links">
          <a href="{!! $globalvalue->findcta['url'] !!}" class="sub-cta" title="{!! $globalvalue->findcta['title'] !!}">{!! $globalvalue->findcta['title'] !!}</a>
        </div>
      </div>
    </div>
    <div class="full-img" style="background: url({!! $globalvalue->findimg['url'] !!}) no-repeat center center;"></div>
  </div>
</section>
