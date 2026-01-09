@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')

<main class="main">
    <div class="container py-3">
        <img src="{{asset('assets/img/banner/doc-banner-desktop.png')}}" alt="">
    </div>
    <!-- category area -->
    <div class="category-area py-5 pt-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mx-auto">
                    <div class="site-heading ">
                        <h2 class="site-title">Specialties <span>Doctor</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5  g-4">
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



        </div>
    </div>
    <!-- category area end-->

</main>

@endsection
@section('js')

@endsection