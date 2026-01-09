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

                    <div class="col-lg-8 ">
                        <div class="d-flex justify-content-between px-3 mb-4"  style="background: #F5F7FA; height: 54px; align-items: center;  border-radius: 10px;">
                            <div class=" align-items-center">
                                <h4>View all test</h4>
                            </div>
                            <div>
                                <a class="text-primary " href="{{route('lab.test')}}">
                                    <i class="fa-solid fa-plus"></i> Add more test
                                </a>
                            </div>
                        </div>
                        <div class="cart-table">

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>

                                            <th>S.No.</th>

                                            <th>Image</th>

                                            <th>Name</th>

                                            <th>Price</th>

                                            <!-- <th>No. of Patients</th> -->

                                            <th>Total</th>

                                            <th></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($items as $entry)

                                        <tr class="cart-item-row" data-id="{{ $entry['item']->id }}"

                                            data-type="{{ $entry['type'] }}"

                                            data-price="{{ $entry['item']->price }}"

                                            data-quantity="{{ $entry['quantity'] }}">

                                            <td>{{ $loop->iteration }}.</td>

                                            <td>

                                                <div class="shop-cart-img">

                                                    @php

                                                    $item = $entry['item'];

                                                    $image = 'assets/img/default.png'; // default fallback



                                                    if (!empty($item->package_icon)) {

                                                    $image = asset($item->package_icon);

                                                    } elseif (

                                                    !empty($item->categoryDetails) &&

                                                    !empty($item->categoryDetails->category_image)

                                                    ) {

                                                    $image = asset(

                                                    $item->categoryDetails->category_image,

                                                    );

                                                    } else {

                                                    $image = asset($image);

                                                    }

                                                    @endphp

                                                    <a href="#">

                                                        <img src="{{ $image }}" alt="{{ $item->name }}"

                                                            class="img-fluid" style="max-height: 60px;">

                                                    </a>

                                                </div>

                                            </td>

                                            <td>

                                                <div class="shop-cart-content">

                                                    <h5 class="shop-cart-name"><a href="#">

                                                            {{ $entry['item']->name ?? $entry->item->name }}</a>

                                                    </h5>

                                                </div>

                                            </td>

                                            <td>

                                                <div class="shop-cart-price">

                                                    <span>₹{{ $entry['item']->price }} x ({{ $entry['quantity']}} <small> Patients </small>)</span>

                                                </div>

                                            </td>

                                            <!-- <td>

                                                <select class="form-select form-select-sm update-qty"

                                                    data-id="{{ $entry['item']->id ?? $entry->item_id }}"

                                                    data-type="{{ $entry['type'] ?? class_basename($entry->item_type) }}"

                                                    style="max-width: 110px;">

                                                    @for ($i = 1; $i <= 5; $i++)

                                                        <option value="{{ $i }}"

                                                        {{ $entry['quantity'] == $i ? 'selected' : '' }}>

                                                        {{ $i }} {{ Str::plural('Patient', $i) }}

                                                        </option>

                                                        @endfor

                                                </select>

                                            </td> -->

                                            <td>

                                                <div class="shop-cart-total border-0 p-0">

                                                    <span

                                                        class="row-total">₹{{ $entry['item']->price * $entry['quantity'] }}</span>

                                                </div>

                                            </td>

                                            <td>

                                                <a href="javascript:void(0);" class="shop-cart-remove remove-item "

                                                    data-id="{{ $entry['item']->id ?? $entry->item_id }}"

                                                    data-type="{{ $entry['type'] ?? class_basename($entry->item_type) }}"><i

                                                        class="far fa-times"></i></a>

                                            </td>

                                        </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                                <p class="small">These tests are added for <b class="text-dark">one member only</b>. You’ll be able to add or remove members in the next step.</p>


                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="shop-cart-summary mt-0">

                            <h5>Cart Summary</h5>

                            @php

                            $subTotal = 0;

                            foreach ($items as $entry) {

                            $price = $entry['item']->price ?? 0;

                            $quantity = $entry['quantity'] ?? 1;

                            $subTotal += $price * $quantity;

                            }

                            $total = $subTotal; // Add tax/shipping if needed

                            @endphp

                            <ul>

                                <li><strong>Sub Total:</strong> <span

                                        id="subtotal">₹{{ number_format($subTotal, 2) }}</span></li>

                                <li class="shop-cart-total"><strong>Total:</strong> <span

                                        id="total">₹{{ number_format($total, 2) }}</span></li>

                            </ul>

                            <div class="text-end mt-40">

                                <a href="javascript:void(0);" class="theme-btn " id="checkout-btn">Proceed<i

                                        class="fas fa-arrow-right"></i></a>

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

<script>
    function recalculateTotals() {

        let subTotal = 0;

        $('.cart-item-row').each(function() {

            const price = parseFloat($(this).data('price')) || 0;

            const qty = parseInt($(this).find('.update-qty').val()) || 1;

            const rowTotal = price * qty;



            // Update this row's total cell

            $(this).find('.row-total').text('₹' + rowTotal.toFixed(2));



            subTotal += rowTotal;

        });



        // Update summary

        $('#subtotal').text('₹' + subTotal.toFixed(2));

        $('#total').text('₹' + subTotal.toFixed(2));

    }



    $(document).on('change', '.form-select-sm', function(e) {

        e.preventDefault();

        recalculateTotals();

    });



    $(document).on('click', '.remove-item', function() {

        Swal.fire({

            title: 'Removing item from Cart...',

            allowOutsideClick: false,

            didOpen: () => {

                Swal.showLoading();

            }

        });

        let button = $(this);

        let itemId = button.data('id');

        let itemType = button.data('type');



        $.post("{{ route('cart.remove') }}", {

                _token: '{{ csrf_token() }}',

                item_id: itemId,

                item_type: itemType

            },
            function(res) {

                if (res.status === 'success') {

                    Swal.close();

                    // Remove the closest <li> or item container

                    button.closest('tr').remove();



                    // Show toast message

                    showToast('success', res.message || 'Item removed!');

                    updateCartCount();

                    updateCombinedCartCount();

                    recalculateTotals();

                    updateMobileCartSummary();

                } else {

                    showToast('error', 'Failed to remove item!');

                }

            }).fail(function() {

            showToast('error', 'An error occurred!');

        });

    });
</script>

{{-- Checkout Login --}}

<script>
    $(document).ready(function() {

        $('#checkout-btn').on('click', function(e) {

            e.preventDefault();

            if (!isLoggedIn) {

                $('#popup-banner').modal('show');

            } else {

                window.location.href = "{{ route('checkout') }}";

            }

        });

    });
</script>

@endsection