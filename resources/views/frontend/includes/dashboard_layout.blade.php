<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Ourlabz - Health And Medical</title>
  @include('frontend.includes.css')
</head>

<body class=" home-3 ">
  @include('frontend.includes.header')
  <main class="main">
    <!-- user dashboard -->
    <div class="user-area bg pt-50 pb-50">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            @include('frontend.includes.sidemenu')
          </div>
          <div class="col-lg-9">
            @yield('dash_content')
          </div>
        </div>
      </div>
    </div>
    <!-- user dashboard end -->

  </main>
  @yield('content')

  @include('frontend.includes.modal')
  @include('frontend.includes.footer')
  
  @include('frontend.includes.js')
</body>

</html>