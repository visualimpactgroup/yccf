{{--
  Template Name: Landing Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.landing-page.landing-page-hero')
    <div class="page-content" id="main-content">
      @include('partials.general.breadcrumbs')
      @include('partials.general.main-content')
      @include('partials.general.sitespecific.list-of-funds')
      @include('partials.general.sitespecific.heritage-funds')
      @include('partials.general.sitespecific.donor-list-tabs')
      @include('partials.general.double-block')
      @include('partials.general.block-cta')
    </div>
  @endwhile
@endsection
