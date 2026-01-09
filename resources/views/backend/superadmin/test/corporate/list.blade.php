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

        padding: 5px 20px !important;

    }



    #edit_selected_summary_list {

        margin-top: 10px;

        padding: 5px 20px !important;

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



                        {{-- Price (auto-calculated) --}}

                        <div class="mb-3 col-md-6">

                            <label for="price" class="form-label">Total Package Price (Before Discount)</label>

                            <input type="text" name="price" id="corporate_regular_price" class="form-control"  placeholder="Auto calculate" readonly>

                        </div>



                        {{-- Discount Type --}}

                        <div class="mb-3 col-md-6">

                            <label for="discount_type" class="form-label">Discount Type</label>

                            <select name="discount_type" id="corporate_discount_type" class="form-select">

                                <option value="">-- None --</option>

                                <option value="flat">Flat</option>

                                <option value="percent">Percentage</option>

                            </select>

                        </div>



                        {{-- Discount --}}

                        <div class="mb-3 col-md-6">

                            <label for="discount" class="form-label">Discount Amount</label>

                            <input type="number" name="discount" id="corporate_discount" class="form-control" placeholder="Enter discount">

                        </div>





                        {{-- Final Price (after discount) --}}

                        <div class="mb-3 col-md-6">

                            <label for="total_price" class="form-label">Total Price (After Discount)</label>

                            <input type="number" name="total_price" id="corporate_price" class="form-control" placeholder="Auto calculate" readonly>

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

<!-- Add Package Modal Start -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog mt-6 modal-xl" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Edit Package</h4>

                    <p class="fs-10 mb-0 text-white">Please edit your package.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">



                <form id="editStoreCorporatePackage">

                    @csrf

                    <div class="row">

                        <!-- Packages -->

                        <div class="mb-3 col-md-6">

                            <label for="edit_package_ids" class="form-label">Packages</label>

                            <select name="edit_package_ids[]" id="edit_package_ids" class="form-select" multiple>

                                @foreach ($packages as $pack)

                                <option value="{{ $pack->id }}" data-custom-properties='{"price": {{ $pack->price }} }'>{{ $pack->name }}</option>

                                @endforeach

                            </select>

                            {{-- Hidden prices outside the select --}}

                            @foreach ($packages as $pack)

                            <input type="hidden" class="edit_package-price" data-id="{{ $pack->id }}" value="{{ $pack->corporate_price }}">

                            @endforeach

                        </div>

                        <input type="hidden" id="edit_selected_package_prices" value="">

                        <input type="hidden" id="edit_selected_test_prices" value="">

                        <input type="hidden" id="edit_id" value="">

                        <!-- Tests -->

                        <div class="mb-3 col-md-6">

                            <label for="edit_test_ids" class="form-label">Tests</label>

                            <select name="edit_test_ids[]" id="edit_test_ids" class="form-select" multiple>

                                @foreach ($tests as $test)

                                <option value="{{ $test->id }}" data-price="1499">{{ $test->name }}</option>

                                @endforeach

                            </select>

                            @foreach ($tests as $test)

                            <input type="hidden" class="edit_test-price" data-id="{{ $test->id }}" value="{{ $test->corporate_price }}">

                            @endforeach

                        </div>

                        <!-- Display Selected Names -->

                        <div class="mb-3 col-md-12">

                            <label for="selected_summary_list" class="form-label">Selected Package and Test</label>

                            <small class="text-muted">

                                📦 Package &nbsp;&nbsp;|&nbsp;&nbsp; 🧪 Test

                            </small>

                            <ul id="edit_selected_summary_list" class="list-group"></ul>

                        </div>



                        <div class="mb-3 col-md-6">

                            <label for="summary" class="form-label">Package Name</label>

                            <input type="text" name="edit_name" id="edit_name" class="form-control">

                        </div>

                        <div class="mb-3 col-md-6">

                            <label for="no_of_employee" class="form-label">No of Employees</label>

                            <input type="number" name="edit_no_of_employee" id="edit_no_of_employee" class="form-control" min="1">

                        </div>



                        {{-- Price (auto-calculated) --}}

                        <div class="mb-3 col-md-6">

                            <label for="edit_price" class="form-label">Total Package Price (Before Discount)</label>

                            <input type="text" name="edit_price" id="edit_price" class="form-control" readonly>

                        </div>



                        {{-- Discount Type --}}

                        <div class="mb-3 col-md-6">

                            <label for="edit_discount_type" class="form-label">Discount Type</label>

                            <select name="edit_discount_type" id="edit_discount_type" class="form-select">

                                <option value="">-- None --</option>

                                <option value="flat">Flat</option>

                                <option value="percent">Percentage</option>

                            </select>

                        </div>



                        {{-- Discount --}}

                        <div class="mb-3 col-md-6">

                            <label for="edit_discount" class="form-label">Discount Amount</label>

                            <input type="number" name="edit_discount" id="edit_discount" class="form-control">

                        </div>





                        {{-- Final Price (after discount) --}}

                        <div class="mb-3 col-md-6">

                            <label for="edit_total_price" class="form-label">Total Price (After Discount)</label>

                            <input type="number" name="edit_total_price" id="edit_total_price" class="form-control" readonly>

                        </div>



                    </div>



                    <div class="text-center">

                        <button type="submit" class="btn btn-primary">Update Corporate Package</button>

                    </div>

                </form>



            </div>

        </div>

    </div>

</div>

<!-- Add Package Modal End -->

<!-- Assign Modal Start -->

<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <form id="assignForm">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="assignModalLabel">Assign Package to Corporate</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="package_id" id="assign_package_id">



                    <div class="row">

                        <div class="mb-3 col-md-6">

                            <label for="corporate_id" class="form-label">Select Corporate</label>

                            <select class="form-select" name="corporate_id" id="corporate_id" required>

                                <option value="">-- Select --</option>

                                @foreach ($corporates as $corporate)

                                <option value="{{ $corporate->id }}">{{ $corporate->name }}</option>

                                @endforeach

                            </select>

                        </div>



                        <div class="mb-3 col-md-6">

                            <label for="no_of_employee" class="form-label">No of Employees</label>

                            <input type="number" name="no_of_employee" id="no_of_employee" class="form-control" min="1" placeholder="Enter no. of employees">

                        </div>

                        <div class="mb-3 col-md-6">

                            <label for="price" class="form-label">Price</label>

                            <input type="number" name="price" id="price" class="form-control" placeholder="Auto calculate" readonly>

                        </div>

                        {{-- Discount Type --}}

                        <div class="mb-3 col-md-6">

                            <label for="discount_type" class="form-label">Discount Type</label>

                            <select name="discount_type" id="discount_type" class="form-select">

                                <option value="">-- None --</option>

                                <option value="flat">Flat</option>

                                <option value="percent">Percentage</option>

                            </select>

                        </div>

                        {{-- Discount --}}

                        <div class="mb-3 col-md-6">

                            <label for="discount" class="form-label">Discount Amount</label>

                            <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter discount">

                        </div>

                        {{-- Final Price (after discount) --}}

                        <div class="mb-3 col-md-6">

                            <label for="total_price" class="form-label">Total Price</label>

                            <input type="number" name="total_price" id="total_price" class="form-control" placeholder="Auto calculate" readonly>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Assign</button>

                </div>

            </div>

        </form>

    </div>

</div>



@endsection

@section('js')

<script>
    $(document).ready(function() {

        $(document).on("change", ".search-type, .search-category", function() {

            var type = $(".search-type").val();

            var category = $(".search-category").val();

            var $searchInput = $(".search");



            // Combine both values (you can customize the format)

            var combinedSearch = (type ? type + " " : "") + (category ? category : "");

            $searchInput.val(combinedSearch.trim());



            // Simulate a real keyup event

            var event = new KeyboardEvent("keyup", {

                bubbles: true,

                cancelable: true

            });



            $searchInput[0].dispatchEvent(event);

        });



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



        // Fetch

        fetchPackages();



       function fetchPackages() {
    $('.loading').show();

    $.ajax({
        url: "{{ route('corporate.packages.list') }}",
        type: "GET",
        success: function (data) {
            $('.loading').hide();
            $('#cardListContainer').empty();

            $.each(data, function (index, package) {

                // 🔹 Status badge
                let statusBadge = package.status == 1
                    ? '<span class="badge bg-success-subtle text-success mb-3"><i class="fas fa-check-circle me-1"></i> Active</span>'
                    : '<span class="badge bg-danger-subtle text-danger mb-3"><i class="fas fa-ban me-1"></i> Inactive</span>';

                // 🔹 Toggle status button
                let toggleButton = `
                    <button class="btn btn-sm btn-outline-primary toggle-status-btn"
                        title="${package.status == 1 ? 'Deactivate' : 'Activate'}"
                        data-id="${package.id}" data-status="${package.status}">
                        <i class="fas ${package.status == 1 ? 'fa-toggle-on text-success' : 'fa-toggle-off text-danger'} fa-lg"></i>
                    </button>
                `;

                // 🔹 Action buttons
                let actionButtons = '';
                if (package.status != 1 && package.corporate_id == 0) {
                    actionButtons += `
                        <button class="btn btn-sm btn-outline-success assign-btn me-1" title="Assign"
                            data-id="${package.id}" data-price="${package.price}">
                            <i class="fas fa-user-check"></i>
                        </button>`;
                }
                if (package.status != 1) {
                    actionButtons += `
                        <button class="btn btn-sm btn-outline-primary edit-btn me-1" title="Edit" data-id="${package.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" title="Delete" data-id="${package.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>`;
                }

                // 🔹 Discount display
                let discountHtml = '';
                if (package.discount && package.discount_type) {
                    const type = package.discount_type.toLowerCase();
                    if (type === 'percent' || type === 'percentage') {
                        discountHtml = `<span class="badge text-success px-2 py-1 rounded-pill small">
                            <i class="fas fa-percent me-1"></i>${package.discount}% Off
                        </span>`;
                    } else if (type === 'flat') {
                        discountHtml = `<span class="badge text-success px-2 py-1 rounded-pill small">
                            <i class="fas fa-tags me-1"></i>₹${package.discount} Off
                        </span>`;
                    }
                }

                // 🔹 Price section
                const originalPrice = parseFloat(package.price ?? 0);
                const finalPrice = parseFloat(package.total_price ?? 0);
                let priceHtml = '';

                if (package.discount && originalPrice > finalPrice) {
                    priceHtml = `
                        <div>
                            <span class="text-muted text-decoration-line-through small">₹${originalPrice.toLocaleString('en-IN')}</span>
                            <span class="fw-bold text-dark ms-1 fs-6">₹${finalPrice.toLocaleString('en-IN')}</span><br>
                            ${discountHtml}
                        </div>
                    `;
                } else {
                    priceHtml = `<p class="fw-semibold text-dark mb-2 fs-6">
                        ₹${finalPrice.toLocaleString('en-IN')}
                    </p>`;
                }

                // 🔹 Package Icon
                let iconHtml = `
                    <div class="d-flex justify-content-center align-items-center bg-light rounded-circle mx-auto mb-3 shadow-sm"
                        style="height: 90px; width: 90px;">
                        <span style="font-size: 38px;">📦</span>
                    </div>`;

                // 🔹 Paid Badge (new)
                let paidBadge = '';
                if (package.corporate_package_payment_status === 'Paid') {
                    paidBadge = `
                        <span class="badge bg-success text-white mt-2 px-3">
                            <i class="fas fa-check-circle me-1"></i> Paid
                        </span>`;
                }

                // 🔹 Final Card Template
                let cardHtml = `
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                        <div class="card h-100 shadow border-0 rounded-4">
                            <div class="card-body text-center px-3">
                                ${iconHtml}
                                <h6 class="fw-bold text-capitalize mb-1 text-truncate" title="${package.name}">
                                    ${package.name}
                                </h6>
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-users me-1 text-primary"></i> Employees: ${package.no_of_employee ?? 'N/A'}
                                </p>
                                <hr class="my-2">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-user-tie me-1 text-secondary"></i>${package.corporate_admin_name ?? 'N/A'}
                                </p>
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-phone me-1 text-secondary"></i>${package.corporate_admin_phone ?? 'N/A'}
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-building me-1 text-secondary"></i>${package.corporate_company_name ?? 'N/A'}
                                </p>
                                <hr class="my-2">
                                ${priceHtml}
                                ${statusBadge}
                                ${paidBadge}
                                <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                    ${actionButtons}
                                    ${toggleButton}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#cardListContainer').append(cardHtml);
            });
        },
        error: function (xhr) {
            $('.loading').hide();
            console.error(xhr);
        }
    });
}






        function updateEditSelectedSummary() {

            let summaryList = $('#edit_selected_summary_list');

            summaryList.empty();



            let totalPrice = 0;



            // Get selected packages

            $('#edit_package_ids option:selected').each(function() {

                const id = $(this).val();

                const label = $(this).text();

                const price = parseFloat($(`.package-price[data-id="${id}"]`).val()) || 0;

                totalPrice += price;

                summaryList.append(`<li>📦 ${label} - ₹${price}</li>`);

            });



            // Get selected tests

            $('#edit_test_ids option:selected').each(function() {

                const id = $(this).val();

                const label = $(this).text();

                const price = parseFloat($(`.test-price[data-id="${id}"]`).val()) || 0;

                totalPrice += price;

                summaryList.append(`<li>🧪 ${label} - ₹${price}</li>`);

            });

            var employees = parseInt($('#edit_no_of_employee').val()) || 1;
            var finalTotal = totalPrice * employees;



            $('#edit_price').val(finalTotal.toFixed(2));



            // Trigger discount recalculation

            calculateEditDiscountPrice();

        }



        $('#edit_package_ids, #edit_test_ids,#edit_no_of_employee').on('change keyup', updateEditSelectedSummary);

        $('#edit_discount_type, #edit_discount').on('input change', calculateEditDiscountPrice);





        function calculateEditDiscountPrice() {

            const total = parseFloat($('#edit_price').val()) || 0;

            const discountType = $('#edit_discount_type').val();

            const discount = parseFloat($('#edit_discount').val()) || 0;



            let finalPrice = total;



            if (discountType === 'flat') {

                finalPrice = total - discount;

            } else if (discountType === 'percent') {

                finalPrice = total - (total * (discount / 100));

            }



            if (finalPrice < 0) finalPrice = 0;



            $('#edit_total_price').val(finalPrice.toFixed(2));

        }





        // Edit

        // Open Edit Modal & Load Data

        $(document).on('click', '.edit-btn', function() {

            $('.loading').show();

            let packageId = $(this).data('id');



            $.ajax({

                url: '/corp/' + packageId + '/edit',

                type: 'GET',

                success: function(response) {

                    const data = response.package;


                    $('#edit_id').val(data.id);

                    $('#edit_name').val(data.name);

                    $('#edit_price').val(data.price);

                    $('#edit_total_price').val(data.total_price);

                    $('#edit_no_of_employee').val(data.no_of_employee);

                    let packageIds = [];
                    let testIds = [];

                    try {
                        packageIds = typeof data.package_ids === 'string' ? JSON.parse(data.package_ids) : data.package_ids;
                    } catch (e) {
                        packageIds = [];
                    }

                    try {
                        testIds = typeof data.test_ids === 'string' ? JSON.parse(data.test_ids) : data.test_ids;
                    } catch (e) {
                        testIds = [];
                    }

                    // Select packages

                    initOrResetChoices('#edit_package_ids', 'editPackageIds', packageIds);

                    // Select tests

                    initOrResetChoices('#edit_test_ids', 'editTestIds', testIds);



                    // Fill discount details

                    $('#edit_discount_type').val(data.discount_type).trigger('change');

                    $('#edit_discount').val(data.discount);



                    // Recalculate prices

                    setTimeout(() => {

                        $('#edit_package_ids, #edit_test_ids').trigger('change'); // This triggers summary

                    }, 300);





                    $('#editModal').modal('show');

                    $('.loading').hide();

                },

                error: function() {

                    $('.loading').hide();

                    Swal.fire('Error', 'Failed to load package data.', 'error');

                }

            });

        });



        $('#editStoreCorporatePackage').on('submit', function(e) {

            e.preventDefault();



            let formData = {

                edit_id: $('#edit_id').val(),

                edit_name: $('#edit_name').val(),

                edit_price: $('#edit_price').val(),

                edit_discount_type: $('#edit_discount_type').val(),

                edit_no_of_employee: $('#edit_no_of_employee').val(),

                edit_discount: $('#edit_discount').val(),

                edit_total_price: $('#edit_total_price').val(),

                edit_package_ids: $('#edit_package_ids').val(),

                edit_test_ids: $('#edit_test_ids').val(),

                _token: $('input[name="_token"]').val()

            };



            $.ajax({

                url: '/corp/update',

                type: 'POST',

                data: formData,

                beforeSend: function() {

                    $('.loading').show();

                },

                success: function(response) {

                    if (response.status) {

                        Swal.fire('Success', response.message, 'success');

                        $('#editModal').modal('hide');

                        fetchPackages();

                    } else {

                        Swal.fire('Error', 'Something went wrong.', 'error');

                    }

                },

                error: function(xhr, status, error) {

                    Swal.fire('Error', 'Failed to update package.', 'error');

                    console.log("Error:", xhr, status, error);

                },

                complete: function() {

                    $('.loading').hide();

                }

            });

        });





        // Delete Package

        // ✅ Delete Package with Confirmation

        $(document).on('click', '.delete-btn', function() {

            let packageId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the corporate package!",

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#d33",

                cancelButtonColor: "#3085d6",

                confirmButtonText: "Yes, delete it!"

            }).then((result) => {

                if (result.isConfirmed) {

                    $('.loading').show();



                    $.ajax({

                        url: `/corporate/packages/destroy/${packageId}`,

                        type: "DELETE",

                        data: {

                            _token: "{{ csrf_token() }}"

                        },

                        success: function(response) {

                            $('.loading').hide();



                            if (response.status === 'success') {

                                Swal.fire("Deleted!",

                                    "Corporate package have been deleted.",

                                    "success");

                                fetchPackages(); // 🔄 Refresh the package list

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }

                        },

                        error: function(xhr) {

                            $('.loading').hide();

                            Swal.fire("Error!", "Failed to delete package.",

                                "error");

                        }

                    });

                }

            });

        });



        // Search Package

        $(document).on("keyup", ".search-parameter", function() {

            let query = $(this).val();

            let container = $(this).closest(".parameter-section"); // Corrected selector



            // Find the nearest `.package-suggestions` inside that container

            let suggestionsBox = container.find(".package-suggestions");



            if (query.length > 1) {

                $.ajax({

                    url: "{{ route('packages.search') }}",

                    type: "GET",

                    data: {

                        query: query

                    },

                    success: function(data) {

                        let suggestions = "";

                        $.each(data, function(id, name) {

                            suggestions +=

                                `<a href="#" class="list-group-item list-group-item-action package-item" data-name="${name}">${name}</a>`;

                        });

                        suggestionsBox.html(suggestions).show();

                    }

                });

            } else {

                suggestionsBox.hide();

            }

        });



        // Click event to select package and fetch parameters

        $(document).on("click", ".package-item", function(e) {

            e.preventDefault();

            let packageName = $(this).data("name");

            let container = $(this).closest(".parameter-section"); // Get the correct section



            // Update only the closest search input

            container.find(".search-parameter").val(packageName);



            // Hide only the closest suggestion box

            container.find(".package-suggestions").hide();



            // Fetch parameters for selected package

            $.ajax({

                url: "{{ route('packages.parameters') }}",

                type: "GET",

                data: {

                    package_name: packageName

                },

                success: function(data) {

                    let parameterHtml = "";

                    let totalParameters = 0;

                    data.forEach(param => {

                        parameterHtml += `

                            <div class="parameter-block">

                                <h4>${param.name}</h4>

                                <p>${param.content}</p>

                            </div>

                        `;

                        let paramCount = parseInt(param.no_of_parameter) || 0;

                        totalParameters += paramCount;

                    });



                    // Append parameters inside the closest parameter content section

                    container.find(".parameter-list").each(function() {

                        let editorId = $(this).attr("id"); // Get editor ID

                        if (tinymce.get(

                                editorId)) { // Check if TinyMCE is initialized

                            tinymce.get(editorId).setContent(parameterHtml);

                        }

                    });



                    container.find(".no_of_parameter").val(totalParameters);

                }

            });

        });





        // Hide suggestions when clicking outside

        $(document).click(function(e) {

            if (!$(e.target).closest(".search-parameter, .package-suggestions").length) {

                $(".package-suggestions").hide();

            }

        });

        $('#storeCorporatePackage').on('submit', function(e) {

            e.preventDefault();



            const form = $(this);

            const formData = new FormData(this);



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

                    fetchPackages();

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

        let basePrice = 0;



        $(document).on('click', '.assign-btn', function() {

            const packageId = $(this).data('id');

            basePrice = parseFloat($(this).data('price')) || 0;



            $('#assign_package_id').val(packageId);

            $('#no_of_employee').val('');

            $('#price').val('');

            $('#discount').val('');

            $('#total_price').val('');

            $('#discount_type').val('');



            $('#assignModal').modal('show');

        });



        // Calculate price on no_of_employee change

        $('#no_of_employee, #discount_type, #discount').on('input change', function() {

            calculateAssignPrice();

        });



        function calculateAssignPrice() {

            const employeeCount = parseInt($('#no_of_employee').val()) || 0;

            const discountType = $('#discount_type').val();

            const discount = parseFloat($('#discount').val()) || 0;



            const totalPrice = basePrice * employeeCount;

            $('#price').val(totalPrice.toFixed(2));



            let finalPrice = totalPrice;



            if (discountType === 'flat') {

                finalPrice = totalPrice - discount;

            } else if (discountType === 'percent') {

                finalPrice = totalPrice - (totalPrice * discount / 100);

            }



            if (finalPrice < 0) finalPrice = 0;



            $('#total_price').val(finalPrice.toFixed(2));

        }



        $('#assignForm').on('submit', function(e) {

            e.preventDefault();



            const formData = {

                package_id: $('#assign_package_id').val(),

                corporate_id: $('#corporate_id').val(),

                no_of_employee: $('#no_of_employee').val(),

                price: $('#price').val(),

                discount_type: $('#discount_type').val(),

                discount: $('#discount').val(),

                total_price: $('#total_price').val()

            };





            $.ajax({

                url: "{{ route('corporate.packages.assign') }}",

                type: "POST",

                data: formData,

                headers: {

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                },

                success: function(response) {

                    if (response.success) {

                        $('#assignModal').modal('hide');

                        Swal.fire('Success', response.message, 'success');

                        fetchPackages();

                    } else {

                        Swal.fire('Error', response.message, 'error');

                    }

                },

                error: function(xhr, status, error) {

                    if (xhr.status === 422) {

                        const errors = xhr.responseJSON.errors;

                        let errorMessages = Object.values(errors).map(err => err[0]).join('<br>');

                        Swal.fire('Validation Error', errorMessages, 'error');

                    } else {

                        Swal.fire('Error', 'Something went wrong.', 'error');

                    }

                }

            });

        });

        $(document).on('click', '.toggle-status-btn', function() {

            const packageId = $(this).data('id');

            const currentStatus = $(this).data('status');



            const newStatus = currentStatus == 1 ? 0 : 1;

            const actionText = newStatus == 1 ? 'Activate' : 'Deactivate';



            Swal.fire({

                title: `Are you sure you want to ${actionText} this package?`,

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: `Yes, ${actionText}`,

                cancelButtonText: 'Cancel',

            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: `/corp/package/status-toggle/${packageId}`, // adjust route as needed

                        method: 'POST',

                        data: {

                            status: newStatus,

                            _token: '{{ csrf_token() }}'

                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire('Success', response.message, 'success');

                                fetchPackages(); // refresh table

                            } else {

                                Swal.fire('Error', response.message, 'error');

                            }

                        },

                        error: function() {

                            Swal.fire('Error', 'Something went wrong.', 'error');

                        }

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

            let totalPrice = 0;

            let summaryHtml = '';



            // Process selected packages

            $('#package_ids option:selected').each(function() {

                const id = $(this).val();

                const label = $(this).text();

                const price = parseFloat($(`.package-price[data-id="${id}"]`).val()) || 0;

                totalPrice += price;

                summaryHtml += `<li>📦 ${label} - ₹${price}</li>`;

            });



            // Process selected tests

            $('#test_ids option:selected').each(function() {

                const id = $(this).val();

                const label = $(this).text();

                const price = parseFloat($(`.test-price[data-id="${id}"]`).val()) || 0;

                totalPrice += price;

                summaryHtml += `<li>🧪 ${label} - ₹${price}</li>`;

            });



            const noOfEmployees = parseInt($('#edit_no_of_employee').val()) || 1;

            const totalWithEmployees = totalPrice * noOfEmployees;



            $('#selected_summary_list').html(summaryHtml || '<li>No items selected</li>');

            $('#corporate_regular_price').val(totalWithEmployees.toFixed(2));



            // Recalculate after-discount price

            calculateCorporateDiscountPrice();

        }

        // Discount calculation

        function calculateCorporateDiscountPrice() {

            const total = parseFloat($('#corporate_regular_price').val()) || 0;

            const discountType = $('#corporate_discount_type').val();

            const discount = parseFloat($('#corporate_discount').val()) || 0;

            let finalPrice = total;



            if (discountType === 'flat') {

                finalPrice = total - discount;

            } else if (discountType === 'percent') {

                finalPrice = total - (total * (discount / 100));

            }



            $('#corporate_price').val(finalPrice.toFixed(2));

        }

        // Recalculate on change of employee count or discount

        $('#package_ids, #test_ids').on('change keyup', updateSelectedSummaryAndPrice);

        $('#corporate_discount_type, #corporate_discount').on('change keyup', calculateCorporateDiscountPrice);

    });
</script>

@endsection