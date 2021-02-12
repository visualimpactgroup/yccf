@extends('layouts.app')
<?php
  $args = array(
  	'base'               => '%_%',
  	'format'             => '?paged=%#%',
  	'total'              => 1,
  	'current'            => 0,
  	'show_all'           => false,
  	'end_size'           => 1,
  	'mid_size'           => 2,
  	'prev_next'          => true,
  	'prev_text'          => __('« Previous'),
  	'next_text'          => __('Next »'),
  	'type'               => 'plain',
  	'add_args'           => false,
  	'add_fragment'       => '',
  	'before_page_number' => '',
  	'after_page_number'  => ''
  );
?>
@section('content')
  <section class="main-content search-results">
    @include('partials.page-header')
    @if (!have_posts())
    <div class="columns">
      <div class="column">
        <div class="alert alert-warning">
          {{  __('Sorry, no results were found.', 'sage') }}
        </div>
      </div>
    </div>
    @endif

    @while(have_posts()) @php(the_post())
      @include('partials.content-search')
    @endwhile

    <div class="columns">
      <div class="column">
        @php
        enollo_pagination();
        @endphp
      </div>
    </div>
  </section>
@endsection
