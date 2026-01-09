@extends('frontend.includes.layout')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .dates::-webkit-scrollbar {
            height: 8px;
            /* This sets horizontal scrollbar height */
        }

        .table-container {
            background: #fff;
            border-radius: 16px;
            /* box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05); */
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #f9fafb;
        }

        .table th {
            text-align: center;
            padding: 18px 24px;
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        .table tbody tr {
            transition: background 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f1fdfb;
        }

        .table td {
            text-align: center;
            padding: 8px 21px;
            font-size: 16px;
            color: #34495e;
            border-top: 1px solid #eceff1;
        }

        .action-buttons {
            display: inline-flex;
            gap: 10px;
        }

        .edit-btn,
        .delete-btn {
            border: none;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.3s ease;
        }

        .edit-btn {
            background-color: #3498db;
            color: #fff;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .day-button {
            /* width: 70px; */
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: 0.3s;
            /* margin-right: 10px; */
            line-height: 25px;
        }

        .day-button:hover {
            background-color: #e7f0ff;
        }

        .day-selected {
            border: 2px solid #0095d9;
            background-color: #d8f3ff;
        }

        .time-slot {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 6px 20px;
            margin: 5px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
            line-height: 1.5;
        }

        .time-slot:hover {
            background-color: #e6f0fa;
        }

        .time-slot.active {
            border: 2px solid #0095d9;
            background-color: #d8f3ff;
            color: #0095d9 !important;
        }

        .schedule-btn {
            width: 100%;
            background-color: #004d61;
            color: white;
            padding: 12px;
            font-weight: bold;
        }

        .schedule-btn:hover {
            background-color: #006d87;
        }

        .scroll-area {
            max-height: 200px;
            overflow-y: auto;
        }

        #dateCarousel {
            position: relative;
        }

        .owl-stage {
            display: flex !important;
            gap: 6px;
            /* adds consistent spacing */
        }

        /* Owl Nav Buttons */
        .owl-nav {
            position: absolute;
            top: 35%;
            width: 95%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .owl-nav button.owl-prev,
        .owl-nav button.owl-next {
            background: #0095d9 !important;
            color: #fff !important;
            border: none;
            font-size: 18px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            pointer-events: all;
        }

        .owl-nav button.owl-prev {
            margin-left: -20px;
        }

        .scroll-area::-webkit-scrollbar {
            width: 6px;
            /* Width of vertical scrollbar */
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        scroll-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .consult {
            max-height: 600px;
        }

        .nav-tabs .nav-link {
            color: #000 !important;
        }

        .nav-tabs .nav-link {
            color: #000 !important;
        }

        .form-label {
            font-weight: 600;
            color: #0095d9;
        }

        .input-group-text {
            background-color: #e0f3fc;
            border-color: #b3e0f8;
            color: #0095d9;
        }

        #progressbar #personal:before {
            margin: auto;
            text-align: center;
        }

        #progressbar #location:before {
            margin: auto;
            text-align: center;
        }

        #progressbar li {
            width: 25% !important;
        }

        #progressbar #selectLab:before {
            margin: auto;
            text-align: center;
        }

        #progressbar #payment:before {
            margin: auto;
            text-align: center;
        }

        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #000;
            border-radius: 4px;
            background-color: #fff;
            position: relative;
            cursor: pointer;
        }

        .custom-checkbox:checked {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23008000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 16px 16px;
            border-color: #008000;
        }

        .bg-sk {
            background-color: #0095d91c;
        }

        .accordion-button::after {
            display: none;
        }

        .accordion-button:not(.collapsed) {
            box-shadow: none;
        }

        .accordion-button .accordion-content {
            width: 100%;
        }

        .accordion-button {
            background-color: #f8f9fa;
            display: block;
        }

        .quantity-controls input[type="number"]::-webkit-inner-spin-button,
        .quantity-controls input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @media (max-width: 576px) {
            .accordion-content {
                flex-direction: row !important;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 0.5rem;
                align-items: center;
            }

            .accordion-content>div:first-child {
                flex: 1 1 auto;
                display: flex;
                flex-direction: row;
                gap: 0.25rem;
                align-items: center;
                flex-wrap: wrap;
            }

            .accordion-content>div:last-child {
                flex: 1 1 auto;
                display: flex;
                flex-direction: row;
                justify-content: flex-end;
                align-items: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .quantity-controls {
                justify-content: flex-start;
            }
        }

        @media (max-width: 330px) {
            .accordion-content {
                flex-direction: row !important;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 0.5rem;
                align-items: center;
            }

            .accordion-content>div:first-child {
                flex: 1 1 auto;
                display: flex;
                flex-direction: row;
                gap: 0.25rem;
                align-items: center;
                flex-wrap: wrap;
            }

            .accordion-content>div:last-child {
                flex: 1 1 auto;
                display: flex;
                flex-direction: row;
                justify-content: flex-end;
                align-items: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .quantity-controls {
                justify-content: flex-start;
            }

            #decreaseQuantityBtn,
            #increaseQuantityBtn {
                padding: 0;
                height: 20px;
            }

            .accordion-item:first-of-type>.accordion-header .accordion-button {
                padding: 10px;
            }
        }

        .lab-card.active {
            background-color: rgba(171, 228, 255, 0.16);
            border: 2px solid var(--theme-color) !important;
        }

        #checkout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .hanging-banner {
            background: linear-gradient(to bottom, #0095d9, #0095d9);
            width: 300px;
            height: 45px;
            margin: 0 auto;
            border-radius: 0 0 30px 30px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
            font-family: 'Segoe UI', sans-serif;
            top: -24px;
        }

        .banner-text {
            z-index: 1;
        }

        .hanging-banner::before,
        .hanging-banner::after {
            content: "";
            position: absolute;
            top: 5px;
            width: 10px;
            height: 10px;
            background: radial-gradient(circle at 30% 30%, #0095d9, #0095d9);
            border-radius: 50%;
            border: 2px solid #7dddff;
            z-index: 3;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 0.3), inset -1px -1px 2px rgba(0, 0, 0, 0.2);
        }

        .hanging-banner::before {
            left: 10px;
        }

        .hanging-banner::after {
            right: 10px;
        }

        /* Screw slot simulation */
        .hanging-banner::before::after,
        .hanging-banner::after::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 2px;
            background: #444;
            transform: translate(-50%, -50%);
            border-radius: 1px;
        }
    </style>
@endsection
@section('content')
    <main class="main">
        <!-- shop checkout -->
        <div class="shop-checkout py-5">
            <div class="container">
                <div class="shop-checkout-wrap">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="shop-checkout-step">
                                <div class="card p-4 contact-form shadow-sm">
                                    <div class="hanging-banner-container text-center position-relative ">
                                        <div class="hanging-banner">
                                            <span class="banner-text">Delivery Information</span>
                                        </div>
                                    </div>
                                    <form id="msform" class="">


                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4>
                                                            Select Delivery Address
                                                        </h4>
                                                    </div>
                                                    <div class="col-6">
                                                        <h2 class="steps">
                                                            <button type="button" class="theme-btn" data-bs-toggle="modal"
                                                                data-bs-target="#addAddressModal">Add <i
                                                                    class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row row-cols-1 row-cols-md-2 g-4 py-4"
                                                            id="addressContainer">

                                                        </div>
                                                    </div>
                                                </div>

                                            </div> <input type="button" name="next" class="next action-button theme-btn"
                                                value="Next" />
                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>
                                                            Payment Information
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form>
                                                            <div class="row g-4 my-4">
                                                                <div class="col-md-12">
                                                                    <label for="name">Full Name</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bi bi-person-fill"></i></span>
                                                                        <input type="text"
                                                                            class="form-control shadow-none" id="name"
                                                                            placeholder="Full Name"
                                                                            value="{{ auth()->user()->name ?? '' }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-4">
                                                                        <label for="email">Email</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text"><i
                                                                                    class="bi bi-envelope-fill"></i></span>
                                                                            <input type="email"
                                                                                class="form-control shadow-none"
                                                                                id="email"
                                                                                placeholder="email@example.com" required
                                                                                value="{{ auth()->user()->email ?? '' }}">
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-4">
                                                                        <label for="phone">Phone</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text"><i
                                                                                    class="bi bi-telephone-fill"></i></span>
                                                                            <input type="tel"
                                                                                class="form-control shadow-none"
                                                                                id="phone" placeholder="+1 234 567 890"
                                                                                required
                                                                                value="{{ auth()->user()->phone ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="form-check mb-4">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="agreeTerms" required="">
                                                                <label class="form-check-label" for="agreeTerms">
                                                                    I agree to the
                                                                    <a href="#">Privacy Policy</a>,
                                                                    <a href="#">Refund Policy</a>, and
                                                                    <a href="#">Terms &amp; Conditions</a>.
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div> <input type="button" name="previous"
                                                class="previous action-button-previous theme-btn theme-btn2"
                                                value="Previous" />
                                        </fieldset>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="shop-cart-summary mt-0">
                                <h5>Cart Summary</h5>
                                <ul>
                                    <li>
                                        <strong>Sub Total:</strong>
                                        <span>₹{{ number_format($subtotal, 2) }}</span>
                                        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                                    </li>
                                    <li style="display:none;">
                                        <strong>Discount:</strong>
                                        <span>₹{{ number_format($discount, 2) }}</span>
                                        <input type="hidden" name="discount" value="{{ $discount }}">

                                    </li>
                                    <li>
                                        <strong>Shipping:</strong>
                                        <span
                                            id="shippingCharge">{{ $totalShipping > 0 ? '₹' . $totalShipping : 'Free' }}</span>
                                        <input type="hidden" name="shipping"
                                            value="{{ $totalShipping > 0 ? $totalShipping : 'Free' }}">
                                    </li>
                                    <li style="display:none;">
                                        <strong>Taxes:</strong>
                                        <span>₹{{ number_format($tax, 2) }}</span>
                                        <input type="hidden" name="tax" value="{{ $tax }}">
                                    </li>
                                    <li class="shop-cart-total">
                                        <strong>Total:</strong>
                                        <span id="totalAmount">₹{{ number_format($total, 2) }}</span>
                                        <input type="hidden" name="total_amount" value="{{ $total }}">
                                    </li>
                                </ul>

                                <div class="form-group mt-3">
                                    <label for="coupon_code" class="form-label fw-semibold">Have a Coupon?</label>
                                    <div class="input-group">
                                        <input type="text" id="coupon_code" class="form-control"
                                            placeholder="Enter coupon code">
                                        <button type="button" id="apply_coupon_btn"
                                            class="btn btn-primary">Apply</button>
                                    </div>
                                    <small id="coupon_message" class="text-muted d-block mt-1"></small>
                                </div>
                                <div class="text-end mt-4">
                                    <input type="hidden" name="selected_address_id" id="selected_address_id">
                                    @foreach ($items as $index => $entry)
                                        <input type="hidden" name="items[{{ $index }}][product_id]"
                                            value="{{ $entry['product_id'] }}">
                                        <input type="hidden" name="items[{{ $index }}][vendor_id]"
                                            value="{{ $entry['vendor_id'] }}">
                                        <input type="hidden" name="items[{{ $index }}][quantity]"
                                            value="{{ $entry['quantity'] }}">
                                        <input type="hidden" name="items[{{ $index }}][price]"
                                            value="{{ $entry['item']->selling_price }}">
                                    @endforeach

                                    <button id="checkout-btn" class="theme-btn w-100">Pay Now <i
                                            class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- shop checkout end -->

    </main>

    <!-- address form  -->
    <div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="addAddressModal" tabindex="-1"
        aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addAddressModalLabel">Add Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAddressForm" class="contact-form shadow-none">
                        @csrf
                        <div class="form-card">
                            <div class="row g-4">
                                <!-- Street Address -->
                                <div class="col-md-6">
                                    <label for="inputAddress" class="form-label">Street Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input type="text" class="form-control shadow-none" id="address"
                                            name="address" placeholder="Enter Address">
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-6">
                                    <label for="inputCity" class="form-label">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        <input type="text" class="form-control shadow-none" id="city"
                                            name="city" placeholder="Enter City">
                                    </div>
                                </div>

                                <!-- State -->
                                <div class="col-md-6">
                                    <label for="inputState" class="form-label">State</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-map"></i></span>
                                        <input type="text" class="form-control shadow-none" id="state"
                                            name="state" placeholder="Enter State">
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-6">
                                    <label for="inputCountry" class="form-label">Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="text" class="form-control shadow-none" id="country"
                                            name="country" placeholder="Enter Country">

                                    </div>
                                </div>

                                <!-- Pin Code -->
                                <div class="col-md-6">
                                    <label for="inputPin" class="form-label">Pin/Postal Code</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                        <input type="text" class="form-control shadow-none" id="pin"
                                            name="pin" placeholder="Enter Pin code">
                                    </div>
                                </div>

                                <!-- Google Map Link -->
                                <div class="col-md-6">
                                    <label for="inputMap" class="form-label">Google Map Location (Optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                        <input type="text" class="form-control shadow-none" id="google_map_location"
                                            name="google_map_location" placeholder="Paste Google Map Link">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  mt-4 py-4">
                            <button type="submit" class="btn btn-primary w-100">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- address form  -->
    <!-- Edit address form  -->
    <div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="editAddressModal" tabindex="-1"
        aria-labelledby="editAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editAddressModalLabel">Edit Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action=""id="editAddressForm" method="POST" action="javascript:void(0);"
                        class="contact-form shadow-none">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-card">
                            <div class="row g-4">
                                <!-- Street Address -->
                                <div class="col-md-6">
                                    <label for="inputAddress" class="form-label">Street Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input type="text" class="form-control shadow-none" id="edit_address"
                                            name="address" placeholder="Enter Address">
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-6">
                                    <label for="inputCity" class="form-label">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        <input type="text" class="form-control shadow-none" id="edit_city"
                                            name="city" placeholder="Enter City">
                                    </div>
                                </div>

                                <!-- State -->
                                <div class="col-md-6">
                                    <label for="inputState" class="form-label">State</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-map"></i></span>
                                        <input type="text" class="form-control shadow-none" id="edit_state"
                                            name="state" placeholder="Enter State">
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-6">
                                    <label for="inputCountry" class="form-label">Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="text" class="form-control shadow-none" id="edit_country"
                                            name="country" placeholder="Enter Country">

                                    </div>
                                </div>

                                <!-- Pin Code -->
                                <div class="col-md-6">
                                    <label for="inputPin" class="form-label">Pin/Postal Code</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                        <input type="text" class="form-control shadow-none" id="edit_pin"
                                            name="pin" placeholder="Enter Pin code">
                                    </div>
                                </div>

                                <!-- Google Map Link -->
                                <div class="col-md-6">
                                    <label for="inputMap" class="form-label">Google Map Location (Optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                        <input type="text" class="form-control shadow-none"
                                            id="edit_google_map_location" name="google_map_location"
                                            placeholder="Paste Google Map Link">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  mt-4 py-4">
                            <button type="submit" class="btn btn-primary w-100">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit address form  -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            var current_fs, next_fs, previous_fs;
            var current = 1;
            var steps = $("fieldset").length;

            $(".next").click(function() {
                const currentFieldset = $(this).closest("fieldset");
                // Step 1: Patient Validation (Only for the first step)
                if (currentFieldset.index() === 1) {
                    let valid = validatePatientCounts();
                    if (!valid) return; // Stop moving forward
                }
                if (currentFieldset.index() === 2) {
                    valid = validateAddress();
                    if (!valid) return; // Stop moving forward
                }

                if (currentFieldset.index() === 2) {
                    fetchLabs();
                }

                // Proceed to next step
                const nextFieldset = currentFieldset.next();
                $("#progressbar li").eq($("fieldset").index(nextFieldset)).addClass("active");

                nextFieldset.show();
                currentFieldset.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        opacity = 1 - now;
                        currentFieldset.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        nextFieldset.css({
                            'opacity': opacity
                        });
                    },
                    duration: 500
                });


                $('html, body').animate({
                    scrollTop: 0
                }, 300);
            });

            function validatePatientCounts() {
                let isValid = true;

                $('#packageAccordion .accordion-item').each(function() {
                    const $accordionItem = $(this);
                    const packageName = $accordionItem.find('.accordion-button').text().trim().split('-')[0]
                        .trim();
                    const quantity = parseInt($accordionItem.find('input[type="number"]').val());

                    // Count only patient-entry rows
                    const actualPatients = $accordionItem.find('.patient-entry').length;

                    if (actualPatients < quantity) {
                        const remaining = quantity - actualPatients;

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: `Add ${remaining} more patient(s) for "${packageName}"`,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        $accordionItem[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        isValid = false;
                        return false; // Break .each loop
                    }
                });

                return isValid;
            }

            function validateAddress() {
                let selectedId = $('#selected_address_id').val();

                if (!selectedId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Address Selected',
                        text: 'Please select an address to proceed.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return false;
                }

                return true;
            }

            $(".previous").click(function() {
                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                previous_fs.show();
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 500
                });

                $('html, body').animate({
                    scrollTop: 0
                }, 300);
            });


            // Validation logic
            function validateCurrentStep(fieldset) {
                var isValid = true;

                fieldset.find('input, select, textarea').each(function() {
                    if ($(this).prop('required') && !$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }

                    if ($(this).is(':radio') && $(this).prop('required')) {
                        const name = $(this).attr('name');
                        if ($('input[name="' + name + '"]:checked').length === 0) {
                            $('input[name="' + name + '"]').addClass('is-invalid');
                            isValid = false;
                        } else {
                            $('input[name="' + name + '"]').removeClass('is-invalid');
                        }
                    }
                });

                return isValid;
            }

            $("#msform").on("submit", function(e) {
                if (!validateCurrentStep($(this).find("fieldset").last())) {
                    e.preventDefault();
                } else {
                    alert("Form submitted successfully!"); // Replace with AJAX if needed
                }
            });
        });

        // Add address
        $('#addAddressForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            // Show SweetAlert loading
            Swal.fire({
                title: 'Saving address...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post("{{ route('addresses.store') }}", formData, function(response) {
                Swal.close(); // Close loading alert
                $('#addAddressForm')[0].reset();
                $('#addAddressModal').modal('hide');
                fetchAddresses();

                // Optional success message
                Swal.fire({
                    icon: 'success',
                    title: 'Address added successfully!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            }).fail(function(xhr) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to save address',
                    text: xhr.responseJSON?.message || 'Something went wrong',
                });
                console.log(xhr);
            });
        });


        function fetchAddresses() {
            $.ajax({
                url: "{{ route('addresses.fetch') }}",
                type: 'GET',
                success: function(addresses) {
                    let html = '';

                    if (!addresses || addresses.length === 0) {
                        html = '<p>No addresses found.</p>';
                    } else {
                        addresses.forEach(function(address, index) {
                            const isActive = index === 0 ? 'active' : '';

                            html += `
                    <div class="col">
                        <div class="card h-100 border address shadow-sm ${isActive} select-address-btn" data-id="${address.id}" id="card-${address.id}">
                            <div class="card-body">
                                <div class="position-absolute top-0 end-0 mt-3 me-3">
                                    <a href="javascript:void(0);" 
                                       class="btn btn-sm btn-outline-primary edit-address-btn"
                                       data-id="${address.id}"
                                       data-address="${address.address}"
                                       data-city="${address.city}"
                                       data-state="${address.state}"
                                       data-country="${address.country}"
                                       data-pin="${address.pin}"
                                       data-map="${address.google_map_location}"
                                       title="Edit Address">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                                <h5 class="pb-2 mb-1 text-primary">
                                    <i class="bi bi-geo-alt-fill me-2"></i>Address
                                </h5>
                                <hr>
                                <a href="javascript:void(0);" >
                                    <p class="text-muted">
                                        ${address.address}, ${address.city}, ${address.state}, ${address.country}, ${address.pin}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                `;

                            // ✅ Automatically set selected ID for first address
                            if (index === 0) {
                                $('#selected_address_id').val(address.id);
                                shippingCalculator()
                            }
                        });
                    }

                    $('#addressContainer').html(html);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }


        fetchAddresses();

        $(document).on('click', '.edit-address-btn', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_address').val($(this).data('address'));
            $('#edit_city').val($(this).data('city'));
            $('#edit_state').val($(this).data('state'));
            $('#edit_country').val($(this).data('country'));
            $('#edit_pin').val($(this).data('pin'));
            $('#edit_google_map_location').val($(this).data('map'));
            $('#editAddressModal').modal('show');
        });

        // Update address
        // Update address
        $('#editAddressForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let formData = $(this).serialize();

            // Show SweetAlert loading
            Swal.fire({
                title: 'Updating Address...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "/user/addresses/" + id + "/update",
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.close(); // Close loading
                    $('#editAddressModal').modal('hide');
                    $('#card-' + id).remove();
                    fetchAddresses();

                    // Optional success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Address updated successfully!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
                error: function(xhr) {
                    Swal.close(); // Close loading
                    console.log(xhr);

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to update address',
                        text: xhr.responseJSON?.message || 'Please try again later.'
                    });
                }
            });
        });


        $(document).on('click', '.select-address-btn', function() {
            const addressId = $(this).data('id');

            // Store in hidden input
            $('#selected_address_id').val(addressId);

            // Remove previous selections
            $('.address').removeClass('active');

            // Mark this one as selected
            $(`#card-${addressId}`).addClass('active');

            shippingCalculator();
        });


        function checkIfAllBookingFieldsFilled() {
            const textFields = ['#selected_address_id', '#email', '#phone', '#name'];
            const checkboxField = '#agreeTerms';

            // Check all text fields
            let allFilled = textFields.every(selector => {
                const val = $(selector).val();
                return val !== undefined && val !== null && val.trim() !== '';
            });

            // Check if checkbox is ticked
            const isChecked = $(checkboxField).is(':checked');

            // Enable button only if all fields filled and terms agreed
            $('#checkout-btn').prop('disabled', !(allFilled && isChecked));
        }

        // Trigger on input/checkbox changes
        $(document).on('change', '#selected_address_id, #email, #phone, #name, #agreeTerms', function() {
            checkIfAllBookingFieldsFilled();
        });
        checkIfAllBookingFieldsFilled();

        $(document).on('click', '#checkout-btn', function() {

            const items = [];
            $('input[name^="items"]').each(function() {
                const input = $(this);
                const name = input.attr('name'); // items[0][product_id]
                const match = name.match(/^items\[(\d+)\]\[(\w+)\]$/);
                if (match) {
                    const index = match[1];
                    const field = match[2];
                    if (!items[index]) items[index] = {};
                    items[index][field] = input.val();
                }
            });

            const checkoutData = {
                address: $('#selected_address_id').val(),
                subtotal: $('input[name="subtotal"]').val(),
                discount: $('input[name="discount"]').val(),
                tax: $('input[name="tax"]').val(),
                total_amount: $('input[name="total_amount"]').val(),
                items: items
            };

            if (!checkoutData.address) {
                Swal.fire('Error', 'Please select a delivery address', 'error');
                return;
            }

            Swal.fire({
                title: 'Processing Payment...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            // Step 1: Create Razorpay order
            fetch('/razorpay/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: checkoutData.total_amount,
                        type: 'product'
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (!data.order_id) {
                        Swal.close();
                        Swal.fire('Error', 'Failed to initiate payment', 'error');
                        return;
                    }

                    // Step 2: Open Razorpay checkout
                    const options = {
                        key: "{{ config('services.razorpay.key') }}",
                        amount: data.amount,
                        currency: data.currency,
                        order_id: data.order_id,
                        handler: function(response) {

                            // Step 3: Payment success, now place the order
                            checkoutData.razorpay_payment_id = response.razorpay_payment_id;
                            checkoutData.razorpay_order_id = response.razorpay_order_id;
                            checkoutData.razorpay_signature = response.razorpay_signature;
                            checkoutData.payment_status = 'Paid';

                            $.ajax({
                                url: "{{ route('product.checkout.store') }}",
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: checkoutData,
                                success: function(res) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Placed!',
                                        text: res.message
                                    }).then(() => window.location.href =
                                        '/user/order-list');
                                },
                                error: function(xhr) {
                                    Swal.fire('Error', xhr.responseJSON?.message ||
                                        'Order failed', 'error');
                                }
                            });

                        },
                        theme: {
                            color: "#528FF0"
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.open();

                })
                .catch(err => {
                    Swal.fire('Error', 'Something went wrong while initiating payment', 'error');
                    console.error(err);
                });

        });

        function shippingCalculator() {
            const addressId = $('#selected_address_id').val();

            if (!addressId) {
                alert('Please select a delivery address first.');
                return;
            }

            // Optional: show loader or temporary text
            $('#shippingCharge').text('Calculating...');
            $('#totalAmount').text('Calculating...');

            $.ajax({
                url: "{{ route('checkout.calculateShipping') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    address_id: addressId
                },
                success: function(res) {
                    if (res.error) {
                        alert(res.error);
                        return;
                    }

                    $('#shippingCharge').text('₹' + res.totalShipping);
                    $('#totalAmount').text('₹' + res.total);
                    $('input[name="shipping"]').val(res.totalShipping);
                    $('input[name="total_amount"]').val(res.total);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error calculating shipping');
                }
            });
        }
    </script>
@endsection
