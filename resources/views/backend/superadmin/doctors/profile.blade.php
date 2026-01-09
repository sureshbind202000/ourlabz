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

    <div class="card mb-3">

        <div class="card-header position-relative min-vh-25 mb-7">

            <div class="bg-holder rounded-3 rounded-bottom-0"

                style="background-image: url('{{ asset('backend/assets/img/generic/4.jpg') }}')"></div>

            <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm"

                    src="{{ asset($doctor->profile ?? 'assets/img/user.png') }}" width="200" alt="" /></div>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-lg-8">

                    <h4 class="mb-1">

                        {{ $doctor->name ?? 'Name' }} <span

                            class="fs-10 fw-normal text-dark">({{ $doctor->doctor_details?->year_of_experience }}

                            Years)</span>

                        <span data-bs-toggle="tooltip" data-bs-placement="right" title="Verified">

                            <small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small>

                        </span>

                    </h4>

                    @if (!empty($doctor->doctor_details?->medical_license_number))

                        <span class="fs-10 fw-bold text-dark">License No : </span>

                        <span>{{ $doctor->doctor_details->medical_license_number }}</span>

                        <br>

                    @endif

                    @if (!empty($doctor->doctor_details?->license_issue_authority))

                        <span class="fs-10 fw-bold text-dark">License Issue Authority : </span>

                        <span>{{ $doctor->doctor_details->license_issue_authority }}</span>

                        <br>

                    @endif

                    <span class="fs-10 fw-bold text-dark">Qualifications : </span>

                    @php

                        $qualificationsRaw = $doctor->doctor_details?->qualification ?? [];

                        $qualifications = is_string($qualificationsRaw)

                            ? json_decode($qualificationsRaw, true)

                            : $qualificationsRaw;

                    @endphp



                    @foreach ($qualifications as $qualification)

                        <span class="badge btn-falcon-primary me-1">{{ $qualification }}</span>

                    @endforeach



                    <br>

                    <span class="fs-10 fw-bold text-dark">Specialization : </span>

                    @php

                        $specializationsRaw = $doctor->doctor_details?->specialization ?? [];

                        $specializations = is_string($specializationsRaw)

                            ? json_decode($specializationsRaw, true)

                            : $specializationsRaw;

                    @endphp



                    @if (!empty($specializations) && count($specializations) > 0)

                        @foreach ($specializations as $specialization)

                            <span class="badge btn-falcon-primary me-1">{{ $specialization }}</span>

                        @endforeach

                    @else

                        <span class="text-muted">No specializations</span>

                    @endif





                    <br>

                    @if (!empty($doctor->doctor_details?->price))

                        <span class="fs-10 fw-bold text-dark">Consultation Fee : </span>

                        <span>₹{{ $doctor->doctor_details?->price }}</span>

                    @endif

                    <br>

                    @if (!empty($doctor->doctor_details?->consultation_type))

                        <span class="fs-10 fw-bold text-dark">Consultation Type : </span>

                        <span class="badge btn-falcon-primary me-1">{{ $doctor->doctor_details?->consultation_type == 'Both' ? 'Online | Offline' : $doctor->doctor_details?->consultation_type}}</span>

                    @endif



                    @php

                        $address = $doctor->user_details;

                        $hasAddress =

                            $address &&

                            ($address->street_address ||

                                $address->city ||

                                $address->state ||

                                $address->country ||

                                $address->postal_code);

                    @endphp



                    <p class="mb-0">

                        <span class="fs-10 fw-bold text-dark">Address : </span>

                        @if ($hasAddress)

                            {{ $address->address ?? '' }}

                            {{ $address->city ? ', ' . $address->city : '' }}

                            {{ $address->state ? ', ' . $address->state : '' }}

                            {{ $address->country ? ', ' . $address->country : '' }}

                            {{ $address->postal_code ? ', ' . $address->postal_code : '' }}

                        @else

                            <span class="text-danger">No address found</span>

                        @endif

                    </p>



                    <br>

                    {{-- Buttons --}}

                    <a class="btn btn-falcon-primary btn-sm" href="{{ url()->previous() }}">

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                    <button class="btn btn-falcon-primary btn-sm px-3 ms-2 edit-btn" type="button"

                    data-id="{{ $doctor->id }}">

                    <i class="fa-solid fa-pen-to-square"></i>

                </button>

                <a class="btn btn-falcon-primary btn-sm ms-2" href="{{ route('doctor.details', ['id' => encrypt($doctor->id)]) }}" target="_blank">

                    <i class="fa-solid fa-eye"></i>

                </a>

                    <div class="border-bottom border-dashed my-4 d-lg-none"></div>

                </div>



                <div class="col ps-2 ps-lg-3">

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-file-signature me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Contact Person</h6>

                            <p class="mb-0">{{ $doctor->name ?? 'N/A' }} / {{ $doctor->gender ?? 'N/A' }}</p>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-calendar-days me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">D.O.B</h6>

                            <p class="mb-0">

                                {{ $doctor->date_of_birth ? \Carbon\Carbon::parse($doctor->date_of_birth)->format('d F Y') : 'N/A' }}

                                / {{ $doctor->age ?? 'N/A' }} years old

                            </p>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-envelope me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Email</h6>

                            <a href="mailto:{{ $doctor->email ?? '#' }}">{{ $doctor->email ?? 'N/A' }}</a>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-phone me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Phone</h6>

                            <a href="tel:{{ $doctor->phone ?? '#' }}">{{ $doctor->phone ?? 'N/A' }}</a>

                        </div>

                    </div>

                    <div class="d-flex align-items-center mb-2" href="#">

                        <i class="fa-solid fa-droplet me-2 align-self-start fs-8 text-primary"></i>

                        <div class="flex-1">

                            <h6 class="mb-0">Blood Group</h6>

                            <a href="javascript:void(0);">{{ $doctor->blood_group ?? 'N/A' }}</a>

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

                                    <p class="mb-1 text-900">{{ $doctor->username ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-lock text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Password</a></h6>

                                    <p class="mb-1 text-900"> {{ $doctor->show_password ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-phone text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Alternate Phone</a></h6>

                                    <a

                                        href="tel:{{ $doctor->doctor_details->alternate_phone ?? '#' }}">{{ $doctor->doctor_details->alternate_phone ?? 'N/A' }}</a>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-user text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Emergency Contact Name</a></h6>

                                    <p class="mb-1 text-900"> {{ $doctor->user_details->emergency_contact_name ?? 'N/A' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-phone text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Emergency Contact Number</a></h6>

                                    <p class="mb-1 text-900">

                                        {{ $doctor->user_details->emergency_contact_phone ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-building text-primary me-3 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Clinic Name</a></h6>

                                    <p class="mb-1 text-900">

                                        {{ $doctor->doctor_details->affiliated_hospital_clinic_name ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 mb-3">

                            <div class="d-flex position-relative align-items-center mb-2">

                                <i class="fas fa-map-pin text-primary me-4 fs-5"></i>

                                <div class="flex-1">

                                    <h6 class="fs-9 mb-0"><a class="stretched-link text-decoration-none text-dark"

                                            href="javascript:void(0);">Clinic Address</a></h6>

                                    <p class="mb-1 text-900">

                                        {{ $doctor->doctor_details->hospital_clinic_address ?? 'N/A' }}</p>

                                </div>

                            </div>

                        </div>



                    </div>



                </div>

            </div>

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">About</h5>

                </div>



                <div class="card-body text-justify lab-description collapsed-description text-dark" id="lab-description">

                    {!! $doctor->doctor_details->about ?? '' !!}

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



        </div>
        <div class="col-lg-4 ps-lg-2">
            
            <div class="sticky-sidebar">
                
                @if (!empty($doctor->doctor_details?->medical_degree_certificate) || !empty($doctor->doctor_details?->medical_license) || !empty($doctor->doctor_details?->id_proof) || !empty($doctor->doctor_details?->iso_certifications) || !empty($doctor->doctor_details?->environmental_certificates))
                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h5 class="mb-0">Documents</h5>

                    </div>

                    <div class="card-body fs-10">

                        @if (!empty($doctor->doctor_details?->medical_degree_certificate))

                            <a href="{{ asset($doctor->doctor_details?->medical_degree_certificate) }}" target="_blank">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">Medical Degree Certificate</h6>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($doctor->doctor_details?->medical_license))

                            <a href="{{ asset($doctor->doctor_details?->medical_license) }}" target="_blank">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">Medical License</h6>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($doctor->doctor_details?->id_proof))

                            <a href="{{ asset($doctor->doctor_details?->id_proof) }}" target="_blank">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">ID Proof

                                        </h6>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($doctor->doctor_details?->iso_certifications))

                            <a href="javascript:void(0);" class="text-decoration-none">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document2.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">ISO/Quality Certifications

                                        </h6>

                                        <p class="text-600">

                                            {{ $doctor->doctor_details?->iso_certifications }}

                                        </p>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                        @if (!empty($doctor->doctor_details?->environmental_certificates))

                            <a href="javascript:void(0);" class="text-decoration-none">

                                <div class="d-flex align-items-center"> <img class="img-fluid"

                                        src="{{ asset('backend/assets/img/document2.png') }}" alt=""

                                        width="40" />

                                    <div class="flex-1 position-relative ps-3">

                                        <h6 class="fs-9 mb-0">Environmental Compliance Certificates

                                        </h6>

                                        <p class="text-600">

                                            {{ $doctor->doctor_details?->environmental_certificates }}

                                        </p>

                                    </div>

                                </div>

                            </a>

                            <div class="border-bottom border-dashed my-3"></div>

                        @endif

                    </div>

                </div>
                @endif
                @if(!empty($doctor->doctor_details?->account_number))
                <div class="card mb-3">

                    <div class="card-header bg-body-tertiary">

                        <h5 class="mb-0">Account Information</h5>

                    </div>

                    <div class="card-body fs-10">

                        <p class="mb-2">

                            <strong>Account Holder Name:</strong>

                            {{ $doctor->doctor_details?->account_holder_name }}

                        </p>

                        <p class="mb-2">

                            <strong>Account Number:</strong>

                            {{ $doctor->doctor_details?->account_number }}

                        </p>

                        <p class="mb-2">

                            <strong>IFSC Code:</strong>

                            {{ $doctor->doctor_details?->ifsc_code }}

                        </p>

                        <p class="mb-2">

                            <strong>UPI Id:</strong>

                            {{ $doctor->doctor_details?->upi_id }}

                        </p>

                        <p class="mb-2">

                            <strong>GSTIN:</strong>

                            {{ $doctor->doctor_details?->tin }}

                        </p>

                    </div>

                </div>
                @endif

                <div class="card mb-3 mb-lg-0">

                    <div class="card-header bg-body-tertiary">

                        <h5 class="mb-0">Operating Hours</h5>

                    </div>

                    <div class="card-body fs-10">

                        @foreach ($doctor->operating_hours as $hour)

                            <div class="d-flex align-items-start mb-2">

                                <div class="me-3 mt-1">

                                    <i class="fa fa-calendar-days fs-5 text-secondary"></i> {{-- Bootstrap Icons --}}

                                </div>

                                <div class="flex-1">

                                    <span class="fw-bold text-dark">{{ $hour['day'] }}</span><br>

                                    @if ($hour['status'] == 'Open')

                                        <span class="text-dark">

                                            {{ \Carbon\Carbon::createFromFormat('H:i', $hour['from_time'])->format('h:i A') }}

                                            -

                                            {{ \Carbon\Carbon::createFromFormat('H:i', $hour['to_time'])->format('h:i A') }}

                                        </span>

                                    @endif

                                    @if ($hour['status'] == 'Open')

                                        <span class="badge bg-success ms-2">{{ $hour['status'] }}</span>

                                    @else

                                        <span class="badge bg-danger">{{ $hour['status'] }}</span>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>



            </div>

        </div>
       @if (!empty($doctor->user_details->google_map_location))
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

                    

                        {!! $doctor->user_details->google_map_location !!}

                    

                </div>

            </div>

        </div>
        @endif

    </div>



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

                                                <label class="form-label" for="edit_medical_license_number">Medical

                                                    License Number</label>

                                                <input class="form-control" id="edit_medical_license_number"

                                                    name="medical_license_number" type="text"

                                                    placeholder="Enter Medical License Number" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_license_issue_authority">License

                                                    Issuing Authority</label>

                                                <select name="license_issue_authority" id="edit_license_issue_authority"

                                                    class="form-select">

                                                    <option value="">--select--</option>

                                                    <option value="MCI">MCI</option>

                                                    <option value="State Medical Council">State Medical Council</option>

                                                </select>

                                            </div>



                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_specialization">Specialization</label>

                                                <select name="specialization[]" id="edit_specialization"

                                                    class="form-select" multiple="multiple" size="1"

                                                    >

                                                    <option value="">--select--</option>

                                                    @foreach ($speciality as $s)

                                                        <option value="{{ $s->speciality }}">{{ $s->speciality }}

                                                        </option>

                                                    @endforeach

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

                                                <label class="form-label" for="edit_year_of_experience">Years of

                                                    Experience</label>

                                                <input class="form-control" id="edit_year_of_experience"

                                                    name="year_of_experience" type="number" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label"

                                                    for="edit_affiliated_hospital_clinic_name">Affiliated Hospital/Clinic

                                                    Name </label>

                                                <input class="form-control" id="edit_affiliated_hospital_clinic_name"

                                                    name="affiliated_hospital_clinic_name" type="text"

                                                    placeholder="Enter Affiliated Hospital/Clinic Name " />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label"

                                                    for="edit_hospital_clinic_address">Hospital/Clinic Address </label>

                                                <input class="form-control" id="edit_hospital_clinic_address"

                                                    name="hospital_clinic_address" type="text"

                                                    placeholder="Enter Hospital/Clinic Address " />

                                            </div>



                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_consultation_type">Consultation

                                                    Type</label>

                                                <select name="consultation_type" id="edit_consultation_type"

                                                    class="form-select">

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

                                                <label class="form-label" for="edit_account_number">Bank Account

                                                    Number</label>

                                                <input class="form-control" id="edit_account_number"

                                                    name="account_number" type="number"

                                                    placeholder="Enter Bank Account Number" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_ifsc_code">IFSC Code</label>

                                                <input class="form-control" id="edit_ifsc_code" name="ifsc_code"

                                                    type="text" placeholder="Enter IFSC Code" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_account_holder_name">Account Holder

                                                    Name</label>

                                                <input class="form-control" id="edit_account_holder_name"

                                                    name="account_holder_name" type="text"

                                                    placeholder="Enter Account Holder Name" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_upi_id">UPI ID (Optional)</label>

                                                <input class="form-control" id="edit_upi_id" name="upi_id"

                                                    type="text" placeholder="Enter UPI ID" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_tin">Tax Identification Number

                                                    (TIN/GST if applicable)</label>

                                                <input class="form-control" id="edit_tin" name="tin" type="text"

                                                    placeholder="Enter Tax Identification Number" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_price">Consultation Fee</label>

                                                <input class="form-control" id="edit_price" name="price" type="number" step="0.01"

                                                    placeholder="Enter Consultation Fee" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"

                                        aria-labelledby="bootstrap-wizard-tab15" id="bootstrap-wizard-tab15"

                                        data-wizard-form="15">

                                        <div class="row">

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_medical_degree_certificate">Medical

                                                    Degree Certificate</label>

                                                <input class="form-control" id="edit_medical_degree_certificate"

                                                    name="medical_degree_certificate" type="file"

                                                    placeholder="Upload Medical Degree Certificate" />

                                                <br>

                                                <a href="" target="_blank"

                                                    id="medical_degree_certificate_preview">View</a>

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_medical_license">Medical

                                                    License/Registration Certificate</label>

                                                <input class="form-control" id="edit_medical_license"

                                                    name="medical_license" type="file"

                                                    placeholder="Upload Medical Degree Certificate" />

                                                <br>

                                                <a href="" target="_blank" id="medical_license_preview">View</a>

                                            </div>

                                            <div class="mb-3 col-6 ">

                                                <div class="input-group">

                                                    <label class="form-label" for="edit_id_proof">Government ID

                                                        Proof</label>

                                                    <label class="form-label ms-auto" for="edit_id_type">ID Type</label>

                                                </div>



                                                <div class="input-group">

                                                    <input class="form-control w-75" id="edit_id_proof" name="id_proof"

                                                        type="file" />

                                                    <select name="id_type" id="edit_id_type" class="form-select w-25">

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

    <!-- Edit Doctor Modal End -->

@endsection

@section('js')

    <script>

        document.addEventListener('DOMContentLoaded', function() {

            const toggleButtons = document.querySelectorAll('.btn-collapse-toggle');



            toggleButtons.forEach(button => {

                const targetId = button.getAttribute('data-target');

                const target = document.getElementById(targetId);

                const toggleText = button.querySelector('.toggle-text');



                button.addEventListener('click', () => {

                    target.classList.toggle('expanded');



                    if (target.classList.contains('expanded')) {

                        toggleText.innerHTML =

                            'Show less <span class="fas fa-chevron-up ms-2 fs-11"></span>';

                    } else {

                        toggleText.innerHTML =

                            'Show full <span class="fas fa-chevron-down ms-2 fs-11"></span>';

                    }

                });

            });

        });

    </script>

    <script>

        $(document).ready(function() {

            // Edit

            // Open Edit Modal & Load Data

            $(document).on('click', '.edit-btn', function() {

                $('.loading').show();

                let doctorId = $(this).data('id');

                console.log(doctorId);

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

                            $('#edit_medical_license_number').val(details

                                .medical_license_number || '');

                            $('#edit_license_issue_authority').val(details

                                .license_issue_authority || '');

                            initOrResetChoices('#edit_specialization', 'editSpecialization',details.specialization);

                            initOrResetChoices('#edit_qualification', 'editQualification',details.qualification);

                            $('#edit_year_of_experience').val(details.year_of_experience || '');

                            $('#edit_affiliated_hospital_clinic_name').val(details.affiliated_hospital_clinic_name || '');

                            $('#edit_hospital_clinic_address').val(details

                                .hospital_clinic_address || '');

                            $('#edit_consultation_type').val(details.consultation_type || '');

                            $('#edit_account_number').val(details.account_number || '');

                            $('#edit_ifsc_code').val(details.ifsc_code || '');

                            $('#edit_account_holder_name').val(details.account_holder_name ||

                                '');

                            $('#edit_upi_id').val(details.upi_id || '');

                            $('#edit_tin').val(details.tin || '');
                            $('#edit_price').val(details.price || '');

                            $('#edit_id_type').val(details.id_type || '');

                            if (details.medical_degree_certificate) {

                                $('#medical_degree_certificate_preview').attr('href', '/' +

                                    details.medical_degree_certificate).show();

                            }

                            if (details.medical_license) {

                                $('#medical_license_preview').attr('href', '/' + details

                                    .medical_license).show();

                            }

                            if (details.id_proof) {

                                $('#id_proof_preview').attr('href', '/' + details.id_proof)

                                    .show();

                            }

                            if (tinymce.get('edit_about') && details.about) {

                                tinymce.get('edit_about').setContent(details.about);

                            }

                        }



                        $('.day-checkbox').prop('checked', false);

                        $('.from-time').val('');

                        $('.to-time').val('');

                        $('.status').val('');



                        // Fill operating hours

                        if (doctor.doctor_operating_hours && doctor.doctor_operating_hours

                            .length) {

                            doctor.doctor_operating_hours.forEach(function(hour) {

                                let day = hour.day;



                                if (day && typeof day === 'string') {

                                    $('.' + day.toLowerCase()).prop('checked', true);



                                    $('.from-time[data-day="' + day + '"]').val(hour

                                        .from_time);

                                    $('.to-time[data-day="' + day + '"]').val(hour

                                        .to_time);

                                    $('.status[data-day="' + day + '"]').val(hour

                                        .status);

                                }

                            });



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

