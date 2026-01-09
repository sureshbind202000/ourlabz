@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">All Labs</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3"
                data-list='{"valueNames":["labid", "labname", "labtype","date","phone","status"],"page":10,"pagination":true}'>
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
                                <th class="text-900" data-sort="labid">Lab ID</th>
                                <th class="text-900" data-sort="labname">Name</th>
                                <th class="text-900" data-sort="phone">Phone</th>
                                <th class="text-900" data-sort="labtype">Facilities</th>
                                <th class="text-900" data-sort="date">Date</th>
                                <th class="text-900" data-sort="status">Status</th>
                                <th class="text-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <tr>
                                <td>1</td>
                                <td class="labid">LABXXX</td>
                                <td class="labname">Name</td>
                                <td class="phone">xxx xxx xxx</td>
                                <td class="labtype">Type</td>
                                <td class="date">dd/mm/yy</td>
                                <td class="status">Pending</td>
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
    <div class="modal-dialog mt-6 modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Lab</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create new lab.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <div class="theme-wizard ">
                    <form class="row" id="storeLab" enctype="multipart/form-data">
                        @csrf
                        <div class="pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">
                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-1"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Lab Details</span></a></li>
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
                                            class="d-none d-md-block mt-1 fs-10">Address & Location</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                        data-bs-toggle="tab" data-wizard-step="4"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-4"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Services Offered</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                        data-bs-toggle="tab" data-wizard-step="5"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-5"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Pricing & Insurance</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab6"
                                        data-bs-toggle="tab" data-wizard-step="6"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-6"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Uploads & Documents</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab7"
                                        data-bs-toggle="tab" data-wizard-step="7"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-7"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Login & Admin Details</span></a>
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
                                            <label class="form-label" for="lab_name">Lab Name</label>
                                            <input class="form-control" id="lab_name" name="lab_name"
                                                type="text" placeholder="Enter lab name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="lab_registration_no">Lab Registration No.
                                                (Optional)</label>
                                            <input class="form-control" id="lab_registration_no"
                                                name="lab_registration_no" type="text"
                                                placeholder="Enter lab registration no." />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label for="lab_type">Lab Facilities</label>
                                            <select class="form-select js-choice" id="lab_type" multiple="multiple"
                                                size="1" name="lab_type[]"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="" disabled>-- Select --</option>
                                                @foreach ($facilities as $facility)
                                                <option value="{{ $facility->facility }}">{{ $facility->facility }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label">Year Of Establishment</label>
                                            <input type="date" class="form-control" id="year_of_establishment"
                                                name="year_of_establishment" />
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label">Accreditation Details (Optional)</label>
                                            <input class="form-control" id="accreditation_details"
                                                name="accreditation_details" type="file" />
                                        </div>
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
                                                        <input class="form-check-input day-checkbox"
                                                            type="checkbox" name="day[]"
                                                            value="{{ $day }}" />
                                                        <label
                                                            class="form-check-label fw-bold">{{ $day }}</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">From</label>
                                                        <input type="time" name="from_time[]"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">To</label>
                                                        <input type="time" name="to_time[]"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status[]" class="form-select">
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
                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                    data-wizard-form="2">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="primary_contact_name">Primary Contact
                                                Name</label>
                                            <input class="form-control" id="primary_contact_name"
                                                name="primary_contact_name" type="text"
                                                placeholder="Enter primary contact name" />
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
                                            <label class="form-label" for="landline">Landline</label>
                                            <input class="form-control" id="landline" name="landline"
                                                type="number" placeholder="Enter landline number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="email">Email (Optional)</label>
                                            <input class="form-control" id="email" name="email" type="text"
                                                placeholder="Enter email" />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="website_url">Website URL (Optional)</label>
                                            <input class="form-control" id="website_url" name="website_url"
                                                type="text" placeholder="Enter or paste website url" />
                                        </div>


                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                    data-wizard-form="3">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="street_address">Street Address</label>
                                            <input class="form-control" id="street_address" name="street_address"
                                                type="text" placeholder="Enter street address" />
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
                                            <label class="form-label" for="postal_code">Pin/Postal code</label>
                                            <input class="form-control" id="postal_code" name="postal_code"
                                                type="text" placeholder="Enter pin/postal code" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="google_map_location">Google Map Location
                                                (Optional)</label>
                                            <input class="form-control" id="google_map_location"
                                                name="google_map_location" type="text"
                                                placeholder="Enter or paste google map location" />
                                                  <a href="javascript:void(0);"

                                                class="btn btn-sm btn-primary select-map-location w-100 mt-2" data-type="add"

                                                data-tooltip="tooltip" title="Click to select location on map"><i

                                                    class="bi bi-geo-alt-fill"></i> Select location on map</a>
                                            <input type="hidden" id="latitude" name="latitude">

                                            <input type="hidden" id="longitude" name="longitude">
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4"
                                    data-wizard-form="4">
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            {{-- <label class="form-label" for="list_of_test_available">List of Tests
                                                    Available</label>
                                                <select class="form-select js-choice" id="list_of_test_available"
                                                    multiple="multiple" size="1" name="list_of_test_available[]"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">-- Select Test --</option>
                                                    @foreach ($packages as $package)
                                                        <option value="{{ $package->package_id }}">{{ $package->name }}
                                            </option>
                                            @endforeach
                                            </select> --}}
                                            <form>
                                                <div class="row">
                                                    <h5 class="mb-4">Available Tests : </h5>
                                                    @foreach ($packages as $package)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input add-test-checkbox"
                                                                type="checkbox" value="{{ $package->package_id }}"
                                                                id="addtest{{ $package->package_id }}" checked>
                                                            <label class="form-check-label"
                                                                for="addtest{{ $package->package_id }}">
                                                                {{ $package->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-sm btn-falcon-success mt-3 "
                                                    id="addExportExcelBtn">Export Selected Tests to Excel</button>
                                            </form>
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="test_excel">Upload Tests Excel</label>
                                            <input type="file" class="form-control" id="test_excel"
                                                name="test_excel">
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                    data-wizard-form="5">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="sample_collection">Sample
                                                Collection for Corporate</label>
                                            <select class="form-select" id="sample_collection"
                                                name="sample_collection">
                                                <option value="">-- Select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="home_sample_collection">Home Sample
                                                Collection</label>
                                            <select class="form-select" id="home_sample_collection"
                                                name="home_sample_collection">
                                                <option value="">-- Select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="tat_for_reports">Average Time for
                                                Reports </label>
                                            <select class="form-select" id="tat_for_reports" name="tat_for_reports">
                                                <option value="">-- Select --</option>
                                                <option value="Same Day">Same Day</option>
                                                <option value="2-4 Hours">2-4 Hours</option>
                                                <option value="4-8 Hours">4-8 Hours</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="insurance_partner_accepted">Insurance
                                                Partners Accepted ?</label>
                                            <select class="form-select" id="insurance_partner_accepted"
                                                name="insurance_partner_accepted">
                                                <option value="">-- Select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6"
                                    data-wizard-form="6">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="lab_license">Lab License/Certificate
                                                Upload</label>
                                            <input class="form-control" id="lab_license" name="lab_license"
                                                type="file" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="doctor_license">Doctor/Technician
                                                Licenses</label>
                                            <input class="form-control" id="doctor_license" name="doctor_license"
                                                type="file" />
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label" for="signatory_doctor_details">Signatory Doctor
                                                Details</label>
                                            <textarea class="tinymce" data-tinymce="data-tinymce" id="signatory_doctor_details" name="signatory_doctor_details"
                                                placeholder="Enter signatory doctor details"></textarea>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="lab_logo">Lab Logo/Image Upload</label>
                                            <input class="form-control" id="lab_logo" name="lab_logo"
                                                type="file" />
                                        </div>
                                        <div class="mb-3 col-6 ">
                                            <div class="input-group">
                                                <label class="form-label" for="certification">Upload Certification
                                                    (optional)</label>
                                                <label class="form-label ms-auto" for="certification_type">Certificate
                                                    Type</label>
                                            </div>
                                            <div class="input-group">
                                                <input class="form-control w-75" id="certification"
                                                    name="certification" type="file" />
                                                <select name="certification_type" id="certification_type"
                                                    class="form-select w-25">
                                                    <option value="">Type</option>
                                                    <option value="ISO">ISO</option>
                                                    <option value="NABL">NABL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label" for="lab_description">Lab Description</label>
                                            <textarea class="tinymce" data-tinymce="data-tinymce" id="lab_description" name="lab_description"
                                                placeholder="Enter lab description"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"
                                    data-wizard-form="7">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="name">Admin Name</label>
                                            <input class="form-control" id="name" name="name" type="text"
                                                placeholder="Enter admin name" />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="username">Username</label>
                                            <input class="form-control" id="username" name="username"
                                                type="text" placeholder="Enter username" />
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
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Lab</h4>
                    <p class="fs-10 mb-0 text-white">Update lab details.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <div class="theme-wizard ">
                    <form class="row" id="updateLab" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">
                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab8" data-bs-toggle="tab" data-wizard-step="8"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-1"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Lab Details</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab9"
                                        data-bs-toggle="tab" data-wizard-step="9"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-2"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab10"
                                        data-bs-toggle="tab" data-wizard-step="10"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-3"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Address & Location</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab11"
                                        data-bs-toggle="tab" data-wizard-step="11"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-4"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Services Offered</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab12"
                                        data-bs-toggle="tab" data-wizard-step="12"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-5"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Pricing & Insurance</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab13"
                                        data-bs-toggle="tab" data-wizard-step="13"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-6"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Uploads & Documents</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab14"
                                        data-bs-toggle="tab" data-wizard-step="14"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-7"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Login & Admin Details</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="py-4">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab8" id="bootstrap-wizard-tab8"
                                    data-wizard-form="1">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_lab_name">Lab Name</label>
                                            <input class="form-control" id="edit_lab_name" name="lab_name"
                                                type="text" placeholder="Enter lab name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_lab_registration_no">Lab Registration
                                                No. (Optional)</label>
                                            <input class="form-control" id="edit_lab_registration_no"
                                                name="lab_registration_no" type="text"
                                                placeholder="Enter lab registration no." />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label for="edit_lab_type">Lab Facilities</label>
                                            <select class="form-select " id="edit_lab_type" multiple="multiple"
                                                size="1" name="lab_type[]"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                @foreach ($facilities as $facility)
                                                <option value="{{ $facility->facility }}">{{ $facility->facility }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label">Year Of Establishment</label>
                                            <input type="date" class="form-control"
                                                id="edit_year_of_establishment" name="year_of_establishment" />
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label">Accreditation Details (Optional)</label>
                                            <input class="form-control" id="edit_accreditation_details"
                                                name="accreditation_details" type="file" />
                                        </div>
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
                                    aria-labelledby="bootstrap-wizard-tab9" id="bootstrap-wizard-tab9"
                                    data-wizard-form="2">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_primary_contact_name">Primary Contact
                                                Name</label>
                                            <input class="form-control" id="edit_primary_contact_name"
                                                name="primary_contact_name" type="text"
                                                placeholder="Enter primary contact name" />
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
                                            <label class="form-label" for="edit_landline">Landline</label>
                                            <input class="form-control" id="edit_landline" name="landline"
                                                type="number" placeholder="Enter landline number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_email">Email (Optional)</label>
                                            <input class="form-control" id="edit_email" name="email"
                                                type="text" placeholder="Enter email" />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_website_url">Website URL
                                                (Optional)</label>
                                            <input class="form-control" id="edit_website_url" name="website_url"
                                                type="text" placeholder="Enter or paste website url" />
                                        </div>


                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab10" id="bootstrap-wizard-tab10"
                                    data-wizard-form="3">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_street_address">Street Address</label>
                                            <input class="form-control" id="edit_street_address"
                                                name="street_address" type="text"
                                                placeholder="Enter street address" />
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
                                            <label class="form-label" for="edit_postal_code">Pin/Postal code</label>
                                            <input class="form-control" id="edit_postal_code" name="postal_code"
                                                type="text" placeholder="Enter pin/postal code" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_google_map_location">Google Map
                                                Location (Optional)</label>
                                            <input class="form-control" id="edit_google_map_location"
                                                name="google_map_location" type="text"
                                                placeholder="Enter or paste google map location" />
                                            <a href="javascript:void(0);"

                                                class="btn btn-sm btn-primary select-map-location w-100 mt-2" data-type="edit"

                                                data-tooltip="tooltip" title="Click to select location on map"><i

                                                    class="bi bi-geo-alt-fill"></i> Select location on map</a>
                                            <input type="hidden" id="edit_latitude" name="latitude">

                                            <input type="hidden" id="edit_longitude" name="longitude">
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab11" id="bootstrap-wizard-tab11"
                                    data-wizard-form="4">
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            {{-- <label class="form-label" for="edit_list_of_test_available">List of Tests
                                                    Available</label>
                                                <select class="form-select " id="edit_list_of_test_available"
                                                    multiple="multiple" size="1" name="list_of_test_available[]"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">-- Select Test --</option>
                                                    @foreach ($packages as $package)
                                                        <option value="{{ $package->package_id }}">{{ $package->name }}
                                            </option>
                                            @endforeach
                                            </select> --}}
                                            <form>
                                                <div class="row">
                                                    <h5 class="mb-4">Available Tests : </h5>
                                                    @foreach ($packages as $package)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input edit-test-checkbox"
                                                                type="checkbox"
                                                                value="{{ $package->package_id }}"
                                                                id="edittest{{ $package->package_id }}" checked>
                                                            <label class="form-check-label"
                                                                for="edittest{{ $package->package_id }}">
                                                                {{ $package->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-sm btn-falcon-success mt-3 "
                                                    id="editExportExcelBtn">Export Selected Tests to Excel</button>
                                            </form>

                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_test_excel">Upload Tests Excel</label>
                                            <input type="file" class="form-control" id="edit_test_excel"
                                                name="test_excel">
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab12" id="bootstrap-wizard-tab12"
                                    data-wizard-form="5">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_sample_collection">Sample
                                                Collection for Corporate</label>
                                            <select class="form-select" id="edit_sample_collection"
                                                name="sample_collection">
                                                <option value="">-- Select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_home_sample_collection">Home Sample
                                                Collection</label>
                                            <select class="form-select" id="edit_home_sample_collection"
                                                name="home_sample_collection">
                                                <option value="">-- Select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_tat_for_reports">Average Time for
                                                Reports </label>
                                            <select class="form-select" id="edit_tat_for_reports"
                                                name="tat_for_reports">
                                                <option value="">-- Select --</option>
                                                <option value="Same Day">Same Day</option>
                                                <option value="2-4 Hours">2-4 Hours</option>
                                                <option value="4-8 Hours">4-8 Hours</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_insurance_partner_accepted">Insurance
                                                Partners Accepted ?</label>
                                            <select class="form-select" id="edit_insurance_partner_accepted"
                                                name="insurance_partner_accepted">
                                                <option value="">-- Select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab13" id="bootstrap-wizard-tab13"
                                    data-wizard-form="6">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_lab_license">Lab License/Certificate
                                                Upload</label>
                                            <input class="form-control" id="edit_lab_license" name="lab_license"
                                                type="file" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_doctor_license">Doctor/Technician
                                                Licenses</label>
                                            <input class="form-control" id="edit_doctor_license"
                                                name="doctor_license" type="file" />
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label" for="edit_signatory_doctor_details">Signatory
                                                Doctor Details</label>
                                            <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_signatory_doctor_details"
                                                name="signatory_doctor_details" placeholder="Enter signatory doctor details"></textarea>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_lab_logo">Lab Logo/Image
                                                Upload</label>
                                            <input class="form-control" id="edit_lab_logo" name="lab_logo"
                                                type="file" />
                                        </div>
                                        <div class="mb-3 col-6 ">
                                            <div class="input-group">
                                                <label class="form-label" for="edit_certification">Upload
                                                    Certification (optional)</label>
                                                <label class="form-label ms-auto"
                                                    for="edit_certification_type">Certificate Type</label>
                                            </div>
                                            <div class="input-group">
                                                <input class="form-control w-75" id="edit_certification"
                                                    name="certification" type="file" />
                                                <select name="certification_type" id="edit_certification_type"
                                                    class="form-select w-25">
                                                    <option value="">Type</option>
                                                    <option value="ISO">ISO</option>
                                                    <option value="NABL">NABL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label class="form-label" for="edit_lab_description">Lab
                                                Description</label>
                                            <textarea class="tinymce" data-tinymce="data-tinymce" id="edit_lab_description" name="lab_description"
                                                placeholder="Enter lab description"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab14" id="bootstrap-wizard-tab14"
                                    data-wizard-form="7">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_name">Admin Name</label>
                                            <input class="form-control" id="edit_name" name="name"
                                                type="text" placeholder="Enter admin name" />
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_username">Username</label>
                                            <input class="form-control" id="edit_username" name="username"
                                                type="text" placeholder="Enter username" />
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
                                                    name="gender" value="Other" />
                                                <label class="form-check-label" for="edit_other">Other</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_password">Password</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control w-75" type="password" name="password"
                                                    id="edit_password" placeholder="Type or generate password." />
                                                <button type="button" class="btn btn-success generate-password"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Click to generate random password.">
                                                    <i class="fa-solid fa-key"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-12 text-center">
                                            <button class="btn btn-primary bg-gradient px-5 " type="button"
                                                id="updateBtn">Submit</button>
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

<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Select Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px; width: 100%;"></div>
                <!-- Loading overlay -->
                <div id="mapLoading"
                    style="display: none !important; position: absolute; top: 0; left: 0; 
                width: 100%; height: 100%; 
                background: rgba(255,255,255,0.7); 
                z-index: 10; 
                display: flex; 
                align-items: center; 
                justify-content: center;">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
                <button type="button" id="recenterMap" class="btn bg-white shadow-sm rounded-circle p-2"
                    style="position:absolute;right: 28px;bottom: 165px;height: 37px;width: 37px;"
                    data-tooltip="tooltip" title="Click to select current location">
                    <i class="fa-solid fa-location-crosshairs fs-5"></i>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal"
                    data-open="editModal" id="save-location-btn">Save Location</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#addExportExcelBtn').on('click', function() {
        var selectedIds = $('.add-test-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one test.');
            return;
        }

        $.ajax({
            url: "{{ route('tests.export') }}",
            method: 'POST',
            xhrFields: {
                responseType: 'blob' // important to handle binary file
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                test_ids: selectedIds
            },
            success: function(data, status, xhr) {
                var blob = new Blob([data], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);

                var disposition = xhr.getResponseHeader('Content-Disposition');
                var filename = 'tests.xlsx';
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/['"]/g, '');
                }

                link.download = filename;
                link.click();
                window.URL.revokeObjectURL(link.href);
            },
            error: function() {
                alert('Something went wrong while exporting the Excel file.');
            }
        });
    });
    $('#editExportExcelBtn').on('click', function() {
        var selectedIds = $('.edit-test-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one test.');
            return;
        }

        $.ajax({
            url: "{{ route('tests.export') }}",
            method: 'POST',
            xhrFields: {
                responseType: 'blob' // important to handle binary file
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                test_ids: selectedIds
            },
            success: function(data, status, xhr) {
                var blob = new Blob([data], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);

                var disposition = xhr.getResponseHeader('Content-Disposition');
                var filename = 'tests.xlsx';
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/['"]/g, '');
                }

                link.download = filename;
                link.click();
                window.URL.revokeObjectURL(link.href);
            },
            error: function() {
                alert('Something went wrong while exporting the Excel file.');
            }
        });
    });
    $(document).ready(function() {

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
        fetchLabs();

        function fetchLabs() {
            $('.loading').show();
            $.ajax({
                url: "{{ route('lab.list') }}",
                type: "GET",
                success: function(data) {
                    $('.loading').hide();
                    let rows = "";
                    $.each(data, function(index, lab) {
                        let lab_logo = (lab.lab_logo === 'NULL') ?
                            "{{ asset('backend/assets/img/team/avatar.png') }}" :
                            "{{ asset('/') }}" + lab.lab_logo;
                        let lab_status = (lab.status == 0) ? 'Pending' : (lab.status == 1) ?
                            'Approved' : 'Declined';
                        let lab_status_badge = (lab.status == 0) ? 'bg-warning' : (lab
                            .status == 1) ? 'bg-success' : 'bg-danger';
                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="labid">${lab.lab_id}</td>
                        <td class="labname">
                        <img class="rounded-circle shadow-sm me-1" src="${lab_logo}" alt="Lab Logo" style="height:26px;width:26px;"/>
                         ${lab.lab_name}
                        </td>
                        <td class="phone">${lab.phone}</td>
                        <td class="labtype">
                             ${JSON.parse(lab.lab_type || '[]').map(type => `<span class="badge btn-falcon-primary bg-gradient me-1">${type}</span>`).join('')}
                         </td>

                        <td class="date">${formatDate(lab.created_at)}</td>
                        <td class="status"><a href="javascript:void(0);" data-id="${lab.id}" class="badge ${lab_status_badge} change_lab_status">${lab_status}</a></td>
                        <td>
                            <div>
                                 <a class="btn btn-link p-0 " href="{{ url('/') }}/lab/${lab.lab_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${lab.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${lab.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${lab.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['labid', 'labname', 'labtype', 'date', 'phone'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Store
        $(document).ready(function() {
            var validator = $("#storeLab").validate({
                ignore: [],
                rules: {
                    lab_name: {
                        required: true,
                        minlength: 3
                    },
                    'lab_type[]': {
                        required: true
                    },
                    year_of_establishment: {
                        required: true,
                    },
                    operating_hours: {
                        required: true
                    },
                    primary_contact_name: {
                        required: true,
                        minlength: 3
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    street_address: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    postal_code: {
                        required: true,
                    },
                    country: {
                        required: true
                    },
                    'list_of_test_available[]': {
                        required: true
                    },
                    sample_collection: {
                        required: true
                    },
                    home_sample_collection: {
                        required: true
                    },
                    insurance_partner_accepted: {
                        required: true
                    },
                    lab_license: {
                        required: true,
                        extension: "pdf|jpg|jpeg|png"
                    },
                    lab_logo: {
                        required: true,
                        extension: "jpg|jpeg|png"
                    },
                    lab_description: {
                        required: true,
                    }
                },
                messages: {
                    lab_name: {
                        required: "lab name is required",
                        minlength: "lab name must be at least 3 characters"
                    },
                    'lab_type[]': {
                        required: "lab type is required"
                    },
                    year_of_establishment: {
                        required: "year of establishment is required"
                    },
                    operating_hours: {
                        required: "operating hours is required"
                    },
                    primary_contact_name: {
                        required: "primary contact name is required"
                    },
                    street_address: {
                        required: "street address is required"
                    },
                    city: {
                        required: "city is required"
                    },
                    state: {
                        required: "state is required"
                    },
                    postal_code: {
                        required: "postal code is required"
                    },
                    country: {
                        required: "country is required"
                    },
                    'list_of_test_available[]': {
                        required: "list of test availableis required"
                    },
                    sample_collection: {
                        required: "sample collection is required"
                    },
                    home_sample_collection: {
                        required: "home sample collection is required"
                    },
                    insurance_partner_accepted: {
                        required: "insurance partner accepted is required"
                    },
                    'list_of_accepted_insurance[s': {
                        required: "list of accepted insurances is required"
                    },
                    phone: {
                        required: "Phone number is required",
                        digits: "Only numbers are allowed",
                        minlength: "Phone number must be at least 10 digits",
                        maxlength: "Phone number cannot exceed 15 digits"
                    },
                    lab_license: {
                        required: "Lab license is required",
                        extension: "Only PDF, JPG, JPEG, or PNG files are allowed"
                    },
                    lab_logo: {
                        required: "Lab logo is required",
                        extension: "Only JPG, JPEG, or PNG files are allowed"
                    },
                    lab_description: {
                        required: "Lab description is required",
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

            $("#submitBtn").click(function(e) {
                e.preventDefault();

                if ($("#storeLab").valid()) {
                    $('.loading').show();
                    var form = $('#storeLab')[0];
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('lab.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('.loading').hide();
                            Swal.fire("Success!", response.success, "success");
                            form.reset();
                            fetchLabs();
                            $('#addModal').modal('hide');
                        },
                        error: function(xhr) {
                            $('.loading').hide();
                            console.log(xhr); // Shows the full error in console

                            let errorMessage = "An error occurred!";

                            // Check if backend sent a specific error message
                            if (xhr.responseJSON) {
                                // If backend sends 'error' key
                                if (xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                // If backend sends 'message' key (Laravel default)
                                else if (xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        }

                    });
                } else {
                    // Collect jQuery Validate errors
                    let validator = $("#storeLab").validate();
                    let errorList = validator.errorList;

                    if (errorList.length > 0) {
                        let errorHtml = "<ol class='text-start'>";
                        errorList.forEach(function(error) {
                            errorHtml += "<li class='text-danger'>" + error.message +
                                "</li>";
                        });
                        errorHtml += "</ol>";

                        Swal.fire({
                            icon: "error",
                            title: "Please fix the following errors:",
                            html: errorHtml
                        });
                    }
                }
            });
        });
        $(document).on('click', '.select-map-location', function(e) {

            e.preventDefault();

            selectedType = $(this).data('type');

            if (selectedType == 'add') {

                $('#addModal').modal('hide');

                $('#mapModal').modal('show');

                $('#save-location-btn').data('open', 'addModal');



            } else if (selectedType == 'edit') {

                $('#editModal').modal('hide');

                $('#mapModal').modal('show');

                $('#save-location-btn').data('open', 'editModal');
            }

            setTimeout(() => {

                initMap();

            }, 500);

        });
        $('#mapModal').on('shown.bs.modal', function() {

            initMap();

        });



        $(document).on('click', '[data-open]', function() {

            let target = $(this).data('open'); // e.g. "addAddressModal"

            let modalId = '#' + target;



            // Wait until mapModal fully closes, then open the next modal

            $('#mapModal').on('hidden.bs.modal', function() {

                $(modalId).modal('show');

                $(this).off('hidden.bs.modal'); // remove to prevent duplicate triggers

            });

        });


        // Edit
        // Open Edit Modal & Load Data
        $(document).on('click', '.edit-btn', function() {
            $('.loading').show();
            let labId = $(this).data('id');

            $.ajax({
                url: '/lab/' + labId + '/edit',
                type: 'GET',
                success: function(response) {
                    let lab = response.lab;
                    let user = response.lab.users[0];

                    // Example: Fill inputs
                    $('#edit_id').val(lab.id);
                    $('#edit_lab_name').val(lab.lab_name);
                    $('#edit_lab_registration_no').val(lab.lab_registration_no);
                    $('#edit_phone').val(user.phone);
                    $('#edit_alternate_phone').val(lab.alternate_phone);
                    $('#edit_landline').val(lab.landline);
                    $('#edit_email').val(user.email);
                    $('#edit_name').val(user.name);
                    $('#edit_username').val(user.username);
                    $('#edit_website_url').val(lab.website_url);
                    $('#edit_primary_contact_name').val(lab.primary_contact_name);
                    $('#edit_year_of_establishment').val(lab.year_of_establishment);
                    $('#edit_certification_type').val(lab.certification_type).trigger(
                        'change');

                    $('#edit_street_address').val(lab.street_address);
                    $('#edit_city').val(lab.city);
                    $('#edit_state').val(lab.state);
                    $('#edit_country').val(lab.country);
                    $('#edit_postal_code').val(lab.postal_code);
                    $('#edit_google_map_location').val(lab.google_map_location);
                    $('#edit_latitude').val(lab.latitude);
                    $('#edit_longitude').val(lab.longitude);
                    $('#edit_sample_collection').val(lab.sample_collection).trigger(
                        'change');
                    $('#edit_home_sample_collection').val(lab.home_sample_collection)
                        .trigger('change');
                    $('#edit_tat_for_reports').val(lab.tat_for_reports).trigger('change');
                    $('#edit_insurance_partner_accepted').val(lab
                        .insurance_partner_accepted).trigger('change');
                    // Set content only if TinyMCE editor exists and lab data is available
                    if (tinymce.get('edit_signatory_doctor_details') && lab
                        .signatory_doctor_details) {
                        tinymce.get('edit_signatory_doctor_details').setContent(lab
                            .signatory_doctor_details);
                    }

                    if (tinymce.get('edit_lab_description') && lab.lab_description) {
                        tinymce.get('edit_lab_description').setContent(lab.lab_description);
                    }


                    // Select Gender
                    $('input[name="gender"]').prop('checked', false); // Reset all options
                    if (user.gender) {
                        $('input[name="gender"][value="' + user.gender + '"]').prop(
                            'checked', true);
                    }
                    // Example: Select2/Choices or select multiple

                    initOrResetChoices('#edit_lab_type', 'editLabType', lab.lab_type);
                    initOrResetChoices('#edit_list_of_test_available', 'editTestList', lab
                        .list_of_test_available);


                    $('.day-checkbox').prop('checked', false);
                    $('.from-time').val('');
                    $('.to-time').val('');
                    $('.status').val('');

                    // Fill operating hours
                    if (lab.operating_hours && lab.operating_hours.length) {
                        lab.operating_hours.forEach(function(hour) {
                            let day = hour.day;

                            // Check the checkbox for that day
                            $('.' + day.toLowerCase()).prop('checked', true);

                            // Set from, to and status using data attributes
                            $('.from-time[data-day="' + day + '"]').val(hour
                                .from_time);
                            $('.to-time[data-day="' + day + '"]').val(hour.to_time);
                            $('.status[data-day="' + day + '"]').val(hour.status);
                        });
                    }
                    $('#editModal').modal('show');
                    $('.loading').hide();
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
        });






        // Update Lab AJAX
        $('#updateBtn').on('click', function(e) {
            e.preventDefault();
            $('.loading').show();
            tinymce.triggerSave();
            var labId = $('#edit_id').val(); // Make sure you have a hidden input with id="edit_id"
            var form = $('#updateLab')[0];
            var formData = new FormData(form);
            formData.append('_method', 'PUT');

            $.ajax({
                url: '/lab/' + labId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchLabs();
                    form.reset();
                    $('.loading').hide();
                },
                error: function(xhr) {
                    console.log(xhr);
                    let msg = xhr.responseJSON?.error || 'Something went wrong.';
                    Swal.fire("Error!", msg, "error");
                    $('.loading').hide();
                }
            });
        });


        // Delete 
        $(document).on('click', '.delete-btn', function() {
            let labId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the lab and all related users data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();

                    $.ajax({
                        url: `/lab/${labId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('.loading').hide();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "Lab and all related users data deleted successfully.",
                                    "success");
                                fetchLabs();
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

        $(document).on('click', '.change_lab_status', function(e) {
            e.preventDefault();
            let labId = $(this).data('id');
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
                        url: "{{ route('change.lab.status') }}",
                        method: 'POST',
                        data: {
                            lab_id: labId,
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
                                    'Lab status has been updated.', 'success');
                                // Update label and badge
                                $this.removeClass().addClass(
                                    `badge change_lab_status ${response.new_badge_class}`
                                );
                                $this.text(response.new_status_label);
                            } else {
                                Swal.fire('Error!', 'Failed to update status.',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            $('.loading').hide();
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
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