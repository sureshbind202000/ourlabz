<!doctype html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ourlabz | Lab Tests | Health Checkups | Lab Products</title>



    @include('frontend.includes.css')

    <style>
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            /* padding: 24px; */
            /* max-width: 500px; */
            margin: 0 auto;
            left: 0;
            background-color: white;
            right: 0;
            z-index: 10;
        }

        .nav-box {
            display: flex;
            background-color: #fff;
            box-shadow: 0px 0px 16px 0px #4444;
            border-radius: 8px;
            padding-bottom: 20px;
        }

        .nav-container {
            display: flex;
            width: 100%;
            list-style: none;
            justify-content: space-around;
        }

        .nav__item {
            display: flex;
            position: relative;
            padding: 2px;
        }

        /* .nav__item.active .nav__item-icon {
        margin-top: -50%;
        width: 70px;
        height: 70px;
        line-height: 1.5;
        font-size: 12px;
        border-radius: 100%;
        box-shadow: ;
    } */
        .nav__item.active .nav__item-icon {
            margin-top: -12px;
            box-shadow: 0px 0px 16px 0px #4444;
        }

        .nav__item.active .nav__item-text {
            transform: scale(1);
        }

        .nav__item-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* color: #0095d9; */
            text-decoration: none;
        }

        .nav__item-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            /* font-size: 1.6em; */
            background-color: #fff;
            border-radius: 50%;
            height: 46px;
            color: #0095d9;
            width: 46px;
            transition: margin-top 250ms ease-in-out, box-shadow 250ms ease-in-out;
        }

        .nav__item-text {
            position: absolute;
            bottom: 0;
            transform: scale(1);
            transition: transform 250ms ease-in-out;
            font-size: 11px;
            top: 39px;
        }

        .bottom-nav .fa-solid,
        .fas {
            font-weight: 900;
        }

        /* Border Design  */
        @-webkit-keyframes rotate {
            100% {
                transform: rotate(1turn);
            }
        }

        @keyframes rotate {
            100% {
                transform: rotate(1turn);
            }
        }

        .rainbow {
            position: relative;
            z-index: 0;
            border-radius: 100%;
            overflow: hidden;
            /* padding: 2rem; */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
            font-weight: bold;
        }

        .rainbow::before {
            content: "";
            position: absolute;
            z-index: -2;
            left: -50%;
            top: -50%;
            width: 200%;
            height: 200%;
            background-color: #a3e2ff;
            background-repeat: no-repeat;
            background-size: 50% 50%, 50% 50%;
            background-position: 0 0, 100% 0, 100% 100%, 0 100%;
            background-image: linear-gradient(#e0f5ffd0, #a3e2ff), linear-gradient(#0eadf7d0, #0095d9), linear-gradient(#e0f5ffd0, #a3e2ff), linear-gradient(#0eadf7d0, #0095d9);
            -webkit-animation: rotate 4s linear infinite;
            animation: rotate 4s linear infinite;
        }

        .rainbow::after {
            content: "";
            position: absolute;
            z-index: -1;
            /* left: 6px; */
            /* top: 6px; */
            width: calc(100% - 8px);
            height: calc(100% - 8px);
            background-color: #e0f5ff;
            border-radius: 100%;
        }

        .card-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 15px;
        }

        .offer-banner {
            background: #00a976;
            color: white;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 11px;
        }

        .bottom-bar {
            background: white;
            padding: 10px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            bottom: 0;
        }

        .btn-proceed {
            background: linear-gradient(to right, #feba4f, #ffa837);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
        }
    </style>

</head>



<body class=" home-3 ">

    <!-- preloader -->

    <div class="preloader">

        <div class="loader-ripple">

            <div></div>

            <div></div>

        </div>

    </div>

    <!-- preloader end -->



    <!-- header area -->



    <div class="home-2">

        <header class="header">



            <!-- header top -->
            <div class="header-top text-center text-white">
                @php
                // Get active coupons (as you already have)
                $coupons = getActiveCoupons(['products', 'lab_tests','doctors'], 2, true);
                // Pick one coupon from the collection
                $c = $coupons->isNotEmpty() ? $coupons->first() : null;
                @endphp

                @if($c)
                <p class="small mb-1">
                    🎁 Get <strong>
                        {{ $c->discount_type == 'percentage' ? $c->discount_value.'%' : '₹'.$c->discount_value }} OFF*
                    </strong>
                    @if($c->min_cart_amount)
                    on orders above ₹{{ $c->min_cart_amount }}
                    @endif
                    Use: <strong>{{ $c->code }}</strong>
                </p>
                @else
                <p class="small">No offers available</p>
                @endif
            </div>
            <!-- header top end -->





            <!-- navbar -->

            <div class="main-navigation bg-white">

                <nav class="navbar navbar-expand-lg border-bottom p-0">

                    <div class="container position-relative">

                        <a class="navbar-brand" href="{{ route('index') }}">

                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" style="width: 60px;">

                        </a>

                        <div class=" ms-xl-5 d-none d-lg-block">



                            <div class="input-group align-items-center px-2 mx-1" style="cursor: pointer;width: 180px;">

                                <span class=""><img src="{{ asset('assets/img/icon/location-pin.gif') }}"

                                        alt="" style="height: 35px;"></span>

                                <input type="text"

                                    class="form-control  border-0 border-bottom border-2 rounded-0 shadow-none"

                                    data-bs-toggle="modal" href="#exampleModalToggle" role="button" id="selectedCityLabel" value="{{ session('selected_city', 'Location') }}"

                                    readonly style="cursor: pointer;">

                            </div>





                        </div>

                        <div class="mobile-menu-right">

                            <div class="mobile-menu-btn">
                                <div class=" ms-xl-5 ">



                                    <div class="input-group align-items-center ps-2  "
                                        style="cursor: pointer;width: 180px;">



                                        <input type="text"
                                            class="form-control  border-0 text-end fw-bold rounded-0 shadow-none "
                                            data-bs-toggle="modal" href="#exampleModalToggle" role="button" value="Lucknow"
                                            readonly style="cursor: pointer;" id="selectedCityLabel2">
                                        <span class=""><img src="{{asset('assets/img/icon/location-pin.gif')}}" alt=""
                                                style="height: 35px;"></span>
                                    </div>

                                </div>
                                <a href="{{route('login')}}" class="nav-right-link d-none d-lg-block"><i
                                        class="far fa-user"></i></a>
                                <a href="javascript:void(0);" class="nav-right-link search-box-outer  d-none d-lg-block"><i class="far fa-search"></i></a>

                                <a href="javascript:void(0);" class="nav-right-link wishlist-link  d-none d-lg-block"><i

                                        class="far fa-heart"></i>
                                    <span class="product-wishlist-count" style="display: none;">0</span>
                                </a>

                                <a href="javascript:void(0);" class="nav-right-link cart-icon-handler  d-none d-lg-block"><i

                                        class="far fa-shopping-bag"></i><span class="cart-total-count" style="display: none;">0</span></a>

                            </div>

                            <button class="navbar-toggler d-none d-lg-block" type="button" data-bs-toggle="offcanvas"

                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"

                                aria-label="Toggle navigation">

                                <span></span>

                                <span></span>

                                <span></span>

                            </button>

                        </div>

                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"

                            aria-labelledby="offcanvasNavbarLabel">

                            <div class="offcanvas-header">

                                <a href="{{ route('index') }}" class="offcanvas-brand" id="offcanvasNavbarLabel">

                                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" style="height: 66px;">

                                </a>

                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"

                                    aria-label="Close"></button>

                            </div>

                            <div class="offcanvas-body">

                                <ul class="navbar-nav flex-grow-1 justify-content-center">
                                   
                                    <li class="nav-item">

                                        <a class="nav-link small fw-bold" href="{{route('index')}}">Home</a>

                                    </li>

                                    <li class="nav-item">

                                        <a class="nav-link small fw-bold book-test" href="{{route('lab.test')}}">Book Test</a>

                                    </li>

                                    <li class="nav-item"><a class="nav-link small fw-bold"

                                            href="{{route('corporate.index')}}">Corporate</a>

                                    </li>



                                    <li class="nav-item dropdown">

                                        <a class="nav-link small fw-bold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>

                                        <div class="dropdown-menu fade-down">

                                            <ul class="mega-menu-item">

                                                <li><a class="dropdown-item require-corporate-login" href="{{route('corporate.doctorConsult')}}">Doctor Consultation</a></li>

                                                <li><a class="dropdown-item require-corporate-login" href="{{route('corporate.labTest')}}">Lab Test</a></li>

                                                <li><a class="dropdown-item require-corporate-login" href="{{route('corporate.hospitalAssistance')}}">Hospital Assistance</a></li>

                                            </ul>

                                        </div>

                                    </li>

                                    <li class="nav-item"><a class="nav-link small fw-bold"

                                            href="{{route('contact')}}">Contact Us</a></li>

                                </ul>

                                <!-- nav-right -->



                                <div class="nav-right">

                                    @guest

                                    <a href="javascript:void(0);" class="nav-right-link user-login-trigger">

                                        <i class="far fa-user"></i>

                                    </a>

                                    @endguest



                                    @auth

                                    <a href="{{ route('user.dashboard') }}" class="nav-right-link">

                                        <i class="far fa-user"></i>

                                    </a>

                                    @endauth



                                    <a href="#" class="nav-right-link search-box-outer">

                                        <i class="far fa-search"></i>

                                    </a>

                                    <a href="javascript:void(0);" class="nav-right-link wishlist-link">

                                        <i class="far fa-heart"></i>

                                        <span class="product-wishlist-count" style="display: none;">0</span>

                                    </a>

                                    <a href="javascript:void(0);" class="nav-right-link cart-icon-handler">

                                        <i class="far fa-shopping-bag me-1"></i>

                                        <span class="cart-total-count" style="display: none;">0</span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </nav>

            </div>

            <!-- navbar end -->



        </header>

    </div>



    <!-- header area end -->





    <!-- mobile popup search -->

    <div class="search-popup">

        <button class="close-search"><span class="far fa-times"></span></button>

        <form action="#">

            <div class="form-group">

                <input type="search" name="search-field" class="form-control" placeholder="Search Here..." required>

                <button type="submit"><i class="far fa-search"></i></button>

            </div>

        </form>

    </div>

    <!-- mobile popup search end -->



    @yield('content')



    @include('frontend.includes.footer')
    <!-- bottom nav  -->
    <section>
        <div class="row mx-auto d-lg-none w-100 add-card mobile-bottom-cart" style="bottom: 65px; position: fixed; z-index: 2;">
            <div class="col-sm-12 p-0 py-1">
                <div class="card h-100 p-2 pb-3 border ">

                    <div class="card-body p-0 ">

                        <div class="d-flex gap-2">

                            <div class="border rounded-2 test-image" style="height: 40px; width: 40px;">
                                <img src="assets/img/icon/cart.png" alt="" style="height: 40px; width: 40px; padding: 9px; text-align: center;">
                            </div>

                            <div class="w-100">

                                <div>
                                    <p><span class="fw-bold mobile-cart-total-amount">₹0.00</span> <small class="text-muted">( <span class="mobile-cart-total-count" style="display: none;">0</span> item)</small></p>
                                </div>
                                <div class=" gap-2 d-flex  price" style="margin-top: -7px;">
                                    <a href="#" class="small px-0 text-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#viewCartCanvas" aria-controls="viewCartCanvas">View Cart </a>

                                    <a href="javascript:void(0);" type="button" class="theme-btn cart-icon-handler" style="margin-top: -20px;">Proceed </a>

                                </div>

                            </div>

                        </div>
                        @php
                        // Fetch active coupons for products and lab tests, limit 2, random order
                        $coupons = getActiveCoupons(['products', 'lab_tests'], 2, true);

                        // Pick only one coupon to display
                        $c = $coupons->isNotEmpty() ? $coupons->first() : null;
                        @endphp

                        @if($c)
                        <p class="offer-banner mt-2">
                            🎁 Get <strong>
                                {{ $c->discount_type == 'percentage' ? $c->discount_value.'%' : '₹'.$c->discount_value }} OFF*
                            </strong>
                            @if($c->min_cart_amount)
                            on orders above ₹{{ $c->min_cart_amount }}
                            @endif
                            Use: <strong>{{ $c->code }}</strong>
                        </p>
                        @else
                        <p class="offer-banner">No offers available</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <nav class="bottom-nav d-lg-none">
        <div class="nav-box">
            <ul class="nav-container">
                <li class="nav__item ">
                    <a href="javascript:void(0);" class="nav__item-link user-login-trigger">
                        <div class="nav__item-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="nav__item-text">{{ auth()->check() ? 'Profile' : 'Login' }}</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="javascript:void(0);" class="nav__item-link search-box-outer">
                        <div class="nav__item-icon">
                            <i class="fas fa-search"></i><br>
                        </div>
                        <span class="nav__item-text ">Search</span>
                    </a>
                </li>
                <li class="nav__item active">
                    <a href="{{ route('lab.test') }}" class="nav__item-link ">
                        <div class="nav__item-icon rainbow">
                            <i class="fa-solid fa-microscope"></i>
                        </div>
                        <span class="nav__item-text">Book Test</span>
                    </a>
                </li>
                <!-- <li class="nav__item active">
                <a href="#Messages" class="nav__item-link">
                    <div class="nav__item-icon text-center fw-bold shadow-sm rainbow">
                        BOOK <br> TEST
                    </div>
                </a>
            </li> -->
                <li class="nav__item">
                    <a href="{{route('shop')}}" class="nav__item-link">
                        <div class="nav__item-icon">
                            <i class="fas fa-shop"></i>
                        </div>
                        <span class="nav__item-text">Shop</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="#Settings" class="nav__item-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <div class="nav__item-icon">
                            <i class="fa-solid fa-bars fs-3"></i>
                        </div>
                        <span class="nav__item-text">Menu</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- view cart for mobile  -->
    <div class="offcanvas offcanvas-bottom " tabindex="-1" id="viewCartCanvas" aria-labelledby="viewCartCanvasLabel" style="height: 65vh;background: #f8f8f8;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="viewCartCanvasLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small p-0">
            <div class="container py-4" style="max-width: 400px;">

                <div id="mobileCartItems"></div> <!-- Dynamic items go here -->

                <p class="text-muted mb-4" style="font-size: 13px;">
                    Tests added here are for <strong>1 member</strong>. You can add or remove members in the next step.
                </p>

                @php
                // Fetch active coupons for products and lab tests, limit 2, random order
                $coupons = getActiveCoupons(['products', 'lab_tests'], 2, true);

                // Pick only one coupon to display
                $c = $coupons->isNotEmpty() ? $coupons->first() : null;
                @endphp

                @if($c)
                <p class="offer-banner">
                    🎁 Get <strong>
                        {{ $c->discount_type == 'percentage' ? $c->discount_value.'%' : '₹'.$c->discount_value }} OFF*
                    </strong>
                    @if($c->min_cart_amount)
                    on orders above ₹{{ $c->min_cart_amount }}
                    @endif
                    Use: <strong>{{ $c->code }}</strong>
                </p>
                @else
                <p class="offer-banner">No offers available</p>
                @endif

            </div>
            <div class="bottom-bar">
                <div>
                    <div class="fw-semibold fs-5">₹0.00</div>
                    <div class="text-muted" style="font-size: 13px;">0 Item</div>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary border-0 cart-icon-handler">Proceed</a>
            </div>
        </div>
    </div>
    @include('frontend.includes.modal')
    @include('frontend.includes.js')

</body>



</html>