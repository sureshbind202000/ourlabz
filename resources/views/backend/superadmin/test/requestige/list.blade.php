@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Requestige</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["name","status","type"],"page":10,"pagination":true}'>

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

                                <th class="text-900">Requisites Icon</th>

                                <th class="text-900" data-sort="name">Requisites Name</th>

                                <th class="text-900" data-sort="date">Date</th>

                                <th class="text-900">Action</th>

                            </tr>

                        </thead>

                        <tbody class="list">

                            <tr>

                                <td>1</td>

                                <td class="icon">icon</td>

                                <td class="name">Requisites name</td>

                                <td class="date">dd/mm/yy</td>

                                <td>

                                    <div><a class="btn btn-link p-0" href="javascript:void(0);" data-bs-toggle="tooltip"

                                            data-bs-placement="top" title="View"><span

                                                class="text-500 fas fa-eye"></span></a>

                                        <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"

                                            data-bs-placement="top" title="Edit"><span

                                                class="text-500 fas fa-edit"></span></button><button

                                            class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"

                                            data-bs-placement="top" title="Delete"><span

                                                class="text-500 fas fa-trash-alt"></span></button>

                                    </div>

                                </td>

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



<!-- Add Requestige Modal -->
<div class="modal fade" id="requestigeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Requisite</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Form -->
            <form id="requisiteForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Requisite Name</label>
                        <input type="text" name="name" id="requisite_name" class="form-control" placeholder="Enter name" required>
                    </div>

                    <!-- Icon -->
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="file" name="icon" class="form-control">
                        <br>
                        <!-- Search Image Link -->

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <a href="" id="search-icon" target="_blank">
                        <i class="fa-solid fa-magnifying-glass"></i> Search Image
                    </a>
                    <button type="submit" id="submitRequisiteBtn" class="btn btn-success">Save Requisite</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Add Package Modal End -->

<!-- Edit Package Modal Start -->
<div class="modal fade" id="editRequisiteModal" tabindex="-1" role="dialog" aria-labelledby="editRequisiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">

            <!-- Modal Header -->
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editRequisiteModalLabel">Edit Requisite</h4>
                    <p class="fs-10 mb-0 text-white">Update requisite details.</p>
                </div>
                <div data-bs-theme="dark">
                    <button class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Modal Body / Form -->
            <div class="modal-body px-4 pb-4">
                <form class="row" id="updateRequisiteForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_requisite_id" name="id">

                    <!-- Requisite Name -->
                    <div class="mb-3">
                        <label class="form-label" for="edit_requisite_name">Requisite Name</label>
                        <input class="form-control" id="edit_requisite_name" name="name" type="text" placeholder="Enter Requisite Name" required />
                    </div>

                    <!-- Icon -->
                    <div class="mb-3">
                        <label class="form-label" for="edit_requisite_icon">Upload Icon <span class="text-danger">(.png & transparent background)</span></label>
                        <input class="form-control" id="edit_requisite_icon" name="icon" type="file" />
                        <br>
                        <img src="" id="PreviewRequisiteIcon" alt="" style="height:50px;width:50px;">
                        <br>
                        <!-- Search Image link like Edit Category modal -->

                    </div>

                    <!-- Footer / Buttons -->
                    <div class="mb-3">

                        <button class="btn btn-falcon-primary me-2">Update</button>
                        <a href="" id="edit-requisite-search-icon" target="_blank">
                            <i class="fa-solid fa-magnifying-glass"></i> Search Image
                        </a>
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

        $('#requisite_name').on('input', function() {

            var cat_name = $(this).val();

            $('#search-icon').attr('href', 'https://icons8.com/icons/set/' + cat_name);

        });



        $('#edit_requisite_name').on('input', function() {

            var cat_name = $(this).val();

            $('#edit-requisite-search-icon').attr('href', 'https://icons8.com/icons/set/' + cat_name);

        });



        function formatDate(dateString) {

            let date = new Date(dateString);

            let day = date.getDate().toString().padStart(2, '0');

            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based

            let year = date.getFullYear();

            return `${day}/${month}/${year}`;

        }



        $('#addModalBtn').on('click', function() {

            $('#requestigeModal').modal('show');

        });



        // Fetch

        fetchRequisites();



        function fetchRequisites() {
            Swal.fire({
                title: 'Please Wait...',
                text: 'Loading Requisites...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('requisites.list') }}",
                type: "GET",
                dataType: "json",

                success: function(data) {
                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, item) {

                        let itemIcon = item.icon ?
                            "{{ asset('/') }}" + item.icon :
                            "{{ asset('backend/assets/img/team/avatar.png') }}";

                        rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name}</td>
                        <td><img src="${itemIcon}" style="height:50px;width:50px;"></td>
                        <td>${formatDate(item.created_at)}</td>

                        <td>
                            <button class="btn btn-link p-0 edit-btn" data-id="${item.id}">
                                <span class="text-primary fas fa-edit"></span>
                            </button>

                            <button class="btn btn-link p-0 delete-btn" data-id="${item.id}">
                                <span class="text-danger fas fa-trash-alt"></span>
                            </button>
                        </td>
                    </tr>
                `;
                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {
                        valueNames: ['name', 'date'],
                        page: 10,
                        pagination: true
                    });
                },

                error: function() {
                    Swal.close();
                    Swal.fire("Error!", "Unable to fetch data!", "error");
                }
            });
        }




        // Store Requisite
        $(document).ready(function() {

            // CSRF Setup
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            // Submit
            $("#submitRequisiteBtn").click(function(e) {
                e.preventDefault();

                let form = $("#requisiteForm")[0];
                let formData = new FormData(form);

                Swal.fire({
                    title: "Saving...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "{{ route('requisites.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        Swal.close();
                        Swal.fire("Success!", res.message, "success");
                        $("#requisiteForm")[0].reset();
                        $("#requisiteModal").modal("hide");
                        fetchRequisites();
                    },
                    error: function(xhr) {
                        Swal.close();

                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            // Sab errors ko concatenate karenge
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + "\n"; // first message per field
                            });

                            Swal.fire("Validation Error!", errorMessages, "error");
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // Agar Laravel se koi custom message aya
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        } else {
                            // Generic fallback
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }

                        console.log(xhr.responseText); // debugging ke liye
                    }
                });
            });
        });


        // Edit Requisite – Open Modal & Load Data
        $(document).on('click', '.edit-btn', function() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let requisiteId = $(this).data('id');

            $.ajax({
                url: '/requisites/' + requisiteId + '/edit', // Laravel GET edit route
                type: 'GET',
                success: function(response) {
                    var requisite = response.requisite;

                    // Populate form
                    $('#edit_requisite_id').val(requisite.id);
                    $('#edit_requisite_name').val(requisite.name);

                    if (requisite.icon == 'dummy' || !requisite.icon) {
                        $('#PreviewRequisiteIcon').attr('src', '/backend/assets/img/team/avatar.png');
                    } else {
                        $('#PreviewRequisiteIcon').attr('src', requisite.icon);
                    }

                    // Search Image link
                    $('#edit-requisite-search-icon').attr('href', 'https://www.google.com/search?tbm=isch&q=' + encodeURIComponent(requisite.name));

                    $('#editRequisiteModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    alert('Something went wrong while fetching requisite data.');
                }
            });
        });


        // Update Requisite – AJAX
        $('#updateRequisiteForm').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Please wait...',
                text: 'Updating Requisite...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var requisiteId = $('#edit_requisite_id').val();
            var formData = new FormData(this);

            $.ajax({
                url: '/requisites/update/' + requisiteId, // Correct RESTful route
                type: 'POST', // Use POST
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    $('#editRequisiteModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchRequisites(); // Refresh table
                    Swal.close();
                },
                  error: function(xhr) {
                        Swal.close();

                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            // Sab errors ko concatenate karenge
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + "\n"; // first message per field
                            });

                            Swal.fire("Validation Error!", errorMessages, "error");
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // Agar Laravel se koi custom message aya
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        } else {
                            // Generic fallback
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }

                        console.log(xhr.responseText); // debugging ke liye
                    }
            });
        });



        // Delete Requisite
        $(document).on('click', '.delete-btn', function() {
            let requisiteId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the requisite and its image!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting requisite...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: `/requisites/${requisiteId}`, // Laravel route for delete
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.close();

                            if (response.success) {
                                Swal.fire(
                                    "Deleted!",
                                    "The requisite and its image have been deleted.",
                                    "success"
                                );
                                fetchRequisites(); // refresh the table
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete requisite.", "error");
                        }
                    });
                }
            });
        });








    });
</script>

@endsection