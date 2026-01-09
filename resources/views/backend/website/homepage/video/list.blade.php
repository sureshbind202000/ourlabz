@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Homepage Video Gallery</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["title","popuplink","link","content","status","date"],"page":10,"pagination":true}'>

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

                                <th class="text-900" data-sort="title">Title</th>

                                <th class="text-900" data-sort="content">Content</th>

                                <th class="text-900" data-sort="link">Link</th>

                                <th class="text-900" data-sort="popuplink">Popup Link</th>

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

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Video Gallery</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to add new video gallery.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="storeVideo" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3 col-12">

                        <label class="form-label" for="title">Video Title</label>

                        <input class="form-control" id="title" name="title" type="text"

                            placeholder="Enter video title" required/>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="content">Content</label>

                        <textarea name="content" id="content" class="form-control" rows="3" placeholder="Enter video content" required></textarea>

                    </div>
                    <div class="mb-3 col-12">

                        <label class="form-label" for="link">Video Link</label>

                        <input class="form-control" id="link" name="link" type="text"

                            placeholder="Enter video link" required/>

                    </div>
                    <div class="mb-3 col-12">

                        <label class="form-label" for="popup_link">Popup Link (optional)</label>

                        <input class="form-control" id="popup_link" name="popup_link" type="text"

                            placeholder="Enter video popup link" />

                    </div>

                    <div class="mb-3 col-4">

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

                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Video Gallery</h4>

                    <p class="fs-10 mb-0 text-white">Update video details.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="updateVideo" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_title">Video Title</label>

                        <input class="form-control" id="edit_title" name="title" type="text"

                            placeholder="Enter video title" required/>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_content">Content</label>

                        <textarea name="content" id="edit_content" class="form-control" rows="3" placeholder="Enter video content" required></textarea>

                    </div>
                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_link">Video Link</label>

                        <input class="form-control" id="edit_link" name="link" type="text"

                            placeholder="Enter video link" required/>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_popup_link">Popup Link (optional)</label>

                        <input class="form-control" id="edit_popup_link" name="popup_link" type="text"

                            placeholder="Enter video popup link" />

                    </div>

                    <div class="mb-3 col-4">

                        <label class="form-label" for="edit_sort_order">Sorting Value</label>

                        <input class="form-control" id="edit_sort_order" name="sort_order" type="number" value="0" />

                    </div>



                    <div class="mb-3">

                        <button class="btn btn-falcon-primary me-2" type="submit">Submit</button>

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

        fetchVideo();



        function fetchVideo() {

            Swal.fire({

                title: 'Please wait...',

                text: 'Loading videos...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            $.ajax({

                url: "{{ route('website.home.video.list') }}",

                type: "GET",

                success: function(data) {

                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, video) {

                        rows += `<tr>

                        <td>${index + 1}</td>

                        <td class="title">${video.title}</td>

                        <td class="content">

                         ${video.content}

                        </td>

                        <td>
                            <iframe width="200" height="120"
                                src="${video.link.replace('watch?v=', 'embed/').replace('youtu.be/', 'youtube.com/embed/')}"
                                frameborder="0" allowfullscreen>
                            </iframe>
                        </td>
                        <td>

                            ${video.popup_link}

                        </td>

                        <td class="status">

                        <div class="form-check form-switch">

                            <input class="form-check-input status-toggle" type="checkbox" data-id="${video.id}" ${video.is_active == 1 ? 'checked' : ''} />

                        </div>

                        </td>

                        <td class="sort">

                        ${video.sort_order}

                        </td>

                        <td class="date">${formatDate(video.created_at)}</td>

                        <td>

                            <div>

                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Edit" data-id="${video.id}"><span

                                                    class="text-primary fas fa-edit"></span></button>

                                                    <button

                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Delete" data-id="${video.id}"><span

                                                    class="text-danger fas fa-trash-alt"></span></button>

                                                    </div>

                            

                        </td>

                    </tr>`;

                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {

                        valueNames: ['title','link','content','popuplink', 'date', 'status', 'sort'],

                        page: 10,

                        pagination: true

                    });

                }

            });

        }



        // Store

        $(document).ready(function() {

            var validator = $("#storeVideo").validate({

                ignore: [],

                rules: {

                    title: {

                        required: true,

                    },

                    content: {

                        required: true,

                    },

                    link: {

                        required: true,

                    }

                },

                messages: {

                    title: {

                        required: "Video title is required",

                    },

                    content: {

                        required: "Video content is required",

                    },

                    link: {

                        required: "Video link is required",

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



                if ($("#storeVideo").valid()) {



                    Swal.fire({

                        title: 'Uploading...',

                        text: 'Please wait',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    var form = $("#storeVideo")[0];

                    var formData = new FormData(form);



                    $.ajax({

                        url: "{{ route('website.home.video.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            Swal.close();

                            Swal.fire("Success!", response.success, "success");



                            fetchVideo();

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

                text: 'Edit video gallery form opening...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            let videoId = $(this).data('id');



            $.ajax({

                url: '/website/home/video/' + videoId + '/edit',

                type: 'GET',

                success: function(response) {



                    var video = response.video;



                    // Basic user info

                    $('#edit_id').val(video.id);

                    $('#edit_title').val(video.title);

                    $('#edit_content').val(video.content);

                    $('#edit_link').val(video.link);

                    $('#edit_popup_link').val(video.popup_link);

                    $('#edit_sort_order').val(video.sort_order);


                    $('#editModal').modal('show');

                    Swal.close();

                },

                error: function() {

                    Swal.close();

                    alert('Something went wrong while fetching brand data.');

                }

            });

        });





        // Update AJAX

        $('#updateVideo').submit(function(e) {

            e.preventDefault();



            let videoId = $('#edit_id').val();

            let formData = new FormData(this);

            formData.append('_method', 'PUT');



            // SweetAlert loading indicator

            Swal.fire({

                title: 'Please wait...',

                text: 'Updating video...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $.ajax({

                url: '/website/home/video/' + videoId,

                type: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(response) {

                    Swal.close();

                    $('#editModal').modal('hide');

                    Swal.fire("Success!", response.success, "success");

                    fetchVideo();

                    $('#updateVideo')[0].reset();

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

            let videoId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the brand!",

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

                        text: 'Deleting video...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: `/website/home/video/${videoId}`,

                        type: "DELETE",

                        success: function(response) {

                            Swal.close();

                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The video have been deleted.",

                                    "success");

                                fetchVideo();

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }



                        },

                        error: function(xhr) {

                            Swal.close();

                            Swal.fire("Error!", "Failed to delete video.",

                                "error");

                        }

                    });

                }

            });

        });



        $(document).on('change', '.status-toggle', function() {

            var videoId = $(this).data('id');

            var status = $(this).is(':checked') ? 1 : 0;



            $.ajax({

                url: "{{ route('website.home.video.status') }}", // Create this route

                type: "POST",

                data: {

                    id: videoId,

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

                    fetchVideo();

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