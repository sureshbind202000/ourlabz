    @extends('frontend.includes.corporateLayout')

    @section('css')

    <style>
        .s-bg {

            background-image: url('{{ asset($detail->image) }}');

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

        <!-- Wellness Details start  -->

        <div class="team-area pb-50">



            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="site-heading text-center">
                            <h2 class="site-title">{{ $detail->title ?? '' }}</h2>
                        </div>
                        <div class="about-list d-flex">
                            <ul class="mx-auto">
                                @foreach($detail->content as $content)
                                <li><i class="fas fa-check-double"></i> {{$content}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12">
                        <p>
                            {!! $detail->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wellness Details end  -->
    </main>

    @endsection