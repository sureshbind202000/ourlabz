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
    </style>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Products</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["productid","name","date","type"],"page":10,"pagination":true}'>
                    <div class="row justify-content-end justify-content-end gx-3 gy-0 ">
                        <div class="col-auto col-sm-5 mb-3 me-auto">
                            <form>
                                <div class="input-group"><input class="form-control form-control-sm shadow-none search"
                                        type="search" placeholder="Search..." aria-label="search" />
                                    <div class="input-group-text bg-transparent"><span
                                            class="fa fa-search fs-10 text-600"></span></div>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-auto">
                            <a href="{{ route('product.add') }}" class="btn btn-sm btn-falcon-primary me-1 mb-1"><i
                                    class="fa-solid fa-plus"></i> Add</a>
                        </div>
                    </div>

                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-900">S.No.</th>
                                    <th class="text-900" data-sort="productid">Product ID</th>
                                    <th class="text-900" data-sort="category">Type / Category / Sub-category</th>
                                    <th class="text-900" data-sort="name">Name</th>
                                    <th class="text-900" data-sort="price">Price</th>
                                    <th class="text-900" data-sort="status">Status</th>
                                    <th class="text-900" data-sort="date">Date</th>
                                    <th class="text-900">Action</th>
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
                    <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1"
                            type="button" title="Previous" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"
                            title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                    </div>
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

            // Fetch
            fetchProducts();

            function fetchProducts() {
                Swal.fire({
                    title: 'Loading products...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "{{ route('product.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();

                        let rows = "";
                        $.each(data, function(index, product) {
                            let badgeClass = "";
                            let statusText = "";
                            let tooltipBtn = "";

                            switch (product.status) {
                                case 0:
                                    badgeClass = "badge-subtle-warning";
                                    statusText = "Pending";
                                    break;
                                case 1:
                                    badgeClass = "badge-subtle-success";
                                    statusText = "Verified";
                                    break;
                                case 2:
                                    badgeClass = "badge-subtle-danger";
                                    statusText = "Rejected";

                                    tooltipBtn = `<button class="btn btn-sm btn-link text-info ms-1 reason-btn p-0" data-id="${product.id}" title="View Reason">
                            <i class="fas fa-info-circle"></i>
                        </button>`;
                                    break;
                                default:
                                    badgeClass = "badge-subtle-secondary";
                                    statusText = "Unknown";
                            }


                            rows += `<tr>
                    <td>${index + 1}</td>
                    <td class="productid">${product.product_id}</td>
                    <td class="category search-category">
                        <span class="badge badge-subtle-success">${product.product_type?.name ?? '-'}</span> / 
                        <span class="badge badge-subtle-primary">${product.product_category?.name ?? '-'}</span> / 
                        <span class="badge badge-subtle-warning">${product.product_sub_category?.name ?? '-'}</span>
                    </td>
                    <td class="name">${product.product_name}</td>
                    <td class="price">₹${product.selling_price}</td>
                   <td class="search-status">
                      <span 
                        class="badge ${badgeClass} w-100 py-2 type fs-11 change-status" 
                        style="cursor: pointer;"
                        data-id="${product.id}" 
                        data-status="${product.status}"
                        title="Click to change status"
                      >
                        ${statusText}
                        ${tooltipBtn}
                      </span>
                    </td>
                    <td class="date">${formatDate(product.created_at)}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ url('/') }}/product/${product.slug}" class="btn btn-link p-0" title="View" target="_blank">
                                <span class="text-secondary fas fa-eye"></span>
                            </a>
                          |
                          <a href="{{ url('/') }}/vendor-product/${product.encrypted_id}/edit" class="btn btn-link p-0" title="Edit">
                               <span class="text-primary fas fa-edit"></span>
                           </a>
                            |
                            <button class="btn btn-link p-0 delete-btn" type="button" title="Delete" data-id="${product.id}">
                                <span class="text-danger fas fa-trash-alt"></span>
                            </button>
                        </div>
                    </td>
                </tr>`;
                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {
                            valueNames: ['productid', 'name', 'date', 'status', 'category'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            // 🧠 Show rejection reason on click
            $(document).on('click', '.reason-btn', function() {
                const productId = $(this).data('id');

                $.ajax({
                    url: `/products/rejection-reason/${productId}`,
                    type: 'GET',
                    success: function(res) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Rejection Reason',
                            text: res.reason || 'No reason provided.'
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch rejection reason.'
                        });
                    }
                });
            });



            // Delete Product
            // ✅ Delete Product with Confirmation
            $(document).on('click', '.delete-btn', function() {
                let productId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the product and all related data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.loading').show();

                        $.ajax({
                            url: `/product/${productId}/destroy`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('.loading').hide();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The product and related data have been deleted.",
                                        "success");
                                    fetchProducts(); // 🔄 Refresh the product list
                                } else {
                                    Swal.fire("Error!", "Something went wrong.",
                                        "error");
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                $('.loading').hide();
                                Swal.fire("Error!", "Failed to delete product.",
                                    "error");
                            }
                        });
                    }
                });
            });

            // ============
            const authRole = {{ auth()->user()->role }};
            if (authRole === 0) {
                $(document).on('click', '.change-status', function() {
                    const productId = $(this).data('id');
                    const currentStatus = parseInt($(this).data('status'));

                    Swal.fire({
                        title: 'Change Product Status',
                        html: `
            <select id="swal-status" class="swal2-input form-control w-25 mx-auto">
                <option value="0" ${currentStatus === 0 ? 'selected' : ''}>Pending</option>
                <option value="1" ${currentStatus === 1 ? 'selected' : ''}>Verified</option>
                <option value="2" ${currentStatus === 2 ? 'selected' : ''}>Rejected</option>
            </select>
            <br>
            <textarea  id="swal-reason" class="swal2-input form-control w-75 mx-auto" placeholder="Write Rejection Reason" style="display:none;"></textarea>
        `,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                        preConfirm: () => {
                            const status = $('#swal-status').val();
                            const reason = $('#swal-reason').val();

                            if (status == 2 && reason.trim() === '') {
                                Swal.showValidationMessage('Rejection reason is required.');
                                return false;
                            }

                            return $.ajax({
                                url: `/products/change-status/${productId}`,
                                method: 'POST',
                                data: {
                                    status: status,
                                    rejection_reason: reason,
                                    _token: '{{ csrf_token() }}'
                                }
                            }).then(res => {
                                if (!res.success) {
                                    throw new Error(res.message ||
                                        'Error updating status');
                                }
                                return res;
                            }).catch(err => {
                                Swal.showValidationMessage(err.message);
                            });
                        }
                    }).then(result => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                timer: 1200,
                                showConfirmButton: false
                            });

                            // ✅ Refresh table
                            fetchProducts();
                        }
                    });

                    // Show/hide rejection reason input dynamically
                    $(document).on('change', '#swal-status', function() {
                        if ($(this).val() == 2) {
                            $('#swal-reason').show();
                        } else {
                            $('#swal-reason').hide();
                        }
                    });

                    // Trigger once to initialize
                    $('#swal-status').trigger('change');
                });
            }

            $(document).on('click', '.search-category, .search-status', function() {
                let categoryText = $(this).text().replace(/\s+/g, ' ').trim();
                $('.search').val(categoryText).trigger('input');
            });


        });
    </script>
@endsection
