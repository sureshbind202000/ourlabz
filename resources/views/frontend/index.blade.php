@extends('frontend.includes.layout')
@section('seo_tags')
<title>Ourlabz | Lab Tests | Health Checkups | Lab Products</title>
@endsection

@section('css')

<style>
    .small-banner .owl-nav button.owl-prev,

    .small-banner .owl-nav button.owl-next,

    .category-slider .owl-nav button.owl-prev,

    .category-slider .owl-nav button.owl-next {

        position: absolute;

        top: 30%;

        background: #0095d9;

        height: 40px;

        width: 40px;

        border-radius: 50%;

        color: #fff;

        border: none;

        /* padding: 0px 20px !important; */

        font-size: 23px;

        font-weight: bold;

        cursor: pointer;

    }



    .small-banner .owl-nav button.owl-prev,

    .category-slider .owl-nav button.owl-prev {

        left: -10px;

    }



    .small-banner .owl-nav button.owl-next,

    .category-slider .owl-nav button.owl-next {

        right: -10px;

    }



    .category-slider .owl-nav.disabled {

        display: block;

    }





    .product-wrap .owl-dots {

        display: none;

    }

    /* --- Modern Full-Width Glassy Search --- */
    .modern-search-area {
        max-width: 900px;
        padding: 20px 20px;
        background: linear-gradient(136deg, #0095d9 0%, #dbf0fa 100%);
        position: relative;
        overflow: hidden;
        border-radius: 20px;
    }

    .modern-search-area::before {
        content: "";
        position: absolute;
        inset: 0;
        background: url('https://www.transparenttextures.com/patterns/cubes.png');
        opacity: 0.05;
    }

    .search-inner {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
        text-align: center;
        color: #fff;
        z-index: 1;
        animation: fadeIn 1.2s ease;
    }

    .search-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .search-title span {
        color: #ffffff;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .search-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 35px;
    }

    /* Glassy Search Bar */
    .search-bar {
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 60px;
        padding: 8px 12px;
        max-width: 700px;
        margin: 0 auto;
        transition: all 0.3s ease;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .search-bar:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.02);
    }

    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        padding: 15px 20px;
        font-size: 16px;
        color: #fff;
    }

    .search-bar input::placeholder {
        color: rgba(255, 255, 255, 0.8);
    }

    .search-bar button {
        background: #fff;
        color: #0095d9;
        border: none;
        border-radius: 50px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    .search-bar button:hover {
        background: #e6f7ff;
        transform: translateY(-2px);
    }
    .product-price {
        font-size: 15px !important;
    }
    .product-price strike{
        font-size: 13px !important;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .search-title {
            font-size: 26px;
        }

        .search-bar {
            flex-direction: row;
            padding: 2px 8px;
            justify-content: left;
        }

        .search-bar input {
            flex: auto;
            width: 80%;
            padding: 10px;

        }

        .search-bar button {
            /* width: 100%; */
            justify-content: center;
            /* margin-top: 10px; */
            padding: 10px;
        }
    }
  @media (max-width: 425px) {
     .product-price {
        width: min-content;
     }
     .product-item .type{
            padding: 1px 10px;
     }
     .item-tab .nav-link{
        font-size: small;
     }
     .package-card h6.small{
        font-size: 12px !important;

     }
     .package-card p.small{
        font-size: 11px !important;

     }
  }
    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@endsection



@section('content')

<main class="main">

    <!-- hero slider -->

    <div class="hero-section hs-1 mt-30">

        <div class="container">

            <div class="hero-slider owl-carousel owl-theme shadow-sm">

                @foreach ($banners as $banner)

                <div class="hero-single">

                    <div class="container">

                        <div class="row align-items-center">

                            <div class="col-lg-6">

                                <div class="hero-content">

                                    <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">

                                        {{ $banner->tag }}

                                    </h6>

                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">

                                        {{ $banner->heading }} <span>{{ $banner->heading2 }}</span>

                                        {{ $banner->heading3 }}

                                    </h1>

                                    <p data-animation="fadeInLeft" data-delay=".75s">

                                        {{ $banner->paragraph }}

                                    </p>

                                    <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">

                                        <a href="{{ $banner->button_link }}"

                                            class="theme-btn">{{ $banner->button_text }}<i

                                                class="fas fa-arrow-right"></i></a>

                                        <a href="{{ $banner->button_link2 }}"

                                            class="theme-btn theme-btn2">{{ $banner->button_text2 }}<i

                                                class="fas fa-arrow-right"></i></a>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="hero-right" data-animation="fadeInRight" data-delay=".25s">

                                    <div class="hero-img">

                                        @if ($banner->product_id == 0)

                                        <img src="{{ $banner->image }}" alt="">

                                        @else
                                        @php
                                        $firstImage = $banner->product && $banner->product->images->count() > 0
                                        ? asset($banner->product->images->first()->image)
                                        : asset('backend/assets/img/no-image.jpg'); // fallback image
                                        @endphp
                                        <div class="hero-img-price" style="font-size: 14px;">

                                            <span>Price</span>

                                            <span>₹{{$banner->product->selling_price}}</span>

                                        </div>

                                        <img src="{{ $firstImage }}" alt="{{ $banner->product->product_name ?? 'Product Image' }}">

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

    </div>

    <!-- hero slider end -->
    <div class="hero-section hs-1 mt-30">

        <div class="container">
            <section class="modern-search-area mx-auto">
                <div class="search-inner">
                    <h2 class="search-title">Find the Right <span>Lab Test</span> Near You</h2>
                    <p class="search-subtitle">Search for tests, health packages, or labs — fast, easy, and reliable.</p>

                    <form action="{{ route('lab.test') }}" method="GET" class="search-bar">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search for lab tests or health packages..."
                            value="{{ request('search') }}" />
                        <button type="submit" class="d-none d-md-block">
                            <i class="fas fa-flask"></i> Search
                        </button>
                        <button type="submit" class="d-md-none">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                </div>
            </section>
        </div>
    </div>



    <!-- category area -->

    <div class="category-area2 mt-30">

        <div class="container">

            <div class="row">

                <div class="col-12 wow fadeInDown py-0" data-wow-delay=".25s"

                    style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInDown;">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Top Category</h2>

                        <a href="{{ url('category', ['type' => 'Organ']) }}">View More <i

                                class="fas fa-angle-double-right"></i></a>

                    </div>

                </div>

            </div>





        </div>

    </div>

    <div class="category-area pb-10">

        <div class="container">

            <!-- <div class="row">

                                                                                                                                <div class="col-12 wow fadeInDown" data-wow-delay=".25s">

                                                                                                                                    <div class="site-heading-inline">

                                                                                                                                        <h2 class="site-title">Top Category</h2>

                                                                                                                                        <a href="#">View More <i class="fas fa-angle-double-right"></i></a>

                                                                                                                                    </div>

                                                                                                                                </div>

                                                                                                                            </div> -->

            <div class="category-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                @foreach ($category_by_organ as $category)

                <div class="category-item">

                    <a href="{{ route('lab.test', ['category' => $category->slug]) }}">

                        <div class="category-info">

                            <div class="card  h-100 ">

                                <div class="card-body px-0  ">

                                    <div class="icon">

                                        <img src="{{ asset($category->category_image) }}" alt="">

                                    </div>

                                    <div class="content">

                                        <h4>{{ $category->category_name }}</h4>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>

                @endforeach

            </div>

        </div>

    </div>

    <!-- category area end-->

    <!-- Lab Test -->

    <div class="product-area pb-80">

        <div class="container">

            <div class="row g-4">

                <div class="col-lg-3">

                    <div class="product-banner wow fadeInRight h-100" data-wow-delay=".25s">

                        <a href="#" class="h-100">

                            <img src="{{ asset('assets/img/banner/product-banner.png') }}" alt=""

                                class="h-100" style="object-fit: cover;">

                        </a>

                    </div>

                </div>

                <div class="col-lg-9">

                    <div class="row">

                        <div class="col-12 wow fadeInDown" data-wow-delay=".25s">

                            <div class="site-heading-inline">

                                <h2 class="site-title">Lab Test</h2>

                                <a href="{{ route('lab.test') }}">View All <i

                                        class="fas fa-angle-double-right"></i></a>

                            </div>

                            <div class="item-tab">

                                <ul class="nav nav-pills mt-40 mb-35" id="item-tab" role="tablist">

                                    <li class="nav-item" role="presentation">

                                        <button class="nav-link active filter-tab" id="item-tab1" data-type="All"

                                            data-bs-toggle="pill" data-bs-target="#pill-item-tab1" type="button"

                                            role="tab" aria-controls="pill-item-tab1"

                                            aria-selected="true">All</button>

                                    </li>

                                    @foreach ($test_types as $type)

                                    <li class="nav-item" role="presentation">

                                        <button class="nav-link filter-tab" id="item-tab"

                                            data-type="{{ $type }}" data-bs-toggle="pill"

                                            data-bs-target="#pill-item-tab1" type="button" role="tab"

                                            aria-controls="pill-item-tab1"

                                            aria-selected="true">{{ $type }}</button>

                                    </li>

                                    @endforeach



                                </ul>

                            </div>

                        </div>

                    </div>

                    <div class="tab-content wow fadeInUp" data-wow-delay=".25s" id="item-tabContent">

                        <div class="tab-pane show active" id="pill-item-tab1" role="tabpanel"

                            aria-labelledby="item-tab1" tabindex="0">

                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="item-container">

                                @foreach ($packages as $package)

                                <div class="col package-card">

                                    <div class="card h-100 p-3 border">

                                        <div class="card-body p-0 mb-4">

                                            <div class="d-flex gap-2">

                                                <div class="border p-1 rounded-2 test-image">

                                                    @php

                                                    $icon = $package->package_icon

                                                    ? asset($package->package_icon)

                                                    : ($package->categoryDetails &&

                                                    $package->categoryDetails->category_image

                                                    ? asset(

                                                    $package->categoryDetails->category_image,

                                                    )

                                                    : asset('default.png'));

                                                    @endphp

                                                    <img src="{{ $icon }}" alt="">

                                                </div>

                                                <div>

                                                    <h6 class=" mb-2 fw-bold ">

                                                        <a

                                                            href="{{ route('test.details', ['slug' => $package->slug]) }}">

                                                            {{ $package->name }}

                                                        </a>

                                                    </h6>

                                                    <div class=" d-flex gap-3 mt-2">

                                                        <div>

                                                            <h6 class="small text-muted">Parameters</h6>

                                                            <p class="text-muted small">

                                                                {{ count($package->parameters) }} Test

                                                            </p>

                                                        </div>

                                                        <div>

                                                            <h6 class="small text-muted">Reports Within</h6>

                                                            <p class="text-muted small">

                                                                {{ $package->reports_within }} Hours

                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="d-flex w-100 price justify-content-between align-items-center">

                                            <div>

                                                <span class="pe-2 text-dark fw-bold">

                                                    ₹{{ number_format($package->selling_price, 2) }}

                                                </span>



                                                @if (!empty($package->discount_label))

                                                <del class="text-muted small px-0">

                                                    ₹{{ number_format($package->regular_price, 2) }}

                                                </del>

                                                <br>

                                                <span class="text-danger small px-0">

                                                    {{ $package->discount_label }}

                                                </span>

                                                @endif

                                            </div>

                                            @php

                                            $key = get_class($package) . '_' . $package->id;

                                            $inCart = in_array($key, $cartItems);

                                            $quantity = 1;



                                            // if logged in or session cart has this item, get its quantity

                                            if ($inCart) {

                                            if (Auth::check()) {

                                            $cartRow = \App\Models\Cart::where(

                                            'user_id',

                                            Auth::id(),

                                            )

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

                                            <div class="cart-action">

                                                @if ($inCart)

                                                <div class="d-flex align-items-center gap-2">

                                                    <select class="form-select form-select-sm update-qty"

                                                        data-id="{{ $package->id }}" data-type="package"

                                                        style="max-width: 110px;">

                                                        <option value="remove" class="remove-from-cart"

                                                            data-id="{{ $package->id }}"

                                                            data-type="package">

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

                                        </div>

                                    </div>

                                </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Lab Test end -->

    <!-- Disease category area -->

    <div class="category-area2">

        <div class="container">

            <div class="row">

                <div class="col-12 wow fadeInDown py-0" data-wow-delay=".25s"

                    style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInDown;">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Disease</h2>

                        <a href="{{ url('category', ['type' => 'Disease']) }}">View More <i

                                class="fas fa-angle-double-right"></i></a>

                    </div>

                </div>

            </div>





        </div>

    </div>

    <div class="category-area pb-80">

        <div class="container">

            <div class="category-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                @foreach ($category_by_disease as $category)

                <div class="category-item">

                    <a href="{{ route('lab.test', ['category' => $category->slug]) }}">

                        <div class="category-info">

                            <div class="card  h-100 ">

                                <div class="card-body px-0  ">

                                    <div class="icon">

                                        <img src="{{ asset($category->category_image) }}" alt="">

                                    </div>

                                    <div class="content">

                                        <h4>{{ $category->category_name }}</h4>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>

                @endforeach

            </div>

        </div>

    </div>

    <!-- category area end-->



    <!-- small banner -->

    @if ($offers->count())

    <div class="small-banner pb-80">

        <div class="container">

            <div class="row">

                <div class="col-lg-12 item-3 wow fadeInUp" data-wow-delay=".25s">

                    <!-- testimonial area -->

                    <div class="banner-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                        @foreach ($offers as $offer)

                        @if ($offer->type == 'slider')

                        <a href="{{ $offer->link }}" target="_blank">

                            <div class="banner-item">

                                <img src="{{ asset($offer->image) }}" alt="">

                            </div>

                        </a>

                        @endif

                        @endforeach

                    </div>



                    <!-- testimonial area end -->

                </div>

            </div>

        </div>

    </div>

    @endif

    <!-- small banner end -->





    <!-- feature area -->

    @if ($feature)

    <div class="feature-area pb-80">

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

    <!-- Higiene item -->
    @if($products->isNotEmpty())
    <div class="product-area pb-80">

        <div class="container">

            <div class="row">

                <div class="col-12 wow fadeInDown" data-wow-delay=".25s">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Higiene Items</h2>

                        <a href="{{ route('shop') }}">View More <i class="fas fa-angle-double-right"></i></a>

                    </div>

                </div>

            </div>

            <div class="product-wrap item-3 wow fadeInUp" data-wow-delay=".25s">

                <div class="product-slider owl-carousel owl-theme">



                    @foreach ($products as $product)

                    @php

                    $regular = $product->regular_price;

                    $discount = $product->discount;

                    $type = $product->discount_type;

                    $selling = $regular;

                    $discount_label = null;



                    if ($discount && $type === 'percent') {

                    $selling = $regular - ($regular * $discount) / 100;

                    $discount_label = $discount . '% Off';

                    } elseif ($discount && $type === 'flat') {

                    $selling = $regular - $discount;

                    $discount_label = '₹' . number_format($discount, 0) . ' Off';

                    }

                    @endphp



                    <div class="product-item">

                        <div class="product-img">

                            {{-- Discount or New badge --}}

                            @if ($discount_label)

                            <span class="type discount">{{ $discount_label }}</span>

                            @else

                            <span class="type new">New</span>

                            @endif



                            {{-- Product Image --}}

                            <a href="{{ route('product', ['slug' => $product->slug]) }}">

                                <img src="{{ asset(optional($product->images->first())->image ?? 'assets/img/product/default.png') }}"

                                    alt="{{ $product->product_name }}">

                            </a>



                            {{-- Product Actions --}}

                            <div class="product-action-wrap">

                                <div class="product-action">

                                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"

                                                data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a> --}}

                                    <a href="javascript:void(0);" class="add-to-wishlist"

                                        data-id="{{ $product->id }}" data-tooltip="tooltip"

                                        title="Add To Wishlist"><i class="far fa-heart"></i></a>

                                    <!-- <a href="#" data-tooltip="tooltip" title="Add To Compare"><i

                                            class="far fa-arrows-repeat"></i></a> -->

                                </div>

                            </div>

                        </div>



                        <div class="product-content">

                            {{-- Product Title --}}

                            <h3 class="product-title">

                                <a href="">{{ $product->product_name }}</a>

                            </h3>



                            {{-- Star Rating --}}

                            <div class="product-rate">

                                @php

                                $rating = $product->average_rating ?? rand(3, 5);

                                @endphp

                                @for ($i = 1; $i <= 5; $i++)

                                    <i class="{{ $i <= round($rating) ? 'fas' : 'far' }} fa-star"></i>

                                    @endfor

                            </div>



                            {{-- Price and Cart Button --}}

                            <div class="product-bottom">

                                <div class="product-price">

                                    @if ($discount)

                                    <span class=" fw-bold me-0 me-md-2">₹{{ number_format($selling, 2) }}</span>

                                    <strike class="text-muted me-0 me-md-2">₹{{ number_format($regular, 2) }}</strike>

                                    @else

                                    <span class="fw-bold">₹{{ number_format($regular, 2) }}</span>

                                    @endif

                                </div>

                                <button type="button" class="product-cart-btn product-add-to-cart"

                                    data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"

                                    data-id="{{ $product->id }}" data-type="Product">

                                    <i class="far fa-shopping-bag"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                    @endforeach



                </div>

            </div>

        </div>

    </div>
    @endif
    <!-- Higiene item end -->

    <!-- big banner -->

    @if ($offers->count())

    <div class="big-banner pb-80">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            @foreach ($offers as $offer)

            @if ($offer->type == 'content')

            <div class="banner-wrap" style="background-image: url('{{ asset($offer->image) }}');">

                <div class="row">

                    <div class="col-lg-8 mx-auto">

                        <div class="banner-content">

                            <div class="banner-info">

                                {!! $offer->content !!}

                            </div>

                            <a href="{{ $offer->link }}" class="theme-btn" target="_blank">Shop Now<i

                                    class="fas fa-arrow-right"></i></a>

                        </div>

                    </div>

                </div>

            </div>

            @endif

            @endforeach

        </div>

    </div>

    @endif

    <!-- big banner end -->

    <!-- Equipments item -->
    @if($equipments->isNotEmpty())
    <div class="product-area pb-80">

        <div class="container">

            <div class="row">

                <div class="col-12 wow fadeInDown" data-wow-delay=".25s">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Equipments</h2>

                        <a href="{{ route('shop') }}">View More <i class="fas fa-angle-double-right"></i></a>

                    </div>

                </div>

            </div>

            <div class="product-wrap item-3 wow fadeInUp" data-wow-delay=".25s">

                <div class="product-slider owl-carousel owl-theme">

                    @foreach ($equipments as $product)

                    @php

                    $regular = $product->regular_price;

                    $discount = $product->discount;

                    $type = $product->discount_type;

                    $selling = $regular;

                    $discount_label = null;



                    if ($discount && $type === 'percent') {

                    $selling = $regular - ($regular * $discount) / 100;

                    $discount_label = $discount . '% Off';

                    } elseif ($discount && $type === 'flat') {

                    $selling = $regular - $discount;

                    $discount_label = '₹' . number_format($discount, 0) . ' Off';

                    }

                    @endphp



                    <div class="product-item">

                        <div class="product-img">

                            {{-- Discount or New badge --}}

                            @if ($discount_label)

                            <span class="type discount">{{ $discount_label }}</span>

                            @else

                            <span class="type new">New</span>

                            @endif



                            {{-- Product Image --}}

                            <a href="{{ route('product', ['slug' => $product->slug]) }}">

                                <img src="{{ asset(optional($product->images->first())->image ?? 'assets/img/product/default.png') }}"

                                    alt="{{ $product->product_name }}">

                            </a>



                            {{-- Product Actions --}}

                            <div class="product-action-wrap">

                                <div class="product-action">

                                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"

                                                data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a> --}}

                                    <a href="javascript:void(0);" class="add-to-wishlist"

                                        data-id="{{ $product->id }}" data-tooltip="tooltip"

                                        title="Add To Wishlist"><i class="far fa-heart"></i></a>

                                    <!-- <a href="#" data-tooltip="tooltip" title="Add To Compare"><i

                                            class="far fa-arrows-repeat"></i></a> -->

                                </div>

                            </div>

                        </div>



                        <div class="product-content">

                            {{-- Product Title --}}

                            <h3 class="product-title">

                                <a href="{{ route('product', ['slug' => $product->slug]) }}">{{ $product->product_name }}</a>

                            </h3>



                            {{-- Star Rating --}}

                            <div class="product-rate">

                                @php

                                $rating = $product->average_rating ?? rand(3, 5);

                                @endphp

                                @for ($i = 1; $i <= 5; $i++)

                                    <i class="{{ $i <= round($rating) ? 'fas' : 'far' }} fa-star"></i>

                                    @endfor

                            </div>



                            {{-- Price and Cart Button --}}

                            <div class="product-bottom">

                                <div class="product-price">

                                    @if ($discount)

                                    <span class="fw-bold me-0 me-md-2">₹{{ number_format($selling, 2) }}</span>

                                    <strike class="text-muted me-0 me-md-2">₹{{ number_format($regular, 2) }}</strike>

                                    @else

                                    <span class="fw-bold">₹{{ number_format($regular, 2) }}</span>

                                    @endif

                                </div>

                                <button type="button" class="product-cart-btn product-add-to-cart"

                                    data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"

                                    data-id="{{ $product->id }}" data-type="Product">

                                    <i class="far fa-shopping-bag"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>
    @endif
    <!-- Equipments item end -->



    <!-- brand area -->

    @if ($brands->count())

    <div class="brand-area pb-80">

        <div class="container">

            <div class="row">

                <div class="col-12">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Popular Brands</h2>



                    </div>

                </div>

            </div>

            <div class="brand-slider owl-carousel owl-theme">

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





    <!-- product list -->

    <div class="product-list pb-80 d-none">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="row g-4">

                <div class="col-12 col-md-6 col-lg-6 col-xl-4">

                    <div class="product-list-box border">

                        <h2 class="product-list-title">On sale</h2>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/01.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/02.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/03.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                    </div>

                </div>

                <div class="col-12 col-md-6 col-lg-6 col-xl-4">

                    <div class="product-list-box border">

                        <h2 class="product-list-title">Best Seller</h2>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/04.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/05.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/06.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                    </div>

                </div>

                <div class="col-12 col-md-6 col-lg-6 col-xl-4">

                    <div class="product-list-box border">

                        <h2 class="product-list-title">Top Rated</h2>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/07.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/08.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                        <div class="product-list-item">

                            <div class="product-list-img">

                                <a href=""><img src="assets/img/product/09.png" alt="#"></a>

                            </div>

                            <div class="product-list-content">

                                <h4><a href="">Surgical Face Mask</a></h4>

                                <div class="product-list-rate">

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="fas fa-star"></i>

                                    <i class="far fa-star"></i>

                                </div>

                                <div class="product-list-price">

                                    <del>60.00</del><span>$40.00</span>

                                </div>

                            </div>

                            <a href="#" class="product-list-btn" data-bs-placement="left"

                                data-tooltip="tooltip" title="Add To Cart"

                                style="width: 50px; border-radius: 50%;"><i class="far fa-shopping-bag"></i></a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- product list end -->





    <!-- deal area -->

    @if ($offers->count())

    <div class="deal-area py-80">

        <div class="deal-text-shape">Deal</div>

        <div class="container">

            <div class="deal-wrap wow fadeInUp" data-wow-delay=".25s">

                <div class="deal-slider owl-carousel owl-theme">

                    @foreach ($offers as $offer)

                    @if ($offer->type == 'timed_slider')

                    <div class="deal-item">

                        <div class="row align-items-center">

                            <div class="col-lg-6">

                                <div class="deal-content">

                                    <div class="deal-info">

                                        <span>{{ $offer->title }}</span>

                                        {!! $offer->content !!}

                                    </div>

                                    <div class="deal-countdown">

                                        @php

                                        $formattedDate = \Carbon\Carbon::parse(

                                        $offer->timer_end_at,

                                        )->format('Y/m/d');

                                        @endphp

                                        <div class="countdown" data-countdown="{{ $formattedDate }}">

                                        </div>

                                    </div>

                                    <a href="{{ $offer->link }}" class="theme-btn theme-btn2"

                                        target="_blank">Shop Now <i class="fas fa-arrow-right"></i></a>

                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="deal-img">

                                    <img src="{{ asset($offer->image) }}" alt="">

                                    <!-- <div class="deal-discount">

                                                                                                                                <span>35%</span>

                                                                                                                                <span>off</span>

                                                                                                                            </div> -->

                                </div>

                            </div>

                        </div>

                    </div>

                    @endif

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    @endif

    <!-- deal area end -->





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





    <!-- blog area -->

    @if ($blogs->count())

    <div class="blog-area py-80">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 mx-auto">

                    <div class="site-heading text-center">

                        <span class="site-title-tagline">Our Blog</span>

                        <h2 class="site-title">Our Latest News & <span>Blog</span></h2>

                    </div>

                </div>

            </div>

            <div class="row g-4">

                @foreach ($blogs as $blog)

                <div class="col-md-6 col-lg-4">

                    <div class="blog-item wow fadeInUp" data-wow-delay=".25s">

                        <div class="blog-item-img">

                            <img src="{{ asset($blog->thumbnail_image) }}" alt="Thumb">

                            <span class="blog-date"><i class="far fa-calendar-alt"></i>

                                {{ $blog->created_at->format('M d, Y') }}</span>

                        </div>

                        <div class="blog-item-info">

                            <div class="blog-item-meta">

                                <ul>

                                    <li><a href="{{ route('blog.details', ['slug' => $blog->slug]) }}"><i

                                                class="far fa-user-circle"></i> By {{ $blog->author }}</a>

                                    </li>

                                    <li><a

                                            href="{{ route('blog.details', ['slug' => $blog->slug]) }}#comment-section"><i

                                                class="far fa-comments"></i>

                                            {{ formatCount($blog->comments_count) }} Comments</a></li>

                                </ul>

                            </div>

                            <h4 class="blog-title">

                                <a

                                    href="{{ route('blog.details', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a>

                            </h4>

                            <p>{{ $blog->short_content }}</p>

                            <a class="theme-btn" href="{{ url('/blog', ['slug' => $blog->slug]) }}">Read

                                More<i class="fas fa-arrow-right"></i></a>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

    @endif

    <!-- blog area end -->



</main>

<!-- modal quick shop-->

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

<!-- modal quick shop end -->







@endsection



@section('js')

<script>
    // testimonial slider

    $('.banner-slider').owlCarousel({

        loop: true,

        margin: 20,

        nav: true,

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
    // testimonial slider

    $('#category-slider').owlCarousel({

        loop: true,

        margin: 10,

        nav: true,

        autoplay: true,

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.filter-tab', function() {

            Swal.fire({

                title: 'Loading...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $('.filter-tab').removeClass('active');

            $(this).addClass('active');



            const type = $(this).data('type');



            $.ajax({

                url: "{{ url('/') }}", // Update if needed

                method: "GET",

                data: {

                    type: type

                },

                success: function(items) {

                    Swal.close();

                    let html = '';



                    if (items.length === 0) {

                        html = '<div class="col"><p>No Test Found.</p></div>';

                    }







                    items.forEach(function(item) {

                        const parameters = item.parameters.length;

                        const sellingPrice = parseFloat(item.price) || 0;

                        const regularPrice = parseFloat(item.regular_price) || 0;

                        const discountType = item.discount_type;

                        const discountAmount = parseFloat(item.discount_price) || 0;



                        let actionHtml = '';



                        if (item.in_cart) {

                            actionHtml = `

                                    <div class="d-flex align-items-center gap-2">

                                        <select class="form-select form-select-sm update-qty"

                                            data-id="${item.id}" data-type="package" style="max-width: 110px;">

                                            <option value="remove">Remove Test</option>

                                            ${[1,2,3,4,5].map(i => `

                                                            <option value="${i}" ${item.quantity == i ? 'selected' : ''}>

                                                                ${i} ${i > 1 ? 'Patients' : 'Patient'}

                                                            </option>

                                                        `).join('')}

                                        </select>

                                    </div>

                                `;

                        } else {

                            actionHtml = `

                                    <a href="javascript:void(0);" class="btn btn-primary px-4 py-1 border-0 add-to-cart"

                                        data-id="${item.id}" data-type="package">Add</a>

                                `;

                        }



                        let discountHtml = '';

                        if (regularPrice > sellingPrice) {

                            if (discountType === 'percent') {

                                discountHtml = `

                                    <del class="text-muted small px-1">₹${regularPrice.toFixed(2)}</del>

                                    <br>

                                    <span class="text-danger small">(${discountAmount}% OFF)</span>

                                `;

                            } else if (discountType === 'flat') {

                                discountHtml = `

                                    <del class="text-muted small px-1">₹${regularPrice.toFixed(2)}</del>

                                    <br>

                                    <span class="text-danger small">(₹${discountAmount.toFixed(2)} OFF)</span>

                                `;

                            }

                        }



                        html += `

                        <div class="col">

                            <div class="card h-100 p-3 border">

                                <div class="card-body p-0 mb-4">

                                    <div class="d-flex gap-2">

                                        <div class="border p-1 rounded-2 test-image">

                                            <img src="${item.icon_url}" alt="Test Image">

                                        </div>

                                        <div>

                                            <h6 class="mb-2 fw-bold">

                                                <a href="/lab-test/${item.slug}">${item.name}</a>

                                            </h6>

                                            <div class="d-flex gap-3 mt-2">

                                                <div>

                                                    <h6 class="small text-muted">Parameters</h6>

                                                    <p class="text-muted small">${parameters} Test</p>

                                                </div>

                                                <div>

                                                    <h6 class="small text-muted">Reports Within</h6>

                                                    <p class="text-muted small">${item.reports_within} Hours</p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="d-flex w-100 price justify-content-between align-items-center">

                                    <div>

                                        <span class="pe-2 text-dark fw-bold">₹${sellingPrice.toFixed(2)}</span>

                                        ${discountHtml}

                                    </div>

                                    <div class="cart-action">

                                    ${actionHtml}

                                    </div>

                                </div>

                            </div>

                        </div>

                        `;



                    });



                    $('#item-container').html(html);

                },

                error: function(xhr) {

                    console.log(xhr);

                    Swal.close();

                    showToast('error', 'Something went wrong');

                }

            });

        });

    });
</script>

@endsection