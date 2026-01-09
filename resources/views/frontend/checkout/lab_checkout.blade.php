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

        width: 245px;

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

        font-size: 16px;

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


    .filter-toggle {
        background: #f3f3f3;
        border-radius: 14px;
        padding: 4px;
        display: flex;
        width: fit-content;
    }

    .toggle-btn {
        border: 1px solid #0095d9;
        padding: 10px 28px;
        border-radius: 12px;
        background: transparent;
        color: #666;
        font-weight: 500;
        transition: all 0.25s ease;
    }

    .toggle-btn.active {
        background: linear-gradient(135deg, #0095d9, #37a9dd);
        color: #fff !important;
        box-shadow: 0 6px 18px rgb(163 210 231 / 23%);
    }

    .search-input {
        height: 42px;
        /* toggle ke equal */
        border-radius: 999px;
        padding-left: 16px;
    }


    #viewAllCouponsModal .modal-dialog .modal-content{
        /* position: fixed; */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050;
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

                                        <span class="banner-text">Booking Information</span>

                                    </div>

                                </div>

                                <form id="msform" class="">

                                    <!-- progressbar -->

                                    <ul id="progressbar">

                                        <li class="active" id="personal"><strong>Patient

                                                Details</strong></li>

                                        <li id="location"><strong>Select Address</strong></li>

                                        <li id="selectLab"><strong>Select Lab</strong></li>

                                        <li id="payment"><strong>Booking Slot</strong></li>

                                    </ul>

                                    <!-- fieldsets -->

                                    <fieldset>

                                        <div class="form-card">



                                            <div class="row">

                                                <div class="col-sm-12">

                                                    <div class="accordion" id="packageAccordion">



                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row" style="position: absolute;">
                                                <div class="col-sm-12 ">
                                                    <!-- Add More Patient Button (if slots available) -->

                                                    <div class="d-flex justify-content-center">
                                                        <button class="btn btn-primary action-button theme-btn w-auto mx-0" type="button" style="margin: 10px;padding: 12px 20px;" onclick="openAddPatientModal()">
                                                            + Add More Patient
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <input type="button" name="next" class="next action-button theme-btn"

                                            value="Next" />

                                    </fieldset>

                                    <fieldset>

                                        <div class="form-card">

                                            <div class="row">

                                                <div class="col-12">

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

                                            value="Next" /> <input type="button" name="previous"

                                            class="previous action-button-previous theme-btn theme-btn2"

                                            value="Previous" />

                                    </fieldset>

                                    <fieldset>

                                        <div class="form-card">



                                            <div class="row">

                                                <div class="col-sm-12">

                                                    <div class="row row-cols-1 row-cols-md-2 g-4 py-4"

                                                        id="labContainer">



                                                    </div>

                                                </div>

                                            </div>



                                        </div> <input type="button" name="next" class="next action-button theme-btn"

                                            value="Next" /> <input type="button" name="previous"

                                            class="previous action-button-previous theme-btn theme-btn2"

                                            value="Previous" />

                                    </fieldset>

                                    <fieldset>

                                        <div class="form-card">



                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <p>When should we collect the sample?</p>
                                                    <div class="d-flex gap-5 py-4 px-3">

                                                        <div class="form-check">

                                                            <input class="form-check-input border border-primary"

                                                                type="radio" name="schedule_for"

                                                                id="homeCollectionRadio" value="1">

                                                            <label class="form-check-label" for="homeCollectionRadio">

                                                                <i class="fa-solid fa-house me-2 text-primary"></i> Home

                                                                Collection

                                                            </label>

                                                        </div>

                                                        <div class="form-check">

                                                            <input class="form-check-input border border-primary"

                                                                type="radio" name="schedule_for" id="labVisitRadio"

                                                                value="2">

                                                            <label class="form-check-label" for="labVisitRadio">

                                                                <i class="fa-solid fa-microscope me-2 text-primary"></i>

                                                                Lab Visit

                                                            </label>

                                                        </div>

                                                    </div>



                                                    <div class="consult">

                                                        <!-- Date Carousel -->

                                                        <div class="owl-carousel owl-theme px-4 pb-4" id="dateCarousel">

                                                        </div>



                                                        <!-- Time Slots Section -->

                                                        <div class="mt-4">

                                                            <div class="nav nav-tabs justify-content-start"

                                                                id="nav-tab" role="tablist">

                                                                <button class="nav-link active text-primary"

                                                                    data-period="morning" type="button">

                                                                    <i class="fa-solid fa-sun me-1"></i> Morning

                                                                </button>

                                                                <button class="nav-link text-primary"

                                                                    data-period="afternoon" type="button">

                                                                    <i class="fa-solid fa-cloud-sun me-1"></i>

                                                                    Afternoon

                                                                </button>

                                                                <button class="nav-link text-primary"

                                                                    data-period="evening" type="button">

                                                                    <i class="fa-solid fa-cloud-moon me-1"></i> Evening

                                                                </button>

                                                            </div>



                                                            <div class="scroll-area py-3">

                                                                <div class="d-flex flex-wrap gap-2 justify-content-start"

                                                                    id="timeSlotContainer"></div>

                                                            </div>

                                                        </div>





                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <input type="button" name="previous"

                                            class="previous action-button-previous theme-btn theme-btn2"

                                            value="Previous" />

                                    </fieldset>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4 right-items">
                        <div class="offer-container mt-0">
                            <h5>Offers</h5>
                            <div class="form-group mt-3">

                                <label for="coupon_code" id="couponLabel" class="form-label fw-semibold">Have a Coupon?</label>

                                <div class="input-group" id="coupon_code_container">
                                    <input name="coupon_code" type="text" id="coupon_code" class="form-control"
                                        placeholder="Enter coupon code">
                                    <button type="button" id="applyCouponBtn"
                                        class="btn btn-primary">Apply</button>
                                </div>
                                <div id="appliedCouponCard" class="border rounded p-3 d-none " style="background-color: #0095d91f;"> >
                                    {{-- Add applied coupon  --}}
                                </div>

                                <small id="coupon_message" class="d-block mt-1"></small>
                                 <a htrf="javascript:void(0);" id="viewAllCoupons"
                                        class="text-primary text-center w-100 mt-3">View All <i class="fa-solid fa-angle-right"></i>
                                    </a>

                            </div>

                        </div>


                        <div class="shop-cart-summary mt-4">

                            <h5>Payment Summary</h5>

                            <ul>

                                <li>

                                    <strong>Sub Total:</strong>

                                    <span id="subtotal_text">₹{{ number_format($subtotal, 2) }}</span>
                                    <input type="hidden" name="subtotal" id="subtotal_input" value="{{ $subtotal }}">
                                </li>

                                <li class="{{ $couponDiscount > 0 ? '' : 'd-none' }}">
                                    <strong>Coupon discount:</strong>

                                    <span id="coupon_discount_text">
                                        - ₹{{ isset($couponDiscount) ? number_format($couponDiscount, 2) : '0.00' }}
                                    </span>

                                    <input type="hidden"
                                        name="coupon_discount"
                                        id="coupon_discount_input"
                                        value="{{ $couponDiscount ?? 0 }}">
                                </li>


                                @if ($discount > 0)

                                <li>

                                    <strong>Discount:</strong>

                                    <span id="discount_text">₹{{ number_format($discount, 2) }}</span>
                                    <input type="hidden" name="discount" id="discount_input" value="{{ $discount }}">



                                </li>

                                @endif

                                @if ($tax > 0)

                                <li>

                                    <strong>Taxes:</strong>

                                    <span id="tax_text">₹{{ number_format($tax, 2) }}</span>
                                    <input type="hidden" name="tax" id="tax_input" value="{{ $tax }}">

                                </li>

                                @endif

                                <li class="shop-cart-total">

                                    <strong>Total:</strong>

                                    <span id="total_text">₹{{ number_format($total, 2) }}</span>
                                    <input type="hidden" name="total_amount" id="total_input" value="{{ $total }}">

                                </li>

                            </ul>


                            <div class="text-end mt-40">

                                <input type="hidden" name="selected_address_id" id="selected_address_id">

                                <input type="hidden" name="selected_lab_id" id="selected_lab_id">

                                <input type="hidden" name="booking_schedule_for" id="booking_schedule_for">

                                <input type="hidden" name="booking_scheduler_id" id="booking_scheduler_id">

                                <input type="hidden" name="booking_date" id="booking_date">

                                <input type="hidden" name="booking_time" id="booking_time">

                                <button id="checkout-btn" class="theme-btn">Checkout Now <i
                                        class="fas fa-arrow-right"></i></button>

                                <div id="checkout-error"
                                    class="text-danger mt-2 d-none">
                                </div>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- shop checkout end -->



</main>



<!-- information form  -->

<div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="addPatientModal" tabindex="-1"

    aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Patient</h1>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                <form action="javascript:void(0);" id="addPatientForm" class="contact-form shadow-none form-group">

                    <div class="form-card">

                        <div class="row g-4">

                            <!-- Patient Name -->

                            <div class="col-md-12">

                                <label class="label d-block mb-2">Patient Name</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>

                                    <input type="text" class="form-control shadow-none" name="name"

                                        placeholder="Patient Name" required>

                                </div>

                            </div>



                            <!-- Gender -->

                            <div class="col-md-12 col-lg-6">

                                <label class="label d-block mb-2">Gender</label>

                                <div class="d-flex gap-4 pt-1">

                                    <div class="form-check">

                                        <input type="radio" class="form-check-input shadow-none" name="gender"

                                            id="male" value="Male">

                                        <label class="form-check-label" for="male">Male</label>

                                    </div>

                                    <div class="form-check">

                                        <input type="radio" class="form-check-input shadow-none" name="gender"

                                            id="female" value="Female">

                                        <label class="form-check-label" for="female">Female</label>

                                    </div>

                                    <div class="form-check">

                                        <input type="radio" class="form-check-input shadow-none" name="gender"

                                            id="other_gender" value="Other">

                                        <label class="form-check-label" for="other_gender">Other</label>

                                    </div>

                                </div>

                            </div>



                            <!-- Email -->

                            <div class="col-md-12 col-lg-6">

                                <label for="inputEmail" class="form-label">Email</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>

                                    <input type="email" class="form-control shadow-none" id="inputEmail"

                                        name="email" placeholder="Enter Email" required>

                                </div>

                            </div>



                            <!-- Phone -->

                            <div class="col-md-12 col-lg-6">

                                <label for="inputPhone" class="form-label">Phone No</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>

                                    <input type="number" class="form-control shadow-none" id="inputPhone"

                                        name="phone" placeholder="Enter Phone No" required>

                                </div>

                            </div>



                            <!-- Date of Birth -->

                            <div class="col-md-12 col-lg-6">

                                <label for="inputdob" class="form-label">Date of Birth</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>

                                    <input type="date" class="form-control shadow-none" id="inputdob"

                                        name="dob" required>

                                </div>

                            </div>



                            <!-- Relation -->

                            <div class="col-md-12 col-lg-6">

                                <label for="booking_relation" class="form-label">Relation</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>

                                    <select name="relation" id="booking_relation"

                                        class="form-control shadow-none form-select" required>

                                        <option value="">--select--</option>

                                        <option value="Self">Self</option>

                                        <option value="Father">Father</option>

                                        <option value="Mother">Mother</option>

                                        <option value="Brother">Brother</option>

                                        <option value="Sister">Sister</option>

                                        <option value="Other">Other</option>

                                    </select>

                                </div>

                            </div>

                            <!-- Prescription Upload -->

                            <div class="col-md-12 col-lg-6" id="prescriptionField">

                                <label for="prescription" class="form-label">Upload Prescription (if any)</label>

                                <div class="input-group">

                                    <input type="file" id="prescription" multiple accept=".jpg,.jpeg,.png,.pdf"

                                        class="form-control">

                                    <br>

                                </div>

                                <div class="mt-2 p-1 bg-light rounded border border-dashed text-muted small">

                                    <div style="font-size: 10px;">

                                        <i class="fa-regular fa-circle-check text-success me-1"></i>

                                        <strong>JPG, PNG, PDF</strong> formats |

                                        <strong>Max 5MB</strong> |

                                    </div>

                                </div>

                            </div>



                        </div>

                    </div>

                    <!-- Submit Button -->

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


<div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="editPatientModal" tabindex="-1"

    aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Patient</h1>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                <form action="javascript:void(0);" id="editPatientForm" enctype="multipart/form-data" class="contact-form shadow-none form-group">
                    <input type="hidden" name="id" id="edit_patient_id">
                    <div class="form-card">

                        <div class="row g-4">

                            <!-- Patient Name -->

                            <div class="col-md-12">

                                <label class="label d-block mb-2">Patient Name</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>

                                    <input type="text" class="form-control shadow-none" name="editname"

                                        placeholder="Patient Name" required>

                                </div>

                            </div>



                            <!-- Gender -->

                            <div class="col-md-12 col-lg-6">

                                <label class="label d-block mb-2">Gender</label>

                                <div class="d-flex gap-4 pt-1">

                                    <div class="form-check">

                                        <input type="radio" class="form-check-input shadow-none" name="editgender"

                                            id="male" value="Male">

                                        <label class="form-check-label" for="male">Male</label>

                                    </div>

                                    <div class="form-check">

                                        <input type="radio" class="form-check-input shadow-none" name="editgender"

                                            id="female" value="Female">

                                        <label class="form-check-label" for="female">Female</label>

                                    </div>

                                    <div class="form-check">

                                        <input type="radio" class="form-check-input shadow-none" name="editgender"

                                            id="other_gender" value="Other">

                                        <label class="form-check-label" for="other_gender">Other</label>

                                    </div>

                                </div>

                            </div>



                            <!-- Email -->

                            <div class="col-md-12 col-lg-6">

                                <label for="inputEmail" class="form-label">Email</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>

                                    <input type="email" class="form-control shadow-none" id="inputEmail"

                                        name="editemail" placeholder="Enter Email" required>

                                </div>

                            </div>



                            <!-- Phone -->

                            <div class="col-md-12 col-lg-6">

                                <label for="inputPhone" class="form-label">Phone No</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>

                                    <input type="number" class="form-control shadow-none" id="inputPhone"

                                        name="editphone" placeholder="Enter Phone No" required>

                                </div>

                            </div>



                            <!-- Date of Birth -->

                            <div class="col-md-12 col-lg-6">

                                <label for="inputdob" class="form-label">Date of Birth</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>

                                    <input type="date" class="form-control shadow-none" id="inputdob"

                                        name="editdob" required>

                                </div>

                            </div>



                            <!-- Relation -->

                            <div class="col-md-12 col-lg-6">

                                <label for="booking_relation" class="form-label">Relation</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>

                                    <select name="editrelation" id="booking_relation"

                                        class="form-control shadow-none form-select" required>

                                        <option value="">--select--</option>

                                        <option value="Self">Self</option>

                                        <option value="Father">Father</option>

                                        <option value="Mother">Mother</option>

                                        <option value="Brother">Brother</option>

                                        <option value="Sister">Sister</option>

                                        <option value="Other">Other</option>

                                    </select>

                                </div>

                            </div>

                            <!-- Prescription Upload -->

                            <div class="col-md-12 col-lg-6" id="prescriptionField">

                                <label for="prescription" class="form-label">Upload Prescription (if any)</label>

                                <div class="input-group">

                                    <input type="file" id="prescription" multiple accept=".jpg,.jpeg,.png,.pdf"

                                        class="form-control">

                                    <br>

                                </div>

                                <div class="mt-2 p-1 bg-light rounded border border-dashed text-muted small">

                                    <div style="font-size: 10px;">

                                        <i class="fa-regular fa-circle-check text-success me-1"></i>

                                        <strong>JPG, PNG, PDF</strong> formats |

                                        <strong>Max 5MB</strong> |

                                    </div>

                                </div>

                            </div>



                        </div>

                    </div>

                    <!-- Submit Button -->

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

<!-- information form  -->

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

                                <label for="inputMap" class="form-label">Google Map Location</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>

                                    <input type="text" class="form-control shadow-none" id="google_map_location"

                                        name="google_map_location" placeholder="Paste Google Map Link" readonly>

                                </div>

                                <a href="javascript:void(0);"

                                    class="btn btn-sm btn-primary select-map-location w-100 mt-2" data-type="add"

                                    data-tooltip="tooltip" title="Click to select location on map"><i

                                        class="bi bi-geo-alt-fill"></i> Select location on map</a>

                            </div>



                            <!-- Address Type -->

                            <div class="col-md-6">

                                <label class="form-label d-block">Address Type</label>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="type" id="home"

                                        value="1" checked>

                                    <label class="form-check-label" for="home">Home</label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="type" id="work"

                                        value="2">

                                    <label class="form-check-label" for="work">Work</label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="type" id="other"

                                        value="3">

                                    <label class="form-check-label" for="other">Other</label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-12  mt-4 py-4">

                        <input type="hidden" id="latitude" name="latitude">

                        <input type="hidden" id="longitude" name="longitude">

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

                <form action="" id="editAddressForm" method="POST" action="javascript:void(0);"

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

                                <label for="inputMap" class="form-label">Google Map Location</label>

                                <div class="input-group">

                                    <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>

                                    <input type="text" class="form-control shadow-none"

                                        id="edit_google_map_location" name="google_map_location"

                                        placeholder="Paste Google Map Link" readonly>

                                    <a href="javascript:void(0);"

                                        class="btn btn-sm btn-primary select-map-location w-100 mt-2" data-type="edit"

                                        data-tooltip="tooltip" title="Click to select location on map"><i

                                            class="bi bi-geo-alt-fill"></i> Select location on map</a>

                                </div>

                            </div>



                            <!-- Address Type -->

                            <div class="col-md-6">

                                <label class="form-label d-block">Address Type</label>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="type" id="edit_home"

                                        value="1" checked>

                                    <label class="form-check-label" for="home">Home</label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="type" id="edit_work"

                                        value="2">

                                    <label class="form-check-label" for="work">Work</label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="type" id="edit_other"

                                        value="3">

                                    <label class="form-check-label" for="other">Other</label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-12  mt-4 py-4">

                        <input type="hidden" id="edit_latitude" name="latitude">

                        <input type="hidden" id="edit_longitude" name="longitude">

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
<!-- Add Package / Test -->
<div class="modal fade" id="addPackageModal" tabindex="-1">
    <div class="modal-dialog modal-xl  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Package / Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 align-items-center mb-3" style="justify-content: space-between;">
                    <!-- Search -->
                    <div class="col-12 col-md-auto order-1 order-md-2">
                        <input type="text"
                            id="packageSearchInput"
                            class="form-control p-2"
                            placeholder="Search tests or checkups">
                    </div>
                    <!-- Toggle -->
                    <div class="col-12 col-md-auto order-2 order-md-1">
                        <div class="btn-group w-100" role="group">
                            <button type="button"
                                class="btn btn-outline-primary active toggle-btn"
                                data-type="test">
                                Tests
                            </button>
                            <button type="button"
                                class="btn btn-outline-primary toggle-btn"
                                data-type="package">
                                Packages
                            </button>
                        </div>
                    </div>



                </div>

                <div style="overflow-x: hidden;" id="packageListContainer">
                    <!-- Packages AJAX se load honge -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Package / Test -->

{{-- Coupons list modal --}}
<div class="modal fade" id="viewAllCouponsModal" tabindex="-1">
    <div class="modal-dialog modal-md  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Coupon List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 align-items-center mb-3" style="justify-content: space-between;">
                    <!-- Search -->
                    <div class="col-12 order-1 order-md-2">
                        <input type="text"
                            id="coupnSearchInput"
                            class="form-control p-2"
                            placeholder="Enter Coupon code">
                    </div>




                </div>

                <div id="couponsListContainer">
                    <!-- Coupon AJAX se load honge -->
                </div>
            </div>
        </div>
    </div>
</div>

{{-- End coupone list --}}
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<script>
    window.hasPatients = @json($hasPatients);
    window.patientPackages = @json($patientPackages);

    function showAddPatientModal() {
        const modalEl = document.getElementById('addPatientModal');
        if (!modalEl) return;

        // ❌ Hide close button via JS
        const closeBtn = modalEl.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.style.display = 'none';
        }
        const modal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    }

    function initPatientsOnCheckout() {
        // ✅ render existing patients
        if (Array.isArray(patientPackages) && patientPackages.length > 0) {
            renderPatients();
        }

        // ❌ No patient → force modal
        if (hasPatients === false) {
            showAddPatientModal();
        }
    }

    // 🚀 call after DOM ready
    document.addEventListener('DOMContentLoaded', initPatientsOnCheckout);
</script>




<script>
    // Modal open + load coupons
    $('#viewAllCoupons').on('click', function () {
        $('#viewAllCouponsModal').modal('show');
        loadCoupons(); // initial load
    });

    // Search coupon
    $('#coupnSearchInput').on('keyup', function () {
        let keyword = $(this).val();
        loadCoupons(keyword);
    });

    function loadCoupons(search = '') {
        $.ajax({
            url: "{{ route('coupons.list') }}", // route banani hogi
            type: "GET",
            data: { search: search },
            beforeSend: function () {
                $('#couponsListContainer').html(
                    '<div class="text-center py-3">Loading coupons...</div>'
                );
            },
            success: function (response) {
                $('#couponsListContainer').html(response);
            },
            error: function () {
                $('#couponsListContainer').html(
                    '<div class="text-danger text-center py-3">Something went wrong</div>'
                );
            }
        });
    }


    // APPLY COUPON
   $(document).on('click', '#applyCouponBtn, .applyCouponBtn', function () {

        let code = '';
        //  Click class
        if ($(this).hasClass('applyCouponBtn')) {
            code = $(this).data('code');
        }

        // Clicked id
        if ($(this).attr('id') === 'applyCouponBtn') {
            code = $('#coupon_code').val().trim();
        }

        if (!code) {
            $('#coupon_message').text('Please enter coupon code').addClass('text-danger');
             Swal.close();
            return;
        }

        $.ajax({
            url: "{{ route('coupon.apply') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: code
            },
             beforeSend: function() {
                Swal.fire({
                    title: 'Coupon Applying...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
           success: function (res) {
             Swal.close();
                $('#viewAllCouponsModal').modal('hide')
                $('#couponLabel').addClass('d-none');

                appliedCoupon(res);
                updateCartSummary(res.paymentSummary);
            },
            error: function (xhr) {
                $('#coupon_message')
                    .text(xhr.responseJSON.message)
                    .addClass('text-danger');
                 $('#viewAllCouponsModal').modal('hide')
                Swal.close();
            }
        });
    });

    function appliedCoupon(res){
          const coupon = res.data ? res.data : res;

            if (!coupon) return;

                // hide input
                $('#coupon_code_container').addClass('d-none');

                let discountText = '';
                if (coupon.discount_type === 'percentage') {
                    discountText = `Discount: ${parseInt(coupon.discount_value)}%`;
                } else if (coupon.discount_type === 'flat') {
                    discountText = `Flat ₹${coupon.discount_value} off`;
                } else if (coupon.discount_type === 'free_delivery') {
                    discountText = `Free Delivery`;
                }

                let html = `
                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            <h6 class="mb-1">${coupon.code}</h6>
                            <small class="text-muted">${coupon.title ?? ''}</small><br>
                            <small class="text-success">${discountText}</small>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-sm btn-outline-danger" id="removeCouponBtn">
                                Remove
                            </button>
                        </div>

                    </div>
                `;

                $('#appliedCouponCard').html(html).removeClass('d-none');

                $('#coupon_message').text('').removeClass('text-danger');
    }

    // REMOVE COUPON
    $(document).on('click', '#removeCouponBtn', function () {
        removeCoupon ();
    });

    function removeCoupon () {
        $.ajax({
            url: "{{ route('coupon.remove') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
             beforeSend: function() {
            Swal.fire({
                title: 'Coupon Removing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
            success: function (res) {
                updateCartSummary(res.payment)
                $('#couponLabel').removeClass('d-none');
                $('#appliedCouponCard').addClass('d-none');
                $('#coupon_code_container').removeClass('d-none');
                $('#coupon_message').html('');
                $('#coupon_code').val('');
                Swal.close();
            }
        });
    }


    function updateCartSummary(res) {
        // TEXT UPDATE
        // console.log(res);
        $('#subtotal_text').text('₹' + res.subtotal.toFixed(2));
        $('#total_text').text('₹' + res.total.toFixed(2));

        // INPUT UPDATE
        $('#subtotal_input').val(res.subtotal);
        $('#total_input').val(res.total);

        // DISCOUNT
        if (res.couponDiscount > 0) {
            $('#coupon_discount_text').text('- ₹' + res.couponDiscount.toFixed(2));
            $('#coupon_discount_input').val(res.couponDiscount);
            $('#coupon_discount_text').closest('li').removeClass('d-none');
        } else {
            $('#coupon_discount_text').closest('li').addClass('d-none');
        }

        // DISCOUNT
        if (res.discount > 0) {
            $('#discount_text').text('₹' + res.discount.toFixed(2));
            $('#discount_input').val(res.discount);
            $('#discount_text').closest('li').show();
        } else {
            $('#discount_text').closest('li').hide();
        }

        // TAX
        if (res.tax > 0) {
            $('#tax_text').text('₹' + res.tax.toFixed(2));
            $('#tax_input').val(res.tax);
            $('#tax_text').closest('li').show();
        } else {
            $('#tax_text').closest('li').hide();
        }
    }
</script>


@if($appliedCoupon)
<script>
    $('#coupon_code_container').addClass('d-none');
    $('#couponLabel').addClass('d-none');
    appliedCoupon(@json($appliedCoupon));
     $('#appliedCouponCard').removeClass('d-none');
</script>
@endif


<script>
    function updateRemaining() {

        const checkboxes = document.querySelectorAll('.patient-checkbox');

        const selected = Array.from(checkboxes).filter(cb => cb.checked).length;

        document.getElementById('remainingCount').textContent = checkboxes.length - selected;

    }



    document.querySelectorAll('.patient-checkbox').forEach(cb => {

        cb.addEventListener('change', updateRemaining);

    });



    updateRemaining();



    const qtyInput = document.getElementById('quantityValue');



    function getTotalPatients() {

        return document.querySelectorAll('.patient-checkbox').length;

    }



    document.getElementById('increaseQuantityBtn').addEventListener('click', function() {

        const max = getTotalPatients();

        let current = parseInt(qtyInput.value);

        if (current < max) {

            qtyInput.value = current + 1;

        }

    });



    document.getElementById('decreaseQuantityBtn').addEventListener('click', function() {

        let current = parseInt(qtyInput.value);

        if (current > 1) {

            qtyInput.value = current - 1;

        }

    });
</script>

<script>
    $(document).ready(function() {

        // Initialize Owl Carousel

        $('#dateCarousel').owlCarousel({

            margin: 10,

            nav: true,

            dots: true,

            responsive: {

                0: {

                    items: 3

                },

                600: {

                    items: 5

                },

                1000: {

                    items: 8

                }

            }

        });



        // Toggle active time slot

        document.querySelectorAll('.time-slot').forEach(slot => {

            slot.addEventListener('click', () => {

                document.querySelectorAll('.time-slot').forEach(s => s.classList.remove(

                    'active'));

                slot.classList.add('active');

            });

        });


    });
</script>

<script>
    $(document).ready(function() {

        var current_fs, next_fs, previous_fs;

        var current = 1;

        var steps = $("fieldset").length;



        setProgressBar(current);



        $(".next").click(function() {

            const total = parseFloat($('#total_input').val()) || 0;

            if (total <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Total Amount',
                    text: 'Please select at least one package before proceeding.',
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000
                });
                return; // ❌ STOP NEXT STEP
            }

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



            setProgressBar(++current);

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

            setProgressBar(--current);

            $('html, body').animate({

                scrollTop: 0

            }, 300);

        });

        function setProgressBar(curStep) {

            var percent = parseFloat(100 / steps) * curStep;

            $(".progress-bar").css("width", percent.toFixed() + "%");

        }

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

                // alert("Form submitted successfully!"); // Replace with AJAX if needed

            }

        });

    });


    function getAge(dob) {

        const birthDate = new Date(dob);

        const diff = Date.now() - birthDate.getTime();

        const ageDate = new Date(diff);

        return Math.abs(ageDate.getUTCFullYear() - 1970);

    }
    const packages = @json($packages);

    let activePackageIndex = null;

    let editIndex = null;

    let allPatients = []; // make global
    let selectedPatient = null;

    let patientPackages = @json($patientPackages);
    // Initialize allPatients from packages
    function initPatients() {
        allPatients = [];

        // patientPackages comes from PHP backend
        if (!patientPackages || patientPackages.length === 0) return;

        patientPackages.forEach(p => {
            allPatients.push({
                ...p, // patient details
                packages: p.packages || [] // only the packages assigned to this patient
            });
        });
    }

    initPatients();

    // Render all patients and their assigned packages
    function renderPatients() {
        $('#packageAccordion').empty(); // clear previous content

         console.log(patientPackages);
        patientPackages.forEach((p, pIndex) => {

            // Build packages HTML for this patient only
            const packagesHtml = (p.packages || []).map(pkg => {
                const testsHtml = (pkg.tests && pkg.tests.length > 0) ? `
                    <ul class="list-group list-group-flush mb-2">
                        ${pkg.tests.map(t => `<li class="list-group-item p-1 small">${t.test_name} - ₹${t.price}</li>`).join('')}
                    </ul>
                ` : `<div class="small text-muted mb-2">No tests added yet</div>`;

                return `
                <div class="card mb-2 p-2 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <p class="small">${pkg.name}</p>
                            <p class="text-primary">₹${pkg.price}</p>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="deletePackage(${pkg.id}, ${p.id})"
                                title="Remove package">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                `;
            }).join('');

            const html = `
            <div class="accordion-item mb-3 shadow-sm rounded" id="patient-item-${p.id}">
                <h2 class="accordion-header d-flex bg-light pe-3 align-items-center" id="patient-heading-${pIndex}">
                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#patient-collapse-${pIndex}" aria-expanded="true">
                        <div class="d-flex w-100 align-items-center ">
                            <div>
                                <div class="fs-6 fw-bold text-dark">
                                    <i class="fa fa-user-circle text-primary me-1"></i>
                                    • ${p.name}
                                </div>
                            </div>

                        </div>
                    </button>
                    <div style="display: flex;height: fit-content;">
                                             <button class="btn btn-sm btn-outline-danger" type="button" onclick="deletePatient(${p.id})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                </h2>
                <div id="patient-collapse-${pIndex}" class="accordion-collapse collapse show" aria-labelledby="patient-heading-${pIndex}">
                    <div class="accordion-body">
                        <div class="row">
                            <!-- Patient Info -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="card p-3 h-100 border-end">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-semibold mb-0">Patient Details</h6>
                                        <div>
                                            <button class="btn btn-sm btn-outline-secondary me-1" type="button" onclick="editPatient(${p.id})">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                        </div>
                                    </div>
                                    <p class="mb-1"><strong>Age:</strong> ${p.age} yrs</p>
                                    <p class="mb-1"><strong>Gender:</strong> ${p.gender}</p>
                                    <p class="mb-2"><strong>Relation:</strong> ${p.relation}</p>
                                    <p class="mb-1"><strong>Phone:</strong> ${p.phone}</p>
                                    ${p.email ? `<p class="mb-1"><strong>Email:</strong> ${p.email}</p>` : ''}
                                    ${p.prescription ? `<p class="mb-0"><strong>Prescription:</strong> <a href="${p.prescription}" target="_blank" class="text-danger"><i class="fa fa-file-pdf"></i> View</a></p>` : ''}
                                </div>
                            </div>

                            <!-- Packages -->
                            <div class="col-md-6">
                                <div class="card p-3 h-100" >
                                <div id="patient-packages-${p.id}">
                                    <h6 class="fw-semibold mb-2">Packages</h6>
                                    ${packagesHtml}
                                </div>
                                    <button class="btn btn-outline-primary btn-sm mx-auto mt-4 " type="button" style="width: fit-content;" data-id="${p.id}" onclick="openAddPackageModal(${p.id}, ${pIndex})">
                                        + Add Package / Test
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;

            $('#packageAccordion').append(html);
        });
    }


    // render patients
    // renderPatients();

    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();
        let $btn = $(this);
        let patient_id = $('#packageListContainer').attr('data-pid');;
        let patient = allPatients[selectedPatientIndex];

    if (!patient) return;

    // ensure packages array
    if (!Array.isArray(patient.packages)) {
        patient.packages = [];
    }


        $.ajax({
            url: "{{ route('checkout.getPatientTest', '') }}/" + patient_id,
            type: 'GET',
            success: function(response) {
                // 🔑 allPatients mein update
                const patientIndex = allPatients.findIndex(
                    p => String(p.id) === String(patient.id)
                );

                if (patientIndex === -1) return;

                if (!Array.isArray(allPatients[patientIndex].packages)) {
                    allPatients[patientIndex].packages = [];
                }

                response.packages.forEach(pkg => {
                    const alreadyAdded = allPatients[patientIndex].packages.some(
                        p => String(p.id) === String(pkg.id)
                    );

                    if (!alreadyAdded) {
                        allPatients[patientIndex].packages.push(pkg);
                    }
                });

                // 2️⃣ patientPackages mein bhi same structure maintain karo
                // ✅ Pehle check karo ki ye patient already exist karta hai?
                let patientInGlobal = patientPackages.find(
                    p => String(p.id) === String(patient.id)
                );

                // ❌ Agar patient nahi hai, toh add karo
                if (!patientInGlobal) {
                    patientPackages.push({
                        id: patient.id,
                        name: patient.name,
                        // ...patient ki baaki details
                        packages: []
                    });
                    patientInGlobal = patientPackages[patientPackages.length - 1];
                }

                // ✅ Ab patient ke packages array mein push karo
                if (!Array.isArray(patientInGlobal.packages)) {
                    patientInGlobal.packages = [];
                }

                response.packages.forEach(pkg => {
                    const existsInPatientPackages = patientInGlobal.packages.some(
                        p => String(p.id) === String(pkg.id)
                    );

                    if (!existsInPatientPackages) {
                        patientInGlobal.packages.push(pkg);
                    }
                });

                $btn.fadeOut(200, function() {
                    $(this).replaceWith(`<span class="bg-primary-subtle text-primary p-2 px-3 rounded-2">Added</span>`);
                });
                // ✅ Only update package list UI
                renderPatientPackages(patient);
                // renderPatients();
                updateCartSummary(response);
            }
        });
    });


    function renderPatientPackages(patient) {
        // ✅ FIX 1: correct container id
        const container = $('#patient-packages-' + patient.id);
        if (!container.length) {
            console.warn('Container not found');
            return;
        }

        if (!Array.isArray(patient.packages) || patient.packages.length === 0) {
            container.html('<p class="text-muted small">No packages found</p>');
            return;
        }

        let html = '';

        patient.packages.forEach(pkg => {

            // ✅ safety check
            if (!pkg.id || !pkg.name) return;

            html += `
                <div class="card mb-2 p-2 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <p class="small mb-1">${pkg.name}</p>
                            <p class="text-primary mb-0">₹${pkg.price}</p>
                        </div>
                        <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            onclick="deletePackage(${pkg.id}, ${patient.id})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        container.html(html);
    }


    function editPatient(patientId) {
        // Find patient from packages array
        let patient, packageIndex;
        packages.forEach((pkg, idx) => {
            const p = pkg.patients.find(pt => pt.id === patientId);
            if (p) {
                patient = p;
                packageIndex = idx;
            }
        });

        if (!patient) return;

        // Fill form with patient data
        $('#edit_patient_id').val(patient.id);
        $('input[name="editname"]').val(patient.name);
        $('input[name="editphone"]').val(patient.phone);
        $('input[name="editdob"]').val(patient.dob);
        $('input[name="editemail"]').val(patient.email);
        $('select[name="editrelation"]').val(patient.relation);
        $(`input[name="editgender"][value="${patient.gender}"]`).prop('checked', true);

        editIndex = patientId; // store ID for update
        activePackageIndex = packageIndex;

        $('#editPatientModal').modal('show');
    }
    $('#editPatientForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData();

        // CSRF
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        // Patient ID
        formData.append('id', editIndex);

        // Normal fields
        formData.append('name', $('input[name="editname"]').val());
        formData.append('gender', $('input[name="editgender"]:checked').val());
        formData.append('phone', $('input[name="editphone"]').val());
        formData.append('email', $('input[name="editemail"]').val());
        formData.append('dob', $('input[name="editdob"]').val());
        formData.append('relation', $('select[name="editrelation"]').val());
        formData.append('age', getAge($('input[name="editdob"]').val()));

        // 🔥 Prescription files
        let files = $('#prescription')[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append('prescription[]', files[i]);
        }

        $.ajax({
            url: '/booking-patient/update/' + editIndex,
            type: 'POST',
            data: formData,
            contentType: false, // 🔥 REQUIRED
            processData: false, // 🔥 REQUIRED
            success: function(res) {

                if (!res.status) {
                    alert('Update failed');
                    return;
                }

                // 🔥 Update frontend patient
                patientPackages.forEach(pkg => {
                    pkg.patients = pkg.patients.map(p =>
                        p.id === res.patient.id ? res.patient : p
                    );
                });

                $('#editPatientModal').modal('hide');
                renderPatients();
            },
            error: function(err) {
                console.error(err);
                alert('Something went wrong');
            }
        });
    });


    function deletePatient(patientId) {
        Swal.fire({
            title: 'Remove Test?',
            text: 'This test will be removed for this patient only.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel',
            width: 350
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: `/booking-patient/delete/${patientId}`, // your Laravel route
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (!res.status) {
                        alert("Failed to delete patient");
                        return;
                    }
                    const index = patientPackages.findIndex(p => p.id === patientId);
                    if (index !== -1) {
                        patientPackages.splice(index, 1);
                    }

                    renderPatients();
                    updateCartSummary(res);

                    if (!res.hasPatients) {
                        $('#addPatientModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).modal('show');
                    }

                },
                error: function(err) {
                    console.error(err);
                    alert("Failed to delete patient");
                }
            });
        });
    }

    function deletePackage(packageId, patientId) {
        Swal.fire({
            title: 'Remove Test?',
            text: 'This test will be removed for this patient only.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel',
            width: 350
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "/cart/remove-package",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    package_id: packageId,
                    patient_id: patientId
                },
                success: function(res) {
                    if (!res.status) {
                        Swal.fire('Error', 'Failed to remove test', 'error');
                        return;
                    }
                    const patient = patientPackages.find(p => p.id === patientId);
                    if (patient) {
                        patient.packages = patient.packages.filter(pkg => pkg.id !== packageId);
                    }

                    // renderPatients();
                    renderPatientPackages(patient);
                    updateCartSummary(res);
                    // initPatientsOnCheckout();
                    updateCombinedCartCount();

                    if (!res.isCoupon) {
                        $('#appliedCouponCard').addClass('d-none');
                        $('#coupon_code_container').removeClass('d-none');
                        $('#couponLabel').removeClass('d-none');
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Removed',
                        text: 'Test removed successfully',
                        timer: 1200,
                        showConfirmButton: false,
                        width: 300
                    });
                },
                error: function() {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            });
        });
    }

    function openAddPatientModal(pkgIndex, isPrescriptionRequired = 0) {

        activePackageIndex = pkgIndex;

        editIndex = null;
        $('#addPatientForm')[0].reset();

        $('#addPatientModal').modal('show');



        if (isPrescriptionRequired == 1) {

            $('#prescriptionField').show();

        } else {

            $('#prescriptionField').hide();

        }

    }

    function increaseQuantity(pkgIndex) {

        packages[pkgIndex].quantity++;

        renderPatients();
        updateTotal();

    }

    function decreaseQuantity(pkgIndex) {

        if (packages[pkgIndex].quantity > 1) {

            packages[pkgIndex].quantity--;

            // Trim patients if needed

            if (packages[pkgIndex].patients.length > packages[pkgIndex].quantity) {

                packages[pkgIndex].patients.splice(packages[pkgIndex].quantity);

            }

            renderPatients();
            updateTotal();
        }

    }

    let selectedFiles = [];

    document.getElementById('prescription').addEventListener('change', function() {

        selectedFiles = Array.from(this.files);

        document.getElementById('file-name').textContent =

            selectedFiles.length > 0 ? `${selectedFiles.length} file(s) selected` : 'No file chosen';

    });

    async function mergeFilesToPDF(files) {

        const {

            PDFDocument

        } = PDFLib;

        const pdfDoc = await PDFDocument.create();

        for (const file of files) {

            const fileType = file.type;

            if (fileType.startsWith('image/')) {

                const imgBytes = await file.arrayBuffer();

                let img;

                if (fileType === 'image/png') {

                    img = await pdfDoc.embedPng(imgBytes);

                } else {

                    img = await pdfDoc.embedJpg(imgBytes);

                }

                const page = pdfDoc.addPage([img.width, img.height]);
                page.drawImage(img, {

                    x: 0,

                    y: 0,

                    width: img.width,

                    height: img.height,

                });

            } else if (fileType === 'application/pdf') {
                const existingPdfBytes = await file.arrayBuffer();

                const donorPdf = await PDFDocument.load(existingPdfBytes);

                const copiedPages = await pdfDoc.copyPages(donorPdf, donorPdf.getPageIndices());

                copiedPages.forEach(p => pdfDoc.addPage(p));
            }
        }

        const mergedPdfBytes = await pdfDoc.save();

        return new Blob([mergedPdfBytes], {

            type: 'application/pdf'

        });

    }

    // ✅ YAHAN ADD KARNA H (TOP)
    function blobToBase64(blob) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result);
            reader.readAsDataURL(blob);
        });
    }


    $('#addPatientForm').on('submit', async function(e) {
        e.preventDefault();

        const name = $('input[name="name"]').val();
        const gender = $('input[name="gender"]:checked').val();
        const phone = $('input[name="phone"]').val();
        const email = $('input[name="email"]').val();
        const dob = $('input[name="dob"]').val();
        const relation = $('select[name="relation"]').val();
        const age = getAge(dob);

        let prescription = null;

        if (selectedFiles.length > 0) {
            const mergedPdfBlob = await mergeFilesToPDF(selectedFiles);
            prescription = await blobToBase64(mergedPdfBlob);
        }

        const payload = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            name,
            gender,
            phone,
            email,
            dob,
            relation,
            age,
            prescription
        };

        $.ajax({
            url: "/booking-patient/store",
            type: "POST",
            data: payload,
            beforeSend: function() {
                Swal.fire({
                    title: 'Patient adding...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(res) {
                Swal.close();
                res2 = JSON.stringify(res);
                // console.log(res2);
                if (!res.status) return;

                patientPackages.push({
                    ...res.patient,

                });

                $('#addPatientModal').modal('hide');


                // 👉 New patient render
                renderPatients(patientPackages[patientPackages.length - 1], patientPackages.length - 1);

                // 👉 AUTO OPEN newly added patient accordion
                setTimeout(() => {
                    $(`#patient-heading-${patientPackages.length - 1} button`).click();
                }, 200);
                updateCartSummary(JSON.parse(res2));
                // renderPatientPackages();
                initPatientsOnCheckout();

            },
            error: function(err) {
                alert("Patient save failed");
                console.error(err);
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
            // console.log(xhr);
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
                                       data-type="${address.type}"
                                       data-latitude="${address.latitude}"
                                       data-longitude="${address.longitude}"
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

    // get Address
    fetchAddresses();

    // Edit Address
    $(document).on('click', '.edit-address-btn', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_address').val($(this).data('address'));
        $('#edit_city').val($(this).data('city'));
        $('#edit_state').val($(this).data('state'));
        $('#edit_country').val($(this).data('country'));
        $('#edit_pin').val($(this).data('pin'));
        $('#edit_google_map_location').val($(this).data('map'));
        $('#edit_latitude').val($(this).data('latitude'));
        $('#edit_longitude').val($(this).data('longitude'));

        let type = $(this).data('type'); // 1, 2, or 3
        $("input[name='type'][value='" + type + "']").prop('checked', true);
        $('#editAddressModal').modal('show');
    });

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
                // console.log(xhr);
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
    });


    function fetchLabs(page = 1) {
        var patient_address_id = $('.address.active').data('id');
        if (!patient_address_id) {
            console.warn('No address selected');
            return;
        }

        $.ajax({
            url: "{{ route('labs.fetch') }}",
            method: 'GET',
            data: {
                address_id: patient_address_id,
                page: page
            },
            success: function(response) {
                // console.log(response);
                let html = '';
                let labs = response.data; // ✅ pagination fix

                if (!labs || labs.length === 0) {
                    html = '<p>No labs available.</p>';
                } else {
                    labs.forEach(function(lab) {
                        const address =
                            `${lab.street_address}, ${lab.city}, ${lab.state} - ${lab.postal_code}`;
                        const homeSample = lab.home_sample_collection === 'Yes' ?
                            `<div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-success bg-opacity-10 text-success rounded-pill" style="font-size:12px;">
                               <i class="bi bi-house-heart-fill"></i> Home Sample Available
                           </div>` :
                            `<div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-danger bg-opacity-10 text-danger rounded-pill" style="font-size:12px;">
                               <i class="bi bi-x-circle-fill"></i> Home Sample Not Available
                           </div>`;

                        html += `
                    <div class="col">
                        <div class="card h-100 border lab-card shadow-sm select-lab-btn"
                             data-id="${lab.lab_id}"
                             id="lab-card-${lab.lab_id}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="${lab.lab_logo}" class="rounded-circle me-3 border" style="width:50px;height:50px;">
                                    <h5 class="mb-0 text-primary">${lab.lab_name}</h5>
                                </div>
                                <hr>
                                <p class="text-muted">${address}</p>
                                ${homeSample}
                                <p class="powered-by text-center mt-2 text-muted" style="font-size:10px;">
                                    <span>Powered by</span>
                                    <a href="{{ url('/') }}" class="text-primary fw-bold" target="_blank">OurLabz</a>
                                </p>
                            </div>
                        </div>
                    </div>`;
                    });
                }

                $('#labContainer').html(html);
                renderPagination(response); // optional
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }


    function renderPagination(res) {
        let html = '';

        for (let i = 1; i <= res.last_page; i++) {
            html += `
            <button class="btn btn-sm ${i === res.current_page ? 'btn-primary' : 'btn-outline-primary'} page-btn"
                data-page="${i}">
                ${i}
            </button>
        `;
        }

        $('#pagination').html(html);
    }

    $(document).on('click', '.page-btn', function() {
        fetchLabs($(this).data('page'));
    });


    $(document).on('click', '.select-lab-btn', function() {
        const labId = $(this).data('id');
        $('#selected_lab_id').val(labId);
        $('.lab-card').removeClass('active');
        $(`#lab-card-${labId}`).addClass('active');
    });

    $(document).ready(function() {
        let selectedType = null;
        let selectedDate = null;
        let selectedTime = null;
        let schedulerId = null;

        function initCarousel() {
            $('#dateCarousel').owlCarousel({
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 5
                    },
                    1000: {
                        items: 8
                    }
                }
            });
        }

        $(document).on('change', 'input[name="schedule_for"]', function() {
            selectedType = $(this).val();
            schedulerId = $('#selected_lab_id').val();
            $('#booking_schedule_for').val(selectedType);

            if (!schedulerId) {
                Swal.fire('Please select a lab first');
                return;
            }

            loadSchedules(selectedType, schedulerId);
        });

        function loadSchedules(schedulingFor, schedulerId) {
            $.ajax({
                url: "{{ route('lab.schedule.dates') }}",
                type: 'POST',
                data: {
                    scheduling_for: schedulingFor,
                    scheduler_id: schedulerId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    let html = '';
                    const today = new Date().setHours(0, 0, 0, 0);

                    data.forEach(item => {
                        const itemDate = new Date(item.date).setHours(0, 0, 0, 0);
                        const isPast = itemDate < today;
                        const day = item.day.substring(0, 3);
                        const dateNum = new Date(item.date).getDate();

                        html += `
                        <div class="item">
                            <div class="day-button text-center ${isPast ? 'text-danger disabled-date' : ''}"
                                 data-date="${item.date}" data-scheduler_id="${schedulerId}"
                                 ${isPast ? 'style="pointer-events: none; opacity: 0.6;"' : ''}>
                                <div>${day}</div>
                                <div class="fw-bold fs-5 mt-0">${dateNum}</div>
                            </div>
                        </div>
                    `;
                    });

                    $('#dateCarousel').trigger('destroy.owl.carousel').html(html);

                    initCarousel();
                    selectedDate = null;
                    selectedTime = null;
                    $('#booking_time').val('');
                    $('#booking_date').val('');
                    dayGreetingsToggle ();
                    $('#timeSlotContainer').html('');
                },
                error: function() {
                    Swal.fire("Error!", "Could not load dates.", "error");
                }
            });
        }

        $(document).on('click', '.day-button:not(.disabled-date)', function() {
            $('.day-button').removeClass('day-selected');
            $(this).addClass('day-selected');
            selectedDate = $(this).data('date');
            $('#booking_date').val(selectedDate);
            $('#nav-tab .nav-link').removeClass('active');
            $('#nav-tab .nav-link[data-period="morning"]').addClass('active');
            // console.log('Morning forced active');
            selectedTime = null;
            $('#booking_time').val('');
            $('#scheduleBtn').addClass('disabled').attr('disabled', true);
            dayGreetingsToggle ();
        });


        $('#nav-tab button').on('click', function() {
            selectedTime = null;
            $('#booking_time').val('');
            dayGreetingsToggle (this)
        });

        function dayGreetingsToggle (element = null) {
            $('#nav-tab button').removeClass('active');
            let period = 'morning';
            if (element) {
                $(element).addClass('active');
                period = $(element).data('period');
            } else {
                $('[data-period="morning"]').addClass('active');
            }
            loadSlots(period);
        }

        function loadSlots(period) {
            if (!selectedType || !selectedDate || !schedulerId) return;
            $.ajax({
                url: "{{ route('lab.schedule.slots') }}",
                type: 'POST',
                data: {
                    scheduling_for: selectedType,
                    date: selectedDate,
                    scheduler_id: schedulerId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    const now = new Date();
                    const isToday = new Date(selectedDate).toDateString() === now.toDateString();
                    // const status = typeof t === 'string' ? 1 : t.status;
                    const slots = data[period] || [];
                    let html = '';
                    slots.forEach(t => {
                        const timeStr = typeof t === 'string' ? t : t.time;
                        const available = typeof t === 'string' ? 1 : t.available_slots;
                        const status = t.status;
                        const slotTime = new Date(`${selectedDate} ${timeStr}`);
                        const isPast = isToday && slotTime < now;
                        const isZero = available === 0;
                        const isInactive = status == 0;
                        const disabled = isPast || isZero || isInactive;

                        html += `
                        <div class="time-slot ${disabled ? 'disabled-slot text-danger' : 'text-success'}"
                             style="${disabled ? 'pointer-events: none; opacity: 0.6;' : ''}"
                             data-time="${timeStr}">
                            ${timeStr} <br>
                             <!-- <span class="slot-count">(${available} slot${available !== 1 ? 's' : ''})</span> -->
                        </div>
                    `;
                    });
                    $('#timeSlotContainer').html(html);
                },
                error: function() {
                    Swal.fire("Error!", "Could not load time slots.", "error");
                }
            });

        }

        $(document).on('click', '.time-slot:not(.disabled-slot)', function() {
            $('.time-slot').removeClass('active');
            $(this).addClass('active');
            selectedTime = $(this).data('time');
            $('#booking_time').val(selectedTime);
            $('#booking_scheduler_id').val(schedulerId);

            if (selectedType && selectedDate && selectedTime) {
                $('#scheduleBtn').removeClass('disabled').removeAttr('disabled');
            }
            checkIfAllBookingFieldsFilled();
        });

        initCarousel();
    });



    function showCheckoutError(message) {
        $('#checkout-error')
            .text(message)
            .removeClass('d-none');
    }

    function hideCheckoutError() {
        $('#checkout-error')
            .addClass('d-none')
            .text('');
    }

    function checkIfAllBookingFieldsFilled() {
        const fields = [
            '#selected_address_id',
            '#selected_lab_id',
            '#booking_schedule_for',
            '#booking_scheduler_id',
            '#booking_date',
            '#booking_time'
        ];

        let allFilled = fields.every(selector => {
            const val = $(selector).val();
            return val !== undefined && val !== null && val.trim() !== '';
        });

        // $('#checkout-btn').prop('disabled', !allFilled);
    }

    // Attach check on input changes (even though they're hidden, update them in JS after values are set)
    $(document).on('change',
        '#selected_address_id, #selected_lab_id, #booking_schedule_for, #booking_scheduler_id, #booking_date, #booking_time',
        function() {
            checkIfAllBookingFieldsFilled();
            hideCheckoutError();
        });

    // Optionally run once on page load
    $(document).ready(function() {
        checkIfAllBookingFieldsFilled();
    });

    $('#checkout-btn').on('click', async function() {
        // Basic validations
        // if (!$('#selected_lab_id').val() || !$('#booking_date').val() || !$('#booking_time').val()) {
        //     Swal.fire('Error', 'Please complete all booking details', 'error');
        //     return;
        // }

        hideCheckoutError();

        if (!$('#selected_address_id').val()) {
            showCheckoutError('Please select a address to continue');
            return;
        }

        if (!$('#selected_lab_id').val()) {
            showCheckoutError('Please select a lab to continue');
            return;
        }

        if (!$('#booking_schedule_for').val()) {
            showCheckoutError('Please select a collection method to continue');
            return;
        }

        if (!$('#booking_date').val()) {
            showCheckoutError('Please select booking date to continue');
            return;
        }

        if (!$('#booking_time').val()) {
            showCheckoutError('Please select booking time to continue');
            return;
        }

        Swal.fire({
            title: 'Checking Slot Availability...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const checkRes = await fetch("{{ route('check.slot') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                scheduler_id: $('#booking_scheduler_id').val(),
                date: $('#booking_date').val(),
                time: $('#booking_time').val()
            })
        });

        const slotData = await checkRes.json();

        if (!slotData.available) {
            Swal.fire('Error', slotData.message, 'error');
            return; // Stop booking
        }

        Swal.fire({
            title: 'Processing Payment...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        // Step 1️⃣ — Create Razorpay order
        const totalAmount = $('input[name="total_amount"]').val();

        try {
            const razorRes = await fetch('/razorpay/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: totalAmount,
                    type: 'test' // important!
                })
            });

            const data = await razorRes.json();
            Swal.close();

            if (!data.order_id) {
                Swal.fire('Error', 'Failed to initiate payment', 'error');
                return;
            }

            // Step 2️⃣ — Open Razorpay window
            const options = {

                key: "{{ config('services.razorpay.key') }}",

                amount: data.amount,

                currency: data.currency,

                order_id: data.order_id,

                name: "OurLabz",

                description: "Lab Test Booking Payment",

                prefill: {
                    name: "{{ auth()->user()->name ?? '' }}",
                    email: "{{ auth()->user()->email ?? '' }}",
                    contact: "{{ auth()->user()->phone ?? '' }}" // user's phone number
                },

                theme: {

                    color: "#528FF0"

                },

                handler: async function(response) {

                    // ✅ Step 0️⃣ — Check if slot is still available

                    // Step 3️⃣ — Payment Success, now book the test

                    Swal.fire({

                        title: 'Finalizing Booking...',

                        allowOutsideClick: false,

                        didOpen: () => Swal.showLoading()

                    });



                    const formData = new FormData();

                    formData.append('lab_id', $('#selected_lab_id').val());

                    formData.append('schedule_for', $('#booking_schedule_for').val());

                    formData.append('date', $('#booking_date').val());

                    formData.append('time', $('#booking_time').val());

                    formData.append('address', $('#selected_address_id').val());

                    formData.append('subtotal', $('input[name="subtotal"]').val());

                    formData.append('discount', $('input[name="discount"]').val());

                    formData.append('coupon_discount', $('input[name="coupon_discount"]').val());

                    formData.append('tax', $('input[name="tax"]').val());

                    formData.append('total_amount', totalAmount);

                    formData.append('payment_status', 'Paid');

                    formData.append('razorpay_payment_id', response.razorpay_payment_id);

                    formData.append('razorpay_order_id', response.razorpay_order_id);

                    formData.append('razorpay_signature', response.razorpay_signature);



                    // Attach package + patient data

                    packages.forEach((pkg, pkgIndex) => {

                        formData.append(`packages[${pkgIndex}][package_id]`, pkg

                            .package_id);

                        formData.append(`packages[${pkgIndex}][name]`, pkg.name);

                        formData.append(`packages[${pkgIndex}][price]`, pkg.price);



                        pkg.patients.forEach((p, patientIndex) => {


                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][id]`,
                                p.id);
                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][name]`,

                                p.name);

                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][gender]`,

                                p.gender);

                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][phone]`,

                                p.phone);

                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][email]`,

                                p.email);

                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][dob]`,

                                p.dob);

                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][relation]`,

                                p.relation);

                            formData.append(

                                `packages[${pkgIndex}][patients][${patientIndex}][age]`,

                                p.age);



                            if (p.prescription && p.prescription.startsWith(

                                    'data:application/pdf')) {

                                const blob = dataURLtoBlob(p.prescription);

                                formData.append(

                                    `packages[${pkgIndex}][patients][${patientIndex}][prescription]`,

                                    blob,

                                    `prescription_${pkgIndex}_${patientIndex}.pdf`

                                );

                            }

                        });

                    });



                    // Step 4️⃣ — Save booking after payment success

                    $.ajax({

                        url: "{{ route('booking.store') }}",

                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': '{{ csrf_token() }}'

                        },

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(res) {

                            Swal.fire({

                                icon: 'success',

                                title: 'Booking Confirmed!',

                                text: res.message

                            }).then(() => window.location.href =

                                '/user/booking-list');

                        },

                        error: function(xhr) {

                            Swal.fire('Error', xhr.responseJSON?.message ||

                                'Booking failed', 'error');

                        }

                    });

                }

            };



            const rzp = new Razorpay(options);

            rzp.open();



        } catch (err) {

            Swal.close();

            Swal.fire('Error', 'Something went wrong while initiating payment', 'error');

            console.error(err);

        }

    });





    $(document).on('click', '.select-map-location', function(e) {

        e.preventDefault();

        selectedType = $(this).data('type');

        if (selectedType == 'add') {

            $('#addAddressModal').modal('hide');

            $('#mapModal').modal('show');

            $('#save-location-btn').data('open', 'addAddressModal');



        } else if (selectedType == 'edit') {

            $('#editAddressModal').modal('hide');

            $('#mapModal').modal('show');

            $('#save-location-btn').data('open', 'editAddressModal');

        }

        setTimeout(() => {

            initMap();

        }, 500);

    });



    $('#mapModal').on('shown.bs.modal', function() {

        initMap();

    });



    $(document).on('click', '[data-open]', function() {

        let target = $(this).data('open'); // e.g. "addAddressModal"

        let modalId = '#' + target;



        // Wait until mapModal fully closes, then open the next modal

        $('#mapModal').on('hidden.bs.modal', function() {

            $(modalId).modal('show');

            $(this).off('hidden.bs.modal'); // remove to prevent duplicate triggers

        });

    });
</script>
<script>
    let selectedPatientIndex = null;

    function openAddPackageModal(pid, pIndex) {
        selectedPatientIndex = pIndex;

        const container = $('#packageListContainer');
        container.html('<p class="text-center">Loading packages...</p>');

        // Set pid as data-id
        container.attr('data-pid', pid);
        // AJAX request to get packages from backend
        $.ajax({
            url: '/lab-test?from=lab-checkout', // Laravel route jo aapke labTest controller me point kare
            type: 'GET',
            data: {
                ajax: 1
            }, // controller me if($request->ajax()) use ho raha hai
            success: function(response) {
                container.empty();
                // response me package_list blade render aayega
                container.html(response);
                // CSS classes replace karna
                container.find('.row').first()
                    .removeClass('row-cols-1 row-cols-md-2 row-cols-lg-3 g-3')
                    .addClass('row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3 g-3 test-modal');

                applyPatientWisePackageControl();
            },
            error: function(err) {
                container.html('<p class="text-danger text-center">Failed to load packages. Please try again.</p>');
                console.error(err);
            }
        });

        // Show modal
        new bootstrap.Modal('#addPackageModal').show();
    }

    // Delegate click because buttons are dynamic

    function applyPatientWisePackageControl() {

        // 👇 currently selected patient
        const patient = patientPackages[selectedPatientIndex];
        if (!patient) return;

        // 👇 already assigned package IDs for this patient
        const assignedPackageIds = (patient.packages || []).map(p => p.id);

        // loop through each package card
        $('#packageListContainer .card').each(function() {

            const addBtn = $(this).find('.add-to-cart');
            const qtySelect = $(this).find('.update-qty');

            let packageId = null;

            if (addBtn.length) {
                packageId = parseInt(addBtn.data('id'));
            } else if (qtySelect.length) {
                packageId = parseInt(qtySelect.data('id'));
            }

            if (!packageId) return;

            // ✅ Package already assigned to this patient
            if (assignedPackageIds.includes(packageId)) {
                addBtn.hide();
                qtySelect.hide();

                // optional: show badge
                if (!$(this).find('.assigned-badge').length) {
                    $(this).find('.cart-action').append(
                        `<span class="bg-primary-subtle text-primary p-2 px-3 rounded-2">Added</span>`
                    );
                }
            } else {
                // ❌ Not assigned → show add button
                addBtn.show();
                qtySelect.show();
                $(this).find('.assigned-badge').remove();
            }
        });
    }




    // Delegate click because pagination links are dynamic
    $(document).on('click', '#packageListContainer .pagination a', function(e) {
        e.preventDefault(); // page reload prevent
        let url = $(this).attr('href');

        const container = $('#packageListContainer');
        container.html('<p class="text-center">Loading packages...</p>');

        // AJAX request to get new page
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                ajax: 1
            }, // to trigger controller AJAX response
            success: function(response) {
                container.empty();
                container.html(response);

                // Optional: update row classes if needed
                container.find('.row').first()
                    .removeClass('row-cols-1 row-cols-md-2 row-cols-lg-3 g-3')
                    .addClass('row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3 g-3');
            },
            error: function(err) {
                container.html('<p class="text-danger text-center">Failed to load packages. Please try again.</p>');
                console.error(err);
            }
        });
    });


    let currentFilter = 'test';
    let currentSearch = '';

    function loadPackages(pageUrl = '/lab-test') {
        const container = $('#packageListContainer');
        container.html('<p class="text-center my-3">Loading...</p>');

        $.ajax({
            url: pageUrl,
            type: 'GET',
            data: {
                ajax: 1,
                type: currentFilter ? [currentFilter] : [], // ✅ ARRAY
                search: currentSearch
            },
            success: function(response) {
                container.html(response);

                container.find('.row').first()
                    .removeClass('row-cols-1 row-cols-md-2 row-cols-lg-3 g-3')
                    .addClass('row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3 g-3');
            },
            error: function() {
                container.html(
                    '<p class="text-danger text-center">Failed to load packages.</p>'
                );
            }
        });
    }
</script>

<script>
    $(document).on('click', '.toggle-btn', function() {
        $('.toggle-btn').removeClass('active');
        $(this).addClass('active');

        currentFilter = $(this).data('type'); // test / package
        loadPackages();
    });
</script>
<script>
    let searchTimer;

    $('#packageSearchInput').on('input', function() {
        clearTimeout(searchTimer);
        currentSearch = $(this).val();

        searchTimer = setTimeout(() => {
            loadPackages();
        }, 300);
    });
</script>

@endsection
