{{--
  Template Name: Internal Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
  @include('partials.internal-page.internal-page-hero')
  <div class="page-content" id="main-content">
    @include('partials.general.breadcrumbs')
    @include('partials.general.main-content')
    @include('partials.general.contact-info')
    @include('partials.general.sitespecific.publications')
    @include('partials.general.sitespecific.media-center')
    @include('partials.general.sitespecific.scholarships')
    @include('partials.general.sitespecific.dollars-for-scholars')
    @include('partials.general.sitespecific.donor-stories-main')
    @include('partials.general.sitespecific.list-of-funds')
    @include('partials.general.block-cta')
    @include('partials.general.shortcodes')
  </div>
  @endwhile
@endsection
