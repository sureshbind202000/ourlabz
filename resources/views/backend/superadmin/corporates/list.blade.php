@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Corporates</h5>
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
                                    <th class="text-900" data-sort="userid">Corporate ID</th>
                                    <th class="text-900" data-sort="name">Company Name</th>
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
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Corporate</h4>
                        <p class="fs-10 mb-0 text-white">Fill the form to create new corporate.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="storeForm" enctype="multipart/form-data">
                            @csrf
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span>
                                            <span class="d-none d-md-block mt-1 fs-10">Company Details</span></a></li>
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
                                                class="d-none d-md-block mt-1 fs-10">Office Address</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                            data-bs-toggle="tab" data-wizard-step="4"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Employee Test Preferences</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                            data-bs-toggle="tab" data-wizard-step="5"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Billing & Payment</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab6"
                                            data-bs-toggle="tab" data-wizard-step="6"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Document Uploads</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab7"
                                            data-bs-toggle="tab" data-wizard-step="7"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-7"></i></span></span><span
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
                                                    type="text" placeholder="Enter company name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="company_reg_no">Company Registration No.
                                                    (CIN/GST/etc.)</label>
                                                <input class="form-control" id="company_reg_no" name="company_reg_no"
                                                    type="text" placeholder="Enter company registration number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="industry_type">Industry Type</label>
                                                <select class="form-select" id="industry_type" name="industry_type">
                                                    <option value="">--select--</option>
                                                    <option value="IT">IT</option>
                                                    <option value="Health Care">Health Care</option>
                                                    <option value="Manufacturing">Manufacturing</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="company_size">Company Size</label>
                                                <select class="form-select" id="company_size" name="company_size">
                                                    <option value="">--select--</option>
                                                    <option value="1-50">1-50</option>
                                                    <option value="51-200">51-200</option>
                                                    <option value="201-1000">201-1000</option>
                                                    <option value="1000+">1000+</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="establishment_year">Establishment
                                                    Year</label>
                                                <input class="form-control" id="establishment_year"
                                                    name="establishment_year" type="date" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Company Logo (optional)</label>
                                                <input class="form-control" id="profile" name="profile"
                                                    type="file" />
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="website_url">Website URL (optional)</label>
                                                <input class="form-control" id="website_url" name="website_url"
                                                    type="text" placeholder="Enter website url" />
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
                                                <input class="form-control" id="name" name="name" type="text"
                                                    placeholder="Enter name" />
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
                                                    type="date" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="age">Age</label>
                                                <input class="form-control" id="age" name="age" type="number"
                                                    placeholder="Auto-calculated based on DOB" readonly />
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
                                                    placeholder="Enter phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="alternate_phone">Alternate Phone</label>
                                                <input class="form-control" id="alternate_phone" name="alternate_phone"
                                                    type="number" placeholder="Enter alternate phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="email">Official Email Address
                                                    (Optional)</label>
                                                <input class="form-control" id="email" name="email" type="text"
                                                    placeholder="Enter email" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                        data-wizard-form="3">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="address">Street Address</label>
                                                <input class="form-control" id="address" name="address" type="text"
                                                    placeholder="Enter address" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="city">City</label>
                                                <input class="form-control" id="city" name="city" type="text"
                                                    placeholder="Enter city" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="state">State</label>
                                                <input class="form-control" id="state" name="state" type="text"
                                                    placeholder="Enter state" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="country">Country</label>
                                                <input class="form-control" id="country" name="country" type="text"
                                                    placeholder="Enter country" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="pin">Pin/Postal code</label>
                                                <input class="form-control" id="pin" name="pin" type="text"
                                                    placeholder="Enter pin/postal code" />
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
                                                <label class="form-label" for="no_of_emp_for_test">Number of Employees for
                                                    Testing</label>
                                                <input class="form-control" id="no_of_emp_for_test"
                                                    name="no_of_emp_for_test" type="number"
                                                    placeholder="Enter Number of Employees for Testing" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="on_site_test">On-Site Testing
                                                    Required?</label>
                                                <select name="on_site_test" id="on_site_test" class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="home_sample_collection">Home Sample
                                                    Collection for Employees?</label>
                                                <select name="home_sample_collection" id="home_sample_collection"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="frequency_of_testing">Frequency of
                                                    Testing</label>
                                                <select name="frequency_of_testing" id="frequency_of_testing"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="One-time">One-time</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Quarterly">Quarterly</option>
                                                    <option value="Yearly">Yearly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                        data-wizard-form="5">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="billing_contact_name">Billing Contact
                                                    Name</label>
                                                <input class="form-control" id="billing_contact_name"
                                                    name="billing_contact_name" type="text"
                                                    placeholder="Enter Billing Contact Name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="billing_contact_email">Billing Email
                                                    Address</label>
                                                <input class="form-control" id="billing_contact_email"
                                                    name="billing_contact_email" type="email"
                                                    placeholder="Enter Billing Email Address" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="company_gst">Company GST Number (if
                                                    applicable)</label>
                                                <input class="form-control" id="company_gst" name="company_gst"
                                                    type="text" placeholder="Enter Company GST Number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="prefer_payment_method">Preferred Payment
                                                    Method</label>
                                                <select name="prefer_payment_method" id="prefer_payment_method"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                    <option value="UPI">UPI</option>
                                                    <option value="Invoice">Invoice</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="bank_account_no">Bank Account
                                                    Number</label>
                                                <input class="form-control" id="bank_account_no" name="bank_account_no"
                                                    type="number" placeholder="Enter Bank Account Number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="ifsc">IFSC Code</label>
                                                <input class="form-control" id="ifsc" name="ifsc" type="text"
                                                    placeholder="Enter IFSC Code" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="subscription_plan">Subscription Plan (if
                                                    applicable)</label>
                                                <select name="subscription_plan" id="subscription_plan"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Pay-per-test">Pay-per-test</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Annual">Annual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6"
                                        data-wizard-form="6">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="company_reg_cert">Company Registration
                                                    Certificate</label>
                                                <input class="form-control" id="company_reg_cert" name="company_reg_cert"
                                                    type="file"
                                                    placeholder="Upload Company Registration Certificate" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="employee_list">Employee List (for bulk
                                                    testing) </label>
                                                <input class="form-control" id="employee_list" name="employee_list"
                                                    type="file" accept=".xlsx" placeholder="Upload Employee List" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="authorization_letter">Authorization Letter
                                                    (if required for testing)</label>
                                                <input class="form-control" id="authorization_letter"
                                                    name="authorization_letter" type="file"
                                                    placeholder="Upload Authorization Letter" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"
                                        data-wizard-form="7">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="username">username</label>
                                                <input class="form-control" id="username" name="username"
                                                    type="text" placeholder="Enter username" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control w-75" type="password" name="password"
                                                        id="password" placeholder="Type or generate password." />
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
                                                        value="" name="terms_condition" />
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
                                                    id="submitBtn">Submit</button>
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
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Corporate</h4>
                        <p class="fs-10 mb-0 text-white">Update corporate details.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="updateCorporate" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="edit_id" name="id">
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">

                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab9" data-bs-toggle="tab" data-wizard-step="9"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span>
                                            <span class="d-none d-md-block mt-1 fs-10">Company Details</span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab10"
                                            data-bs-toggle="tab" data-wizard-step="10"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab11"
                                            data-bs-toggle="tab" data-wizard-step="11"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-3"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Office Address</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab12"
                                            data-bs-toggle="tab" data-wizard-step="12"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Employee Test Preferences</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab13"
                                            data-bs-toggle="tab" data-wizard-step="13"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Billing & Payment</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab14"
                                            data-bs-toggle="tab" data-wizard-step="14"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Document Uploads</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab15"
                                            data-bs-toggle="tab" data-wizard-step="15"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-7"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Login & Account</span></a>
                                    </li>

                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab9" id="bootstrap-wizard-tab9"
                                        data-wizard-form="9">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_name">Company Name</label>
                                                <input class="form-control" id="edit_company_name" name="company_name"
                                                    type="text" placeholder="Enter company name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_reg_no">Company Registration
                                                    No.
                                                    (CIN/GST/etc.)</label>
                                                <input class="form-control" id="edit_company_reg_no"
                                                    name="company_reg_no" type="text"
                                                    placeholder="Enter company registration number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_industry_type">Industry Type</label>
                                                <select class="form-select" id="edit_industry_type" name="industry_type">
                                                    <option value="">--select--</option>
                                                    <option value="IT">IT</option>
                                                    <option value="Health Care">Health Care</option>
                                                    <option value="Manufacturing">Manufacturing</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_size">Company Size</label>
                                                <select class="form-select" id="edit_company_size" name="company_size">
                                                    <option value="">--select--</option>
                                                    <option value="1-50">1-50</option>
                                                    <option value="51-200">51-200</option>
                                                    <option value="201-1000">201-1000</option>
                                                    <option value="1000+">1000+</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_establishment_year">Establishment
                                                    Year</label>
                                                <input class="form-control" id="edit_establishment_year"
                                                    name="establishment_year" type="date" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_profile">Company Logo
                                                    (optional)</label>
                                                <input class="form-control" id="edit_profile" name="profile"
                                                    type="file" />
                                                <br>
                                                <img src="" id="preview_company_logo" alt=""
                                                    height="50">
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label" for="edit_website_url">Website URL
                                                    (optional)</label>
                                                <input class="form-control" id="edit_website_url" name="website_url"
                                                    type="text" placeholder="Enter website url" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab10" id="bootstrap-wizard-tab10"
                                        data-wizard-form="10">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_name">Primary Contact Person
                                                    Name</label>
                                                <input class="form-control" id="edit_name" name="name" type="text"
                                                    placeholder="Enter name" />
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
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_age">Age</label>
                                                <input class="form-control" id="edit_age" name="age" type="number"
                                                    placeholder="Auto-calculated based on DOB" readonly />
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
                                                <label class="form-label" for="edit_email">Official Email Address
                                                    (Optional)</label>
                                                <input class="form-control" id="edit_email" name="email"
                                                    type="text" placeholder="Enter email" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab11" id="bootstrap-wizard-tab11"
                                        data-wizard-form="11">
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
                                        aria-labelledby="bootstrap-wizard-tab12" id="bootstrap-wizard-tab12"
                                        data-wizard-form="12">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_no_of_emp_for_test">Number of
                                                    Employees for
                                                    Testing</label>
                                                <input class="form-control" id="edit_no_of_emp_for_test"
                                                    name="no_of_emp_for_test" type="number"
                                                    placeholder="Enter Number of Employees for Testing" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_on_site_test">On-Site Testing
                                                    Required?</label>
                                                <select name="on_site_test" id="edit_on_site_test" class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_home_sample_collection">Home Sample
                                                    Collection for Employees?</label>
                                                <select name="home_sample_collection" id="edit_home_sample_collection"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_frequency_of_testing">Frequency of
                                                    Testing</label>
                                                <select name="frequency_of_testing" id="edit_frequency_of_testing"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="One-time">One-time</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Quarterly">Quarterly</option>
                                                    <option value="Yearly">Yearly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab13" id="bootstrap-wizard-tab13"
                                        data-wizard-form="13">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_billing_contact_name">Billing Contact
                                                    Name</label>
                                                <input class="form-control" id="edit_billing_contact_name"
                                                    name="billing_contact_name" type="text"
                                                    placeholder="Enter Billing Contact Name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_billing_contact_email">Billing Email
                                                    Address</label>
                                                <input class="form-control" id="edit_billing_contact_email"
                                                    name="billing_contact_email" type="email"
                                                    placeholder="Enter Billing Email Address" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_gst">Company GST Number (if
                                                    applicable)</label>
                                                <input class="form-control" id="edit_company_gst" name="company_gst"
                                                    type="text" placeholder="Enter Company GST Number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_prefer_payment_method">Preferred
                                                    Payment
                                                    Method</label>
                                                <select name="prefer_payment_method" id="edit_prefer_payment_method"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                    <option value="UPI">UPI</option>
                                                    <option value="Invoice">Invoice</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_bank_account_no">Bank Account
                                                    Number</label>
                                                <input class="form-control" id="edit_bank_account_no"
                                                    name="bank_account_no" type="number"
                                                    placeholder="Enter Bank Account Number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_ifsc">IFSC Code</label>
                                                <input class="form-control" id="edit_ifsc" name="ifsc" type="text"
                                                    placeholder="Enter IFSC Code" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_subscription_plan">Subscription Plan
                                                    (if
                                                    applicable)</label>
                                                <select name="subscription_plan" id="edit_subscription_plan"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Pay-per-test">Pay-per-test</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Annual">Annual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab14" id="bootstrap-wizard-tab14"
                                        data-wizard-form="14">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_company_reg_cert">Company Registration
                                                    Certificate</label>
                                                <input class="form-control" id="edit_company_reg_cert"
                                                    name="company_reg_cert" type="file"
                                                    placeholder="Upload Company Registration Certificate" />
                                                <br>
                                                <a href="" id="preview_company_reg_cert">View</a>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_employee_list">Employee List (for
                                                    bulk
                                                    testing) </label>
                                                <input class="form-control" id="edit_employee_list"
                                                    name="employee_list" type="file" accept=".xlsx"
                                                    placeholder="Upload Employee List" />
                                                <br>
                                                <a href="" id="preview_employee_list">View</a>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_authorization_letter">Authorization
                                                    Letter
                                                    (if required for testing)</label>
                                                <input class="form-control" id="edit_authorization_letter"
                                                    name="authorization_letter" type="file"
                                                    placeholder="Upload Authorization Letter" />
                                                <br>
                                                <a href="" id="preview_authorization_letter">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab15" id="bootstrap-wizard-tab15"
                                        data-wizard-form="15">
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
                                                    <button type="button"
                                                        class="btn btn-success edit-generate-password"
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
                                                    <input class="form-check-input" id="edit_subscribe"
                                                        type="checkbox" value="" name="subscribe" />
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
            fetchData();

            function fetchData() {
                $('.loading').show();
                $.ajax({
                    url: "{{ route('corporate.list') }}",
                    type: "GET",
                    success: function(data) {
                        $('.loading').hide();
                        let rows = "";
                        $.each(data, function(index, corporate) {
                            let corporate_status = (corporate.status == 0) ? 'Pending' : (
                                    corporate
                                    .status == 1) ?
                                'Approved' : 'Declined';
                            let corporate_status_badge = (corporate.status == 0) ?
                                'bg-warning' : (
                                    corporate
                                    .status == 1) ? 'bg-success' : 'bg-danger';

                            let profileImage = (corporate.profile === 'dummy') ?
                                "{{ asset('backend/assets/img/team/avatar.png') }}" :
                                "{{ asset('/') }}" + corporate.profile;
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="userid">${corporate.user_id}</td>
                        <td class="name">
                        <img class="rounded-circle shadow-sm me-1" src="${profileImage}" alt="User Avatar" style="height:26px;width:26px;"/>
                         ${corporate.name}
                        </td>
                        <td class="phone">${corporate.phone}</td>
                        <td class="email">${corporate.email}</td>
                        <td class="date">${formatDate(corporate.created_at)}</td>
                        <td class="status"><a href="javascript:void(0);" data-id="${corporate.id}" class="badge ${corporate_status_badge} change_corporate_status">${corporate_status}</a></td>
                        <td>
                            <div>
                                 <a class="btn btn-link p-0 " href="{{ url('/') }}/corporate/${corporate.user_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${corporate.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${corporate.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${corporate.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['testid', 'name', 'date','status'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            // Store
            $(document).ready(function() {
                var validator = $("#storeForm").validate({
                    ignore: [],
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        phone: {
                            required: true
                        },
                        username: {
                            required: true
                        },
                        password: {
                            required: true
                        },
                        gender: {
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Name is required",
                            minlength: "Name must be at least 3 characters"
                        },
                        phone: "Phone number is required",
                        username: "Username is required",
                        password: "Password is required",
                        gender: "Gender is required",
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

                    if ($("#storeForm").valid()) {
                        $('.loading').show();
                        var form = $("#storeForm")[0];
                        var formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('corporate.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('.loading').hide();
                                Swal.fire("Success!", response.success, "success");
                                fetchData();
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
                let corporateId = $(this).data('id');

                $.ajax({
                    url: '/corporate/' + corporateId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        let corporate = response.corporate;

                        // Basic corporate info
                        $('#edit_id').val(corporate.id);
                        $('#edit_name').val(corporate.name);
                        $('#edit_username').val(corporate.username);
                        $('#edit_phone').val(corporate.phone);
                        $('#edit_email').val(corporate.email);
                        $('#edit_date_of_birth').val(corporate.date_of_birth || '');
                        $('#edit_age').val(corporate.age || '');
                        $('#edit_blood_group').val(corporate.blood_group || '');
                        $('#edit_terms_condition').prop('checked', corporate.terms_condition ==
                            1);
                        $('#edit_subscribe').prop('checked', corporate.subscribe == 1);
                        if (corporate.profile == 'dummy') {
                            $('#preview_company_logo').attr('src',
                                '/backend/assets/img/team/avatar.png');
                        } else {
                            $('#preview_company_logo').attr('src', corporate.profile);
                        }

                        // Gender
                        $('input[name="gender"]').prop('checked', false);
                        if (corporate.gender == 'Male') {
                            $('#edit_male').prop('checked', true);
                        }
                        if (corporate.gender == 'Female') {
                            $('#edit_female').prop('checked', true);
                        }
                        if (corporate.gender == 'Other') {
                            $('#edit_other').prop('checked', true);
                        }
                        // corporate Details
                        if (corporate.user_details) {
                            let details = corporate.user_details;
                            $('#edit_address').val(details.address || '');
                            $('#edit_city').val(details.city || '');
                            $('#edit_state').val(details.state || '');
                            $('#edit_country').val(details.country || '');
                            $('#edit_pin').val(details.pin || '');
                            $('#edit_google_map_location').val(details.google_map_location ||
                                '');
                            $('#edit_alternate_phone').val(details.alternate_phone || '');
                        } else {
                            $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone, #edit_emergency_contact_name, #edit_emergency_contact_phone')
                                .val('');
                        }

                        if (corporate.corporate_details) {
                            let details = corporate.corporate_details;
                            $('#edit_company_name').val(details.company_name || '');
                            $('#edit_company_reg_no').val(details.company_reg_no || '');
                            $('#edit_industry_type').val(details.industry_type || '');
                            $('#edit_company_size').val(details.company_size || '');
                            $('#edit_establishment_year').val(details.establishment_year || '');
                            $('#edit_website_url').val(details.website_url || '');
                            $('#edit_no_of_emp_for_test').val(details.no_of_emp_for_test || '');
                            $('#edit_on_site_test').val(details.on_site_test || '');
                            $('#edit_home_sample_collection').val(details
                                .home_sample_collection || '');
                            $('#edit_frequency_of_testing').val(details.frequency_of_testing ||
                                '');
                            $('#edit_billing_contact_name').val(details.billing_contact_name ||
                                '');
                            $('#edit_billing_contact_email').val(details
                                .billing_contact_email || '');
                            $('#edit_company_gst').val(details.company_gst || '');
                            $('#edit_prefer_payment_method').val(details
                                .prefer_payment_method || '');
                            $('#edit_bank_account_no').val(details.bank_account_no || '');
                            $('#edit_ifsc').val(details.ifsc || '');
                            $('#edit_subscription_plan').val(details.subscription_plan || '');
                            if (details.company_reg_cert) {
                                $('#preview_company_reg_cert').attr('href', '/' + details
                                    .company_reg_cert).show();
                            }
                            if (details.employee_list) {
                                $('#preview_employee_list').attr('href', '/' + details
                                    .employee_list).show();
                            }
                            if (details.authorization_letter) {
                                $('#preview_authorization_letter').attr('href', '/' + details
                                        .authorization_letter)
                                    .show();
                            }
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
            $('#updateCorporate').submit(function(e) {
                e.preventDefault();
                $('.loading').show();

                var corporateId = $('#edit_id').val();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '/corporate/' + corporateId,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        $('#editModal').modal('hide');
                        Swal.fire("Success!", response.success, "success");
                        fetchData();
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
                let corporateId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the user and all related data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.loading').show();

                        $.ajax({
                            url: `/corporate/${corporateId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('.loading').hide();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The corporate and related data have been deleted.",
                                        "success");
                                    fetchData();
                                } else {
                                    Swal.fire("Error!", "Something went wrong.",
                                        "error");
                                }
                            },
                            error: function(xhr) {
                                $('.loading').hide();
                                Swal.fire("Error!", "Failed to delete user.",
                                    "error");
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.change_corporate_status', function(e) {
                e.preventDefault();
                let corporateId = $(this).data('id');
                let $this = $(this);

                Swal.fire({
                    title: 'Change Doctor Status',
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
                            url: '{{ route('change.corporate.status') }}',
                            method: 'POST',
                            data: {
                                corporate_id: corporateId,
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
                                        'Corporate status has been updated.', 'success'
                                        );
                                    // Update label and badge
                                    $this.removeClass().addClass(
                                        `badge change_corporate_status ${response.new_badge_class}`
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

        });
    </script>
@endsection
