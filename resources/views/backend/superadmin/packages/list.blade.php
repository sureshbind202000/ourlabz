@extends('backend.includes.layout')
@section('css')
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

    <style>
        .package-suggestions {
            position: absolute;
            z-index: 1000;
            width: 100%;
            max-height: 250px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
            /* Initially hidden */
        }

        .package-item {
            display: block;
            padding: 10px 15px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease-in-out;
        }

        .package-item:last-child {
            border-bottom: none;
        }

        .package-item:hover {
            background: #f8f9fa;
            color: #007bff;
        }

        .choices[data-type*=select-one] .choices__inner {
            padding-bottom: 0px !important;
        }
    </style>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Packages</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["packageid","name","date","type"],"page":10,"pagination":true}'>
                    <div class="row justify-content-end justify-content-end gx-3 gy-0 ">
                        <div class="col-auto col-sm-5 mb-3 me-auto">
                            <form>
                                <div class="input-group"><input class="form-control form-control-sm shadow-none search"
                                        type="search" placeholder="Search..." aria-label="search" />
                                    <div class="input-group-text bg-transparent"><span
                                            class="fa fa-search fs-10 text-600"></span></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-select form-select-sm js-choice search-category" size="1"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="" class="text-dark">Category...</option>
                                @foreach ($PackageCategory as $cat)
                                    <option value="{{ $cat->category_name }}">{{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-sm-auto">
                            <select class="form-select form-select-sm search-type" placeholder="Package Type...">
                                <option value="">Type...</option>
                                <option value="">All</option>
                                <option value="test">Test</option>
                                <option value="package">Package</option>
                            </select>
                        </div> --}}
                        <div class="col-sm-auto">
                            <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtnExcel"><i
                                    class="fa-solid fa-plus"></i> Upload Excel</button>
                        </div>
                        <div class="col-sm-auto">
                            <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i
                                    class="fa-solid fa-plus"></i> Add</button>
                        </div>
                    </div>

                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-900">S.No.</th>
                                    <th class="text-900" data-sort="packageid">Package ID</th>
                                    <th class="text-900" data-sort="category">Category</th>
                                    <th class="text-900" data-sort="name">Name</th>
                                    <th class="text-900" data-sort="price">Price</th>
                                    <th class="text-900" data-sort="type">Type</th>
                                    <th class="text-900" data-sort="date">Date</th>
                                    <th class="text-900">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td>1</td>
                                    <td class="packageid">example</td>
                                    <td class="category">example</td>
                                    <td class="name">example</td>
                                    <td class="price">example</td>
                                    <td class="type">example</td>
                                    <td class="date">example</td>
                                    <td>
                                        <div><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View"><span
                                                    class="text-500 fas fa-eye"></span></button>
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
        <div class="modal-dialog mt-6 modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Package</h4>
                        <p class="fs-10 mb-0 text-white">Please create your package.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard">
                        <form class="row" id="storePackage" enctype="multipart/form-data">
                            @csrf
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"
                                            data-bs-toggle="tab" data-wizard-step="2"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3"
                                            data-bs-toggle="tab" data-wizard-step="3"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-3"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                            data-bs-toggle="tab" data-wizard-step="4"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                            data-bs-toggle="tab" data-wizard-step="5"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab6"
                                            data-bs-toggle="tab" data-wizard-step="6"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab7"
                                            data-bs-toggle="tab" data-wizard-step="7"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-7"></i></span></span></a></li>
                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1"
                                        data-wizard-form="1">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="category">Category</label>
                                                <select class="form-select js-choice" id="category" name="category"
                                                    size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($PackageCategory as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="package_icon">Icon</label>
                                                <input type="file" class="form-control" name="package_icon"
                                                    id="package_icon">
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="name">Name</label>
                                                <input class="form-control" id="name" name="name" type="text"
                                                    placeholder="Enter test name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="type">Type</label>
                                                <select name="type" id="type" class="form-select">
                                                    <option value="Package">Package</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="about_test">About Test</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" name="about_test" id="about_test"
                                                    placeholder="Describe the test"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                        data-wizard-form="2">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">Requisites</label>
                                                <div id="requisites-container">
                                                    

                                                    <div class="input-group mb-3">
                                                        <select name="icon[]" id="icon-select" class="form-select">
                                                            <option value="">- Icon -</option>
                                                            <option value="✔">✔ Default Check</option>
                                                            <option value="⚕">⚕ Medical Symbol</option>
                                                            <option value="🍽">🍽 Fasting</option>
                                                            <option value="🩸">🩸 Blood</option>
                                                            <option value="🔬">🔬 Microscope</option>
                                                            <option value="🧪">🧪 Test Tube</option>
                                                            <option value="🧫">🧫 Petri Dish</option>
                                                            <option value="🧬">🧬 DNA</option>
                                                            <option value="🔎">🔎 Magnifying Glass (Diagnostics)
                                                            </option>
                                                            <option value="📋">📋 Medical Report</option>
                                                            <option value="📡">📡 Lab Communication</option>
                                                            <option value="🧠">🧠 Brain (Neurology, Psychology)
                                                            </option>
                                                            <option value="❤️">❤️ Heart (Cardiology)</option>
                                                            <option value="💙">💙 Mental Health Awareness</option>
                                                        </select>
                                                        <input class="form-control w-75" type="text"
                                                            name="requisite_name[]" placeholder="Requisite name" />
                                                        <button type="button" class="btn btn-success add-requisite">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                        data-wizard-form="3">
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="list_of_parameters_note">List of Parameters
                                                    (Optional Note)</label>
                                                <textarea class="form-control" id="list_of_parameters_note" name="list_of_parameters_note"
                                                    placeholder="Enter list of parameters note"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <div id="list_of_parameters-container">
                                                    <div class="parameter-section">

                                                        <label class="form-label">Parameter</label>
                                                        <div class="input-group mb-3">
                                                            <input class="form-control w-75 search-parameter"
                                                                type="text" name="parameter_name[]"
                                                                placeholder="Parameter name" />
                                                            <button type="button" class="btn btn-success add-parameter">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <div class="list-group position-absolute w-75 package-suggestions">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Parameter Content</label>
                                                            <textarea class="tinymce parameter-list" name="parameter_content[]" placeholder="Enter list of parameters"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">No. of parameters (Optional)</label>
                                                            <input class="form-control no_of_parameter"
                                                                id="no_of_parameter" name="no_of_parameter[]"
                                                                type="number" placeholder="Enter no. of parameters" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4"
                                        data-wizard-form="4">
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="test_preparation">Test Preparation</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" id="test_preparation" name="test_preparation"
                                                    placeholder="Enter test preparation details"></textarea>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="why_this_test">Why This Test</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" id="why_this_test" name="why_this_test"
                                                    placeholder="Explain why this test is needed"></textarea>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="interpretations">Interpretations</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" id="interpretations" name="interpretations"
                                                    placeholder="Provide test interpretations"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                        data-wizard-form="5">
                                        <div class="row">

                                            <div class="mb-3 col-6">
                                                <label class="form-label"
                                                    for="department_category">Department/Category</label>
                                                <textarea class="form-control" id="department_category" name="department_category"
                                                    placeholder="Enter department or category"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="measures">Measures</label>
                                                <textarea class="form-control" id="measures" name="measures" placeholder="Enter measures"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="identifies">Identifies</label>
                                                <textarea class="form-control" id="identifies" name="identifies" placeholder="What does this test identify?"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="sample_type_specimen">Sample
                                                    Type/Specimen</label>
                                                <textarea class="form-control" id="sample_type_specimen" name="sample_type_specimen"
                                                    placeholder="Enter sample type or specimen"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="method">Method</label>
                                                <textarea class="form-control" id="method" name="method" placeholder="Enter testing method"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="tat">TAT (Turnaround Time in
                                                    hours)</label>
                                                <input class="form-control" id="tat" name="tat" type="number"
                                                    placeholder="Enter hours" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="recommendation_of_age">Recommended
                                                    Age</label>
                                                <input class="form-control" id="recommendation_of_age"
                                                    name="recommendation_of_age" type="text"
                                                    placeholder="Enter years (5-65)" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="stability_room">Stability Room (in
                                                    hours)</label>
                                                <input class="form-control" id="stability_room" name="stability_room"
                                                    type="number" placeholder="Enter stability in room temperature" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="stability_refrigerated">Stability
                                                    Refrigerated
                                                    (in hours)</label>
                                                <input class="form-control" id="stability_refrigerated"
                                                    name="stability_refrigerated" type="number"
                                                    placeholder="Enter refrigerated stability" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="stability_frozen">Stability Frozen (in
                                                    hours)</label>
                                                <input class="form-control" id="stability_frozen" name="stability_frozen"
                                                    type="number" placeholder="Enter frozen stability" />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="reports_within">Reports Within (in
                                                    hours)</label>
                                                <input class="form-control" id="reports_within" name="reports_within"
                                                    type="number" placeholder="Enter reports within" required />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="is_prescription">Is Prescription Required
                                                    ?</label>
                                                <select name="is_prescription" id="is_prescription" class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6"
                                        data-wizard-form="6">
                                        <div class="row">
                                            <h5>Normal Pricing</h5>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="regular_price">Regular Price</label>
                                                <input class="form-control" id="regular_price" name="regular_price"
                                                    type="number" step="0.01" placeholder="Enter Regular Price"
                                                    required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="discount_type">Discount Type</label>
                                                <select name="discount_type" id="discount_type" class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="discount_price">Discount</label>
                                                <input class="form-control" id="discount_price" name="discount_price"
                                                    type="number" step="0.01" placeholder="Enter Discount"
                                                    readonly />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="price">Selling Price</label>
                                                <input class="form-control" id="price" name="price" type="number"
                                                    step="0.01" placeholder="Enter price" required readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>Corporate Pricing</h5>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="corporate_regular_price">Regular
                                                    Price</label>
                                                <input class="form-control" id="corporate_regular_price"
                                                    name="corporate_regular_price" type="number" step="0.01"
                                                    placeholder="Enter Regular Price" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="corporate_discount_type">Discount
                                                    Type</label>
                                                <select name="corporate_discount_type" id="corporate_discount_type"
                                                    class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="corporate_discount">Discount</label>
                                                <input class="form-control" id="corporate_discount"
                                                    name="corporate_discount" type="number" step="0.01"
                                                    placeholder="Enter Discount" readonly />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="corporate_price">Selling Price</label>
                                                <input class="form-control" id="corporate_price" name="corporate_price"
                                                    type="number" step="0.01" placeholder="Enter Corporate Price"
                                                    required readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>Free Consultation</h5>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="free-consultation">Is Free
                                                    Consultation Available?</label>
                                                <select name="free_consultation" class="form-select"
                                                    id="free-consultation">
                                                    <option value="">--select--</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6 consultant-category-wrapper" style="display:none;">
                                                <label class="form-label" for="consultant_category">Consultant
                                                    Category</label>
                                                <select name="consultant_category[]" id="consultant_category"
                                                    class="form-select js-choice" multiple="multiple" size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($consultant_categories as $s)
                                                        <option value="{{ $s->speciality }}">{{ $s->speciality }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"
                                        data-wizard-form="7">
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="faq-container">
                                                    <label class="form-label">FAQ</label>
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" type="text" name="question[]"
                                                            placeholder="Enter Question" />
                                                        <button type="button" class="btn btn-success add-faq">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <textarea class="form-control" name="answer[]" placeholder="Enter Answer"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 text-center">
                                                <button class="btn btn-primary bg-gradient px-5 "
                                                    type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer" style="display: block !important;">
                                <div class="px-sm-3 px-md-5">
                                    <ul class="pager wizard list-inline mb-0">
                                        <li class="previous"><button class="btn btn-falcon-primary px-5 px-sm-6"
                                                type="button" style="display: block !important;"><span
                                                    class="fas fa-chevron-left me-2"
                                                    data-fa-transform="shrink-3"></span>Prev</button></li>
                                        <li class="next"><button class="btn btn-falcon-primary px-5 px-sm-6"
                                                type="button">Next<span class="fas fa-chevron-right ms-2"
                                                    data-fa-transform="shrink-3"> </span></button></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Package Modal End -->
    <!-- Edit Package Modal Start -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog mt-6 modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Package</h4>
                        <p class="fs-10 mb-0 text-white">Update your package details.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard">
                        <form class="row" id="updatePackage" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="edit_id" name="id">
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab8" data-bs-toggle="tab" data-wizard-step="1"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab9"
                                            data-bs-toggle="tab" data-wizard-step="2"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab10"
                                            data-bs-toggle="tab" data-wizard-step="3"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-3"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab11"
                                            data-bs-toggle="tab" data-wizard-step="4"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab12"
                                            data-bs-toggle="tab" data-wizard-step="5"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab13"
                                            data-bs-toggle="tab" data-wizard-step="6"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab14"
                                            data-bs-toggle="tab" data-wizard-step="7"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-7"></i></span></span></a></li>
                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab8" id="bootstrap-wizard-tab8"
                                        data-wizard-form="1">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_category">Category</label>
                                                <select class="form-select" id="edit_category" name="category"
                                                    size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($PackageCategory as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_package_icon">Icon</label>
                                                <input type="file" class="form-control" name="edit_package_icon"
                                                    id="edit_package_icon">
                                                <div>
                                                    <img src="" alt="Icon" id="previewIcon">
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_name">Name</label>
                                                <input class="form-control" id="edit_name" name="edit_name"
                                                    type="text" placeholder="Enter test name" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_type">Type</label>
                                                <select name="edit_type" id="edit_type" class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="Package">Package</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_about_test">About Test</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" name="edit_about_test" id="edit_about_test"
                                                    placeholder="Describe the test"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab9" id="bootstrap-wizard-tab9"
                                        data-wizard-form="2">
                                        <div class="row">
                                            <div class="col-12 text-end mb-3">
                                                <button type="button"
                                                    class="btn btn-sm btn-primary bg-gradient add-requisite">
                                                    <i class="fa-solid fa-plus"></i> Add Requisite
                                                </button>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Requisites</label>
                                                <div id="edit-requisites-container">
                                                    <div class="input-group mb-3">
                                                        <select name="edit_icon[]" id="edit-icon-select"
                                                            class="form-select text-center">
                                                            <option value="">- Icon -</option>
                                                            <option value="✔">✔ Default Check</option>
                                                            <option value="⚕">⚕ Medical Symbol</option>
                                                            <option value="🍽">🍽 Fasting</option>
                                                            <option value="🩸">🩸 Blood</option>
                                                            <option value="🔬">🔬 Microscope</option>
                                                            <option value="🧪">🧪 Test Tube</option>
                                                            <option value="🧬">🧬 DNA</option>
                                                            <option value="🔎">🔎 Magnifying Glass (Diagnostics)
                                                            </option>
                                                            <option value="📋">📋 Medical Report</option>
                                                            <option value="📡">📡 Lab Communication</option>
                                                            <option value="🧠">🧠 Brain (Neurology, Psychology)
                                                            </option>
                                                            <option value="❤️">❤️ Heart (Cardiology)</option>
                                                            <option value="💙">💙 Mental Health Awareness</option>
                                                        </select>
                                                        <input class="form-control w-75" type="text"
                                                            name="edit_requisite_name[]" placeholder="Requisite name" />
                                                        <button type="button" class="btn btn-success add-requisite">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab10" id="bootstrap-wizard-tab10"
                                        data-wizard-form="3">
                                        <div class="row">
                                            <div class="col-12 text-end mb-3">
                                                <button type="button"
                                                    class="btn btn-sm btn-primary bg-gradient add-parameter">
                                                    <i class="fa-solid fa-plus"></i> Add Parameter
                                                </button>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_list_of_parameters_note">List of
                                                    Parameters
                                                    (Optional Note)</label>

                                                <textarea class="form-control" id="edit_list_of_parameters_note" name="edit_list_of_parameters_note"
                                                    placeholder="Enter list of parameters note"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <div id="edit-list_of_parameters-container">
                                                    <label class="form-label">Parameter</label>
                                                    <div class="input-group mb-3">
                                                        <input class="form-control w-75" type="text"
                                                            name="edit_parameter_name[]" placeholder="Parameter name" />
                                                        <button type="button" class="btn btn-success add-parameter">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Parameter Content</label>
                                                        <textarea class="tinymce" name="edit_parameter_content[]" placeholder="Enter list of parameters"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">No. of parameters (Optional)</label>
                                                        <input class="form-control" id="edit_no_of_parameter"
                                                            name="edit_no_of_parameter[]" type="number"
                                                            placeholder="Enter no. of parameters" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab11" id="bootstrap-wizard-tab11"
                                        data-wizard-form="4">
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_test_preparation">Test
                                                    Preparation</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_test_preparation" name="edit_test_preparation"
                                                    placeholder="Enter test preparation details"></textarea>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_why_this_test">Why This Test</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_why_this_test" name="edit_why_this_test"
                                                    placeholder="Explain why this test is needed"></textarea>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label"
                                                    for="edit_interpretations">Interpretations</label>
                                                <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_interpretations" name="edit_interpretations"
                                                    placeholder="Provide test interpretations"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab12" id="bootstrap-wizard-tab12"
                                        data-wizard-form="5">
                                        <div class="row">

                                            <div class="mb-3 col-6">
                                                <label class="form-label"
                                                    for="edit_department_category">Department/Category</label>
                                                <textarea class="form-control" id="edit_department_category" name="edit_department_category"
                                                    placeholder="Enter department or category"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_measures">Measures</label>
                                                <textarea class="form-control" id="edit_measures" name="edit_measures" placeholder="Enter measures"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_identifies">Identifies</label>
                                                <textarea class="form-control" id="edit_identifies" name="edit_identifies"
                                                    placeholder="What does this test identify?"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_sample_type_specimen">Sample
                                                    Type/Specimen</label>
                                                <textarea class="form-control" id="edit_sample_type_specimen" name="edit_sample_type_specimen"
                                                    placeholder="Enter sample type or specimen"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_method">Method</label>
                                                <textarea class="form-control" id="edit_method" name="edit_method" placeholder="Enter testing method"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_tat">TAT (Turnaround Time in
                                                    hours)</label>
                                                <input class="form-control" id="edit_tat" name="edit_tat"
                                                    type="number" placeholder="Enter hours" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_recommendation_of_age">Recommended
                                                    Age</label>
                                                <input class="form-control" id="edit_recommendation_of_age"
                                                    name="edit_recommendation_of_age" type="text"
                                                    placeholder="Enter years (5-65)" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_stability_room">Stability Room (in
                                                    hours)</label>
                                                <input class="form-control" id="edit_stability_room"
                                                    name="edit_stability_room" type="number"
                                                    placeholder="Enter stability in room temperature" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_stability_refrigerated">Stability
                                                    Refrigerated
                                                    (in hours)</label>
                                                <input class="form-control" id="edit_stability_refrigerated"
                                                    name="edit_stability_refrigerated" type="number"
                                                    placeholder="Enter refrigerated stability" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_stability_frozen">Stability Frozen (in
                                                    hours)</label>
                                                <input class="form-control" id="edit_stability_frozen"
                                                    name="edit_stability_frozen" type="number"
                                                    placeholder="Enter frozen stability" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_reports_within">Reports Within (in
                                                    hours)</label>
                                                <input class="form-control" id="edit_reports_within"
                                                    name="edit_reports_within" type="number"
                                                    placeholder="Enter reports within" required />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_is_prescription">Is Prescription
                                                    Required ?</label>
                                                <select name="edit_is_prescription" id="edit_is_prescription"
                                                    class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab13" id="bootstrap-wizard-tab13"
                                        data-wizard-form="6">
                                        <div class="row">
                                            <h5>Normal Pricing</h5>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_regular_price">Regular Price</label>
                                                <input class="form-control" id="edit_regular_price"
                                                    name="edit_regular_price" type="number" step="0.01"
                                                    placeholder="Enter Regular Price" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_discount_type">Discount Type</label>
                                                <select name="edit_discount_type" id="edit_discount_type"
                                                    class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_discount_price">Discount</label>
                                                <input class="form-control" id="edit_discount_price"
                                                    name="edit_discount_price" type="number" step="0.01"
                                                    placeholder="Enter Discount" readonly />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_price">Selling Price</label>
                                                <input class="form-control" id="edit_price" name="edit_price"
                                                    type="number" step="0.01" placeholder="Enter price" required
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>Corporate Pricing</h5>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_corporate_regular_price">Regular
                                                    Price</label>
                                                <input class="form-control" id="edit_corporate_regular_price"
                                                    name="edit_corporate_regular_price" type="number" step="0.01"
                                                    placeholder="Enter Regular Price" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_corporate_discount_type">Discount
                                                    Type</label>
                                                <select name="edit_corporate_discount_type"
                                                    id="edit_corporate_discount_type" class="form-select">
                                                    <option value="">-- Select --</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_corporate_discount">Discount</label>
                                                <input class="form-control" id="edit_corporate_discount"
                                                    name="edit_corporate_discount" type="number" step="0.01"
                                                    placeholder="Enter Discount" readonly />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_corporate_price">Selling Price</label>
                                                <input class="form-control" id="edit_corporate_price"
                                                    name="edit_corporate_price" type="number" step="0.01"
                                                    placeholder="Enter Corporate Price" required readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>Free Consultation</h5>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit-free-consultation">Is Free
                                                    Consultation Available?</label>
                                                <select name="free_consultation" class="form-select"
                                                    id="edit-free-consultation">
                                                    <option value="">--select--</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6 edit-consultant-category-wrapper"
                                                style="display:none;">
                                                <label class="form-label" for="edit_consultant_category">Consultant
                                                    Category</label>
                                                <select name="consultant_category[]" id="edit_consultant_category"
                                                    class="form-select" multiple="multiple" size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($consultant_categories as $s)
                                                        <option value="{{ $s->speciality }}">{{ $s->speciality }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab14" id="bootstrap-wizard-tab14"
                                        data-wizard-form="7">
                                        <div class="row">
                                            <div class="col-12 text-end mb-3">
                                                <button type="button"
                                                    class="btn btn-sm btn-primary bg-gradient add-faq">
                                                    <i class="fa-solid fa-plus"></i> Add FAQ
                                                </button>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">FAQ</label>
                                                <div id="edit-faq-container">
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" type="text"
                                                            name="edit_question[]" placeholder="Enter Question" />
                                                        <button type="button" class="btn btn-success add-faq">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <textarea class="form-control" name="edit_answer[]" placeholder="Enter Answer"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 text-center">
                                                <button class="btn btn-primary bg-gradient px-5 "
                                                    type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer" style="display: block !important;">
                                <div class="px-sm-3 px-md-5">
                                    <ul class="pager wizard list-inline mb-0">
                                        <li class="previous"><button class="btn btn-falcon-primary px-5 px-sm-6"
                                                type="button" style="display: block !important;"><span
                                                    class="fas fa-chevron-left me-2"
                                                    data-fa-transform="shrink-3"></span>Prev</button></li>
                                        <li class="next"><button class="btn btn-falcon-primary px-5 px-sm-6"
                                                type="button">Next<span class="fas fa-chevron-right ms-2"
                                                    data-fa-transform="shrink-3"> </span></button></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Package Modal End -->
@endsection
@section('js')

<!-- Include Select2 CSS & JS -->

    <script>
        $(document).ready(function() {

            function toggleConsultantCategory(selectEl, wrapperEl) {
                if ($(selectEl).val() === 'Yes') {
                    $(wrapperEl).show();
                } else {
                    $(wrapperEl).hide();
                    $(wrapperEl).find('select').val(null).trigger('change'); // reset select
                }
            }

            // Add Form
            toggleConsultantCategory('#free-consultation', '.consultant-category-wrapper');
            $('#free-consultation').on('change', function() {
                toggleConsultantCategory(this, '.consultant-category-wrapper');
            });

            // Edit Form
            toggleConsultantCategory('#edit-free-consultation', '.edit-consultant-category-wrapper');
            $('#edit-free-consultation').on('change', function() {
                toggleConsultantCategory(this, '.edit-consultant-category-wrapper');
            });

            // $('.add-requisite').click(function() {
            //     var $newRow = $('<div class="input-group mb-3">' +
            //         '<select name="icon[]" class="form-select"></select>' +
            //         '<input class="form-control w-75" type="text" name="requisite_name[]" placeholder="Requisite name">' +
            //         '<button type="button" class="btn btn-success add-requisite"><i class="fa-solid fa-plus"></i></button>' +
            //         '</div>');
            //     $newRow.insertAfter($(this).closest('.input-group'));

            //     // fetch options and initialize select2 for new select
            //     var $newSelect = $newRow.find('select');
            //     fetchRequisitesForSelect($newSelect); // modified function to accept select element
            // });


            // Remove requisite row
            $(document).on("click", ".remove-requisite", function() {
                $(this).closest(".requisite-row").remove();
            });

            // Function to initialize TinyMCE
            function initializeTinyMCE() {
                setTimeout(() => {
                    tinymce.remove('.tinymce'); // Remove existing instances
                    tinymce.init({
                        selector: '.tinymce',
                        height: '30vh',
                        menubar: false,
                        license_key: 'gpl',
                        skin: utils.settings.tinymce.theme,
                        content_style: `
                    .mce-content-body {
                        color: ${utils.getColors().emphasis};
                        background-color: ${utils.getColor('tinymce-bg')};
                    }
                `,
                        mobile: {
                            theme: 'mobile',
                            toolbar: ['undo', 'bold']
                        },
                        statusbar: false,
                        plugins: 'link image lists table media',
                        toolbar: 'styles | bold italic link bullist numlist image blockquote table media undo redo',
                        directionality: utils.getItemFromStore('isRTL') ? 'rtl' : 'ltr'
                    });
                }, 100); // Delay to ensure new elements are recognized
            }

            // Initialize TinyMCE on page load
            initializeTinyMCE();

            // Add parameter row
            $(document).on("click", ".add-parameter", function() {
                let newRow = `
        <div class="parameter-row parameter-section">
            <label class="form-label">Parameter</label>
            <div class="input-group mb-3">
                <input class="form-control w-75 search-parameter" type="text" name="parameter_name[]"
                    placeholder="Parameter name" />
                <button type="button" class="btn btn-danger remove-parameter">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </div>
             <div class="list-group position-absolute w-75 package-suggestions">
                                                    </div>
            <div class="mb-3">
                <label class="form-label">Parameter Content</label>
                <textarea class="tinymce parameter-list" name="parameter_content[]" placeholder="Enter list of parameters"></textarea>
            </div>
            <div class="mb-3">
                                                    <label class="form-label">No. of parameters (Optional)</label>
                                                    <input class="form-control no_of_parameter" id="no_of_parameter" name="no_of_parameter[]" type="number"placeholder="Enter no. of parameters" required />
                                                </div>
        </div>`;

                $("#list_of_parameters-container").append(newRow);
                initializeTinyMCE(); // Reinitialize TinyMCE for the new elements
            });

            // Remove parameter row
            $(document).on("click", ".remove-parameter", function() {
                $(this).closest(".parameter-row").remove();
                initializeTinyMCE(); // Reinitialize TinyMCE after removal
            });

            // Add FAQ row
            $(".add-faq").on("click", function() {
                let newRow = `
                <div class="faq-row">
           <label class="form-label">FAQ</label>
            <div class="input-group mb-3">
                <input class="form-control" type="text" name="question[]"
                    placeholder="Enter Question" />
                <button type="button" class="btn btn-danger remove-faq">
                    <i class="fa-solid fa-minus"></i>
                   </button>
             </div>
             <div class="mb-3">
                 <textarea class="form-control" name="answer[]" placeholder="Enter Answer"></textarea>
             </div>
             </div>`;
                $("#faq-container").append(newRow);
            });

            // Remove faq row
            $(document).on("click", ".remove-faq", function() {
                $(this).closest(".faq-row").remove();
            });

            $(document).on("change", ".search-type, .search-category", function() {
                var type = $(".search-type").val();
                var category = $(".search-category").val();
                var $searchInput = $(".search");

                // Combine both values (you can customize the format)
                var combinedSearch = (type ? type + " " : "") + (category ? category : "");
                $searchInput.val(combinedSearch.trim());

                // Simulate a real keyup event
                var event = new KeyboardEvent("keyup", {
                    bubbles: true,
                    cancelable: true
                });

                $searchInput[0].dispatchEvent(event);
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
            fetchPackages();

            function fetchPackages() {
                $('.loading').show();
                $.ajax({
                    url: "{{ route('packages.list') }}",
                    type: "GET",
                    success: function(data) {
                        $('.loading').hide();

                        let rows = "";
                        $.each(data, function(index, package) {
                            let badgeClass = "";

                            // Assign different badge colors based on package type
                            switch (package.type) {
                                case "Test":
                                    badgeClass = "badge badge-subtle-success"; // Green for Test
                                    break;
                                case "Package":
                                    badgeClass =
                                        "badge badge-subtle-primary"; // Blue for Package
                                    break;
                                case "Corporate":
                                    badgeClass =
                                        "badge badge-subtle-warning"; // Yellow for Corporate
                                    break;
                                default:
                                    badgeClass =
                                        "badge badge-subtle-secondary"; // Grey for unknown types
                            }
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="packageid">${package.package_id}</td>
                        <td class="category">${package.category_details?.category_name ?? 'N/A'}</td>
                        <td class="name">${package.name}</td>
                        <td class="price">₹${package.price}</td>
                        <td ><span class="${badgeClass} w-100 py-2 type fs-11">${package.type}</span></td>
                        <td class="date">${formatDate(package.created_at)}</td>
                        <td>
                            <div>
                            <button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${package.id}"><span
                                                    class="text-secondary fas fa-eye"></span></button>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${package.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${package.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['packageid', 'name', 'date', 'type', 'category'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            // Store
            $(document).ready(function() {
                $("#storePackage").validate({
                    ignore: [], // Prevents ignoring hidden fields in multi-step forms
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        package_icon: {
                            required: true
                        },
                        "category": {
                            required: true
                        },
                        "department_category": {
                            required: true
                        },
                        "about_test": {
                            required: true
                        },
                        "icon[]": {
                            required: true
                        },
                        "requisite_name[]": {
                            required: true
                        },
                        "parameter_name[]": {
                            required: true
                        },
                        "parameter_content[]": {
                            required: true
                        },
                        "test_preparation": {
                            required: true
                        },
                        "why_this_test": {
                            required: true
                        },
                        "measures": {
                            required: true
                        },
                        "identifies": {
                            required: true
                        },
                        "sample_type_specimen": {
                            required: true
                        },
                        "tat": {
                            required: true,
                            number: true,
                            min: 1
                        },
                        "recommendation_of_age": {
                            required: true,
                        },
                        "stability_room": {
                            required: true
                        },
                        "stability_refrigerated": {
                            required: true
                        },
                        "stability_frozen": {
                            required: true
                        },
                        "method": {
                            required: true
                        },
                        "price": {
                            required: true,
                            number: true,
                            min: 0
                        },
                        "type": {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "Name is required",
                            minlength: "Name must be at least 3 characters"
                        },
                        package_icon: {
                            required: "Icon is required"
                        },
                        category: "Choose category...",
                        department_category: "Department/Category is required",
                        about_test: "About Test is required",
                        "icon[]": "Requisite icon is required",
                        "requisite_name[]": "Requisite is required",
                        "parameter_name[]": "Parameter name is required",
                        "parameter_content[]": "Parameter content is required",
                        test_preparation: "Test Preparation is required",
                        why_this_test: "Why this test is required",
                        interpretations: "Interpretations are required",
                        measures: "Measures are required",
                        identifies: "Identifies field is required",
                        sample_type_specimen: "Sample Type/Specimen is required",
                        tat: {
                            required: "TAT is required",
                            number: "Enter a valid number",
                            min: "TAT must be at least 1 hour"
                        },
                        recommendation_of_age: {
                            required: "Recommended Age is required",
                            number: "Enter a valid age",
                            min: "Age cannot be negative"
                        },
                        stability_room: "Stability Room is required",
                        stability_refrigerated: "Stability Refrigerated is required",
                        stability_frozen: "Stability Frozen is required",
                        method: "Method is required",
                        price: {
                            required: "Price is required",
                            number: "Enter a valid price",
                            min: "Price cannot be negative"
                        },
                        corporate_price: {
                            required: "Price is required",
                            number: "Enter a valid price",
                            min: "Price cannot be negative"
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.addClass("text-danger");
                        if (element.is(":radio") || element.is(":checkbox")) {
                            error.appendTo(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        $('.loading').show();
                        $.ajax({
                            url: "{{ route('package.store') }}",
                            type: "POST",
                            data: $(form).serialize(),
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('.loading').hide();
                                Swal.fire("Success!", response.success, "success");
                                $("#addTestModal").modal("hide");
                                form.reset();
                                fetchPackages();
                                $('#addModal').modal('hide');
                                window.location.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                $('.loading').hide();
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
                $('.loading').show();
                let packageId = $(this).data('id');

                $.ajax({
                    url: '/package/' + packageId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        var package = response.package;
                        $('#edit_id').val(package.id);
                        $('#edit_name').val(package.name);
                        $('#edit_category').val(package.category);
                        $('#edit_reports_within').val(package.reports_within);
                        $('#edit_regular_price').val(package.regular_price);
                        $('#edit_discount_type').val(package.discount_type);
                        $('#edit_discount_price').val(package.discount_price);
                        $('#edit_price').val(package.price);
                        $('#edit_corporate_regular_price').val(package.corporate_regular_price);
                        $('#edit_corporate_discount_type').val(package.corporate_discount_type);
                        $('#edit_corporate_discount').val(package.corporate_discount);
                        $('#edit_corporate_price').val(package.corporate_price);
                        $('#edit_list_of_parameters_note').val(package.list_of_parameters_note);
                        $('#edit_department_category').val(package.department_category);
                        $('#edit_measures').val(package.measures);
                        $('#edit_identifies').val(package.identifies);
                        $('#edit_sample_type_specimen').val(package.sample_type_specimen);
                        $('#edit_method').val(package.method);
                        $('#edit_tat').val(package.tat);
                        $('#edit_recommendation_of_age').val(package.recommendation_of_age);
                        $('#edit_stability_room').val(package.stability_room);
                        $('#edit_stability_refrigerated').val(package.stability_refrigerated);
                        $('#edit_stability_frozen').val(package.stability_frozen);
                        $('#edit_interpretations').val(package.interpretations);
                        $('#edit_type').val(package.type);
                        $('#edit_is_prescription').val(package.is_prescription);
                        $('#previewIcon').attr('src', '/' + package.package_icon);
                        $('#edit-free-consultation').val(package.free_consultation);
                        toggleConsultantCategory('#edit-free-consultation',
                            '.edit-consultant-category-wrapper');
                        initSingleChoice('#edit_category', 'editCategory', package
                            .category_details?.id ?? '');
                        initOrResetChoices('#edit_consultant_category',
                            'editConsultantCategory',
                            package.consultant_category ?? '');

                        // ✅ Set TinyMCE Content for Static Editors
                        if (tinymce.get('edit_about_test') && package.about_test) {
                            tinymce.get('edit_about_test').setContent(package.about_test);
                        }

                        if (tinymce.get('edit_test_preparation') && package.test_preparation) {
                            tinymce.get('edit_test_preparation').setContent(package
                                .test_preparation);
                        }

                        if (tinymce.get('edit_why_this_test') && package.why_this_test) {
                            tinymce.get('edit_why_this_test').setContent(package.why_this_test);
                        }

                        if (tinymce.get('edit_interpretations') && package.interpretations) {
                            tinymce.get('edit_interpretations').setContent(package
                                .interpretations);
                        }


                        // ✅ Populate Requisites
                        let requisitesHtml = '';
                        package.requisites.forEach(requisite => {
                            requisitesHtml += getRequisiteRow(requisite.icon, requisite
                                .name);
                        });
                        $('#edit-requisites-container').html(requisitesHtml);

                        // ✅ Destroy Existing TinyMCE Instances
                        tinymce.remove('.tinymce');

                        // ✅ Populate Parameters
                        let parametersHtml = '';
                        package.parameters.forEach((parameter, index) => {
                            parametersHtml += getParameterRow(index, parameter.name,
                                parameter.content, parameter.no_of_parameter);
                        });
                        $('#edit-list_of_parameters-container').html(parametersHtml);

                        // ✅ Populate FAQs
                        let faqsHtml = '';
                        package.faqs.forEach(faq => {
                            faqsHtml += getFaqRow(faq.question, faq.answer);
                        });
                        $('#edit-faq-container').html(faqsHtml);

                        // ✅ Initialize TinyMCE
                        initializeTinyMCE();

                        $('#editModal').modal('show');
                        $('.loading').hide();
                    }
                });
            });

            // ✅ Function to generate a requisite row
            function getRequisiteRow(icon = '', name = '') {
                return `
    <div class="input-group mb-3 requisite-row">
        <select name="edit_icon[]" class="form-select">
             <option value="">-- Icon --</option>
    <option value="✔" ${icon === '✔' ? 'selected' : ''}>✔ Default Check</option>
    <option value="⚕" ${icon === '⚕' ? 'selected' : ''}>⚕ Medical Symbol</option>
    <option value="🍽" ${icon === '🍽' ? 'selected' : ''}>🍽 Fasting</option>
    <option value="🩸" ${icon === '🩸' ? 'selected' : ''}>🩸 Blood Drop</option>
    <option value="🔬" ${icon === '🔬' ? 'selected' : ''}>🔬 Microscope</option>
    <option value="🧪" ${icon === '🧪' ? 'selected' : ''}>🧪 Test Tube</option>
    <option value="🧬" ${icon === '🧬' ? 'selected' : ''}>🧬 DNA</option>
    <option value="🔎" ${icon === '🔎' ? 'selected' : ''}>🔎 Magnifying Glass (Diagnostics)</option>
    <option value="📋" ${icon === '📋' ? 'selected' : ''}>📋 Medical Report</option>
    <option value="📡" ${icon === '📡' ? 'selected' : ''}>📡 Lab Communication</option>
    <option value="🧠" ${icon === '🧠' ? 'selected' : ''}>🧠 Brain (Neurology, Psychology)</option>
    <option value="❤️" ${icon === '❤️' ? 'selected' : ''}>❤️ Heart (Cardiology)</option>
    <option value="💙" ${icon === '💙' ? 'selected' : ''}>💙 Mental Health Awareness</option>
        </select>
        <input class="form-control w-75" type="text" name="edit_requisite_name[]" value="${name}" placeholder="Requisite name" />
        <button type="button" class="btn btn-danger remove-requisite"><i class="fa-solid fa-trash"></i></button>
    </div>`;
            }

            // ✅ Function to generate a parameter row
            function getParameterRow(index, name = '', content = '', no_of_parameter = '') {
                let editorId = `edit_parameter_content_${index}`;
                return `
    <div class="parameter-row">
        <div class="input-group mb-3">
            <input class="form-control w-75" type="text" name="edit_parameter_name[]" value="${name}" placeholder="Parameter name" />
            <button type="button" class="btn btn-danger remove-parameter"><i class="fa-solid fa-trash"></i></button>
        </div>
        <div class="mb-3">
            <label class="form-label">Parameter Content</label>
            <textarea id="${editorId}" class="tinymce" name="edit_parameter_content[]">${content}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">No. of Parameters (Optional)</label>
            <input class="form-control" type="number" name="edit_no_of_parameter[]" value="${no_of_parameter}" placeholder="Enter number" />
        </div>`;
            }

            // ✅ Function to generate an FAQ row
            function getFaqRow(question = '', answer = '') {
                return `
    <div class="faq-row">
        <div class="input-group mb-3">
            <input class="form-control" type="text" name="edit_question[]" value="${question}" placeholder="Enter Question" />
            <button type="button" class="btn btn-danger remove-faq"><i class="fa-solid fa-trash"></i></button>
        </div>
        <div class="mb-3">
            <textarea class="form-control" name="edit_answer[]" placeholder="Enter Answer">${answer}</textarea>
        </div>
    </div>`;
            }


            // ✅ ADD FUNCTIONALITY FOR NEW ELEMENTS

            // Add requisite row
            $(document).on("click", ".add-requisite", function() {
                $("#edit-requisites-container").append(getRequisiteRow());
            });

            // Remove requisite row
            $(document).on("click", ".remove-requisite", function() {
                $(this).closest(".requisite-row").remove();
            });

            // Add parameter row
            $(document).on("click", ".add-parameter", function() {
                let index = $(".parameter-row").length;
                $("#edit-list_of_parameters-container").append(getParameterRow(index));
                initializeTinyMCE(); // Re-initialize TinyMCE for new elements
            });

            // Remove parameter row
            $(document).on("click", ".remove-parameter", function() {
                $(this).closest(".parameter-row").remove();
            });

            // Add FAQ row
            $(document).on("click", ".add-faq", function() {
                $("#edit-faq-container").append(getFaqRow());
            });

            // Remove FAQ row
            $(document).on("click", ".remove-faq", function() {
                $(this).closest(".faq-row").remove();
            });

            // Update Package AJAX
            $('#updatePackage').submit(function(e) {
                e.preventDefault();
                $('.loading').show();

                var packageId = $('#edit_id').val();
                var form = this;
                var formData = new FormData(form); // Correctly capture files + input values
                formData.append('_method', 'PUT'); // Simulate PUT request via POST

                $.ajax({
                    url: '/package/' + packageId,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editModal').modal('hide');
                        Swal.fire("Success!", response.success, "success");
                        fetchPackages();
                        form.reset();
                        $('.loading').hide();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        $('.loading').hide();
                        console.error(xhr);
                        let message = "Something went wrong.";
                        if (xhr.responseJSON?.error) {
                            message = xhr.responseJSON.error;
                        }
                        Swal.fire("Error!", message, "error");
                    }
                });
            });


            // Delete Package
            // ✅ Delete Package with Confirmation
            $(document).on('click', '.delete-btn', function() {
                let packageId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the package and all related data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.loading').show();

                        $.ajax({
                            url: `/package/${packageId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('.loading').hide();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The package and related data have been deleted.",
                                        "success");
                                    fetchPackages(); // 🔄 Refresh the package list
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

            // Search Package
            $(document).on("keyup", ".search-parameter", function() {
                let query = $(this).val();
                let container = $(this).closest(".parameter-section"); // Corrected selector

                // Find the nearest `.package-suggestions` inside that container
                let suggestionsBox = container.find(".package-suggestions");

                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('packages.search') }}",
                        type: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            let suggestions = "";
                            $.each(data, function(id, name) {
                                suggestions +=
                                    `<a href="#" class="list-group-item list-group-item-action package-item" data-name="${name}">${name}</a>`;
                            });
                            suggestionsBox.html(suggestions).show();
                        }
                    });
                } else {
                    suggestionsBox.hide();
                }
            });

            // Click event to select package and fetch parameters
            $(document).on("click", ".package-item", function(e) {
                e.preventDefault();
                let packageName = $(this).data("name");
                let container = $(this).closest(".parameter-section"); // Get the correct section

                // Update only the closest search input
                container.find(".search-parameter").val(packageName);

                // Hide only the closest suggestion box
                container.find(".package-suggestions").hide();

                // Fetch parameters for selected package
                $.ajax({
                    url: "{{ route('packages.parameters') }}",
                    type: "GET",
                    data: {
                        package_name: packageName
                    },
                    success: function(data) {
                        let parameterHtml = "";
                        let totalParameters = 0;
                        data.forEach(param => {
                            parameterHtml += `
                            <div class="parameter-block">
                                <h4>${param.name}</h4>
                                <p>${param.content}</p>
                            </div>
                        `;
                            let paramCount = parseInt(param.no_of_parameter) || 0;
                            totalParameters += paramCount;
                        });

                        // Append parameters inside the closest parameter content section
                        container.find(".parameter-list").each(function() {
                            let editorId = $(this).attr("id"); // Get editor ID
                            if (tinymce.get(
                                    editorId)) { // Check if TinyMCE is initialized
                                tinymce.get(editorId).setContent(parameterHtml);
                            }
                        });

                        container.find(".no_of_parameter").val(totalParameters);
                    }
                });
            });


            // Hide suggestions when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest(".search-parameter, .package-suggestions").length) {
                    $(".package-suggestions").hide();
                }
            });

            function setupPricing(regularId, typeId, discountId, outputId) {
                function calculate() {
                    const regular = parseFloat($(regularId).val()) || 0;
                    const type = $(typeId).val();
                    const discount = parseFloat($(discountId).val()) || 0;

                    let final = regular;
                    if (type === 'flat') final -= discount;
                    else if (type === 'percent') final -= (regular * discount / 100);

                    $(outputId).val(Math.max(0, final).toFixed(2));
                }

                $(typeId).on('change', function() {
                    const selected = $(this).val();
                    $(discountId).prop('readonly', !selected).val('');
                    calculate();
                });

                $(regularId + ', ' + discountId).on('input', calculate);
            }
            setupPricing('#regular_price', '#discount_type', '#discount_price', '#price');
            setupPricing('#edit_regular_price', '#edit_discount_type', '#edit_discount_price', '#edit_price');
            setupPricing('#corporate_regular_price', '#corporate_discount_type', '#corporate_discount',
                '#corporate_price');
            setupPricing('#edit_corporate_regular_price', '#edit_corporate_discount_type',
                '#edit_corporate_discount', '#edit_corporate_price');

        });


// Call this function on page load
function fetchRequisitesForSelect($select = $('#icon-select')) {
    $.ajax({
        url: '/requisites/list',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            // Clear old options
            $select.empty();
            $select.append('<option value="">- Icon -</option>');

            // Append emoji + name
            data.forEach(function(item) {
                $select.append(`
                    <option value="${item.icon}">
                        ${item.icon} ${item.name}
                    </option>
                `);
            });
        },
        error: function(err) {
            console.log("Error loading icons", err);
        }
    });
}


// Function to format options with image
// function formatOption(option) {
//     if (!option.id) return option.text; // placeholder
//     if (!option.element) return option.text; // safety check

//     var imgUrl = $(option.element).data('image');
//     if (!imgUrl) return option.text;

//  console.log(imgUrl);
//     var $option = $(
//         `<span><img src="${imgUrl}" style="width: 20px; height: 20px; margin-right: 8px;" /> ${option.text}</span>`
//     );
//     return $option;
// }


$(document).ready(function() {
    fetchRequisitesForSelect();
});



    </script>
    
@endsection
