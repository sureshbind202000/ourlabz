@extends('frontend.includes.corporateLayout')



@section('css')

<style>
    .s-bg {



        background-size: cover;



        background-repeat: no-repeat;



        background-position: center;



    }







    .mantra-card {



        /* background-color: #f5faff; */



        border-radius: 12px;



        padding: 5px;



        height: 100%;



    }







    .mantra-card img {



        width: 100%;



        border-radius: 12px;



        object-fit: cover;



    }







    .mantra-card h5 {



        margin-top: 15px;



        font-weight: 700;



    }







    .mantra-card ul {



        list-style: none;



        padding-left: 0;



    }







    .mantra-card li {



        display: flex;



        align-items: center;



        margin-bottom: 10px;



        font-size: 16px;



    }







    .mantra-card li i {



        margin-right: 10px;



        color: #004080;



    }







    .offcanvas-end {



        width: 33% !important;



    }
</style>

@endsection







@section('content')

<main class="main">



    <div class="hero-section hs-2 ">



        <div class="hero-slider owl-carousel owl-theme">

            @foreach ($banners as $banner)

            <div class="hero-single">

                <div class="hero-single-bg" style="background-image: url('{{ asset($banner->image) }}')"></div>



                <div class="container">

                    <div class="row align-items-center">

                        <div class="col-lg-7 px-2 px-md-5">

                            <div class="hero-content">

                                @if ($banner->heading)

                                <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">

                                    {{ $banner->heading }} <span>{{ $banner->heading2 }}</span> {{ $banner->heading3 }}

                                </h1>

                                @endif



                                @if ($banner->paragraph)

                                <p data-animation="fadeInLeft" data-delay=".75s">

                                    {{ $banner->paragraph }}

                                </p>

                                @endif



                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">

                                    @if ($banner->button_text && $banner->button_link)

                                    <a href="{{ $banner->button_link }}" class="theme-btn">

                                        {{ $banner->button_text }} <i class="fas fa-arrow-right"></i>

                                    </a>

                                    @endif



                                    @if ($banner->button_text2 && $banner->button_link2)

                                    <a href="{{ $banner->button_link2 }}" class="theme-btn ms-2">

                                        {{ $banner->button_text2 }} <i class="fas fa-arrow-right"></i>

                                    </a>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach







        </div>



    </div>







    <div class="affiliate-area py-100">



        <div class="container">



            <div class="row align-items-center">



                <div class="col-lg-6">



                    <div class="affiliate-img">



                        <img src="{{asset($about->image ?? '')}}" alt="">



                    </div>



                </div>



                <div class="col-lg-6">



                    <div class="affiliate-content">



                        <div class="site-heading mb-3">



                            <span class="site-title-tagline">{{$about->title ?? ''}}</span>



                            <h2 class="site-title">{{$about->heading ?? ''}}</h2>



                        </div>



                        <p>

                            {{$about->content ?? ''}}

                        </p>





                    </div>



                </div>



            </div>



        </div>



    </div>



    <!-- services start  -->



    <div class="team-area pt-100 pb-50">



        <div class="container">



            <div class="row">



                <div class="col-lg-6 mx-auto">



                    <div class="site-heading text-center">







                        <h2 class="site-title">{{$service->title ?? ''}}</h2>



                        <p>{{$service->heading ?? ''}}</p>



                    </div>



                </div>



            </div>



            <div class="row mt-5">



                <div class="col-md-6 col-lg-3">



                    <div class="team-item wow fadeInUp" data-wow-delay=".25s">



                        <div class="team-img">



                            <img src="{{ asset($service->image ?? '') }}" alt="thumb">



                        </div>



                        <div class="team-content">



                            <div class="team-bio">



                                <h5><a href="{{route('corporate.doctorConsult')}}" class="require-corporate-login">{{$service->name ?? ''}}</a></h5>



                                <p>{{$service->content ?? ''}}</p>



                            </div>



                        </div>



                        <div class="team-social">







                        </div>



                    </div>



                </div>



                <div class="col-md-6 col-lg-3">



                    <div class="team-item wow fadeInUp" data-wow-delay=".50s">



                        <div class="team-img">



                            <img src="{{ asset($service->image2 ?? '') }}" alt="thumb">



                        </div>



                        <div class="team-content">



                            <div class="team-bio">



                                <h5><a href="{{route('corporate.doctorConsult')}}" class="require-corporate-login">{{$service->name2 ?? ''}}</a></h5>



                                <p>{{$service->content2 ?? ''}}</p>



                            </div>



                        </div>



                        <div class="team-social">







                        </div>



                    </div>



                </div>



                <div class="col-md-6 col-lg-3">



                    <div class="team-item wow fadeInUp" data-wow-delay=".75s">



                        <div class="team-img">



                            <img src="{{ asset($service->image3 ?? '') }}" alt="thumb">



                        </div>



                        <div class="team-content">



                            <div class="team-bio">



                                <h5><a href="{{route('corporate.labTest')}}" class="require-corporate-login">{{$service->name3 ?? ''}}</a></h5>



                                <p>{{$service->content3 ?? ''}}</p>



                            </div>



                        </div>



                        <div class="team-social">







                        </div>



                    </div>



                </div>



                <div class="col-md-6 col-lg-3">



                    <div class="team-item wow fadeInUp" data-wow-delay="1s">



                        <div class="team-img">



                            <img src="{{ asset($service->image4 ?? '') }}" alt="thumb">



                        </div>



                        <div class="team-content">



                            <div class="team-bio">



                                <h5><a href="{{ route('corporate.services') }}" class="require-corporate-login">{{$service->name4 ?? ''}}</a></h5>



                                <p>{{$service->content4 ?? ''}}</p>



                            </div>



                        </div>



                        <div class="team-social">







                        </div>



                    </div>



                </div>







            </div>



        </div>



    </div>



    <!-- services end  -->



    <!-- Program start  -->

    @if(count($wellnessprograms) > 0)

    <div class="container pb-5">



        <div class="row">



            <div class="col-lg-6 mx-auto">



                <div class="site-heading text-center">



                    <h2 class="site-title"> Wellness Program</h2>



                </div>



            </div>



            <div class="row">



                <div class="col-sm-12">



                    <div class="row g-4">
                        @foreach($wellnessprograms as $program)
                        <div class="col-lg-4 col-md-6">



                            <div class="mantra-card shadow">



                                <img src="{{asset($program->image)}}" alt="Yoga Group">



                                <div class="p-4">
                                    <h5>{{$program->title}}</h5>
                                    <ul class="ps-3 mt-3">
                                        @foreach($program->content as $content)
                                        <li><i class="fa-solid fa-arrow-right"></i> {{$content}}</li>
                                        @endforeach
                                        @if(!empty($program->description) && !empty($program->slug))
                                        <li>
                                            <a href="{{ route('corporate.wellness.description', $program->slug) }}" class="text-primary">
                                                Read More.....
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>



                            </div>



                        </div>
                        @endforeach
                    </div>



                </div>



            </div>



        </div>



    </div>

    @endif

    <!-- Program end  -->

</main>

@endsection







@section('js')

@endsection