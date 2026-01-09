@extends('backend.includes.layout')

@section('css')

<style>
    .package-suggestions {

        position: absolute;

        z-index: 1000;

        width: 100%;

        max-height: 250px;

        overflow-y: auto;

        background: #fff;

        border: 1px solid #ddd;

        border-radius: 8px;

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

        display: none;

        /* Initially hidden */

    }



    .package-item {

        display: block;

        padding: 10px 15px;

        font-size: 14px;

        color: #333;

        cursor: pointer;

        border-bottom: 1px solid #eee;

        transition: background 0.3s ease-in-out;

    }



    .package-item:last-child {

        border-bottom: none;

    }



    .package-item:hover {

        background: #f8f9fa;

        color: #007bff;

    }



    .choices[data-type*=select-one] .choices__inner {

        padding-bottom: 0px !important;

    }



    .choices {

        margin-bottom: 0px !important;

    }



    #selected_summary_list {

        margin-top: 10px;

        padding: 5px 20px;

    }



    @media (min-width: 1200px) {

        .col-xl-2-4 {

            flex: 0 0 auto;

            width: 20%;

        }

    }
</style>

@endsection

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">All Packages</h5>

            </div>

            <div class="col-sm-auto">

                <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i

                        class="fa-solid fa-plus"></i> Add</button>

            </div>

        </div>

    </div>



</div>

<div class="row g-3 list" id="cardListContainer">

    <!-- Cards will be appended here -->

</div>

<!-- Add Package Modal Start -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog mt-6 modal-xl" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Package</h4>

                    <p class="fs-10 mb-0 text-white">Please create your package.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">



                <form id="storeCorporatePackage">

                    @csrf

                    <div class="row">



                        {{-- Select Corporate --}}

                        <div class="mb-3 col-md-6">

                            <label for="type" class="form-label">Type</label>

                            <select name="type" id="type" class="form-select">

                                <option value="">-- Select --</option>

                                <option value="Test">Test</option>

                                <option value="Package">Package</option>

                            </select>

                        </div>

                        <!-- Packages -->

                        <div class="mb-3 col-md-6">

                            <label for="package_ids" class="form-label">Packages</label>

                            <select name="package_ids[]" id="package_ids" class="form-select js-choice" multiple>

                                @foreach ($packages as $pack)

                                <option value="{{ $pack->id }}" data-custom-properties='{"price": {{ $pack->price }} }'>{{ $pack->name }}</option>

                                @endforeach

                            </select>

                            {{-- Hidden prices outside the select --}}

                            @foreach ($packages as $pack)

                            <input type="hidden" class="package-price" data-id="{{ $pack->id }}" value="{{ $pack->corporate_price }}">

                            @endforeach

                        </div>

                        <input type="hidden" id="selected_package_prices" value="">

                        <input type="hidden" id="selected_test_prices" value="">

                        <!-- Tests -->

                        <div class="mb-3 col-md-6">

                            <label for="test_ids" class="form-label">Tests</label>

                            <select name="test_ids[]" id="test_ids" class="form-select js-choice" multiple>

                                @foreach ($tests as $test)

                                <option value="{{ $test->id }}" data-price="1499">{{ $test->name }}</option>

                                @endforeach

                            </select>

                            @foreach ($tests as $test)

                            <input type="hidden" class="test-price" data-id="{{ $test->id }}" value="{{ $test->corporate_price }}">

                            @endforeach

                        </div>

                        <input type="hidden" name="c_id" id="c_id" value="{{ auth()->user()->id }}">



                        <!-- Display Selected Names -->

                        <div class="mb-3 col-md-12">

                            <label for="selected_summary_list" class="form-label">Selected Package and Test</label>

                            <small class="text-muted">

                                📦 Package &nbsp;&nbsp;|&nbsp;&nbsp; 🧪 Test

                            </small>

                            <ul id="selected_summary_list" class="list-group"></ul>

                        </div>

                        <div class="mb-3 col-md-6">

                            <label for="summary" class="form-label">Package Name</label>

                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter package name">

                        </div>



                        <div class="mb-3 col-md-6">

                            <label for="no_of_employee" class="form-label">No of Employees</label>

                            <input type="number" name="no_of_employee" id="no_of_employee" class="form-control" min="1" placeholder="Enter no. of employees">

                        </div>



                        {{-- Price (auto-calculated) --}}

                        <div class="mb-3 col-md-6">

                            <label for="price" class="form-label">Package Price</label>

                            <input type="text" name="price" id="regular_price" class="form-control" placeholder="Auto calculate" readonly>

                        </div>



                        {{-- Coupon (optional) --}}

                        <!-- <div class="mb-3 col-md-6">

                            <label for="coupon" class="form-label">Coupon Code</label>

                            <input type="text" name="coupon" id="coupon" class="form-control">

                        </div> -->

                        {{-- Final Price (after discount) --}}

                        <div class="mb-3 col-md-6">

                            <label for="total_price" class="form-label">Total Price</label>

                            <input type="number" name="total_price" id="total_price" class="form-control" placeholder="Auto calculate" readonly>

                        </div>

                    </div>

                    <div class="text-center">

                        <button type="submit" class="btn btn-primary">Create Corporate Package</button>

                    </div>

                </form>



            </div>

        </div>

    </div>

</div>

<!-- Add Package Modal End -->

<div class="modal fade" id="applyCouponModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0">

            <div class="modal-header">

                <h5 class="modal-title">Apply Coupon</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form id="applyCouponForm">

                    <input type="hidden" name="package_id" id="coupon_package_id">

                    <div class="mb-3">

                        <label for="coupon_code" class="form-label">Enter Coupon Code</label>

                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" required>

                    </div>

                    <button type="submit" class="btn btn-success w-100">Apply</button>

                </form>

            </div>

        </div>

    </div>

</div>



@endsection

@section('js')

<script>
    $(document).ready(function() {





        function formatDate(dateString) {

            let date = new Date(dateString);

            let day = date.getDate().toString().padStart(2, '0');

            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based

            let year = date.getFullYear();

            return `${day}/${month}/${year}`;

        }



        $('#addModalBtn').on('click', function() {

            $('#addModal').modal('show');

        });



        $('#storeCorporatePackage').on('submit', function(e) {

            e.preventDefault();



            const form = $(this);

            const formData = new FormData(this);

            const noOfEmployee = form.find('[name="no_of_employee"]').val();



            if (!noOfEmployee || isNaN(noOfEmployee) || parseInt(noOfEmployee) <= 0) {

                Swal.fire({

                    icon: 'warning',

                    title: 'Required!',

                    text: 'Please enter a valid number of employees.'

                });

                return;

            }

            const packageIds = form.find('[name="package_ids[]"]').val() || [];

            const testIds = form.find('[name="test_ids[]"]').val() || [];



            if (packageIds.length === 0 && testIds.length === 0) {

                Swal.fire({

                    icon: 'warning',

                    title: 'Required!',

                    text: 'Please select at least one package or test.'

                });

                return;

            }



            $.ajax({

                url: '/corporate/packages/store',

                method: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                success: function(response) {

                    // Optional: Reset form

                    form[0].reset();



                    // Close modal

                    $('#addModal').modal('hide');



                    // Show success message

                    Swal.fire({

                        icon: 'success',

                        title: 'Success!',

                        text: 'Corporate package created successfully.',

                        timer: 2000,

                        showConfirmButton: false

                    });

                    fetchPackages()



                },

                error: function(xhr) {

                    let message = 'Something went wrong!';

                    if (xhr.responseJSON && xhr.responseJSON.message) {

                        message = xhr.responseJSON.message;

                    }



                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: message

                    });

                }

            });

        });

        // Toggle package/test visibility based on selected type

        $('#type').on('change', function() {

            const selectedType = $(this).val();



            if (selectedType === 'Package') {

                $('#package_ids').closest('.mb-3').show();

                $('#test_ids').closest('.mb-3').hide();

            } else if (selectedType === 'Test') {

                $('#package_ids').closest('.mb-3').hide();

                $('#test_ids').closest('.mb-3').show();

            } else {

                $('#package_ids').closest('.mb-3').hide();

                $('#test_ids').closest('.mb-3').hide();

            }



            updateSelectedSummaryAndPrice(); // Ensure prices and summary stay updated

        });



        // Trigger initial state

        $('#type').trigger('change');





        function updateSelectedSummaryAndPrice() {

            let baseTotal = 0;

            let summaryHtml = '';



            // Add selected package prices

            $('#package_ids option:selected').each(function() {

                const id = $(this).val();

                const label = $(this).text();

                const price = parseFloat($(`.package-price[data-id="${id}"]`).val()) || 0;

                baseTotal += price;

                summaryHtml += `<li>📦 ${label} - ₹${price}</li>`;

            });



            // Add selected test prices

            $('#test_ids option:selected').each(function() {

                const id = $(this).val();

                const label = $(this).text();

                const price = parseFloat($(`.test-price[data-id="${id}"]`).val()) || 0;

                baseTotal += price;

                summaryHtml += `<li>🧪 ${label} - ₹${price}</li>`;

            });



            // Number of employees

            const employees = parseInt($('#no_of_employee').val()) || 1;

            const finalTotal = baseTotal * employees;



            // Update values

            $('#selected_summary_list').html(summaryHtml || '<li>No items selected</li>');

            $('#regular_price').val(baseTotal.toFixed(2));

            $('#total_price').val(finalTotal.toFixed(2));

        }





        // Whenever selections or employee count change

        $('#package_ids, #test_ids, #no_of_employee').on('change keyup', updateSelectedSummaryAndPrice);



        // Also call it when the modal opens

        $('#addModal').on('shown.bs.modal', function() {

            updateSelectedSummaryAndPrice();

        });

        fetchPackages();



        function fetchPackages() {
            $('.loading').show();

            $.ajax({
                url: "{{ route('corporate.packages.list') }}",
                type: "GET",
                success: function(data) {
                    $('.loading').hide();
                    $('#cardListContainer').empty();

                    $.each(data, function(index, package) {

                        // 🔹 Status badge
                        let statusBadge = package.status == 1 ?
                            `<span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">
                        <i class="fas fa-check-circle me-1"></i> Active
                       </span>` :
                            `<span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill">
                        <i class="fas fa-ban me-1"></i> Inactive
                       </span>`;

                        // 🔹 Package Icon
                        let iconHtml = `
                    <div class="d-flex justify-content-center align-items-center bg-light rounded-circle mx-auto my-3 shadow-sm"
                        style="height: 90px; width: 90px;">
                        <span style="font-size: 36px;">📦</span>
                    </div>
                `;

                        // 🔹 Discount Text
                        let discountHtml = '';
                        if (package.discount && package.discount_type) {
                            const type = package.discount_type.toLowerCase();
                            if (type === 'percent' || type === 'percentage') {
                                discountHtml = `<p class="text-success small mb-1">
                            <i class="fas fa-percent me-1"></i>${package.discount}% off
                        </p>`;
                            } else if (type === 'flat') {
                                discountHtml = `<p class="text-success small mb-1">
                            <i class="fas fa-tags me-1"></i>₹${package.discount} off
                        </p>`;
                            }
                        }

                        // 🔹 Pricing Section
                        const originalPrice = parseFloat(package.price ?? 0);
                        const finalPrice = parseFloat(package.total_price ?? 0);
                        let priceHtml = '';

                        if (package.discount && originalPrice > finalPrice) {
                            priceHtml = `
                        <p class="mb-0">
                            <span class="text-muted text-decoration-line-through me-1 small">
                                ₹${originalPrice.toLocaleString('en-IN')}
                            </span>
                            <span class="fw-bold text-dark">
                                ₹${finalPrice.toLocaleString('en-IN')}
                            </span>
                        </p>
                        ${discountHtml}
                    `;
                        } else {
                            priceHtml = `<p class="fw-semibold text-dark mb-1">
                        ₹${finalPrice.toLocaleString('en-IN')}
                    </p>`;
                        }

                        // 🔹 Action Button (Paid / Buy Now / Apply Coupon)
                        let actionButton = '';

                        if (package.status == 1) {
                            if (package.corporate_package_payment_status === 'Paid') {
                                // ✅ Already purchased
                                actionButton = `
                            <span class="badge bg-success w-100 mt-3 py-2">
                                <i class="fas fa-check-circle me-1"></i> Paid
                            </span>`;
                            } else {
                                // 🛒 Not purchased yet
                                actionButton = `
                            <button class="btn btn-sm btn-primary w-100 mt-3 buy-now-btn"
                                data-id="${package.id}"
                                data-name="${package.name}"
                                data-price="${package.total_price}">
                                <i class="fas fa-shopping-cart me-1"></i> Buy Now
                            </button>`;
                            }
                        } else {
                            // ❗Inactive or Coupon related
                            if (!package.coupon) {
                                actionButton = `
                            <button class="btn btn-sm btn-outline-success w-100 mt-3 apply-coupon-btn"
                                data-id="${package.id}"
                                data-name="${package.name}">
                                <i class="fas fa-tags me-1"></i> Apply Coupon
                            </button>`;
                            } else {
                                actionButton = `
                            <span class="badge bg-info text-white mt-3 px-3 py-1">
                                Coupon Applied
                            </span>`;
                            }
                        }

                        // 🔹 Final Card HTML
                        let cardHtml = `
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                        <div class="card h-100 shadow-sm border-0 text-center package-card hover-shadow">
                            <div class="card-body px-3">
                                ${iconHtml}
                                <h6 class="fw-bold text-dark mb-1 text-truncate" title="${package.name}">
                                    ${package.name}
                                </h6>
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-users me-1 text-primary"></i>
                                    Employees: ${package.no_of_employee ?? 'N/A'}
                                </p>
                                ${priceHtml}
                                ${statusBadge}
                                ${actionButton}
                            </div>
                        </div>
                    </div>
                `;

                        $('#cardListContainer').append(cardHtml);
                    });
                },
                error: function(xhr) {
                    $('.loading').hide();
                    console.error(xhr);
                }
            });
        }


        // Open modal on button click

        $(document).on('click', '.apply-coupon-btn', function() {

            const packageId = $(this).data('id');

            $('#coupon_package_id').val(packageId);

            $('#coupon_code').val('');

            $('#applyCouponModal').modal('show');

        });



        // Submit coupon form

        $('#applyCouponForm').on('submit', function(e) {

            e.preventDefault();



            const packageId = $('#coupon_package_id').val();

            const couponCode = $('#coupon_code').val();



            $.ajax({

                url: '/corporate/packages/apply-coupon',

                type: 'POST',

                data: {

                    package_id: packageId,

                    coupon_code: couponCode,

                    _token: $('meta[name="csrf-token"]').attr('content')

                },

                success: function(response) {

                    Swal.fire('Success', response.message, 'success');

                    $('#applyCouponModal').modal('hide');

                    fetchPackages(); // Refresh list if price/discount updates

                },

                error: function(xhr) {

                    let message = 'Something went wrong';

                    if (xhr.responseJSON?.message) {

                        message = xhr.responseJSON.message;

                    }

                    Swal.fire('Error', message, 'error');

                }

            });

        });

        // Buy Package
        $(document).on('click', '.buy-now-btn', function() {
            const packageId = $(this).data('id');
            const packageName = $(this).data('name');
            const packagePrice = $(this).data('price'); // make sure you set this in HTML

            Swal.fire({
                title: `Buy Package: ${packageName}`,
                text: `Proceed to pay ₹${packagePrice}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Pay Now'
            }).then(result => {
                if (result.isConfirmed) {
                    initiateCorporatePackagePayment(packageId, packagePrice);
                }
            });
        });

        function initiateCorporatePackagePayment(packageId, amount) {
            Swal.fire({
                title: 'Processing Payment...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch('/razorpay/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        amount: amount,
                        type: 'corporate_package'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.close();

                    if (!data.order_id) {
                        Swal.fire('Error', 'Failed to initiate payment.', 'error');
                        return;
                    }

                    let userPhone = "{{ auth()->user()->phone ?? '' }}";
                    let userName = "{{ auth()->user()->name ?? '' }}";
                    let userEmail = "{{ auth()->user()->email ?? '' }}";

                    const options = {
                        key: "{{ config('services.razorpay.key') }}",
                        amount: data.amount,
                        currency: data.currency,
                        name: "Corporate Package Purchase",
                        description: "Corporate Package Payment",
                        order_id: data.order_id,
                        prefill: {
                            name: userName,
                            email: userEmail,
                            contact: userPhone
                        },
                        handler: function(response) {
                            $.ajax({
                                url: '/corporate/package/purchase',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    corporate_package_id: packageId,
                                    amount: amount,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature,
                                    payment_status: 'Paid'
                                },
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire('Success', res.message, 'success').then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error', res.message, 'error');
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong.', 'error');
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
                    Swal.close();
                    Swal.fire('Error', 'Something went wrong while initiating payment.', 'error');
                    console.error(err);
                });
        }




    });
</script>

@endsection