@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Homepage Offers</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3" data-list='{"valueNames":["title","type","status","date","sort"],"page":10,"pagination":true}'>
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
                                <th class="text-900">Image</th>
                                <th class="text-900" data-sort="title">Title</th>
                                <th class="text-900">Link</th>
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

<!-- Add offer Modal Start -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Offer</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create new offer.</p>
                </div>
                <div data-bs-theme="dark">
                    <button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body px-4 pb-4">
                <form class="row" id="storeOffer" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 col-md-6">
                        <label for="type" class="form-label">Offer Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled selected>Select type</option>
                            <option value="slider">Slider – Image with link (Homepage top carousel)</option>
                            <option value="content">Content – Image with heading and text</option>
                            <option value="timed_slider">Timed Slider – Image, content, and countdown timer</option>
                        </select>
                        <small class="form-text text-muted mt-1">
                            Choose the type of offer to display. Use:
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li><strong>Slider</strong> – For rotating banners with clickable images.</li>
                                <li><strong>Content</strong> – For static offers with descriptive text.</li>
                                <li><strong>Timed Slider</strong> – For limited-time deals with countdowns.</li>
                            </ul>
                        </small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="image" class="form-label">Upload Offer Image<span class="text-danger">*</span></label>
                        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
                        <small class="form-text text-muted mt-1">
                            Recommended image sizes based on offer type:
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li><strong>Slider</strong>: 410 x 200 px</li>
                                <li><strong>Content</strong>: 1920 x 500 px</li>
                                <li><strong>Timed Slider</strong>: 600 x 400 px</li>
                            </ul>
                            Use JPG, WEBP or PNG formats. Max file size: 2MB.
                        </small>
                    </div>



                    <div class="mb-3 col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Offer title">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="https://example.com">
                    </div>

                    <div class="mb-3 col-md-12 d-none" id="contentField">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" id="content" name="content" rows="3"></textarea>
                    </div>


                    <div class="mb-3 col-md-6 d-none" id="timerField">
                        <label for="timer_end_at" class="form-label">Timer End At</label>
                        <input type="date" class="form-control" id="timer_end_at" name="timer_end_at">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_active">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
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

<!-- Add Package Modal End -->
<!-- Edit Package Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Banner</h4>
                    <p class="fs-10 mb-0 text-white">Update Banner details.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form class="row" id="updateOffer" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3 col-md-6">
                        <label for="type" class="form-label">Offer Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_type" name="type" required>
                            <option value="" disabled selected>Select type</option>
                            <option value="slider">Slider – Image with link (Homepage top carousel)</option>
                            <option value="content">Content – Image with heading and text</option>
                            <option value="timed_slider">Timed Slider – Image, content, and countdown timer</option>
                        </select>
                        <small class="form-text text-muted mt-1">
                            Choose the type of offer to display. Use:
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li><strong>Slider</strong> – For rotating banners with clickable images.</li>
                                <li><strong>Content</strong> – For static offers with descriptive text.</li>
                                <li><strong>Timed Slider</strong> – For limited-time deals with countdowns.</li>
                            </ul>
                        </small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="image" class="form-label">Upload Offer Image<span class="text-danger">*</span></label>
                        <input class="form-control" id="edit_image" name="image" type="file" accept="image/*" />
                        <small class="form-text text-muted mt-1">
                            Recommended image sizes based on offer type:
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li><strong>Slider</strong>: 410 x 200 px</li>
                                <li><strong>Content</strong>: 1920 x 500 px</li>
                                <li><strong>Timed Slider</strong>: 600 x 400 px</li>
                            </ul>
                            Use JPG, WEBP or PNG formats. Max file size: 2MB.
                        </small>
                        <!-- Image Preview -->
                        <div class="mt-2">
                            <img id="PreviewOfferImage" src="/backend/assets/img/team/avatar.png" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    </div>



                    <div class="mb-3 col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter Offer title">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" id="edit_link" name="link" placeholder="https://example.com">
                    </div>

                    <div class="mb-3 col-md-12 d-none" id="edit_contentField">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" id="edit_content" name="content" rows="3"></textarea>
                    </div>


                    <div class="mb-3 col-md-6 d-none" id="edit_timerField">
                        <label for="timer_end_at" class="form-label">Timer End At</label>
                        <input type="date" class="form-control" id="edit_timer_end_at" name="timer_end_at">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="edit_sort_order" name="sort_order" value="0">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_active" id="edit_is_active">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
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
        fetchOffer();

        function fetchOffer() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading offers...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ url('/website/home/offers/list/homepage') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();
                    let rows = "";
                    $.each(data, function(index, offer) {
                        let offerImage = (offer.image === 'dummy') ?
                            "{{ asset('backend/assets/img/team/avatar.png') }}" :
                            "{{ asset('/') }}" + offer.image;
                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td>${offer.type.toUpperCase()}</td>
                        <td><img class="" src="${offerImage}" alt="Offer Image" style="height:50px;width:50px;"/></td>
                        <td class="title">
                         ${offer.title}
                        </td>
                        <td>
                             ${offer.link}
                        </td>
                        <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${offer.id}" ${offer.is_active == 1 ? 'checked' : ''} />
                        </div>
                        </td>
                        <td>
                        ${offer.sort_order}
                        </td>
                        <td class="date">${formatDate(offer.created_at)}</td>
                        <td>
                            <div>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${offer.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${offer.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['title', 'date', 'status', 'sort'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeOffer").validate({
                ignore: [],
                rules: {
                    type: {
                        required: true
                    },
                    image: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    content: {
                        required: function(element) {
                            if ($('#type').val() === 'content') {
                                return;
                            } else if ($('#type').val() === 'timed_slider') {
                                return;
                            }
                        }
                    },
                    link: {
                        required: true
                    },
                    timer_end_at: {
                        required: function(element) {
                            return $('#type').val() === 'timed_slider';
                        }
                    },
                },
                messages: {
                    type: "Offer type is required",
                    image: "Offer image is required",
                    title: "Title is required",
                    content: "Content is required",
                    link: "Link is required",
                    timer_end_at: "Timer end date/time is required for timed sliders",
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

                if ($("#storeOffer").valid()) {

                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    var form = $("#storeOffer")[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('website.home.offer.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            Swal.fire("Success!", response.success, "success");

                            fetchOffer();
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
                text: 'Edit offer form opening...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let offerId = $(this).data('id');

            $.ajax({
                url: '/website/home/offer/' + offerId + '/edit',
                type: 'GET',
                success: function(response) {
                    let offer = response.offer;

                    // Fill form fields
                    $('#edit_id').val(offer.id);
                    $('#edit_type').val(offer.type).trigger('change');
                    $('#edit_title').val(offer.title);
                    $('#edit_link').val(offer.link);
                    $('#edit_sort_order').val(offer.sort_order);
                   
                    $('#edit_is_active').val(offer.is_active ? 1 : 0);
                    tinymce.get('edit_content').setContent(offer.content || '');

                    // Show/Hide conditional fields
                    if (offer.type === 'timed_slider') {
                         let dateOnly = offer.timer_end_at.substring(0, 10); // "2025-06-20"
                    $('#edit_timer_end_at').val(dateOnly);
                        $('#timerField').removeClass('d-none');
                    } else {
                        $('#timerField').addClass('d-none');
                    }

                    if (offer.type === 'slider') {
                        $('#edit_timerField').addClass('d-none');
                        $('#edit_contentField').addClass('d-none');
                    } else if (offer.type === 'content') {
                        $('#edit_timerField').addClass('d-none');
                        $('#edit_contentField').removeClass('d-none');
                    } else if (offer.type === 'timed_slider') {
                        $('#edit_timerField').removeClass('d-none');
                        $('#edit_contentField').removeClass('d-none');
                    } else {
                        $('#edit_timerField').addClass('d-none');
                        $('#edit_contentField').addClass('d-none');
                    }

                    // Preview image
                    if (!offer.image || offer.image === 'dummy') {
                        $('#PreviewOfferImage').attr('src', '/backend/assets/img/team/avatar.png');
                    } else {
                        $('#PreviewOfferImage').attr('src', '/' + offer.image);
                    }

                    // Show the modal
                    $('#editModal').modal('show');
                    Swal.close();
                },
                error: function() {
                    Swal.close();
                    Swal.fire("Error!", "Something went wrong while fetching offer data.", "error");
                }
            });
        });



        // Update AJAX
        $('#updateOffer').submit(function(e) {
            e.preventDefault();

            let offerId = $('#edit_id').val();
            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            // SweetAlert loading indicator
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating offer...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/website/home/offer/' + offerId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.close();
                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchOffer();
                    $('#updateOffer')[0].reset();
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
            let offerId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the offer!",
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
                        text: 'Deleting offer...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/website/home/offer/${offerId}`,
                        type: "DELETE",
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The offer have been deleted.",
                                    "success");
                                fetchOffer();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }

                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete banner.",
                                "error");
                        }
                    });
                }
            });
        });

        $(document).on('change', '.status-toggle', function() {
            var bannerId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.home.offer.status') }}", // Create this route
                type: "POST",
                data: {
                    id: bannerId,
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
                    fetchOffer();
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

        $(document).on('change', '.product-toggle', function() {
            var bannerId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.banner.product.status') }}", // Create this route
                type: "POST",
                data: {
                    id: bannerId,
                    status: status
                },
                beforeSend: function() {
                    // SweetAlert loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Updating product status...',
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
                        title: 'Product status updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    fetchOffer();
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
<script>
    $(document).ready(function() {
        $('#type').on('change', function() {
            if ($(this).val() === 'slider') {
                $('#timerField').addClass('d-none');
                $('#contentField').addClass('d-none');
            } else if ($(this).val() === 'content') {
                $('#timerField').addClass('d-none');
                $('#contentField').removeClass('d-none');
            } else if ($(this).val() === 'timed_slider') {
                $('#timerField').removeClass('d-none');
                $('#contentField').removeClass('d-none');
            } else {
                $('#timerField').addClass('d-none');
                $('#contentField').addClass('d-none');
            }
        });
    });
</script>
@endsection