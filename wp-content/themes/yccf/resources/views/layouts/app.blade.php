<!doctype html>
<html @php(language_attributes())>
  @include('partials.global.head')
  <body @php(body_class())>
    @include('partials.general.modal')
    @php(do_action('get_header'))
    @include('partials.global.header')
    <div class="site-container" role="document">
        <main class="main">
          @yield('content')
        </main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
    </div>
    @php(do_action('get_footer'))
    @include('partials.global.footer')
    @php(wp_footer())
  </body>
</html>
