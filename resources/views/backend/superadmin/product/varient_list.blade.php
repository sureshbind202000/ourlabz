@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Varients</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["varientid","name","date","status","price"],"page":10,"pagination":true}'>
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
                            <a href="{{ route('products') }}"
                                class="btn btn-sm btn-falcon-primary me-1 mb-1"><i class="fa-solid fa-arrow-left"></i>  Back to products</a>
                            <a href="{{ route('product.varient.add', $product->encrypted_id) }}"
                                class="btn btn-sm btn-falcon-primary me-1 mb-1"><i class="fa-solid fa-plus"></i> Add</a>
                        </div>
                    </div>

                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-900">S.No.</th>
                                    <th class="text-900" data-sort="varientid">Varient ID</th>
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
            fetchVarients();

            function fetchVarients() {
                Swal.fire({
                    title: 'Loading varients...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                var productId = "{{$product->id}}";

                $.ajax({
                    url: `/vendor-product/varient/${productId}/list`,
                    type: "GET",
                    success: function(data) {
                        Swal.close();

                        let rows = "";
                        $.each(data, function(index, varient) {
                            let badgeClass = "";
                            let statusText = "";
                            let tooltipBtn = "";

                            switch (varient.status) {
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

                                    tooltipBtn = `<button class="btn btn-sm btn-link text-info ms-1 reason-btn p-0" data-id="${varient.id}" title="View Reason">
                            <i class="fas fa-info-circle"></i>
                        </button>`;
                                    break;
                                default:
                                    badgeClass = "badge-subtle-secondary";
                                    statusText = "Unknown";
                            }

                            rows += `<tr>
                    <td>${index + 1}</td>
                    <td class="varientid">${varient.varient_id}</td>
                    <td class="name">${varient.varient_name}</td>
                    <td class="price">₹${varient.selling_price}</td>
                   <td class="search-status">
                      <span 
                        class="badge ${badgeClass} w-100 py-2 type fs-11 change-status" 
                        style="cursor: pointer;"
                        data-id="${varient.id}" 
                        data-status="${varient.status}"
                        title="Click to change status"
                      >
                        ${statusText}
                        ${tooltipBtn}
                      </span>
                    </td>
                    <td class="date">${formatDate(varient.created_at)}</td>
                    <td>
                        <div>
                            <button class="btn btn-link p-0" type="button" title="View" data-id="${varient.id}">
                                <span class="text-secondary fas fa-eye"></span>
                            </button>
                          <a href="{{ url('/') }}/vendor-product/varient/${varient.encrypted_id}/edit" class="btn btn-link p-0 ms-2" title="Edit">
                               <span class="text-primary fas fa-edit"></span>
                           </a>
                            <button class="btn btn-link p-0 ms-2 delete-btn" type="button" title="Delete" data-id="${varient.id}">
                                <span class="text-danger fas fa-trash-alt"></span>
                            </button>
                        </div>
                    </td>
                </tr>`;
                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {
                            valueNames: ['varientid', 'name', 'date', 'status', 'price'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            // 🧠 Show rejection reason on click
            $(document).on('click', '.reason-btn', function() {
                const varientId = $(this).data('id');

                $.ajax({
                    url: `/product-varient/rejection-reason/${varientId}`,
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
                let varientId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the varient and all related data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.loading').show();

                        $.ajax({
                            url: `/product-varient/${varientId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('.loading').hide();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The varient and related data have been deleted.",
                                        "success");
                                    fetchVarients(); // 🔄 Refresh the package list
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

            // ============
            const authRole = {{ auth()->user()->role }};
            if (authRole === 0) {
                $(document).on('click', '.change-status', function() {
                    const varientId = $(this).data('id');
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
                                url: `/product-varient/change-status/${varientId}`,
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
                            fetchVarients();
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

        });
    </script>
@endsection
