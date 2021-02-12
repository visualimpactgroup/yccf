@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.front-page.hero')
    @include('partials.front-page.page-navigation')
    @include('partials.front-page.about')
    @include('partials.front-page.footer-feed')
  @endwhile
@endsection
