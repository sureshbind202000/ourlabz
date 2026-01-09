@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">All Doctors</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3"
                data-list='{"valueNames":["userid","name","phone","email"],"page":10,"pagination":true}'>
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
                                <th class="text-900" data-sort="userid">Doctor ID</th>
                                <th class="text-900" data-sort="name">Name</th>
                                <th class="text-900" data-sort="phone">Phone</th>
                                <th class="text-900" data-sort="phone">Email</th>
                                <th class="text-900" data-sort="date">Date</th>
                                <th class="text-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <tr>
                                <td>1</td>
                                <td class="userid">000</td>
                                <td class="name">user</td>
                                <td class="phone">xxx xxx xxx</td>
                                <td class="email">user@example.com</td>
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

<!-- Add Doctor Modal Start -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog mt-6 modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Doctor</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create new doctor.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <div class="theme-wizard ">
                    <form class="row" id="storeUser" enctype="multipart/form-data">
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

                                        <div class="mb-4 col-md-12">

                                            <label for="name">Full Name</label>

                                            <div class="input-group">



                                                <input type="text" class="form-control shadow-none" id="name" name="name"

                                                    placeholder="Full Name" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="gender">Gender</label>

                                            <div class="input-group">



                                                <select class="form-control shadow-none" id="gender" name="gender" required>

                                                    <option value="" disabled selected>Select Gender</option>

                                                    <option>Male</option>

                                                    <option>Female</option>

                                                    <option>Other</option>

                                                </select>

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="dob">Date of Birth</label>

                                            <div class="input-group">



                                                <input type="date" name="date_of_birth" class="form-control shadow-none" id="dob" required />
                                                <input type="hidden" name="age" id="age">
                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-12">

                                            <label>Profile Photo</label>

                                            <input class="form-control" id="profile" name="profile"
                                                type="file" />
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                    data-wizard-form="2">
                                    <div class="row">

                                        <div class="mb-4 col-md-12">

                                            <label for="emailAddress">Email Address</label>

                                            <div class="input-group">



                                                <input type="email" name="email" class="form-control shadow-none" id="emailAddress"

                                                    placeholder="email@example.com" required />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">

                                            <label for="phoneNumber">Phone Number</label>

                                            <div class="input-group">



                                                <input type="tel" name="phone" class="form-control shadow-none" id="phoneNumber"

                                                    placeholder="+919876543210" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="alternateNumber">Alternate Phone Number</label>

                                            <div class="input-group">



                                                <input type="tel" name="alternate_phone" class="form-control shadow-none" id="alternateNumber"

                                                    placeholder="+1 987 654 321" />

                                            </div>

                                        </div>







                                        <div class="mb-4 col-md-6">

                                            <label for="emergencyContactname">Emergency Contact Name</label>

                                            <div class="input-group">



                                                <input type="text" name="emergency_contact_name" class="form-control shadow-none"

                                                    id="emergencyContactname" placeholder="Name" required />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">

                                            <label for="emergencyContact">Emergency Contact Number</label>

                                            <div class="input-group">



                                                <input type="number" name="emergency_contact_phone" class="form-control shadow-none"

                                                    id="emergencyContact" placeholder=" +1 111 222 3333" required />

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                    data-wizard-form="3">
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
                                                    value="1" name="terms_condition" />
                                                <label class="form-check-label" for="terms_condition">Consent to Terms
                                                    & Conditions</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="subscribe_notification"
                                                    type="checkbox" value="1" name="subscribe" />
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
<!-- Add Doctor Modal End -->
<!-- Edit Doctor Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog mt-6 modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Doctor</h4>
                    <p class="fs-10 mb-0 text-white">Update doctor details.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <div class="theme-wizard ">
                    <form class="row" id="updateDoctor" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">

                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab9" data-bs-toggle="tab" data-wizard-step="9"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-1"></i></span></span>
                                        <span class="d-none d-md-block mt-1 fs-10">Personal Details</span></a></li>
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
                                            class="d-none d-md-block mt-1 fs-10">Address Details</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab12"
                                        data-bs-toggle="tab" data-wizard-step="12"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-4"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Professional Details</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab13"
                                        data-bs-toggle="tab" data-wizard-step="13"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-5"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Availability & Booking</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab14"
                                        data-bs-toggle="tab" data-wizard-step="14"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-6"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Bank & Payment</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab15"
                                        data-bs-toggle="tab" data-wizard-step="15"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-7"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Uploads & Documents</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab16"
                                        data-bs-toggle="tab" data-wizard-step="16"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-8"></i></span></span><span
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
                                            <label class="form-label" for="edit_name">Full Name</label>
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
                                            <label class="form-label">Upload Image (optional)</label>
                                            <input class="form-control" id="edit_profile" name="profile"
                                                type="file" />
                                            <br>
                                            <img src="" alt="" id="PreviewProfile" height="100px">
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label" for="edit_about">About</label>
                                            <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_about" name="about"
                                                placeholder="Enter about description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab10" id="bootstrap-wizard-tab10"
                                    data-wizard-form="10">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_phone">Phone</label>
                                            <input class="form-control" id="edit_phone" name="phone"
                                                type="tel" placeholder="Enter phone number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_alternate_phone">Alternate
                                                Phone</label>
                                            <input class="form-control" id="edit_alternate_phone"
                                                name="alternate_phone" type="tel"
                                                placeholder="Enter alternate phone number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_email">Email (Optional)</label>
                                            <input class="form-control" id="edit_email" name="email"
                                                type="text" placeholder="Enter email" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_emergency_contact_name">Emergency
                                                Contact
                                                Name</label>
                                            <input class="form-control" id="edit_emergency_contact_name"
                                                name="emergency_contact_name" type="text"
                                                placeholder="Enter emergency contact name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_emergency_contact_phone">Emergency
                                                Contact
                                                Phone</label>
                                            <input class="form-control" id="edit_emergency_contact_phone"
                                                name="emergency_contact_phone" type="number"
                                                placeholder="Enter emergency contact phone number" />
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
                                            <label class="form-label" for="edit_medical_license_number">Medical License Number</label>
                                            <input class="form-control" id="edit_medical_license_number"
                                                name="medical_license_number" type="text"
                                                placeholder="Enter Medical License Number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_license_issue_authority">License Issuing Authority</label>
                                            <select name="license_issue_authority" id="edit_license_issue_authority" class="form-select">
                                                <option value="">--select--</option>
                                                <option value="MCI">MCI</option>
                                                <option value="State Medical Council">State Medical Council</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_specialization">Specialization</label>
                                            <select name="specialization[]" id="edit_specialization"
                                                class="form-select" multiple="multiple" size="1"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">--select--</option>
                                                <option value="General Physician">General Physician</option>
                                                <option value="Cardiologist">Cardiologist</option>
                                                <option value="Radiologist">Radiologist</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_qualification">Qualification</label>
                                            <select name="qualification[]" id="edit_qualification"
                                                class="form-select" multiple="multiple" size="1"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">--select--</option>
                                                <option value="MBBS">MBBS</option>
                                                <option value="BDS">BDS</option>
                                                <option value="MS">MS</option>
                                                <option value="MD">MD</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_year_of_experience">Years of Experience</label>
                                            <input class="form-control" id="edit_year_of_experience"
                                                name="year_of_experience" type="number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_affiliated_hospital_clinic_name">Affiliated Hospital/Clinic Name </label>
                                            <input class="form-control" id="edit_affiliated_hospital_clinic_name"
                                                name="affiliated_hospital_clinic_name" type="text"
                                                placeholder="Enter Affiliated Hospital/Clinic Name " />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_hospital_clinic_address">Hospital/Clinic Address </label>
                                            <input class="form-control" id="edit_hospital_clinic_address"
                                                name="hospital_clinic_address" type="text"
                                                placeholder="Enter Hospital/Clinic Address " />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_consultation_type">Consultation Type</label>
                                            <select name="consultation_type" id="edit_consultation_type" class="form-select">
                                                <option value="">--select--</option>
                                                <option value="Online">Online</option>
                                                <option value="In-Person">In-Person</option>
                                                <option value="Both">Both</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab13" id="bootstrap-wizard-tab13"
                                    data-wizard-form="13">
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label>Operating Hours</label>
                                            <div class="form-check">
                                                <div class="row mt-2 align-items-center">
                                                    <div class="col-md-3">
                                                        <input class="form-check-input day-checkbox check-all-day"
                                                            type="checkbox" />
                                                        <label class="form-check-label fw-bold"
                                                            for="check-all-day">Check All</label>
                                                    </div>
                                                    <div class="col-md-3 d-none">
                                                        <label class="form-label">From</label>
                                                        <input type="time" class="form-control all_from_time" />
                                                    </div>
                                                    <div class="col-md-3 d-none">
                                                        <label class="form-label">To</label>
                                                        <input type="time" class="form-control all_to_time" />
                                                    </div>
                                                    <div class="col-md-3 d-none">
                                                        <label class="form-label ">Status</label>
                                                        <select class="form-select all_status">
                                                            <option value="">-- Select --</option>
                                                            <option value="Open">Open</option>
                                                            <option value="Close">Close</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                            $days = [
                                            'Sunday',
                                            'Monday',
                                            'Tuesday',
                                            'Wednesday',
                                            'Thursday',
                                            'Friday',
                                            'Saturday',
                                            ];
                                            @endphp

                                            @foreach ($days as $day)
                                            <div class="form-check">
                                                <div class="row mt-2 align-items-center">
                                                    <div class="col-md-3">
                                                        <input
                                                            class="form-check-input day-checkbox {{ strtolower($day) }}"
                                                            type="checkbox" name="day[]"
                                                            value="{{ $day }}" />
                                                        <label
                                                            class="form-check-label fw-bold">{{ $day }}</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">From</label>
                                                        <input type="time" name="from_time[]"
                                                            class="form-control from-time"
                                                            data-day="{{ $day }}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">To</label>
                                                        <input type="time" name="to_time[]"
                                                            class="form-control to-time"
                                                            data-day="{{ $day }}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status[]" class="form-select status"
                                                            data-day="{{ $day }}">
                                                            <option value="">-- Select --</option>
                                                            <option value="Open">Open</option>
                                                            <option value="Close">Close</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab14" id="bootstrap-wizard-tab14"
                                    data-wizard-form="14">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_account_number">Bank Account Number</label>
                                            <input class="form-control" id="edit_account_number"
                                                name="account_number" type="number"
                                                placeholder="Enter Bank Account Number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_ifsc_code">IFSC Code</label>
                                            <input class="form-control" id="edit_ifsc_code"
                                                name="ifsc_code" type="text"
                                                placeholder="Enter IFSC Code" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_account_holder_name">Account Holder Name</label>
                                            <input class="form-control" id="edit_account_holder_name"
                                                name="account_holder_name" type="text"
                                                placeholder="Enter Account Holder Name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_upi_id">UPI ID (Optional)</label>
                                            <input class="form-control" id="edit_upi_id"
                                                name="upi_id" type="text"
                                                placeholder="Enter UPI ID" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_tin">Tax Identification Number (TIN/GST if applicable)</label>
                                            <input class="form-control" id="edit_tin"
                                                name="tin" type="text"
                                                placeholder="Enter Tax Identification Number" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab15" id="bootstrap-wizard-tab15"
                                    data-wizard-form="15">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_medical_degree_certificate">Medical Degree Certificate</label>
                                            <input class="form-control" id="edit_medical_degree_certificate" name="medical_degree_certificate"
                                                type="file" placeholder="Upload Medical Degree Certificate" />
                                            <br>
                                            <a href="" target="_blank" id="medical_degree_certificate_preview">View</a>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_medical_license">Medical License/Registration Certificate</label>
                                            <input class="form-control" id="edit_medical_license" name="medical_license"
                                                type="file" placeholder="Upload Medical Degree Certificate" />
                                            <br>
                                            <a href="" target="_blank" id="medical_license_preview">View</a>
                                        </div>
                                        <div class="mb-3 col-6 ">
                                            <div class="input-group">
                                                <label class="form-label" for="edit_id_proof">Government ID Proof</label>
                                                <label class="form-label ms-auto" for="edit_id_type">ID Type</label>
                                            </div>

                                            <div class="input-group">
                                                <input class="form-control w-75" id="edit_id_proof" name="id_proof"
                                                    type="file" />
                                                <select name="id_type" id="edit_id_type"
                                                    class="form-select w-25">
                                                    <option value="">Type</option>
                                                    <option value="Aadhar card">Aadhar card</option>
                                                    <option value="PAN Card">PAN Card</option>
                                                    <option value="Ration Card">Ration Card</option>
                                                    <option value="Driving Licence">Driving Licence</option>
                                                    <option value="Voter ID">Voter ID</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <br>
                                            <a href="" target="_blank" id="id_proof_preview">View</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab16" id="bootstrap-wizard-tab16"
                                    data-wizard-form="16">
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
                                                <label class="form-check-label"
                                                    for="edit_subscribe">Subscribe to Notifications &
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
<!-- Edit Doctor Modal End -->
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
        fetchDoctors();

        function fetchDoctors() {
            $('.loading').show();
            $.ajax({
                url: "{{ route('doctor.refering_doctor.list') }}",
                type: "GET",
                success: function(data) {
                    $('.loading').hide();
                    let rows = "";
                    $.each(data, function(index, doctor) {
                        let profileImage = (doctor.profile === 'dummy') ?
                            "{{ asset('backend/assets/img/team/avatar.png') }}" :
                            "{{ asset('/') }}" + doctor.profile;
                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="userid">${doctor.user_id}</td>
                        <td class="name">
                        <img class="rounded-circle shadow-sm me-1" src="${profileImage}" alt="User Avatar" style="height:26px;width:26px;"/>
                         ${doctor.name}
                        </td>
                        <td class="phone">${doctor.phone}</td>
                        <td class="email">${doctor.email}</td>
                        <td class="date">${formatDate(doctor.created_at)}</td>
                        <td>
                            <div>
                                 <a class="btn btn-link p-0 " href="{{ url('/') }}/doctor/${doctor.user_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${doctor.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${doctor.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${doctor.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['testid', 'name', 'date'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeUser").validate({
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

            $('#submitUserBtn').on('click', function(e) {
                e.preventDefault();
                console.log("working")
                if ($("#storeUser").valid()) {
                    $('.loading').show();
                    var form = $("#storeUser")[0];
                    var formData = new FormData(form);
                    if (!$('#terms_condition').is(':checked')) {
                        formData.set('terms_condition', ''); // To trigger validation error
                    }

                    if (!$('#subscribe_notification').is(':checked')) {
                        formData.set('subscribe', '0'); // Optional, since it's nullable
                    }
                    $.ajax({
                        url: "{{ route('doctor.referring_doctor.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('.loading').hide();
                            Swal.fire("Success!", response.success, "success");
                            fetchDoctors();
                            $('#addModal').modal('hide');
                            window.location.reload();
                        },
                        error: function(xhr, error, status) {
                            $('.loading').hide();
                            console.log(xhr, error, status); // Optional: debugging

                            // Default error message
                            let errorMessage = "An error occurred!";

                            // Check if controller sent a custom error
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }

                            // Show Swal alert
                            Swal.fire("Error!", errorMessage, "error");
                        }
                    });
                }
            });
        });

        // Open Edit Modal & Load Data
        $(document).on('click', '.edit-btn', function() {
            $('.loading').show();
            let doctorId = $(this).data('id');

            $.ajax({
                url: '/doctor/' + doctorId + '/edit',
                type: 'GET',
                success: function(response) {
                    let doctor = response.doctor;

                    // Basic doctor info
                    $('#edit_id').val(doctor.id);
                    $('#edit_name').val(doctor.name);
                    $('#edit_username').val(doctor.username);
                    $('#edit_phone').val(doctor.phone);
                    $('#edit_email').val(doctor.email);
                    $('#edit_date_of_birth').val(doctor.date_of_birth || '');
                    $('#edit_age').val(doctor.age || '');
                    $('#edit_blood_group').val(doctor.blood_group || '');
                    $('#edit_terms_condition').prop('checked', doctor.terms_condition == 1);
                    $('#edit_subscribe').prop('checked', doctor.subscribe == 1);
                    if (doctor.profile == 'dummy') {
                        $('#PreviewProfile').attr('src', '/backend/assets/img/team/avatar.png');
                    } else {
                        $('#PreviewProfile').attr('src', '/' + doctor.profile).show();
                    }
                    if (tinymce.get('edit_about') && doctor.about) {
                        tinymce.get('edit_about').setContent(doctor.about);
                    }

                    // Gender
                    $('input[name="gender"]').prop('checked', false);
                    if (doctor.gender == 'Male') {
                        $('#edit_male').prop('checked', true);
                    }
                    if (doctor.gender == 'Female') {
                        $('#edit_female').prop('checked', true);
                    }
                    if (doctor.gender == 'Other') {
                        $('#edit_other').prop('checked', true);
                    }
                    // doctor Details
                    if (doctor.user_details) {
                        let details = doctor.user_details;
                        $('#edit_address').val(details.address || '');
                        $('#edit_city').val(details.city || '');
                        $('#edit_state').val(details.state || '');
                        $('#edit_country').val(details.country || '');
                        $('#edit_pin').val(details.pin || '');
                        $('#edit_google_map_location').val(details.google_map_location ||
                            '');
                        $('#edit_alternate_phone').val(details.alternate_phone || '');
                        $('#edit_emergency_contact_name').val(details
                            .emergency_contact_name || '');
                        $('#edit_emergency_contact_phone').val(details
                            .emergency_contact_phone || '');
                    } else {
                        $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone, #edit_emergency_contact_name, #edit_emergency_contact_phone')
                            .val('');
                    }

                    if (doctor.doctor_details) {
                        let details = doctor.doctor_details;
                        $('#edit_medical_license_number').val(details.medical_license_number || '');
                        $('#edit_license_issue_authority').val(details.license_issue_authority || '');
                        initOrResetChoices('#edit_specialization', 'editSpecialization', details.specialization);
                        initOrResetChoices('#edit_qualification', 'editQualification', details.qualification);
                        $('#edit_year_of_experience').val(details.year_of_experience || '');
                        $('#edit_affiliated_hospital_clinic_name').val(details.affiliated_hospital_clinic_name || '');
                        $('#edit_hospital_clinic_address').val(details.hospital_clinic_address || '');
                        $('#edit_consultation_type').val(details.consultation_type || '');
                        $('#edit_account_number').val(details.account_number || '');
                        $('#edit_ifsc_code').val(details.ifsc_code || '');
                        $('#edit_account_holder_name').val(details.account_holder_name || '');
                        $('#edit_upi_id').val(details.upi_id || '');
                        $('#edit_tin').val(details.tin || '');
                        $('#edit_id_type').val(details.id_type || '');
                        if (details.medical_degree_certificate) {
                            $('#medical_degree_certificate_preview').attr('href', '/' + details.medical_degree_certificate).show();
                        }
                        if (details.medical_license) {
                            $('#medical_license_preview').attr('href', '/' + details.medical_license).show();
                        }
                        if (details.id_proof) {
                            $('#id_proof_preview').attr('href', '/' + details.id_proof).show();
                        }
                    }

                    $('.day-checkbox').prop('checked', false);
                    $('.from-time').val('');
                    $('.to-time').val('');
                    $('.status').val('');

                    // Fill operating hours
                    if (doctor.doctor_operating_hours && doctor.doctor_operating_hours.length) {
                        doctor.doctor_operating_hours.forEach(function(hour) {
                            let day = hour.day;

                            if (day && typeof day === 'string') {
                                $('.' + day.toLowerCase()).prop('checked', true);

                                $('.from-time[data-day="' + day + '"]').val(hour.from_time);
                                $('.to-time[data-day="' + day + '"]').val(hour.to_time);
                                $('.status[data-day="' + day + '"]').val(hour.status);
                            }
                        });
                    }

                    $('#editModal').modal('show');
                    $('.loading').hide();
                },
                error: function(xhr, status, error) {
                    $('.loading').hide();
                    alert('Something went wrong while fetching user data.');
                    console.log(xhr, status, error);
                }
            });
        });


        // Update User AJAX
        $('#updateDoctor').submit(function(e) {
            e.preventDefault();
            $('.loading').show();

            var doctorId = $('#edit_id').val();
            var formData = new FormData(this);

            let specialization = $('#edit_specialization').val();

            formData.delete('specialization[]');
            specialization.forEach(val => formData.append('specialization[]', val));

            let qualification = $('#edit_qualification').val();

            formData.delete('qualification[]');
            qualification.forEach(val => formData.append('qualification[]', val));

            formData.append('_method', 'PUT');

            $.ajax({
                url: '/doctor/' + doctorId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchDoctors();
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
            let packageId = $(this).data('id');

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
                        url: `/user/${packageId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('.loading').hide();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The user and related data have been deleted.",
                                    "success");
                                fetchDoctors();
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

    });
</script>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            const passwordInput = $('#password');
            const icon = $('#togglePasswordIcon');

            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);

            // Toggle the icon class
            icon.toggleClass('bi-eye');
            icon.toggleClass('bi-eye-slash');
        });

        // Age Calculator
        $('#dob').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();

            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            $('#age').val(age >= 0 ? age : '');
        });

    });
</script>
<script>
    $(document).ready(function() {
        // Toggle all checkboxes + show/hide shared inputs
        $('.check-all-day').on('change', function() {
            const isChecked = $(this).is(':checked');

            // Check/uncheck all day checkboxes
            $('.day-checkbox').prop('checked', isChecked);

            // Toggle visibility of shared inputs
            if (isChecked) {
                $('.check-all-day').closest('.row').find('.d-none').removeClass('d-none').addClass(
                    'd-block');
            } else {
                $('.check-all-day').closest('.row').find('.d-block').removeClass('d-block').addClass(
                    'd-none');
            }
        });

        // Sync from time
        $('.all_from_time').on('input', function() {
            const value = $(this).val();
            $('input[name="from_time[]"]').val(value);
        });

        // Sync to time
        $('.all_to_time').on('input', function() {
            const value = $(this).val();
            $('input[name="to_time[]"]').val(value);
        });

        // Sync status
        $('.all_status').on('change', function() {
            const value = $(this).val();
            $('select[name="status[]"]').val(value);
        });
    });
</script>
@endsection