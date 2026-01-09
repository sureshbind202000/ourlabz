@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Website Teams</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">
        <div class="tab-content">
            <div id="tableExample3" data-list='{"valueNames":["name","designation"],"page":10,"pagination":true}'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group">
                                <input class="form-control form-control-sm shadow-none search"
                                    type="search" placeholder="Search Team..." aria-label="search" />
                                <div class="input-group-text bg-transparent">
                                    <span class="fa fa-search fs-10 text-600"></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn">
                            <i class="fa-solid fa-plus"></i> Add Team
                        </button>
                    </div>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th>S.No.</th>
                                <th data-sort="name">Name</th>
                                <th data-sort="designation">Designation</th>
                                <th>Image</th>
                                <th>Social Links</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="list">
                            <tr>
                                <td></td>
                                <td class="name"></td>
                                <td class="designation"></td>
                                <td class="image"></td>
                                <td class="social-links"></td>
                                <td class="status"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button"
                        title="Previous" data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>

                    <ul class="pagination mb-0"></ul>

                    <button class="btn btn-sm btn-falcon-default ms-1" type="button"
                        title="Next" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>



<!-- Add Team Modal Start -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="addModalLabel">Add Team Member</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <form id="storeTeam" class="row" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Designation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="designation" placeholder="Enter Designation">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Primary Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Is Active</label>
                        <select class="form-select" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Facebook</label>
                        <input type="text" class="form-control" name="facebook" placeholder="Facebook URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Twitter</label>
                        <input type="text" class="form-control" name="twitter" placeholder="Twitter URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" class="form-control" name="linkedin" placeholder="LinkedIn URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">YouTube</label>
                        <input type="text" class="form-control" name="youtube" placeholder="YouTube URL">
                    </div>

                    <div class="mb-3 col-md-12">
                        <button class="btn btn-falcon-primary" id="submitBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Team Modal End -->

<!-- Edit Team Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="editModalLabel">Edit Team Member</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <form id="updateTeam" class="row" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Enter name">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Designation</label>
                        <input type="text" class="form-control" id="edit_designation" name="designation" placeholder="Enter designation">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Facebook</label>
                        <input type="text" class="form-control" id="edit_facebook" name="facebook" placeholder="Facebook URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Twitter</label>
                        <input type="text" class="form-control" id="edit_twitter" name="twitter" placeholder="Twitter URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" class="form-control" id="edit_linkedin" name="linkedin" placeholder="LinkedIn URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">YouTube</label>
                        <input type="text" class="form-control" id="edit_youtube" name="youtube" placeholder="YouTube URL">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="image" class="form-control" id="edit_image">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Image Preview</label><br>
                        <img id="edit_image_preview" src="#" alt="Image Preview" height="100" style="display:none;">
                    </div>

                    <div class="mb-3 col-md-12">
                        <button class="btn btn-falcon-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Team Modal End -->

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

        fetchTeam();

        function fetchTeam() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading Team Members...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            const assetBase = "{{ asset('') }}";
            $.ajax({
                url: "{{ route('website.team.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, team) {
                        rows += `<tr>
                    <td>${index + 1}</td>
                    <td class="name">${team.name}</td>
                    <td class="designation">${team.designation}</td>
                     <td class="image">
                        ${team.image ? `<img src="${assetBase}${team.image}" height="50" />` : ''}
                    </td>
                    <td class="social-links">
                        ${team.facebook ? `<a href="${team.facebook}" target="_blank"><i class="fab fa-facebook"></i></a>` : ''}
                        ${team.twitter ? `<a href="${team.twitter}" target="_blank"><i class="fab fa-twitter"></i></a>` : ''}
                        ${team.linkedin ? `<a href="${team.linkedin}" target="_blank"><i class="fab fa-linkedin"></i></a>` : ''}
                        ${team.youtube ? `<a href="${team.youtube}" target="_blank"><i class="fab fa-youtube"></i></a>` : ''}
                    </td>
                    <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${team.id}" 
                            ${team.is_active ? 'checked' : ''} />
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <button class="btn btn-link p-0 edit-btn" type="button" data-id="${team.id}">
                                <span class="text-primary fas fa-edit"></span>
                            </button> | 
                            <button class="btn btn-link p-0 delete-btn" type="button" data-id="${team.id}">
                                <span class="text-danger fas fa-trash-alt"></span>
                            </button>
                        </div>
                    </td>
                </tr>`;
                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {
                        valueNames: ['name', 'designation'],
                        page: 10,
                        pagination: true
                    });
                },
                error: function() {
                    Swal.close();
                    Swal.fire("Error!", "Failed to load team members.", "error");
                }
            });
        }





        // Store
        $(document).ready(function() {
            $('#submitBtn').on('click', function(e) {
                e.preventDefault();

                let formData = new FormData($('#storeTeam')[0]);

                Swal.fire({
                    title: 'Saving...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "{{ route('website.team.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.close();
                        Swal.fire("Success!", response.success, "success");

                        fetchTeam(); // Refresh team list
                        $('#addModal').modal('hide');
                        $('#storeTeam')[0].reset();
                    },
                    error: function(xhr) {
                        Swal.close();
                        let msg = xhr.responseJSON?.message ?? "Something went wrong!";
                        Swal.fire("Error!", msg, "error");
                    }
                });
            });
        });


        // Open Edit Modal & Load Team Data
        $(document).on('click', '.edit-btn', function() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let id = $(this).data('id');

            $.ajax({
                url: "/website/team/" + id + "/edit",
                type: "GET",
                success: function(res) {
                    const team = res.team;

                    $('#edit_id').val(team.id);
                    $('#edit_name').val(team.name);
                    $('#edit_designation').val(team.designation);
                    $('#edit_facebook').val(team.facebook);
                    $('#edit_twitter').val(team.twitter);
                    $('#edit_linkedin').val(team.linkedin);
                    $('#edit_youtube').val(team.youtube);

                    // Set current image previews
                    if (team.image) {
                        $('#edit_image_preview').attr('src', "{{ asset('') }}" + team.image).show();
                    } else {
                        $('#edit_image_preview').hide();
                    }

                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    Swal.fire("Error", "Failed to load team data", "error");
                }
            });
        });

        // Update Team AJAX
        $("#updateTeam").submit(function(e) {
            e.preventDefault();

            let id = $("#edit_id").val();
            let formData = new FormData(this);

            Swal.fire({
                title: "Updating...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "/website/team/" + id,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#editModal').modal('hide');
                    Swal.fire("Success", res.success, "success");
                    fetchTeam(); // reload the team list
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = xhr.responseJSON?.message ?? "Update failed!";
                    Swal.fire("Error", msg, "error");
                }
            });
        });


        // Delete Team Member
        $(document).on('click', '.delete-btn', function() {
            let teamId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the team member!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting team member...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/website/team/${teamId}`,
                        type: "DELETE",
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire("Deleted!", response.success, "success");
                                fetchTeam(); // Refresh the team list
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete team member.", "error");
                        }
                    });
                }
            });
        });

        // Toggle Team Status
        $(document).on('change', '.status-toggle', function() {
            var teamId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.team.status') }}",
                type: "POST",
                data: {
                    id: teamId,
                    status: status,
                    _token: "{{ csrf_token() }}" // Make sure CSRF token is included
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
                        title: 'Status updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    fetchTeam(); // Reload the team list
                },
                error: function(xhr) {
                    console.log(xhr);
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