@extends('frontend.includes.layout')

@section('css')
<style>
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
@endsection
@section('content')

<main class="main bg">

    <div class="container py-4">

        <img src="{{asset('assets/img/banner/doc-banner-desktop.png')}}" alt="">

    </div>

    <div class="shop-area">

        <div class="container">

            <div class="row">

                {{-- Filters --}}

                <div class="col-lg-3 " id="mainFilter">

                    @include('frontend.includes.filters', ['types' => $types, 'categories' => $categories])

                </div>

                {{-- Packages --}}

                <div class="col-lg-9 ">

                    <div class="col-md-12">

                        <div class="shop-sort d-block d-md-flex">

                            <div class="shop-search-form">

                                <form action="#">

                                    <div class="form-group">

                                        <input type="text" id="search" placeholder="Search..." class="form-control rounded-2 py-2">

                                        <button type="search"><i class="far fa-search"></i></button>

                                    </div>

                                </form>

                            </div>

                           <div class=" mt-2 mt-md-0 row">
                             <div class="col-6 col-lg-12">
                                <select id="sort_by" class="form-select w-100" >

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
                        
                           </div>

                        </div>

                    </div>
                   

                    <div id="package-list" class="pb-3">

                        @include('frontend.includes.package_list', ['packages' => $packages])

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>


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

        // Initialize slider

        if ($(".price-range").length) {

            $(".price-range").slider({

                range: true,

                min: 0,

                max: 10000,

                values: [0, 5000],

                slide: function(event, ui) {

                    $("#price-amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);

                    $("#min_price").val(ui.values[0]);

                    $("#max_price").val(ui.values[1]);

                },

                change: function() {

                    fetchData(); // Trigger AJAX on change

                }

            });



            $("#price-amount").val("₹" + $(".price-range").slider("values", 0) + " - ₹" + $(".price-range").slider("values", 1));

            $("#min_price").val($(".price-range").slider("values", 0));

            $("#max_price").val($(".price-range").slider("values", 1));

        }



        // AJAX filter

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

                    $('#package-list').html(response);

                },

                error: function(xhr) {

                    console.log(xhr);

                }

            });

        }



        $(document).on('change keyup', '#search, #sort_by, input[name="type[]"], input[name="category[]"], input[name="rating[]"]', function() {

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