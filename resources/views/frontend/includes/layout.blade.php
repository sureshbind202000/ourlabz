<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('seo_tags')

  @include('frontend.includes.css')
</head>

<body class=" home-3 ">
  @include('frontend.includes.header')
  @yield('content')

  @include('frontend.includes.modal')
  @include('frontend.includes.footer')
  @include('frontend.includes.js')
</body>

</html>