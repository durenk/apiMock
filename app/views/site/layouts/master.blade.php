<!doctype html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>@yield('title', trans("presentation.app_name"))</title>
  <meta name="description" content="@yield('description', Config::get('site.description'))">

  <link rel="canonical" href="{{ URL::current() }}">

  <meta name="base_url" content="{{ URL::to('/') }}">
  <meta name="_token" content="{{ csrf_token() }}" />

  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">

  <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
  <script src="{{ asset('assets/js/vendor/modernizr.js') }}"></script>

  @yield('styles')

  <link rel="author" href="{{ url('humans.txt') }}">

  <script>
    window.base_url = '{{ URL::to('/') }}';
  </script>

  </head>
  <body>

    <div class="container">
      @yield('content')
      <hr />
      <footer>
          <p class="text-center">
            <strong class="alert alert-success">Idea &amp; Inspiration from <a href="http://www.mocky.io/" target="_blank">Mocky</a></strong>
            Made by <a href="https://github.com/durenk" target="_blank">Dedy Ibnu</a>.
            You can <a href="https://github.com/durenk/apiMock" target="_blank">fork me <img src="{{ asset('assets/img/octocat.png') }}" /></a>
          </p>
      </footer>
    </div>

    <script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

     <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
      <script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
      <![endif]-->

    @yield('scripts')
  
  </body>

</html>