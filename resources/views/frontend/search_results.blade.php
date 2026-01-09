@extends('frontend.includes.layout')

@section('css')
<style>
    /* === Compact Smart Search === */
    .search-section {
        padding: 25px 0;
        background: #fafafa;
        min-height: 65vh;
    }

    .search-title {
        font-size: 17px;
        font-weight: 600;
        color: #222;
        text-align: center;
        margin-bottom: 20px;
    }

    .section-header {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin: 10px 0;
        display: flex;
        align-items: center;
    }

    .section-header span {
        font-size: 17px;
        margin-right: 6px;
    }

    /* --- Card Styling --- */
    .result-card {
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        overflow: hidden;
        background: #fff;
        transition: all 0.2s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .result-img {
        height: 110px;
        width: 100%;
        object-fit: contain;
        background: #f7f7f7;
    }

    .card-body {
        padding: 6px 8px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-body h6 {
        font-size: 12.5px;
        font-weight: 600;
        color: #222;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .price {
        font-size: 12.5px;
        font-weight: 600;
        color: #0095d9;
        margin-top: auto;
    }

    /* Equal height across all cards */
    .equal-row>[class*='col-'] {
        display: flex;
    }

    /* --- No Results --- */
    .no-results {
        font-size: 13px;
        color: #777;
        text-align: center;
        margin-top: 25px;
    }

    /* --- Animation --- */
    .fade-in {
        animation: fadeIn 0.3s ease both;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .result-img {
            height: 95px;
        }

        .card-body h6 {
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
<main class="main">
    <section class="search-section">
        <div class="container">
            <h5 class="search-title fade-in">
                Search Results for: <strong>"{{ $search }}"</strong>
            </h5>

            {{-- Lab Tests --}}
            @if($labTests->count() > 0)
            <div class="section-header fade-in">
                <span>🔬</span> Lab Tests
            </div>
            <div class="row g-2 equal-row">
                @foreach($labTests as $t)
                @php
                $icon = $t->package_icon
                ? asset($t->package_icon)
                : ($t->categoryDetails && $t->categoryDetails->category_image
                ? asset($t->categoryDetails->category_image)
                : asset('default.png'));
                @endphp
                <div class="col-xl-2 col-lg-3 col-md-3 col-6 fade-in">
                    <a href="{{ route('test.details', $t->slug) }}" class="text-decoration-none w-100">
                        <div class="result-card w-100">
                            <img src="{{ $icon }}" class="result-img" alt="{{ $t->name }}">
                            <div class="card-body">
                                <h6>{{ Str::limit($t->name, 27) }}</h6>
                                <div class="price">

                                    <span class="pe-2 fw-bold">

                                        ₹{{ number_format($t->selling_price, 2) }}

                                    </span>



                                    @if (!empty($t->discount_label))

                                    <del class="text-muted small px-0">

                                        ₹{{ number_format($t->regular_price, 2) }}

                                    </del>

                                    <br>

                                    <span class="text-danger small px-0">

                                        {{ $t->discount_label }}

                                    </span>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Products --}}
            @if($products->count() > 0)
            <div class="section-header fade-in">
                <span>🛒</span> Products
            </div>
            <div class="row g-2 equal-row">
                @foreach($products as $p)
                @php

                $regular = $p->regular_price;

                $discount = $p->discount;

                $type = $p->discount_type;

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
                <div class="col-xl-2 col-lg-3 col-md-3 col-6 fade-in">
                    <a href="{{ route('product', $p->slug) }}" class="text-decoration-none w-100">
                        <div class="result-card w-100">
                            <img src="{{ asset(optional($p->images->first())->image ?? 'assets/img/product/default.png') }}"
                                class="result-img" alt="{{ $p->product_name }}">
                            <div class="card-body">
                                <h6>{{ Str::limit($p->product_name, 27) }}</h6>
                                <div class="price">

                                    @if ($discount)

                                    <span class=" fw-bold me-2">₹{{ number_format($selling, 2) }}</span>

                                    <strike class="text-muted me-2">₹{{ number_format($regular, 2) }}</strike>

                                    @else

                                    <span class="fw-bold">₹{{ number_format($regular, 2) }}</span>

                                    @endif

                                    @if ($discount_label)

                                    <span class="type discount text-danger">{{ $discount_label }}</span>

                                    @else

                                    <span class="type new text-warning">New</span>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            {{-- No Results --}}
            @if($products->count() === 0 && $labTests->count() === 0)
            <p class="no-results fade-in">
                No results found for "<strong>{{ $search }}</strong>".
            </p>
            @endif
        </div>
    </section>
</main>
@endsection