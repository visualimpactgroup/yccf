@extends('layouts.app')

@section('content')
  @if (!have_posts())
    <section class="main-content error-page">
      <div class="columns">
        <div class="column">
          <h2>Uh Oh, This Probably Isn't Where You Wanted to Go</h2>
          <p>{{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}</p>
          <div class="button-block">
            <a class="more Styled" href="/" title="Return to Home">Return to Homepage</a>
          </div>
        </div>
      </div>
    </section>
  @endif
@endsection
