{{--
  Template Name: Landing Page w/ Hero
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.landing-page.landing-page-hero')
    <div class="page-content" id="main-content">
      @include('partials.general.double-block')
      @include('partials.general.block-cta')
    </div>
  @endwhile
@endsection
