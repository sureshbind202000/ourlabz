@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Notification Messages</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3" data-list='{"valueNames":["notification_for"],"page":10,"pagination":true}'>
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
                                    <th class="text-900" data-sort="notification_for">Notification For</th>
                                    <th class="text-900">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
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

    <!-- Add Notification Message Modal Start -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Notification Message</h4>
                        <p class="fs-10 mb-0 text-white">Fill the form to create new notification message.</p>
                    </div>
                    <div data-bs-theme="dark">
                        <button class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form class="row" id="storeNotificationMessage">
                        @csrf

                        <div class="mb-3 col-md-12">
                            <label for="notification_for" class="form-label">Notificatio For</label>
                            <input type="text" class="form-control" id="notification_for" name="notification_for"
                                placeholder="Enter notification for">
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="tinymce" data-tinymce="data-tinymce" id="message" name="message" rows="3"></textarea>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" class="form-control" id="link" name="link"
                                placeholder="https://example.com">
                        </div>


                        <div class="mb-3 col-12 text-end">
                            <input type="hidden" id="page" name="page" value="homepage">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Package Modal Start -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Notification Message</h4>
                        <p class="fs-10 mb-0 text-white">Update Notification Message.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <form class="row" id="updateNotificationMessage">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3 col-md-12">
                            <label for="edit_notification_for" class="form-label">Notification For</label>
                            <input type="text" class="form-control" id="edit_notification_for"
                                name="notification_for" placeholder="https://example.com">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="edit_message" class="form-label">Message</label>
                            <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_message" name="message" rows="3"></textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="edit_link" class="form-label">Link</label>
                            <input type="text" class="form-control" id="edit_link" name="link"
                                placeholder="https://example.com">
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
            fetchMessage();

            function fetchMessage() {
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Loading notification messages...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "{{ route('notification.messages.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";
                        $.each(data, function(index, message) {
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="notification_for">
                         ${message.notification_for}
                        </td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${message.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${message.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['notification_for'],
                            page: 10,
                            pagination: true
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        $("tbody.list").html(' ');
                        Swal.close();
                    }
                });
            }

            // Store
            $(document).ready(function() {
                var validator = $("#storeNotificationMessage").validate({
                    ignore: [],
                    rules: {
                        notification_for: {
                            required: true
                        },
                        message: {
                            required: true
                        },
                        link: {
                            required: true
                        },

                    },
                    messages: {
                        notification_for: "Notification for is required",
                        message: "Notification message is required",
                        link: "link is required",
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

                $(document).on('click', '#submitBtn', function(e) {
                    e.preventDefault();

                    if ($("#storeNotificationMessage").valid()) {

                        Swal.fire({
                            title: 'Uploading...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        var form = $("#storeNotificationMessage")[0];
                        var formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('notification.messages.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.close();
                                Swal.fire("Success!", response.success, "success");

                                fetchMessage();
                                $('#addModal').modal('hide');
                                form.reset();
                            },
                            error: function(xhr) {
                                Swal.close();
                                console.log(xhr);

                                let errorMessage = "An error occurred!";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
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
                    text: 'Edit notification message form opening...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                let messageId = $(this).data('id');

                $.ajax({
                    url: '/notification/messages/' + messageId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        let message = response.message;

                        // Fill form fields
                        $('#edit_id').val(message.id);

                        $('#edit_notification_for').val(message.notification_for);

                        $('#edit_link').val(message.link);

                        tinymce.get('edit_message').setContent(message.message || '');

                        // Show the modal
                        $('#editModal').modal('show');
                        Swal.close();
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire("Error!",
                            "Something went wrong while fetching notification messages data.",
                            "error");
                    }
                });
            });



            // Update AJAX
            $('#updateNotificationMessage').submit(function(e) {
                e.preventDefault();

                let messageId = $('#edit_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                // SweetAlert loading indicator
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Updating notification message...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/notification/messages/' + messageId,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.close();
                        $('#editModal').modal('hide');
                        Swal.fire("Success!", response.success, "success");
                        fetchMessage();
                        $('#updateNotificationMessage')[0].reset();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.close();
                        let errorMessage = "Something went wrong.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire("Error!", errorMessage, "error");
                    }
                });
            });

            // Delete 
            $(document).on('click', '.delete-btn', function() {
                let messageId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the notification message!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // SweetAlert loading indicator
                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Deleting notification message...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: `/notification/messages/${messageId}`,
                            type: "DELETE",
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The notification message have been deleted.",
                                        "success");
                                    fetchMessage();
                                } else {
                                    Swal.fire("Error!", "Something went wrong.",
                                        "error");
                                }

                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire("Error!",
                                    "Failed to delete notification message.",
                                    "error");
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
