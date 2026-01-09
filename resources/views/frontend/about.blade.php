@extends('frontend.includes.layout')

@section('css')



@endsection

@section('content')

<main class="main">

    <!-- about area -->

    <div class="about-area py-100">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <div class="about-left wow fadeInLeft" data-wow-delay=".25s">

                        <div class="about-img">

                            <div class="row">

                                <div class="col-7">

                                    <img class="img-1" src="{{asset($about->primary_image)}}" alt="">

                                </div>

                                <div class="col-5 align-self-end">

                                    <img class="img-2" src="{{asset($about->secondary_image)}}" alt="">

                                </div>

                            </div>

                        </div>

                        <div class="about-experience">

                            <div class="about-experience-icon">

                                <img src="assets/img/icon/experience.svg" alt="">

                            </div>

                            <b>{{$about->experience_years}} Years Of <br> Experience</b>

                        </div>

                        <div class="about-shape">

                            <img src="{{asset('assets/img/shape/01.png')}}" alt="">

                        </div>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="about-right wow fadeInRight" data-wow-delay=".25s">

                        <div class="site-heading mb-3">

                            <span class="site-title-tagline justify-content-start">

                                <i class="flaticon-drive"></i> About Us

                            </span>

                            <h2 class="site-title">

                                {{$about->heading}}

                            </h2>

                        </div>

                        <p>

                            {{$about->about_content}}

                        </p>

                        <div class="about-list">

                            <ul>
                                @foreach($about->keypoints as $keypoint)
                                <li><i class="fas fa-check-double"></i> {{$keypoint}}</li>
                                @endforeach
                            </ul>

                        </div>
                        @if($about->link != '#')
                        <a href="{{$about->link}}" target="_blank" class="theme-btn mt-4">Discover More<i

                                class="fas fa-arrow-right"></i></a>
                        @endif
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- about area end -->





    <!-- counter area -->

    <div class="counter-area pt-50 pb-50">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-sm-6">
                    <div class="counter-box">
                        <div class="icon">
                            <img src="{{ asset('assets/img/icon/sale.svg') }}" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-amount">
                                <span class="counter" data-count="+" data-to="{{ $about->total_sales ?? 0 }}" data-speed="3000">
                                    {{ $about->total_sales ?? 0 }}
                                </span>
                                <span class="counter-sign"><i class="fa-solid fa-k"></i></span>
                            </div>
                            <h6 class="title">Total Sales</h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="counter-box">
                        <div class="icon">
                            <img src="{{ asset('assets/img/icon/rate.svg') }}" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-amount">
                                <span class="counter" data-count="+" data-to="{{ $about->happy_clients ?? 0 }}" data-speed="3000">
                                    {{ $about->happy_clients ?? 0 }}
                                </span>
                                <span class="counter-sign"><i class="fa-solid fa-k"></i></span>
                            </div>
                            <h6 class="title">Happy Clients</h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="counter-box">
                        <div class="icon">
                            <img src="{{ asset('assets/img/icon/employee.svg') }}" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-amount">
                                <span class="counter" data-count="+" data-to="{{ $about->team_workers ?? 0 }}" data-speed="3000">
                                    {{ $about->team_workers ?? 0 }}
                                </span>
                                <span class="counter-sign"><i class="fa-solid fa-plus"></i></span>
                            </div>
                            <h6 class="title">Team Workers</h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="counter-box">
                        <div class="icon">
                            <img src="{{ asset('assets/img/icon/award.svg') }}" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-amount">
                                <span class="counter" data-count="+" data-to="{{ $about->win_awards ?? 0 }}" data-speed="3000">
                                    {{ $about->win_awards ?? 0 }}
                                </span>
                                <span class="counter-sign"><i class="fa-solid fa-plus"></i></span>
                            </div>
                            <h6 class="title">Win Awards</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- counter area end -->

    <!-- testimonial area -->

    @if ($testimonials->count())

    <div class="testimonial-area ts-bg py-80">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-delay=".25s">

                    <div class="site-heading text-center">

                        <span class="site-title-tagline">Testimonials</span>

                        <h2 class="site-title text-white">What Our Client Say's <span>About Us</span></h2>

                    </div>

                </div>

            </div>

            <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                @foreach ($testimonials as $testimonial)

                <div class="testimonial-item">

                    <div class="testimonial-author">

                        <div class="testimonial-author-img">

                            <img src="{{ asset($testimonial->image) }}" alt="">

                        </div>

                        <div class="testimonial-author-info">

                            <h4>{{ $testimonial->name }}</h4>

                            <p>{{ $testimonial->title }}</p>

                        </div>

                    </div>

                    <div class="testimonial-quote">

                        <p>

                            {{ $testimonial->message }}

                        </p>

                    </div>

                    <div class="testimonial-rate">

                        @for ($i = 1; $i <= 5; $i++)

                            @if ($i <=$testimonial->rating)

                            <i class="fas fa-star text-warning"></i>

                            @else

                            <i class="fas fa-star"></i>

                            @endif

                            @endfor

                    </div>

                    <div class="testimonial-quote-icon"><img src="assets/img/icon/quote.svg" alt="">

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

    @endif

    <!-- testimonial area end -->

    <!-- gallery-area -->
    @if(count($videos) > 0)
    <div class="gallery-area py-80">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 mx-auto">

                    <div class="site-heading text-center">

                        <span class="site-title-tagline">Our Gallery</span>

                        <h2 class="site-title">Let's Check Our Video <span>Gallery</span></h2>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-sm-12">

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($videos as $video)
                        <div class="col">
                            <div class="card h-100 rounded-3 overflow-hidden">

                                {{-- Video Frame --}}
                                <div class="popup_youtube">
                                    <iframe width="100%" height="100%"
                                        src="{{ str_replace(['watch?v=', 'youtu.be/'], ['embed/', 'youtube.com/embed/'], $video->link) }}"
                                        title="YouTube video player"
                                        frameborder="0" allowfullscreen>
                                    </iframe>
                                </div>

                                {{-- Play Button Popup --}}
                                <a class="play-btn popup-youtube"
                                    href="{{ $video->popup_link ?? $video->link }}">
                                    <i class="fas fa-play"></i>
                                </a>

                                <div class="card-body video-card">
                                    <div class="video-title">

                                        {{-- Title --}}
                                        <h5 class="card-title">{{ $video->title }}</h5>

                                        {{-- Content --}}
                                        <p class="card-text">{{ $video->content }}</p>
                                    </div>
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
    <!-- gallery-area end -->

    <!-- feature area -->

    @if ($feature)

    <div class="feature-area">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="feature-wrap">

                <div class="row g-0">

                    <div class="col-12 col-md-6 col-lg-3">

                        <div class="feature-item">

                            <div class="feature-icon">

                                {!! $feature->icon !!}

                            </div>

                            <div class="feature-content">

                                <h4>{{ $feature->title }}</h4>

                                <p>{{ $feature->content }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-md-6 col-lg-3">

                        <div class="feature-item">

                            <div class="feature-icon">

                                {!! $feature->icon2 !!}

                            </div>

                            <div class="feature-content">

                                <h4>{{ $feature->title2 }}</h4>

                                <p>{{ $feature->content2 }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-md-6 col-lg-3">

                        <div class="feature-item">

                            <div class="feature-icon">

                                {!! $feature->icon3 !!}

                            </div>

                            <div class="feature-content">

                                <h4>{{ $feature->title3 }}</h4>

                                <p>{{ $feature->content3 }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-md-6 col-lg-3">

                        <div class="feature-item">

                            <div class="feature-icon">

                                {!! $feature->icon4 !!}

                            </div>

                            <div class="feature-content">

                                <h4>{{ $feature->title4 }}</h4>

                                <p>{{ $feature->content4 }}</p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endif

    <!-- feature area end -->

    <!-- team-area -->
    @if(count($teams)>0)
    <div class="team-area pt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline">Our Team</span>
                        <h2 class="site-title">Meet Our Expert <span>Team</span></h2>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                @foreach($teams as $index => $team)
                <div class="col-md-6 col-lg-3">
                    <div class="team-item wow fadeInUp" data-wow-delay="{{ ($index + 1) * 0.25 }}s">
                        <div class="team-img">
                            <img src="{{ asset($team->image) }}" alt="{{ $team->name }}">
                        </div>
                        <div class="team-content">
                            <div class="team-bio">
                                <h5><a href="#">{{ $team->name }}</a></h5>
                                <span>{{ $team->designation }}</span>
                            </div>
                        </div>
                        <div class="team-social">
                            @if($team->facebook)
                            <a href="{{ $team->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($team->twitter)
                            <a href="{{ $team->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($team->linkedin)
                            <a href="{{ $team->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if($team->youtube)
                            <a href="{{ $team->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- team-area end -->



    <!-- instagram-area -->

    <div class="instagram-area py-100 d-none">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="row">

                <div class="col-lg-6 mx-auto">

                    <div class="site-heading text-center">

                        <h2 class="site-title">Instagram <span>@medion</span></h2>

                    </div>

                </div>

            </div>

            <div class="instagram-slider owl-carousel owl-theme">

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/01.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/02.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/03.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/04.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/05.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/06.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="instagram-item">

                    <div class="instagram-img">

                        <img src="assets/img/instagram/07.jpg" alt="Thumb">

                        <a href="#"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- instagram-area end -->





    <!-- brand area -->
    @if(count($brands) > 0)
    <div class="brand-area bg pt-50 pb-50">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="row">

                <div class="col-12">

                    <div class="text-center">

                        <h2 class="site-title">Trusted by over <span>3.2k+</span> companies</h2>

                    </div>

                </div>

            </div>

            <div class="brand-slider pt-40 pb-40 owl-carousel owl-theme">

                @foreach ($brands as $brand)

                <div class="brand-item">

                    <a href="{{ $brand->link }}">

                        <img src="{{ asset($brand->image) }}" alt="">

                    </a>

                </div>

                @endforeach

            </div>

        </div>

    </div>
    @endif
    <!-- brand area end -->



</main>





@endsection

@section('js')



@endsection