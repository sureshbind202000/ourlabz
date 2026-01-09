@extends('frontend.includes.layout')

@section('css')

    <style>

        .testimonial-author {

            display: flex;

            align-items: center;

            gap: 10px;

            /* padding: 8px; */

            margin-bottom: 15px;

            background: transparent;

            border-radius: 0px;

            /* border-bottom: 1px solid var(--border-info-color); */

            box-shadow: none;

        }



        .star-rating {

            color: #fffb00;

        }



        .review-avatar {

            width: 40px;

            height: 40px;

            object-fit: cover;

            border-radius: 50%;

        }



        .clamp-2 {

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;

        }



        .lcl_txt_toggle {

            display: none !important;

        }



        #lcl_author,

        #lcl_txt {

            display: none !important;

        }



        .variant-card:hover {

            transform: translateY(-3px);

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);

        }



        .variant-card.selected {

            border: 2px solid #0095d9 !important;

        }



        .variant-card:hover .variant-overlay {

            opacity: 1;

        }



        /* Slider CSS Start  */



        .thumbnail_slider {

            max-width: 700px;

        }



        .splide__slide {

            display: flex;

            justify-content: center;

            align-items: center;

            overflow: hidden;

            transition: .2s;

            border-width: 2px !important;

            margin: 10px 4px;

        }



        .splide--nav>.splide__track>.splide__list>.splide__slide.is-active {

            box-shadow: none !important;

        }



        .splide--nav>.splide__track>.splide__list>.splide__slide.is-active {

            border-color: #0095d9;

        }



        .splide__slide img {

            width: 100%;

            height: 100%;

            object-fit: contain !important;

            /* prevent cropping */

            background-color: #fff;

            /* optional – adds clean padding */

            border-radius: 8px;

            /* optional – soft corners */

        }



        /* Slider CSS End  */

    </style>

@endsection

@section('content')

    <main class="main">



        <!-- shop single -->

        <div class="shop-single py-90">

            <div class="container">

                <div class="row">

                    <div class="col-md-9 col-lg-6 col-xxl-5 mx-auto">

                        <div class="thumbnail_slider">

                            <!-- Primary Slider -->

                            <div id="primary_slider" class="splide">

                                <div class="splide__track">

                                    <ul class="splide__list" id="primary_slides">

                                        @foreach ($product->images as $image)

                                            <li class="splide__slide product-image">

                                                <img src="{{ asset($image->image) }}" alt="{{ $product->product_name }}">

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>



                            <!-- Thumbnail Slider -->

                            <div id="thumbnail_slider" class="splide mt-3 border">

                                <div class="splide__track">

                                    <ul class="splide__list" id="thumbnail_slides">

                                        @foreach ($product->images as $image)

                                            <li class="splide__slide product-image">

                                                <img src="{{ asset($image->image) }}" alt="{{ $product->product_name }}">

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="col-md-12 col-lg-6 col-xxl-6">

                        <div class="shop-single-info">

                            <h4 class="shop-single-title" id="selected-variant-name">{{ $product->product_name }}</h4>

                            <div class="shop-single-rating">

                                @php

                                    $avgRating = round($product->avg_rating ?? rand(3, 5));

                                @endphp



                                @for ($i = 1; $i <= 5; $i++)

                                    <i class="{{ $i <= $avgRating ? 'fas text-warning' : 'far' }} fa-star"></i>

                                @endfor

                                <span class="rating-count"> ({{ $product->review_count }} Customer Reviews)</span>

                            </div>

                            @php

                                $regular = $product->regular_price;

                                $discount = $product->discount;

                                $type = $product->discount_type;



                                $selling = $regular;

                                $discountLabel = null;



                                if ($type === 'percent') {

                                    $selling = $regular - ($regular * $discount) / 100;

                                    $discountLabel = $discount . '% Off';

                                } elseif ($type === 'flat') {

                                    $selling = $regular - $discount;

                                    $discountLabel = '₹' . number_format($discount, 2) . ' Off';

                                }

                            @endphp



                            <div class="shop-single-price" id="selected-variant-price">

                                @if ($discount > 0)

                                    <del>₹{{ number_format($regular, 2) }}</del>

                                    <span class="amount text-primary">₹{{ number_format($selling, 2) }}</span>

                                    <span class="discount-percentage text-success border badge">{{ $discountLabel }}</span>

                                @else

                                    <span class="amount">₹{{ number_format($regular, 2) }}</span>

                                @endif

                            </div>



                            <p>

                                {{ $product->short_desc }}

                            </p>



                            @php

                                // Group variant data by attribute

                                $attributes = [];

                                foreach ($product->variants as $variant) {

                                    foreach ($variant->attributeValues() as $attrValue) {

                                        $attrName = $attrValue->attribute->name ?? 'Unknown';

                                        $attributes[$attrName][$attrValue->value][] = $variant->id;

                                    }

                                }

                            @endphp



                            <div class="shop-single-cs border-top-0 mb-2">

                                <div class="row">

                                    <div class="col-md-12">

                                        @if ($product->varient == 1)

                                            <h6 class="mb-2">Available Variant</h6>



                                            @foreach ($attributes as $attrName => $values)

                                                <div class="mb-2 d-flex gap-2 align-items-center">

                                                    <strong>{{ $attrName }}:</strong>

                                                    <div class="d-flex flex-wrap gap-2 mt-1">

                                                        @foreach ($values as $value => $variantIds)

                                                            <button type="button"

                                                                class="btn btn-outline-secondary btn-sm variant-btn"

                                                                data-attr="{{ $attrName }}"

                                                                data-value="{{ $value }}"

                                                                data-variant-ids="{{ json_encode($variantIds) }}">

                                                                {{ $value }}

                                                            </button>

                                                        @endforeach

                                                    </div>

                                                </div>

                                            @endforeach



                                            <!-- Selected variant details -->

                                            <div class="mt-3 p-2 border rounded" id="selected-variant-info"

                                                style="display:none;">

                                                <p><strong>Variant:</strong> <span id="selected-variant-name"></span></p>

                                                <p><strong>Price:</strong> ₹ <span id="selected-variant-price"></span></p>

                                                <p><strong>Stock:</strong> <span id="selected-variant-stock"></span></p>

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </div>

                            <div class="shop-single-cs mt-2">

                                <div class="row">

                                    <div class="col-md-3 col-lg-4 col-xl-3">

                                        <div class="shop-single-size">

                                            <h6>Quantity</h6>

                                            <div class="shop-cart-qty">

                                                <button class="minus-btn"><i class="fal fa-minus"></i></button>

                                                <input class="quantity" type="text" value="1" disabled="">

                                                <button class="plus-btn"><i class="fal fa-plus"></i></button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="shop-single-sortinfo">

                                <ul>

                                    <li>Stock: <span id="selected-variant-stock"

                                            class="{{ $product->in_stock ? 'text-success' : 'text-danger' }}">

                                            {{ $product->in_stock ? 'Available' : 'Out Of Stock' }}</span></li>



                                    <li>Product Identification No : <span

                                            id="selected-variant-pid">{{ $product->product_identification_no }}</span>

                                    </li>

                                    <li>Category: <span>{{ $product->productCategory->name }}</span></li>

                                    <li>Brand: <span>{{ $product->brand }}</span></li>

                                    <li>

                                        Tags:

                                        @foreach (explode(',', $product->tags) as $tag)

                                            <a href="#{{ trim($tag) }}"

                                                class="badge bg-primary text-white me-1">{{ trim($tag) }}</a>

                                        @endforeach

                                    </li>

                                </ul>

                            </div>

                            <div class="shop-single-action">

                                <div class="row align-items-center">

                                    <div class="col-md-6 col-lg-12 col-xl-6">

                                        <div class="shop-single-btn">

                                            <a href="javascript:void(0);" class="theme-btn product-add-to-cart" data-id="{{ $product->id }}" data-type="Product"><span

                                                    class="far fa-shopping-bag" ></span>Add

                                                To

                                                Cart</a>

                                            <a href="javascript:void(0);" class="theme-btn theme-btn2 add-to-wishlist"

                                                data-id="{{ $product->id }}" data-tooltip="tooltip"

                                                title="Add To Wishlist"><span class="far fa-heart"></span></a>



                                            <a href="javascript:void(0);" class="theme-btn theme-btn2"

                                                data-tooltip="tooltip" title="Add To Compare"><span

                                                    class="far fa-arrows-repeat"></span></a>

                                        </div>

                                    </div>

                                    <div class="col-md-6 col-lg-12 col-xl-6">

                                        <div class="shop-single-share">

                                            <span>Share:</span>

                                            <a href="#"><i class="fab fa-facebook-f"></i></a>

                                            <a href="#"><i class="fab fa-x-twitter"></i></a>

                                            <a href="#"><i class="fab fa-linkedin-in"></i></a>

                                            <a href="#"><i class="fab fa-pinterest-p"></i></a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- shop single details -->

                <div class="shop-single-details">

                    <nav>

                        <div class="nav nav-tabs" id="nav-tab" role="tablist">

                            <button class="nav-link active" id="nav-tab1" data-bs-toggle="tab" data-bs-target="#tab1"

                                type="button" role="tab" aria-controls="tab1"

                                aria-selected="true">Description</button>

                            <button class="nav-link" id="nav-tab2" data-bs-toggle="tab" data-bs-target="#tab2"

                                type="button" role="tab" aria-controls="tab2" aria-selected="false">Additional

                                Info</button>

                            <button class="nav-link" id="nav-tab3" data-bs-toggle="tab" data-bs-target="#tab3"

                                type="button" role="tab" aria-controls="tab3" aria-selected="false">Reviews

                            </button>

                        </div>

                    </nav>

                    <div class="tab-content" id="nav-tabContent">

                        <div class="tab-pane fade show active" id="tab1" role="tabpanel"

                            aria-labelledby="nav-tab1">

                            <div class="shop-single-desc">

                                {!! $product->long_desc ?? '' !!}

                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="nav-tab2">

                            <div class="shop-single-additional">

                                @if ($product->specifications && $product->specifications->count())

                                    <ul class="list-unstyled">

                                        @foreach ($product->specifications as $detail)

                                            <li class="mb-1">

                                                <strong>{{ $detail->label }} </strong> {{ $detail->property }}

                                            </li>

                                        @endforeach

                                    </ul>

                                @else

                                    <p>No additional details available.</p>

                                @endif

                            </div>

                        </div>





                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="nav-tab3">

                            <div class="shop-single-review">

                                <div class="blog-comments">

                                    <div class="container">

                                        <h3 class="mb-4">Reviews</h3>

                                        <div class="row py-4">

                                            <!-- Left Column: Reviews -->

                                            <!-- Product Reviews -->

                                            <div class="col-md-7">

                                                @forelse($product->reviews as $review)

                                                    <div class="mb-5 border-bottom">

                                                        <div class="d-flex align-items-center mb-2">

                                                            <img src="{{ asset('assets/img/user.png') }}"

                                                                alt="{{ $review->name }}" class="review-avatar me-3">

                                                            <div>

                                                                <strong>{{ $review->name }}</strong><br>

                                                                <small

                                                                    class="text-muted">{{ $review->created_at->diffForHumans() }}</small>

                                                            </div>

                                                            <div class="ms-auto text-purple">

                                                                <strong>{{ $review->rating }}.0</strong>

                                                                <span class="star-rating">

                                                                    @for ($i = 1; $i <= 5; $i++)

                                                                        <i

                                                                            class="{{ $i <= $review->rating ? 'fas text-warning' : 'far' }} fa-star"></i>

                                                                    @endfor

                                                                </span>

                                                            </div>

                                                        </div>



                                                        <p class="review-text clamp-2">{{ $review->comment }}</p>



                                                        @if ($review->images)

                                                            <div class="row g-2 py-2">

                                                                <div class="col-sm-12 d-flex gap-2 flex-wrap">

                                                                    @foreach (json_decode($review->images, true) as $img)

                                                                        <a href="{{ asset($img) }}" class="lightbox"

                                                                            data-lcl-thumb="{{ asset($img) }}">

                                                                            <img src="{{ asset($img) }}"

                                                                                alt="Review Image"

                                                                                class="gallery-img img-fluid rounded"

                                                                                style="height: 70px;">

                                                                        </a>

                                                                    @endforeach

                                                                </div>

                                                            </div>

                                                        @endif

                                                    </div>

                                                @empty

                                                    <p>No reviews yet. Be the first to review this product.</p>

                                                @endforelse

                                            </div>





                                            <!-- Right Column: Review Form -->

                                            <div class="col-md-5">

                                                <div class="blog-comments-form mt-0">

                                                    <h4 class="mb-4">Leave A Review</h4>

                                                    <form id="productReviewForm"

                                                        action="{{ route('website.product.review.store') }}"

                                                        method="POST" enctype="multipart/form-data">

                                                        @csrf

                                                        <input type="hidden" name="product_id"

                                                            value="{{ $product->id }}">

                                                        <input type="hidden" name="website">



                                                        <div class="row">

                                                            <div class="col-md-6">

                                                                <div class="form-group">

                                                                    <input type="text" name="name"

                                                                        class="form-control" placeholder="Your Name*"

                                                                        required>

                                                                </div>

                                                            </div>



                                                            <div class="col-md-6">

                                                                <div class="form-group">

                                                                    <input type="email" name="email"

                                                                        class="form-control" placeholder="Your Email*"

                                                                        required>

                                                                </div>

                                                            </div>



                                                            <div class="col-md-6">

                                                                <div class="form-group">

                                                                    <select class="form-control form-select"

                                                                        name="rating" required>

                                                                        <option value="">Your Rating</option>

                                                                        <option value="5">5 Stars</option>

                                                                        <option value="4">4 Stars</option>

                                                                        <option value="3">3 Stars</option>

                                                                        <option value="2">2 Stars</option>

                                                                        <option value="1">1 Star</option>

                                                                    </select>

                                                                </div>

                                                            </div>



                                                            <div class="col-md-6">

                                                                <div class="form-group">

                                                                    <input type="file" class="form-control"

                                                                        name="images[]" multiple>

                                                                </div>

                                                            </div>



                                                            <div class="col-md-12">

                                                                <div class="form-group">

                                                                    <textarea class="form-control" name="comment" rows="5" placeholder="Your Review*" required></textarea>

                                                                </div>



                                                                <button type="submit" class="theme-btn">

                                                                    <span class="far fa-paper-plane"></span> Submit Review

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

                        </div>

                    </div>

                </div>

                <!-- shop single details end -->





                <!-- related item -->

                @if ($relatedProducts->count())

                    <div class="product-area related-item pt-40">

                        <div class="container px-0">

                            <div class="row">

                                <div class="col-12">

                                    <div class="site-heading-inline">

                                        <h2 class="site-title">Related Items</h2>

                                        <a href="{{ route('products') }}">View More <i

                                                class="fas fa-arrow-right"></i></a>

                                    </div>

                                </div>

                            </div>

                            <div class="row g-4 item-2">

                                @foreach ($relatedProducts as $related)

                                    @php

                                        $regular = $related->regular_price;

                                        $discount = $related->discount;

                                        $type = $related->discount_type;

                                        $selling = $regular;

                                        $discountLabel = '';



                                        if ($type === 'percent') {

                                            $selling = $regular - ($regular * $discount) / 100;

                                            $discountLabel = $discount . '% Off';

                                        } elseif ($type === 'flat') {

                                            $selling = $regular - $discount;

                                            $discountLabel = '₹' . number_format($discount, 2) . ' Off';

                                        }

                                    @endphp

                                    <div class="col-md-6 col-lg-3">

                                        <div class="product-item">

                                            <div class="product-img">

                                                @if ($discountLabel)

                                                    <span class="type discount">{{ $discountLabel }}</span>

                                                @elseif($related->in_stock == 0)

                                                    <span class="type oos">Out Of Stock</span>

                                                @else

                                                    <span class="type new">New</span>

                                                @endif



                                                <a href="{{ route('product', $related->slug) }}">

                                                    <img src="{{ asset(optional($related->images->first())->image ?? 'assets/img/product/default.png') }}"

                                                        alt="{{ $related->product_name }}">

                                                </a>



                                                <div class="product-action-wrap">

                                                    <div class="product-action">

                                                        <a href="#" data-bs-toggle="modal"

                                                            data-bs-target="#quickview" data-bs-placement="right"

                                                            data-tooltip="tooltip" title="Quick View"><i

                                                                class="far fa-eye"></i></a>

                                                        <a href="#" data-bs-placement="right"

                                                            data-tooltip="tooltip" title="Add To Wishlist"><i

                                                                class="far fa-heart"></i></a>

                                                        <a href="#" data-bs-placement="right"

                                                            data-tooltip="tooltip" title="Add To Compare"><i

                                                                class="far fa-arrows-repeat"></i></a>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="product-content">

                                                <h3 class="product-title">

                                                    <a href="{{ route('product', $related->slug) }}">

                                                        {{ $related->product_name }}

                                                    </a>

                                                </h3>



                                                <div class="product-rate">

                                                    @for ($i = 1; $i <= 5; $i++)

                                                        <i

                                                            class="{{ $i <= round($related->rating ?? 4) ? 'fas' : 'far' }} fa-star"></i>

                                                    @endfor

                                                </div>



                                                <div class="product-bottom">

                                                    <div class="product-price">

                                                        @if ($discount)

                                                            <del>₹{{ number_format($regular, 2) }}</del>

                                                            <span>₹{{ number_format($selling, 2) }}</span>

                                                        @else

                                                            <span>₹{{ number_format($regular, 2) }}</span>

                                                        @endif

                                                    </div>

                                                    <button type="button" class="product-cart-btn"

                                                        data-bs-placement="left" data-tooltip="tooltip"

                                                        title="Add To Cart">

                                                        <i class="far fa-shopping-bag"></i>

                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif

                <!-- related item end -->

            </div>

        </div>

        <!-- shop single end -->



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

        const modalImage = document.getElementById('modalImage');

        const prevBtn = document.getElementById('prevBtn');

        const nextBtn = document.getElementById('nextBtn');



        let currentIndex = 0;

        let images = [];



        document.querySelectorAll('.img-clickable').forEach(img => {

            img.addEventListener('click', function() {

                // Find the closest review container to get all images in the same review

                const reviewDiv = this.closest('.mb-5');

                images = Array.from(reviewDiv.querySelectorAll('.img-clickable'))

                    .map(i => i.getAttribute('data-bs-imgsrc'));

                currentIndex = images.indexOf(this.getAttribute('data-bs-imgsrc'));

                modalImage.src = images[currentIndex];

            });

        });



        prevBtn.addEventListener('click', () => {

            if (images.length === 0) return;

            currentIndex = (currentIndex - 1 + images.length) % images.length;

            modalImage.src = images[currentIndex];

        });



        nextBtn.addEventListener('click', () => {

            if (images.length === 0) return;

            currentIndex = (currentIndex + 1) % images.length;

            modalImage.src = images[currentIndex];

        });

    </script>

    <script>

        document.querySelectorAll('.read-more-link').forEach(link => {

            link.addEventListener('click', function(e) {

                e.preventDefault();

                const paragraph = this.previousElementSibling;

                paragraph.classList.toggle('clamp-2');

                this.textContent = paragraph.classList.contains('clamp-2') ? 'Read more' : 'Read less';

            });

        });

    </script>

    <script>

        $(document).ready(function() {

            $('#productReviewForm').on('submit', function(e) {

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

    @php

        $variantsData = $product->variants->map(function ($v) {

            // Calculate price based on discount type

            $regular = $v->regular_price;

            $discount = $v->discount;

            $type = $v->discount_type;

            $selling = $regular;

            $discountLabel = null;



            if ($discount > 0) {

                if ($type === 'percent') {

                    $selling = $regular - ($regular * $discount) / 100;

                    $discountLabel = $discount . '% Off';

                } elseif ($type === 'flat') {

                    $selling = $regular - $discount;

                    $discountLabel = '₹' . number_format($discount, 2) . ' Off';

                }

            }



            return [

                'id' => $v->id,

                'name' => $v->varient_name,

                'regular_price' => $regular,

                'discount' => $discount,

                'discount_type' => $type,

                'selling_price' => $selling,

                'discount_label' => $discountLabel,

                'stock' => $v->stock,

                'in_stock' => $v->in_stock,

                'product_identification_no' => $v->product_identification_no,

                'images' => $v->images->pluck('image')->toArray(),

                'attributes' => collect($v->attributeValues())

                    ->mapWithKeys(fn($av) => [$av->attribute->name ?? 'Unknown' => $av->value])

                    ->toArray(),

            ];

        });

    @endphp



    <script>

        let selectedAttributes = {};

        let variantsData = @json($variantsData);



        $(document).on('click', '.variant-btn', function() {

            let attr = $(this).data('attr');

            let value = $(this).data('value');



            // Mark selected button

            $(`.variant-btn[data-attr="${attr}"]`).removeClass('btn-primary').addClass('btn-outline-secondary');

            $(this).removeClass('btn-outline-secondary').addClass('btn-primary');



            selectedAttributes[attr] = value;



            // Find matching variant

            let matchingVariant = variantsData.find(v =>

                Object.keys(selectedAttributes).every(a => v.attributes[a] === selectedAttributes[a])

            );



            if (matchingVariant) {

                // Update variant info

                $('#selected-variant-name').text(matchingVariant.name);

                $('#selected-variant-stock').text(matchingVariant.in_stock ? 'Available' : 'Out Of Stock');

                $('#selected-variant-pid').text(matchingVariant.product_identification_no);



                // Update images

                updateVariantImages(matchingVariant.images, matchingVariant.name);



                // Update price HTML

                let regular = Number(matchingVariant.regular_price);

                let selling = Number(matchingVariant.selling_price);

                let discountLabel = matchingVariant.discount_label;



                let priceHtml = '';

                if (Number(matchingVariant.discount) > 0) {

                    priceHtml = `<del>₹${regular.toFixed(2)}</del>

                 <span class="amount text-primary">₹${selling.toFixed(2)}</span>

                 <span class="discount-percentage text-success border badge">${discountLabel}</span>`;

                } else {

                    priceHtml = `<span class="amount">₹${regular.toFixed(2)}</span>`;

                }

                $('#selected-variant-price').html(priceHtml);

            }

        });



        function updateVariantImages(images, variantName) {

            let slidesHtml = '';



            images.forEach(img => {

                let imgUrl = "{{ asset('') }}" + img;

                slidesHtml += `

                <li class="splide__slide product-image">

                    <img src="${imgUrl}" alt="${variantName}">

                </li>`;

            });



            // Replace slides in both sliders

            $('#primary_slides').html(slidesHtml);

            $('#thumbnail_slides').html(slidesHtml);



            // Destroy old sliders





            // Re-initialize sliders

            initializeSliders();

        }



        function initializeSliders() {

            if (primarySlider) primarySlider.destroy();

            if (thumbnailSlider) thumbnailSlider.destroy();

            // Primary slider.

            var primarySlider = new Splide('#primary_slider', {

                ttype: 'fade', // Smooth fade transition

                heightRatio: 0.65, // Adjusts height relative to width (0.65 works for most product images)

                pagination: false, // Hide dots

                arrows: true, // Enable navigation arrows

                cover: false, // Scale images to cover the slide

                rewind: true, // Loop back after last image

                speed: 800, // Smooth transition speed (in ms)

                autoplay: false, // Optional – auto slide

                interval: 4000, // 4s per slide

                pauseOnHover: true, // Pause on hover

                lazyLoad: 'nearby',

            });



            // Thumbnails slider.

            var thumbnailSlider = new Splide('#thumbnail_slider', {

                rewind: true,

                fixedWidth: 100,

                fixedHeight: 64,

                isNavigation: true,

                arrows: false,

                gap: 10,

                focus: 'center',

                pagination: false,

                cover: false,

                breakpoints: {

                    '600': {

                        fixedWidth: 66,

                        fixedHeight: 40,

                    }

                }

            }).mount();

            // sync the thumbnails slider as a target of primary slider.

            primarySlider.sync(thumbnailSlider).mount();

        }



        document.addEventListener('DOMContentLoaded', initializeSliders);

    </script>

@endsection

