{{--
  Template Name: Kitchen Sink
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
  <div class="main-content">
    @include('partials.zzz_kitchensink.content')
    @include('partials.zzz_kitchensink.forms')
  </div>
  @endwhile
@endsection
