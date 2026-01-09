<style>
    .footer-list.multi-column {



        display: block;



        column-count: 5;
        /* Change this to 3 or more as needed */



        column-gap: 30px;
        /* Space between columns */



        list-style: none;



        padding: 0;



        margin: 0;



    }







    .footer-list.multi-column li {



        break-inside: avoid;
        /* Keeps items from breaking across columns */



        margin-bottom: 8px;
        /* Space between items */



    }
</style>







<!-- footer area -->



<footer class="footer-area">



    <div class="footer-widget">



        <div class="container">



            <div class="row footer-widget-wrapper pt-100 ">



                <div class="col-md-6 col-lg-3">



                    <div class="footer-widget-box about-us">



                        <a href="index.html" class="footer-logo">

                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" style="width: 60px;">

                        </a>
                        <p class="mb-3">
                            {{ $contactInfo->about }}
                        </p>
                        <ul class="footer-contact">
                            <li>
                                <div><i class="far fa-map-marker-alt"></i></div>
                                <div>{{$contactInfo->office_address ?? ''}}</div>
                            </li>
                            <li>
                                @if(!empty($contactInfo->phone) && isset($contactInfo->phone[0]))
                                <a href="tel:{{ $contactInfo->phone[0] }}">
                                    <i class="far fa-phone"></i>
                                    {{ $contactInfo->phone[0] }}
                                </a>
                                @endif
                            </li>
                            <li>
                                @if(!empty($contactInfo->email) && isset($contactInfo->email[0]))
                                <a href="mailto:{{ $contactInfo->email[0] }}">
                                    <i class="far fa-envelope"></i>
                                    {{ $contactInfo->email[0] }}
                                </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Quick Links</h4>



                        <ul class="footer-list">



                            <li><a href="{{route('index')}}">Home</a></li>



                            <li><a href="{{route('about')}}">About Us</a></li>



                            <li><a href="">Test</a></li>



                            <li><a href="{{route('corporate.index')}}">Corporate</a></li>



                            <li><a href="{{route('contact')}}">Contact Us</a></li>



                            <li><a href="{{route('blog')}}">Blog</a></li>

                            <li><a href="{{route('faq')}}">FAQ's</a></li>

                            <li><a href="javascript:void(0);" class="user-trackmyorder-trigger">Track Your Order</a></li>

                        </ul>



                    </div>



                </div>



                <div class="col-md-6 col-lg-2">



                    <div class="footer-widget-box list">



                        <h4 class="footer-widget-title">Browse Category</h4>



                        <ul class="footer-list">



                            <li><a href="{{route('shop')}}">Medicine</a></li>



                            <li><a href="{{route('shop')}}">Medical Equipments</a></li>



                            <li><a href="{{route('shop')}}">Beauty Care</a></li>



                            <li><a href="{{route('shop')}}">Baby & Mom Care</a></li>



                            <li><a href="{{route('shop')}}">Healthcare</a></li>



                            <!-- <li><a href="{{route('shop')}}">Food & Nutrition</a></li> -->



                            <li><a href="{{route('shop')}}">Medical Supplies</a></li>



                        </ul>



                    </div>



                </div>



                <div class="col-md-6 col-lg-2">



                    <div class="footer-widget-box list">



                        <h4 class="footer-widget-title">Policies</h4>

                        <ul class="footer-list">
                            @foreach($policyPages as $policy)
                            <li>
                                <a href="{{ route('policy.show', $policy->slug) }}">
                                    {{ $policy->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>



                    </div>



                </div>



                <div class="col-md-6 col-lg-3">



                    <div class="footer-widget-box list">



                        <h4 class="footer-widget-title">Registration Links</h4>



                        <ul class="footer-list">



                            <li><a href="{{route('lab.registration')}}">Lab Registration</a></li>



                            <li><a href="{{route('doctor.registration')}}">Doctor Registration</a></li>



                            <li><a href="{{route('corporate.registration')}}">Corporate Registration</a></li>



                            <li><a href="{{route('vendor.registration')}}">Vendor Registration</a></li>







                        </ul>



                    </div>



                </div>







            </div>



            <hr>



            <div class="row footer-widget-wrapper">







                <div class="col-md-6 mx-auto">



                    <div class="footer-widget-box list text-center">



                        <div class="footer-payment">



                            <img src="{{asset('assets/img/payment/visa.svg')}}" alt="">



                            <img src="{{asset('assets/img/payment/mastercard.svg')}}" alt="">



                            <img src="{{asset('assets/img/payment/amex.svg')}}" alt="">



                            <img src="{{asset('assets/img/payment/discover.svg')}}" alt="">



                            <img src="{{asset('assets/img/payment/paypal.svg')}}" alt="">



                        </div>



                    </div>



                </div>







            </div>







        </div>



    </div>



    <div class="copyright">



        <div class="container">



            <div class="copyright-wrap">



                <div class="row">



                    <div class="col-12 col-lg-6 align-self-center">



                        <p class="copyright-text">



                            &copy; Copyright <span id="date"></span> <a href="index.html"> Ourlabz </a> All Rights



                            Reserved.



                        </p>



                    </div>



                    <div class="col-12 col-lg-6 align-self-center">



                        <div class="footer-social">



                            <span>Follow Us:</span>



                            <a href="{{$contactInfo->facebook ?? '#'}}"><i class="fab fa-facebook-f"></i></a>



                            <a href="{{$contactInfo->twitter ?? '#'}}"><i class="fab fa-x-twitter"></i></a>



                            <a href="{{$contactInfo->linkedin ?? '#'}}"><i class="fab fa-linkedin-in"></i></a>



                            <a href="{{$contactInfo->youtube ?? '#'}}"><i class="fab fa-youtube"></i></a>



                        </div>



                    </div>



                </div>



            </div>



        </div>



    </div>



</footer>



<!-- footer area end -->







<!-- scroll-top -->



<a href="#" class="d-none d-md-block" id="scroll-top"><i class="far fa-arrow-up-from-arc mt-3"></i></a>



<!-- scroll-top end -->