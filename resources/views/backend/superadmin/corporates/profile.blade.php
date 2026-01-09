@extends('backend.includes.layout')

@section('css')

<style>

    .collapsed-description {

        max-height: 200px;

        overflow: hidden;

        transition: max-height 0.5s ease;

    }



    .expanded {

        max-height: none !important;

    }

</style>

@endsection

@section('content')

@php



@endphp

<div class="card mb-3">

    <div class="card-header position-relative min-vh-25 mb-7">

        <div class="bg-holder rounded-3 rounded-bottom-0"

            style="background-image:url({{ asset('backend/assets/img/generic/4.webp') }});">

        </div><!--/.bg-holder-->

        <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm"

                src="@if ($user->profile == 'dummy') {{ asset('backend/assets/img/team/avatar.png') }} @else {{ asset($user->profile) }} @endif"

                width="200" alt="" /></div>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-lg-8">

                <h4 class="mb-1">{{ $user->corporate_details->company_name }} <span data-bs-toggle="tooltip"

                        data-bs-placement="right" title="Verified"><small class="fa fa-check-circle text-primary"

                            data-fa-transform="shrink-4 down-2"></small></span></h4>

                <span class="fs-10 fw-bold text-dark">Company Registration No : </span>

                <span> {{ $user->corporate_details->company_reg_no ?? 'N/A'}}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Industry Type: </span>

                <span class="badge btn-falcon-primary me-1">{{ $user->corporate_details->industry_type ?? 'N/A' }}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Company Size: </span>

                <span class="badge btn-falcon-primary me-1">{{ $user->corporate_details->company_size ?? 'N/A' }}</span>

                <!-- <span class="text-muted">N/A</span> -->

                <br>

                @php

                $address = $user->user_details;

                $hasAddress = $address &&

                ($address->street_address || $address->city || $address->state || $address->country || $address->postal_code);

                @endphp



                <p class="mb-0">

                    <span class="fs-10 fw-bold text-dark">Address : </span>

                    @if ($hasAddress)

                    {{ $address->street_address ?? '' }}

                    {{ $address->city ? ', ' . $address->city : '' }}

                    {{ $address->state ? ', ' . $address->state : '' }}

                    {{ $address->country ? ', ' . $address->country : '' }}

                    {{ $address->postal_code ? ', ' . $address->postal_code : '' }}

                    @else

                    <span class="text-danger">No address found</span>

                    @endif

                </p>



                <span class="fs-10 fw-bold text-dark">Establishment Year : </span>

                <span>{{ $user->corporate_details->establishment_year ?? 'N/A' }}

                </span>

                <br>

                <br>

                <a class="btn btn-falcon-primary btn-sm" href="{{ url()->previous() }}"><i

                        class="fa-solid fa-arrow-left"></i></a>

                <button class="btn btn-falcon-primary btn-sm px-3 ms-2 edit-btn" type="button"

                    data-id="{{ $user->id ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>

                @if(auth()->user()->role == 0)

                <button

                    class="btn btn-falcon-danger btn-sm px-3 ms-2 delete-btn" type="button"

                    data-id="{{ $user->id ?? '' }}"><i class="fa-solid fa-trash-can"></i></button>

                <a class="btn btn-danger btn-sm px-3 ms-2" href="/corporate/{{$user->user_id}}/list">Employee List</a>

                @endif

                <div class="border-bottom border-dashed my-4 d-lg-none"></div>

            </div>

            <div class="col ps-2 ps-lg-3">

                <a class="d-flex align-items-center mb-2 text-decoration-none" href="javascript:void(0);"

                    style="cursor: default;">

                    <img src="{{ asset('backend/assets/img/id-card.png') }}" alt="" class="me-2"

                        height="32" data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Primary Contact Name</h6>

                        <span> {{ $user->name ?? '' }}</span>

                    </div>

                </a>

                <a class="d-flex align-items-center mb-2 text-decoration-none"

                    href="mailto:{{ $user->email ?? '' }}">

                    <img src="{{ asset('backend/assets/img/gmail.png') }}" alt="" class="me-2" height="30"

                        data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Email</h6>

                        <span> {{ $user->email ?? '' }}</span>

                    </div>

                </a>

                <a class="d-flex align-items-center mb-2 text-decoration-none" href="tel:{{ $user->phone ?? '' }}">

                    <img src="{{ asset('backend/assets/img/phone-call.png') }}" alt="" class="me-2"

                        height="30" data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Phone</h6>

                        <span> {{ $user->phone ?? '' }}</span>

                    </div>

                </a>

                <a class="d-flex align-items-center mb-2 text-decoration-none" href="{{ $user->website_url ?? '#' }}"

                    target="_blank">

                    <img src="{{ asset('backend/assets/img/chrome.png') }}" alt="" class="me-2"

                        height="30" data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Website URL</h6>

                        <span> {{ $user->corporate_details->website_url ?? '' }}</span>

                    </div>

                </a>

            </div>

        </div>

    </div>

</div>

<div class="row g-0">

    <div class="col-lg-8 pe-lg-2">

        <div class="card mb-3">

            <div class="card-header bg-body-tertiary d-flex justify-content-between">

                <h5 class="mb-0">Corporate Details</h5>

            </div>

            <div class="card-body fs-10 pb-0">

                <div class="row">

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/test-tube.png') }}" alt="" width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Preferred Payment Method</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $user->corporate_details->prefer_payment_method ?? 'N/A' }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/house-cleaning.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>No. of Employees for Test</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $user->corporate_details->no_of_emp_for_test ?? 'N/A' }}</p>

                            </div>

                        </div>

                    </div>



                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/research.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>On-Site Test</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $user->corporate_details->on_site_test ? 'Yes' : 'No' }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/health-care.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Home Sample Collection</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $user->corporate_details->home_sample_collection ? 'Yes' : 'No' }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/health-care.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Subscription Plan</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $user->corporate_details->subscription_plan  ? 'Yes' : 'No' }}</p>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

        <!-- <div class="card mb-3">

            <div class="card-header bg-body-tertiary d-flex justify-content-between">

                <h5 class="mb-0">Corporate Description</h5>

                <a class="font-sans-serif glightbox" href=""

                    data-gallery="gallery1" data-glightbox="data-glightbox">View License/Certificate</a>

            </div>



            <div class="card-body text-justify lab-description collapsed-description text-dark" id="lab-description">



            </div>



            <div class="card-footer bg-body-tertiary p-0 border-top">

                <button class="btn btn-link d-block w-100 btn-collapse-toggle" type="button"

                    data-target="lab-description">

                    <span class="toggle-text">

                        Show full <span class="fa fa-chevron-down ms-2 fs-11"></span>

                    </span>

                </button>

            </div>

        </div>



        <div class="card mb-3">

            <div class="card-header bg-body-tertiary d-flex justify-content-between">

                <h5 class="mb-0">Signatory Doctor Details</h5>

                <a class="font-sans-serif glightbox" href=""

                    data-gallery="gallery1" data-glightbox="data-glightbox">View License/Certificate</a>

            </div>



            <div class="card-body text-justify lab-description collapsed-description text-dark" id="doctor-details">



            </div>



            <div class="card-footer bg-body-tertiary p-0 border-top">

                <button class="btn btn-link d-block w-100 btn-collapse-toggle" type="button"

                    data-target="doctor-details">

                    <span class="toggle-text">

                        Show full <span class="fa fa-chevron-down ms-2 fs-11"></span>

                    </span>

                </button>

            </div>

        </div> -->

        <div class="card mb-3 mb-lg-0">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Photos/Documents</h5>

            </div>

            <div class="card-body overflow-hidden">

                <div class="row g-0">
                    @if(!empty($user->corporate_details->authorization_letter))
                    <div class="col p-1">

                        <a class="glightbox" href="{{ asset($user->corporate_details->authorization_letter) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($user->corporate_details->authorization_letter) }}" alt="..." />

                            <p class="btn btn-falcon-primary w-100">Authorization Letter</p>

                        </a>

                    </div>
                    @endif
                    @if(!empty($user->corporate_details->employee_list))
                    <div class="col p-1">

                        <a class="glightbox" href="{{ asset($user->corporate_details->employee_list) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($user->corporate_details->employee_list) }}"

                                alt="..." />

                            <p class="btn btn-falcon-primary w-100">Employee List</p>

                        </a>

                    </div>
                    @endif
                    @if(!empty($user->corporate_details->company_reg_cert))
                    <div class="col p-1">

                        <a class="glightbox" href="{{ asset($user->corporate_details->company_reg_cert) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($user->corporate_details->company_reg_cert) }}" alt="..." />

                            <p class="btn btn-falcon-primary w-100">Company Registration Certificate</p>

                        </a>

                    </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 ps-lg-2">

        <div class="sticky-sidebar">

            {{-- Subscription Plan & Payment Section --}}

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">Subscription Plan</h5>

                </div>

                <div class="card-body fs-10">

                    <p class="mb-2">

                        <strong>Plan:</strong> {{ $user->corporate_details->subscription_plan ?? 'N/A' }}

                    </p>

                    <p class="mb-2">

                        <strong>Preferred Payment:</strong> {{ $user->corporate_details->prefer_payment_method ?? 'N/A' }}

                    </p>

                    <p class="mb-2">

                        <strong>Bank Account:</strong> {{ $user->corporate_details->bank_account_no ?? 'N/A' }}

                    </p>

                    <p class="mb-2">

                        <strong>IFSC:</strong> {{ $user->corporate_details->ifsc ?? 'N/A' }}

                    </p>

                </div>

            </div>

            {{-- Authorized Contact Details --}}

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">Billing Contact</h5>

                </div>

                <div class="card-body fs-10">

                    <p class="mb-2">

                        <strong>Name:</strong> {{ $user->corporate_details->billing_contact_name ?? 'N/A' }}

                    </p>

                    <p class="mb-2">

                        <strong>Email:</strong> <a href="mailto:{{ $user->corporate_details->billing_contact_email }}">{{ $user->corporate_details->billing_contact_email ?? 'N/A' }}</a>

                    </p>

                    <p class="mb-2">

                        <strong>Company GST:</strong> {{ $user->corporate_details->company_gst ?? 'N/A' }}

                    </p>

                </div>

            </div>



            {{-- Testing Preferences --}}

            <div class="card mb-3 mb-lg-0">

                <div class="card-header bg-body-tertiary">

                    <h5 class="mb-0">Testing Preferences</h5>

                </div>

                <div class="card-body fs-10">

                    <p class="mb-2">

                        <strong>No. of Employees for Testing:</strong> {{ $user->corporate_details->no_of_emp_for_test ?? 'N/A' }}

                    </p>

                    <p class="mb-2">

                        <strong>On-site Test:</strong>

                        <span class="badge bg-{{ $user->corporate_details->on_site_test ? 'success' : 'danger' }}">

                            {{ $user->corporate_details->on_site_test ? 'Yes' : 'No' }}

                        </span>

                    </p>

                    <p class="mb-2">

                        <strong>Home Sample Collection:</strong>

                        <span class="badge bg-{{ $user->corporate_details->home_sample_collection ? 'success' : 'danger' }}">

                            {{ $user->corporate_details->home_sample_collection ? 'Yes' : 'No' }}

                        </span>

                    </p>

                    <p class="mb-2">

                        <strong>Frequency:</strong> {{ $user->corporate_details->frequency_of_testing ?? 'N/A' }}

                    </p>

                </div>

            </div>



        </div>

    </div>


    @if(!empty($user->user_details->google_map_location))
    <div class="col-lg-12">

        <div class="card my-3 mb-lg-0">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Google Map Location</h5>

            </div>

            <div class="card-body overflow-hidden w-100 map-frame">

                <style>

                    .map-frame iframe {

                        width: 100% !important;

                        height: 400px;

                        border: 0;

                    }

                </style>

                

                {!! $user->user_details->google_map_location !!}
                



            </div>

        </div>

    </div>
    @endif

</div>

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

                                            <img src="" id="preview_company_logo" alt="" height="50">

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

                                            <input class="form-control" id="edit_phone" name="phone" type="number"

                                                placeholder="Enter phone number" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_alternate_phone">Alternate Phone</label>

                                            <input class="form-control" id="edit_alternate_phone" name="alternate_phone"

                                                type="number" placeholder="Enter alternate phone number" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_email">Official Email Address

                                                (Optional)</label>

                                            <input class="form-control" id="edit_email" name="email" type="text"

                                                placeholder="Enter email" />

                                        </div>

                                    </div>



                                </div>

                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"

                                    aria-labelledby="bootstrap-wizard-tab11" id="bootstrap-wizard-tab11"

                                    data-wizard-form="11">

                                    <div class="row">

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_address">Street Address</label>

                                            <input class="form-control" id="edit_address" name="address" type="text"

                                                placeholder="Enter address" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_city">City</label>

                                            <input class="form-control" id="edit_city" name="city" type="text"

                                                placeholder="Enter city" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_state">State</label>

                                            <input class="form-control" id="edit_state" name="state" type="text"

                                                placeholder="Enter state" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_country">Country</label>

                                            <input class="form-control" id="edit_country" name="country" type="text"

                                                placeholder="Enter country" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_pin">Pin/Postal code</label>

                                            <input class="form-control" id="edit_pin" name="pin" type="text"

                                                placeholder="Enter pin/postal code" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_google_map_location">Google Map Location

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

                                            <label class="form-label" for="edit_no_of_emp_for_test">Number of Employees for

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

                                            <label class="form-label" for="edit_prefer_payment_method">Preferred Payment

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

                                            <input class="form-control" id="edit_bank_account_no" name="bank_account_no"

                                                type="number" placeholder="Enter Bank Account Number" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_ifsc">IFSC Code</label>

                                            <input class="form-control" id="edit_ifsc" name="ifsc" type="text"

                                                placeholder="Enter IFSC Code" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_subscription_plan">Subscription Plan (if

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

                                            <input class="form-control" id="edit_company_reg_cert" name="company_reg_cert"

                                                type="file"

                                                placeholder="Upload Company Registration Certificate" />

                                            <br>

                                            <a href="" id="preview_company_reg_cert">View</a>

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_employee_list">Employee List (for bulk

                                                testing) </label>

                                            <input class="form-control" id="edit_employee_list" name="employee_list"

                                                type="file" accept=".xlsx" placeholder="Upload Employee List" />

                                            <br>

                                            <a href="" id="preview_employee_list">View</a>

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="edit_authorization_letter">Authorization Letter

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

                        $('#edit_home_sample_collection').val(details.home_sample_collection || '');

                        $('#edit_frequency_of_testing').val(details.frequency_of_testing || '');

                        $('#edit_billing_contact_name').val(details.billing_contact_name || '');

                        $('#edit_billing_contact_email').val(details.billing_contact_email || '');

                        $('#edit_company_gst').val(details.company_gst || '');

                        $('#edit_prefer_payment_method').val(details.prefer_payment_method || '');

                        $('#edit_bank_account_no').val(details.bank_account_no || '');

                        $('#edit_ifsc').val(details.ifsc || '');

                        $('#edit_subscription_plan').val(details.subscription_plan || '');

                        if (details.company_reg_cert) {

                            $('#preview_company_reg_cert').attr('href', '/' + details.company_reg_cert).show();

                        }

                        if (details.employee_list) {

                            $('#preview_employee_list').attr('href', '/' + details.employee_list).show();

                        }

                        if (details.authorization_letter) {

                            $('#preview_authorization_letter').attr('href', '/' + details.authorization_letter)

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

    });

</script>

@endsection