@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Homepage Testimonials</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3" data-list='{"valueNames":["title","rating","name","status"],"page":10,"pagination":true}'>
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
                                <th class="text-900" data-sort="title">Title</th>
                                <th class="text-900">Image</th>
                                <th class="text-900">Message</th>
                                <th class="text-900" data-sort="rating">Rating</th>
                                <th class="text-900" data-sort="status">Status</th>
                                <th class="text-900" data-sort="sort">Sort</th>
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
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Testimonial</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to add new testimonial.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="storeTestimonial" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 col-6">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="Enter Name" />
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" id="title" name="title" type="text"
                            placeholder="Enter title" />
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="image">Image <span
                                class="text-danger">*</span></label>
                        <input class="form-control" id="image" name="image" type="file" />
                        <small class="form-text text-muted mt-1">
                            Recommended image size :
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li>100 x 100 px</li>
                                <li>Use JPG, PNG and WEBP format.</li>
                                <li>Max file size: 2MB.</li>
                            </ul>
                        </small>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label" for="message">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Enter Message"></textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="link">Rating</label>
                        <select name="rating" id="rating" class="form-select">
                            <option value="">--select--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="sort_order">Sorting Value</label>
                        <input class="form-control" id="sort_order" name="sort_order" type="number" value="0" />
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
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Testimonial</h4>
                    <p class="fs-10 mb-0 text-white">Update Testimonial details.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="updateTestimonial" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3 col-6">
                        <label class="form-label" for="edit_name">Name</label>
                        <input class="form-control" id="edit_name" name="name" type="text"
                            placeholder="Enter Name" />
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="edit_title">Title</label>
                        <input class="form-control" id="edit_title" name="title" type="text"
                            placeholder="Enter title" />
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="edit_image">Image <span
                                class="text-danger">*</span></label>
                        <input class="form-control" id="edit_image" name="image" type="file" />
                        
                    </div>
                    <div class="mb-3 col-6">
                        <div class="mt-2">
                            <img id="PreviewTestimonialImage" src="#" alt="Image Preview" style="max-height: 100px;" />
                        </div>
                        
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label" for="edit_message">Message</label>
                        <textarea name="message" id="edit_message" class="form-control" rows="3" placeholder="Enter Message"></textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="edit_rating">Rating</label>
                        <select name="rating" id="edit_rating" class="form-select">
                            <option value="">--select--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label" for="edit_sort_order">Sorting Value</label>
                        <input class="form-control" id="edit_sort_order" name="sort_order" type="number" value="0" />
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
        fetchTestimonial();

        function fetchTestimonial() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading Testimonials...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ route('website.home.testimonial.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();
                    let rows = "";
                    $.each(data, function(index, testimonial) {
                        let testimonialImage = (testimonial.image === 'dummy') ?
                            "{{ asset('backend/assets/img/team/avatar.png') }}" :
                            "{{ asset('/') }}" + testimonial.image;
                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="name">
                         ${testimonial.name}
                        </td>
                        <td class="title">
                         ${testimonial.title}
                        </td>
                        <td><img class="" src="${testimonialImage}" alt="Testimonial Image" style="height:50px;width:50px;"/></td>
                        
                        <td>
                            ${testimonial.message}
                        </td>
                        <td>
                            ${testimonial.rating}
                        </td>
                        <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${testimonial.id}" ${testimonial.is_active == 1 ? 'checked' : ''} />
                        </div>
                        </td>
                        <td class="sort">
                        ${testimonial.sort_order}
                        </td>
                        <td class="date">${formatDate(testimonial.created_at)}</td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${testimonial.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${testimonial.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['name', 'title', 'rating', 'date', 'status', 'sort'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeTestimonial").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                    rating: {
                        required: true,
                    },
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png|webp"
                    }
                },
                messages: {
                    name: {
                        required: "Name is required",
                    },
                    title: {
                        required: "Title is required",
                    },
                    message: {
                        required: "Message is required",
                    },
                    rating: {
                        required: "Rating is required",
                    },
                    image: {
                        required: "Image is required",
                        extension: "Only jpg, jpeg, png, webp formats are allowed"
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

                if ($("#storeTestimonial").valid()) {

                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    var form = $("#storeTestimonial")[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('website.home.testimonial.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            Swal.fire("Success!", response.success, "success");

                            fetchTestimonial();
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
                text: 'Edit testimonial form opening...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let testimonialId = $(this).data('id');

            $.ajax({
                url: '/website/home/testimonial/' + testimonialId + '/edit',
                type: 'GET',
                success: function(response) {

                    var testimonial = response.testimonial;

                    // Basic user info
                    $('#edit_id').val(testimonial.id);
                    $('#edit_name').val(testimonial.name);
                    $('#edit_title').val(testimonial.title);
                    $('#edit_message').val(testimonial.message);
                    $('#edit_rating').val(testimonial.rating).change();
                    $('#edit_sort_order').val(testimonial.sort_order);

                    if (testimonial.image == 'dummy') {
                        $('#PreviewTestimonialImage').attr('src',
                            '/backend/assets/img/team/avatar.png');
                    } else {
                        $('#PreviewTestimonialImage').attr('src', '/' + testimonial.image);;
                    }

                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    alert('Something went wrong while fetching testimonial data.');
                }
            });
        });


        // Update AJAX
        $('#updateTestimonial').submit(function(e) {
            e.preventDefault();

            let testimonialId = $('#edit_id').val();
            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            // SweetAlert loading indicator
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating testimonial...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/website/home/testimonial/' + testimonialId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.close();
                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchTestimonial();
                    $('#updateTestimonial')[0].reset();
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
            let testimonialId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the testimonial!",
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
                        text: 'Deleting testimonial...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/website/home/testimonial/${testimonialId}`,
                        type: "DELETE",
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The testimonial have been deleted.",
                                    "success");
                                fetchTestimonial();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }

                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete testimonial.",
                                "error");
                        }
                    });
                }
            });
        });

        $(document).on('change', '.status-toggle', function() {
            var testimonialId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.home.testimonial.status') }}",
                type: "POST",
                data: {
                    id: testimonialId,
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
                    fetchTestimonial();
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