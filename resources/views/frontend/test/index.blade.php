@extends('frontend.includes.layout')
@section('css')
    <style>
        #sideMenu {
            top: 16% !important;
            padding: 10px;
        }

        .bord {
            border-left: 1px solid rgb(232, 232, 232);
            border-right: 1px solid rgb(232, 232, 232);
        }

        .bord-r {
            border-right: 1px solid rgb(232, 232, 232);
        }

        #sideMenu a {
            border-bottom: 1px solid lightgray;
        }

        #sideMenu a.active {
            color: #0095d9;
            border-bottom: 2px solid #0095d9;
            font-weight: bold;
        }

        .requisties-class {
            display: flex;
            width: 32px;
            height: 32px;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, .161);
        }
    </style>
@endsection
@section('content')
    <main class="main">
        <!-- shop single -->
        <div class="shop-single">
            <div class="container-fluid">
                <div class="row pb-5">
                    <div class="col-lg-2 col-md-3 col-sm-12 pt-5 wow fadeInDown" data-wow-delay=".25s" style="z-index: 0;">
                        <div id="sideMenu" class="d-flex flex-column gap-3 simple-list-example-scrollspy  sticky-top ">
                            <a class="p-1 d-flex justify-content-between align-items-center" href="#simple-list-item-1">About
                                The Test <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <a class="p-1 d-flex justify-content-between align-items-center" href="#simple-list-item-2">List
                                of Parameter's <i class="fa-solid fa-arrow-right"></i></a>
                            <a class="p-1 d-flex justify-content-between align-items-center" href="#simple-list-item-3">Test
                                Preparation <i class="fa-solid fa-arrow-right"></i></a>
                            <a class="p-1 d-flex justify-content-between align-items-center" href="#simple-list-item-4">Why
                                This Test ? <i class="fa-solid fa-arrow-right"></i></a>
                            @if ($package->interpretations)
                                <a class="p-1 d-flex justify-content-between align-items-center"
                                    href="#simple-list-item-5">Interpretation's <i class="fa-solid fa-arrow-right"></i></a>
                            @endif
                            <a class="p-1 d-flex justify-content-between align-items-center"
                                href="#simple-list-item-6">FAQ's <i class="fa-solid fa-arrow-right"></i></a>
                            <a class="p-1 d-flex justify-content-between align-items-center"
                                href="#simple-list-item-7">Review's <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-9 col-sm-12 row  bord pt-5 ">
                        <div class="col-md-12  pt-4 wow fadeInUp" data-wow-delay=".25s">
                            <div class="shop-single-info">
                                <h3 class="wow fadeInDown" data-wow-delay=".25s">{{ $package->name }}</h3>
                                <div class="shop-single-price ">
                                    <!-- <del>$690</del> -->
                                    <span class="amount">₹{{ number_format($package->selling_price, 2) }}</span>
                                    <!-- <span class="discount-percentage">30% Off</span> -->
                                    @if (!empty($package->discount_label))
                                        <del>
                                            ₹{{ number_format($package->regular_price, 2) }}
                                        </del>
                                        <span class="discount-percentage text-danger">
                                            ( {{ $package->discount_label }} )
                                        </span>
                                    @endif

                                </div>
                                @php
                                    $roundedRating = round($average_rating ?? 0);
                                @endphp

                                <div class="product-rate mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $roundedRating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2">({{ number_format($average_rating, 1) ?? '0.0' }})</span>
                                </div>

                                <!-- <p>1K people booked this test</p> -->

                                @php
                                    $key = get_class($package) . '_' . $package->id;
                                    $inCart = in_array($key, $cartItems);
                                    $quantity = 1;

                                    // if logged in or session cart has this item, get its quantity
                                    if ($inCart) {
                                        if (Auth::check()) {
                                            $cartRow = \App\Models\Cart::where('user_id', Auth::id())
                                                ->where('item_type', get_class($package))
                                                ->where('item_id', $package->id)
                                                ->first();
                                            $quantity = $cartRow ? $cartRow->quantity : 1;
                                        } else {
                                            $cartRow = Session::get("cart.$key");
                                            $quantity = $cartRow['quantity'] ?? 1;
                                        }
                                    }
                                @endphp
                                <div class="cart-action mb-4">
                                    @if ($inCart)
                                        <div class="d-flex align-items-center gap-2">
                                            <select class="form-select form-select-sm update-qty"
                                                data-id="{{ $package->id }}" data-type="package" style="max-width: 110px;">
                                                <option value="remove" class="remove-from-cart"
                                                    data-id="{{ $package->id }}" data-type="package">
                                                    Remove Test
                                                </option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $quantity == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                        {{ Str::plural('Patient', $i) }}
                                                    </option>
                                                @endfor
                                            </select>

                                        </div>
                                    @else
                                        <a href="javascript:void(0);" type="button"
                                            class="btn btn-primary px-4 py-1 border-0 add-to-cart"
                                            data-id="{{ $package->id }}" data-type="package">
                                            Add
                                        </a>
                                    @endif
                                </div>
                                <div class="shop-single-cs">
                                </div>
                                <div class="shop-single-sortinfo">
                                    <div class="row row-cols-1 row-cols-md-3 g-4 mb-3">
                                        <div class="col ps-0">
                                            <div class="card border-0">
                                                <div class="card-body py-0 d-flex gap-2">
                                                    <div>
                                                        <img src="{{ asset('assets/img/report_within.png') }}"
                                                            alt="Reports Within" style="height: 50px;">
                                                    </div>
                                                    <div>
                                                        <h6 class="card-title">Reports Within</h6>
                                                        <p class="card-text">{{ $package->reports_within }} hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <div class="card border-0">
                                                <div class="card-body d-flex gap-2 py-0">
                                                    <div>
                                                        <img src="{{ asset('assets/img/microscope.png') }}"
                                                            alt="Tests included" style="height: 50px;">
                                                    </div>
                                                    <div>
                                                        <h6 class="card-title">Test included </h6>
                                                        <p class="card-text">{{ count($package->parameters) }} parameters
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <div class="card border-0">
                                                <div class="card-body d-flex gap-2 py-0">
                                                    <div>
                                                        <img src="{{ asset('assets/img/age_calendar.png') }}"
                                                            alt="Tests included" style="height: 50px;">
                                                    </div>
                                                    <div>
                                                        <h6 class="card-title">Recommended Age </h6>
                                                        <p class="card-text">{{ $package->recommendation_of_age }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 card mb-3">

                                            <div class="p-2 shadow-sm rounded-2 ps-3" style="background-color: #f8fdff;">
                                                <h6 class="card-title">Measures </h6>
                                                <p class="card-text">{{ $package->measures }}</p>
                                            </div>

                                        </div>
                                        <div class="col-md-6 card">

                                            <div class="p-2 shadow-sm rounded-2 ps-3" style="background-color: #f8fdff;">
                                                <h6 class="card-title">Identifies </h6>
                                                <p class="card-text">{{ $package->identifies }}</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="report-card ps-3 mt-3 shadow-sm py-3">
                                        <h6 class="text-muted ">Requisites</h6>
                                        <div class="d-flex gap-3 mt-2">
                                            @foreach ($package->requisites as $requisites)
                                                <p class="requisties-class">
                                                 <img src="{{ asset($requisites->icon) }}" alt="{{ $requisites->name }}" style="height: 20px;" >
                                                </p>
                                                {{ $requisites->name }}
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div data-bs-spy="scroll" data-bs-target="#simple-list-example" data-bs-offset="0"
                            class="scrollspy-example" tabindex="0">
                            <!-- list 1 -->
                            <h3 id="simple-list-item-1" class="mt-5 wow fadeInUp text-uppercase text-primary"
                                data-wow-delay=".25s">About Test</h3>
                            <p class="my-4 wow fadeInUp" data-wow-delay=".25s">
                                {!! $package->about_test !!}
                            </p>
                            <hr>
                            <!-- list 2 -->
                            <h3 id="simple-list-item-2" class=" my-4 mt-5 wow fadeInUp text-uppercase text-primary"
                                data-wow-delay=".25s">List Of Parameter's</h3>
                            <div class="row px-md-3 mb-4">
                                <div class="col-md-12">
                                    <p>
                                        {{ $package->list_of_parameters_note }}
                                    </p>
                                    <div class="accordion accordion-flush" id="accordionFlushParent">
                                        @foreach ($package->parameters as $parameter)
                                            @php
                                                $paramId = 'parameter_' . $parameter->id;
                                            @endphp
                                            <div class="accordion-item my-3 border-0 rounded-3 border-bottom p-0 bg-white wow fadeInUp"
                                                data-wow-delay=".25s">
                                                <h2 class="accordion-header" id="flush-heading-{{ $paramId }}">
                                                    <button
                                                        class="accordion-button collapsed text-dark fw-bold bg-white shadow-none"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse-{{ $paramId }}"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapse-{{ $paramId }}"
                                                        style="text-wrap-style: balance;">
                                                        {{ $parameter->name }}
                                                        <small class="text-muted ms-auto"
                                                            style="font-size: 10px;position: absolute;right: 55px;">
                                                            {{ $parameter->no_of_parameter }}
                                                            Parameter{{ $parameter->no_of_parameter > 1 ? 's' : '' }}
                                                        </small>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse-{{ $paramId }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="flush-heading-{{ $paramId }}"
                                                    data-bs-parent="#accordionFlushParent">
                                                    <div class="accordion-body">
                                                        {!! $parameter->content !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                            <hr>
                            <!-- list 3 -->
                            <h3 id="simple-list-item-3" class=" my-4 mt-5 text-uppercase text-primary">Test Preparation
                            </h3>
                            <p class="mb-4">
                                {!! $package->test_preparation !!}

                            </p>
                            <hr>
                            <!-- list 4  -->
                            <h3 id="simple-list-item-4" class="my-4 mt-5 text-uppercase text-primary">Why this test ?</h3>
                            <p class="mt-3">
                                {!! $package->why_this_test !!}
                            </p>

                            <hr>
                            <!-- list 5  -->
                            @if ($package->interpretations)
                                <h3 id="simple-list-item-5" class="my-4 mt-5 text-uppercase text-primary">Interpretation's
                                </h3>
                                <p class="mt-3">
                                    {!! $package->interpretations !!}
                                </p>

                                <hr>
                            @endif
                            <!-- list 6  -->
                            <h3 id="simple-list-item-6" class="my-4 mt-5 wow fadeInDown text-uppercase text-primary"
                                data-wow-delay=".25s">FAQ's</h3>
                            <div class="row px-md-3 mb-4">
                                <div class=" col-md-12">
                                    <div class="accordion accordion-flush" id="accordionFlushParent2">
                                        @foreach ($package->faqs as $faq)
                                            @php
                                                $faqId = 'faq_' . $faq->id;
                                            @endphp
                                            <div class="accordion-item my-3 border-0 rounded-3 border-bottom p-0 bg-white wow fadeInUp"
                                                data-wow-delay=".25s">
                                                <h2 class="accordion-header" id="flush-heading-{{ $faqId }}">
                                                    <button
                                                        class="accordion-button collapsed text-dark fw-bold bg-white shadow-none"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse-{{ $faqId }}"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapse-{{ $faqId }}"
                                                        style="text-wrap-style: balance;">
                                                        {{ $faq->question }}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse-{{ $faqId }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="flush-heading-{{ $faqId }}"
                                                    data-bs-parent="#accordionFlushParent2">
                                                    <div class="accordion-body">
                                                        {!! $faq->answer !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div id="review-section"></div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 ps-4 pt-5 wow fadeInDown" data-wow-delay=".25s">
                        <div class="row">
                            <div class="col-sm-12 pt-3 wow fadeInUp" data-wow-delay=".25s">
                                <h4 class="mb-4">Related Test</h4>
                                @foreach ($related_packages as $related)
                                    <div class="col mb-3">
                                        <div class="card h-100 p-3 border">
                                            <div class="card-body p-0 mb-4">
                                                <div class="d-flex gap-2">
                                                    <div class="border p-1 rounded-2 test-image">
                                                        @php
                                                            $icon = $related->package_icon
                                                                ? asset($related->package_icon)
                                                                : ($related->categoryDetails &&
                                                                $related->categoryDetails->category_image
                                                                    ? asset($related->categoryDetails->category_image)
                                                                    : asset('default.png'));
                                                        @endphp
                                                        <img src="{{ $icon }}" alt="">
                                                    </div>
                                                    <div>
                                                        <h6 class=" my-2 fw-bold ">
                                                            <a
                                                                href="{{ route('test.details', ['slug' => $related->slug]) }}">{{ $related->name }}</a>
                                                        </h6>
                                                        <div class=" d-flex gap-3 mt-2">
                                                            <div>
                                                                <h6 class="small text-muted">Parameters</h6>
                                                                <p class="text-muted small">
                                                                    {{ count($related->parameters) }} Test</p>
                                                            </div>
                                                            <div>
                                                                <h6 class="small text-muted">Reports Within</h6>
                                                                <p class="text-muted small">{{ $related->reports_within }}
                                                                    Hours</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 price">
                                                <div>
                                                    <span class="pe-2 text-dark fw-bold">
                                                        ₹{{ number_format($related->selling_price, 2) }}
                                                    </span>

                                                    @if (!empty($related->discount_label))
                                                        <del class="text-muted small px-0">
                                                            ₹{{ number_format($related->regular_price, 2) }}
                                                        </del>
                                                        <br>
                                                        <span class="text-danger small px-0">
                                                            {{ $related->discount_label }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @php
                                                    $key = get_class($related) . '_' . $related->id;
                                                    $inCart = in_array($key, $cartItems);
                                                    $quantity = 1;

                                                    // if logged in or session cart has this item, get its quantity
                                                    if ($inCart) {
                                                        if (Auth::check()) {
                                                            $cartRow = \App\Models\Cart::where('user_id', Auth::id())
                                                                ->where('item_type', get_class($related))
                                                                ->where('item_id', $related->id)
                                                                ->first();
                                                            $quantity = $cartRow ? $cartRow->quantity : 1;
                                                        } else {
                                                            $cartRow = Session::get("cart.$key");
                                                            $quantity = $cartRow['quantity'] ?? 1;
                                                        }
                                                    }
                                                @endphp
                                                <div class="cart-action">
                                                    @if ($inCart)
                                                        <div class="d-flex align-items-center gap-2">
                                                            <select class="form-select form-select-sm update-qty"
                                                                data-id="{{ $related->id }}" data-type="package"
                                                                style="max-width: 110px;">
                                                                <option value="remove" class="remove-from-cart"
                                                                    data-id="{{ $related->id }}" data-type="package">
                                                                    Remove Test
                                                                </option>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ $quantity == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                        {{ Str::plural('Patient', $i) }}
                                                                    </option>
                                                                @endfor
                                                            </select>

                                                        </div>
                                                    @else
                                                        <a href="javascript:void(0);" type="button"
                                                            class="btn btn-primary px-4 py-1 border-0 add-to-cart"
                                                            data-id="{{ $related->id }}" data-type="package">
                                                            Add
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <!-- review start -->
                <div class="row">
                    <div class="col-sm-12 wow fadeInDown" data-wow-delay=".25s">
                        <h2 class="site-title pt-80 ps-5 text-primary" id="simple-list-item-7">Review's</h2>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-8 wow fadeInUp" data-wow-delay=".25s">
                        <!-- testimonial area -->
                        <div class="testimonial-area">
                            <div class="container">
                                <div class="review-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">
                                    @foreach ($package_reviews as $reviews)
                                        <div class="testimonial-item">
                                            <div class="testimonial-author">
                                                <div class="testimonial-author-img">
                                                    <img src="{{ asset('assets/img/user.png') }}" alt="Profile Image"
                                                        style="height:50px;width:50px;">
                                                </div>
                                                <div class="testimonial-author-info">
                                                    <h4>{{ $reviews->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="testimonial-quote">
                                                <p>
                                                    {{ $reviews->comment }}
                                                </p>
                                            </div>
                                            <div class="testimonial-rate">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $reviews->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="fas fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="testimonial-quote-icon"><img
                                                    src="{{ asset('assets/img/icon/quote.svg') }}" alt=""></div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div id="review-section"></div>
                        <!-- testimonial area end -->
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay=".25s">
                        <div id="reviewform">
                            <div class="package-comments-form mt-0">
                                <h4 class="mb-4">Leave a Review</h4>
                                <form id="packageReviewForm" method="POST"
                                    action="{{ route('website.package.review.store') }}" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                                    <input type="text" name="website" value="" autocomplete="off"
                                        tabindex="-1" style="position:absolute;left:-9999px">

                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Your Name*" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Your Email*" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="form-group">
                                                <select name="rating" class="form-control form-select" required>
                                                    <option value="">Ratings</option>
                                                    <option value="5">5</option>
                                                    <option value="4">4</option>
                                                    <option value="3">3</option>
                                                    <option value="2">2</option>
                                                    <option value="1">1</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group  mb-3">
                                                <textarea name="comment" class="form-control" rows="3" placeholder="Write comment here*" required></textarea>
                                            </div>
                                            <button type="submit" class="theme-btn">
                                                <span class="far fa-paper-plane"></span> Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- shop single end -->

    </main>



    <div class="modal quickview fade" id="quickview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="quickview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="far fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-img">
                                <img src="assets/img/product/04.png" alt="#">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h4 class="quickview-title">Surgical Face Mask</h4>
                                <div class="quickview-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <span class="rating-count"> (4 Customer Reviews)</span>
                                </div>
                                <div class="quickview-price">
                                    <h5><del>$860</del><span>$740</span></h5>
                                </div>
                                <ul class="quickview-list">
                                    <li>Brand:<span>Medica</span></li>
                                    <li>Category:<span>Healthcare</span></li>
                                    <li>Stock:<span class="stock">Available</span></li>
                                    <li>Code:<span>789FGDF</span></li>
                                </ul>
                                <div class="quickview-cart">
                                    <a href="#" class="theme-btn">Add to cart</a>
                                </div>
                                <div class="quickview-social">
                                    <span>Share:</span>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuLinks = document.querySelectorAll('#sideMenu a');
            const sections = Array.from(menuLinks).map(link => {
                const id = link.getAttribute('href').substring(1);
                return document.getElementById(id);
            });

            // Scroll listener to update active menu link
            function updateActiveLink() {
                let currentIndex = sections.findIndex((section) => {
                    const rect = section.getBoundingClientRect();
                    return rect.top <= window.innerHeight / 2 && rect.bottom >= 0;
                });

                if (currentIndex !== -1) {
                    menuLinks.forEach(link => link.classList.remove('active'));
                    menuLinks[currentIndex].classList.add('active');
                }
            }

            // Click listener to scroll and activate
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const target = document.getElementById(targetId);

                    window.scrollTo({
                        top: target.offsetTop - 20, // Adjust for header if needed
                        behavior: 'smooth'
                    });

                    menuLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Scroll event
            window.addEventListener('scroll', updateActiveLink);
        });

        const sideMenu = document.getElementById('sideMenu');
        const section5 = document.getElementById('section5');

        window.addEventListener('scroll', () => {
            const section5Top = section5.getBoundingClientRect().top;
            const triggerPoint = window.innerHeight / 2;

            if (section5Top < triggerPoint) {
                sideMenu.style.position = 'absolute';
                sideMenu.style.top = window.scrollY + 'px';
            } else {
                sideMenu.style.position = 'fixed';
                sideMenu.style.top = '200';
            }
        });
    </script>


    <!-- review form  -->
    <!-- <script>
        const review = document.getElementById('reviewform');
        const reviewSection = document.getElementById('review-section');

        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            const triggerPoint = 480;
            const sectionTop = reviewSection.offsetTop;
            const formHeight = review.offsetHeight;

            if (scrollY + formHeight >= sectionTop) {
                // When reviewform reaches the section, scroll with it
                review.style.position = '';
            } else if (scrollY >= triggerPoint) {
                // Fix it while scrolling
                review.style.position = 'fixed';
                review.style.padding = '15px';
                review.style.top = '200px';
            } else {
                // Normal at the top
                review.style.position = 'relative';
                review.style.top = '0';
            }
        });
    </script> -->


    <script>
        // testimonial slider
        $('.review-slider').owlCarousel({
            loop: false,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
                // 1400: {
                //     items: 4
                // }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#packageReviewForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                // Honeypot check
                let honeypot = form.find('input[name="website"]').val().trim();
                if (honeypot !== '') {
                    showToast('error', 'Spam detected!');
                    return;
                }

                Swal.fire({
                    title: 'Submitting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        Swal.close();
                        showToast('success', response.message ||
                            'Review submitted successfully!');
                        form.trigger('reset');
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.close();
                        let errorText = 'Something went wrong!';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                errorText = '';
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorText += value[0] + '\n';
                                });
                            } else if (xhr.responseJSON.error) {
                                errorText = xhr.responseJSON.error;
                            }
                        }
                        showToast('error', errorText);
                    }
                });
            });


        });
    </script>
@endsection
