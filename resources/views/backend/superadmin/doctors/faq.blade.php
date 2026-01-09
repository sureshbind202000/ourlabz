@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Doctor FAQ's</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3" data-list='{"valueNames":["question","answer","date"],"page":10,"pagination":true}'>
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
                                <th class="text-900" data-sort="question">Question?</th>
                                <th class="text-900" data-sort="answer">Asnwer.</th>
                                <th class="text-900">Status</th>
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


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add FAQ</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to add FAQ.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="storeFaq" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="question">Question ?</label>
                        <textarea name="question" id="question" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="answer">Answer.</label>
                        <textarea name="answer" id="answer" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-falcon-primary me-2" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Edit FAQ</h4>
                    <p class="fs-10 mb-0 text-white">Update FAQ.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="updateFaq" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="edit_question">Question ?</label>
                        <textarea name="question" id="edit_question" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_answer">Answer.</label>
                        <textarea name="answer" id="edit_answer" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-falcon-primary me-2">Submit</button>
                    </div>
                </form>
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

        $('#addModalBtn').on('click', function() {
            $('#addModal').modal('show');
        });

        // Fetch
        fetchFaq();

        function fetchFaq() {
            Swal.fire({
                title: 'Please Wait...',
                text: 'FAQs Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ route('doctor.faq.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();
                    let rows = "";
                    $.each(data, function(index, faq) {

                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="question">
                        ${faq.question}
                        </td>
                        <td class="answer">
                        ${faq.answer}
                        </td>
                        <td class="status">
                        <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="${faq.id}" ${faq.is_active == 1 ? 'checked' : ''} />
                        </div>
                        </td>
                        <td class="date">${formatDate(faq.created_at)}</td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-modal-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${faq.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${faq.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['question', 'answer', 'date'],
                        page: 10,
                        pagination: true
                    });
                },
                error: function(xhr) {
                    Swal.close();
                    console.log(xhr);
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeFaq").validate({
                ignore: [],
                rules: {
                    question: {
                        required: true,
                    },
                    answer: {
                        required: true
                    },
                },
                messages: {
                    question: {
                        required: "Question? is required",
                    },
                    answer: {
                        required: "Answer. is required",
                    },
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

                if ($("#storeFaq").valid()) {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    var form = $("#storeFaq")[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('doctor.faq.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            Swal.fire("Success!", response.success, "success");
                            fetchFaq();
                            $('#addModal').modal('hide');
                            window.location.reload();
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
        $(document).on('click', '.edit-modal-btn', function() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let faqId = $(this).data('id');

            $.ajax({
                url: '/doctor-faq/' + faqId + '/edit',
                type: 'GET',
                success: function(response) {
                    Swal.close();
                    var faq = response.faq;
                    console.log(faq);
                    // Basic user info
                    $('#edit_id').val(faq.id);
                    $('#edit_question').val(faq.question);
                    $('#edit_answer').val(faq.answer);
                    $('#editModal').modal('show');

                },
                error: function() {
                    Swal.close();
                    alert('Something went wrong while fetching faq data.');
                }
            });
        });


        // Update User AJAX
        $('#updateFaq').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating FAQ...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var faqId = $('#edit_id').val();
            var formData = new FormData(this);
            formData.append('_method', 'PUT');
            $.ajax({
                url: '/doctor-faq/' + faqId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchFaq();
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
            let faqId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the FAQ!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting FAQ...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/doctor-faq/${faqId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.close();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The FAQ have been deleted.",
                                    "success");
                                fetchFaq();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete FAQ.",
                                "error");
                        }
                    });
                }
            });
        });

        $(document).on('change', '.status-toggle', function() {
            var faqId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('doctor.faq.status.update') }}", // Create this route
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: faqId,
                    status: status
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait...',
                        text: 'Making faq on Top...',
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
                    fetchFaq();
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