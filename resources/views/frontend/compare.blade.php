@extends('frontend.includes.layout')
@section('css')

@endsection

@section('content')

 <main class="main">
        <!-- compare area -->
        <div class="compare-area py-90">
            <div class="container">
                 <div class="row">
                <div class="col-lg-6 ">
                    <div class="site-heading">
                        <h2 class="site-title">Product <span>Compare</span></h2>
                    </div>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered compare-table">
                        <tbody>
                            <tr>
                                <th></th>
                                <td>
                                    <div class="compare-img">
                                        <img src="assets/img/product/01.png" alt="product">
                                        <a href="#" class="compare-remove"><i class="far fa-xmark"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="compare-img">
                                        <img src="assets/img/product/02.png" alt="product">
                                        <a href="#" class="compare-remove"><i class="far fa-xmark"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="compare-img">
                                        <img src="assets/img/product/03.png" alt="product">
                                        <a href="#" class="compare-remove"><i class="far fa-xmark"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td><a href="#" class="compare-title">Surgical Face Mask</a></td>
                                <td><a href="#" class="compare-title">Surgical Face Mask</a></td>
                                <td><a href="#" class="compare-title">Surgical Face Mask</a></td>
                            </tr>
                            <tr>
                                <th>Product Color</th>
                                <td><span>Black</span></td>
                                <td><span>Red</span></td>
                                <td><span>Blue</span></td>
                            </tr>
                            <tr>
                                <th>Imported</th>
                                <td><span>Yes</span></td>
                                <td><span>No</span></td>
                                <td><span>Yes</span></td>
                            </tr>
                            <tr>
                                <th>Outdoor</th>
                                <td><span>Yes</span></td>
                                <td><span>Yes</span></td>
                                <td><span>No</span></td>
                            </tr>
                            <tr>
                                <th>Indoor</th>
                                <td><span>Yes</span></td>
                                <td><span>No</span></td>
                                <td><span>Yes</span></td>
                            </tr>
                            <tr>
                                <th>Thickness</th>
                                <td><span>6.7mm</span></td>
                                <td><span>6.9mm</span></td>
                                <td><span>6.7mm</span></td>
                            </tr>
                            <tr>
                                <th>Quality</th>
                                <td><span>High</span></td>
                                <td><span>High</span></td>
                                <td><span>High</span></td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td><span>10kg</span></td>
                                <td><span>10kg</span></td>
                                <td><span>10kg</span></td>
                            </tr>
                            <tr>
                                <th>Made With</th>
                                <td><span>Natural Components</span></td>
                                <td><span>Natural Components</span></td>
                                <td><span>Natural Components</span></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td><span class="compare-price">$150</span></td>
                                <td><span class="compare-price">$120</span></td>
                                <td><span class="compare-price">$140</span></td>
                            </tr>
                            <tr>
                                <th>Review</th>
                                <td>
                                    <div class="compare-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span>5.0 (5k Review)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="compare-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span>5.0 (5k Review)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="compare-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span>5.0 (5k Review)</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td><a href="#" class="theme-btn"> <span class="far fa-shopping-bag"></span>Add To Cart</a></td>
                                <td><a href="#" class="theme-btn"> <span class="far fa-shopping-bag"></span>Add To Cart</a></td>
                                <td><a href="#" class="theme-btn"> <span class="far fa-shopping-bag"></span>Add To Cart</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- compare area end -->

    </main>





@endsection

@section('js')

@endsection