@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Product Type</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3" data-list='{"valueNames":["name","type"],"page":10,"pagination":true}'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group"><input class="form-control form-control-sm shadow-none search"
                                    type="search" placeholder="Search..." aria-label="search" />
                                <div class="input-group-text bg-transparent"><span
                                        class="fa fa-search fs-10 text-600"></span></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i
                                class="fa-solid fa-plus"></i> Add</button>
                    </div>
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900">S.No.</th>
                                <th class="text-900" data-sort="name">Name</th>
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

<!-- Add Package Modal Start -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Type</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create new type.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="storeType">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Type</label>
                        <input class="form-control" id="name" name="name" type="text" placeholder="Enter type" />
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-falcon-primary me-2" id="submitBtn">Submit</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Package Modal End -->
<!-- Edit Package Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Type</h4>
                    <p class="fs-10 mb-0 text-white">Update type.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="updateType" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="edit_name">Type</label>
                        <input class="form-control" id="edit_name" name="name" type="text" placeholder="Enter type" />
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-falcon-primary me-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Package Modal End -->
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

        // Fetch
        fetchType();

        function fetchType() {
            Swal.fire({
                title: 'Please Wait...',
                text: 'Type Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ route('product.type.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();
                    let rows = "";
                    $.each(data, function(index, type) {
                        
                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="name">
                         ${type.name}
                        </td>
                        <td class="date">${formatDate(type.created_at)}</td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${type.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${type.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['name', 'date'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeType").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Type Name is required",
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    if (element.is(":radio") || element.is(":checkbox")) {
                        error.appendTo(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#submitBtn').on('click', function(e) {
                e.preventDefault();

                if ($("#storeType").valid()) {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    var form = $("#storeType")[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('product.type.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            Swal.fire("Success!", response.success, "success");
                            fetchType();
                            form.reset();
                            $('#addModal').modal('hide');
                        },
                        error: function(xhr) {
                            Swal.close();
                            console.log(xhr);

                            let errorMessage = "An error occurred!";

                            if (xhr.responseJSON) {
                                // Prefer 'message' but fallback to 'error'
                                errorMessage = xhr.responseJSON.message || xhr.responseJSON.error || errorMessage;
                            }

                            Swal.fire("Error!", errorMessage, "error");
                        }
                    });
                }
            });
        });


        // Edit
        // Open Edit Modal & Load Data
        $(document).on('click', '.edit-btn', function() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let typeId = $(this).data('id');

            $.ajax({
                url: '/product-type/' + typeId + '/edit',
                type: 'GET',
                success: function(response) {
                    var type = response.type;

                    // Basic user info
                    $('#edit_id').val(type.id);
                    $('#edit_name').val(type.name);

                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    alert('Something went wrong while fetching type data.');
                }
            });
        });


        // Update User AJAX
        $('#updateType').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating Type...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var typeId = $('#edit_id').val();
            var formData = new FormData(this);
            formData.append('_method', 'PUT');
            $.ajax({
                url: '/product-type/' + typeId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.close();
                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchType();
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.fire("Error!", "Something went wrong.", "error");
                    Swal.close();
                }
            });
        });

        // Delete 
        $(document).on('click', '.delete-btn', function() {
            let typeId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the type!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting type...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/product-type/${typeId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.close();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The type have been deleted.",
                                    "success");
                                fetchType();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete type.",
                                "error");
                        }
                    });
                }
            });
        });


    });
</script>
@endsection