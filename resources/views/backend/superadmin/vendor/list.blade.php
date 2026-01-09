@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Vendors</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["userid","name","phone","email","status"],"page":10,"pagination":true}'>
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
                                    <th class="text-900" data-sort="userid">Vendor ID</th>
                                    <th class="text-900" data-sort="name">Name</th>
                                    <th class="text-900" data-sort="phone">Phone</th>
                                    <th class="text-900" data-sort="phone">Email</th>
                                    <th class="text-900" data-sort="date">Date</th>
                                    <th class="text-900" data-sort="status">Status</th>
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
        <div class="modal-dialog mt-6 modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Vendor</h4>
                        <p class="fs-10 mb-0 text-white">Fill the form to create new vendor.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="storeVendor" enctype="multipart/form-data" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span>
                                            <span class="d-none d-md-block mt-1 fs-10">Personal Details</span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"
                                            data-bs-toggle="tab" data-wizard-step="2"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3"
                                            data-bs-toggle="tab" data-wizard-step="3"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-3"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Address Details</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                            data-bs-toggle="tab" data-wizard-step="4"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Legal & Compliance</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                            data-bs-toggle="tab" data-wizard-step="5"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Product Categories &
                                                Capabilities</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab6"
                                            data-bs-toggle="tab" data-wizard-step="6"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Login & Account</span></a>
                                    </li>

                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1"
                                        data-wizard-form="1">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="company_name">Company Name</label>
                                                <input class="form-control" id="company_name" name="company_name"
                                                    type="text" placeholder="Enter company name" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="business_type">Business Type</label>
                                                <select name="business_type" id="business_type" class="form-select"
                                                    required>
                                                    <option value="">--select--</option>
                                                    <option value="Manufacturer">Manufacturer</option>
                                                    <option value="Distributor">Distributor</option>
                                                    <option value="Reseller">Reseller</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="establishment_year">Year of
                                                    Establishment</label>
                                                <input class="form-control" id="establishment_year"
                                                    name="establishment_year" type="date" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="company_reg_no">Company Registration
                                                    Number</label>
                                                <input class="form-control" id="company_reg_no" name="company_reg_no"
                                                    type="text" placeholder="Enter company reg. no." required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="tin">Tax Identification Number
                                                    (GST/VAT/PAN etc.)</label>
                                                <input class="form-control" id="tin" name="tin" type="text"
                                                    placeholder="Enter tax indentification no." required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="profile">Company Logo</label>
                                                <input class="form-control" id="profile" name="profile" type="file"
                                                    required />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                        data-wizard-form="2">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="name">Primary Contact Person
                                                    Name</label>
                                                <input class="form-control" id="name" name="name" type="number"
                                                    placeholder="Enter name" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="blood_group">Blood Group</label>
                                                <select name="blood_group" id="blood_group" class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="phone">Phone</label>
                                                <input class="form-control" id="phone" name="phone" type="number"
                                                    placeholder="Enter phone number" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="alternate_phone">Alternate Phone</label>
                                                <input class="form-control" id="alternate_phone" name="alternate_phone"
                                                    type="number" placeholder="Enter alternate phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="text"
                                                    placeholder="Enter email" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="gender">Gender</label>
                                                <br>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="male" type="radio"
                                                        name="gender" value="Male" />
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="female" type="radio"
                                                        name="gender" value="Female" />
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="other" type="radio"
                                                        name="gender" value="Female" />
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="date_of_birth">Date of Birth</label>
                                                <input class="form-control" id="date_of_birth" name="date_of_birth"
                                                    type="date" required />
                                                <input id="age" name="age" type="hidden" readonly />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                        data-wizard-form="3">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="address">Address</label>
                                                <input class="form-control" id="address" name="address" type="text"
                                                    placeholder="Enter address" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="city">City</label>
                                                <input class="form-control" id="city" name="city" type="text"
                                                    placeholder="Enter city" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="state">State</label>
                                                <input class="form-control" id="state" name="state" type="text"
                                                    placeholder="Enter state" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="country">Country</label>
                                                <input class="form-control" id="country" name="country" type="text"
                                                    placeholder="Enter country" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="pin">Pin/Postal code</label>
                                                <input class="form-control" id="pin" name="pin" type="text"
                                                    placeholder="Enter pin/postal code" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="google_map_location">Google Map Location
                                                    (optional)</label>
                                                <input class="form-control" id="google_map_location"
                                                    name="google_map_location" type="text"
                                                    placeholder="Enter google map location" />
                                            </div>

                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4"
                                        data-wizard-form="4">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="business_license">Business License
                                                    Upload</label>
                                                <input class="form-control" id="business_license" name="business_license"
                                                    type="file" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="msds_document">MSDS (Material Safety Data
                                                    Sheet)</label>
                                                <input class="form-control" id="msds_document" name="msds_document"
                                                    type="file" />
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="iso_certifications">ISO/Quality
                                                    Certifications (e.g., ISO 9001, ISO 13485) (if applicable)</label>
                                                <input class="form-control" id="iso_certifications"
                                                    name="iso_certifications" type="text"
                                                    placeholder="e.g., ISO 9001, ISO 13485" />
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="environmental_certificates">Environmental
                                                    Compliance Certificates (e.g., RoHS, REACH) (if applicable)</label>
                                                <input class="form-control" id="environmental_certificates"
                                                    name="environmental_certificates" type="text"
                                                    placeholder="e.g., RoHS, REACH" />
                                            </div>

                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="import_export_license">Import/Export
                                                    License (if international shipping is involved)</label>
                                                <input class="form-control" id="import_export_license"
                                                    name="import_export_license" type="file" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                        data-wizard-form="5">
                                        <div class="row">

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="primary_categories">Primary Product
                                                    Categories</label>
                                                <input class="form-control" id="primary_categories"
                                                    name="primary_categories" type="text"
                                                    placeholder="e.g.: Analytical Instruments, Lab Glassware, Centrifuges" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="subcategories">Product
                                                    Sub-Categories</label>
                                                <input class="form-control" id="subcategories" name="subcategories"
                                                    type="text" placeholder="sub-categories" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="custom_equipment_manufacturing">Custom
                                                    Equipment Manufacturing?</label>
                                                <select name="custom_equipment_manufacturing"
                                                    id="custom_equipment_manufacturing" class="form-select" required>
                                                    <option value="">--select--</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="oem_odm_capabilities">OEM/ODM
                                                    Capabilities?</label>
                                                <select name="oem_odm_capabilities" id="oem_odm_capabilities"
                                                    class="form-select" required>
                                                    <option value="">--select--</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="moq">MOQ (Minimum Order
                                                    Quantity)</label>
                                                <input type="tel" name="moq" id="moq" class="form-control"
                                                    placeholder="e.g : 1">
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="lead_time_days">Lead Time for
                                                    Manufacturing/Shipping</label>
                                                <input type="tel" name="lead_time_days" id="lead_time_days"
                                                    class="form-control" placeholder="Lead time in days">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6"
                                        data-wizard-form="6">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="username">Username</label>
                                                <input class="form-control" id="username" name="username"
                                                    type="text" placeholder="Enter username" required />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control w-75" type="password" name="password"
                                                        id="password" placeholder="Type or generate password."
                                                        required />
                                                    <button type="button" class="btn btn-success generate-password"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Click to generate random password.">
                                                        <i class="fa-solid fa-key"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="terms_condition" type="checkbox"
                                                        value="" name="terms_condition" required />
                                                    <label class="form-check-label" for="terms_condition">Consent to Terms
                                                        & Conditions</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="subscribe_notification"
                                                        type="checkbox" value="" name="subscribe" />
                                                    <label class="form-check-label" for="subscribe_notification">Subscribe
                                                        to Notifications & Updates? </label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 text-center">
                                                <button class="btn btn-primary bg-gradient px-5 " type="button"
                                                    id="submitUserBtn">Submit</button>
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
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Vendor</h4>
                        <p class="fs-10 mb-0 text-white">Update vendor details.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="updateVendor" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="edit_id" name="id">
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">

                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab7" data-bs-toggle="tab" data-wizard-step="7"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span>
                                            <span class="d-none d-md-block mt-1 fs-10">Personal Details</span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab8"
                                            data-bs-toggle="tab" data-wizard-step="8"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab9"
                                            data-bs-toggle="tab" data-wizard-step="9"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-3"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Address Details</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab10"
                                            data-bs-toggle="tab" data-wizard-step="10"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Legal & Compliance</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab11"
                                            data-bs-toggle="tab" data-wizard-step="11"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Product Categories &
                                                Capabilities</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab12"
                                            data-bs-toggle="tab" data-wizard-step="12"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Login & Account</span></a>
                                    </li>

                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">

                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"
                                        data-wizard-form="7">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_name">Company Name</label>
                                                <input class="form-control" id="edit_company_name" name="company_name"
                                                    type="text" placeholder="Enter company name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_business_type">Business Type</label>
                                                <select name="business_type" id="edit_business_type" class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Manufacturer">Manufacturer</option>
                                                    <option value="Distributor">Distributor</option>
                                                    <option value="Reseller">Reseller</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_establishment_year">Year of
                                                    Establishment</label>
                                                <input class="form-control" id="edit_establishment_year"
                                                    name="establishment_year" type="date" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_reg_no">Company Registration
                                                    Number</label>
                                                <input class="form-control" id="edit_company_reg_no"
                                                    name="company_reg_no" type="text"
                                                    placeholder="Enter company reg. no." />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_tin">Tax Identification Number
                                                    (GST/VAT/PAN etc.)</label>
                                                <input class="form-control" id="edit_tin" name="tin" type="text"
                                                    placeholder="Enter tax indentification no." />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_profile">Company Logo</label>
                                                <input class="form-control" id="edit_profile" name="profile"
                                                    type="file" />
                                                <br>
                                                <img src="" alt="" id="preview_company_logo"
                                                    style="height: 100px;">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab8" id="bootstrap-wizard-tab8"
                                        data-wizard-form="8">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_name">Primary Contact Person
                                                    Name</label>
                                                <input class="form-control" id="edit_name" name="name" type="text"
                                                    placeholder="Enter primary contact name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_blood_group">Blood Group</label>
                                                <select name="blood_group" id="edit_blood_group" class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_phone">Phone</label>
                                                <input class="form-control" id="edit_phone" name="phone"
                                                    type="number" placeholder="Enter phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_alternate_phone">Alternate
                                                    Phone</label>
                                                <input class="form-control" id="edit_alternate_phone"
                                                    name="alternate_phone" type="number"
                                                    placeholder="Enter alternate phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_email">Email</label>
                                                <input class="form-control" id="edit_email" name="email"
                                                    type="text" placeholder="Enter email" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="gender">Gender</label>
                                                <br>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_male" type="radio"
                                                        name="gender" value="Male" />
                                                    <label class="form-check-label" for="edit_male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_female" type="radio"
                                                        name="gender" value="Female" />
                                                    <label class="form-check-label" for="edit_female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_other" type="radio"
                                                        name="gender" value="Female" />
                                                    <label class="form-check-label" for="edit_other">Other</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_date_of_birth">Date of Birth</label>
                                                <input class="form-control" id="edit_date_of_birth" name="date_of_birth"
                                                    type="date" />
                                                <input id="edit_age" name="age" type="hidden" readonly />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab9" id="bootstrap-wizard-tab9"
                                        data-wizard-form="9">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_address">Street Address</label>
                                                <input class="form-control" id="edit_address" name="address"
                                                    type="text" placeholder="Enter address" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_city">City</label>
                                                <input class="form-control" id="edit_city" name="city" type="text"
                                                    placeholder="Enter city" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_state">State</label>
                                                <input class="form-control" id="edit_state" name="state"
                                                    type="text" placeholder="Enter state" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_country">Country</label>
                                                <input class="form-control" id="edit_country" name="country"
                                                    type="text" placeholder="Enter country" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_pin">Pin/Postal code</label>
                                                <input class="form-control" id="edit_pin" name="pin" type="text"
                                                    placeholder="Enter pin/postal code" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_google_map_location">Google Map
                                                    Location
                                                    (optional)</label>
                                                <input class="form-control" id="edit_google_map_location"
                                                    name="google_map_location" type="text"
                                                    placeholder="Enter google map location" />
                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab10" id="bootstrap-wizard-tab10"
                                        data-wizard-form="10">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_business_license">Business License
                                                    Upload</label>
                                                <input class="form-control" id="edit_business_license"
                                                    name="business_license" type="file" />
                                                <br>
                                                <img src="" alt="" id="preview_business_license"
                                                    style="height: 100px;">
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_msds_document">MSDS (Material Safety
                                                    Data Sheet)</label>
                                                <input class="form-control" id="edit_msds_document" name="msds_document"
                                                    type="file" />
                                                <br>
                                                <a href="" id="preview_msds_document" target="_blank">View</a>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_iso_certifications">ISO/Quality
                                                    Certifications (e.g., ISO 9001, ISO 13485) (if applicable)</label>
                                                <input class="form-control" id="edit_iso_certifications"
                                                    name="iso_certifications" type="text"
                                                    placeholder="e.g., ISO 9001, ISO 13485" />
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label"
                                                    for="edit_environmental_certificates">Environmental Compliance
                                                    Certificates (e.g., RoHS, REACH) (if applicable)</label>
                                                <input class="form-control" id="edit_environmental_certificates"
                                                    name="environmental_certificates" type="text"
                                                    placeholder="e.g., RoHS, REACH" />
                                            </div>

                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_import_export_license">Import/Export
                                                    License (if international shipping is involved)</label>
                                                <input class="form-control" id="edit_import_export_license"
                                                    name="import_export_license" type="file" />
                                                <br>
                                                <img src="" alt="" id="preview_import_export_license"
                                                    style="height: 100px;">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab11" id="bootstrap-wizard-tab11"
                                        data-wizard-form="11">

                                        <div class="row">

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_primary_categories">Primary Product
                                                    Categories</label>
                                                <input class="form-control" id="edit_primary_categories"
                                                    name="primary_categories" type="text"
                                                    placeholder="e.g.: Analytical Instruments, Lab Glassware, Centrifuges" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_subcategories">Product
                                                    Sub-Categories</label>
                                                <input class="form-control" id="edit_subcategories" name="subcategories"
                                                    type="text" placeholder="sub-categories" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_custom_equipment_manufacturing">Custom
                                                    Equipment Manufacturing?</label>
                                                <select name="custom_equipment_manufacturing"
                                                    id="edit_custom_equipment_manufacturing" class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_oem_odm_capabilities">OEM/ODM
                                                    Capabilities?</label>
                                                <select name="oem_odm_capabilities" id="edit_oem_odm_capabilities"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_moq">MOQ (Minimum Order
                                                    Quantity)</label>
                                                <input type="tel" name="moq" id="edit_moq" class="form-control"
                                                    placeholder="e.g : 1">
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_lead_time_days">Lead Time for
                                                    Manufacturing/Shipping</label>
                                                <input type="tel" name="lead_time_days" id="edit_lead_time_days"
                                                    class="form-control" placeholder="Lead time in days">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab12" id="bootstrap-wizard-tab12"
                                        data-wizard-form="12">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_username">username</label>
                                                <input class="form-control" id="edit_username" name="username"
                                                    type="text" placeholder="Enter username" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control w-75" type="password" name="password"
                                                        id="edit_password" placeholder="Type or generate password." />
                                                    <button type="button" class="btn btn-success edit-generate-password"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Click to generate random password.">
                                                        <i class="fa-solid fa-key"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="edit_terms_condition"
                                                        type="checkbox" value="" name="terms_condition" />
                                                    <label class="form-check-label" for="edit_terms_condition">Consent
                                                        to Terms & Conditions</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="edit_subscribe" type="checkbox"
                                                        value="" name="subscribe" />
                                                    <label class="form-check-label" for="edit_subscribe">Subscribe to
                                                        Notifications &
                                                        Updates? </label>
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
                                        <li class="next"><button class="btn btn-primary px-5 px-sm-6"
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
    <script>
        $(document).ready(function() {
            // Add Form Calculate age
            $('#date_of_birth').on('change', function() {
                var dob = new Date($(this).val());
                var today = new Date();

                var age = today.getFullYear() - dob.getFullYear();
                var m = today.getMonth() - dob.getMonth();

                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                $('#age').val(age >= 0 ? age : '');
            });

            $('#edit_date_of_birth').on('change', function() {
                var dob = new Date($(this).val());
                var today = new Date();

                var age = today.getFullYear() - dob.getFullYear();
                var m = today.getMonth() - dob.getMonth();

                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                $('#edit_age').val(age >= 0 ? age : '');
            });

            function generatePassword() {
                let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                let password = "";
                for (let i = 0; i < 12; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return password;
            }

            // Event to generate a password when the button is clicked
            $(".generate-password").on("click", function() {
                var newPassword = generatePassword();
                $("#password").val(newPassword);
                $("#password").attr("type", "text").focus();
            });

            // Toggle password visibility when input is focused
            $("#password").on("focus", function() {
                $(this).attr("type", "text");
            });

            // Revert back to password type when focus is lost
            $("#password").on("blur", function() {
                $(this).attr("type", "password");
            });

            $(".edit-generate-password").on("click", function() {
                var newPassword = generatePassword();
                $("#edit_password").val(newPassword);
                $("#edit_password").attr("type", "text").focus();
            });

            // Toggle password visibility when input is focused
            $("#edit_password").on("focus", function() {
                $(this).attr("type", "text");
            });

            // Revert back to password type when focus is lost
            $("#edit_password").on("blur", function() {
                $(this).attr("type", "password");
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
            fetchVendor();

            function fetchVendor() {
                $('.loading').show();
                $.ajax({
                    url: "{{ route('vendor.list') }}",
                    type: "GET",
                    success: function(data) {
                        $('.loading').hide();
                        let rows = "";
                        $.each(data, function(index, user) {
                            let profileImage = (user.profile === 'dummy') ?
                                "{{ asset('backend/assets/img/team/avatar.png') }}" :
                                "{{ asset('/') }}" + user.profile;
                                let vendor_status = (user.status == 0) ? 'Pending' : (user.status == 1) ?
                                'Approved' : 'Declined';
                            let vendor_status_badge = (user.status == 0) ? 'bg-warning' : (user.status == 1) ? 'bg-success' : 'bg-danger';
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="vendorid">${user.user_id}</td>
                        <td class="name">
                        <img class="rounded-circle shadow-sm me-1" src="${profileImage}" alt="User Avatar" style="height:26px;width:26px;"/>
                         ${user.name}
                        </td>
                        <td class="phone">${user.phone}</td>
                        <td class="email">${user.email}</td>
                        <td class="date">${formatDate(user.created_at)}</td>
                        <td class="status"><a href="javascript:void(0);" data-id="${user.id}" class="badge ${vendor_status_badge} change_vendor_status">${vendor_status}</a></td>
                        <td>
                            <div>
                                 <a class="btn btn-link p-0 " href="{{ url('/') }}/vendor/${user.user_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${user.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${user.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${user.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['vendorid', 'name', 'email', 'phone', 'date','status'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            // Store
            $(document).ready(function() {
                var validator = $("#storeVendor").validate({
                    ignore: [],
                    errorPlacement: function(error, element) {
                        error.addClass("text-danger");
                        if (element.is(":radio") || element.is(":checkbox")) {
                            error.appendTo(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $('#submitUserBtn').on('click', function(e) {
                    e.preventDefault();

                    if ($("#storeVendor").valid()) {
                        $('.loading').show();
                        var form = $("#storeVendor")[0];
                        var formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('vendor.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('.loading').hide();
                                Swal.fire("Success!", response.success, "success");
                                fetchVendor();
                                $('#addModal').modal('hide');
                                window.location.reload();
                            },
                            error: function(xhr) {
                                $('.loading').hide();
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
                $('.loading').show();
                let vendorId = $(this).data('id');

                $.ajax({
                    url: '/vendor/' + vendorId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        let vendor = response.vendor;

                        // Basic user info
                        $('#edit_id').val(vendor.id);
                        $('#edit_name').val(vendor.name);
                        $('#edit_username').val(vendor.username);
                        $('#edit_phone').val(vendor.phone);
                        $('#edit_email').val(vendor.email);
                        $('#edit_date_of_birth').val(vendor.date_of_birth || '');
                        $('#edit_age').val(vendor.age || '');
                        $('#edit_blood_group').val(vendor.blood_group || '');
                        $('#edit_terms_condition').prop('checked', vendor.terms_condition == 1);
                        $('#edit_subscribe').prop('checked', vendor.subscribe == 1);
                        if (vendor.profile == 'dummy') {
                            $('#preview_company_logo').attr('src',
                                '/backend/assets/img/team/avatar.png');
                        } else {
                            $('#preview_company_logo').attr('src', vendor.profile);
                        }

                        // Gender
                        $('input[name="gender"]').prop('checked', false);
                        if (vendor.gender == 'Male') {
                            $('#edit_male').prop('checked', true);
                        }
                        if (vendor.gender == 'Female') {
                            $('#edit_female').prop('checked', true);
                        }
                        if (vendor.gender == 'Other') {
                            $('#edit_other').prop('checked', true);
                        }
                        // User Details
                        if (vendor.user_details) {

                            let details = vendor.user_details;
                            $('#edit_address').val(details.address || '');
                            $('#edit_city').val(details.city || '');
                            $('#edit_state').val(details.state || '');
                            $('#edit_country').val(details.country || '');
                            $('#edit_pin').val(details.pin || '');
                            $('#edit_google_map_location').val(details.google_map_location ||
                                '');
                            $('#edit_alternate_phone').val(details.alternate_phone || '');

                        } else {
                            $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone')
                                .val('');
                        }
                        if (vendor.vendor_details) {

                            let vendorDetails = vendor.vendor_details;

                            $('#edit_company_name').val(vendorDetails.company_name || '');
                            $('#edit_company_reg_no').val(vendorDetails.company_reg_no || '');
                            $('#edit_business_type').val(vendorDetails.business_type || '');
                            $('#edit_tin').val(vendorDetails.tin || '');
                            $('#edit_establishment_year').val(vendorDetails
                                .establishment_year || '');
                            $('#edit_iso_certifications').val(vendorDetails
                                .iso_certifications || '');
                            $('#edit_environmental_certificates').val(vendorDetails
                                .environmental_certificates || '');
                            $('#edit_primary_categories').val(vendorDetails
                                .primary_categories || '');
                            $('#edit_subcategories').val(vendorDetails.subcategories || '');
                            $('#edit_custom_equipment_manufacturing').val(String(vendorDetails
                                .custom_equipment_manufacturing ?? '')).trigger('change');
                            $('#edit_oem_odm_capabilities').val(String(vendorDetails
                                .oem_odm_capabilities ?? '')).trigger('change');
                            $('#edit_moq').val(vendorDetails.moq || '');
                            $('#edit_lead_time_days').val(vendorDetails.lead_time_days || '');

                            if (vendorDetails.business_license) {
                                $('#preview_business_license').attr('src', vendorDetails
                                    .business_license);
                            } else {
                                $('#preview_business_license').attr('src',
                                    '/backend/assets/img/team/avatar.png');
                            }

                            if (vendorDetails.import_export_license) {
                                $('#preview_import_export_license').attr('src', vendorDetails
                                    .import_export_license);
                            } else {
                                $('#preview_import_export_license').attr('src',
                                    '/backend/assets/img/team/avatar.png');
                            }

                            if (vendorDetails.msds_document) {
                                $('#preview_msds_document').attr('href', vendorDetails
                                    .msds_document);
                                $('#preview_msds_document').show();
                            } else {
                                $('#preview_msds_document').hide();
                            }

                        } else {
                            $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone').val('');
                        }

                        $('#editModal').modal('show');
                        $('.loading').hide();
                    },
                    error: function() {
                        $('.loading').hide();
                        alert('Something went wrong while fetching user data.');
                    }
                });
            });


            // Update User AJAX
            $('#updateVendor').submit(function(e) {
                e.preventDefault();
                $('.loading').show();

                var vendorId = $('#edit_id').val();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');
                $.ajax({
                    url: '/vendor/' + vendorId,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        $('#editModal').modal('hide');
                        Swal.fire("Success!", response.success, "success");
                        fetchVendor();
                        $('.loading').hide();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire("Error!", "Something went wrong.", "error");
                        $('.loading').hide();
                    }
                });
            });

            // Delete 
            $(document).on('click', '.delete-btn', function() {
                let vendorId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the vendor and all related data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.loading').show();

                        $.ajax({
                            url: `/vendor/${vendorId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('.loading').hide();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The vendor and related data have been deleted.",
                                        "success");
                                    fetchVendor();
                                } else {
                                    Swal.fire("Error!", "Something went wrong.",
                                        "error");
                                }
                            },
                            error: function(xhr) {
                                $('.loading').hide();
                                Swal.fire("Error!", "Failed to delete vendor.",
                                "error");
                            }
                        });
                    }
                });
            });
        });
        $(document).on('click', '.change_vendor_status', function(e) {
                e.preventDefault();
                let vendorId = $(this).data('id');
                let $this = $(this);

                Swal.fire({
                    title: 'Change Lab Status',
                    input: 'select',
                    inputOptions: {
                        '1': 'Approved',
                        '0': 'Pending',
                        '2': 'Declined'
                    },
                    inputPlaceholder: 'Select status',
                    showConfirmButton: false,
                    showCancelButton: true,
                    didOpen: () => {
                        const select = Swal.getInput();
                        select.classList.add('w-50', 'mx-auto', 'form-select',
                            'form-select-sm');

                        // Auto-confirm when an option is selected
                        select.addEventListener('change', () => {
                            if (select.value !== '') {
                                Swal.clickConfirm();
                            }
                        });
                    },
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value !== '') {
                                resolve();
                            } else {
                                resolve('You need to select a status');
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let newStatus = result.value;

                        $.ajax({
                            url: '{{ route('change.vendor.status') }}',
                            method: 'POST',
                            data: {
                                vendor_id: vendorId,
                                status: newStatus,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                $('.loading').show();
                            },
                            success: function(response) {
                                $('.loading').hide();
                                if (response.success) {
                                    Swal.fire('Updated!',
                                        'Vendor status has been updated.', 'success');
                                    // Update label and badge
                                    $this.removeClass().addClass(
                                        `badge change_vendor_status ${response.new_badge_class}`
                                    );
                                    $this.text(response.new_status_label);
                                } else {
                                    Swal.fire('Error!', 'Failed to update status.',
                                        'error');
                                }
                            },
                            error: function() {
                                $('.loading').hide();
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });
    </script>
@endsection
