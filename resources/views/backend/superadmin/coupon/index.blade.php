@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">All Coupons</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["code","type","status","date"],"page":10,"pagination":true}'>

                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group">
                                <input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                                <div class="input-group-text bg-transparent"><span class="fa fa-search fs-10 text-600"></span></div>
                            </div>
                        </form>
                    </div>

                    <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addCouponBtn">
                            <i class="fa-solid fa-plus"></i> Add Coupon
                        </button>
                    </div>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th>S.No.</th>
                                <th data-sort="code">Coupon Code</th>
                                <th>Title</th>
                                <th data-sort="type">Type</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th data-sort="date">Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="list">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button" data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>

            </div>

        </div>

    </div>

</div>



<!-- Add Coupon Modal Start -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Coupon</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create a new coupon</p>
                </div>
                <div data-bs-theme="dark">
                    <button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body px-4 pb-4">
                <form class="row" id="storeCoupon">
                    @csrf

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                        <input class="form-control" name="code" type="text" placeholder="EX: SAVE20" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input class="form-control" name="title" type="text" placeholder="20% OFF on orders" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="discount_type" id="discount_type">
                            <option disabled selected>Select Type</option>
                            <option value="flat">Flat</option>
                            <option value="percentage">Percentage</option>
                            <option value="bogo">BOGO (Buy One Get One)</option>
                            <option value="buy_x_get_y">Buy X Get Y</option>
                            <option value="free_delivery">Free Delivery</option>
                            <option value="auto_apply">Auto Apply</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6 discount-value-field">
                        <label class="form-label">Discount Value</label>
                        <input class="form-control" name="discount_value" type="number" step="0.01" placeholder="Enter value" />
                    </div>

                    <div class="mb-3 col-md-6 max-discount-field">
                        <label class="form-label">Max Discount (Optional)</label>
                        <input class="form-control" name="max_discount" type="number" step="0.01" placeholder="Max Discount" />
                    </div>

                    <div class="mb-3 col-md-3 bogo-fields">
                        <label class="form-label">Buy Qty (X)</label>
                        <input class="form-control" name="buy_qty" type="number" placeholder="e.g. 1" />
                    </div>

                    <div class="mb-3 col-md-3 bogo-fields">
                        <label class="form-label">Get Qty (Y)</label>
                        <input class="form-control" name="get_qty" type="number" placeholder="e.g. 1" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Minimum Cart Amount</label>
                        <input class="form-control" name="min_cart_amount" type="number" step="0.01" placeholder="Optional" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Usage Limit</label>
                        <input class="form-control" name="usage_limit" type="number" placeholder="System wide limit" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Usage Per User</label>
                        <input class="form-control" name="usage_per_user" type="number" placeholder="Limit per user" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Start Date</label>
                        <input class="form-control" name="start_date" type="datetime-local" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">End Date</label>
                        <input class="form-control" name="end_date" type="datetime-local" />
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Applicable For</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="for_products" value="1">
                            <label class="form-check-label">Products</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="for_lab_tests" value="1">
                            <label class="form-check-label">Lab Tests</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="for_doctors" value="1">
                            <label class="form-check-label">Doctors</label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-falcon-primary me-2" id="submitBtn">Save Coupon</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Coupon Modal End -->

<!-- Edit Coupon Modal Start -->

<!-- Edit Coupon Modal (same structure/design as Add Modal) -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Coupon</h4>
                    <p class="fs-10 mb-0 text-white">Update coupon details.</p>
                </div>
                <div data-bs-theme="dark">
                    <button class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body px-4 pb-4">
                <form class="row" id="updateCoupon">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                        <input class="form-control" id="edit_code" name="code" type="text" placeholder="EX: SAVE20" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input class="form-control" id="edit_title" name="title" type="text" placeholder="20% OFF on orders" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_discount_type" name="discount_type">
                            <option disabled>Select Type</option>
                            <option value="flat">Flat</option>
                            <option value="percentage">Percentage</option>
                            <option value="bogo">BOGO (Buy One Get One)</option>
                            <option value="buy_x_get_y">Buy X Get Y</option>
                            <option value="free_delivery">Free Delivery</option>
                            <option value="auto_apply">Auto Apply</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6 discount-value-field">
                        <label class="form-label">Discount Value</label>
                        <input class="form-control" id="edit_discount_value" name="discount_value" type="number" step="0.01" placeholder="Enter value" />
                    </div>

                    <div class="mb-3 col-md-6 max-discount-field">
                        <label class="form-label">Max Discount (Optional)</label>
                        <input class="form-control" id="edit_max_discount" name="max_discount" type="number" step="0.01" placeholder="Max Discount" />
                    </div>

                    <div class="mb-3 col-md-3 bogo-fields">
                        <label class="form-label">Buy Qty (X)</label>
                        <input class="form-control" id="edit_buy_qty" name="buy_qty" type="number" placeholder="e.g. 1" />
                    </div>

                    <div class="mb-3 col-md-3 bogo-fields">
                        <label class="form-label">Get Qty (Y)</label>
                        <input class="form-control" id="edit_get_qty" name="get_qty" type="number" placeholder="e.g. 1" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Minimum Cart Amount</label>
                        <input class="form-control" id="edit_min_cart_amount" name="min_cart_amount" type="number" step="0.01" placeholder="Optional" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Usage Limit</label>
                        <input class="form-control" id="edit_usage_limit" name="usage_limit" type="number" placeholder="System wide limit" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Usage Per User</label>
                        <input class="form-control" id="edit_usage_per_user" name="usage_per_user" type="number" placeholder="Limit per user" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Start Date</label>
                        <input class="form-control" id="edit_start_date" name="start_date" type="datetime-local" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">End Date</label>
                        <input class="form-control" id="edit_end_date" name="end_date" type="datetime-local" />
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Applicable For</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="edit_for_products" type="checkbox" name="for_products" value="1">
                            <label class="form-check-label">Products</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="edit_for_lab_tests" type="checkbox" name="for_lab_tests" value="1">
                            <label class="form-check-label">Lab Tests</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="edit_for_doctors" type="checkbox" name="for_doctors" value="1">
                            <label class="form-check-label">Doctors</label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-falcon-primary me-2" id="updateSubmitBtn">Update Coupon</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>



<!-- Edit Coupon Modal End -->

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



        $('#addCouponBtn').on('click', function() {

            $('#addModal').modal('show');

        });



        // Fetch

        fetchCoupon();



        function fetchCoupon() {

            Swal.fire({
                title: 'Please wait...',
                text: 'Loading coupons...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "{{ route('website.coupon.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();

                    let rows = "";

                    // If no coupons found
                    if (!data.data || data.data.length === 0) {
                        rows = `
                    <tr>
                        <td colspan="8" class="text-center text-muted">No coupons found</td>
                    </tr>`;
                        $("tbody.list").html(rows);
                        return;
                    }

                    $.each(data.data, function(index, coupon) {

                        let createdAt = coupon.created_at ? formatDate(coupon.created_at) : '-';

                        rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td class="code">${coupon.code ?? '-'}</td>
                    <td>${coupon.title ?? '-'}</td>
                    <td class="type">${coupon.discount_type ?? '-'}</td>
                    <td>${coupon.discount_value ?? '-'}</td>

                    <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox"
                                data-id="${coupon.id}"
                                ${coupon.is_active == 1 ? 'checked' : ''}/>
                        </div>
                    </td>

                    <td class="date">${createdAt}</td>

                    <td>
                        <button class="btn btn-link p-0 edit-btn" data-id="${coupon.id}">
                            <span class="text-primary fas fa-edit"></span>
                        </button>
                        <button class="btn btn-link p-0 delete-btn ms-2" data-id="${coupon.id}">
                            <span class="text-danger fas fa-trash-alt"></span>
                        </button>
                    </td>
                </tr>`;
                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {
                        valueNames: ['code', 'type', 'status', 'date'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {

            // === Validation Rules ===
            var validator = $("#storeCoupon").validate({
                ignore: [],
                rules: {
                    code: {
                        required: true
                    },
                    discount_type: {
                        required: true
                    },
                    discount_value: {
                        required: function() {
                            let type = $("#discount_type").val();
                            return !(type === "bogo" || type === "buy_x_get_y" || type === "free_delivery");
                        },
                        number: true
                    },
                    buy_qty: {
                        required: function() {
                            let type = $("#discount_type").val();
                            return type === "bogo" || type === "buy_x_get_y";
                        },
                        number: true
                    },
                    get_qty: {
                        required: function() {
                            let type = $("#discount_type").val();
                            return type === "bogo" || type === "buy_x_get_y";
                        },
                        number: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                },
                messages: {
                    code: {
                        required: "Coupon Code Required"
                    },
                    discount_type: {
                        required: "Select discount type"
                    },
                    discount_value: {
                        required: "Discount value required",
                        number: "Enter valid number"
                    },
                    buy_qty: {
                        required: "Enter Buy Qty"
                    },
                    get_qty: {
                        required: "Enter Get Qty"
                    },
                    start_date: {
                        required: "Start date required"
                    },
                    end_date: {
                        required: "End date required"
                    },
                },
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    error.insertAfter(element);
                }
            });


            // === Submit Form ===
            $("#submitBtn").on("click", function(e) {
                e.preventDefault();

                if ($("#storeCoupon").valid()) {

                    Swal.fire({
                        title: "Saving Coupon...",
                        text: "Please wait",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });

                    var form = $("#storeCoupon")[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('website.coupon.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                            Swal.close();
                            Swal.fire("Success!", response.message, "success");

                            $("#addModal").modal("hide");
                            form.reset();
                            fetchCoupon();
                        },
                        error: function(xhr) {
                            Swal.close();

                            let msg = "Something went wrong!";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire("Error!", msg, "error");
                        }
                    });
                }
            });


            // ==== Show/Hide BOGO fields ====
            $("#discount_type").change(function() {
                let type = $(this).val();

                if (type === "bogo" || type === "buy_x_get_y") {
                    $(".bogo-fields").show();
                    $(".discount-value-field").hide();
                } else {
                    $(".bogo-fields").hide();
                    $(".discount-value-field").show();
                }

                if (type === "free_delivery") {
                    $(".discount-value-field").hide();
                    $(".max-discount-field").hide();
                } else {
                    $(".max-discount-field").show();
                }
            }).trigger("change");

        });

        // Open Edit Modal & Load Data
        // helper to convert ISO to datetime-local value "YYYY-MM-DDTHH:MM"
        function toDateTimeLocal(iso) {
            if (!iso) return "";
            let d = new Date(iso);
            if (isNaN(d)) return "";
            let pad = (n) => n.toString().padStart(2, '0');
            let YYYY = d.getFullYear();
            let MM = pad(d.getMonth() + 1);
            let DD = pad(d.getDate());
            let hh = pad(d.getHours());
            let mm = pad(d.getMinutes());
            return `${YYYY}-${MM}-${DD}T${hh}:${mm}`;
        }

        // show/hide bogo fields for both add & edit modals
        function toggleBogoFields(modalSelector, type) {
            let $modal = $(modalSelector);
            if (type === 'bogo' || type === 'buy_x_get_y') {
                $modal.find('.bogo-fields').show();
                $modal.find('.discount-value-field').hide();
            } else {
                $modal.find('.bogo-fields').hide();
                $modal.find('.discount-value-field').show();
            }

            if (type === 'free_delivery') {
                $modal.find('.discount-value-field').hide();
                $modal.find('.max-discount-field').hide();
            } else {
                $modal.find('.max-discount-field').show();
            }
        }

        // when discount_type changes inside edit modal
        $(document).on('change', '#edit_discount_type', function() {
            toggleBogoFields('#editModal', $(this).val());
        });

        // Open edit modal, fetch coupon
        $(document).on('click', '.edit-btn', function() {

            Swal.fire({
                title: 'Please wait...',
                text: 'Opening edit coupon form...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let couponId = $(this).data('id');

            $.ajax({
                url: '/website/coupons/' + couponId + '/edit',
                type: 'GET',
                success: function(response) {
                    // support both response shapes
                    var c = response.coupon ? response.coupon : response;

                    // populate inputs
                    $('#edit_id').val(c.id || '');
                    $('#edit_code').val(c.code || '');
                    $('#edit_title').val(c.title || '');
                    $('#edit_discount_type').val(c.discount_type || '');
                    $('#edit_discount_value').val(c.discount_value ?? '');
                    $('#edit_max_discount').val(c.max_discount ?? '');
                    $('#edit_buy_qty').val(c.buy_qty ?? '');
                    $('#edit_get_qty').val(c.get_qty ?? '');
                    $('#edit_min_cart_amount').val(c.min_cart_amount ?? '');
                    $('#edit_usage_limit').val(c.usage_limit ?? '');
                    $('#edit_usage_per_user').val(c.usage_per_user ?? '');

                    // checkboxes
                    $('#edit_for_products').prop('checked', !!c.for_products);
                    $('#edit_for_lab_tests').prop('checked', !!c.for_lab_tests);
                    $('#edit_for_doctors').prop('checked', !!c.for_doctors);

                    // dates -> datetime-local format
                    $('#edit_start_date').val(toDateTimeLocal(c.start_date));
                    $('#edit_end_date').val(toDateTimeLocal(c.end_date));

                    // toggle fields properly
                    toggleBogoFields('#editModal', c.discount_type);

                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.close();
                    Swal.fire("Error", "Unable to fetch coupon details", "error");
                }
            });
        });

        // Submit update (PUT)
        $(document).on('click', '#updateSubmitBtn', function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            if (!id) {
                Swal.fire('Error', 'Invalid coupon id', 'error');
                return;
            }

            // gather form data
            var form = $('#updateCoupon')[0];
            var fd = new FormData(form);
            fd.append('_method', 'PUT'); // method override for PUT

            // ensure checkboxes send 0 when unchecked (server expects 0/1)
            if (!fd.has('for_products')) fd.append('for_products', 0);
            if (!fd.has('for_lab_tests')) fd.append('for_lab_tests', 0);
            if (!fd.has('for_doctors')) fd.append('for_doctors', 0);

            Swal.fire({
                title: 'Updating...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '/website/coupons/' + id,
                type: 'POST', // using method override
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();
                    $('#editModal').modal('hide');
                    fetchCoupon();
                    Swal.fire('Success', 'Coupon updated', 'success');
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = 'Something went wrong';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // show first error
                        let firstKey = Object.keys(xhr.responseJSON.errors)[0];
                        msg = xhr.responseJSON.errors[firstKey][0];
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
        // Delete Coupon
        $(document).on('click', '.delete-btn', function() {

            let couponId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the coupon!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting coupon...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: `/website/coupons/${couponId}`, // ✅ coupon URL
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}" // CSRF token
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire(
                                    "Deleted!",
                                    "The coupon has been deleted.",
                                    "success"
                                );
                                fetchCoupon(); // refresh table
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete coupon.", "error");
                        }
                    });

                }
            });
        });




        $(document).on('change', '.status-toggle', function() {

            var couponId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.coupon.status') }}", // ✅ Correct route for coupons
                type: "POST",
                data: {
                    id: couponId,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Updating status...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Coupon status updated',
                        timer: 1200,
                        showConfirmButton: false
                    });
                    fetchCoupon(); // ✅ reload table
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

    });
</script>

@endsection