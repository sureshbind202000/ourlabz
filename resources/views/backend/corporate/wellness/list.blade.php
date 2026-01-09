@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Corporate Wellness Programs</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["title","content"],"page":10,"pagination":true}'>

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

                                <th class="text-900">Image</th>

                                <th class="text-900" data-sort="title">Title</th>

                                <th class="text-900" data-sort="content">Content</th>

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



<!-- Add Package Modal Start -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Wellness Program</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new wellness program.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="storeWellness" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3 col-12">

                        <label class="form-label" for="image">Upload Image <span class="text-danger">*</span></label>

                        <input class="form-control" id="image" name="image" type="file" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label">Title <span class="text-danger">*</span></label>

                        <input class="form-control" id="title" name="title" type="text"

                            placeholder="Enter Title" />

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label">Content <span class="text-danger">*</span></label>

                    </div>



                    <div class="content-container mb-3">



                    </div>

                    <div class="mb-3 col-12 d-flex gap-2">

                        <input class="form-control" id="content" name="content" type="text"

                            placeholder="Enter one line content then click add" />

                        <button class="btn btn-sm btn-falcon-primary d-flex gap-2 align-items-center add-content-btn"><i

                                class="fa-solid fa-plus "></i> Add</button>

                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" name="description" id="description"></textarea>
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

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Wellness Program</h4>

                    <p class="fs-10 mb-0 text-white">Update wellness program details.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="updateWellness" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_image">Upload Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="edit_image" name="image" type="file" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="preview_image">Preview Image</label>

                        <br>

                        <img src="" alt="Wellness program image" id="PreviewWellnessImage" height="100">

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_title">Title <span class="text-danger">*</span></label>

                        <input class="form-control" id="edit_title" name="title" type="text"

                            placeholder="Enter Title" />

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label">Content <span class="text-danger">*</span></label>

                    </div>



                    <div class="edit_content-container mb-3">



                    </div>

                    <div class="mb-3 col-12 d-flex gap-2">

                        <input class="form-control" id="edit_content" name="content" type="text"

                            placeholder="Enter one line content then click add" />

                        <button

                            class="btn btn-sm btn-falcon-primary d-flex gap-2 align-items-center add-content-btn"><i

                                class="fa-solid fa-plus "></i> Add</button>

                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label" for="edit_description">Description <span class="text-danger">*</span></label>
                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" name="description" id="edit_description"></textarea>
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

        fetchWellness();



        function fetchWellness() {

            Swal.fire({

                title: 'Please wait...',

                text: 'Loading wellness programs...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            $.ajax({

                url: "{{ route('corporate.wellness.list') }}",

                type: "GET",

                success: function(data) {

                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, wellness) {

                        let wellnessImage = (wellness.image === 'dummy') ?

                            "{{ asset('backend/assets/img/team/avatar.png') }}" :

                            "{{ asset('/') }}" + wellness.image;

                        rows += `

    <tr>

        <td>${index + 1}</td>

        <td><img src="${wellnessImage}" alt="wellness Image" style="height:50px;width:50px;"/></td>

        <td class="title">${wellness.title}</td>

        <td class="content">

            <ul class="mb-0 ps-0" type="none">

                ${wellness.content.map(line => `<li><i class='fa-solid fa-arrow-right text-primary me-1'></i> ${line}</li>`).join('')}

            </ul>

        </td>

        <td class="status">

            <div class="form-check form-switch">

                <input class="form-check-input status-toggle" type="checkbox" data-id="${wellness.id}" ${wellness.status == 1 ? 'checked' : ''} />

            </div>

        </td>

        <td class="date">${formatDate(wellness.created_at)}</td>

        <td>

            <div>

                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"

                        data-bs-placement="top" title="Edit" data-id="${wellness.id}">

                    <span class="text-primary fas fa-edit"></span>

                </button>

                <a href="/corporate-wellness/${wellness.encrypted_id}/details" class="btn btn-link p-0 ms-2 d-none" data-bs-toggle="tooltip"

                        data-bs-placement="top" title="Add details" data-id="${wellness.id}"><i class="fa-solid fa-plus"></i></a>

                <button class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                        data-bs-placement="top" title="Delete" data-id="${wellness.id}">

                    <span class="text-danger fas fa-trash-alt"></span>

                </button>

            </div>

        </td>

    </tr>

`;



                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {

                        valueNames: ['title', 'content'],

                        page: 10,

                        pagination: true

                    });

                }

            });

        }



        // Store

        $(document).ready(function() {

            var validator = $("#storeWellness").validate({

                ignore: [],

                rules: {

                    title: {

                        required: true,

                    },

                    image: {

                        required: true

                    },
                    description: {
                        required: function() {
                            tinymce.triggerSave();
                            return true;
                        }
                    }

                },

                messages: {

                    title: {

                        required: "Title is required",

                    },

                    image: "Image is required",
                    description: "Descritpion is required",

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



                if ($('.content-container input[name="contents[]"]').length === 0) {

                    Swal.fire("Error",

                        "Please add at least one content line before submitting.", "error");

                    return;

                }



                if ($("#storeWellness").valid()) {



                    Swal.fire({

                        title: 'Uploading...',

                        text: 'Please wait...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    var form = $("#storeWellness")[0];

                    var formData = new FormData(form);



                    $.ajax({

                        url: "{{ route('corporate.wellness.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            Swal.close();

                            Swal.fire("Success!", response.success, "success");



                            fetchWellness();

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

                text: 'Edit wellness program form opening...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            let wellnessId = $(this).data('id');



            $.ajax({

                url: '/corporate-wellness/' + wellnessId + '/edit',

                type: 'GET',

                success: function(response) {



                    var wellness = response.wellness;



                    // Basic user info

                    $('#edit_id').val(wellness.id);

                    $('#edit_title').val(wellness.title);
                    tinymce.get('edit_description').setContent(wellness.description || "");

                    $('.edit_content-container').empty(); // Clear old content



                    let contents = Array.isArray(wellness.content) ? wellness.content : [];



                    contents.forEach(function(line) {

                        if (line.trim() !== '') {

                            let item = `

                <div class="d-flex justify-content-between align-items-center mb-2 content-item">

                    <input type="hidden" name="contents[]" value="${line}">

                    <div class="flex-grow-1">

                        <i class="fa-solid fa-arrow-right text-primary me-2"></i> ${line}

                    </div>

                    <button type="button" class="btn btn-sm btn-danger remove-content">

                        <i class="fa fa-trash"></i>

                    </button>

                </div>

            `;

                            $('.edit_content-container').append(item);

                        }

                    });





                    if (wellness.image == 'dummy') {

                        $('#PreviewWellnessImage').attr('src',

                            '/backend/assets/img/team/avatar.png');

                    } else {

                        $('#PreviewWellnessImage').attr('src', '/' + wellness.image);;

                    }



                    $('#editModal').modal('show');

                    Swal.close();

                },

                error: function(xhr) {

                    console.log(xhr);

                    Swal.close();

                    alert('Something went wrong while fetching wellness program data.');

                }

            });

        });





        // Update AJAX

        $('#updateWellness').submit(function(e) {

            e.preventDefault();



            let wellnessId = $('#edit_id').val();

            let formData = new FormData(this);
            formData.append("description", tinymce.get("edit_description").getContent());
            formData.append('_method', 'PUT');



            // SweetAlert loading indicator

            Swal.fire({

                title: 'Please wait...',

                text: 'Updating wellness program...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $.ajax({

                url: '/corporate-wellness/' + wellnessId,

                type: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(response) {

                    Swal.close();

                    $('#editModal').modal('hide');

                    Swal.fire("Success!", response.success, "success");

                    fetchWellness();

                    $('#updateWellness')[0].reset();

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

            let wellnessId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the wellness program!",

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

                        text: 'Deleting wellness program...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: `/corporate-wellness/${wellnessId}`,

                        type: "DELETE",

                        success: function(response) {

                            Swal.close();

                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The wellness program have been deleted.",

                                    "success");

                                fetchWellness();

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }



                        },

                        error: function(xhr) {

                            Swal.close();

                            Swal.fire("Error!",

                                "Failed to delete wellness program.",

                                "error");

                        }

                    });

                }

            });

        });



        $(document).on('change', '.status-toggle', function() {

            var wellnessId = $(this).data('id');

            var status = $(this).is(':checked') ? 1 : 0;



            $.ajax({

                url: "{{ route('corporate.wellness.status') }}", // Create this route

                type: "POST",

                data: {

                    id: wellnessId,

                    status: status

                },

                beforeSend: function() {

                    // SweetAlert loading indicator

                    Swal.fire({

                        title: 'Please wait...',

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

                    fetchWellness();

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

<script>
    $(document).ready(function() {

        // Handle the Add Content button click (for both add & edit)

        $(document).on('click', '.add-content-btn', function(e) {

            e.preventDefault();



            let form = $(this).closest('form');

            let input = form.find('input[name="content"]');

            let contentValue = input.val().trim();



            if (contentValue === '') {

                Swal.fire("Warning", "Please enter content before adding.", "warning");

                return;

            }



            let contentItem = `

            <div class="d-flex justify-content-between align-items-center mb-2 content-item">

                <input type="hidden" name="contents[]" value="${contentValue}">

                <div class="flex-grow-1"><i class="fa-solid fa-arrow-right text-primary"></i> ${contentValue}</div>

                <button type="button" class="btn btn-sm btn-danger remove-content">

                    <i class="fa fa-trash"></i>

                </button>

            </div>

        `;



            // Append to proper container inside the form

            form.find('.edit_content-container, .content-container').append(contentItem);

            input.val('');

        });



        // Handle remove content (both add/edit)

        $(document).on('click', '.remove-content', function() {

            $(this).closest('.content-item').remove();

        });





    });
</script>

@endsection