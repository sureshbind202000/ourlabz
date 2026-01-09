@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Homepage Banners</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3" data-list='{"valueNames":["name","status"],"page":10,"pagination":true}'>

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

                                <th class="text-900" data-sort="name">Name</th>

                                <th class="text-900">Product</th>

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



<!-- Add Package Modal Start -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Banner</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new banner.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="storeBanner" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3 col-6">

                        <label class="form-label" for="name">Banner Name</label>

                        <input class="form-control" id="name" name="name" type="text"

                            placeholder="Enter Banner Name" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="image">Upload Banner Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="image" name="image" type="file" />

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="tag">Tag</label>

                        <input class="form-control" id="tag" name="tag" type="text"

                            placeholder="Banner tag" />

                    </div>

                    <h6>Heading</h6>

                    <div class="mb-3 col-4">

                        <label class="form-label">Part 1</label>

                        <input class="form-control" id="heading" name="heading" type="text"

                            placeholder="Enter Banner Heading" />

                    </div>

                    <div class="mb-3 col-4">

                        <label class="form-label">Part 2 <span class="text-primary">(Color Words)</span></label>

                        <input class="form-control" id="heading2" name="heading2" type="text"

                            placeholder="Enter Banner Heading" />

                    </div>

                    <div class="mb-3 col-4">

                        <label class="form-label">Part 3</label>

                        <input class="form-control" id="heading3" name="heading3" type="text"

                            placeholder="Enter Banner Heading" />

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="paragraph">Paragraph</label>

                        <textarea class="form-control" name="paragraph" id="paragraph" cols="30" rows="4"

                            placeholder="Enter Banner Paragraph"></textarea>

                    </div>

                    <h6>Button 1</h6>

                    <div class="mb-3 col-6">

                        <label class="form-label">Text</label>

                        <input class="form-control" id="button_text" name="button_text" type="text"

                            placeholder="Button text" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label">Link</label>

                        <input class="form-control" id="button_link" name="button_link" type="text"

                            placeholder="Button Link" />

                    </div>

                    <h6>Button 2</h6>

                    <div class="mb-3 col-6">

                        <label class="form-label">Text</label>

                        <input class="form-control" id="button_text2" name="button_text2" type="text"

                            placeholder="Button text" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label">Link</label>

                        <input class="form-control" id="button_link2" name="button_link2" type="text"

                            placeholder="Button Link" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="sort">Sorting Value</label>

                        <input class="form-control" id="sort" name="sort" type="number" value="0" />

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

                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Banner</h4>

                    <p class="fs-10 mb-0 text-white">Update Banner details.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form class="row" id="updateBanner" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_name">Banner Name</label>

                        <input class="form-control" id="edit_name" name="name" type="text"

                            placeholder="Enter Banner Name" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_image">Upload Banner Image <span

                                class="text-danger">*</span></label>

                        <input class="form-control" id="edit_image" name="image" type="file" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_tag">Tag</label>

                        <input class="form-control" id="edit_tag" name="tag" type="text"

                            placeholder="Banner tag" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label">Banner Preview</label>

                        <br>

                        <img src="" alt="Banner Image" id="PreviewBannerImage" height="100">

                    </div>

                    <h6>Heading</h6>

                    <div class="mb-3 col-4">

                        <label class="form-label">Part 1</label>

                        <input class="form-control" id="edit_heading" name="heading" type="text"

                            placeholder="Enter Banner Heading" />

                    </div>

                    <div class="mb-3 col-4">

                        <label class="form-label">Part 2 <span class="text-primary">(Color Words)</span></label>

                        <input class="form-control" id="edit_heading2" name="heading2" type="text"

                            placeholder="Enter Banner Heading" />

                    </div>

                    <div class="mb-3 col-4">

                        <label class="form-label">Part 3</label>

                        <input class="form-control" id="edit_heading3" name="heading3" type="text"

                            placeholder="Enter Banner Heading" />

                    </div>

                    <div class="mb-3 col-12">

                        <label class="form-label" for="edit_paragraph">Paragraph</label>

                        <textarea class="form-control" name="paragraph" id="edit_paragraph" cols="30" rows="4"

                            placeholder="Enter Banner Paragraph"></textarea>

                    </div>

                    <h6>Button 1</h6>

                    <div class="mb-3 col-6">

                        <label class="form-label">Text</label>

                        <input class="form-control" id="edit_button_text" name="button_text" type="text"

                            placeholder="Button text" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label">Link</label>

                        <input class="form-control" id="edit_button_link" name="button_link" type="text"

                            placeholder="Button Link" />

                    </div>

                    <h6>Button 2</h6>

                    <div class="mb-3 col-6">

                        <label class="form-label">Text</label>

                        <input class="form-control" id="edit_button_text2" name="button_text2" type="text"

                            placeholder="Button text" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label">Link</label>

                        <input class="form-control" id="edit_button_link2" name="button_link2" type="text"

                            placeholder="Button Link" />

                    </div>

                    <div class="mb-3 col-6">

                        <label class="form-label" for="edit_sort">Sorting Value</label>

                        <input class="form-control" id="edit_sort" name="sort" type="number" value="0" />

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

<div class="modal fade" id="productSelectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Select Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <input type="text" id="productSearch" class="form-control mb-2" placeholder="Search product...">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="productList"></tbody>
                </table>

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

        fetchBanner();



        function fetchBanner() {

            Swal.fire({

                title: 'Please wait...',

                text: 'Loading banners...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            $.ajax({

                url: "{{ route('website.banner.list') }}",

                type: "GET",

                success: function(data) {

                    Swal.close();

                    let rows = "";

                    $.each(data, function(index, banner) {

                        let bannerImage = (banner.image === 'dummy') ?

                            "{{ asset('backend/assets/img/team/avatar.png') }}" :

                            "{{ asset('/') }}" + banner.image;

                        rows += `<tr>

                        <td>${index + 1}</td>

                        <td><img class="" src="${bannerImage}" alt="Banner Image" style="height:50px;width:50px;"/></td>

                        <td class="name">

                         ${banner.name}

                        </td>

                        <td>

                             <div class="form-check form-switch">

                            <input class="form-check-input product-toggle" type="checkbox" data-id="${banner.id}" ${banner.product_id > 0 ? 'checked' : ''} />
                            </div>
                            ${banner.product 
                                 ? `<span class="badge bg-success">${banner.product.product_name}</span>`
                                 : `<span class="badge bg-secondary">No Product</span>`
                             }

                        </td>

                        <td class="status">

                        <div class="form-check form-switch">

                            <input class="form-check-input status-toggle" type="checkbox" data-id="${banner.id}" ${banner.status == 1 ? 'checked' : ''} />

                        </div>

                        </td>

                        <td>

                        ${banner.sort}

                        </td>

                        <td class="date">${formatDate(banner.created_at)}</td>

                        <td>

                            <div>

                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Edit" data-id="${banner.id}"><span

                                                    class="text-primary fas fa-edit"></span></button>

                                                    <button

                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                                                data-bs-placement="top" title="Delete" data-id="${banner.id}"><span

                                                    class="text-danger fas fa-trash-alt"></span></button>

                                                    </div>

                            

                        </td>

                    </tr>`;

                    });

                    $("tbody.list").html(rows);

                    new List('tableExample3', {

                        valueNames: ['name', 'date', 'status', 'sort'],

                        page: 10,

                        pagination: true

                    });

                }

            });

        }



        // Store

        $(document).ready(function() {

            var validator = $("#storeBanner").validate({

                ignore: [],

                rules: {

                    name: {

                        required: true,

                    },

                    image: {

                        required: true

                    },

                    tag: {

                        required: true

                    },

                    heading: {

                        required: true

                    },

                    paragraph: {

                        required: true

                    },

                    button_text: {

                        required: true

                    },

                    button_link: {

                        required: true

                    },

                    button_text2: {

                        required: true

                    },

                    button_link2: {

                        required: true

                    },

                },

                messages: {

                    name: {

                        required: "Banner Name is required",

                    },

                    image: "Banner Image is required",

                    tag: {

                        required: "Banner tag is required",

                    },

                    heading: {

                        required: "Banner heading is required",

                    },

                    paragraph: {

                        required: "Banner paragraph is required",

                    },

                    button_text: {

                        required: "Banner button text 1 is required",

                    },

                    button_link: {

                        required: "Banner button link 1 is required",

                    },

                    button_text2: {

                        required: "Banner button text 2 is required",

                    },

                    button_link2: {

                        required: "Banner button link 2 is required",

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



                if ($("#storeBanner").valid()) {



                    Swal.fire({

                        title: 'Uploading...',

                        text: 'Please wait',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    var form = $("#storeBanner")[0];

                    var formData = new FormData(form);



                    $.ajax({

                        url: "{{ route('website.banner.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            Swal.close();

                            Swal.fire("Success!", response.success, "success");



                            fetchBanner();

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

                text: 'Edit banner form opening...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });

            let bannerId = $(this).data('id');



            $.ajax({

                url: '/website/banner/' + bannerId + '/edit',

                type: 'GET',

                success: function(response) {



                    var banner = response.banner;



                    // Basic user info

                    $('#edit_id').val(banner.id);

                    $('#edit_name').val(banner.name);

                    $('#edit_heading').val(banner.heading);

                    $('#edit_heading2').val(banner.heading2);

                    $('#edit_heading3').val(banner.heading3);

                    $('#edit_tag').val(banner.tag);

                    $('#edit_paragraph').val(banner.paragraph);

                    $('#edit_button_link').val(banner.button_link);

                    $('#edit_button_link2').val(banner.button_link2);

                    $('#edit_button_text').val(banner.button_text);

                    $('#edit_button_text2').val(banner.button_text2);

                    $('#edit_sort').val(banner.sort);

                    if (banner.image == 'dummy') {

                        $('#PreviewBannerImage').attr('src',

                            '/backend/assets/img/team/avatar.png');

                    } else {

                        $('#PreviewBannerImage').attr('src', '/' + banner.image);;

                    }



                    $('#editModal').modal('show');

                    Swal.close();

                },

                error: function() {

                    Swal.close();

                    alert('Something went wrong while fetching banner data.');

                }

            });

        });





        // Update AJAX

        $('#updateBanner').submit(function(e) {

            e.preventDefault();



            let bannerId = $('#edit_id').val();

            let formData = new FormData(this);

            formData.append('_method', 'PUT');



            // SweetAlert loading indicator

            Swal.fire({

                title: 'Please wait...',

                text: 'Updating banner...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $.ajax({

                url: '/website/banner/' + bannerId,

                type: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(response) {

                    Swal.close();

                    $('#editModal').modal('hide');

                    Swal.fire("Success!", response.success, "success");

                    fetchBanner();

                    $('#updateBanner')[0].reset();

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

            let bannerId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the banner!",

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

                        text: 'Deleting banner...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: `/website/banner/${bannerId}`,

                        type: "DELETE",

                        success: function(response) {

                            Swal.close();

                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The banner have been deleted.",

                                    "success");

                                fetchBanner();

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

                url: "{{ route('website.banner.status') }}", // Create this route

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

                    fetchBanner();

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



        // $(document).on('change', '.product-toggle', function() {

        //     var bannerId = $(this).data('id');

        //     var status = $(this).is(':checked') ? 1 : 0;



        //     $.ajax({

        //         url: "{{ route('website.banner.product.status') }}", // Create this route

        //         type: "POST",

        //         data: {

        //             id: bannerId,

        //             status: status

        //         },

        //         beforeSend: function() {

        //             // SweetAlert loading indicator

        //             Swal.fire({

        //                 title: 'Please wait...',

        //                 text: 'Updating product status...',

        //                 allowOutsideClick: false,

        //                 didOpen: () => {

        //                     Swal.showLoading();

        //                 }

        //             });

        //         },

        //         success: function(response) {

        //             Swal.close();

        //             Swal.fire({

        //                 icon: 'success',

        //                 title: 'Product status updated successfully',

        //                 timer: 1500,

        //                 showConfirmButton: false

        //             });

        //             fetchBanner();

        //         },

        //         error: function() {

        //             Swal.close();

        //             Swal.fire({

        //                 icon: 'error',

        //                 title: 'Something went wrong',

        //                 timer: 1500,

        //                 showConfirmButton: false

        //             });

        //         }

        //     });

        // });

        $(document).on('change', '.product-toggle', function() {
            let bannerId = $(this).data('id');
            let isChecked = $(this).is(':checked');

            if (isChecked) {
                // If turning ON → open product modal
                $('#productSelectModal').data('banner-id', bannerId).modal('show');

                // revert toggle until user selects product
                $(this).prop('checked', false);
            } else {
                // If turning OFF → remove product assignment
                $.ajax({
                    url: "{{ route('website.banner.product.status') }}",
                    type: "POST",
                    data: {
                        id: bannerId,
                        product_id: null
                    }, // clear product
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Product removed from banner',
                            timer: 1200,
                            showConfirmButton: false
                        });
                        fetchBanner();
                    }
                });
            }
        });

        $('#productSelectModal').on('shown.bs.modal', function() {
            $.get("{{ route('product.list') }}", function(products) {

                let rows = '';
                $.each(products, function(i, p) {
                    let firstImage = p.images && p.images.length > 0 ?
                        `{{ asset('/') }}` + p.images[0].image :
                        `{{ asset('backend/assets/img/no-image.jpg') }}`;
                    // ------- Price Calculation -------
                    let regular = parseFloat(p.regular_price) || 0;
                    let discount = parseFloat(p.discount) || 0;
                    let finalPrice = regular;

                    if (p.discount_type === 'percent') {
                        finalPrice = regular - (regular * discount / 100);
                    } else if (p.discount_type === 'flat') {
                        finalPrice = regular - discount;
                    }

                    finalPrice = finalPrice.toFixed(2); // round
                    rows += `
                <tr>
                    <td>
                        <img src="${firstImage}" height="50" class="me-2" style="border-radius:6px;object-fit:cover;">
                        <strong>${p.product_name}</strong><br>
                        <small>
                            Regular: ₹${regular.toFixed(2)} | 
                            Discount: ${discount}${p.discount_type === 'percent' ? '%' : '₹'} | 
                            Final: <b class="text-success">₹${finalPrice}</b>
                        </small>
                    </td>
                    <td><button class="btn btn-success select-product" data-id="${p.id}">Select</button></td>
                </tr>
            `;
                });
                $('#productList').html(rows);
            });
        });

        $(document).on('click', '.select-product', function() {
            let productId = $(this).data('id');
            let bannerId = $('#productSelectModal').data('banner-id');

            $.ajax({
                url: "{{ route('website.banner.product.status') }}",
                type: "POST",
                data: {
                    id: bannerId,
                    product_id: productId
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Product assigned to banner',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#productSelectModal').modal('hide');
                    fetchBanner();
                }
            });
        });

        $(document).on("keyup", "#productSearch", function() {
            let value = $(this).val().toLowerCase();

            $("#productList tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });



    });
</script>

@endsection