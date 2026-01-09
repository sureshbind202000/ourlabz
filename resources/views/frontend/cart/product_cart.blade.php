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

                                                <th>S.No.</th>

                                                <th>Image</th>

                                                <th>Name</th>

                                                <th>Qty.</th>

                                                <th>Price</th>

                                                <th></th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach ($items as $entry)

                                                @php

                                                    $item = $entry['item'];

                                                    $image = !empty($item->images->first()?->image)

                                                        ? asset($item->images->first()->image)

                                                        : asset('assets/img/product_cart.png');

                                                @endphp

                                                <tr class="cart-item-row" data-id="{{ $item->id }}"

                                                    data-type="{{ $entry['type'] }}" data-price="{{ $item->selling_price }}"

                                                    data-quantity="{{ $entry['quantity'] }}">

                                                    <td>{{ $loop->iteration }}.</td>

                                                    <td>

                                                        <div class="shop-cart-img">

                                                            <a href="#">

                                                                <img src="{{ $image }}"

                                                                    alt="{{ $item->product_name }}" class="img-fluid"

                                                                    style="max-height: 60px;">

                                                            </a>

                                                        </div>

                                                    </td>

                                                    <td>

                                                        <h5 class="shop-cart-name"><a

                                                                href="#">{{ $item->product_name }}</a></h5>

                                                    </td>

                                                    <td>

                                                        <div class="input-group quantity-control" style="max-width: 100px;">

                                                            <button class="btn btn-sm btn-primary qty-minus" type="button"

                                                                data-id="{{ $item->id }}" data-type="Product">−</button>

                                                            <input type="number"

                                                                class="form-control form-control-sm text-center quantity-input"

                                                                value="{{ $entry['quantity'] }}" min="1"

                                                                data-id="{{ $item->id }}" data-type="Product">

                                                            <button class="btn btn-sm btn-primary qty-plus" type="button"

                                                                data-id="{{ $item->id }}"

                                                                data-type="Product">+</button>

                                                        </div>

                                                    </td>

                                                    <td>

                                                        <span

                                                            class="item-total-price">₹{{ number_format($item->selling_price, 2) }}</span>

                                                    </td>

                                                    <td>

                                                        <a href="javascript:void(0);" class="shop-cart-remove remove-item"

                                                            data-id="{{ $item->id }}"

                                                            data-type="{{ $entry['type'] }}">

                                                            <i class="far fa-times"></i>

                                                        </a>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>



                                    </table>

                                </div>

                            </div>

                        </div>



                        <!-- Cart Summary -->

                        <div class="col-lg-4">

                            <div class="shop-cart-summary">

                                <h5>Cart Summary</h5>

                                @php

                                    $subTotal = 0;

                                    foreach ($items as $entry) {

                                        $subTotal += ($entry['item']->selling_price ?? 0) * ($entry['quantity'] ?? 1);

                                    }

                                @endphp

                                <ul>

                                    <li><strong>Sub Total:</strong> <span

                                            id="subtotal">₹{{ number_format($subTotal, 2) }}</span></li>

                                    <li class="shop-cart-total"><strong>Total:</strong> <span

                                            id="total">₹{{ number_format($subTotal, 2) }}</span></li>

                                </ul>

                                <div class="text-end mt-40">

                                    <a href="javascript:void(0);" class="theme-btn" id="checkout-btn">Checkout Now <i

                                            class="fas fa-arrow-right"></i></a>

                                </div>

                            </div>

                        </div>



                        <!-- /Cart Summary -->



                    </div>

                </div>

            </div>

        </div>

        <!-- shop cart end -->

    </main>

@endsection



@section('js')

    <script>

        function recalculateTotals() {

            let subTotal = 0;

            $('.cart-item-row').each(function() {

                const price = parseFloat($(this).data('price'));

                const qty = parseInt($(this).data('quantity'));

                subTotal += price * qty;

            });

            $('#subtotal').text('₹' + subTotal.toFixed(2));

            $('#total').text('₹' + subTotal.toFixed(2)); // Add tax if needed

        }



        $(document).on('click', '.remove-item', function() {

            let button = $(this);

            let itemId = button.data('id');

            let itemType = button.data('type');



            $.ajax({

                url: '{{ route('product.cart.remove') }}',

                type: 'POST',

                data: {

                    _token: '{{ csrf_token() }}',

                    item_id: itemId,

                    item_type: itemType

                },

                beforeSend: function() {

                    Swal.fire({

                        title: 'Removing item from Cart...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });

                },

                success: function(res) {

                    Swal.close();

                    if (res.status === 'success') {

                        button.closest('tr').remove();

                        showToast('success', res.message || 'Item removed!');

                        updateProductCartCount();

                        updateCombinedCartCount();

                        recalculateTotals();

                        updateMobileCartSummary();

                    } else {

                        showToast('error', res.message || 'Failed to remove item!');

                    }

                },

                error: function(xhr, status, error) {

                    console.log('AJAX Error:', xhr);

                    Swal.close();

                    showToast('error', 'An error occurred while removing the item.');

                }

            });

        });


        $(document).ready(function() {

            $('#checkout-btn').on('click', function(e) {

                e.preventDefault();

                if (!isLoggedIn) {

                    $('#popup-banner').modal('show');

                } else {

                    window.location.href = "{{ route('product.checkout') }}";

                }

            });

        });



        // Qty. Update

        function updateCartQuantity(itemId, itemType, quantity) {

            if (itemType !== 'Product') return;



            $.ajax({

                url: "{{ route('product.cart.updateQuantity') }}",

                method: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    item_id: itemId,

                    item_type: itemType,

                    quantity: quantity

                },

                beforeSend: function() {

                    Swal.fire({

                        title: 'Updating Quantity...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });

                },

                success: function(res) {

                    Swal.close();

                    if (res.status === 'success') {

                        const row = $(`.cart-item-row[data-id="${itemId}"]`);

                        const price = parseFloat(row.data('price'));

                        const total = price * quantity;



                        row.find('.quantity-input').val(quantity);

                        // row.find('.item-total-price').text('₹' + total.toFixed(2));



                        // Recalculate summary

                        let newSubtotal = 0;

                        $('.cart-item-row').each(function() {

                            const qty = parseInt($(this).find('.quantity-input').val());

                            const itemPrice = parseFloat($(this).data('price'));

                            newSubtotal += qty * itemPrice;

                        });



                        $('#subtotal').text('₹' + newSubtotal.toFixed(2));

                        $('#total').text('₹' + newSubtotal.toFixed(2));



                        showToast('success', res.message || 'Quantity updated!');

                    }

                }

            });

        }



        $(document).on('click', '.qty-plus', function() {

            const input = $(this).siblings('.quantity-input');

            let quantity = parseInt(input.val()) + 1;

            const itemId = $(this).data('id');

            const itemType = $(this).data('type');

            updateCartQuantity(itemId, itemType, quantity);

        });



        $(document).on('click', '.qty-minus', function() {

            const input = $(this).siblings('.quantity-input');

            let quantity = parseInt(input.val()) - 1;

            if (quantity < 1) quantity = 1;

            const itemId = $(this).data('id');

            const itemType = $(this).data('type');

            updateCartQuantity(itemId, itemType, quantity);

        });



        $(document).on('change', '.quantity-input', function() {

            let quantity = parseInt($(this).val());

            if (isNaN(quantity) || quantity < 1) quantity = 1;

            const itemId = $(this).data('id');

            const itemType = $(this).data('type');

            updateCartQuantity(itemId, itemType, quantity);

        });

    </script>

@endsection

