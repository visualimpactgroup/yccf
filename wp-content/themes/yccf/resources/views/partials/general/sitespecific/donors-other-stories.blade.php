<section class="other-stories main-content">
  <div class="columns">
    <div class="column">
      <h4>Meet Some of Our Other Donor's</h4>
    </div>
    <div class="column">
      <a class="more fr" href="/for-donors/our-donors/donor-stories/" title="See All Donor Stories">See All Donor Stories{!! $globalvalue->moreafter !!}</a>
    </div>
  </div>
  <div class="columns">
    @php
      echo do_shortcode('[recentdonorstories]');
    @endphp
  </div>
</section>
