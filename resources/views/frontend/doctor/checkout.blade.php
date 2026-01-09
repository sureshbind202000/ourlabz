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

            padding: 10px;

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



        /* modal  */

        .form-label {

            color: #0d6efd;

            /* Bootstrap primary blue */

        }



        .input-group-text {

            background-color: #e9f2ff;

            border-color: #a6c8ff;

            color: #0d6efd;

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

                                <div class="card p-4 mb-3 shadow-sm">

                                    <form class="">

                                        <!-- fieldsets -->

                                        <fieldset>

                                            <div class="form-card">

                                                <div class="row">

                                                    <div class="col-7">

                                                        <h2 class="fs-title fw-bold">Addresses </h2>

                                                    </div>

                                                </div>

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

                                                <div id="prescriptionUploadWrapper" class="mt-4">

                                                    <label for="prescription_upload"

                                                        class="form-label fw-semibold text-dark">

                                                        <i class="fa-solid fa-file-medical me-1 text-primary"></i> Upload

                                                        Prescription / Report <small class="text-muted">(if any)</small>

                                                    </label>



                                                    <input type="file" name="prescription_upload[]"

                                                        id="prescription_upload" class="form-control border-primary"

                                                        accept=".jpg,.jpeg,.png,.pdf" multiple>



                                                    <div class="mt-2 p-2 bg-light rounded border border-dashed">

                                                        <ul class="mb-0 text-muted small">

                                                            <li><i class="fa-regular fa-circle-check text-success me-1"></i>

                                                                Allowed formats: <strong>JPG, PNG, PDF</strong></li>

                                                            <li><i class="fa-regular fa-circle-check text-success me-1"></i>

                                                                Max file size: <strong>5MB</strong></li>

                                                            <li><i class="fa-regular fa-circle-check text-success me-1"></i>

                                                                Upload only if required by doctor</li>

                                                        </ul>

                                                    </div>

                                                </div>



                                            </div>

                                        </fieldset>

                                        <input type="hidden" name="booking_schedule_for" id="booking_schedule_for"

                                            value="{{ $data['booking_schedule_for'] }}">

                                        <input type="hidden" name="booking_scheduler_id" id="booking_scheduler_id"

                                            value="{{ $data['booking_scheduler_id'] }}">

                                        <input type="hidden" name="booking_date" id="booking_date"

                                            value="{{ $data['booking_date'] }}">

                                        <input type="hidden" name="booking_time" id="booking_time"

                                            value="{{ $data['booking_time'] }}">

                                        <input type="hidden" name="selected_address_id" id="selected_address_id">

                                        <input type="hidden" name="subtotal" id="subtotal"

                                            value="{{ number_format($data['subtotal'], 2) }}">

                                        <input type="hidden" name="discount" id="discount"

                                            value="{{ number_format($data['discount'], 2) }}">

                                        <input type="hidden" name="tax" id="tax"

                                            value="{{ number_format($data['tax'], 2) }}">

                                        <input type="hidden" name="total" id="total"

                                            value="{{ number_format($data['total'], 2) }}">

                                        <input type="hidden" name="price" id="price">

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="shop-cart-summary mt-0">

                                <h5>Cart Summary</h5>

                                <ul>

                                    <li><strong>Sub Total:</strong> <span> ₹{{ number_format($data['subtotal'], 2) }}</span>

                                    </li>
                                    @if ($data['discount'] > 0)
                                    <li><strong>Discount:</strong> <span>₹{{ number_format($data['discount'], 2) }}</span></li>
                                    @endif
                                    @if ($data['tax'] > 0)
                                    <li><strong>Taxes:</strong> <span>₹{{ number_format($data['tax'], 2) }}</span></li>
                                    @endif
                                    <li class="shop-cart-total"><strong>Total:</strong>

                                        <span>₹{{ number_format($data['total'], 2) }}</span>

                                    </li>

                                </ul>

                                <div class="form-group mt-3">

                                    <label for="coupon_code" class="form-label fw-semibold text-primary">Have a Coupon?</label>

                                    <div class="input-group">

                                        <input type="text" id="coupon_code" class="form-control"

                                            placeholder="Enter coupon code">

                                        <button type="button" id="apply_coupon_btn"

                                            class="btn btn-primary">Apply</button>

                                    </div>

                                    <small id="coupon_message" class="text-muted d-block mt-1"></small>

                                </div>

                                <div class="text-end mt-4">

                                    <a href="javascript:void(0)" class="theme-btn checkoutbtn">Checkout Now<i

                                            class="fas fa-arrow-right"></i></a>

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

    <div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="information" tabindex="-1"

        aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Patient</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form action="" class="contact-form shadow-none form-group" novalidate>

                        <div class="form-card">

                            <div class="row g-4">

                                <!-- Patient Name -->

                                <div class="col-12">

                                    <label class="form-label fw-semibold" for="patientName">Patient Name</label>

                                    <div class="input-group">

                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>

                                        <input type="text" class="form-control" id="patientName" name="name"

                                            placeholder="Patient Name" required />

                                    </div>

                                </div>



                                <!-- Gender -->

                                <div class="col-12 col-lg-6">

                                    <label class="form-label fw-semibold d-block mb-2">Gender</label>

                                    <div class="d-flex gap-4">

                                        <div class="form-check">

                                            <input class="form-check-input" type="radio" name="gender" id="male"

                                                value="Male" required />

                                            <label class="form-check-label" for="male">Male</label>

                                        </div>

                                        <div class="form-check">

                                            <input class="form-check-input" type="radio" name="gender" id="female"

                                                value="Female" />

                                            <label class="form-check-label" for="female">Female</label>

                                        </div>

                                        <div class="form-check">

                                            <input class="form-check-input" type="radio" name="gender"

                                                id="other_gender" value="Other" />

                                            <label class="form-check-label" for="other_gender">Other</label>

                                        </div>

                                    </div>

                                </div>



                                <!-- Email -->

                                <div class="col-12 col-lg-6">

                                    <label for="inputEmail" class="form-label fw-semibold">Email</label>

                                    <div class="input-group">

                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>

                                        <input type="email" class="form-control" id="inputEmail" name="email"

                                            placeholder="Enter Email" required />

                                    </div>

                                </div>



                                <!-- Phone -->

                                <div class="col-12 col-lg-6">

                                    <label for="inputPhone" class="form-label fw-semibold">Phone No</label>

                                    <div class="input-group">

                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>

                                        <input type="tel" class="form-control" id="inputPhone" name="phone"

                                            placeholder="Enter Phone No" pattern="[0-9+()-\s]+" required />

                                    </div>

                                </div>



                                <!-- Date of Birth -->

                                <div class="col-12 col-lg-6">

                                    <label for="inputdob" class="form-label fw-semibold">Date of Birth</label>

                                    <div class="input-group">

                                        <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>

                                        <input type="date" class="form-control" id="inputdob" name="dob"

                                            required />

                                    </div>

                                </div>



                                <!-- Relation -->

                                <div class="col-12 col-lg-6">

                                    <label for="booking_relation" class="form-label fw-semibold">Relation</label>

                                    <select name="relation" id="booking_relation" class="form-select" required>

                                        <option value="" disabled selected>-- Select --</option>

                                        <option value="Father">Father</option>

                                        <option value="Mother">Mother</option>

                                        <option value="Brother">Brother</option>

                                        <option value="Sister">Sister</option>

                                        <option value="Other">Other</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary">Save changes</button>

                </div>

            </div>

        </div>

    </div>

    <!-- information form  -->

    <!-- address form  -->

    <div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="address" tabindex="-1"

        aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Address</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form action="" class="contact-form shadow-none form-group">

                        <div class="form-card">

                            <div class="row">

                                <div class="col-md-6 form-group">

                                    <label for="inputAddress" class="form-label">Street Address</label>

                                    <input type="name" class="form-control " id="inputAddress" name=""

                                        placeholder="Enter Address">

                                </div>

                                <div class="col-md-6 form-group">

                                    <label for="inputCity" class="form-label">City</label>

                                    <input type="name" class="form-control " id="inputCity" name=""

                                        placeholder="Enter City">

                                </div>

                                <div class="col-md-6 form-group">

                                    <label for="inputState" class="form-label">State</label>

                                    <input type="name" class="form-control " id="inputState" name=""

                                        placeholder="Enter State">

                                </div>

                                <div class="col-md-6 form-group">

                                    <label for="inputCountry" class="form-label">Country</label>

                                    <input type="name" class="form-control " id="inputCountry" name=""

                                        placeholder="Enter Country">

                                </div>

                                <div class="col-md-6 form-group">

                                    <label for="inputPin" class="form-label">Pin/Postal Code</label>

                                    <input type="name" class="form-control " id="inputPin" name=""

                                        placeholder="Enter Pin code">

                                </div>

                                <div class="col-md-6 form-group">

                                    <label for="inputMap" class="form-label">Google Map Location

                                        (Optional)</label>

                                    <input type="name" class="form-control " id="inputMap" name=""

                                        placeholder="Paste Google Map Link">

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary">Save changes</button>

                </div>

            </div>

        </div>

    </div>

    <!-- address form  -->

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

                                <div class="col-md-12">

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

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="form-label">Address Type</label>

                                        <select name="type" class="form-select" id="type">

                                            <option value="">--select--</option>

                                            <option value="1">Home</option>

                                            <option value="2">Work</option>

                                            <option value="3">Other</option>

                                        </select>

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

                    <form action="" id="editAddressForm" method="POST" action="javascript:void(0);"

                        class="contact-form shadow-none">

                        @csrf

                        <input type="hidden" name="id" id="edit_id">

                        <div class="form-card">

                            <div class="row g-4">

                                <!-- Street Address -->

                                <div class="col-md-12">

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

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="form-label">Address Type</label>

                                        <select name="type" class="form-select" id="edit_type">

                                            <option value="">--select--</option>

                                            <option value="1">Home</option>

                                            <option value="2">Work</option>

                                            <option value="3">Other</option>

                                        </select>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>

        $(document).ready(function() {

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

                                       data-type="${address.type}"

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





            fetchAddresses();

            $(document).on('click', '.edit-address-btn', function() {

                $('#edit_id').val($(this).data('id'));

                $('#edit_address').val($(this).data('address'));

                $('#edit_city').val($(this).data('city'));

                $('#edit_state').val($(this).data('state'));

                $('#edit_country').val($(this).data('country'));

                $('#edit_pin').val($(this).data('pin'));

                $('#edit_google_map_location').val($(this).data('map'));

                $('#edit_type').val($(this).data('type'));

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

            });

        });

    </script>

    <script>

        $(document).ready(function() {

            // Helper: read file as base64 dataURL

            function readFileAsDataURL(file) {

                return new Promise((resolve, reject) => {

                    const reader = new FileReader();

                    reader.onload = () => resolve(reader.result);

                    reader.onerror = reject;

                    reader.readAsDataURL(file);

                });

            }



            // Provided in your common JS

            function dataURLtoBlob(dataurl) {

                const arr = dataurl.split(',');

                const mime = arr[0].match(/:(.*?);/)[1];

                const bstr = atob(arr[1]);

                let n = bstr.length;

                const u8arr = new Uint8Array(n);

                while (n--) {

                    u8arr[n] = bstr.charCodeAt(n);

                }

                return new Blob([u8arr], {

                    type: mime

                });

            }



            $(document).on('click', '.checkoutbtn', async function(e) {

                e.preventDefault();



                const formData = new FormData();



                // Collect booking details

                const consultationType = $('#booking_schedule_for').val();

                const doctorId = $('#booking_scheduler_id').val();

                const bookingDate = $('#booking_date').val();

                const bookingTime = $('#booking_time').val();

                const addressId = $('#selected_address_id').val();

                const subtotal = $('#subtotal').val();

                const discount = $('#discount').val();

                const tax = $('#tax').val();

                const total = $('#total').val();



                if (!bookingDate || !bookingTime || !addressId) {

                    Swal.fire('Error', 'Please complete all booking details before checkout.', 'error');

                    return;

                }



                // Add to FormData

                formData.append('consultation_type', consultationType);

                formData.append('doctor_id', doctorId);

                formData.append('booking_date', bookingDate);

                formData.append('booking_time', bookingTime);

                formData.append('address_id', addressId);

                formData.append('subtotal', subtotal);

                formData.append('discount', discount);

                formData.append('tax', tax);

                formData.append('total', total);



                // Handle uploaded prescriptions (merge to PDF)

                const files = $('#prescription_upload')[0].files;

                if (files.length > 0) {

                    const pdfDoc = await PDFLib.PDFDocument.create();

                    for (const file of files) {

                        if (file.type === "application/pdf") {

                            const existingPdfBytes = await file.arrayBuffer();

                            const loadedPdf = await PDFLib.PDFDocument.load(existingPdfBytes);

                            const copiedPages = await pdfDoc.copyPages(loadedPdf, loadedPdf

                                .getPageIndices());

                            copiedPages.forEach((page) => pdfDoc.addPage(page));

                        } else if (file.type.startsWith("image/")) {

                            const dataUrl = await readFileAsDataURL(file);

                            const img = new Image();

                            img.src = dataUrl;

                            await new Promise((resolve) => img.onload = resolve);



                            const canvas = document.createElement("canvas");

                            canvas.width = img.width;

                            canvas.height = img.height;

                            const ctx = canvas.getContext("2d");

                            ctx.drawImage(img, 0, 0);



                            const jpegDataUrl = canvas.toDataURL("image/jpeg");

                            const blob = dataURLtoBlob(jpegDataUrl);

                            const arrayBuffer = await blob.arrayBuffer();

                            const jpgImage = await pdfDoc.embedJpg(arrayBuffer);



                            const page = pdfDoc.addPage([jpgImage.width, jpgImage.height]);

                            page.drawImage(jpgImage, {

                                x: 0,

                                y: 0,

                                width: jpgImage.width,

                                height: jpgImage.height

                            });

                        }

                    }

                    const mergedPdfBytes = await pdfDoc.save();

                    const mergedBlob = new Blob([mergedPdfBytes], {

                        type: "application/pdf"

                    });

                    formData.append('prescription_upload', mergedBlob, 'merged_prescription.pdf');

                }



                // Step 1: Create Razorpay Order

                Swal.fire({

                    title: 'Initializing Payment...',

                    allowOutsideClick: false,

                    didOpen: () => Swal.showLoading()

                });



                fetch('/razorpay/checkout', {

                        method: 'POST',

                        headers: {

                            'Content-Type': 'application/json',

                            'X-CSRF-TOKEN': '{{ csrf_token() }}'

                        },

                        body: JSON.stringify({

                            amount: total,

                            type: 'consultation'

                        })

                    })

                    .then(res => res.json())

                    .then(async data => {

                        Swal.close();



                        if (!data.order_id) {

                            Swal.fire('Error', 'Failed to initialize Razorpay order.', 'error');

                            return;

                        }



                        // Step 2: Open Razorpay Checkout

                        const options = {

                            key: "{{ config('services.razorpay.key') }}",

                            amount: data.amount,

                            currency: data.currency,

                            name: "OurLabz Healthcare",

                            description: "Doctor Consultation Payment",

                            order_id: data.order_id,

                            handler: function(response) {

                                // Step 3: Payment Successful — now store booking

                                formData.append('razorpay_payment_id', response

                                    .razorpay_payment_id);

                                formData.append('razorpay_order_id', response

                                    .razorpay_order_id);

                                formData.append('razorpay_signature', response

                                    .razorpay_signature);

                                formData.append('payment_status', 'Paid');



                                Swal.fire({

                                    title: 'Finalizing Booking...',

                                    allowOutsideClick: false,

                                    didOpen: () => Swal.showLoading()

                                });



                                $.ajax({

                                    url: "{{ route('doctor.booking') }}",

                                    method: 'POST',

                                    data: formData,

                                    processData: false,

                                    contentType: false,

                                    success: function(response) {

                                        Swal.close();

                                        Swal.fire({

                                            icon: 'success',

                                            title: 'Consultation Booked!',

                                            toast: true,

                                            position: 'top-end',

                                            showConfirmButton: false,

                                            timer: 2000

                                        }).then(() => {

                                            window.location.href =

                                                "{{ url('/user/all-consultation') }}";

                                        });

                                    },

                                    error: function(xhr) {

                                        Swal.close();

                                        Swal.fire('Error', xhr.responseJSON

                                            ?.message ||

                                            'Booking failed.', 'error');

                                    }

                                });

                            },

                            prefill: {

                                name: "{{ auth()->user()->name ?? '' }}",

                                email: "{{ auth()->user()->email ?? '' }}",

                                contact: "{{ auth()->user()->phone ?? '' }}"

                            },

                            theme: {

                                color: "#0d6efd"

                            }

                        };



                        const rzp = new Razorpay(options);

                        rzp.open();

                    })

                    .catch(err => {

                        Swal.fire('Error', 'Something went wrong while initiating payment.',

                            'error');

                        console.error(err);

                    });

            });

        })

    </script>

@endsection

