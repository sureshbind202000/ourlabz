@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Lab Facilities</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3" data-list='{"valueNames":["facility","status","date"],"page":10,"pagination":true}'>
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
                                <th class="text-900" data-sort="facility">Facility</th>
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
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Facility</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create new facility.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="storeFacility">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="facility">Facility</label>
                        <input class="form-control" id="facility" name="facility" type="text" placeholder="Enter facility name" />
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
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Facility</h4>
                    <p class="fs-10 mb-0 text-white">Update facility.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="updateFacility" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="edit_facility">Facility</label>
                        <input class="form-control" id="edit_facility" name="facility" type="text" placeholder="Enter facility name" />
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
        fetchFacility();

        function fetchFacility() {
            Swal.fire({
                title: 'Please Wait...',
                text: 'Facilities Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ route('lab.facility.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();
                    let rows = "";
                    $.each(data, function(index, facility) {

                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="facility">
                         ${facility.facility}
                        </td>
                        <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${facility.id}" ${facility.status == 1 ? 'checked' : ''} />
                        </div>
                        </td>
                        <td class="date">${formatDate(facility.created_at)}</td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${facility.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${facility.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['facility', 'date'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeFacility").validate({
                ignore: [],
                rules: {
                    facility: {
                        required: true,
                    },
                },
                messages: {
                    facility: {
                        required: "Facility Name is required",
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

                if ($("#storeFacility").valid()) {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    var form = $("#storeFacility")[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('lab.facility.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            Swal.fire("Success!", response.success, "success");
                            fetchFacility();
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
            let facilityId = $(this).data('id');

            $.ajax({
                url: '/lab-facility/' + facilityId + '/edit',
                type: 'GET',
                success: function(response) {
                    var facility = response.facility;

                    // Basic user info
                    $('#edit_id').val(facility.id);
                    $('#edit_facility').val(facility.facility);
                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    alert('Something went wrong while fetching facility data.');
                }
            });
        });


        // Update User AJAX
        $('#updateFacility').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating Facility...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var facilityId = $('#edit_id').val();
            var formData = new FormData(this);
            formData.append('_method', 'PUT');
            $.ajax({
                url: '/lab-facility/' + facilityId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.close();
                    Swal.fire("Success!", response.success, "success");
                    fetchFacility();
                    $('#editModal').modal('hide');
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
            let facilityId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the facility!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting Facility...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/lab-facility/${facilityId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.close();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The facility have been deleted.",
                                    "success");
                                fetchFacility();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete facility.",
                                "error");
                        }
                    });
                }
            });
        });

        $(document).on('change', '.status-toggle', function() {
            var categoryId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('lab.facility.status.update') }}", // Create this route
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: categoryId,
                    status: status
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait...',
                        text: 'Updating status...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    fetchFacility();
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