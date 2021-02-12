<div style="display: none;" id="search" class="search-styles animated-modal">
  <form class="search-form" role="search" method="get" action="{{ home_url('/') }}">
    <div class="positioned">
      <label class="search-for">
        <span class="screen-reader-text">Search for:</span>
        <input type="search" class="search-field input input--search" placeholder="What are you looking for?" value="" name="s" title="Search for:">
      </label>
      <button type="submit">
        {!! $globalvalue->searchicon !!}
        <span class="screen-reader-text">Search</span>
      </button>
    </div>
  </form>
</div>
