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



    .choose-icon img {

        width: 35px;

        filter: brightness(0) invert(1);

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

    .floating-card {

        position: fixed;

        bottom: 20%;

        right: 20px;

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



    .floating-card p {

        font-size: 0.9rem;

        margin: 0.25rem 0;

    }
</style>

@endsection



@section('content')

<main class="main">

    <div class="container-fluid bg-search">

        <div class="container pb-4">

            <div class="row">

                <div class="col-sm-6 py-5">

                    <h2 class="mb-4">{{$lab_test->title ?? ''}}</h2>

                    <p>{{$lab_test->content ?? ''}}</p>

                    <div class="header-middle-search mt-5">

                        <form action="{{ route('lab.test') }}" method="GET">

                            <div class="search-content ps-3">

                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by Test Name... ">

                                <button type="submit" class="search-btn"><i class="far fa-search"></i></button>

                            </div>

                            

                        </form>

                    </div>

                </div>

                <div class="col-sm-6">

                    <img src="{{ asset($lab_test->image ?? 'assets/img/hospital/doctor.png') }}" alt="">

                </div>

            </div>

        </div>

    </div>



    <div class="choose-area ">

        <div class="container">



            <div class="choose-content wow fadeInUp" data-wow-delay=".25s"

                style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInUp;">

                <div class="row">

                    <div class="col-12 wow fadeInDown py-0 pb-4" data-wow-delay=".25s"

                        style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInDown;">

                        <div class="site-heading-inline">

                            <h2 class="site-title">Book via Prescriplion or Call</h2>



                        </div>

                    </div>

                </div>

                <div class="row g-4">

                    <div class="col-lg-4">

                        <div class="choose-item shadow-sm ">

                            <div class="choose-icon rounded-circle">

                                <img src="{{asset('assets/img/icon/document.pn')}}g" alt="">

                            </div>

                            <div class="choose-info">

                                <h4 style="margin: revert;">Upload Precription</h4>



                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="choose-item shadow-sm ">

                            <div class="choose-icon rounded-circle">

                                <img src="{{asset('assets/img/icon/call.png')}}" alt="">

                            </div>

                            <div class="choose-info align-middle">

                                <h4 style="margin: revert;">Call us to book a test</h4>



                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="instagram-area pt-100 pb-100">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="row">

                <div class="col-12 wow fadeInDown" data-wow-delay=".25s">

                    <div class="site-heading-inline">

                        <h2 class="site-title">Choose Corporate Lab Tests</h2>

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

    <div class="container">



    </div>



</main>
<div class="floating-card">

    <h4>📞 Call to Book a  Test</h4>

    <p class="phone-number">+91 12345 67890</p>

    <p>We’re here to help.</p>

    <a href="tel:+911234567890" class="btn btn-primary call-btn">Call</a>

  </div>

@endsection



@section('js')
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