@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Package Categories</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["name","status","type"],"page":10,"pagination":true}'>

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

                                <th class="text-900">Category Icon</th>

                                <th class="text-900" data-sort="name">Category Name</th>

                                <th class="text-900" data-sort="date">Date</th>

                                <th class="text-900" data-sort="status">Top Category</th>

                                <th class="text-900" data-sort="status">Sort</th>

                                <th class="text-900">Action</th>

                            </tr>

                        </thead>

                        <tbody class="list">

                            <tr>

                                <td>1</td>

                                <td class="icon">icon</td>

                                <td class="name">category name</td>

                                <td class="date">dd/mm/yy</td>

                                <td>

                                    <div><a class="btn btn-link p-0" href="javascript:void(0);" data-bs-toggle="tooltip"

                                            data-bs-placement="top" title="View"><span

                                                class="text-500 fas fa-eye"></span></a>

                                        <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"

                                            data-bs-placement="top" title="Edit"><span

                                                class="text-500 fas fa-edit"></span></button><button

                                            class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"

                                            data-bs-placement="top" title="Delete"><span

                                                class="text-500 fas fa-trash-alt"></span></button>

                                    </div>

                                </td>

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

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Category</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new category.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="storeCategory" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label" for="type">Type</label>

                        <select class="form-control" id="type" name="type">

                            <option value="">--Type--</option>

                            <option value="Organ">Organ</option>

                            <option value="Disease">Disease</option>

                            <option value="Both">Both</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="category_name">Category Name</label>

                        <input class="form-control" id="category_name" name="category_name" type="text" placeholder="Enter Category Name" />

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="category_image">Upload Category Image <span

                                class="text-danger">(.png & transparent background)</span></label>

                        <input class="form-control" id="category_image" name="category_image" type="file" />

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="sort">Sorting Value</label>

                        <input class="form-control" id="sort" name="sort" type="number" value="0" />

                    </div>



                    <div class="mb-3">

                        <button class="btn btn-falcon-primary me-2" id="submitBtn">Submit</button> <a href=""

                            id="search-icon" target="_blank"><i class="fa-solid fa-magnifying-glass"></i> Search

                            Image</a>

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

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Categpry</h4>

                    <p class="fs-10 mb-0 text-white">Update category details.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="updateCategory" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">

                        <label class="form-label" for="edit_type">Type</label>

                        <select class="form-control" id="edit_type" name="type">

                            <option value="">--Type--</option>

                            <option value="Organ">Organ</option>

                            <option value="Disease">Disease</option>

                            <option value="Both">Both</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="edit_category_name">Category Name</label>

                        <input class="form-control" id="edit_category_name" name="category_name" type="text" placeholder="Enter Category Name" />

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="edit_category_image">Upload Category Image <span

                                class="text-danger">(.png & transparent background)</span></label>

                        <input class="form-control" id="edit_category_image" name="category_image" type="file" />

                        <br>

                        <img src="" id="PreviewCategoryImage" alt="">

                    </div>



                    <div class="mb-3">

                        <label class="form-label" for="edit_sort">Sorting Value</label>

                        <input class="form-control" id="edit_sort" name="sort" type="number" />

                    </div>



                    <div class="mb-3">

                        <button class="btn btn-falcon-primary me-2">Submit</button>

                        <a href="" id="edit-search-icon" target="_blank"><i

                                class="fa-solid fa-magnifying-glass"></i> Search Image</a>

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

        $('#category_name').on('input', function() {

            var cat_name = $(this).val();

            $('#search-icon').attr('href', 'https://icons8.com/icons/set/' + cat_name);

        });



        $('#edit_category_name').on('input', function() {

            var cat_name = $(this).val();

            $('#edit-search-icon').attr('href', 'https://icons8.com/icons/set/' + cat_name);

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

        fetchCategory();



        function fetchCategory() {

            Swal.fire({

                title: 'Please Wait...',

                text: 'Category Loading...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            $.ajax({

                url: "{{ route('package.category.list') }}",

                type: "GET",

                success: function(data) {

                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, category) {

                        let categoryImageImage = (category.category_image === 'dummy') ?

                            "{{ asset('backend/assets/img/team/avatar.png') }}" :

                            "{{ asset('/') }}" + category.category_image;

                        rows += `<tr>

                        <td>${index + 1}</td>

                        <td class="type">${category.type}</td>

                        <td><img class="" src="${categoryImageImage}" alt="category Avatar" style="height:50px;width:50px;"/></td>

                        <td class="name">

                         ${category.category_name}

                        </td>

                        <td class="date">${formatDate(category.created_at)}</td>

                        <td class="status">

                        <div class="form-check form-switch">

                            <input class="form-check-input status-toggle" type="checkbox" data-id="${category.id}" ${category.status == 1 ? 'checked' : ''} />

                        </div>

                        </td>

                        <td>

                        ${category.sort}

                        </td>

                        <td>

                            <div>

                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Edit" data-id="${category.id}"><span

                                                    class="text-primary fas fa-edit"></span></button>

                                                    <button

                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Delete" data-id="${category.id}"><span

                                                    class="text-danger fas fa-trash-alt"></span></button>

                                                    </div>

                            

                        </td>

                    </tr>`;

                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {

                        valueNames: ['name', 'date', 'type'],

                        page: 10,

                        pagination: true

                    });

                }

            });

        }



        // Store

        $(document).ready(function() {

            var validator = $("#storeCategory").validate({

                ignore: [],

                rules: {

                    type: {

                        required: true,

                    },

                    category_name: {

                        required: true,

                    },

                    category_image: {

                        required: true

                    },

                },

                messages: {

                    type: {

                        required: "Category Type is required",

                    },

                    category_name: {

                        required: "Category Name is required",

                    },

                    category_image: "Category Image is required",

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



                if ($("#storeCategory").valid()) {

                    Swal.fire({

                        title: 'Uploading...',

                        text: 'Please wait',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });

                    var form = $("#storeCategory")[0];

                    var formData = new FormData(form);



                    $.ajax({

                        url: "{{ route('package.category.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            Swal.close();

                            Swal.fire("Success!", response.success, "success");

                            fetchCategory();

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

        $(document).on('click', '.edit-btn', function() {

            Swal.fire({

                title: 'Please wait...',

                text: 'Loading...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            let categoryId = $(this).data('id');



            $.ajax({

                url: '/package-category/' + categoryId + '/edit',

                type: 'GET',

                success: function(response) {

                    var category = response.category;



                    // Basic user info

                    $('#edit_id').val(category.id);

                    $('#edit_type').val(category.type);

                    $('#edit_category_name').val(category.category_name);

                    $('#edit_sort').val(category.sort);

                    if (category.category_image == 'dummy') {

                        $('#PreviewCategoryImage').attr('src',

                            '/backend/assets/img/team/avatar.png');

                    } else {

                        $('#PreviewCategoryImage').attr('src', category.category_image);

                    }



                    $('#editModal').modal('show');

                    Swal.close();

                },

                error: function() {

                    Swal.close();

                    alert('Something went wrong while fetching user data.');

                }

            });

        });





        // Update User AJAX

        $('#updateCategory').submit(function(e) {

            e.preventDefault();

            Swal.fire({

                title: 'Please wait...',

                text: 'Updating Category...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            var categoryId = $('#edit_id').val();

            var formData = new FormData(this);

            formData.append('_method', 'PUT');

            $.ajax({

                url: '/package-category/' + categoryId,

                type: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(response) {



                    $('#editModal').modal('hide');

                    Swal.fire("Success!", response.success, "success");

                    fetchCategory();

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

            let packageId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the category!",

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#d33",

                cancelButtonColor: "#3085d6",

                confirmButtonText: "Yes, delete it!"

            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({

                        title: 'Please wait...',

                        text: 'Deleting category...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: `/package-category/${packageId}`,

                        type: "DELETE",

                        data: {

                            _token: "{{ csrf_token() }}"

                        },

                        success: function(response) {

                            Swal.close();



                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The category have been deleted.",

                                    "success");

                                fetchCategory();

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



        $(document).on('change', '.status-toggle', function() {

            var categoryId = $(this).data('id');

            var status = $(this).is(':checked') ? 1 : 0;



            $.ajax({

                url: "{{ route('package.category.status.update') }}", // Create this route

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    id: categoryId,

                    status: status

                },

                beforeSend: function() {

                    Swal.fire({

                        title: 'Please Wait...',

                        text: 'Making category on Top...',

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

                    fetchCategory();

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