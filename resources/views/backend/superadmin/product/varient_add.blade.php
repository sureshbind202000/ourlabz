@extends('backend.includes.layout')
@section('content')
    <form action="" id="addVarientFrom" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product_id }}">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Add Varient</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ url('/') }}/vendor-product/{{encrypt($product_id)}}/varients" class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>
                        <input type="submit" value="Add Varient" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3">
                    <div class="card-header bg-body-tertiary">
                        <h6 class="mb-0">Varient information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-2">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="product_identification_no">Product Identification
                                    No.:</label>
                                <input class="form-control" id="product_identification_no" name="product_identification_no"
                                    type="text" placeholder="Unique product identification no." />
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

                            <div class="col-6 mb-3 d-flex gap-4 align-items-end justify-content-center">
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
                                    src="../../../assets/img/icons/cloud-upload.svg" width="25"
                                    alt="" /><span class="d-none d-lg-inline">Drag your image here<br />or,
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
            </div>
            <div class="col-lg-4 ps-lg-2">
                <div class="sticky-sidebar">

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
                        <a href="{{ url('/') }}/vendor-product/{{encrypt($product_id)}}/varients"
                            class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>
                        <input type="submit" value="Add Varient" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#add-varient-btn').on('click', function(e) {
                e.preventDefault();

                let attribute = $('#varient-attribute').val().trim();
                let property = $('#varient-value').val().trim();

                if (attribute === '' || property === '') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Please enter both Attribute and Property.',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                // Check if attribute already exists
                let existing = $('#varient-list .varient-item[data-attribute="' + attribute + '"]');
                if (existing.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Attribute',
                        text: 'This attribute already exists. Remove it first or use a different name.',
                    });
                    return;
                }

                let index = $('#varient-list .varient-item').length;

                let itemHtml = `
<div class="row gx-2 flex-between-center mb-3 spec-item varient-item" data-attribute="${attribute}">
  <div class="col-sm-3">
    <h6 class="mb-0 text-600">${attribute}</h6>
    <input type="hidden" name="variants[${index}][attribute]" value="${attribute}">
  </div>
  <div class="col-sm-9">
    <div class="d-flex flex-between-center">
      <h6 class="mb-0 text-700">${property}</h6>
      <input type="hidden" name="variants[${index}][property]" value="${property}">
      <a class="btn btn-sm btn-link text-danger btn-remove-varient" href="#!" title="Remove">
        <span class="fs-10 fas fa-trash-alt"></span>
      </a>
    </div>
  </div>
</div>`;

                $('#varient-list').append(itemHtml);
                $('#varient-attribute').val('');
                $('#varient-value').val('');
            });

            // Remove variant
            $(document).on('click', '.btn-remove-varient', function() {
                $(this).closest('.varient-item').remove();
            });
        });
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
            $('#addVarientFrom').on('submit', function(e) {
                e.preventDefault();

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
                markInvalid('#product_identification_no', 'Product ID is required.');
                markInvalid('#regular_price', 'Regular price is required.');
                markInvalid('#discount', 'Discount is required.');
                markInvalid('#discount_type', 'Select discount type is required.');
                markInvalid('#bulk_regular_price', 'Regular price in bulk pricing is required.');
                markInvalid('#bulk_moq', 'Minimum order quantity in bulk pricing is required.');
                markInvalid('#bulk_discount', 'Discount in bulk pricing is required.');
                markInvalid('#bulk_discount_type', 'Discount type in bulk pricing is required.');
                markInvalid('#release_date', 'Release date field is required.');
                markInvalid('#stock', 'Stock field is required.');

                // Variant validation
                if ($('#varient').val() === '1' && $('#varient-list .spec-item').length === 0) {
                    errors.push('Please add at least one product variant.');
                    if (!firstInvalid) firstInvalid = $('#varient-attribute');
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

                // Variants
                $('#varient-list .varient-item').each(function(i, el) {
                    formData.append(`variants[${i}][attribute]`, $(el).find(
                        'input[name^="variants"]').eq(0).val());
                    formData.append(`variants[${i}][property]`, $(el).find(
                        'input[name^="variants"]').eq(1).val());
                });


                // Dropzone files (if used)
                if (dropzoneInstance && dropzoneInstance.getAcceptedFiles().length > 0) {
                    dropzoneInstance.getAcceptedFiles().forEach((file, i) => {
                        formData.append('images[]', file);
                    });
                }

                // AJAX Submit
                $.ajax({
                    url: "{{ route('product.varient.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Varient Added',
                            text: 'Your product varient has been added successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ url('/') }}/vendor-product/{{encrypt($product_id)}}/varients";
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
@endsection
