<!doctype html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ourlabz | Lab Tests | Health Checkups | Lab Products</title>

    @include('frontend.includes.css')

    <style>

        .footer-widget {

            display: none;

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



    <div class="home-2">

        <header class="header">



            <!-- header top -->

            <div class="header-top">

                <div class="container-fluid">

                    <div class="header-top-wrapper">

                        <div class="row py-0">

                            <div class="col-sm-12 py-0 text-white text-center">

                                <p>Free Shipping on Orders Over ₹999 - Shop Now!</p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- header top end -->





            <!-- navbar -->

            <div class="main-navigation">

                <nav class="navbar navbar-expand-lg border-bottom">

                    <div class="container position-relative">

                        <a class="navbar-brand" href="{{route('index')}}">

                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" style="width: 60px;">

                        </a>

                        <!-- <div class="category-all">



                            <div class="header-middle-search">

                                <form action="#">

                                    <div class="search-content p-0">

                                        <div class="input-group align-items-center px-2 border-end w-50"

                                            style="cursor: pointer;">

                                            <span class=""><img src="{{ asset('assets/img/icon/location-pin.gif') }}" alt=""

                                                    style="height: 30px;"></span>

                                            <input type="text" class="form-control" data-bs-toggle="modal"

                                                href="#exampleModalToggle" role="button" value="Lucknow" readonly

                                                style="cursor: pointer;">

                                        </div>

                                        <input type="text" class="form-control" placeholder="Search Here...">

                                        <button type="submit" class="search-btn"><i class="far fa-search"></i></button>

                                    </div>

                                </form>

                            </div>

                        </div> -->



                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"

                            aria-labelledby="offcanvasNavbarLabel">

                            <div class="offcanvas-header">

                                <a href="index.html" class="offcanvas-brand" id="offcanvasNavbarLabel">

                                    <img src="assets/img/logo/logo.png" alt="">

                                </a>

                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"

                                    aria-label="Close"></button>

                            </div>

                            <div class="offcanvas-body px-2">

                                <ul class="navbar-nav flex-grow-1 justify-content-end header-top-list"

                                    style="align-items: center;">





                                    <li><a href="#home" class="scroll-link border-end pe-3"> Home</a></li>

                                    <li><a href="#test" class="scroll-link border-end pe-3"> Test</a></li>

                                    <li><a href="#gallery" class="scroll-link border-end pe-3"> Gallery</a></li>

                                    <li><a href="#about" class="scroll-link border-end pe-3"> About</a></li>

                                    <li><a href="#map" class="scroll-link border-end pe-3"> Map</a></li>

                                    <li><a href="{{ route('index') }}" class="border-end pe-3"> Ourlabz</a></li>



                                    <!-- <li>

                                        <div class="dropdown">

                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

                                                <i class="far fa-globe-americas"></i> EN

                                            </a>

                                            <div class="dropdown-menu px-1">

                                                <a class="dropdown-item border-bottom" href="#">English - EN</a>

                                                <a class="dropdown-item border-bottom" href="#">हिंदी - HI</a>

                                                <a class="dropdown-item border-bottom" href="#">मराठी - MR</a>

                                                <a class="dropdown-item border-bottom" href="#">বেঙ্গলি - BN</a>

                                            </div>

                                        </div>

                                    </li> -->



                                </ul>

                                <!-- nav-right -->



                                <!-- <div class="nav-right">

                                        <div class="header-middle-right">

                                            <ul class="header-middle-list">

                                                <li>

                                                    <a href="#" class="list-item" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">

                                                        <div class="list-item-icon">

                                                            <i class="far fa-user-circle"></i>

                                                        </div>

                                                        <div class="list-item-info">

                                                            <h6>Sign In</h6>

                                                            <h5>Account</h5>

                                                        </div>

                                                    </a>

                                                </li>





                                            </ul>

                                        </div>

                                    </div> -->

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

                <input type="search" name="search-field" class="form-control" placeholder="Search Here..."

                    required>

                <button type="submit"><i class="far fa-search"></i></button>

            </div>

        </form>

    </div>

    <!-- mobile popup search end -->

    <!-- modal start  -->

    <div class="modal fade modal-lg" id="exampleModalToggle" aria-hidden="true"

        aria-labelledby="exampleModalToggleLabel" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content ">

                <div class="modal-header text-center border-0">

                    <h1 class="text-center fs-5" style="margin-top: -0px;">Choose your City</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body ">

                    <div class="row">

                        <div class="col-sm-10 mx-auto">

                            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5  py-5 g-2">

                                <div class="col">

                                    <div class="card h-100 border-0 border-0">

                                        <div class="card-body">

                                            <div class="city-icon text-center" onclick="selectCity('Mumbai')"

                                                data-bs-dismiss="modal" aria-label="Close">

                                                <img src="assets/img/city/Mumbai.png" alt="#">

                                                <p>Mumbai</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col">

                                    <div class="card h-100 border-0">

                                        <div class="card-body">

                                            <div class="city-icon text-center" onclick="selectCity('Jaipur')"

                                                data-bs-dismiss="modal" aria-label="Close">

                                                <img src="assets/img/city/jaipur.png" alt="#">

                                                <p>Jaipur</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col">

                                    <div class="card h-100 border-0">

                                        <div class="card-body">

                                            <div class="city-icon text-center" onclick="selectCity('Chennai')"

                                                data-bs-dismiss="modal" aria-label="Close">

                                                <img src="assets/img/city/chennai.png" alt="#">

                                                <p>Chennai</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col">

                                    <div class="card h-100 border-0">

                                        <div class="card-body">

                                            <div class="city-icon text-center" onclick="selectCity('Bangalore')"

                                                aria-label="Close">

                                                <img src="assets/img/city/Bangalore.png" alt="#">

                                                <p>Bangalore</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col">

                                    <div class="card h-100 border-0">

                                        <div class="card-body">

                                            <div class="city-icon text-center" onclick="selectCity('Delhi')"

                                                data-bs-dismiss="modal" aria-label="Close">

                                                <img src="assets/img/city/Delhi.png" alt="#">

                                                <p>Delhi</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- <div class="col">

                                <div class="card h-100 border-0">

                                    <div class="card-body">

                                        <div class="city-icon text-center" onclick="selectCity('Trivandrum')"

                                            data-bs-dismiss="modal" aria-label="Close">

                                           <img src="assets/img/city/Trivandrum.png" alt="#">

                                            <p>Trivandrum</p>

                                        </div>

                                    </div>

                                </div>

                            </div> -->

                            </div>

                            <div class="row">

                                <div class="col-sm-10">

                                    <div class="header-middle-search">

                                        <form action="#">

                                            <div class="search-content border-0 rounded-0"

                                                style="border-bottom:2px solid #0095d9 !important;">



                                                <input type="text" class="form-control"

                                                    placeholder="Search Here...">

                                                <button type="submit" class="search-btn"><i

                                                        class="far fa-search"></i></button>

                                            </div>

                                        </form>

                                        <ul class="mt-3 text-dark">

                                            <li class="py-1">Mumbai</li>

                                            <li class="py-1">Delhi</li>

                                            <li class="py-1">Lucknow</li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- modal end -->

    @yield('content')

    @include('frontend.includes.footer')

    @include('frontend.includes.js')



</body>



</html>

