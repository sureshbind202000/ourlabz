@extends('frontend.includes.layout')
@section('css')

@endsection

@section('content')

<main class="main bg">
    <div class="container py-4">
        <img src="{{asset('assets/img/banner/doc-banner-desktop.png')}}" alt="">
    </div>
    <!-- shop-area -->
    <div class="shop-area ">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop-sidebar bg-white rounded-4">
                        <div class="shop-widget">
                            <div class="shop-search-form">
                                <h4 class="shop-widget-title">Search</h4>
                                <form action="#">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <button type="search"><i class="far fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="shop-widget">
                            <h4 class="shop-widget-title">Category</h4>
                            <ul class="shop-category-list">
                                <li><a href="#">Test <span>(15)</span></a></li>
                                <li><a href="#">Package<span>(23)</span></a></li>
                                <li><a href="#">Corporate<span>(35)</span></a></li>
                            </ul>
                        </div>
                        <div class="shop-widget">
                            <h4 class="shop-widget-title">Category</h4>
                            <ul class="shop-category-list">
                                <li><a href="#">Medicine<span>(15)</span></a></li>
                                <li><a href="#">Healthcare<span>(23)</span></a></li>
                                <li><a href="#">Beauty Care<span>(35)</span></a></li>
                                <li><a href="#">Sexual Wellness<span>(46)</span></a></li>
                                <li><a href="#">Fitness<span>(39)</span></a></li>
                                <li><a href="#">Lab Test<span>(79)</span></a></li>
                                <li><a href="#">Baby & Mom Care<span>(28)</span></a></li>
                                <li><a href="#">Supplement<span>(17)</span></a></li>
                                <li><a href="#">Food & Nutrition<span>(12)</span></a></li>
                                <li><a href="#">Equipments<span>(74)</span></a></li>
                                <li><a href="#">Medical Supplies<span>(38)</span></a></li>
                                <li><a href="#">Pet Care<span>(22)</span></a></li>
                                <li><a href="#">Others<span>(25)</span></a></li>
                            </ul>
                        </div>
                        <div class="shop-widget">
                            <h4 class="shop-widget-title">Brands</h4>
                            <ul class="shop-checkbox-list">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand1">
                                        <label class="form-check-label" for="brand1">Tovol<span>(12)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand2">
                                        <label class="form-check-label" for="brand2">Sundoy<span>(15)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand3">
                                        <label class="form-check-label" for="brand3">Sahoo Medoc<span>(20)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand4">
                                        <label class="form-check-label" for="brand4">Casterly<span>(05)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand5">
                                        <label class="form-check-label" for="brand5">Maindeno<span>(09)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand6">
                                        <label class="form-check-label" for="brand6">Knroll Seproll<span>(25)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand7">
                                        <label class="form-check-label" for="brand7">Neo Enternity<span>(19)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand8">
                                        <label class="form-check-label" for="brand8">Charisha<span>(23)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand9">
                                        <label class="form-check-label" for="brand9">Audou<span>(13)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand10">
                                        <label class="form-check-label" for="brand10">Desioreck<span>(14)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand11">
                                        <label class="form-check-label" for="brand11">Rochel Brek<span>(16)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand12">
                                        <label class="form-check-label" for="brand12">Mordani<span>(17)</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="brand13">
                                        <label class="form-check-label" for="brand13">Others<span>(18)</span></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="shop-widget">
                            <h4 class="shop-widget-title">Price Range</h4>
                            <div class="price-range-box">
                                <div class="price-range-input">
                                    <input type="text" id="price-amount" readonly>
                                </div>
                                <div class="price-range"></div>
                            </div>
                        </div>
                        <div class="shop-widget">
                            <h4 class="shop-widget-title">Ratings</h4>
                            <ul class="shop-checkbox-list rating">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rate1">
                                        <label class="form-check-label" for="rate1">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rate2">
                                        <label class="form-check-label" for="rate2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rate3">
                                        <label class="form-check-label" for="rate3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rate4">
                                        <label class="form-check-label" for="rate4">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rate5">
                                        <label class="form-check-label" for="rate5">
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="col-md-12">
                        <div class="shop-sort">
                            <div class="shop-sort-box">
                                
                            </div>
                                <select class="select">
                                    <option value="1">Default Sorting</option>
                                    <option value="5">Latest Items</option>
                                    <option value="2">Best Seller Items</option>
                                    <option value="3">Price - Low To High</option>
                                    <option value="4">Price - High To Low</option>
                                </select>
                        </div>
                    </div>
                    <div class="shop-item-wrap item-4">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <div class="col">
                                <div class="card h-100 p-3 border">
                                    <div class="card-body p-0 mb-4">
                                        <div class="d-flex gap-2">
                                            <div class="border p-1 rounded-2 test-image">
                                                <img src="assets/img/test/kidneys.png" alt="">
                                            </div>
                                            <div>
                                                <h6 class=" my-2 fw-bold ">
                                                    <a href="">Kidney Check Basic</a>
                                                </h6>
                                                <div class=" d-flex gap-3 mt-2">
                                                    <div>
                                                        <h6 class="small text-muted">Parameters</h6>
                                                        <p class="text-muted small">91 Test</p>
                                                    </div>
                                                    <div>
                                                        <h6 class="small text-muted">Reports With in</h6>
                                                        <p class="text-muted small">8 Hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 price">
                                        <div>
                                            <span class="pe-2 text-dark fw-bold">₹40.00</span>
                                            <del class="text-muted small px-0">₹60.00</del>
                                            <span class="text-danger small px-0">30% Off</span>
                                        </div>
                                        <a href="#" type="button" class="btn btn-primary px-4">Add </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 p-3 border">
                                    <div class="card-body p-0 mb-4">
                                        <div class="d-flex gap-2">
                                            <div class="border p-1 rounded-2 test-image">
                                                <img src="assets/img/test/Thyroid.jpg" alt="">
                                            </div>
                                            <div>
                                                <h6 class=" my-2 fw-bold ">
                                                    <a href="">Thyroid Profile (T3 T4
                                                        TSH) Test</a>
                                                </h6>
                                                <div class=" d-flex gap-3 mt-2">
                                                    <div>
                                                        <h6 class="small text-muted">Parameters</h6>
                                                        <p class="text-muted small">91 Test</p>
                                                    </div>
                                                    <div>
                                                        <h6 class="small text-muted">Reports With in</h6>
                                                        <p class="text-muted small">8 Hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 price">
                                        <div>
                                            <span class="pe-2 text-dark fw-bold">₹40.00</span>
                                            <del class="text-muted small px-0">₹60.00</del>
                                            <span class="text-danger small px-0">30% Off</span>
                                        </div>
                                        <a href="#" type="button" class="btn btn-primary px-4">Add </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 p-3 border">
                                    <div class="card-body p-0 mb-4">
                                        <div class="d-flex gap-2">
                                            <div class="border p-1 rounded-2 test-image">
                                                <img src="assets/img/test/Diabetes.jpg" alt="">
                                            </div>
                                            <div>
                                                <h6 class=" my-2 fw-bold ">
                                                    <a href="">Diabetes Panel - Essential</a>
                                                </h6>
                                                <div class=" d-flex gap-3 mt-2">
                                                    <div>
                                                        <h6 class="small text-muted">Parameters</h6>
                                                        <p class="text-muted small">91 Test</p>
                                                    </div>
                                                    <div>
                                                        <h6 class="small text-muted">Reports With in</h6>
                                                        <p class="text-muted small">8 Hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 price">
                                        <div>
                                            <span class="pe-2 text-dark fw-bold">₹40.00</span>
                                            <del class="text-muted small px-0">₹60.00</del>
                                            <span class="text-danger small px-0">30% Off</span>
                                        </div>
                                        <a href="#" type="button" class="btn btn-primary px-4">Add </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 p-3 border">
                                    <div class="card-body p-0 mb-4">
                                        <div class="d-flex gap-2">
                                            <div class="border p-1 rounded-2 test-image">
                                                <img src="assets/img/test/kidneys.png" alt="">
                                            </div>
                                            <div>
                                                <h6 class=" my-2 fw-bold ">
                                                    <a href="">Kidney Check Basic</a>
                                                </h6>
                                                <div class=" d-flex gap-3 mt-2">
                                                    <div>
                                                        <h6 class="small text-muted">Parameters</h6>
                                                        <p class="text-muted small">91 Test</p>
                                                    </div>
                                                    <div>
                                                        <h6 class="small text-muted">Reports With in</h6>
                                                        <p class="text-muted small">8 Hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 price">
                                        <div>
                                            <span class="pe-2 text-dark fw-bold">₹40.00</span>
                                            <del class="text-muted small px-0">₹60.00</del>
                                            <span class="text-danger small px-0">30% Off</span>
                                        </div>
                                        <a href="#" type="button" class="btn btn-primary px-4">Add </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 p-3 border">
                                    <div class="card-body p-0 mb-4">
                                        <div class="d-flex gap-2">
                                            <div class="border p-1 rounded-2 test-image">
                                                <img src="assets/img/test/kidneys.png" alt="">
                                            </div>
                                            <div>
                                                <h6 class=" my-2 fw-bold ">
                                                    <a href="">Kidney Check Basic</a>
                                                </h6>
                                                <div class=" d-flex gap-3 mt-2">
                                                    <div>
                                                        <h6 class="small text-muted">Parameters</h6>
                                                        <p class="text-muted small">91 Test</p>
                                                    </div>
                                                    <div>
                                                        <h6 class="small text-muted">Reports With in</h6>
                                                        <p class="text-muted small">8 Hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 price">
                                        <div>
                                            <span class="pe-2 text-dark fw-bold">₹40.00</span>
                                            <del class="text-muted small px-0">₹60.00</del>
                                            <span class="text-danger small px-0">30% Off</span>
                                        </div>
                                        <a href="#" type="button" class="btn btn-primary px-4">Add </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 p-3 border">
                                    <div class="card-body p-0 mb-4">
                                        <div class="d-flex gap-2">
                                            <div class="border p-1 rounded-2 test-image">
                                                <img src="assets/img/test/kidneys.png" alt="">
                                            </div>
                                            <div>
                                                <h6 class=" my-2 fw-bold ">
                                                    <a href="">Kidney Check Basic</a>
                                                </h6>
                                                <div class=" d-flex gap-3 mt-2">
                                                    <div>
                                                        <h6 class="small text-muted">Parameters</h6>
                                                        <p class="text-muted small">91 Test</p>
                                                    </div>
                                                    <div>
                                                        <h6 class="small text-muted">Reports With in</h6>
                                                        <p class="text-muted small">8 Hours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 price">
                                        <div>
                                            <span class="pe-2 text-dark fw-bold">₹40.00</span>
                                            <del class="text-muted small px-0">₹60.00</del>
                                            <span class="text-danger small px-0">30% Off</span>
                                        </div>
                                        <a href="#" type="button" class="btn btn-primary px-4">Add </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- pagination -->
                    <div class="pagination-area mt-50">
                        <div aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item"><a class="page-link" href="#">10</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="far fa-arrow-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- pagination end -->
                </div>
            </div>
        </div>
    </div>
    <!-- shop-area end -->

</main>
@endsection

@section('js')

@endsection