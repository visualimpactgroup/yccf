{{--
  Template Name: Internal Page w/ Large Hero
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.internal-page.internal-page-tallhero')
    <div class="page-content" id="main-content">
      @include('partials.general.breadcrumbs')
      @include('partials.general.main-content')
      @include('partials.general.sitespecific.endowment-faqs')
      @include('partials.general.sitespecific.giving')
      @include('partials.general.sitespecific.endowment')
      @include('partials.general.sitespecific.donor-stories')
      @include('partials.general.sitespecific.donor-resources')
      @include('partials.general.double-block')
    </div>
  @endwhile
@endsection
