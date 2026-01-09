@extends('frontend.includes.dashboard_layout')
@section('css')
@endsection
@section('dash_content')

    <div class="user-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="user-card">
                    <h4 class="user-card-title">My Wishlist</h4>
                    <div class="row g-4 mt-20 item-2">
                        @forelse ($wishlists as $wishlist)
                            @php
                                $product = isset($wishlist->product) ? $wishlist->product : $wishlist;

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

                            <div class="col-md-6 col-lg-3">
                                <div class="product-item">
                                    <div class="product-img">
                                        @if ($discount_label)
                                            <span class="type discount">{{ $discount_label }}</span>
                                        @elseif ($product->is_new ?? false)
                                            <span class="type new">New</span>
                                        @endif

                                        <a href="{{ route('product', $product->slug) }}">
                                            <img src="{{ asset($product->images?->first()->image ?? 'assets/img/default-product.png') }}"
                                                alt="{{ $product->product_name }}" title="{{ $product->product_name }}">
                                        </a>

                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" title="Add To Compare">
                                                    <i class="far fa-arrows-repeat"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="remove-wishlist"
                                                    data-id="{{ $product->id }}" title="Remove From Wishlist">
                                                    <i class="far fa-xmark"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-content">
                                        <h3 class="product-title">
                                            <a
                                                href="{{ route('product', $product->slug) }}">{{ $product->product_name }}</a>
                                        </h3>

                                        <div class="product-rate">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= ($product->rating ?? 4) ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>

                                        <div class="product-bottom">
                                            <div class="product-price">
                                                @if ($discount)
                                                    <span
                                                        class=" fw-bold me-2">₹{{ number_format($selling, 2) }}</span>
                                                    <strike class="text-muted">₹{{ number_format($regular, 2) }}</strike>
                                                @else
                                                    <span class="fw-bold">₹{{ number_format($regular, 2) }}</span>
                                                @endif
                                            </div>

                                            <button type="button" class="product-cart-btn product-add-to-cart"
                                                data-id="{{ $product->id }}" title="Add To Cart">
                                                <i class="far fa-shopping-bag"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">Your wishlist is empty.</p>
                            </div>
                        @endforelse
                    </div>


                    <!-- Pagination (optional if paginating wishlist) -->
                    {{-- {!! $wishlists->links() !!} --}}
                </div>
            </div>
        </div>
    </div>



    <!-- modal quick shop-->
    {{-- <div class="modal quickview fade" id="quickview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
</div> --}}
    <!-- modal quick shop end -->
@endsection
@section('js')
    <script>
        function updateWishlistCount() {
            $.get("{{ route('wishlist.count') }}", function(res) {
                console.log(res.count);
                if (res.count !== undefined) {
                    $('#product-wishlist-count').text(res.count);
                }
            });
        }
        updateWishlistCount();
        $(document).on('click', '.remove-wishlist', function() {
            Swal.fire({
                title: 'Removing from wishlist...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route('wishlist.remove') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id
                },
                success: function(res) {
                    Swal.close();
                    if (res.success) {
                        showToast('success', 'Product removed to wishlist!');
                        updateWishlistCount();
                        window.location.reload();
                    }
                }
            });
        });
    </script>
@endsection
