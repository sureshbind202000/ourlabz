@extends('backend.includes.layout')

@section('content')

    <form action="" id="updateProductFrom" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="card mb-3">

            <div class="card-body">

                <div class="row flex-between-center">

                    <div class="col-md">

                        <h5 class="mb-2 mb-md-0">Edit product</h5>

                    </div>

                    <div class="col-auto">

                        <a href="{{ route('products') }}" class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>

                        <input type="submit" value="Update product" class="btn btn-primary">

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

                                    placeholder="Enter product name" value="{{ $product->product_name ?? '' }}" />

                            </div>

                            <div class="col-4 mb-3">

                                <label class="form-label" for="varient">Product has varient:</label>

                                <select name="varient" id="varient" class="form-control">

                                    <option value="">--select--</option>

                                    <option value="1" {{ $product->varient == 1 ? 'selected' : '' }}>Yes</option>

                                    <option value="0" {{ $product->varient == 0 ? 'selected' : '' }}>No</option>

                                </select>

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label" for="brand">Manufacturar Name:</label>

                                <input class="form-control" id="brand" name="brand" type="text"

                                    placeholder="Enter manufacturar name (Brand)" value="{{ $product->brand ?? '' }}" />

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label" for="product_identification_no">Product Identification

                                    No.:</label>

                                <input class="form-control" id="product_identification_no" name="product_identification_no"

                                    type="text" placeholder="Unique product identification no."

                                    value="{{ $product->product_identification_no ?? '' }}" />

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label" for="short_desc">Product Summary:</label>

                                <textarea name="short_desc" class="form-control" id="short_desc" rows="4"

                                    placeholder="Write short description about product...">{{ $product->short_desc ?? '' }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Add images</h6>

                    </div>

                    <div class="card-body">

                        <div class="row" id="existing-images">

                            @foreach ($product->images as $img)

                                <div class="col-md-3 position-relative mb-3" id="image-box-{{ $img->id }}">

                                    <img src="{{ asset($img->image) }}" class="img-thumbnail w-100" />

                                    <button type="button"

                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-existing-image"

                                        data-id="{{ $img->id }}" style="z-index: 10;">&times;</button>

                                </div>

                            @endforeach

                        </div>



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

                                        placeholder="Write long description about product...">{{ $product->long_desc }}</textarea>

                                </div>

                            </div>



                            <div class="col-sm-6 mb-3">

                                <label class="form-label" for="country_of_origin">Country of Origin: </label>

                                <select class="form-select" id="country_of_origin" name="country_of_origin">

                                    <option value="">Select </option>

                                    <option value="China" {{ $product->country_of_origin == 'China' ? 'selected' : '' }}>

                                        China</option>

                                    <option value="India" {{ $product->country_of_origin == 'India' ? 'selected' : '' }}>

                                        India</option>

                                    <option value="United States"

                                        {{ $product->country_of_origin == 'States' ? 'selected' : '' }}>United States

                                    </option>

                                    <option value="Indonesia"

                                        {{ $product->country_of_origin == 'Indonesia' ? 'selected' : '' }}>Indonesia

                                    </option>

                                    <option value="Pakistan"

                                        {{ $product->country_of_origin == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>

                                    <option value="Brazil"

                                        {{ $product->country_of_origin == 'Brazil' ? 'selected' : '' }}>Brazil</option>

                                    <option value="Nigeria"

                                        {{ $product->country_of_origin == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>

                                    <option value="Bangladesh"

                                        {{ $product->country_of_origin == 'Bangladesh' ? 'selected' : '' }}>Bangladesh

                                    </option>

                                    <option value="Russia"

                                        {{ $product->country_of_origin == 'Russia' ? 'selected' : '' }}>Russia</option>

                                    <option value="Japan" {{ $product->country_of_origin == 'Japan' ? 'selected' : '' }}>

                                        Japan</option>

                                    <option value="Mexico"

                                        {{ $product->country_of_origin == 'Mexico' ? 'selected' : '' }}>Mexico</option>

                                    <option value="Philippines"

                                        {{ $product->country_of_origin == 'Philippines' ? 'selected' : '' }}>Philippines

                                    </option>

                                    <option value="Egypt" {{ $product->country_of_origin == 'Egypt' ? 'selected' : '' }}>

                                        Egypt</option>

                                    <option value="Vietnam"

                                        {{ $product->country_of_origin == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>

                                    <option value="Ethiopia"

                                        {{ $product->country_of_origin == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>

                                    <option value="DR Congo"

                                        {{ $product->country_of_origin == 'Congo' ? 'selected' : '' }}>DR Congo</option>

                                    <option value="Iran" {{ $product->country_of_origin == 'Iran' ? 'selected' : '' }}>

                                        Iran</option>

                                    <option value="Turkey"

                                        {{ $product->country_of_origin == 'Turkey' ? 'selected' : '' }}>Turkey</option>

                                    <option value="Germany"

                                        {{ $product->country_of_origin == 'Germany' ? 'selected' : '' }}>Germany</option>

                                    <option value="France"

                                        {{ $product->country_of_origin == 'France' ? 'selected' : '' }}>France</option>

                                </select>

                            </div>

                            <div class="col-6 mb-3">

                                <label class="form-label" for="release_date">Release Date: </label>

                                <input class="form-control datetimepicker" id="release_date" name="release_date"

                                    type="text" data-options='{"dateFormat":"d/m/y","disableMobile":true}'

                                    placeholder="Manufacture date" value="{{ $product->release_date ?? '' }}" />

                            </div>

                            <div class="col-6 mb-3">

                                <label class="form-label" for="warranty">Warranty Lenght (in months): </label>

                                <input class="form-control" id="warranty" name="warranty" type="text"

                                    placeholder="e.g : 12" value="{{ $product->warranty ?? '' }}" />

                            </div>

                            <div class="col-6 mb-3">

                                <label class="form-label" for="stock">Stock Qty.: </label>

                                <input class="form-control" id="stock" name="stock" type="text"

                                    placeholder="e.g. : 100" value="{{ $product->stock ?? '' }}" />

                            </div>

                            <div class="col-sm-6 mb-3">

                                <label class="form-label" for="product_for">Product For: </label>

                                <select class="form-select" id="product_for" name="product_for">

                                    <option value="">Select </option>

                                    <option value="user" {{ $product->product_for == 'user' ? 'selected' : '' }}>Users

                                    </option>

                                    <option value="lab" {{ $product->product_for == 'lab' ? 'selected' : '' }}>Labs

                                    </option>

                                    <option value="both" {{ $product->product_for == 'both' ? 'selected' : '' }}>Both

                                    </option>

                                </select>

                            </div>

                            <div class="col-sm-6 mb-3">

                                <label class="form-label" for="product_weight">Product Weight (in grams) : </label>
                                <input type="number" class="form-control" name="product_weight" id="product_weight" placeholder="e.g 100" value="{{$product->weight ?? 0}}">
                                <span class="text-danger small">Product weight is required for shipping</span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card mb-3 ">

                    <div class="card-header bg-body-tertiary">

                        <h6 class="mb-0">Additional Details</h6>

                    </div>

                    <div class="card-body">

                        <div id="spec-list">

                            @if (!empty($product->specifications))

                                @foreach ($product->specifications as $index => $spec)

                                    <div class="row gx-2 flex-between-center mb-3 spec-item">

                                        <div class="col-sm-3">

                                            <h6 class="mb-0 text-600">{{ $spec->label }}</h6>

                                            <input type="hidden" name="specifications[][label]"

                                                value="{{ $spec->label }}">

                                        </div>

                                        <div class="col-sm-9">

                                            <div class="d-flex flex-between-center">

                                                <h6 class="mb-0 text-700">{{ $spec->property }}</h6>

                                                <input type="hidden" name="specifications[][property]"

                                                    value="{{ $spec->property }}">

                                                <a class="btn btn-sm btn-link text-danger btn-remove-spec" href="#!"

                                                    title="Remove">

                                                    <span class="fs-10 fas fa-trash-alt"></span>

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            @endif

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



                <div class="card mb-3 mb-lg-0" id="varient-div" style="display: none;">

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

                                {{-- Type Dropdown --}}

                                <div class="col-12 mb-3">

                                    <label class="form-label" for="product_type">Select type:</label>

                                    <select class="form-select" id="product_type" name="product_type">

                                        <option value="">Select Type</option>

                                        @foreach ($types as $type)

                                            <option value="{{ $type->id }}"

                                                {{ $type->id == $product->type ? 'selected' : '' }}>

                                                {{ $type->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>



                                {{-- Category Dropdown --}}

                                <div class="col-12 mb-3" id="category-wrap">

                                    <label class="form-label" for="product_category">Select category:</label>

                                    <select class="form-select" id="product_category" name="product_category">

                                        <option value="">Select Category</option>

                                        @foreach ($categories as $cat)

                                            @if ($cat->type_id == $product->type)

                                                <option value="{{ $cat->id }}"

                                                    {{ $cat->id == $product->category ? 'selected' : '' }}>

                                                    {{ $cat->name }}

                                                </option>

                                            @endif

                                        @endforeach

                                    </select>

                                </div>



                                {{-- Sub-Category Dropdown --}}

                                <div class="col-12" id="subcategory-wrap">

                                    <label class="form-label" for="product_subcategory">Select sub-category:</label>

                                    <select class="form-select" id="product_subcategory" name="product_subcategory">

                                        <option value="">Select Sub-category</option>

                                        @foreach ($subcategories as $sub)

                                            @if ($sub->category_id == $product->category)

                                                <option value="{{ $sub->id }}"

                                                    {{ $sub->id == $product->sub_category ? 'selected' : '' }}>

                                                    {{ $sub->name }}

                                                </option>

                                            @endif

                                        @endforeach

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

                                        step="0.01" placeholder="Enter regular price"

                                        value="{{ $product->regular_price ?? '' }}" />

                                </div>

                                <div class="col-8 mb-3">

                                    <label class="form-label" for="discount">Discount :</label>

                                    <input class="form-control" id="discount" name="discount" type="number"

                                        placeholder="Enter discount" value="{{ $product->discount ?? '' }}" />

                                </div>

                                <div class="col-4">

                                    <label class="form-label" for="discount_type">Type:</label>

                                    <select class="form-select" id="discount_type" name="discount_type">

                                        <option value="">select</option>

                                        <option value="percent"

                                            {{ $product->discount_type == 'percent' ? 'selected' : '' }}>Percent</option>

                                        <option value="flat" {{ $product->discount_type == 'flat' ? 'selected' : '' }}>

                                            Flat</option>

                                    </select>

                                </div>

                                <div class="col-12">

                                    <label class="form-label" for="final_price">Final price:

                                    </label>

                                    <input class="form-control" id="final_price" name="final_price" readonly

                                        type="text" placeholder="Final price auto calculated"

                                        value="{{ $product->final_price ?? '' }}" />

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

                                        type="number" step="0.01" placeholder="Enter regular price"

                                        value="{{ $product->bulk_regular_price ?? '' }}" />

                                </div>

                                <div class="col-4">

                                    <label class="form-label" for="bulk_moq">MOQ:</label>

                                    <input class="form-control" id="bulk_moq" name="bulk_moq" type="number"

                                        placeholder="e.g : 1" value="{{ $product->bulk_moq ?? '' }}" />

                                </div>

                                <div class="col-8 mb-3">

                                    <label class="form-label" for="bulk_discount">Discount :</label>

                                    <input class="form-control" id="bulk_discount" name="bulk_discount" type="number"

                                        placeholder="Enter discount" value="{{ $product->bulk_discount ?? '' }}" />

                                </div>

                                <div class="col-4">

                                    <label class="form-label" for="bulk_discount_type">Type:</label>

                                    <select class="form-select" id="bulk_discount_type" name="bulk_discount_type">

                                        <option value="">select</option>

                                        <option value="percent"

                                            {{ $product->bulk_discount_type == 'percent' ? 'selected' : '' }}>

                                            Percent</option>

                                        <option value="flat"

                                            {{ $product->bulk_discount_type == 'flat' ? 'selected' : '' }}>Flat

                                        </option>

                                    </select>

                                </div>

                                <div class="col-12">

                                    <label class="form-label" for="bulk_final_price">Final price:

                                    </label>

                                    <input class="form-control" name="bulk_final_price" id="bulk_final_price" readonly

                                        type="text" placeholder="Final price auto calculated"

                                        value="{{ $product->bulk_final_price ?? '' }}" />

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

                                    value="1" {{ $product->shipping == 1 ? 'checked' : '' }}>

                                <label class="form-check-label fs-9 fw-normal text-700" for="vendor-delivery">

                                    Delivered by vendor (you)

                                </label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input p-2" id="ourlabz-delivery" type="radio" name="shipping"

                                    value="2" {{ $product->shipping == 2 ? 'checked' : '' }}>

                                <label class="form-check-label fs-9 fw-normal text-700" for="ourlabz-delivery">

                                    Delivered by Ourlabz

                                    <span class="badge badge-subtle-warning rounded-pill ms-2">Recommended</span>

                                </label>

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

                                    value="1" {{ $product->in_stock == 1 ? 'checked' : '' }}>

                                <label class="form-check-label fs-9 fw-normal text-700" for="in_stock">In stock</label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input p-2" id="out_of_stock" type="radio" name="in_stock"

                                    value="0" {{ $product->in_stock == 0 ? 'checked' : '' }}>

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

                            <input class="form-control" id="product_tags" type="text" name="tags"

                                value="{{ $product->tags }}" />

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

                        <input type="submit" value="Update product" class="btn btn-primary">

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

            $('#updateProductFrom').on('submit', function(e) {

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

                markInvalid('#product_for', 'Product For is required.');

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



                // Variants

                $('#varient-list .varient-item').each(function(i, el) {

                    formData.append(`variants[${i}][attribute]`, $(el).find(

                        'input[name^="variants"]').eq(0).val());

                    formData.append(`variants[${i}][property]`, $(el).find(

                        'input[name^="variants"]').eq(1).val());

                });



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

                    url: "{{ route('product.update', $product->id) }}",

                    method: "POST",

                    data: formData,

                    contentType: false,

                    processData: false,

                    success: function(res) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Product Updated',

                            text: 'Your product has been updated successfully.',

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

        document.addEventListener('DOMContentLoaded', function() {

            const tagsInput = document.getElementById('product_tags');



            if (tagsInput) {

                const tagsValue = tagsInput.value;

                const tagArray = tagsValue.split(',').map(tag => tag.trim()).filter(tag => tag !== '');



                const choices = new Choices(tagsInput, {

                    removeItemButton: true,

                    duplicateItemsAllowed: false,

                });



                // Clear the default value and add tags as items

                choices.clearStore();

                tagArray.forEach(tag => choices.setValue([{

                    value: tag,

                    label: tag

                }]));

            }

        });



        $(document).on('click', '.remove-existing-image, .remove-img', function() {

            let btn = $(this);

            let imageId = btn.data('id');



            Swal.fire({

                title: 'Are you sure?',

                text: "This image will be permanently deleted!",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, delete it!'

            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: `/product/image/${imageId}/delete`,

                        type: 'DELETE',

                        data: {

                            _token: '{{ csrf_token() }}'

                        },

                        success: function(res) {

                            if (res.success) {

                                $('#image-box-' + imageId).remove();

                                $(this).parent().remove();

                                Swal.fire('Deleted!', res.message, 'success');

                            } else {

                                Swal.fire('Error', 'Failed to delete image.', 'error');

                            }

                        },

                        error: function() {

                            Swal.fire('Error', 'Something went wrong.', 'error');

                        }

                    });

                }

            });

        });

    </script>

    <script>

        @php

            $variantData = $product->variants

                ->map(function ($v) {

                    return [

                        'id' => $v->id,

                        'varient_name' => $v->varient_name,

                        'variation_values' => $v->variation_values,

                        'product_identification_no' => $v->product_identification_no,

                        'release_date' => $v->release_date,

                        'warranty' => $v->warranty,

                        'stock' => $v->stock,

                        'in_stock' => $v->in_stock,

                        'regular_price' => $v->regular_price,

                        'discount' => $v->discount,

                        'discount_type' => $v->discount_type,

                        'final_price' => $v->selling_price,

                        'bulk_regular_price' => $v->bulk_regular_price,

                        'bulk_moq' => $v->bulk_moq,

                        'bulk_discount' => $v->bulk_discount,

                        'bulk_discount_type' => $v->bulk_discount_type,

                        'bulk_final_price' => $v->bulk_selling_price,

                        'images' => $v->images->pluck('image'),

                    ];

                })

                ->values();

        @endphp



        let existingVariants = @json($variantData);



        // 🧩 RENDER EXISTING VARIANTS

        function renderExistingVariants() {

            if (!existingVariants || existingVariants.length === 0) return;



            let html = '<div class="accordion" id="variantAccordion">';

            existingVariants.forEach((variant, index) => {

                let variationIds = variant.variation_values || [];

                let hiddenInputs = `

                <input type="hidden" name="variants[${index}][id]" value="${variant.id || ''}">

                <input type="hidden" name="variants[${index}][variation_values]" value='${JSON.stringify(variationIds)}'>

            `;



                let checkedInStock = variant.in_stock == 1 ? 'checked' : '';

                let checkedOutStock = variant.in_stock == 0 ? 'checked' : '';



                html += `

            <div class="accordion-item mb-2">

                <h2 class="accordion-header" id="heading${index}">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                        data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">

                        ${variant.varient_name}

                    </button>

                </h2>

                <div id="collapse${index}" class="accordion-collapse collapse" data-bs-parent="#variantAccordion">

                    <div class="accordion-body">

                        <div class="row gx-2">

                            ${hiddenInputs}

                            <div class="col-6 mb-3">

                                <label>Variant Name:</label>

                                <input class="form-control" name="variants[${index}][varient_name]" type="text" value="${variant.varient_name || ''}">

                            </div>

                            <div class="col-6 mb-3">

                                <label>Product Identification No.:</label>

                                <input class="form-control" name="variants[${index}][product_identification_no]" type="text" value="${variant.product_identification_no || ''}">

                            </div>

                            <div class="col-6 mb-3">

                                <label>Release Date:</label>

                                <input class="form-control" name="variants[${index}][release_date]" type="date" value="${variant.release_date || ''}">

                            </div>

                            <div class="col-6 mb-3">

                                <label>Warranty:</label>

                                <input class="form-control" name="variants[${index}][warranty]" type="number" value="${variant.warranty || ''}">

                            </div>

                            <div class="col-6 mb-3">

                                <label>Stock Qty.:</label>

                                <input class="form-control" name="variants[${index}][stock]" type="number" value="${variant.stock || ''}">

                            </div>

                            <div class="col-6 mb-3 d-flex gap-4 align-items-end">

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="variants[${index}][in_stock]" value="1" ${checkedInStock}>

                                    <label>In stock</label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="variants[${index}][in_stock]" value="0" ${checkedOutStock}>

                                    <label>Out of stock</label>

                                </div>

                            </div>

                        </div>



                        <div class="col-12 mb-3">

                            <label>Images:</label>

                            <input type="file" class="form-control variant-images" name="variants[${index}][images][]" multiple>

                            <div class="variant-preview mt-2 d-flex flex-wrap gap-2">

                                ${variant.images.map(img => `

                                                <div class="position-relative">

                                                    <img src="/${img}" class="img-thumbnail" style="width:100px; height:100px;">

                                                    <span class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-img remove-existing-image">&times;</span>

                                                </div>

                                            `).join('')}

                            </div>

                        </div>



                        <!-- User Pricing -->

                        <div class="card mb-3">

                            <div class="card-header bg-body-tertiary"><h6 class="mb-0">Pricing (for Users)</h6></div>

                            <div class="card-body">

                                <div class="row gx-2">

                                    <div class="col-12 mb-3">

                                        <label>Regular Price:</label>

                                        <input class="form-control regular-price" name="variants[${index}][regular_price]" type="number" step="0.01" value="${variant.regular_price || ''}" />

                                    </div>

                                    <div class="col-8 mb-3">

                                        <label>Discount:</label>

                                        <input class="form-control discount" name="variants[${index}][discount]" type="number" value="${variant.discount || ''}" />

                                    </div>

                                    <div class="col-4">

                                        <label>Type:</label>

                                        <select class="form-select discount-type" name="variants[${index}][discount_type]">

                                            <option value="">Select</option>

                                            <option value="percent" ${variant.discount_type == 'percent' ? 'selected' : ''}>Percent</option>

                                            <option value="flat" ${variant.discount_type == 'flat' ? 'selected' : ''}>Flat</option>

                                        </select>

                                    </div>

                                    <div class="col-12">

                                        <label>Final Price:</label>

                                        <input class="form-control final-price" name="variants[${index}][final_price]" type="text" readonly value="${variant.final_price || ''}" />

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

                                        <input class="form-control bulk-regular-price" name="variants[${index}][bulk_regular_price]" type="number" step="0.01" value="${variant.bulk_regular_price || ''}" />

                                    </div>

                                    <div class="col-4">

                                        <label>MOQ:</label>

                                        <input class="form-control" name="variants[${index}][bulk_moq]" type="number" value="${variant.bulk_moq || ''}" />

                                    </div>

                                    <div class="col-8 mb-3">

                                        <label>Discount:</label>

                                        <input class="form-control bulk-discount" name="variants[${index}][bulk_discount]" type="number" value="${variant.bulk_discount || ''}" />

                                    </div>

                                    <div class="col-4">

                                        <label>Type:</label>

                                        <select class="form-select bulk-discount-type" name="variants[${index}][bulk_discount_type]">

                                            <option value="">Select</option>

                                            <option value="percent" ${variant.bulk_discount_type == 'percent' ? 'selected' : ''}>Percent</option>

                                            <option value="flat" ${variant.bulk_discount_type == 'flat' ? 'selected' : ''}>Flat</option>

                                        </select>

                                    </div>

                                    <div class="col-12">

                                        <label>Final Price:</label>

                                        <input class="form-control bulk-final-price" name="variants[${index}][bulk_final_price]" type="text" readonly value="${variant.bulk_final_price || ''}" />

                                    </div>

                                </div>

                            </div>

                        </div>



                        <div class="col-12 mb-3 text-end">

                            <button type="button" class="btn btn-sm btn-danger delete-variant-btn" data-id="${variant.id || ''}">Remove</button>

                        </div>

                    </div>

                </div>

            </div>`;

            });



            html += '</div>';

            $('#variant-list').append(html);



            bindAutoPriceCalc();

        }



        // 🧮 Function to recalc final price (User + Bulk)

        function recalcFinalPrice() {

            $('.accordion-item').each(function() {

                let reg = parseFloat($(this).find('.regular-price').val()) || 0;

                let dis = parseFloat($(this).find('.discount').val()) || 0;

                let dtype = $(this).find('.discount-type').val();

                let finalPrice = reg;



                if (reg > 0 && dis > 0) {

                    finalPrice = dtype === 'percent' ? reg - (reg * dis / 100) : reg - dis;

                }

                $(this).find('.final-price').val(finalPrice.toFixed(2));



                // Bulk

                let bulkReg = parseFloat($(this).find('.bulk-regular-price').val()) || 0;

                let bulkDis = parseFloat($(this).find('.bulk-discount').val()) || 0;

                let bulkType = $(this).find('.bulk-discount-type').val();

                let bulkFinal = bulkReg;



                if (bulkReg > 0 && bulkDis > 0) {

                    bulkFinal = bulkType === 'percent' ? bulkReg - (bulkReg * bulkDis / 100) : bulkReg - bulkDis;

                }

                $(this).find('.bulk-final-price').val(bulkFinal.toFixed(2));

            });

        }



        // 🔄 Bind auto calculation to input events

        function bindAutoPriceCalc() {

            $(document).on('input change',

                '.regular-price, .discount, .discount-type, .bulk-regular-price, .bulk-discount, .bulk-discount-type',

                function() {

                    recalcFinalPrice();

                });



            // Trigger once on load for prefilled values

            recalcFinalPrice();

        }



        $(document).ready(function() {

            renderExistingVariants();

        });







        $(document).on('click', '.delete-variant-btn', function() {

            let varientId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the variant and all related data!",

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#d33",

                cancelButtonColor: "#3085d6",

                confirmButtonText: "Yes, delete it!"

            }).then((result) => {

                if (result.isConfirmed) {

                    $('.loading').show();



                    $.ajax({

                        url: `/product-varient/${varientId}`,

                        type: "DELETE",

                        data: {

                            _token: "{{ csrf_token() }}"

                        },

                        success: function(response) {

                            $('.loading').hide();



                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The varient and related data have been deleted.",

                                    "success");

                                fetchVarients(); // 🔄 Refresh the package list

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }

                        },

                        error: function(xhr) {

                            $('.loading').hide();

                            Swal.fire("Error!", "Failed to delete package.",

                                "error");

                        }

                    });

                }

            });

        });

    </script>



    <script>

        let addedAttributes = [];



        // Prefill attributes & values from existing product variants

        function prefillAttributesFromVariants(existingVariants, allAttributes) {

            // Collect all used value IDs

            let usedValueIds = [];

            existingVariants.forEach(v => {

                if (v.variation_values) {

                    usedValueIds = usedValueIds.concat(v.variation_values.map(String)); // make sure it's string

                }

            });



            // Loop through all attributes

            allAttributes.forEach(attr => {

                let attrId = attr.id;

                let attrName = attr.name;

                let values = attr.values;



                // Filter only values that are used in variants

                let selectedValues = values.filter(v => usedValueIds.includes(v.id.toString()));



                if (selectedValues.length && !addedAttributes.includes(attrId)) {

                    addedAttributes.push(attrId);



                    let html = `<div class="row mb-2 attribute-row" data-attr-id="${attrId}">

                <div class="col-md-4">

                    <strong>${attrName}</strong>

                </div>

                <div class="col-md-6">

                    <select class="form-select value-select js-choice" multiple="multiple" size="1"

                        data-options='{"removeItemButton":true,"placeholder":true}'>

                        ${values.map(v => `<option value="${v.id}" ${selectedValues.find(sv => sv.id == v.id) ? 'selected' : ''}>${v.value}</option>`).join('')}

                    </select>

                </div>

                <div class="col-md-2 d-flex">

                    <button type="button" class="btn btn-sm btn-danger remove-attr my-auto w-100">Remove</button>

                </div>

            </div>`;



                    $('#addedAttributes').append(html);



                    // Initialize Choices.js for multi-select

                    let lastSelect = $('#addedAttributes .attribute-row').last().find('.js-choice')[0];

                    new Choices(lastSelect, JSON.parse($(lastSelect).attr('data-options')));

                }

            });

        }



        // Call this on document ready

        $(document).ready(function() {

            // Pass your existing variants and attributes from blade

            let existingVariants = @json($product->variants);

            let allAttributes = @json($attributes);



            prefillAttributesFromVariants(existingVariants, allAttributes);

        });



        // Existing add / remove logic still works

        $('#addAttribute').click(function() {

            let attrSelect = $('#attributeSelect');

            let attrId = attrSelect.val();

            let attrName = attrSelect.find('option:selected').text();

            let values = attrSelect.find('option:selected').data('values');



            if (!attrId) return alert('Please select an attribute');



            if (addedAttributes.includes(attrId)) return alert('Attribute already added');



            addedAttributes.push(attrId);



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



            let lastSelect = $('#addedAttributes .attribute-row').last().find('.js-choice')[0];

            new Choices(lastSelect, JSON.parse($(lastSelect).attr('data-options')));

        });



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



        // Keep a counter to avoid ID conflicts

        let variantCounter = $('#variant-list .accordion-item').length;



        // Generate Variants (Edit Page)

        $('#generateVariants').click(function() {

            let selections = [];

            let selectionIds = [];



            $('.attribute-row').each(function() {

                let values = [];

                let valueIds = [];

                $(this).find('option:selected').each(function() {

                    if ($(this).val() !== "") {

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

                $('#variant-list').html(

                    '<p class="text-danger">Please select at least one value for attributes.</p>');

                return;

            }



            let combos = cartesianProduct(selections);

            let combosIds = cartesianProduct(selectionIds);



            // Collect existing variation combinations to avoid duplicates

            let existingCombos = [];

            $('#variant-list input[name*="[variation_values]"]').each(function() {

                let vals = $(this).val();

                if (vals) existingCombos.push(JSON.stringify(JSON.parse(vals).sort()));

            });



            let html = $('#variant-list .accordion').length ? '' : '<div class="accordion" id="variantAccordion">';



            combos.forEach((combo, index) => {

                let variationIds = combosIds[index];

                let sortedVariationIds = JSON.stringify(variationIds.sort());



                // Skip if combination already exists

                if (existingCombos.includes(sortedVariationIds)) return;



                let variantName = combo.join(' - ');

                let hiddenInputs =

                    `<input type="hidden" name="variants[new_${variantCounter}][variation_values]" value='${JSON.stringify(variationIds)}'>`;



                html += `

        <div class="accordion-item mb-2">

            <h2 class="accordion-header" id="headingnew_${variantCounter}">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenew_${variantCounter}" aria-expanded="false" aria-controls="collapsenew_${variantCounter}">

                    ${variantName}

                </button>

            </h2>

            <div id="collapsenew_${variantCounter}" class="accordion-collapse collapse" aria-labelledby="headingnew_${variantCounter}" data-bs-parent="#variantAccordion">

                <div class="accordion-body">

                    <div class="row gx-2">

                        ${hiddenInputs}

                        <div class="col-6 mb-3">

                            <label class="form-label">Variant Name:</label>

                            <input class="form-control" name="variants[new_${variantCounter}][varient_name]" type="text" placeholder="Enter variant product name" />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Product Identification No.:</label>

                            <input class="form-control" name="variants[new_${variantCounter}][product_identification_no]" type="text" placeholder="Unique product identification no." />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Release Date:</label>

                            <input class="form-control datetimepicker" name="variants[new_${variantCounter}][release_date]" type="date" />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Warranty Length (months):</label>

                            <input class="form-control" name="variants[new_${variantCounter}][warranty]" type="number" placeholder="e.g: 12" />

                        </div>

                        <div class="col-6 mb-3">

                            <label class="form-label">Stock Qty.:</label>

                            <input class="form-control" name="variants[new_${variantCounter}][stock]" type="number" placeholder="e.g: 100" />

                        </div>

                        <div class="col-6 mb-3 d-flex gap-4 align-items-end">

                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="variants[new_${variantCounter}][in_stock]" value="1" checked />

                                <label class="form-check-label">In stock</label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="variants[new_${variantCounter}][in_stock]" value="0" />

                                <label class="form-check-label">Out of stock</label>

                            </div>

                        </div>



                        <!-- Image Upload -->

                        <div class="col-12 mb-3">

                            <label class="form-label">Images:</label>

                            <input type="file" class="form-control variant-images" name="variants[new_${variantCounter}][images][]" multiple accept="image/*" />

                            <div class="variant-preview mt-2 d-flex flex-wrap gap-2"></div>

                        </div>



                        <!-- User Pricing -->

                        <div class="card mb-3">

                            <div class="card-header bg-body-tertiary"><h6 class="mb-0">Pricing (for Users)</h6></div>

                            <div class="card-body">

                                <div class="row gx-2">

                                    <div class="col-12 mb-3">

                                        <label>Regular Price:</label>

                                        <input class="form-control regular_price" name="variants[new_${variantCounter}][regular_price]" type="number" step="0.01" />

                                    </div>

                                    <div class="col-8 mb-3">

                                        <label>Discount:</label>

                                        <input class="form-control discount" name="variants[new_${variantCounter}][discount]" type="number" />

                                    </div>

                                    <div class="col-4">

                                        <label>Type:</label>

                                        <select class="form-select discount_type" name="variants[new_${variantCounter}][discount_type]">

                                            <option value="">Select</option>

                                            <option value="percent">Percent</option>

                                            <option value="flat">Flat</option>

                                        </select>

                                    </div>

                                    <div class="col-12">

                                        <label>Final Price:</label>

                                        <input class="form-control final_price" name="variants[new_${variantCounter}][final_price]" type="text" readonly />

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

                                        <input class="form-control bulk_regular_price" name="variants[new_${variantCounter}][bulk_regular_price]" type="number" step="0.01" />

                                    </div>

                                    <div class="col-4">

                                        <label>MOQ:</label>

                                        <input class="form-control" name="variants[new_${variantCounter}][bulk_moq]" type="number" />

                                    </div>

                                    <div class="col-8 mb-3">

                                        <label>Discount:</label>

                                        <input class="form-control bulk_discount" name="variants[new_${variantCounter}][bulk_discount]" type="number" />

                                    </div>

                                    <div class="col-4">

                                        <label>Type:</label>

                                        <select class="form-select bulk_discount_type" name="variants[new_${variantCounter}][bulk_discount_type]">

                                            <option value="">Select</option>

                                            <option value="percent">Percent</option>

                                            <option value="flat">Flat</option>

                                        </select>

                                    </div>

                                    <div class="col-12">

                                        <label>Final Price:</label>

                                        <input class="form-control bulk_final_price" name="variants[new_${variantCounter}][bulk_final_price]" type="text" readonly />

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div> <!-- row -->

                </div> <!-- accordion-body -->

            </div> <!-- collapse -->

        </div> <!-- accordion-item -->

        `;



                variantCounter++;

            });



            if ($('#variant-list .accordion').length) {

                $('#variant-list .accordion').append(html);

            } else {

                $('#variant-list').append(html + '</div>');

            }

        });



        // ✅ Auto Calculate User and Bulk Final Prices (Scoped and Safe)

        $(document).on('input change',

            '.regular_price, .discount, .discount_type, .bulk_regular_price, .bulk_discount, .bulk_discount_type',

            function() {

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



                finalPrice = Math.max(0, finalPrice); // prevent negatives

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



                bulkFinal = Math.max(0, bulkFinal); // prevent negatives

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

    </script>

@endsection

