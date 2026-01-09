    @extends('frontend.includes.corporateLayout')
    @section('css')
        <style>
            .s-bg {
                background-image: url('{{ asset($service->banner) }}');
                background-size: 100% 100%;
                background-repeat: no-repeat;
                background-position: center;
                height: 400px;
                width: 100%;
                border-radius: 30px;
            }
        </style>
    @endsection

    @section('content')
        <main class="main">

            <div class="container">
                <div class="row py-4">
                    <div class="col-sm-12 s-bg">

                    </div>
                </div>
            </div>
            <!-- services start  -->
            <div class="team-area pt-100 pb-50">

                <div class="container">

                    <div class="row">

                        <div class="col-lg-6 mx-auto">

                            <div class="site-heading text-center">



                                <h2 class="site-title">{{ $service->title ?? '' }}</h2>

                                <p>{{ $service->heading ?? '' }}</p>

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

                                        <h5><a href="javascript:void(0);">{{ $service->name ?? '' }}</a></h5>

                                        <p>{{ $service->content ?? '' }}</p>

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

                                        <h5><a href="javascript:void(0);">{{ $service->name2 ?? '' }}</a></h5>

                                        <p>{{ $service->content2 ?? '' }}</p>

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

                                        <h5><a href="javascript:void(0);">{{ $service->name3 ?? '' }}</a></h5>

                                        <p>{{ $service->content3 ?? '' }}</p>

                                    </div>

                                </div>

                                <div class="team-social">



                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 col-lg-3">

                            <div class="team-item wow fadeInUp" data-wow-delay="1s">

                                <div class="team-img">

                                    <img src="{{ asset($service->image5 ?? '') }}" alt="thumb">

                                </div>

                                <div class="team-content">

                                    <div class="team-bio">

                                        <h5><a href="javascript:void(0);">{{ $service->name5 ?? '' }}</a></h5>

                                        <p>{{ $service->content5 ?? '' }}</p>

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


        </main>
    @endsection

    @section('js')
    @endsection
