@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')

<main class="main">
    <!-- big banner -->
    <div class="container-fluid p-0 overflow-hidden">
        <div class="big-banner">
            <div class="  wow fadeInUp p-0" data-wow-delay=".25s">
                <div class="banner-wrap rounded-0" style="background-image: url({{asset('assets/img/banner/big-banner.jpg')}});">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="banner-content">
                                <div class="banner-info">
                                    <h6>Mega Collections</h6>
                                    <h2>Huge Sale Up To <span>40%</span> Off</h2>
                                    <p>at our outlet stores</p>
                                </div>
                                <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- big banner end -->
    <!-- category area -->
    <div class="category-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline">Our Category</span>
                        <h2 class="site-title">Our Popular <span>{{$type}} Category</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5  g-4">
                        @foreach($category as $c)
                        <div class="col">
                            <div class="category-item">
                                <a href="{{ route('lab.test', ['category' => $c->slug ]) }}">
                                    <div class="category-info">
                                        <div class="card  h-100 ">
                                            <div class="card-body px-0  ">
                                                <div class="icon">
                                                    <img src="{{asset($c->category_image)}}" alt="">
                                                </div>
                                                <div class="content">
                                                    <h4>{{$c->category_name}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- category area end-->

</main>

@endsection
@section('js')

@endsection