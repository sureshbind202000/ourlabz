<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medion - Health And Medical eCommerce HTML5 Template</title>
    
    @include('frontend.includes.css')
  </head>
  <body class=" home-3 ">
 <!-- coming soon -->
 <div class="coming-soon pt-100 pb-90" style="background: url('assets/img/coming-soon/01.jpg');">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <div class="coming-soon-content text-white text-center mt-50">
                        <h1 class="text-white title">We're Coming Soon</h1>
                        <p class="lead">Our website is under construction. We'll be here soon with our new awesome website,
                            subscribe to be notified.</p>
                        <div class="coming-soon-countdown">
                            <div class="countdown" data-countdown="2030/12/30"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 col-lg-5">
                    <form class="newsletter-form position-relative">
                        <input type="text" class="input-newsletter form-control" placeholder="Enter your email"
                            name="email" required="" autocomplete="off">
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="coming-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-x-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    <!-- coming soon end -->



    @include('frontend.includes.js')
  </body>
</html>