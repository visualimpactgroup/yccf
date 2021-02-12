{{--
  Template Name: Home Page
--}}

@extends('layouts.app')
@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.hero')
  @endwhile
@endsection
