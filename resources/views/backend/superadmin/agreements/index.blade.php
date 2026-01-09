@extends('backend.includes.layout')

@section('content')

    <div class="card mb-3">

        <div class="card-header">

            <div class="row flex-between-end">

                <div class="col-auto align-self-center">

                    <h5 class="mb-0" data-anchor="data-anchor">Agreements</h5>

                </div>

            </div>

        </div>

        <div class="card-body pt-0">

            <div class="tab-content">



                <div id="tableExample3"

                    data-list='{"valueNames":["type","title","target","status","date","createdBy"],"page":10,"pagination":true}'>

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

                                    <th class="text-900" data-sort="type">Type</th>

                                    <th class="text-900" data-sort="title">Title</th>

                                    <th class="text-900" data-sort="target">Target</th>

                                    <th class="text-900" data-sort="status">Status</th>

                                    <th class="text-900" data-sort="date">Created At</th>

                                    <th class="text-900" data-sort="createdBy">Created By</th>

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



    <!-- Add Agreement Modal Start -->

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content border-0">

                <div class="modal-header position-relative modal-shape-header bg-shape">

                    <div class="position-relative z-1">

                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Agreement</h4>

                        <p class="fs-10 mb-0 text-white">Fill the form to create new Agreement.</p>

                    </div>

                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                            data-bs-dismiss="modal" aria-label="Close"></button></div>

                </div>

                <div class="modal-body  px-4 pb-4">

                    <form class="row" id="storeAgreement" enctype="multipart/form-data">

                        @csrf



                        <div class="mb-3 col-md-12">

                            <label class="form-label" for="title">Title</label>

                            <input class="form-control" id="title" name="title" type="text"

                                placeholder="Enter Agreement Title" />

                        </div>

                        <div class="mb-3 col-md-12">

                            <label class="form-label" for="description">Description</label>

                            <input class="tinymce" data-tinymce="data-tinymce" id="description" name="description"

                                type="text" placeholder="Enter Agreement Description" />

                        </div>



                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="agreement_type">Agreement Type</label>

                            <select class="form-select" id="agreement_type" name="agreement_type">

                                <option value="">--Select--</option>

                                <option value="policy">Policy</option>

                                <option value="commission">Comission</option>

                                <option value="general">General</option>

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="target_type">Target Type</label>

                            <select class="form-select" id="target_type" name="target_type">

                                <option value="">--Select--</option>

                                <option value="all">All</option>

                                <option value="vendor">Vendor</option>

                                <option value="doctor">Doctor</option>

                                <option value="lab">Lab</option>

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="status">Agreement Status</label>

                            <select class="form-select" id="status" name="status">

                                <option value="draft" selected>Draft</option>

                                <option value="active">Active</option>

                            </select>

                        </div>



                        <div class="col-md-12 mb-3" id="targetUsersSection" style="display: none;">

                            <label>Select Users</label>

                            <select name="target_ids[]" id="selectedIds" class="form-control" multiple>



                            </select>

                        </div>



                        <div class="col-md-12 mb-3" id="vendorCommissionSection" style="display: none;">

                            <div class="row g-2 align-items-end">

                                <div class="col-md-4">

                                    <label class="form-label" for="commission_on">Commission On</label>

                                    <select class="form-select" id="commission_on" name="commission_on">

                                        <option value="">--Select--</option>

                                        <option value="Total Sales">On Total Sales</option>

                                    </select>

                                </div>

                                <div class="col-md-4">

                                    <label class="form-label" for="commission_type">Commission Type</label>

                                    <select class="form-select" id="commission_type" name="commission_type">

                                        <option value="">--Select--</option>

                                        <option value="Percentage">Percentage</option>

                                        <option value="Flat">Flat</option>

                                    </select>

                                </div>

                                <div class="col-md-4">

                                    <label class="form-label" for="commission">Commission</label>

                                    <input type="number" min="0" step="0.01" class="form-control"

                                        id="commission" name="commission" placeholder="Enter commission">

                                </div>

                            </div>

                        </div>



                        <div class="mb-3 col-md-12">

                            <button class="btn btn-falcon-primary me-2" id="submitBtn">Submit</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- Add Agreement Modal End -->

    <!-- Edit Agreement Modal Start -->

    <!-- Edit Agreement Modal Start -->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"

        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content border-0">

                <div class="modal-header position-relative modal-shape-header bg-shape">

                    <div class="position-relative z-1">

                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Agreement</h4>

                        <p class="fs-10 mb-0 text-white">Update agreement details.</p>

                    </div>

                    <div data-bs-theme="dark">

                        <button class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"

                            aria-label="Close"></button>

                    </div>

                </div>

                <div class="modal-body px-4 pb-4">

                    <form class="row" id="updateAgreement" enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" id="edit_id" name="id">



                        <div class="mb-3 col-md-12">

                            <label class="form-label" for="edit_title">Title</label>

                            <input class="form-control" id="edit_title" name="title" type="text"

                                placeholder="Enter Agreement Title" />

                        </div>



                        <div class="mb-3 col-md-12">

                            <label class="form-label" for="edit_description">Description</label>

                            <input class="tinymce" data-tinymce="data-tinymce" id="edit_description" name="description"

                                type="text" placeholder="Enter Agreement Description" />

                        </div>



                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="edit_agreement_type">Agreement Type</label>

                            <select class="form-select" id="edit_agreement_type" name="agreement_type">

                                <option value="">--Select--</option>

                                <option value="policy">Policy</option>

                                <option value="commission">Commission</option>

                                <option value="general">General</option>

                            </select>

                        </div>



                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="edit_target_type">Target Type</label>

                            <select class="form-select" id="edit_target_type" name="target_type">

                                <option value="">--Select--</option>

                                <option value="all">All</option>

                                <option value="vendor">Vendor</option>

                                <option value="doctor">Doctor</option>

                                <option value="lab">Lab</option>

                            </select>

                        </div>



                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="edit_status">Agreement Status</label>

                            <select class="form-select" id="edit_status" name="status">

                                <option value="draft">Draft</option>

                                <option value="active">Active</option>

                            </select>

                        </div>



                        <div class="col-md-12 mb-3" id="editTargetUsersSection" style="display: none;">

                            <label>Select Users</label>

                            <select name="target_ids[]" id="edit_selectedIds" class="form-control" multiple></select>

                        </div>



                        <div class="col-md-12 mb-3" id="editVendorCommissionSection" style="display: none;">

                            <div class="row g-2 align-items-end">

                                <div class="col-md-4">

                                    <label class="form-label" for="edit_commission_on">Commission On</label>

                                    <select class="form-select" id="edit_commission_on" name="commission_on">

                                        <option value="">--Select--</option>

                                        <option value="Total Sales">On Total Sales</option>

                                    </select>

                                </div>

                                <div class="col-md-4">

                                    <label class="form-label" for="edit_commission_type">Commission Type</label>

                                    <select class="form-select" id="edit_commission_type" name="commission_type">

                                        <option value="">--Select--</option>

                                        <option value="Percentage">Percentage</option>

                                        <option value="Flat">Flat</option>

                                    </select>

                                </div>

                                <div class="col-md-4">

                                    <label class="form-label" for="edit_commission">Commission</label>

                                    <input type="number" min="0" step="0.01" class="form-control"

                                        id="edit_commission" name="commission" placeholder="Enter commission">

                                </div>

                            </div>

                        </div>





                        <div class="mb-3 col-md-12">

                            <button class="btn btn-falcon-primary me-2" id="updateBtn">Update</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- Edit Agreement Modal End -->



    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"

        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

            <div class="modal-content border-0 shadow-sm">

                <!-- Header -->

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title text-white" id="viewModalLabel"><i

                            class="fas fa-file-contract me-2"></i>Agreement Details</h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"

                        aria-label="Close"></button>

                </div>



                <!-- Body -->

                <div class="modal-body p-4">

                    <!-- Basic Info Card -->

                    <div class="card mb-3 shadow-sm text-dark">

                        <div class="card-header bg-light">

                            <strong>Agreement Information</strong>

                        </div>

                        <div class="card-body">

                            <div class="row mb-2">

                                <div class="col-md-6"><strong>Title:</strong> <span id="view_title"></span></div>

                                <div class="col-md-6"><strong>Type:</strong> <span id="view_type"></span></div>

                            </div>

                            <div class="row mb-2">

                                <div class="col-md-6"><strong>Target Type:</strong> <span id="view_target_type"></span>

                                </div>

                                <div class="col-md-6"><strong>Status:</strong> <span id="view_status"></span></div>

                            </div>

                            <div class="row mb-2">

                                <div class="col-md-6"><strong>Targets:</strong> <span id="view_targets"></span></div>

                                <div class="col-md-6"><strong>Activated At:</strong> <span id="view_activated_at"></span>

                                </div>

                            </div>

                            <div class="row mb-2">

                                <div class="col-md-6"><strong>Created By:</strong> <span id="view_created_by"></span>

                                </div>

                                <div class="col-md-6"><strong>Created At:</strong> <span id="view_created_at"></span>

                                </div>

                            </div>

                            <div class="row mb-2">

                                <div class="col-md-6"><strong>Updated By:</strong> <span id="view_updated_by"></span>

                                </div>

                                <div class="col-md-6"><strong>Updated At:</strong> <span id="view_updated_at"></span>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- Description Card -->

                    <div class="card mb-3 shadow-sm text-dark">

                        <div class="card-header bg-light">

                            <strong>Description</strong>

                        </div>

                        <div class="card-body">

                            <div id="view_description"></div>

                        </div>

                    </div>



                    <!-- Signatures Card -->

                    <div class="card shadow-sm text-dark">

                        <div class="card-header bg-light">

                            <strong>Signatures</strong>

                        </div>

                        <div class="card-body" id="view_signatures" style="display: flex; flex-wrap: wrap; gap: 20px;">

                            <!-- Signature images will be injected here -->

                        </div>

                    </div>

                </div>



                <!-- Footer (optional actions) -->

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" id="downloadAgreementBtn"><i

                            class="fas fa-download me-2"></i>Download PDF</button>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function() {



            // Initialize Choices.js only once

            let choiceSelect = new Choices('#selectedIds', {

                removeItemButton: true,

                searchEnabled: true,

            });



            // Handle target_type change

            $('#target_type').on('change', function() {

                const type = $(this).val();



                if (type === 'vendor' || type === 'doctor' || type === 'lab') {

                    $('#targetUsersSection').show();



                    // Only show commission section for vendor

                    $('#vendorCommissionSection').toggle(type === 'vendor');



                    // Clear old options

                    choiceSelect.clearStore();



                    // Fetch users via AJAX

                    $.ajax({

                        url: '/get-users/' + type,

                        type: 'GET',

                        success: function(users) {

                            let newChoices = [{

                                value: 'all',

                                label: 'All',

                                selected: false,

                                disabled: false

                            }];



                            users.forEach(user => {

                                newChoices.push({

                                    value: user.id.toString(), // always string

                                    label: `${user.name} (ID: ${user.user_id})`,

                                    selected: false,

                                    disabled: false

                                });

                            });



                            choiceSelect.setChoices(newChoices, 'value', 'label', true);

                        },

                        error: function(xhr) {

                            console.log('Error fetching users:', xhr);

                        }

                    });



                } else {

                    $('#targetUsersSection').hide();

                    $('#vendorCommissionSection').hide();

                    choiceSelect.clearStore();

                }

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

            fetchAgreement();



            function fetchAgreement() {

                Swal.fire({

                    title: 'Please Wait...',

                    text: 'Agreements Loading...',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });

                $.ajax({

                    url: "{{ route('agreements.list') }}",

                    type: "GET",

                    success: function(data) {

                        Swal.close();

                        let rows = "";

                        $.each(data, function(index, agreement) {

                            rows += `<tr>

                               <td>${index + 1}</td>

                               <td>${agreement.type}</td>

                               <td>${agreement.title}</td>

                               <td>${agreement.target}</td>

                               <td>${agreement.status}</td>

                               <td>${agreement.date}</td>

                               <td>${agreement.createdBy}</td>

                               <td>

                                   <div>

                                    <button class="btn btn-link p-0 view-btn" type="button" data-id="${agreement.id}" title="View"><span class="text-secondary fas fa-eye"></span></button>

                                       <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-id="${agreement.id}" title="Edit"><span class="text-primary fas fa-edit"></span></button>

                                       <button class="btn btn-link p-0 ms-2 delete-btn" type="button" data-id="${agreement.id}" title="Delete"><span class="text-danger fas fa-trash-alt"></span></button>

                                   </div>

                               </td>

                           </tr>`;

                        });



                        $("tbody.list").html(rows);

                        new List('tableExample3', {

                            valueNames: ['type', 'title', 'target', 'status', 'date',

                                'createdBy'

                            ],

                            page: 10,

                            pagination: true

                        });

                    }

                });

            }



            // Store Agreement

            $(document).ready(function() {

                const validator = $("#storeAgreement").validate({

                    ignore: [],

                    rules: {

                        title: {

                            required: true,

                            maxlength: 255

                        },

                        agreement_type: {

                            required: true

                        },

                        description: {

                            required: true

                        },

                        target_type: {

                            required: true

                        },

                        status: {

                            required: true

                        }

                    },

                    messages: {

                        title: {

                            required: "Agreement Title is required",

                            maxlength: "Title cannot exceed 255 characters"

                        },

                        agreement_type: {

                            required: "Agreement Type is required"

                        },

                        description: {

                            required: "Agreement Description is required"

                        },

                        target_type: {

                            required: "Target Type is required"

                        },

                        status: {

                            required: "Agreement Status is required"

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



                    if ($("#storeAgreement").valid()) {

                        Swal.fire({

                            title: 'Uploading...',

                            text: 'Please wait',

                            allowOutsideClick: false,

                            didOpen: () => Swal.showLoading()

                        });



                        const form = $("#storeAgreement")[0];

                        const formData = new FormData(form);



                        $.ajax({

                            url: "{{ route('agreements.store') }}",

                            type: "POST",

                            data: formData,

                            contentType: false,

                            processData: false,

                            success: function(response) {

                                Swal.close();

                                Swal.fire("Success!", response.success, "success");

                                fetchAgreement();

                                $('#addModal').modal('hide');

                                window.location.reload();

                            },

                            error: function(xhr) {

                                Swal.close();

                                console.log(xhr);



                                let errorMessage = "An error occurred!";

                                if (xhr.responseJSON) {

                                    errorMessage = xhr.responseJSON.message || xhr

                                        .responseJSON.error || errorMessage;

                                }



                                Swal.fire("Error!", errorMessage, "error");

                            }

                        });

                    }

                });

            });



            // Keep a global reference for Choices instance

            let editChoicesInstance = null;



            // Handle target_type change

            $(document).on('change', '#edit_target_type', function() {

                const type = $(this).val();



                if (type === 'vendor' || type === 'doctor' || type === 'lab') {

                    $('#editTargetUsersSection').show();



                    // Only show commission section for vendor

                    $('#editVendorCommissionSection').toggle(type === 'vendor');



                    // Destroy previous Choices instance if exists

                    if (editChoicesInstance) {

                        editChoicesInstance.destroy();

                    }



                    // Initialize new Choices instance

                    editChoicesInstance = new Choices('#edit_selectedIds', {

                        removeItemButton: true,

                        searchEnabled: true

                    });



                    // Clear old options

                    editChoicesInstance.clearStore();



                    // Fetch users via AJAX

                    $.ajax({

                        url: '/get-users/' + type,

                        type: 'GET',

                        success: function(users) {

                            let newChoices = [{

                                value: 'all',

                                label: 'All',

                                selected: false,

                                disabled: false

                            }];



                            users.forEach(user => {

                                newChoices.push({

                                    value: user.id

                                        .toString(), // convert to string

                                    label: `${user.name} (ID: ${user.user_id})`,

                                    selected: false,

                                    disabled: false

                                });

                            });



                            // Set choices

                            editChoicesInstance.setChoices(newChoices, 'value', 'label', true);



                            // If editing, pre-select the values

                            if ($('#edit_id').val()) {

                                const selectedIds = window.editingTargetIds ||

                            []; // store temporarily

                                if (selectedIds.length > 0) {

                                    editChoicesInstance.setChoiceByValue(selectedIds.map(

                                        String));

                                }

                            }

                        },

                        error: function(xhr) {

                            console.log('Error fetching users:', xhr);

                        }

                    });



                } else {

                    $('#editTargetUsersSection').hide();

                    $('#editVendorCommissionSection').hide();

                    if (editChoicesInstance) editChoicesInstance.clearStore();

                }

            });



            // Open Edit Modal & Load Data

            $(document).on('click', '.edit-btn', function() {

                Swal.fire({

                    title: 'Please wait...',

                    text: 'Loading...',

                    allowOutsideClick: false,

                    didOpen: () => Swal.showLoading()

                });



                const agreementId = $(this).data('id');



                $.ajax({

                    url: '/agreement/' + agreementId + '/edit',

                    type: 'GET',

                    success: function(response) {

                        Swal.close();



                        const agreement = response.agreement;



                        $('#edit_id').val(agreement.id);

                        $('#edit_title').val(agreement.title);



                        if (tinymce.get('edit_description') && agreement.description) {

                            tinymce.get('edit_description').setContent(agreement.description);

                        }



                        $('#edit_agreement_type').val(agreement.agreement_type);

                        $('#edit_target_type').val(agreement.target_type);

                        $('#edit_status').val(agreement.status);



                        window.editingTargetIds = agreement.target_ids || [];



                        $('#edit_target_type').trigger('change');



                        if (agreement.target_type === 'vendor') {

                            $('#edit_commission_on').val(agreement.commission.commission_on ||

                                '');

                            $('#edit_commission_type').val(agreement.commission

                                .commission_type || '');

                            $('#edit_commission').val(agreement.commission.commission || '');

                        }



                        // Show modal

                        $('#editModal').modal('show');

                    },

                    error: function() {

                        Swal.close();

                        Swal.fire('Error',

                            'Something went wrong while fetching agreement data.', 'error');

                    }

                });

            });







            // Update Agreement AJAX

            $('#updateAgreement').submit(function(e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Please wait...',

                    text: 'Updating Agreement...',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });



                var agreementId = $('#edit_id').val();

                var formData = new FormData(this);

                formData.append('_method', 'PUT');

                $.ajax({

                    url: '/agreement/' + agreementId,

                    type: 'POST',

                    data: formData,

                    contentType: false,

                    processData: false,

                    success: function(response) {



                        $('#editModal').modal('hide');

                        Swal.fire("Success!", response.success, "success");

                        fetchAgreement();

                        Swal.close();



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

                let agreementId = $(this).data('id');



                Swal.fire({

                    title: "Are you sure?",

                    text: "This will delete the agreement!",

                    icon: "warning",

                    showCancelButton: true,

                    confirmButtonColor: "#d33",

                    cancelButtonColor: "#3085d6",

                    confirmButtonText: "Yes, delete it!"

                }).then((result) => {

                    if (result.isConfirmed) {

                        Swal.fire({

                            title: 'Please wait...',

                            text: 'Deleting agreement...',

                            allowOutsideClick: false,

                            didOpen: () => {

                                Swal.showLoading();

                            }

                        });



                        $.ajax({

                            url: `/agreement/${agreementId}`,

                            type: "DELETE",

                            data: {

                                _token: "{{ csrf_token() }}"

                            },

                            success: function(response) {

                                Swal.close();



                                if (response.success) {

                                    Swal.fire("Deleted!",

                                        "The agreement have been deleted.",

                                        "success");

                                    fetchAgreement();

                                } else {

                                    Swal.fire("Error!", "Something went wrong.",

                                        "error");

                                }

                            },

                            error: function(xhr) {

                                Swal.close();

                                Swal.fire("Error!", "Failed to delete user.",

                                    "error");

                            }

                        });

                    }

                });

            });



            $(document).on('click', '.view-btn', function() {

                let agreementId = $(this).data('id');



                Swal.fire({

                    title: 'Please wait...',

                    text: 'Loading agreement...',

                    allowOutsideClick: false,

                    didOpen: () => Swal.showLoading()

                });



                $.ajax({

                    url: `/agreement/${agreementId}`,

                    type: 'GET',

                    success: function(response) {

                        Swal.close();



                        const agreement = response.agreement;



                        function formatDate(date) {

                            return date ? new Date(date).toLocaleDateString('en-GB', {

                                day: '2-digit',

                                month: 'long',

                                year: 'numeric'

                            }) : '-';

                        }



                        $('#view_title').text(agreement.title);

                        $('#view_description').html(agreement.description);

                        $('#view_type').text(agreement.agreement_type);

                        $('#view_target_type').text(agreement.target_type);

                        $('#view_targets').text(agreement.targets ? agreement.targets.map(t => t

                            .name).join(', ') : 'All');

                        $('#view_status').text(agreement.status);

                        $('#view_activated_at').text(formatDate(agreement.activated_at));

                        $('#view_created_by').text(agreement.created_by);

                        $('#view_created_at').text(formatDate(agreement.created_at));

                        $('#view_updated_by').text(agreement.updated_by || '-');

                        $('#view_updated_at').text(formatDate(agreement.updated_at));



                        // Render signatures

                        let signaturesHtml = '';

                        if (agreement.signatures && agreement.signatures.length > 0) {

                            agreement.signatures.forEach(sig => {

                               signaturesHtml += `<small class="text-center">

                        <img src="${sig.signature}" alt="Signature" style="height:100px; border:1px solid #ccc;">

                        <br>

                        ${sig.user_name} | ${sig.signed_at}

                        </small>`;

                            });

                        } else {

                            signaturesHtml = '<p>No signatures yet.</p>';

                        }

                        $('#view_signatures').html(signaturesHtml);



                        $('#viewModal').modal('show');

                    },

                    error: function(xhr) {

                        console.log(xhr);

                        Swal.close();

                        Swal.fire('Error', 'Unable to fetch agreement details.', 'error');

                    }

                });

            });



            $(document).on('click', '#downloadAgreementBtn', function() {

                // Select the modal body content

                const element = document.querySelector('#viewModal .modal-body');



                // PDF options

                var opt = {

                    margin: 0,

                    filename: `Agreement_${$('#view_title').text()}.pdf`,

                    image: {

                        type: 'jpeg',

                        quality: 0.98

                    },

                    html2canvas: {

                        scale: 2

                    },

                    jsPDF: {

                        unit: 'in',

                        format: 'letter',

                        orientation: 'portrait'

                    }

                };



                // Generate PDF

                html2pdf().set(opt).from(element).save();

            });



        });

    </script>

@endsection

