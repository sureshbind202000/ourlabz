@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Product Attributes</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3" data-list='{"valueNames":["name","date"],"page":10,"pagination":true}'>
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
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Attribute</h4>
                        <p class="fs-10 mb-0 text-white">Fill the form to create new attribute.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <form class="row" id="storeAttribute" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Attribute Name</label>
                            <input class="form-control" id="name" name="name" type="text"
                                placeholder="Enter attribute name" />
                        </div>
                        <!-- Attribute Values -->
                        <div class="mb-3">
                            <label class="form-label">Attribute Values</label>
                            <div id="attribute-values-wrapper">
                                <div class="input-group mb-2">
                                    <input type="text" name="values[]" class="form-control" placeholder="Enter value">
                                    <button type="button" class="btn btn-danger remove-value d-none">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3 d-flex">
                            <button class="btn  btn-success w-50 rounded-end-0" id="submitBtn">Submit</button>
                            <button type="button" class="btn  btn-secondary w-50 rounded-start-0" id="add-value">
                                <i class="fa fa-plus"></i> Add More
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Attribute Modal End -->
    <!-- Edit Attribute Modal Start -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Attribute</h4>
                        <p class="fs-10 mb-0 text-white">Update attribute and values.</p>
                    </div>
                    <div data-bs-theme="dark">
                        <button class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form class="row" id="updateAttribute" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">

                        <!-- Attribute Name -->
                        <div class="mb-3">
                            <label class="form-label" for="edit_name">Attribute Name</label>
                            <input class="form-control" id="edit_name" name="name" type="text"
                                placeholder="Enter attribute name" />
                        </div>

                        <!-- Attribute Values -->
                        <div class="mb-3">
                            <label class="form-label">Attribute Values</label>
                            <div id="edit-attribute-values-wrapper">
                                <!-- Values will be dynamically inserted via AJAX -->
                            </div>
                        </div>

                        <div class="mb-3 d-flex">
                            <button type="submit" class="btn btn-falcon-primary w-50 rounded-end-0">Update</button>
                            <button type="button" class="btn btn-secondary w-50 rounded-start-0" id="add-edit-value">
                                <i class="fa fa-plus"></i> Add More
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Attribute Modal End -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            // Add More Attribute Values
            $("#add-value").click(function() {
                let newInput = `
            <div class="input-group mb-2">
                <input type="text" name="values[]" class="form-control" placeholder="Enter value">
                <button type="button" class="btn btn-danger remove-value">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        `;
                $("#attribute-values-wrapper").append(newInput);
            });

            // Remove Attribute Value
            $(document).on("click", ".remove-value", function() {
                $(this).closest(".input-group").remove();
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
            fetchAttribute();

            function fetchAttribute() {
                Swal.fire({
                    title: 'Please Wait...',
                    text: 'Attributes Loading...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "{{ route('product.attribute.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";
                        $.each(data, function(index, attribute) {
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="name">
                         ${attribute.name}
                        </td>
                        <td class="date">${formatDate(attribute.created_at)}</td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${attribute.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${attribute.id}"><span
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
                var validator = $("#storeAttribute").validate({
                    ignore: [],
                    rules: {
                        name: {
                            required: true
                        },
                        "values[]": {
                            required: true
                        } // ensure at least one value is entered
                    },
                    messages: {
                        name: {
                            required: "Attribute Name is required"
                        },
                        "values[]": {
                            required: "Please enter at least one value"
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

                    if ($("#storeAttribute").valid()) {
                        Swal.fire({
                            title: 'Uploading...',
                            text: 'Please wait...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        var form = $("#storeAttribute")[0];
                        var formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('product.attribute.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.close();
                                Swal.fire("Success!", response.success, "success");
                                fetchAttribute();
                                $('#addModal').modal('hide');
                                window.location.reload();
                            },
                            error: function(xhr) {
                                Swal.close();
                                console.log(xhr);

                                let errorMessage = "An error occurred!";

                                if (xhr.responseJSON) {
                                    // Prefer 'message' but fallback to 'error'
                                    errorMessage = xhr.responseJSON.message || xhr
                                        .responseJSON.error || errorMessage;
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
                let attributeId = $(this).data('id');

                $.ajax({
                    url: '/product-attribute/' + attributeId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        var attribute = response.attribute;

                        // Basic user info
                        $('#edit_id').val(attribute.id);
                        $('#edit_name').val(attribute.name);

                        $('#editModal').modal('show');
                        Swal.close();
                    },
                    success: function(response) {
                        var attribute = response.attribute;

                        $('#edit_id').val(attribute.id);
                        $('#edit_name').val(attribute.name);

                        // Clear old values
                        $('#edit-attribute-values-wrapper').html('');

                        attribute.values.forEach(function(val) {
                            $('#edit-attribute-values-wrapper').append(`
            <div class="input-group mb-2">
                <input type="text" name="values[]" value="${val.value}" class="form-control" placeholder="Enter value">
                <button type="button" class="btn btn-danger remove-value">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        `);
                        });

                        // Show modal
                        $('#editModal').modal('show');
                        Swal.close();
                    },
                    error: function() {
                        Swal.close();
                        alert('Something went wrong while fetching attribute data.');
                    }
                });
            });

            // Add More button (in edit modal)
            $(document).on('click', '#add-edit-value', function() {
                $('#edit-attribute-values-wrapper').append(`
        <div class="input-group mb-2">
            <input type="text" name="values[]" class="form-control" placeholder="Enter value">
            <button type="button" class="btn btn-danger remove-value">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    `);
            });


            // Update User AJAX
            $('#updateAttribute').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Updating Attributes...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                var attributeId = $('#edit_id').val();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');
                $.ajax({
                    url: '/product-attribute/' + attributeId,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        $('#editModal').modal('hide');
                        Swal.fire("Success!", response.success, "success");
                        fetchAttribute();
                        Swal.close();
                        window.location.reload();
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
                let attributeId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the attribute!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Deleting attribute...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: `/product-attribute/${attributeId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.close();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The attribute have been deleted.",
                                        "success");
                                    fetchAttribute();
                                } else {
                                    Swal.fire("Error!", "Something went wrong.",
                                        "error");
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire("Error!", "Failed to delete attribute.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
