@extends('backend.includes.layout')

@section('content')

    <form action="" id="addProductFrom" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="card mb-3">

            <div class="card-body">

                <div class="row flex-between-center">

                    <div class="col-md">

                        <h5 class="mb-2 mb-md-0">Add a product</h5>

                    </div>

                    <div class="col-auto">

                        <a href="{{ route('products') }}" class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>

                        <input type="submit" value="Add product" class="btn btn-primary">

                    </div>

                </div>

            </div>

        </div>

        <div class="row g-0">

            <div class="col-lg-8 pe-lg-2">

                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Basic information</h6>

                    </div>

                    <div class="card-body">

                        <div class="row gx-2">

                            <div class="col-8 mb-3">

                                <label class="form-label" for="product_name">Product name:</label>

                                <input class="form-control" id="product_name" name="product_name" type="text"

                                    placeholder="Enter product name" />

                            </div>

                            <div class="col-4 mb-3">

                                <label class="form-label" for="varient">Product has varient:</label>

                                <select name="varient" id="varient" class="form-control">

                                    <option value="">--select--</option>

                                    <option value="1">Yes</option>

                                    <option value="0">No</option>

                                </select>

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label" for="brand">Manufacturar Name:</label>

                                <input class="form-control" id="brand" name="brand" type="text"

                                    placeholder="Enter manufacturar name (Brand)" />

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label" for="product_identification_no">Product Identification

                                    No.:</label>

                                <input class="form-control" id="product_identification_no" name="product_identification_no"

                                    type="text" placeholder="Unique product identification no." />

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label" for="short_desc">Product Summary:</label>

                                <textarea name="short_desc" class="form-control" id="short_desc" rows="4"

                                    placeholder="Write short description about product..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Add images</h6>

                    </div>

                    <div class="card-body">

                        <div class="dropzone dropzone-multiple p-0" id="dropzoneMultipleFileUpload"

                            data-dropzone="data-dropzone" action="#!" data-options='{"acceptedFiles":"image/*"}'>

                            <div class="fallback"><input name="images[]" type="file" multiple="multiple" /></div>

                            <div class="dz-message" data-dz-message="data-dz-message"> <img class="me-2"

                                    src="../../../assets/img/icons/cloud-upload.svg" width="25" alt="" /><span

                                    class="d-none d-lg-inline">Drag your image here<br />or,

                                </span><span class="btn btn-link p-0 fs-10">Browse</span></div>

                            <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column ">

                                <div class="d-flex media align-items-center mb-3 pb-3 border-bottom btn-reveal-trigger">

                                    <img class="dz-image" src="../../../assets/img/icons/cloud-upload.svg" alt="..."

                                        data-dz-thumbnail="data-dz-thumbnail" />

                                    <div class="flex-1 d-flex flex-between-center">

                                        <div>

                                            <h6 data-dz-name="data-dz-name"></h6>

                                            <div class="d-flex align-items-center">

                                                <p class="mb-0 fs-10 text-400 lh-1" data-dz-size="data-dz-size"></p>

                                                <div class="dz-progress"><span class="dz-upload"

                                                        data-dz-uploadprogress=""></span></div>

                                            </div>

                                        </div>

                                        <div class="dropdown font-sans-serif"><button

                                                class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none"

                                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"

                                                aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>

                                            <div class="dropdown-menu dropdown-menu-end border py-2"><a

                                                    class="dropdown-item" href="#!"

                                                    data-dz-remove="data-dz-remove">Remove File</a></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Details</h6>

                    </div>

                    <div class="card-body">

                        <div class="row gx-2">

                            <div class="col-12 mb-3">

                                <label class="form-label">Product description:</label>

                                <div class="create-product-description-textarea">

                                    <textarea class="tinymce d-none" data-tinymce="data-tinymce" name="long_desc" id="long_desc"

                                        placeholder="Write long description about product..."></textarea>

                                </div>

                            </div>



                            <div class="col-sm-6 mb-3">

                                <label class="form-label" for="country_of_origin">Country of Origin: </label>

                                <select class="form-select" id="country_of_origin" name="country_of_origin">

                                    <option value="">Select </option>

                                    <option value="China">China</option>

                                    <option value="India">India</option>

                                    <option value="United States">United States</option>

                                    <option value="Indonesia">Indonesia</option>

                                    <option value="Pakistan">Pakistan</option>

                                    <option value="Brazil">Brazil</option>

                                    <option value="Nigeria">Nigeria</option>

                                    <option value="Bangladesh">Bangladesh</option>

                                    <option value="Russia">Russia</option>

                                    <option value="Japan">Japan</option>

                                    <option value="Mexico">Mexico</option>

                                    <option value="Philippines">Philippines</option>

                                    <option value="Egypt">Egypt</option>

                                    <option value="Vietnam">Vietnam</option>

                                    <option value="Ethiopia">Ethiopia</option>

                                    <option value="DR Congo">DR Congo</option>

                                    <option value="Iran">Iran</option>

                                    <option value="Turkey">Turkey</option>

                                    <option value="Germany">Germany</option>

                                    <option value="France">France</option>

                                </select>

                            </div>

                            <div class="col-6 mb-3">

                                <label class="form-label" for="release_date">Release Date: </label>

                                <input class="form-control datetimepicker" id="release_date" name="release_date"

                                    type="text" data-options='{"dateFormat":"d/m/y","disableMobile":true}'

                                    placeholder="Manufacture date" />

                            </div>

                            <div class="col-6 mb-3">

                                <label class="form-label" for="warranty">Warranty Lenght (in months): </label>

                                <input class="form-control" id="warranty" name="warranty" type="text"

                                    placeholder="e.g : 12" />

                            </div>

                            <div class="col-6 mb-3">

                                <label class="form-label" for="stock">Stock Qty.: </label>

                                <input class="form-control" id="stock" name="stock" type="text"

                                    placeholder="e.g. : 100" />

                            </div>

                            <div class="col-sm-6 mb-3">

                                <label class="form-label" for="product_for">Product For: </label>

                                <select class="form-select" id="product_for" name="product_for">

                                    <option value="">Select </option>

                                    <option value="user">Users</option>

                                    <option value="lab">Labs</option>

                                    <option value="both">Both</option>

                                </select>

                            </div>
                            
                            <div class="col-sm-6 mb-3">

                                <label class="form-label" for="product_weight">Product Weight (in grams) : </label>
                                <input type="number" class="form-control" name="product_weight" id="product_weight" placeholder="e.g 100">
                                <span class="text-danger small">Product weight is required for shipping</span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Additional Details</h6>

                    </div>

                    <div class="card-body">

                        <div id="spec-list">



                        </div>



                        <div class="row gy-3 gx-2">

                            <div class="col-sm-3">

                                <input class="form-control form-control-sm" id="spec-label" type="text"

                                    placeholder="Label" />

                            </div>

                            <div class="col-sm-9">

                                <div class="d-flex gap-2 flex-between-center">

                                    <input class="form-control form-control-sm" id="spec-property" type="text"

                                        placeholder="Property" />

                                    <button class="btn btn-sm btn-falcon-default" id="add-spec-btn">Add</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card mb-3" id="varient-div" style="display: none;">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Variant Details</h6>

                    </div>

                    <div class="card-body">







                        <!-- Added Attributes will appear here -->

                        <div id="addedAttributes"></div>



                        <!-- Select Attribute -->

                        <div class="row mt-3">

                            <div class="col-md-3 pe-0">

                                <select id="attributeSelect" class="form-select rounded-end-0">

                                    <option value="">-- Select --</option>

                                    @foreach ($attributes as $attribute)

                                        <option value="{{ $attribute->id }}" data-values='@json($attribute->values)'>

                                            {{ $attribute->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-9 ps-0">

                                <button type="button" id="addAttribute"

                                    class="btn btn-success rounded-start-0">Add</button>

                                <button type="button" class="btn btn-primary" id="generateVariants">Generate

                                    Variants</button>

                            </div>

                        </div>



                        <div id="variant-list" class="mt-3"></div>

                    </div>

                </div>





            </div>

            <div class="col-lg-4 ps-lg-2">

                <div class="sticky-sidebar">

                    <div class="card mb-3">

                        <div class="card-header bg-body-tertiary">

                            <h6 class="mb-0">Category</h6>

                        </div>

                        <div class="card-body">

                            <div class="row gx-2">

                                <div class="col-12 mb-3">

                                    <label class="form-label" for="product_type">Select type:</label>

                                    <select class="form-select" id="product_type" name="product_type">

                                        <option value="">Select Type</option>

                                        @foreach ($productTypes as $type)

                                            <option value="{{ $type->id }}">{{ $type->name }}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-12 mb-3 d-none">

                                    <label class="form-label" for="product_category">Select category:</label>

                                    <select class="form-select" id="product_category" name="product_category">

                                        <option value="">Select Category</option>

                                    </select>

                                </div>

                                <div class="col-12 d-none">

                                    <label class="form-label" for="product_subcategory">Select sub-category:</label>

                                    <select class="form-select" id="product_subcategory" name="product_subcategory">

                                        <option value="">Select Sub-category</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="card mb-3">

                        <div class="card-header bg-body-tertiary">

                            <h6 class="mb-0">Pricing (for Users)</h6>

                        </div>

                        <div class="card-body">

                            <div class="row gx-2">



                                <div class="col-12 mb-3">

                                    <label class="form-label" for="regular_price">Regular Price:</label>

                                    <input class="form-control" id="regular_price" name="regular_price" type="number"

                                        step="0.01" placeholder="Enter regular price" />

                                </div>

                                <div class="col-8 mb-3">

                                    <label class="form-label" for="discount">Discount :</label>

                                    <input class="form-control" id="discount" name="discount" type="number"

                                        placeholder="Enter discount" />

                                </div>

                                <div class="col-4">

                                    <label class="form-label" for="discount_type">Type:</label>

                                    <select class="form-select" id="discount_type" name="discount_type">

                                        <option value="">select</option>

                                        <option value="percent">Percent</option>

                                        <option value="flat">Flat</option>

                                    </select>

                                </div>

                                <div class="col-12">

                                    <label class="form-label" for="final_price">Final price:

                                    </label>

                                    <input class="form-control" id="final_price" name="final_price" readonly

                                        type="text" placeholder="Final price auto calculated" />

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card mb-3">

                        <div class="card-header bg-body-tertiary">

                            <h6 class="mb-0">Bulk Pricing (for Labs)</h6>

                        </div>

                        <div class="card-body">

                            <div class="row gx-2">



                                <div class="col-8 mb-3">

                                    <label class="form-label" for="bulk_regular_price">Regular Price:</label>

                                    <input class="form-control" id="bulk_regular_price" name="bulk_regular_price"

                                        type="number" step="0.01" placeholder="Enter regular price" />

                                </div>

                                <div class="col-4">

                                    <label class="form-label" for="bulk_moq">MOQ:</label>

                                    <input class="form-control" id="bulk_moq" name="bulk_moq" type="number"

                                        placeholder="e.g : 1" />

                                </div>

                                <div class="col-8 mb-3">

                                    <label class="form-label" for="bulk_discount">Discount :</label>

                                    <input class="form-control" id="bulk_discount" name="bulk_discount" type="number"

                                        placeholder="Enter discount" />

                                </div>

                                <div class="col-4">

                                    <label class="form-label" for="bulk_discount_type">Type:</label>

                                    <select class="form-select" id="bulk_discount_type" name="bulk_discount_type">

                                        <option value="">select</option>

                                        <option value="percent">Percent</option>

                                        <option value="flat">Flat</option>

                                    </select>

                                </div>

                                <div class="col-12">

                                    <label class="form-label" for="bulk_final_price">Final price:

                                    </label>

                                    <input class="form-control" name="bulk_final_price" id="bulk_final_price" readonly

                                        type="text" placeholder="Final price auto calculated" />

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="card mb-3">

                        <div class="card-header bg-body-tertiary">

                            <h6 class="mb-0">Shipping</h6>

                        </div>

                        <div class="card-body">

                            <div class="form-check">

                                <input class="form-check-input p-2" id="vendor-delivery" type="radio" name="shipping"

                                    checked />

                                <label class="form-check-label fs-9 fw-normal text-700" for="vendor-delivery">Delivered by

                                    vendor (you)</label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input p-2" id="ourlabz-delivery" type="radio"

                                    name="shipping" />

                                <label class="form-check-label fs-9 fw-normal text-700" for="ourlabz-delivery">Delivered

                                    by

                                    Ourlabz <span

                                        class="badge badge-subtle-warning rounded-pill ms-2">Recommended</span></label>

                            </div>

                        </div>

                    </div>

                    <div class="card mb-3">

                        <div class="card-header bg-body-tertiary">

                            <h6 class="mb-0">Stock status</h6>

                        </div>

                        <div class="card-body">

                            <div class="form-check">

                                <input class="form-check-input p-2" id="in_stock" type="radio" name="in_stock"

                                    value="1" checked />

                                <label class="form-check-label fs-9 fw-normal text-700" for="in_stock">In stock</label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input p-2" id="out_of_stock" type="radio" name="in_stock"

                                    value="0" />

                                <label class="form-check-label fs-9 fw-normal text-700" for="out_of_stock">Out of

                                    stock</label>

                            </div>

                        </div>

                    </div>

                    <div class="card mb-3">

                        <div class="card-header bg-body-tertiary">

                            <h6 class="mb-0">Tags</h6>

                        </div>

                        <div class="card-body">

                            <label class="form-label" for="product_tags">Add a keyword:</label>

                            <input class="form-control js-choice" id="product_tags" type="text" name="tags"

                                size="1" data-options='{"removeItemButton":true,"placeholder":false}' />

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card mt-3">

            <div class="card-body">

                <div class="row justify-content-between align-items-center">

                    <div class="col-md">

                        <h5 class="mb-2 mb-md-0">You're almost done!</h5>

                    </div>

                    <div class="col-auto">

                        <a href="{{ route('products') }}"

                            class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>

                        <input type="submit" value="Add product" class="btn btn-primary">

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@section('js')

    <script>

        $(document).ready(function() {

            // When Type changes

            $('#product_type').on('change', function() {

                const typeId = $(this).val();



                // Reset Category and Subcategory

                $('#product_category').html('<option value="">Select Category</option>').closest('.col-12')

                    .addClass('d-none');

                $('#product_subcategory').html('<option value="">Select Sub-category</option>').closest(

                    '.col-12').addClass('d-none');



                if (typeId) {

                    Swal.fire({

                        title: 'Loading Categories...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: "{{ route('get.categories') }}",

                        type: "GET",

                        data: {

                            type_id: typeId

                        },

                        success: function(res) {

                            Swal.close();



                            if (res.length > 0) {

                                $.each(res, function(key, category) {

                                    $('#product_category').append('<option value="' +

                                        category.id + '">' + category.name +

                                        '</option>');

                                });

                                $('#product_category').closest('.col-12').removeClass('d-none');

                            }

                        },

                        error: function() {

                            Swal.fire('Error', 'Failed to load categories.', 'error');

                        }

                    });

                }

            });



            // When Category changes

            $('#product_category').on('change', function() {

                const categoryId = $(this).val();



                $('#product_subcategory').html('<option value="">Select Sub-category</option>').closest(

                    '.col-12').addClass('d-none');



                if (categoryId) {

                    Swal.fire({

                        title: 'Loading Sub-categories...',

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    $.ajax({

                        url: "{{ route('get.subcategories') }}",

                        type: "GET",

                        data: {

                            category_id: categoryId

                        },

                        success: function(res) {

                            Swal.close();



                            if (res.length > 0) {

                                $.each(res, function(key, sub) {

                                    $('#product_subcategory').append('<option value="' +

                                        sub.id + '">' + sub.name + '</option>');

                                });

                                $('#product_subcategory').closest('.col-12').removeClass(

                                    'd-none');

                            }

                        },

                        error: function() {

                            Swal.fire('Error', 'Failed to load sub-categories.', 'error');

                        }

                    });

                }

            });

        });

    </script>

    <script>

        $(document).ready(function() {

            // Add spec

            $('#add-spec-btn').on('click', function(e) {

                e.preventDefault();



                const label = $('#spec-label').val().trim();

                const property = $('#spec-property').val().trim();



                if (label && property) {

                    const specHTML = `

          <div class="row gx-2 flex-between-center mb-3 spec-item">

            <div class="col-sm-3">

              <h6 class="mb-0 text-600">${label}</h6>

              <input type="hidden" name="specifications[][label]" value="${label}">

            </div>

            <div class="col-sm-9">

              <div class="d-flex flex-between-center">

                <h6 class="mb-0 text-700">${property}</h6>

                <input type="hidden" name="specifications[][property]" value="${property}">

                <a class="btn btn-sm btn-link text-danger btn-remove-spec" href="#!" title="Remove">

                  <span class="fs-10 fas fa-trash-alt"></span>

                </a>

              </div>

            </div>

          </div>

        `;



                    $('#spec-list').append(specHTML);

                    $('#spec-label').val('');

                    $('#spec-property').val('');

                } else {

                    Swal.fire({

                        toast: true,

                        position: 'top-end',

                        icon: 'warning',

                        title: 'Both Label and Property are required!',

                        showConfirmButton: false,

                        timer: 2000,

                        timerProgressBar: true

                    });

                }

            });



            // Remove spec

            $(document).on('click', '.btn-remove-spec', function(e) {

                e.preventDefault();

                $(this).closest('.spec-item').remove();

            });

        });

    </script>

    {{-- Varient Hide/Show --}}

    <script>

        function toggleVariantSection() {

            let value = $('#varient').val();

            if (value == '1') {

                $('#varient-div').show();

            } else {

                $('#varient-div').hide();

            }

        }



        // Run on page load (in case of old value)

        toggleVariantSection();



        // Run on change

        $(document).on('change', '#varient', toggleVariantSection);

    </script>

    {{-- Price Calculation --}}

    <script>

        $(document).ready(function() {



            function calculateFinalPrice() {

                let regularPrice = parseFloat($('#regular_price').val()) || 0;

                let discount = parseFloat($('#discount').val()) || 0;

                let type = $('#discount_type').val();

                let finalPrice = regularPrice;



                if (type === 'percent') {

                    finalPrice = regularPrice - (regularPrice * discount / 100);

                } else if (type === 'flat') {

                    finalPrice = regularPrice - discount;

                }



                $('#final_price').val(finalPrice.toFixed(2));

            }



            function calculateBulkFinalPrice() {

                let bulkRegular = parseFloat($('#bulk_regular_price').val()) || 0;

                let bulkDiscount = parseFloat($('#bulk_discount').val()) || 0;

                let type = $('#bulk_discount_type').val();

                let finalPrice = bulkRegular;



                if (type === 'percent') {

                    finalPrice = bulkRegular - (bulkRegular * bulkDiscount / 100);

                } else if (type === 'flat') {

                    finalPrice = bulkRegular - bulkDiscount;

                }



                $('#bulk_final_price').val(finalPrice.toFixed(2));

            }



            // Listen for input changes

            $('#regular_price, #discount, #discount_type').on('input change', calculateFinalPrice);

            $('#bulk_regular_price, #bulk_discount, #bulk_discount_type').on('input change',

                calculateBulkFinalPrice);



            // Initial calculation on page load (if editing existing product)

            calculateFinalPrice();

            calculateBulkFinalPrice();

        });

    </script>

    <script>

        $(document).ready(function() {

            $(document).on('input change', 'input, select, textarea', function() {

                if ($(this).val().trim() !== '') {

                    $(this).removeClass('is-invalid');

                }

            });

            $('#addProductFrom').on('submit', function(e) {

                e.preventDefault();



                // 🧠 Sync TinyMCE with <textarea>

                if (tinymce.get('long_desc')) {

                    tinymce.get('long_desc').save();

                }



                let errors = [];

                let firstInvalid = null; // to scroll to first error



                // Helper function to handle is-invalid class

                const markInvalid = (selector, message = '') => {

                    const $el = $(selector);

                    if (!$el.val() || $el.val().trim() === '') {

                        $el.addClass('is-invalid');

                        if (!firstInvalid) firstInvalid = $el;

                        if (message) errors.push(message);

                    } else {

                        $el.removeClass('is-invalid');

                    }

                };



                // Basic required checks

                markInvalid('#product_name', 'Product Name is required.');

                markInvalid('#product_for', 'Product for is required.');

                markInvalid('#varient', 'Select if product has variant.');

                markInvalid('#brand', 'Manufacturer name is required.');

                markInvalid('#product_identification_no', 'Product ID is required.');

                markInvalid('#short_desc', 'Product summary is required.');

                markInvalid('#product_type', 'Select product type is required.');

                markInvalid('#product_category', 'Select product category is required.');

                markInvalid('#regular_price', 'Regular price is required.');

                markInvalid('#discount', 'Discount is required.');

                markInvalid('#discount_type', 'Select discount type is required.');

                markInvalid('#bulk_regular_price', 'Regular price in bulk pricing is required.');

                markInvalid('#bulk_moq', 'Minimum order quantity in bulk pricing is required.');

                markInvalid('#bulk_discount', 'Discount in bulk pricing is required.');

                markInvalid('#bulk_discount_type', 'Discount type in bulk pricing is required.');

                markInvalid('#long_desc', 'Product description is required.');

                markInvalid('#country_of_origin', 'Select country of origin is required.');

                markInvalid('#release_date', 'Release date field is required.');

                markInvalid('#stock', 'Stock field is required.');

                markInvalid('#product_weight', 'Product weight is required.');







                // Tags (Choices.js)

                const $tags = $('#product_tags');

                if (!$tags.val() || $tags.val().trim() === '') {

                    $tags.closest('.choices').find('.choices__inner').addClass('is-invalid');

                    if (!firstInvalid) firstInvalid = $tags;

                    errors.push('Please enter at least one tag.');

                } else {

                    $tags.closest('.choices').find('.choices__inner').removeClass('is-invalid');

                }



                // If any errors, show alert

                if (errors.length > 0) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Validation Error',

                        html: errors.map(e => `<div class="text-start">• ${e}</div>`).join(''),

                    });



                    // Scroll to first error field

                    if (firstInvalid) {

                        $('html, body').animate({

                            scrollTop: firstInvalid.offset().top - 100

                        }, 500);

                        firstInvalid.focus();

                    }



                    return;

                }



                // ✅ Show SweetAlert loading

                Swal.fire({

                    title: 'Submitting...',

                    allowOutsideClick: false,

                    didOpen: () => Swal.showLoading()

                });



                // Build formData

                let formData = new FormData(this);



                let variantsData = {};



                $('#variant-list .accordion-item').each(function() {

                    let nameAttr = $(this).find('input[name*="[varient_name]"]').attr('name');

                    if (!nameAttr) return; // skip if variant name input missing



                    let variantNameMatch = nameAttr.match(/variants\[(.*?)\]/);

                    if (!variantNameMatch) return;

                    let variantName = variantNameMatch[1];



                    variantsData[variantName] = {};



                    $(this).find('input, select, textarea').each(function() {

                        let name = $(this).attr('name');

                        if (!name) return;



                        let keyMatch = name.match(/\[([^\]]+)\]$/);

                        if (!keyMatch) return;

                        let key = keyMatch[1];



                        if ($(this).is('[type="file"]')) {

                            variantsData[variantName][key] = [];

                            let files = $(this)[0].files;

                            for (let i = 0; i < files.length; i++) {

                                variantsData[variantName][key].push(files[i]);

                            }

                        } else if (name.endsWith('[]')) { // check original name for array

                            let arrayKey = key;

                            variantsData[variantName][arrayKey] = variantsData[variantName][

                                arrayKey

                            ] || [];

                            variantsData[variantName][arrayKey].push($(this).val());

                        } else {

                            variantsData[variantName][key] = $(this).val() || '';

                        }

                    });



                });





                // Append JSON string to formData

                formData.append('variants', JSON.stringify(variantsData));





                // Specifications

                $('#spec-list .spec-item').each(function(i, el) {

                    formData.append(`specifications[${i}][label]`, $(el).find(

                        'input[name="specifications[][label]"]').val());

                    formData.append(`specifications[${i}][property]`, $(el).find(

                        'input[name="specifications[][property]"]').val());

                });



                // Dropzone files (if used)

                if (dropzoneInstance && dropzoneInstance.getAcceptedFiles().length > 0) {

                    dropzoneInstance.getAcceptedFiles().forEach((file, i) => {

                        formData.append('images[]', file);

                    });

                }



                // AJAX Submit

                $.ajax({

                    url: "{{ route('product.store') }}",

                    method: "POST",

                    data: formData,

                    contentType: false,

                    processData: false,

                    success: function(res) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Product Added',

                            text: 'Your product has been added successfully.',

                            confirmButtonText: 'OK'

                        }).then(() => {

                            window.location.href = "{{ route('products') }}";

                        });

                    },

                    error: function(xhr) {

                        console.log(xhr);

                        Swal.close();

                        if (xhr.status === 422) {

                            let response = xhr.responseJSON.errors;

                            let message = '';

                            $.each(response, function(key, value) {

                                message +=

                                    `<div class="text-start">• ${value[0]}</div>`;

                                $(`[name="${key}"]`).addClass('is-invalid');

                            });

                            Swal.fire({

                                icon: 'error',

                                title: 'Server Validation Error',

                                html: message

                            });

                        } else {

                            Swal.close();

                            Swal.fire({

                                icon: 'error',

                                title: 'Something went wrong',

                                text: 'Please try again later.'

                            });

                        }

                    }

                });

            });

        });

    </script>

    <script>

        let addedAttributes = [];



        $('#addAttribute').click(function() {

            let attrSelect = $('#attributeSelect');

            let attrId = attrSelect.val();

            let attrName = attrSelect.find('option:selected').text();

            let values = attrSelect.find('option:selected').data('values');



            if (!attrId) return alert('Please select an attribute');



            // Check if already added

            if (addedAttributes.includes(attrId)) return alert('Attribute already added');



            addedAttributes.push(attrId);



            // Create value select

            let html = `<div class="row mb-2 attribute-row" data-attr-id="${attrId}">

                    <div class="col-md-4">

                        <strong>${attrName}</strong>

                    </div>

                    <div class="col-md-6">

                        <select class="form-select value-select js-choice" multiple="multiple" size="1"

                                                    data-options='{"removeItemButton":true,"placeholder":true}'>

                            ${values.map(v => `<option value="${v.id}">${v.value}</option>`).join('')}

                        </select>

                    </div>

                    <div class="col-md-2 d-flex">

                        <button type="button" class="btn btn-sm btn-danger remove-attr my-auto w-100">Remove</button>

                    </div>

                </div>`;



            $('#addedAttributes').append(html);



            // Initialize Choices.js on the newly added select

            let lastSelect = $('#addedAttributes .attribute-row').last().find('.js-choice')[0];

            new Choices(lastSelect, JSON.parse($(lastSelect).attr('data-options')));

        });



        // Remove attribute row

        $(document).on('click', '.remove-attr', function() {

            let row = $(this).closest('.attribute-row');

            let attrId = row.data('attr-id');

            addedAttributes = addedAttributes.filter(id => id != attrId);

            row.remove();

        });



        // Generate variant combinations

        function cartesianProduct(arr) {

            return arr.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [

                []

            ]);

        }



        // Cartesian Product Function

function cartesianProduct(arr) {

    return arr.reduce(function(a, b) {

        return a.flatMap(function(d) {

            return b.map(function(e) {

                return d.concat([e]);

            });

        });

    }, [[]]);

}



// Generate Variants

$('#generateVariants').click(function() {

    let selections = [];

    let selectionIds = [];



    $('.attribute-row').each(function() {

        let values = [];

        let valueIds = [];

        $(this).find('option:selected').each(function() {

            if ($(this).val() !== "") { // skip empty selections

                values.push($(this).text());

                valueIds.push($(this).val());

            }

        });

        if (values.length) {

            selections.push(values);

            selectionIds.push(valueIds);

        }

    });



    if (selections.length === 0) {

        $('#variant-list').html('<p class="text-danger">Please select at least one value for attributes.</p>');

        return;

    }



    let combos = cartesianProduct(selections);

    let combosIds = cartesianProduct(selectionIds);



    let html = '<div class="accordion" id="variantAccordion">';

    combos.forEach((combo, index) => {

        let variantName = combo.join(' - ');

        let variationIds = combosIds[index];

        let hiddenInputs = `<input type="hidden" name="variants[${index}][variation_values]" value='${JSON.stringify(variationIds)}'>`;



        html += `

        <div class="accordion-item mb-2">

            <h2 class="accordion-header" id="heading${index}">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">

                    ${variantName}

                </button>

            </h2>

            <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#variantAccordion">

                <div class="accordion-body">

                    <div class="row gx-2">

                        ${hiddenInputs}

                        <div class="col-6 mb-3">

                            <label class="form-label">Variant Name:</label>

                            <input class="form-control" name="variants[${index}][varient_name]" type="text" placeholder="Enter variant product name" />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Product Identification No.:</label>

                            <input class="form-control" name="variants[${index}][product_identification_no]" type="text" placeholder="Unique product identification no." />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Release Date:</label>

                            <input class="form-control datetimepicker" name="variants[${index}][release_date]" type="date" />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Warranty Length (months):</label>

                            <input class="form-control" name="variants[${index}][warranty]" type="number" placeholder="e.g: 12" />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Stock Qty.:</label>

                            <input class="form-control" name="variants[${index}][stock]" type="number" placeholder="e.g: 100" />

                        </div>

                        <div class="col-6 mb-3 d-flex gap-4 align-items-end">

                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="variants[${index}][in_stock]" value="1" checked />

                                <label class="form-check-label">In stock</label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="variants[${index}][in_stock]" value="0" />

                                <label class="form-check-label">Out of stock</label>

                            </div>

                        </div>



                        <!-- Image Upload -->

                        <div class="col-12 mb-3">

                            <label class="form-label">Images:</label>

                            <input type="file" class="form-control variant-images" name="variants[${index}][images][]" multiple accept="image/*" />

                            <div class="variant-preview mt-2 d-flex flex-wrap gap-2"></div>

                        </div>



                        <!-- User Pricing -->

                        <div class="card mb-3">

                            <div class="card-header bg-body-tertiary"><h6 class="mb-0">Pricing (for Users)</h6></div>

                            <div class="card-body">

                                <div class="row gx-2">

                                    <div class="col-12 mb-3">

                                        <label>Regular Price:</label>

                                        <input class="form-control regular_price" name="variants[${index}][regular_price]" type="number" step="0.01" />

                                    </div>

                                    <div class="col-8 mb-3">

                                        <label>Discount:</label>

                                        <input class="form-control discount" name="variants[${index}][discount]" type="number" />

                                    </div>

                                    <div class="col-4">

                                        <label>Type:</label>

                                        <select class="form-select discount_type" name="variants[${index}][discount_type]">

                                            <option value="">Select</option>

                                            <option value="percent">Percent</option>

                                            <option value="flat">Flat</option>

                                        </select>

                                    </div>

                                    <div class="col-12">

                                        <label>Final Price:</label>

                                        <input class="form-control final_price" name="variants[${index}][final_price]" type="text" readonly />

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- Bulk Pricing -->

                        <div class="card mb-3">

                            <div class="card-header bg-body-tertiary"><h6 class="mb-0">Bulk Pricing (for Labs)</h6></div>

                            <div class="card-body">

                                <div class="row gx-2">

                                    <div class="col-8 mb-3">

                                        <label>Regular Price:</label>

                                        <input class="form-control bulk_regular_price" name="variants[${index}][bulk_regular_price]" type="number" step="0.01" />

                                    </div>

                                    <div class="col-4">

                                        <label>MOQ:</label>

                                        <input class="form-control" name="variants[${index}][bulk_moq]" type="number" />

                                    </div>

                                    <div class="col-8 mb-3">

                                        <label>Discount:</label>

                                        <input class="form-control bulk_discount" name="variants[${index}][bulk_discount]" type="number" />

                                    </div>

                                    <div class="col-4">

                                        <label>Type:</label>

                                        <select class="form-select bulk_discount_type" name="variants[${index}][bulk_discount_type]">

                                            <option value="">Select</option>

                                            <option value="percent">Percent</option>

                                            <option value="flat">Flat</option>

                                        </select>

                                    </div>

                                    <div class="col-12">

                                        <label>Final Price:</label>

                                        <input class="form-control bulk_final_price" name="variants[${index}][bulk_final_price]" type="text" readonly />

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div> <!-- row -->

                </div> <!-- accordion-body -->

            </div> <!-- collapse -->

        </div> <!-- accordion-item -->

        `;

    });



    html += '</div>';

    $('#variant-list').html(html);

});



// ✅ Auto Calculate User and Bulk Final Prices

$(document).on('input change', '.regular_price, .discount, .discount_type, .bulk_regular_price, .bulk_discount, .bulk_discount_type', function() {

    let row = $(this).closest('.accordion-body');



    // --- User Pricing ---

    let price = parseFloat(row.find('.regular_price').val()) || 0;

    let discount = parseFloat(row.find('.discount').val()) || 0;

    let type = row.find('.discount_type').val();

    let finalPrice = price;



    if (discount && type === 'percent') {

        finalPrice = price - (price * discount / 100);

    } else if (discount && type === 'flat') {

        finalPrice = price - discount;

    }



    row.find('.final_price').val(finalPrice.toFixed(2));



    // --- Bulk Pricing ---

    let bulkPrice = parseFloat(row.find('.bulk_regular_price').val()) || 0;

    let bulkDiscount = parseFloat(row.find('.bulk_discount').val()) || 0;

    let bulkType = row.find('.bulk_discount_type').val();

    let bulkFinal = bulkPrice;



    if (bulkDiscount && bulkType === 'percent') {

        bulkFinal = bulkPrice - (bulkPrice * bulkDiscount / 100);

    } else if (bulkDiscount && bulkType === 'flat') {

        bulkFinal = bulkPrice - bulkDiscount;

    }



    row.find('.bulk_final_price').val(bulkFinal.toFixed(2));

});





        // Image Preview

        $(document).on('change', '.variant-images', function() {

            let previewContainer = $(this).siblings('.variant-preview');

            previewContainer.html('');

            let files = this.files;

            for (let i = 0; i < files.length; i++) {

                let reader = new FileReader();

                reader.onload = function(e) {

                    let imgHtml = `

            <div class="position-relative">

                <img src="${e.target.result}" class="img-thumbnail" style="width:100px; height:100px;">

                <span class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-img">&times;</span>

            </div>`;

                    previewContainer.append(imgHtml);

                }

                reader.readAsDataURL(files[i]);

            }

        });



        // Remove Image

        $(document).on('click', '.remove-img', function() {

            $(this).parent().remove();

        });

    </script>

@endsection

