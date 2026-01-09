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

$user = $lab->users->where('lab_user_role', 1)->first();

@endphp

<div class="card mb-3">

    <div class="card-header position-relative min-vh-25 mb-7">

        <div class="bg-holder rounded-3 rounded-bottom-0"

            style="background-image:url({{ asset('backend/assets/img/generic/4.webp') }});">

        </div><!--/.bg-holder-->

        <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm"

                src="@if ($lab->lab_logo == 'null') {{ asset('backend/assets/img/team/avatar.png') }} @else {{ asset($lab->lab_logo) }} @endif"

                width="200" alt="" /></div>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-lg-8">

                <h4 class="mb-1">{{ $lab->lab_name }} ({{ $lab->lab_id }}) <span data-bs-toggle="tooltip"

                        data-bs-placement="right" title="Verified"><small class="fa fa-check-circle text-primary"

                            data-fa-transform="shrink-4 down-2"></small></span></h4>



                <span class="fs-10 fw-bold text-dark">Lab Registration No : </span>

                <span>{{ $lab->lab_registration_no ?? 'N/A' }}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Lab Facilities: </span>

                @php

                $types = is_array($lab->lab_type) ? $lab->lab_type : json_decode($lab->lab_type, true);

                @endphp



                @if ($types)

                @foreach ($types as $type)

                <span class="badge btn-falcon-primary me-1">{{ $type }}</span>

                @endforeach

                @else

                <span class="text-muted">N/A</span>

                @endif

                <br>



                <p class="mb-0">

                    <span class="fs-10 fw-bold text-dark">Address : </span>

                    {{ $lab?->street_address ?? 'N/A' }},

                    {{ $lab?->city ?? 'N/A' }},

                    {{ $lab?->state ?? 'N/A' }},

                    {{ $lab?->country ?? 'N/A' }},

                    {{ $lab?->postal_code ?? 'N/A' }}

                </p>

                <span class="fs-10 fw-bold text-dark">Establishment Year : </span>

                <span>{{ \Carbon\Carbon::parse($lab->year_of_establishment)->format('d/m/Y') }}

                </span>

                <br>

                <br>

                <a class="btn btn-falcon-primary btn-sm" href="{{ url()->previous() }}"><i

                        class="fa-solid fa-arrow-left"></i></a>

                <button class="btn btn-falcon-primary btn-sm px-3 ms-2 edit-btn" type="button"

                    data-id="{{ $lab->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                <button

                    class="btn btn-falcon-danger btn-sm px-3 ms-2 delete-btn d-none" type="button"

                    data-id="{{ $lab->id }}"><i class="fa-solid fa-trash-can"></i></button>
                <a class="btn btn-falcon-primary btn-sm ms-2" href="{{ route('lab-profile', [\Illuminate\Support\Str::slug($lab->lab_name), encrypt($lab->lab_id)]) }}" target="_blank">

                    <i class="fa-solid fa-eye"></i>

                </a>

                <div class="border-bottom border-dashed my-4 d-lg-none"></div>

            </div>

            <div class="col ps-2 ps-lg-3">

                <a class="d-flex align-items-center mb-2 text-decoration-none" href="javascript:void(0);"

                    style="cursor: default;">

                    <img src="{{ asset('backend/assets/img/id-card.png') }}" alt="" class="me-2"

                        height="32" data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Primary Contact Name</h6>

                        <span>{{ $lab?->primary_contact_name ?? 'N/A' }}</span>

                    </div>

                </a>

                <a class="d-flex align-items-center mb-2 text-decoration-none"

                    href="mailto:{{ $lab?->email ?? 'N/A' }}">

                    <img src="{{ asset('backend/assets/img/gmail.png') }}" alt="" class="me-2" height="30"

                        data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Email</h6>

                        <span>{{ $lab?->email ?? 'N/A' }}</span>

                    </div>

                </a>

                <a class="d-flex align-items-center mb-2 text-decoration-none" href="tel:{{ $lab?->phone ?? 'N/A' }}">

                    <img src="{{ asset('backend/assets/img/phone-call.png') }}" alt="" class="me-2"

                        height="30" data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Phone</h6>

                        <span>{{ $lab?->phone ?? 'N/A' }}</span>

                    </div>

                </a>

                <a class="d-flex align-items-center mb-2 text-decoration-none" href="{{ $lab?->website_url ?? 'N/A' }}"

                    target="_blank">

                    <img src="{{ asset('backend/assets/img/chrome.png') }}" alt="" class="me-2"

                        height="30" data-fa-transform="grow-2">

                    <div class="flex-1">

                        <h6 class="mb-0 fw-bold">Website URL</h6>

                        <span>{{ $lab?->website_url ?? 'N/A' }}</span>

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

                <h5 class="mb-0">Lab Details</h5>

            </div>

            <div class="card-body fs-10 pb-0">

                <div class="row">

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/test-tube.png') }}" alt="" width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Sample Collection for Corporate</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $lab->sample_collection }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/house-cleaning.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Home Sample Collection</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $lab->home_sample_collection }}</p>

                            </div>

                        </div>

                    </div>



                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/research.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Turnaround Time for Reports</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $lab->tat_for_reports }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <div class="d-flex position-relative align-items-center mb-2"><img

                                class="d-flex align-self-center me-2 rounded-3"

                                src="{{ asset('backend/assets/img/health-care.png') }}" alt=""

                                width="50" />

                            <div class="flex-1">

                                <h6 class="fs-9 mb-0"><span>Insurance Partners Accepted ?</span></h6>

                                <p class="mb-1 text-dark fw-bold">{{ $lab->insurance_partner_accepted }}</p>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

        <div class="card mb-3">

            <div class="card-header bg-body-tertiary d-flex justify-content-between">

                <h5 class="mb-0">Lab Description</h5>

                <a class="font-sans-serif glightbox" href="{{ asset($lab->lab_license ?? 'N/A') }}"

                    data-gallery="gallery1" data-glightbox="data-glightbox">View License/Certificate</a>

            </div>



            <div class="card-body text-justify lab-description collapsed-description text-dark" id="lab-description">

                {!! $lab->lab_description !!}

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

                <a class="font-sans-serif glightbox" href="{{ asset($lab->doctor_license ?? 'N/A') }}"

                    data-gallery="gallery1" data-glightbox="data-glightbox">View License/Certificate</a>

            </div>



            <div class="card-body text-justify lab-description collapsed-description text-dark" id="doctor-details">

                {!! $lab->signatory_doctor_details ?? 'N/A' !!}

            </div>



            <div class="card-footer bg-body-tertiary p-0 border-top">

                <button class="btn btn-link d-block w-100 btn-collapse-toggle" type="button"

                    data-target="doctor-details">

                    <span class="toggle-text">

                        Show full <span class="fa fa-chevron-down ms-2 fs-11"></span>

                    </span>

                </button>

            </div>

        </div>





        <div class="card mb-3 mb-lg-0">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Photos/Documents</h5>

            </div>

            <div class="card-body overflow-hidden">

                <div class="row g-0">
                    @if (!empty($lab->lab_logo))
                    <div class="col-2 p-1">

                        <a class="glightbox" href="{{ asset($lab->lab_logo) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($lab->lab_logo) }}" alt="..." />

                            <p class="btn btn-falcon-primary w-100">Lab Logo</p>

                        </a>

                    </div>
                    @endif
                    @if (!empty($lab->accreditation_details))
                    <div class="col-2 p-1">

                        <a class="glightbox" href="{{ asset($lab->accreditation_details) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($lab->accreditation_details) }}"

                                alt="..." />

                            <p class="btn btn-falcon-primary w-100">Accreditation Details</p>

                        </a>

                    </div>
                    @endif
                    @if (!empty($lab->lab_license))
                    <div class="col-2 p-1">

                        <a class="glightbox" href="{{ asset($lab->lab_license) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($lab->lab_license) }}" alt="..." />

                            <p class="btn btn-falcon-primary w-100">Lab License</p>

                        </a>

                    </div>
                    @endif
                    @if (!empty($lab->doctor_license))
                    <div class="col-2 p-1">

                        <a class="glightbox" href="{{ asset($lab->doctor_license) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($lab->doctor_license) }}" alt="..." />

                            <p class="btn btn-falcon-primary w-100">Doctor License</p>

                        </a>

                    </div>
                    @endif

                    @if (!empty($lab->certification))

                    <div class="col-2 p-1">

                        <a class="glightbox" href="{{ asset($lab->certification) }}" data-gallery="gallery1"

                            data-glightbox="data-glightbox">

                            <img class="img-fluid rounded" src="{{ asset($lab->certification) }}"

                                alt="..." />

                            <p class="btn btn-falcon-primary w-100">{{ $lab->certification_type }}</p>

                        </a>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 ps-lg-2">

        <div class="sticky-sidebar">

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">Available Tests ( {{ $lab->lab_tests->count() }} )</h5>

                    <a data-bs-toggle="modal" data-bs-target="#testsModal" class="font-sans-serif cursor-pointer">

                        <i class="fa-solid fa-eye"></i> View All

                    </a>

                </div>

            </div>

            <div class="card mb-3">

                <div class="card-header bg-body-tertiary d-flex justify-content-between">

                    <h5 class="mb-0">Lab Users ({{ count($lab->users) }})</h5>

                    <a class="font-sans-serif" href="javascript:void(0);" id="addModalBtn"><i

                            class="fa-solid fa-plus"></i> Add</a>

                </div>

                <div class="card-body fs-10" style="max-height: 450px;overflow-y: scroll;">

                    @foreach ($lab->users as $lab_user)

                    <div class="d-flex mb-3">

                        <a href="{{ route('lab.user.profile', encrypt($lab_user->user_id)) }}">

                            <img class="img-fluid border border-primary border-2 rounded-circle"

                                src="@if ($lab_user->profile == 'dummy') {{ asset('backend/assets/img/team/avatar.png') }} @else {{ asset($lab_user->profile) }} @endif"

                                alt="" width="56" />

                        </a>



                        <div class="flex-1 position-relative ps-3">

                            <h6 class="fs-9 mb-0">{{ $lab_user->name }} ({{ $lab_user->user_id }})</h6>

                            <p class="mb-1">

                                <a href="{{ route('lab.user.profile', encrypt($lab_user->user_id)) }}">

                                    @php

                                    $roles = [1 => 'Admin', 2 => 'Manager', 3 => 'Technician'];

                                    echo $roles[$lab_user->lab_user_role] ?? 'Unknown';

                                    @endphp

                                </a>

                            </p>

                            <p class="text-dark mb-0">

                                <span class="fs-10">Phone : </span> {{ $lab_user?->phone ?? 'N/A' }}<br>

                                <span class="fs-10">Username : </span> {{ $lab_user?->username ?? 'N/A' }}<br>



                            <div class="d-flex align-items-center">

                                <span class="fs-10 me-2 text-dark">Password : </span>



                                <input type="password" class="border-0 w-50 lab-password"

                                    value="{{ $lab_user?->show_password ?? 'N/A' }}" readonly

                                    style="outline: none; box-shadow: none; border-color: transparent;">



                                <button type="button"

                                    class="btn btn-sm btn-outline-secondary ms-2 toggle-password">

                                    <i class="fas fa-eye"></i>

                                </button>

                            </div>

                            </p>



                            <div class="border-bottom border-dashed my-3"></div>

                        </div>

                    </div>

                    @endforeach



                </div>

            </div>



            <div class="card mb-3 mb-lg-0">

                <div class="card-header bg-body-tertiary">

                    <h5 class="mb-0">Operating Hours</h5>

                </div>

                <div class="card-body fs-10">

                    @foreach ($lab->operating_hours as $hour)

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
    @if (!empty($lab->google_map_location))
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
                {!! $lab->google_map_location !!}
            </div>

        </div>

    </div>

</div>
@endif
<div class="modal fade" id="testsModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg"><!-- lg = wider -->

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">All Tests ({{ $lab->lab_tests->count() }})</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>



            <div class="modal-body" style="max-height:70vh;overflow-y:auto;">

                @forelse($lab->lab_tests as $index => $test)

                <div class="d-flex align-items-center my-2">

                    <span class="me-3 fw-bold">{{ $index + 1 }}</span>



                    <div class="me-3">

                        <div class="rounded-circle bg-light border border-primary border-1">

                            <img src="{{ asset('backend/assets/img/test-icon.png') }}" alt=""

                                height="35">

                        </div>

                    </div>



                    <div class="flex-grow-1">

                        <h6 class="mb-0">

                            {{ $test->test_name ?? 'Unnamed Package' }}

                        </h6>



                        {{-- Prices --}}

                        <div class="small text-muted mt-1">

                            <span class="me-3">

                                <i class="fa-solid fa-tag me-1"></i>

                                Standard Price: <strong>₹{{ number_format($test->standard_price, 2) }}</strong>

                            </span>

                            <span>

                                <i class="fa-solid fa-briefcase me-1"></i>

                                Corporate Price: <strong>₹{{ number_format($test->corporate_price, 2) }}</strong>

                            </span>

                        </div>

                        {{-- If you want prices etc. add them here --}}

                    </div>

                </div>

                @unless ($loop->last)

                <hr class="my-0">

                @endunless

                @empty

                <p class="text-muted mb-0">No tests available.</p>

                @endforelse

            </div>

        </div>

    </div>

</div>

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

                                                <option value="">-- Select --</option>

                                                @foreach ($facilities as $facility)

                                                <option value="{{ $facility->facility }}">

                                                    {{ $facility->facility }}
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

                                            <input class="form-control" id="edit_name" name="name" type="text"

                                                placeholder="Enter admin name" />

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

<!-- Add Lab user Modal Start -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog mt-6 modal-xl" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add User</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new user.</p>

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

                                                    class="fa-solid fa-1"></i></span></span></a></li>

                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"

                                        data-bs-toggle="tab" data-wizard-step="2"><span

                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i

                                                    class="fa-solid fa-2"></i></span></span></a>

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

                                            <label class="form-label" for="name">Name</label>

                                            <input class="form-control" id="name" name="name" type="text"

                                                placeholder="Enter name" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="phone">Phone</label>

                                            <input class="form-control" id="phone" name="phone" type="number"

                                                placeholder="Enter phone number" />

                                        </div>

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="email">Email (Optional)</label>

                                            <input class="form-control" id="email" name="email" type="text"

                                                placeholder="Enter email" />

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

                                            <label class="form-label">Upload Image (Optional)</label>

                                            <input class="form-control" id="profile" name="profile"

                                                type="file" />

                                        </div>



                                        <div class="mb-3 col-6">

                                            <label class="form-label">Role</label>

                                            <select class="form-select" name="lab_user_role" id="lab_user_role">

                                                <option value="">-- Select --</option>

                                                <option value="1">Admin</option>

                                                <option value="2">Manager</option>

                                                <option value="3">Technician</option>

                                                <option value="4">Phlebotomist</option>

                                            </select>

                                        </div>



                                    </div>

                                </div>

                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"

                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"

                                    data-wizard-form="2">

                                    <div class="row">

                                        <div class="mb-3 col-6">

                                            <label class="form-label" for="address">Address</label>

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

                                            <label class="form-label" for="username">Username</label>

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

                                        <input type="hidden" name="lab_id" id="lab_id"

                                            value="{{ $lab->lab_id }}">

                                        <div class="mb-3 col-12 text-center">

                                            <button class="btn btn-primary bg-gradient px-5 " type="button"

                                                id="submitLabUserBtn">Submit</button>

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

<!-- Add Lab User Modal End -->

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
    document.addEventListener('DOMContentLoaded', function() {

        const toggleButtons = document.querySelectorAll('.toggle-password');



        toggleButtons.forEach(button => {

            button.addEventListener('click', function() {

                const input = this.previousElementSibling;

                const icon = this.querySelector('i');



                if (input.type === 'password') {

                    input.type = 'text';

                    icon.classList.remove('fa-eye');

                    icon.classList.add('fa-eye-slash');

                } else {

                    input.type = 'password';

                    icon.classList.remove('fa-eye-slash');

                    icon.classList.add('fa-eye');

                }

            });

        });

    });



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
</script>

<script>
    $(document).ready(function() {

        $('#addModalBtn').on('click', function() {

            $('#addModal').modal('show');

        });

        var choicesInstances = {};



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

                            if (hour.day) { // check if day exists

                                let day = hour.day;



                                // Check the checkbox for that day

                                $('.' + day.toLowerCase()).prop('checked', true);



                                // Set from, to and status using data attributes

                                $('.from-time[data-day="' + day + '"]').val(hour

                                    .from_time || '');

                                $('.to-time[data-day="' + day + '"]').val(hour

                                    .to_time || '');

                                $('.status[data-day="' + day + '"]').val(hour

                                    .status || '');

                            } else {

                                console.warn(

                                    "Missing day in operating_hours entry:",

                                    hour);

                            }

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

        $(document).on('click', '.select-map-location', function(e) {

            e.preventDefault();

            selectedType = $(this).data('type');

            if (selectedType == 'add') {

                $('#editModal').modal('hide');

                $('#mapModal').modal('show');

                $('#save-location-btn').data('open', 'editModal');



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



        function initOrResetChoices(id, key, selectedValues = []) {

            const $element = document.querySelector(id);

            if (!$element) return;



            // Destroy existing Choices instance if exists

            if (choicesInstances[key]) {

                choicesInstances[key].destroy();

                delete choicesInstances[key];

            }



            // Store original options

            const originalOptions = Array.from($element.options);



            // Clear the select

            $element.innerHTML = '';



            // Re-append all options, only mark selected if value is not empty

            originalOptions.forEach(opt => {

                const option = document.createElement('option');

                option.value = opt.value;

                option.text = opt.text;



                if (opt.value !== '' && selectedValues.includes(opt.value)) {

                    option.selected = true;

                }



                $element.appendChild(option);

            });



            // Re-init Choices

            choicesInstances[key] = new Choices($element, {

                removeItemButton: true,

                placeholder: true,

                allowHTML: true,

                shouldSort: false,

            });

            // console.log(`✅ [${key}] set with:`, selectedValues);

        }









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

                    form.reset();

                    $('.loading').hide();

                    window.location.reload();

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

                    password: "Password is required",

                    gender: "Gender is required",

                    profile: {

                        extension: "Only JPG, JPEG, PNG, or GIF files are allowed",

                        filesize: "Profile image must be less than 2MB"

                    }

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

                    var formData = new FormData(form);

                    $.ajax({

                        url: "{{ route('lab.user.store') }}",

                        type: "POST",

                        data: formData,

                        contentType: false,

                        processData: false,

                        success: function(response) {

                            $('.loading').hide();

                            Swal.fire("Success!", response.success, "success");

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



            // ✅ Submit form on button click

            $('#submitLabUserBtn').on('click', function() {

                if ($("#storeUser").valid()) {

                    $("#storeUser").submit(); // Triggers jQuery Validate's submitHandler

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

    });
</script>

@endsection