@extends('frontend.includes.corporateLayout')

@section('css')

<style>
    .floating-card {

        position: fixed;

        bottom: 20px;

        left: 20px;

        background: #fff;

        border-radius: 0.75rem;

        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);

        padding: 1rem;

        text-align: center;

        max-width: 270px;

        z-index: 9999;

        animation: floatUp 1s ease-out forwards;

        transform: translateY(100px);

        opacity: 0;

    }



    @keyframes floatUp {

        to {

            transform: translateY(0);

            opacity: 1;

        }

    }



    .call-btn {

        margin-top: 0.75rem;

        padding: 0.25rem 0.75rem;

        font-size: 0.9rem;

    }



    .phone-number {

        font-size: 1rem;

        font-weight: bold;

        color: #0d6efd;

    }



    .floating-card h4 {

        font-size: 1.1rem;

        margin-bottom: 0.5rem;

    }



    .floating-card p a {

        font-size: 0.9rem;

        margin: 0.25rem 0;

    }



    .mantra-card {

        /* background-color: #f5faff; */

        border-radius: 12px;

        padding: 20px;

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
</style>



@endsection



@section('content')



<main class="main">



    <div class="affiliate-area py-100">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <div class="affiliate-img">

                        <img src="{{asset('assets/img/affiliate/01.jpg')}}" alt="">

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="affiliate-content">

                        <div class="site-heading mb-3">

                            <span class="site-title-tagline">/Hospital Assistance</span>

                            <h2 class="site-title">Make money with <span>Hyiptox</span></h2>

                        </div>

                        <p>

                            There are many variations of passages of Lorem Ipsum available

                            but the majority have suffered alteration in some form, by injected humour

                            randomised words which don't look even established fact that a reader will

                            be distracted by the readable packages and web page editors now use content

                            of a page when looking at its layout.

                        </p>





                    </div>

                </div>

            </div>

        </div>

    </div>



   

    <!-- Program start  -->

    <div class="container pb-5">

        <div class="row">

            <div class="col-sm-11 mx-auto">

                <div class="site-heading text-center">

                    <h2>What to Expect with Hospital Assistance</h3>

                    <p>Get professional health cae Assistance for your loved onces. Our team for specialistd can help you find the right care when you're navigation dificult times</p>

                </div>

            </div>


                <div class="col-sm-12">

                    <div class="row">

                        <!-- Mantra EAP -->

                        <div class="col-md-4">

                            <div class="mantra-card shadow">

                                <img src="{{asset('assets/img/hospital/c1.avif')}}" alt="Yoga Group">

                                <h5>Personal Assistance</h5>

                                <p class=" mt-3">

                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem eius a, sed in sit, nihil neque ab minima, nostrum error veniam itaque aliquam! Ea, deserunt! Impedit veniam eligendi non adipisci!

                                </p>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="mantra-card shadow">

                                <img src="{{asset('assets/img/hospital/c1.avif')}}" alt="Yoga Group">

                                <h5>Personal Assistance</h5>

                                <p class=" mt-3">

                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem eius a, sed in sit, nihil neque ab minima, nostrum error veniam itaque aliquam! Ea, deserunt! Impedit veniam eligendi non adipisci!

                                </p>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="mantra-card shadow">

                                <img src="{{asset('assets/img/hospital/c1.avif')}}" alt="Yoga Group">

                                <h5>Personal Assistance</h5>

                                <p class=" mt-3">

                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem eius a, sed in sit, nihil neque ab minima, nostrum error veniam itaque aliquam! Ea, deserunt! Impedit veniam eligendi non adipisci!

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


        </div>

    </div>

    <!-- Program end  -->













    <div class="floating-card d-none d-md-block">

        <h5 class="te">Hospital Assistance is just a call way</h5>

        <p class="phone-number"><a href="tel:+911234567890">📞 +91 12345 67890</a></p>

        <p>We’re here to help.</p>



    </div>

</main>



@endsection



@section('js')



@endsection