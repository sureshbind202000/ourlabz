<div class="row g-4">





    @foreach ($products as $product)

        <div class="col-6 col-sm-6 col-md-6 col-lg-4">

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

                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip"

                                title="Quick View"><i class="far fa-eye"></i></a> --}}

                            <a href="javascript:void(0);" class="add-to-wishlist" data-id="{{ $product->id }}"

                                data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>

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

                                <span class="fw-bold me-2">₹{{ number_format($selling, 2) }}</span>

                                <strike class="text-muted me-2">₹{{ number_format($regular, 2) }}</strike>

                            @else

                                <span class="fw-bold">₹{{ number_format($regular, 2) }}</span>

                            @endif

                        </div>

                        <button type="button" class="product-cart-btn product-add-to-cart" data-bs-placement="left"

                            data-tooltip="tooltip" title="Add To Cart" data-id="{{ $product->id }}"

                            data-type="Product">

                            <i class="far fa-shopping-bag"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endforeach



    {{-- Pagination --}}

    <div class="pagination-area mt-3">

        {{ $products->links('vendor.pagination.custom') }}

    </div>

</div>

