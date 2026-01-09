@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">All Blogs</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["title","author"],"page":10,"pagination":true}'>

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

                                <th class="text-900" data-sort="author">Author</th>

                                <th class="text-900">Thumbnail</th>

                                <th class="text-900">Image</th>

                                <th class="text-900">Short Content</th>

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

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Blog</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to add new blog.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="storeBlog" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3 col-6">

                        <label class="form-label" for="title">Title</label>

                        <input class="form-control" id="title" name="title" type="text"

                            placeholder="Enter title" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="author">Author</label>

                        <input class="form-control" id="author" name="author" type="text"

                            placeholder="Enter Author Name" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="thumbnail_image">Thumbnail Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="thumbnail_image" name="thumbnail_image" type="file" />

                        <small class="form-text text-muted mt-1">

                            Recommended image size :

                            <ul class="mb-0 mt-1 ps-3 small">

                                <li>600 x 400 px</li>

                                <li>Use JPG, PNG and WEBP format.</li>

                                <li>Max file size: 2MB.</li>

                            </ul>

                        </small>

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="image">Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="image" name="image" type="file" />

                        <small class="form-text text-muted mt-1">

                            Recommended image size :

                            <ul class="mb-0 mt-1 ps-3 small">

                                <li>1200 x 700 px</li>

                                <li>Use JPG, PNG and WEBP format.</li>

                                <li>Max file size: 2MB.</li>

                            </ul>

                        </small>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="short_content">Short Content</label>

                        <textarea name="short_content" id="short_content" class="form-control" rows="3" placeholder="Enter short content"></textarea>

                    </div>



                    <div class="mb-3 col-12">

                        <label class="form-label" for="content">Content</label>

                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" name="content" id="content" rows="3" placeholder="Enter blog content"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="tags">Tags (optional)</label>

                        <textarea name="tags" id="tags" class="form-control" rows="2" placeholder="Enter tags (Example: tag1,tag2,tag3)"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="meta_title">Meta Title (optional)</label>

                        <textarea name="meta_title" id="meta_title" class="form-control" rows="2" placeholder="Enter meta title"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="meta_description">Meta Description (optional)</label>

                        <textarea name="meta_description" id="meta_description" class="form-control" rows="2" placeholder="Enter meta description"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="meta_keywords">Meta Keywords (optional)</label>

                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="2" placeholder="Enter meta keywords"></textarea>

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

                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit blog</h4>

                    <p class="fs-10 mb-0 text-white">Update blog details.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="updateBlog" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="edit_id" name="id">



                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_title">Title</label>

                        <input class="form-control" id="edit_title" name="title" type="text"

                            placeholder="Enter title" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_author">Author</label>

                        <input class="form-control" id="edit_author" name="author" type="text"

                            placeholder="Enter Author Name" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_thumbnail_image">Thumbnail Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="edit_thumbnail_image" name="thumbnail_image" type="file" />

                        <small class="form-text text-muted mt-1">

                            Recommended image size :

                            <ul class="mb-0 mt-1 ps-3 small">

                                <li>100 x 100 px</li>

                                <li>Use JPG, PNG and WEBP format.</li>

                                <li>Max file size: 2MB.</li>

                            </ul>

                        </small>

                        <div class="mt-2">

                            <img id="PreviewThumbnailImage" src="#" alt="Thumbnail Image Preview" style="max-height: 100px;" />

                        </div>

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_image">Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="edit_image" name="image" type="file" />

                        <small class="form-text text-muted mt-1">

                            Recommended image size :

                            <ul class="mb-0 mt-1 ps-3 small">

                                <li>100 x 100 px</li>

                                <li>Use JPG, PNG and WEBP format.</li>

                                <li>Max file size: 2MB.</li>

                            </ul>

                        </small>

                        <div class="mt-2">

                            <img id="PreviewBlogImage" src="#" alt="Blog Image Preview" style="max-height: 100px;" />

                        </div>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_short_content">Short Content</label>

                        <textarea name="short_content" id="edit_short_content" class="form-control" rows="3" placeholder="Enter short content"></textarea>

                    </div>



                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_content">Content</label>

                        <textarea class="tinymce d-none" data-tinymce="data-tinymce" name="content" id="edit_content" rows="3" placeholder="Enter blog content"></textarea>

                    </div>

 <div class="mb-3 col-12">

                        <label class="form-label" for="edit_tags">Tags (optional)</label>

                        <textarea name="tags" id="edit_tags" class="form-control" rows="2" placeholder="Enter tags (Example: tag1,tag2,tag3)"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_meta_title">Meta Title (optional)</label>

                        <textarea name="meta_title" id="edit_meta_title" class="form-control" rows="2" placeholder="Enter meta title"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_meta_description">Meta Description (optional)</label>

                        <textarea name="meta_description" id="edit_meta_description" class="form-control" rows="2" placeholder="Enter meta description"></textarea>

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_meta_keywords">Meta Keywords (optional)</label>

                        <textarea name="meta_keywords" id="edit_meta_keywords" class="form-control" rows="2" placeholder="Enter meta keywords"></textarea>

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

        fetchBlog();



        function fetchBlog() {

            Swal.fire({

                title: 'Please wait...',

                text: 'Loading Blog...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            $.ajax({

                url: "{{ route('website.blog.list') }}",

                type: "GET",

                success: function(data) {

                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, blog) {

                        let blogImage = (blog.image === 'dummy') ?

                            "{{ asset('backend/assets/img/team/avatar.png') }}" :

                            "{{ asset('/') }}" + blog.image;

                        let blogThumbImage = (blog.thumbnail_image === 'dummy') ?

                            "{{ asset('backend/assets/img/team/avatar.png') }}" :

                            "{{ asset('/') }}" + blog.thumbnail_image;

                        rows += `<tr>

                        <td>${index + 1}</td>

                        <td class="title">

                         ${blog.title}

                        </td>

                        <td class="author">

                         ${blog.author}

                        </td>

                        <td><img class="" src="${blogThumbImage}" alt="Thumbnail Image" style="height:50px;"/></td>

                        <td><img class="" src="${blogImage}" alt="Blog Image" style="height:50px;"/></td>

                        

                        <td>

                            ${blog.short_content}

                        </td>

                        <td class="status">

                        <div class="form-check form-switch">

                            <input class="form-check-input status-toggle" type="checkbox" data-id="${blog.id}" ${blog.is_active == 1 ? 'checked' : ''} />

                        </div>

                        </td>

                        <td class="date">${formatDate(blog.created_at)}</td>

                        <td>

                            <div class="text-center">

                            <a href="/blog/${blog.slug}" class="btn btn-link p-0" target="_blank" ><span

                                                    class="text-primary fas fa-eye"></span></a> | 

                                <button class="btn btn-link p-0 edit-btn" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Edit" data-id="${blog.id}"><span

                                                    class="text-primary fas fa-edit"></span></button> | 

                                                    <button

                                                class="btn btn-link p-0  delete-btn" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Delete" data-id="${blog.id}"><span

                                                    class="text-danger fas fa-trash-alt"></span></button>

                                                    </div>

                            

                        </td>

                    </tr>`;

                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {

                        valueNames: ['author', 'title', 'date'],

                        page: 10,

                        pagination: true

                    });

                }

            });

        }



        // Store

        $(document).ready(function() {

            var validator = $("#storeBlog").validate({

                ignore: [],

                rules: {

                    title: {

                        required: true,

                    },

                    author: {

                        required: true,

                    },

                    thumbnail_image: {

                        extension: "jpg|jpeg|png|webp"

                    },

                    image: {

                        extension: "jpg|jpeg|png|webp"

                    }

                },

                messages: {

                    title: {

                        required: "Title is required",

                    },

                    author: {

                        required: "Author is required",

                    },

                    thumbnail_image: {

                        extension: "Only jpg, jpeg, png, webp formats are allowed"

                    },

                    image: {

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



                if ($("#storeBlog").valid()) {



                    Swal.fire({

                        title: 'Uploading...',

                        text: 'Please wait',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    var form = $("#storeBlog")[0];

                    var formData = new FormData(form);



                    $.ajax({

                        url: "{{ route('website.blog.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            Swal.close();

                            Swal.fire("Success!", response.success, "success");



                            fetchBlog();

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

                text: 'Edit blog form opening...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            let blogId = $(this).data('id');



            $.ajax({

                url: '/website/blog/' + blogId + '/edit',

                type: 'GET',

                success: function(response) {



                    var blog = response.blog;



                    // Basic user info

                    $('#edit_id').val(blog.id);

                    $('#edit_title').val(blog.title);

                    $('#edit_author').val(blog.author);

                    $('#edit_short_content').val(blog.short_content);

                    $('#edit_tags').val(blog.tags);

                    $('#edit_meta_title').val(blog.meta_title);

                    $('#edit_meta_description').val(blog.meta_description);

                    $('#edit_meta_keywords').val(blog.meta_keywords);

                    tinymce.get('edit_content').setContent(blog.content || '');



                    if (blog.thumbnail_image == 'dummy') {

                        $('#PreviewThumbnailImage').attr('src',

                            '/backend/assets/img/team/avatar.png');

                    } else {

                        $('#PreviewThumbnailImage').attr('src', '/' + blog.thumbnail_image);;

                    }



                    if (blog.image == 'dummy') {

                        $('#PreviewBlogImage').attr('src',

                            '/backend/assets/img/team/avatar.png');

                    } else {

                        $('#PreviewBlogImage').attr('src', '/' + blog.image);;

                    }



                    $('#editModal').modal('show');



                    Swal.close();

                },

                error: function() {

                    Swal.close();

                    alert('Something went wrong while fetching blog data.');

                }

            });

        });





        // Update AJAX

        $('#updateBlog').submit(function(e) {

            e.preventDefault();



            let blogId = $('#edit_id').val();

            let formData = new FormData(this);

            formData.append('_method', 'PUT');



            // SweetAlert loading indicator

            Swal.fire({

                title: 'Please wait...',

                text: 'Updating blog...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $.ajax({

                url: '/website/blog/' + blogId,

                type: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(response) {

                    Swal.close();

                    $('#editModal').modal('hide');

                    Swal.fire("Success!", response.success, "success");

                    fetchBlog();

                    $('#updateBlog')[0].reset();

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

            let blogId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the blog!",

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

                        text: 'Deleting blog...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: `/website/blog/${blogId}`,

                        type: "DELETE",

                        success: function(response) {

                            Swal.close();

                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The blog have been deleted.",

                                    "success");

                                fetchBlog();

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }



                        },

                        error: function(xhr) {

                            Swal.close();

                            Swal.fire("Error!", "Failed to delete blog.",

                                "error");

                        }

                    });

                }

            });

        });



        $(document).on('change', '.status-toggle', function() {

            var blogId = $(this).data('id');

            var status = $(this).is(':checked') ? 1 : 0;



            $.ajax({

                url: "{{ route('website.blog.status') }}",

                type: "POST",

                data: {

                    id: blogId,

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

                    fetchBlog();

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