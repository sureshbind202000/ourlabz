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
#lcl_author, #lcl_txt
 {
  display: none !important;
}
</style>
@endsection
@section('content')

<main class="main">

    <!-- breadcrumb -->
    <!-- <div class="site-breadcrumb">
        <div class="site-breadcrumb-bg" style="background: url(assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
            <div class="site-breadcrumb-wrap">
                <h4 class="breadcrumb-title">Shop Single</h4>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html"><i class="far fa-home"></i> Home</a></li>
                    <li class="active">Shop Single</li>
                </ul>
            </div>
        </div>
    </div> -->
    <!-- breadcrumb end -->


    <!-- shop single -->
    <div class="shop-single py-90">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-lg-6 col-xxl-5">
                    <div class="shop-single-gallery">
                        <a class="shop-single-video popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU"
                            data-tooltip="tooltip" title="Watch Video">
                            <i class="far fa-play"></i>
                        </a>
                        <div class="flexslider-thumbnails">
                            <ul class="slides">
                                <li data-thumb="assets/img/product/01.png" rel="adjustX:10, adjustY:">
                                    <img src="assets/img/product/01.png" alt="#">
                                </li>
                                <li data-thumb="assets/img/product/02.png">
                                    <img src="assets/img/product/02.png" alt="#">
                                </li>
                                <li data-thumb="assets/img/product/03.png">
                                    <img src="assets/img/product/03.png" alt="#">
                                </li>
                                <li data-thumb="assets/img/product/04.png">
                                    <img src="assets/img/product/04.png" alt="#">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xxl-6">
                    <div class="shop-single-info">
                        <h4 class="shop-single-title">Surgical Face Mask</h4>
                        <div class="shop-single-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span class="rating-count"> (4 Customer Reviews)</span>
                        </div>
                        <div class="shop-single-price">
                            <del>$690</del>
                            <span class="amount">$650</span>
                            <span class="discount-percentage">30% Off</span>
                        </div>
                        <p class="mb-3">
                            There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form, by injected humour, or randomised words which don't
                            look even slightly believable.
                        </p>
                        <div class="shop-single-cs">
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
                                <div class="col-md-3 col-lg-4 col-xl-3">
                                    <div class="shop-single-size">
                                        <h6>Size</h6>
                                        <select class="select">
                                            <option value="">Choose Size</option>
                                            <option value="1">Extra Small</option>
                                            <option value="2">Small</option>
                                            <option value="3">Medium</option>
                                            <option value="4">Extra Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="shop-single-color">
                                        <h6>Color</h6>
                                        <ul class="shop-checkbox-list color">
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="color1">
                                                    <label class="form-check-label" for="color1"><span
                                                            style="background-color: #606ddd"></span></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="color2">
                                                    <label class="form-check-label" for="color2"><span
                                                            style="background-color: #4caf50"></span></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="color3">
                                                    <label class="form-check-label" for="color3"><span
                                                            style="background-color: #17a2b8"></span></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="color4">
                                                    <label class="form-check-label" for="color4"><span
                                                            style="background-color: #ffc107"></span></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="color5">
                                                    <label class="form-check-label" for="color5"><span
                                                            style="background-color: #f44336"></span></label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop-single-sortinfo">
                            <ul>
                                <li>Stock: <span>Available</span></li>
                                <li>SKU: <span>656TYTR</span></li>
                                <li>Category: <span>Medicine</span></li>
                                <li>Brand: <a href="#">Novak</a></li>
                                <li>Tags: <a href="#">Medicine</a>,<a href="#">Healthcare</a>,<a href="#">Modern</a>,<a
                                        href="#">Shop</a></li>
                            </ul>
                        </div>
                        <div class="shop-single-action">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="shop-single-btn">
                                        <a href="#" class="theme-btn"><span class="far fa-shopping-bag"></span>Add To
                                            Cart</a>
                                        <a href="#" class="theme-btn theme-btn2" data-tooltip="tooltip"
                                            title="Add To Wishlist"><span class="far fa-heart"></span></a>
                                        <a href="#" class="theme-btn theme-btn2" data-tooltip="tooltip"
                                            title="Add To Compare"><span class="far fa-arrows-repeat"></span></a>
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
                            type="button" role="tab" aria-controls="tab1" aria-selected="true">Description</button>
                        <button class="nav-link" id="nav-tab2" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
                            role="tab" aria-controls="tab2" aria-selected="false">Additional
                            Info</button>
                        <button class="nav-link" id="nav-tab3" data-bs-toggle="tab" data-bs-target="#tab3" type="button"
                            role="tab" aria-controls="tab3" aria-selected="false">Reviews
                            (05)</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="nav-tab1">
                        <div class="shop-single-desc">
                            <p>
                                There are many variations of passages of Lorem Ipsum available, but the majority
                                have suffered alteration in some form, by injected humour, or randomised words which
                                don't look even slightly believable. If you are going to use a passage of Lorem
                                Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of
                                text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                                chunks as necessary, making this the first true generator on the Internet.
                            </p>
                            <p>
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                                doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                                veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                                voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                                magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est,
                                qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.
                            </p>
                            <div class="row">
                                <div class="col-lg-5 col-xl-4">
                                    <div class="shop-single-list">
                                        <h5 class="title">Features</h5>
                                        <ul>
                                            <li>Modern Art Deco Chaise Lounge</li>
                                            <li>Unique cylindrical design copper finish</li>
                                            <li>Covered in grey velvet fabric</li>
                                            <li>Modern Bookcase in Copper Colored Finish</li>
                                            <li>Use of Modern Materials</li>
                                            <li>Mirrored compartments and upgraded interior</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-5">
                                    <div class="shop-single-list">
                                        <h5 class="title">Specifications</h5>
                                        <ul>
                                            <li><span>Dimensions:</span> 4ft W x 7ft h</li>
                                            <li><span>Model Year:</span> 2024</li>
                                            <li><span>Available Sizes:</span> 8.5, 9.0, 9.5, 10.0</li>
                                            <li><span>Manufacturer:</span> Reebok Inc.</li>
                                            <li><span>Available Colors:</span> White/Red/Blue,Black/Orange/Green</li>
                                            <li><span>Made In:</span> USA</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="nav-tab2">
                        <div class="shop-single-additional">
                            <p>
                                There are many variations of passages of Lorem Ipsum available, but the majority
                                have suffered alteration in some form, by injected humour, or randomised words which
                                don't look even slightly believable. If you are going to use a passage of Lorem
                                Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of
                                text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                                chunks as necessary, making this the first true generator on the Internet.
                            </p>
                            <p>
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                                doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                                veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                                voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                                magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est,
                                qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.
                            </p>
                            <div class="shop-single-list">
                                <h5 class="title">Shipping Options:</h5>
                                <ul>
                                    <li><span>Standard:</span> 6-7 Days, Shipping Cost - Free</li>
                                    <li><span>Express:</span> 1-2 Days, Shipping Cost - $20</li>
                                    <li><span>Courier:</span> 2-3 Days, Shipping Cost - $30</li>
                                    <li><span>Fastgo:</span> 1-3 Days, Shipping Cost - $15</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="nav-tab3">
                        <div class="shop-single-review">
                            <div class="blog-comments">
                                <div class="container">
                                    <h3 class="mb-4">User Reviews</h3>
                                    <div class="row py-4">
                                        <!-- Left Column: Reviews -->
                                        <div class="col-md-7">
                                            <!-- Review 1 -->
                                           <div class="mb-5 border-bottom">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img src="https://i.pravatar.cc/40?img=1" alt="Alexander Rity"
                                                        class="review-avatar me-3">
                                                    <div>
                                                        <strong>Alexander Rity</strong><br>
                                                        <small class="text-muted">4 months ago</small>
                                                    </div>
                                                    <div class="ms-auto text-purple">
                                                        <strong>5.0</strong> <span class="star-rating">★★★★☆</span>
                                                    </div>
                                                </div>
                                                <p class="review-text clamp-2">
                                                    Easy booking, great value! Cozy rooms at a reasonable price in
                                                    Sheffield's vibrant center. Surprisingly quiet with nearby
                                                    Traveller’s accommodations. Highly recommended!Easy booking, great value! Cozy rooms at a reasonable price in
                                                    Sheffield's vibrant center. Surprisingly quiet with nearby
                                                    Traveller’s accommodations. Highly recommended!
                                                </p>
                                                <a href="#" class="read-more-link text-primary small">Read more</a>
                                                <div class="row g-2 py-2">
                                                    <div class="col-sm-12 d-flex gap-2">
                                                        <a href="assets/img/product/01.png"
                                                            class="lightbox"
                                                            data-lcl-thumb="assets/img/product/01.png"
                                                            data-lcl-title="Mountains" data-lcl-author="Picsum">
                                                            <img src="assets/img/product/01.png"
                                                                alt="Montañas" class="gallery-img img-fluid" style="height: 70px;">
                                                        </a>
                                                        <a href="assets/img/product/01.png"
                                                            class="lightbox"
                                                            data-lcl-thumb="assets/img/product/01.png"
                                                            data-lcl-title="Mountains" data-lcl-author="Picsum">
                                                            <img src="assets/img/product/01.png"
                                                                alt="Montañas" class="gallery-img img-fluid" style="height: 70px;">
                                                        </a>
                                                        <a href="assets/img/product/01.png"
                                                            class="lightbox"
                                                            data-lcl-thumb="assets/img/product/01.png"
                                                            data-lcl-title="Mountains" data-lcl-author="Picsum">
                                                            <img src="assets/img/product/01.png"
                                                                alt="Montañas" class="gallery-img img-fluid" style="height: 70px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Review 2 -->
                                            <div class="mb-5 border-bottom">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img src="https://i.pravatar.cc/40?img=2" alt="Alexander Rity"
                                                        class="review-avatar me-3">
                                                    <div>
                                                        <strong>Alexander Rity</strong><br>
                                                        <small class="text-muted">4 months ago</small>
                                                    </div>
                                                    <div class="ms-auto text-purple">
                                                        <strong>5.0</strong> <span class="star-rating">★★★★☆</span>
                                                    </div>
                                                </div>
                                                <p class="review-text clamp-2">
                                                    Easy booking, great value! Cozy rooms at a reasonable price in
                                                    Sheffield's vibrant center. Surprisingly quiet with nearby
                                                    Traveller’s accommodations. Highly recommended!Easy booking, great value! Cozy rooms at a reasonable price in
                                                    Sheffield's vibrant center. Surprisingly quiet with nearby
                                                    Traveller’s accommodations. Highly recommended!
                                                </p>
                                                <a href="#" class="read-more-link text-primary small">Read more</a>
                                                <div class="row g-2 py-2">
                                                    <div class="col-sm-12 d-flex gap-2">
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                        <img src="assets/img/product/02.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/02.png" />
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-5 border-bottom">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img src="https://i.pravatar.cc/40?img=1" alt="Alexander Rity"
                                                        class="review-avatar me-3">
                                                    <div>
                                                        <strong>Alexander Rity</strong><br>
                                                        <small class="text-muted">4 months ago</small>
                                                    </div>
                                                    <div class="ms-auto text-purple">
                                                        <strong>5.0</strong> <span class="star-rating">★★★★☆</span>
                                                    </div>
                                                </div>
                                                <p class="review-text clamp-2">
                                                    Easy booking, great value! Cozy rooms at a reasonable price in
                                                    Sheffield's vibrant center. Surprisingly quiet with nearby
                                                    Traveller’s accommodations. Highly recommended!Easy booking, great value! Cozy rooms at a reasonable price in
                                                    Sheffield's vibrant center. Surprisingly quiet with nearby
                                                    Traveller’s accommodations. Highly recommended!
                                                </p>
                                                <a href="#" class="read-more-link text-primary small">Read more</a>
                                                <div class="row g-2 py-2">
                                                    <div class="col-sm-12 d-flex gap-2">
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                        <img src="assets/img/product/02.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/02.png" />
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                        <img src="assets/img/product/01.png"
                                                            class="img-fluid border  img-clickable"
                                                            style="height: 70px;" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-bs-imgsrc="assets/img/product/01.png" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column: Review Form -->
                                        <div class="col-md-5">
                                            <div class="blog-comments-form mt-0">
                                                <h4 class="mb-4">Leave A Review</h4>
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Your Name*">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="email" class="form-control"
                                                                    placeholder="Your Email*">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Your Subject*">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="form-control form-select">
                                                                    <option value="">Your Rating</option>
                                                                    <option value="5">5 Stars</option>
                                                                    <option value="4">4 Stars</option>
                                                                    <option value="3">3 Stars</option>
                                                                    <option value="2">2 Stars</option>
                                                                    <option value="1">1 Star</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="file" class="form-control"
                                                                    placeholder="Your Subject*">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5"
                                                                    placeholder="Your Review*"></textarea>
                                                            </div>
                                                            <button type="submit" class="theme-btn"><span
                                                                    class="far fa-paper-plane"></span> Submit
                                                                Review</button>
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
            <div class="product-area related-item pt-40">
                <div class="container px-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="site-heading-inline">
                                <h2 class="site-title">Related Items</h2>
                                <a href="#">View More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 item-2">
                        <div class="col-md-6 col-lg-3">
                            <div class="product-item">
                                <div class="product-img">
                                    <span class="type new">New</span>
                                    <a href="shop-single.html"><img src="assets/img/product/07.png" alt=""></a>
                                    <div class="product-action-wrap">
                                        <div class="product-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i
                                                    class="far fa-eye"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-bottom">
                                        <div class="product-price">
                                            <span>$100.00</span>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left"
                                            data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="product-item">
                                <div class="product-img">
                                    <span class="type hot">Hot</span>
                                    <a href="shop-single.html"><img src="assets/img/product/08.png" alt=""></a>
                                    <div class="product-action-wrap">
                                        <div class="product-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i
                                                    class="far fa-eye"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-bottom">
                                        <div class="product-price">
                                            <span>$100.00</span>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left"
                                            data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="product-item">
                                <div class="product-img">
                                    <span class="type oos">Out Of Stock</span>
                                    <a href="shop-single.html"><img src="assets/img/product/12.png" alt=""></a>
                                    <div class="product-action-wrap">
                                        <div class="product-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i
                                                    class="far fa-eye"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-bottom">
                                        <div class="product-price">
                                            <span>$100.00</span>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left"
                                            data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="product-item">
                                <div class="product-img">
                                    <span class="type discount">10% Off</span>
                                    <a href="shop-single.html"><img src="assets/img/product/14.png" alt=""></a>
                                    <div class="product-action-wrap">
                                        <div class="product-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i
                                                    class="far fa-eye"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                            <a href="#" data-bs-placement="right" data-tooltip="tooltip"
                                                title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-bottom">
                                        <div class="product-price">
                                            <del>$120.00</del>
                                            <span>$100.00</span>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left"
                                            data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        img.addEventListener('click', function () {
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
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const paragraph = this.previousElementSibling;
      paragraph.classList.toggle('clamp-2');
      this.textContent = paragraph.classList.contains('clamp-2') ? 'Read more' : 'Read less';
    });
  });
</script>
@endsection