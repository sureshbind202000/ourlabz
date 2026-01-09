@extends('frontend.includes.layout')

@section('css')

@endsection

<style>
    .big-banner {

        height: 300px;

    }



    .big-banner .wow .hero-slider .hero-single {

        height: 300px;

        width: 100%;

    }



    .big-banner .wow .hero-slider .hero-single img {

        object-fit: cover;

    }



    .product-action-wrap .product-action a i {

        line-height: 40px;

    }



    .owl-stage-outer {

        border-radius: 30px;

    }
    .shop-search-form button {
    padding: 13px 18px !important;
}
.product-content {
    margin-top: 15px !important;
}
 @media (max-width: 425px) {
        .product-price {
            width: min-content;
        }

        .product-item .type {
            padding: 1px 10px;
        }

        .item-tab .nav-link {
            font-size: small;
        }

        .card h6.small {
            font-size: 12px !important;

        }

        .card p.small {
            font-size: 11px !important;

        }
    }
</style>

@section('content')

<main class="main bg">

    <!-- big banner -->



    <div class="container p-0 overflow-hidden  py-4 rounded-4 overflow-hidden">

        <div class="big-banner">

            <div class="  wow fadeInUp p-0" data-wow-delay=".25s">

                <div class="hero-slider owl-carousel owl-theme rounded-4">

                    <div class="hero-single rounded-4">

                        <img src="assets/img/banner/big-banner.jpg" alt="">

                    </div>

                    <div class="hero-single rounded-4">

                        <img src="assets/img/banner/big-banner.jpg" alt="">

                    </div>

                    <div class="hero-single rounded-4">

                        <img src="assets/img/banner/big-banner.jpg" alt="">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- big banner end -->

    <!-- shop-area -->

    <div class="shop-area bg">

        <div class="container">

            <div class="row">

                <div class="col-lg-3" id="mainFilter">

                    @include('frontend.shop.filters')

                </div>

                <div class="col-lg-9">

                    <div class="col-md-12">

                        <div class="shop-sort d-block d-md-flex">

                            <div class="shop-search-form">

                                <form action="#" class="m-0">

                                    <div class="form-group">

                                        <input type="text" id="search" placeholder="Search..."

                                            class="form-control rounded-2 py-2">

                                        <button type="search"><i class="far fa-search"></i></button>

                                    </div>

                                </form>

                            </div>


                            <div class=" mt-2 mt-md-0 row">
                                <div class="col-6 col-lg-12">
                                    <select id="sort_by" class="form-select w-100">

                                        <option value="">Sort By</option>

                                        <option value="latest">Latest</option>

                                        <option value="price_low_high">Price Low to High</option>

                                        <option value="price_high_low">Price High to Low</option>

                                    </select>
                                </div>
                                <div class="col-6">
                                    <a class="btn  bg-white border d-lg-none w-100" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                        <i class="fa-solid fa-filter"></i> Filter
                                    </a>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="shop-item-wrap item-4" id="product-list">

                            @include('frontend.shop.product_list', ['products' => $products])

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- shop-area end -->



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
<!-- filter start -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="filteroffcanvas">

    </div>
</div>
<!-- filter end -->
@endsection



@section('js')

<script>
    function moveFilterToOffcanvas() {

        const mainFilter = document.getElementById("mainFilter");
        const filterOffcanvas = document.getElementById("filteroffcanvas");

        if (!mainFilter || !filterOffcanvas) return;

        // if small screen → move inside offcanvas
        if (window.innerWidth <= 992) {
            if (mainFilter.children.length > 0) {
                filterOffcanvas.append(...mainFilter.childNodes); // CUT + PASTE
            }
        }
        // if large screen → move back to mainFilter
        else {
            if (filterOffcanvas.children.length > 0) {
                mainFilter.append(...filterOffcanvas.childNodes); // REVERT
            }
        }
    }

    // call on load + on resize
    window.addEventListener("load", moveFilterToOffcanvas);
    window.addEventListener("resize", moveFilterToOffcanvas);
</script>
<script>
    $(document).ready(function() {

        if ($(".price-range").length) {

            $(".price-range").slider({

                range: true,

                min: 0,

                max: 100000,

                values: [$("#min_price").val(), $("#max_price").val()],

                slide: function(event, ui) {

                    $("#price-amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);

                    $("#min_price").val(ui.values[0]);

                    $("#max_price").val(ui.values[1]);

                },

                change: function() {

                    fetchData();

                }

            });



            $("#price-amount").val("₹" + $(".price-range").slider("values", 0) + " - ₹" + $(".price-range")

                .slider("values", 1));

        }



        function fetchData(page = 1) {

            let data = {

                search: $('#search').val(),

                sort_by: $('#sort_by').val(),

                type: $('input[name="type[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                category: $('input[name="category[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                subcategory: $('input[name="subcategory[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                rating: $('input[name="rating[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                min_price: $('#min_price').val(),

                max_price: $('#max_price').val(),

                page: page

            };



            $.ajax({

                url: `?page=${page}`,

                method: 'GET',

                data: data,

                success: function(response) {

                    $('#product-list').html(response);

                },

                error: function(xhr) {

                    console.log(xhr);

                }

            });

        }



        $(document).on('change keyup',

            '#search, #sort_by, input[name="type[]"], input[name="category[]"], input[name="subcategory[]"], input[name="rating[]"]',

            function() {

                fetchData();

            });



        $(document).on('click', '.pagination a', function(e) {

            e.preventDefault();

            let page = $(this).attr('href').split('page=')[1];

            fetchData(page);

        });

    });
</script>

@endsection