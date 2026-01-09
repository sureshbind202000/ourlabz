@extends('frontend.includes.corporateLayout')

@section('css')

<style>
    .s-bg {

        background-image: url();

        background-size: cover;

        background-repeat: no-repeat;

        background-position: center;

    }



    .bg-search {

        background-color: #f6f6ff;

    }
</style>

@endsection



@section('content')

<main class="main">

    <div class="container-fluid bg-search">

        <div class="container pb-4">

            <div class="row">

                <div class="col-sm-6 py-5">

                    <h2 class="mb-4">{{$doctor_consult->title ?? ''}}</h2>

                    <p>{{$doctor_consult->content ?? ''}}</p>

                    <div class="header-middle-search mt-5">

                        <form action="{{ route('doctor') }}" method="GET">

                            <div class="search-content ps-3">

                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by Speciality Or Doctor Name... ">

                                <button type="submit" class="search-btn"><i class="far fa-search"></i></button>

                            </div>



                        </form>

                    </div>

                </div>

                <div class="col-sm-6">

                    <img src="{{ asset($doctor_consult->image ?? 'assets/img/hospital/doctor.png') }}" alt="">

                </div>

            </div>

        </div>

    </div>

    <!--  Health Problem start  -->

    <div class="instagram-area pt-100 pb-100 d-none">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="row">

                <div class="col-12 wow fadeInDown py-0 pb-4" data-wow-delay=".25s"

                    style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInDown;">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Choose by Health Problem</h2>

                        <a href="">View More <i class="fas fa-angle-double-right"></i></a>

                    </div>

                </div>

            </div>

            <div class="instagram-slider owl-carousel owl-theme">

                <div class="item">



                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/fever.jpeg" alt="fever" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Fever</p>

                        </div>

                    </a>

                </div>

                <div class="item">

                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/cough.jpeg" alt="cough" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Cough</p>

                        </div>

                    </a>

                </div>

                <div class="item">

                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/Cold.webp" alt="Cold" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Cold</p>

                        </div>

                    </a>

                </div>

                <div class="item">

                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/Stomach.jpeg" alt="Stomach Pain" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Stomach Pain</p>

                        </div>

                    </a>

                </div>

                <div class="item">

                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/Acidity.webp" alt="Acidity" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Acidity</p>

                        </div>

                    </a>

                </div>

                <div class="item">

                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/Constipation.jpeg" alt="Constipation" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Constipation</p>

                        </div>

                    </a>

                </div>

                <div class="item">

                    <a href="">

                        <div class="instagram-img">

                            <img src="assets/img/category/Headache.jpeg" alt="Headache" style="height: 240px;">

                        </div>

                        <div class="px-4 py-2 text-center">

                            <p>Headache</p>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>

    <!--  Health Problem end  -->



    <!--  Health Problem start  -->

    <!-- category area -->

    <div class="category-area2 pt-100">

        <div class="container">

            <div class="row">

                <div class="col-12 wow fadeInDown py-0" data-wow-delay=".25s"

                    style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInDown;">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Choose by Speciality</h2>

                        <a href="{{ route('doctor_category') }}">View More <i class="fas fa-angle-double-right"></i></a>

                    </div>

                </div>

            </div>





        </div>

    </div>

    <div class="category-area pb-100">

        <div class="container">

            <div class="category-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                @foreach($specialities as $speciality)

                <div class="col m-0">

                    <div class="category-item ">

                        <a href="{{route('doctor', ['speciality' => $speciality->slug ])}}">

                            <div class="category-info col">

                                <div class="card h-100 ">

                                    <div class="card-body px-0  ">

                                        <div class="icon">

                                            <img src="{{asset($speciality->image)}}" alt="" class="img-fluid">

                                        </div>

                                        <div class="content">

                                            <h4>{{$speciality->speciality}}</h4>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>

                    </a>

                </div>

                @endforeach

            </div>

        </div>

    </div>

    <!-- category area end-->

    <!-- login start  -->



</main>

@endsection



@section('js')

@endsection