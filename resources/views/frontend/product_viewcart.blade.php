@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')

<main class="main">
    <!-- shop cart -->
    <div class="shop-cart py-90">
        <div class="container">
            <div class="shop-cart-wrap">
               <div class="row">
                        <div class="col-lg-8">
                            <div class="cart-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Sub Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="shop-cart-img">
                                                        <a href="#"><img src="assets/img/product/01.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-content">
                                                        <h5 class="shop-cart-name"><a href="#">Surgical Face Mask</a></h5>
                                                        <div class="shop-cart-info">
                                                            <p><span>Type:</span>Armchair</p>
                                                            <p><span>Color:</span>Orange</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-price">
                                                        <span>$1,500</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-qty">
                                                        <button class="minus-btn"><i class="fal fa-minus"></i></button>
                                                        <input class="quantity" type="text" value="1" disabled="">
                                                        <button class="plus-btn"><i class="fal fa-plus"></i></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-subtotal">
                                                        <span>$1,500</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="shop-cart-remove"><i class="far fa-times"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="shop-cart-img">
                                                        <a href="#"><img src="assets/img/product/15.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-content">
                                                        <h5 class="shop-cart-name"><a href="#">Surgical Face Mask</a></h5>
                                                        <div class="shop-cart-info">
                                                            <p><span>Type:</span>Armchair</p>
                                                            <p><span>Color:</span>Orange</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-price">
                                                        <span>$1,500</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-qty">
                                                        <button class="minus-btn"><i class="fal fa-minus"></i></button>
                                                        <input class="quantity" type="text" value="1" disabled="">
                                                        <button class="plus-btn"><i class="fal fa-plus"></i></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-subtotal">
                                                        <span>$1,500</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="shop-cart-remove"><i class="far fa-times"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="shop-cart-img">
                                                        <a href="#"><img src="assets/img/product/03.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-content">
                                                        <h5 class="shop-cart-name"><a href="#">Surgical Face Mask</a></h5>
                                                        <div class="shop-cart-info">
                                                            <p><span>Type:</span>Armchair</p>
                                                            <p><span>Color:</span>Orange</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-price">
                                                        <span>$1,500</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-qty">
                                                        <button class="minus-btn"><i class="fal fa-minus"></i></button>
                                                        <input class="quantity" type="text" value="1" disabled="">
                                                        <button class="plus-btn"><i class="fal fa-plus"></i></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="shop-cart-subtotal">
                                                        <span>$1,500</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="shop-cart-remove"><i class="far fa-times"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="shop-cart-summary">
                                <h5>Cart Summary</h5>
                                <ul>
                                    <li><strong>Sub Total:</strong> <span>$4,500.00</span></li>
                                    <li><strong>Discount:</strong> <span>$5.00</span></li>
                                    <li><strong>Shipping:</strong> <span>Free</span></li>
                                    <li><strong>Taxes:</strong> <span>$25.00</span></li>
                                    <li class="shop-cart-total"><strong>Total:</strong> <span>$4,520.00</span></li>
                                </ul>
                                <div class="text-end mt-40">
                                    <a href="#" class="theme-btn">Checkout Now<i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- shop cart end -->
</main>


@endsection
@section('js')

@endsection