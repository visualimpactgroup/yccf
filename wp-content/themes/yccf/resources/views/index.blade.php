@extends('layouts.app')

@section('content')
<section class="blog-content main-content">
  <div class="column is-full">
    @include('partials.page-header')
  </div>
  <section class="double-block">
    <div class="columns is-multiline">
    @while (have_posts()) @php(the_post())
      @include('partials.content-'.get_post_type())
    @endwhile
    </div>
  </section>
</section>
@endsection
