@extends('backend.includes.layout')

@section('content')

    <div class="card mb-3">

        <div class="card-header position-relative min-vh-25 mb-7">

            <div class="bg-holder rounded-3 rounded-bottom-0"

                style="background-image: url('{{ asset('backend/assets/img/generic/4.webp') }}')"></div>

            <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm"

                    src="{{ asset($vendor->profile ?? 'assets/img/user.png') }}" width="200" alt="" /></div>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-lg-8">

                    <h4 class="mb-1"> {{ $vendor->vendor_details?->company_name ?? 'Company Name' }} <span

                            data-bs-toggle="tooltip" data-bs-placement="right" title="Verified"><small

                                class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span>

                    </h4>

                    <p class="text-dark d-flex gap-2 align-content-center text-dark">

                        <span

                            class="fs-10 fw-normal badge badge-subtle-primary align-self-center">{{ $vendor->vendor_details?->business_type ?? 'Business Type' }}</span>

                        Establishment Year :

                        {{ $vendor->vendor_details?->establishment_year ? date('Y', strtotime($vendor->vendor_details?->establishment_year)) : '#' }}

                    </p>

                    <p class="text-900 mb-0"><img src="{{ asset('backend/assets/img/address.png') }}"

                            class="shadow-sm rounded-circle p-1 me-2" alt="Address" style="height: 35px;">

                        {{ $vendor->user_details->address ?? 'Address' }}, {{ $vendor->user_details->city ?? 'City' }},

                        {{ $vendor->user_details->state ?? 'State' }}, {{ $vendor->user_details->country ?? 'Country' }},

                        {{ $vendor->user_details->pin ?? 'Postal Code' }} </p>

                    <p class="text-900 mb-0"><img src="{{ asset('backend/assets/img/map_location.png') }}"

                            class="shadow-sm rounded-circle p-1 me-2" alt="Map Location" style="height: 35px;"> <a

                            href="{{ $vendor->user_details->google_map_location ?? 'javascript:void(0);' }}">{{ $vendor->user_details->google_map_location ?? 'Google map location not available!' }}</a>

                    </p>

                    <p class="text-900"><img src="{{ asset('backend/assets/img/blood_group.png') }}"

                            class="shadow-sm rounded-circle p-1 me-2" alt="Blood Group" style="height: 35px;">

                        {{ $vendor->blood_group ?? 'Blood group not available!' }}

                    </p>



                    <a class="btn btn-falcon-primary btn-sm" href="{{ url()->previous() }}">

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                    <button class="btn btn-falcon-primary btn-sm px-3 ms-2 edit-btn" type="button" data-id="{{$vendor->id}}">

                        <i class="fa-solid fa-pen-to-square"></i>

                    </button>

                    <div class="border-bottom border-dashed my-4 d-lg-none"></div>

                </div>

                <div class="col ps-2 ps-lg-3">

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-file-signature me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Contact Person</h6>

                            <p class="mb-0">{{ $vendor->name ?? 'N/A' }} / {{ $vendor->gender ?? 'N/A' }}</p>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-calendar-days me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">D.O.B</h6>

                            <p class="mb-0">

                                {{ $vendor->date_of_birth ? \Carbon\Carbon::parse($vendor->date_of_birth)->format('d F Y') : 'N/A' }}

                                / {{ $vendor->age ?? 'N/A' }} years old</p>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-envelope me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Email</h6>

                            <a href="mailto:{{ $vendor->email ?? '#' }}">{{ $vendor->email ?? 'N/A' }}</a>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-phone me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Phone</h6>

                            <a href="tel:{{ $vendor->phone ?? '#' }}">{{ $vendor->phone ?? 'N/A' }}</a>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-phone-volume me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Alternate Phone</h6>

                            <a

                                href="tel:{{ $vendor->user_details->alternate_phone ?? '#' }}">{{ $vendor->user_details->alternate_phone ?? 'N/A' }}</a>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <div class="row g-0">

        <div class="col-lg-8 pe-lg-2">

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">Account Settings</h5>

                </div>

                <div class="card-body fs-10 pb-0">

                    <div class="row">

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-user text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Username</a></h6>

                                    <p class="mb-1 text-900">{{ $vendor->username ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-lock text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Password</a></h6>

                                    <p class="mb-1 text-900"> {{ $vendor->show_password ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">Product Categories & Capabilities</h5>

                </div>

                <div class="card-body fs-10 pb-0">

                    <div class="row">

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2"><i

                                    class="fas fa-tags text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Primary Product Categories</a></h6>

                                    <p class="mb-1 text-900">{{ $vendor->vendor_details->primary_categories ?? 'N/A' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2"><i

                                    class="fas fa-sitemap text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Product Sub-Categories</a></h6>

                                    <p class="mb-1 text-900"> {{ $vendor->vendor_details->subcategories ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2"><i

                                    class="fas fa-tools text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Custom Equipment Manufacturing?</a></h6>

                                    <p class="mb-1 text-900">

                                        {{ $vendor->vendor_details->custom_equipment_manufacturing == 1 ? 'Yes' : 'No' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2"><i

                                    class="fas fa-industry text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">OEM/ODM Capabilities?</a></h6>

                                    <p class="mb-1 text-900">{{ $vendor->vendor_details->oem_odm_capabilities == 1 ? 'Yes' : 'No'  }}

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2"><i

                                    class="fas fa-sort-numeric-up text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">MOQ (Minimum Order Quantity)</a></h6>

                                    <p class="mb-1 text-900">{{ $vendor->vendor_details->moq ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2"><i

                                    class="fas fa-clock text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Lead Time for Manufacturing/Shipping</a></h6>

                                    <p class="mb-1 text-900">{{ $vendor->vendor_details->lead_time_days ?? 'N/A' }}</p>

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

                        <h5 class="mb-0">Legal & Compliance</h5>

                    </div>

                    <div class="card-body fs-10">

                        @if (!empty($vendor->vendor_details?->business_license))

                            <a href="{{ asset($vendor->vendor_details?->business_license) }}" target="_blank">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">Business License</h6>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($vendor->vendor_details?->msds_document))

                            <a href="{{ asset($vendor->vendor_details?->msds_document) }}" target="_blank">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">MSDS (Material Safety Data Sheet)</h6>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($vendor->vendor_details?->import_export_license))

                            <a href="{{ asset($vendor->vendor_details?->import_export_license) }}" target="_blank">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">Import/Export License

                                        </h6>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($vendor->vendor_details?->iso_certifications))

                            <a href="javascript:void(0);" class="text-decoration-none">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document2.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">ISO/Quality Certifications

                                        </h6>

                                        <p class="text-600">

                                            {{ $vendor->vendor_details?->iso_certifications }}

                                        </p>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($vendor->vendor_details?->environmental_certificates))

                            <a href="javascript:void(0);" class="text-decoration-none">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document2.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">Environmental Compliance Certificates

                                        </h6>

                                        <p class="text-600">

                                            {{ $vendor->vendor_details?->environmental_certificates }}

                                        </p>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

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

@endsection

@section('js')

    <script>

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

                        $('#preview_company_logo').attr('src', '/backend/assets/img/team/avatar.png');

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

                        $('#edit_google_map_location').val(details.google_map_location || '');

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

                        $('#edit_establishment_year').val(vendorDetails.establishment_year || '');

                        $('#edit_iso_certifications').val(vendorDetails.iso_certifications || '');

                        $('#edit_environmental_certificates').val(vendorDetails

                            .environmental_certificates || '');

                        $('#edit_primary_categories').val(vendorDetails.primary_categories || '');

                        $('#edit_subcategories').val(vendorDetails.subcategories || '');

                        $('#edit_custom_equipment_manufacturing').val(String(vendorDetails

                            .custom_equipment_manufacturing ?? '')).trigger('change');

                        $('#edit_oem_odm_capabilities').val(String(vendorDetails.oem_odm_capabilities ??

                            '')).trigger('change');

                        $('#edit_moq').val(vendorDetails.moq || '');

                        $('#edit_lead_time_days').val(vendorDetails.lead_time_days || '');



                        if (vendorDetails.business_license) {

                            $('#preview_business_license').attr('src', vendorDetails.business_license);

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

                            $('#preview_msds_document').attr('href', vendorDetails.msds_document);

                            $('#preview_msds_document').show();

                        } else {

                            $('#preview_msds_document').hide();

                        }



                    } else {

                        $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone')

                            .val('');

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

    </script>

@endsection

