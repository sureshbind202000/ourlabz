@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Product Sub-Categories</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["name","status","category","date"],"page":10,"pagination":true}'>

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

                                <th class="text-900" data-sort="category">Category</th>

                                <th class="text-900" data-sort="name">Sub-Category</th>

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



<!-- Add Package Modal Start -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Sub-Category</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new sub-category.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="storeSubCategory">

                    @csrf



                    <div class="mb-3">

                        <label class="form-label" for="type_id">Product Type</label>

                        <select class="form-select" id="type_id" name="type_id">

                            <option value="">--Select Product Type--</option>

                            @foreach($productTypes as $type)

                            <option value="{{$type->id}}">{{$type->name}}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="category_id">Category</label>

                        <select class="form-select" id="category_id" name="category_id">

                            <option value="">--Category--</option>

                            @foreach($categories as $category)

                            <option value="{{$category->id}}" data-type="{{$category->type_id}}">{{$category->name}}</option>

                            @endforeach

                        </select>

                    </div>



                    <div class="mb-3">

                        <label class="form-label" for="name">Sub-Category</label>

                        <input class="form-control" id="name" name="name" type="text" placeholder="Enter Sub-Category Name" />

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

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Sub-Categpry</h4>

                    <p class="fs-10 mb-0 text-white">Update sub-category details.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="updateSubCategory" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">

                        <label class="form-label" for="edit_type_id">Product Type</label>

                        <select class="form-select" id="edit_type_id" name="type_id">

                            <option value="">--Select Product Type--</option>

                            @foreach($productTypes as $type)

                            <option value="{{$type->id}}">{{$type->name}}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="edit_category_id">Category</label>

                        <select class="form-control" id="edit_category_id" name="category_id">

                            <option value="">--Category--</option>

                            @foreach($categories as $category)

                            <option value="{{$category->id}}" data-type="{{$category->type_id}}">{{$category->name}}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="edit_name">Sub-Category</label>

                        <input class="form-control" id="edit_name" name="name" type="text" placeholder="Enter Sub-Category Name" />

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

        fetchSubCategory();



        function fetchSubCategory() {

            Swal.fire({

                title: 'Please Wait...',

                text: 'Sub-Category Loading...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            $.ajax({

                url: "{{ route('product.sub_category.list') }}",

                type: "GET",

                success: function(data) {

                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, sub_category) {



                        rows += `<tr>

                        <td>${index + 1}</td>

                        <td class="category"><span class="badge badge-subtle-primary">${sub_category.category.name}</span></td>

                        <td class="name">

                         ${sub_category.name}

                        </td>

                        <td class="date">${formatDate(sub_category.created_at)}</td>

                        <td>

                            <div>

                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Edit" data-id="${sub_category.id}"><span

                                                    class="text-primary fas fa-edit"></span></button>

                                                    <button

                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Delete" data-id="${sub_category.id}"><span

                                                    class="text-danger fas fa-trash-alt"></span></button>

                                                    </div>

                            

                        </td>

                    </tr>`;

                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {

                        valueNames: ['category', 'name', 'date'],

                        page: 10,

                        pagination: true

                    });

                }

            });

        }



        // Store

        $(document).ready(function() {

            var validator = $("#storeSubCategory").validate({

                ignore: [],

                rules: {

                    category: {

                        required: true,

                    },

                    name: {

                        required: true,

                    }

                },

                messages: {

                    category: {

                        required: "Category is required",

                    },

                    name: {

                        required: "Sub-Category Name is required",

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



                if ($("#storeSubCategory").valid()) {

                    Swal.fire({

                        title: 'Uploading...',

                        text: 'Please wait',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });

                    var form = $("#storeSubCategory")[0];

                    var formData = new FormData(form);



                    $.ajax({

                        url: "{{ route('product.sub_category.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            Swal.close();

                            Swal.fire("Success!", response.success, "success");

                            fetchSubCategory();

                            form.reset();

                            $('#addModal').modal('hide');

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

            let sub_categoryId = $(this).data('id');

            $.ajax({
                url: '/product-sub_category/' + sub_categoryId + '/edit',
                type: 'GET',
                success: function(response) {
                    
                    Swal.close();

                    let sub_category = response.sub_category;

                    $('#edit_id').val(sub_category.id);
                    $('#edit_name').val(sub_category.name);

                    $('#edit_type_id').val(sub_category.type_id);

                    let selectedType = response.type_id;

                    $('#edit_type_id').val(selectedType).trigger('change');

                    $('#edit_category_id').val(sub_category.category_id);

                    $('#editModal').modal('show');
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Something went wrong while fetching sub-category data.', 'error');
                }
            });
        });

        // Update User AJAX

        $('#updateSubCategory').submit(function(e) {

            e.preventDefault();

            Swal.fire({

                title: 'Please wait...',

                text: 'Updating Sub-Category...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            var sub_categoryId = $('#edit_id').val();

            var formData = new FormData(this);

            formData.append('_method', 'PUT');

            $.ajax({

                url: '/product-sub_category/' + sub_categoryId,

                type: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(response) {

                    Swal.close();

                    Swal.fire("Success!", response.success, "success");

                    fetchSubCategory();

                    $('#editModal').modal('hide');

                },

                error: function(xhr) {

                    console.log(xhr);

                    Swal.fire("Error!", "Something went wrong.", "error");

                    Swal.close();

                    $('#editModal').modal('hide');

                }

            });

        });



        // Delete 

        $(document).on('click', '.delete-btn', function() {

            let sub_categoryId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the sub-category!",

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#d33",

                cancelButtonColor: "#3085d6",

                confirmButtonText: "Yes, delete it!"

            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({

                        title: 'Please wait...',

                        text: 'Deleting sub-category...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: `/product-sub_category/${sub_categoryId}`,

                        type: "DELETE",

                        data: {

                            _token: "{{ csrf_token() }}"

                        },

                        success: function(response) {

                            Swal.close();



                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The sub-category have been deleted.",

                                    "success");

                                fetchSubCategory();

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }

                        },

                        error: function(xhr) {

                            Swal.close();

                            Swal.fire("Error!", "Failed to delete sub-category.",

                                "error");

                        }

                    });

                }

            });

        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#type_id').on('change', function() {
            let selectedType = $(this).val();

            // Reset and disable category dropdown if no type selected
            if (selectedType === "") {
                $('#category_id').val('').prop('disabled', true);
                return;
            }

            // Enable category dropdown
            $('#category_id').prop('disabled', false);

            // Loop through each category option
            $('#category_id option').each(function() {
                const typeId = $(this).data('type');

                // Always keep the first "--Category--" visible
                if ($(this).val() === "") {
                    $(this).show();
                    return;
                }

                // Show only categories that match the selected type
                if (typeId == selectedType) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('#category_id').val('').trigger('change');
        });

        $('#edit_type_id').on('change', function() {
            let selectedType = $(this).val();

            $('#edit_category_id option').each(function() {
                let typeId = $(this).data('type');

                if ($(this).val() === '') {
                    $(this).show();
                    return;
                }

                if (typeId == selectedType) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('#edit_category_id').val('');
        });

        // Initially disable category dropdown
        $('#category_id').prop('disabled', true);
    });
</script>


@endsection