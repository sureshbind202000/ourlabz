@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">All Policies</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">
            <div id="tableExample3" data-list='{"valueNames":["title","slug","date"],"page":10,"pagination":true}'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group">
                                <input class="form-control form-control-sm shadow-none search"
                                    type="search" placeholder="Search Policy..." aria-label="search" />
                                <div class="input-group-text bg-transparent">
                                    <span class="fa fa-search fs-10 text-600"></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn">
                            <i class="fa-solid fa-plus"></i> Add Policy
                        </button>
                    </div>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th>S.No.</th>
                                <th data-sort="title">Title</th>
                                <th data-sort="slug">Slug</th>
                                <th>Content</th>
                                <th data-sort="status">Status</th>
                                <th data-sort="date">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="list">
                            <tr>
                                <td></td>
                                <td class="title"></td>
                                <td class="slug"></td>
                                <td></td>
                                <td class="status"></td>
                                <td class="date"></td>
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



<!-- Add Policy Modal Start -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="addModalLabel">Add Policy Page</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <form id="storePolicy" class="row">

                    @csrf

                    @php
                    $existingPolicies = \App\Models\PolicyPage::pluck('title')->toArray();
                    $allPolicies = [
                    "Privacy Policy",
                    "Refund Policy",
                    "Terms & Conditions",
                    "Return & Cancellation Policy",
                    "Shipping Policy",
                    "Billing Policy",
                    "Data Protection Policy",
                    "Cookie Policy",
                    "User Agreement",
                    "Disclaimer",
                    "Contact Policy",
                    ];
                    @endphp

                    <div class="mb-3 col-12">
                        <label class="form-label">Select Policy <span class="text-danger">*</span></label>
                        <select class="form-select" id="title" name="title">
                            <option value="">-- Select Policy Page --</option>

                            @foreach($allPolicies as $policy)
                            @if(!in_array($policy, $existingPolicies))
                            <option value="{{ $policy }}">{{ $policy }}</option>
                            @endif
                            @endforeach

                        </select>
                    </div>


                    <div class="mb-3 col-12">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" name="content" id="content"></textarea>
                    </div>

                    <div class="mb-3 col-12">
                        <button class="btn btn-falcon-primary" id="submitBtn">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Policy Modal End -->

<!-- Edit Policy Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">

            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="editModalLabel">Edit Policy Page</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <form id="updatePolicy" class="row">
                    @csrf

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3 col-12">
                        <label class="form-label">Select Policy <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_title" name="title" readonly>
                            <option value="Privacy Policy">Privacy Policy</option>
                            <option value="Refund Policy">Refund Policy</option>
                            <option value="Terms & Conditions">Terms & Conditions</option>
                            <option value="Return & Cancellation Policy">Return & Cancellation Policy</option>
                            <option value="Shipping Policy">Shipping Policy</option>
                            <option value="Billing Policy">Billing Policy</option>
                            <option value="Data Protection Policy">Data Protection Policy</option>
                            <option value="Cookie Policy">Cookie Policy</option>
                            <option value="User Agreement">User Agreement</option>
                            <option value="Disclaimer">Disclaimer</option>
                            <option value="Contact Policy">Contact Policy</option>
                        </select>
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" id="edit_content" name="content"></textarea>
                    </div>

                    <div class="mb-3 col-12">
                        <button class="btn btn-falcon-primary">Update</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- Edit Policy Modal End -->

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

        fetchPolicy();

        function fetchPolicy() {

            Swal.fire({
                title: 'Please wait...',
                text: 'Loading Policies...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('website.policy.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, policy) {

                        rows += `<tr>
                    <td>${index + 1}</td>
                    <td class="title">${policy.title}</td>
                    <td class="slug">${policy.slug}</td>
                    
                    <td>
                        ${policy.content ? policy.content.substring(0, 80) + '...' : ''}
                    </td>

                    <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${policy.id}" 
                            ${policy.status == 1 ? 'checked' : ''} />
                        </div>
                    </td>

                    <td class="date">${formatDate(policy.created_at)}</td>

                    <td>
                        <div class="text-center">
                            <a href="/policy/${policy.slug}" class="btn btn-link p-0" target="_blank">
                                <span class="text-primary fas fa-eye"></span></a> | 
                            
                            <button class="btn btn-link p-0 edit-btn" type="button" data-id="${policy.id}">
                                <span class="text-primary fas fa-edit"></span></button> | 

                            <button class="btn btn-link p-0 delete-btn" type="button" data-id="${policy.id}">
                                <span class="text-danger fas fa-trash-alt"></span></button>
                        </div>
                    </td>
                </tr>`;
                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {
                        valueNames: ['title', 'slug', 'date'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }




        // Store
        $(document).ready(function() {

            $("#storePolicy").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true
                    },
                    slug: {
                        required: true
                    },
                    content: {
                        required: function() {
                            tinymce.triggerSave();
                            return true;
                        }
                    }
                },
                messages: {
                    title: {
                        required: "Title is required"
                    },
                    slug: {
                        required: "Slug is required"
                    },
                    content: {
                        required: "Content is required"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    error.insertAfter(element);
                }
            });

            $('#submitBtn').on('click', function(e) {
                e.preventDefault();

                tinymce.triggerSave();

                if ($("#storePolicy").valid()) {

                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('website.policy.store') }}",
                        type: "POST",
                        data: $("#storePolicy").serialize(),
                        success: function(response) {
                            Swal.close();
                            Swal.fire("Success!", response.success, "success");

                            fetchPolicy();
                            $('#addModal').modal('hide');
                            $("#storePolicy")[0].reset();
                            tinymce.get("content").setContent('');
                        },
                        error: function(xhr) {
                            Swal.close();
                            let msg = xhr.responseJSON?.message ?? "Something went wrong!";
                            Swal.fire("Error!", msg, "error");
                        }
                    });
                }
            });

        });

        // Open Edit Modal & Load Data
        $(document).on('click', '.edit-btn', function() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let id = $(this).data('id');

            $.ajax({
                url: "/website/policy-page/" + id + "/edit",
                type: "GET",
                success: function(res) {
                    $('#edit_id').val(res.policy.id);
                    $('#edit_title').val(res.policy.title);
                    tinymce.get('edit_content').setContent(res.policy.content || "");

                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    Swal.fire("Error", "Failed to load policy data", "error");
                }
            });
        });

        // Update AJAX
        $("#updatePolicy").submit(function(e) {
            e.preventDefault();

            let id = $("#edit_id").val();
            let formData = new FormData(this);
            formData.append("content", tinymce.get("edit_content").getContent());

            Swal.fire({
                title: "Updating...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "/website/policy-page/" + id,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#editModal').modal('hide');
                    Swal.fire("Success", res.success, "success");
                    fetchPolicy(); // reload list
                },
                error: function() {
                    Swal.fire("Error", "Update failed!", "error");
                }
            });
        });

        // Delete 
        $(document).on('click', '.delete-btn', function() {
            let policyId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the policy page!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    // SweetAlert loading
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting policy page...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/website/policy-page/${policyId}`,
                        type: "DELETE",
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire("Deleted!", response.success, "success");
                                fetchPolicy(); // Refresh the list
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete policy page.", "error");
                        }
                    });
                }
            });
        });



        $(document).on('change', '.status-toggle', function() {
            var policyId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.policy.status') }}",
                type: "POST",
                data: {
                    id: policyId,
                    status: status
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
                    fetchPolicy(); // make sure this function reloads the policy table/list
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