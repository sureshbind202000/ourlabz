@extends('backend.includes.layout')

@section('css')

    <style>
.prescription-card {
    transition: all 0.25s ease;
    border-radius: 12px;
}

.prescription-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.08);
}

.prescription-card img {
    background: #f8f9fa;
    padding: 6px;
}

        .tracking-header {

            background: linear-gradient(to right, #00c6ff7a, #0072ff6e);

            color: white;

            text-align: center;

            align-content: center;

            border: 5px groove #00b2ff;

            border-radius: 10px;

        }



        .tracking-header h2 {

            margin-bottom: 10px;

        }



        .timeline-steps {

            position: relative;

            padding: 20px 15px;

        }



        .step {

            position: relative;

            display: flex;

            align-items: center;

            margin-bottom: 20px;

        }



        .step:last-child::before {

            content: none;

        }



        .step::before {

            content: '';

            position: absolute;

            top: 25px;

            left: 19px;

            height: calc(100% + 15px);

            width: 3px;

            background: linear-gradient(to right, #00c6ff, #0072ff);

            z-index: 0;

        }



        .icon-wrapper {

            width: 40px;

            height: 40px;

            background: linear-gradient(to right, #00c6ff, #0072ff);

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 20px;

            margin-right: 20px;

            flex-shrink: 0;

            z-index: 1;

            /* box-shadow: 0 0 10px rgba(0, 114, 255, 0.3); */

            transition: background 0.3s, color 0.3s;

        }



        .step-content {

            flex: 1;

            z-index: 1;

        }



        .step-content h5 {

            margin: 0;

            font-weight: 600;

            font-size: 14px;

        }



        .step-content small {

            color: #6c757d;

        }



        .step.active .icon-wrapper {

            background: linear-gradient(to right, #00c6ff, #0072ff);

            /* box-shadow: 0 0 10px rgba(40, 167, 69, 0.5); */

        }



        .step.inactive .icon-wrapper {

            background: white;

            color: #666;

            box-shadow: none;

            border: 2px solid rgba(0, 114, 255, 0.6);

        }



        .step.inactive .step-content h5,

        .step.inactive .step-content small {

            color: #aaa;

        }



        .step.last-active .icon-wrapper {

            position: relative;

            z-index: 1;

            animation: pop-glow 1.5s ease-in-out infinite;

        }



        .step.last-active .icon-wrapper::before {

            content: '';

            position: absolute;

            top: 50%;

            left: 50%;

            width: 100%;

            height: 100%;

            background: rgba(0, 114, 255, 0.3);

            border-radius: 50%;

            transform: translate(-50%, -50%) scale(1);

            z-index: -1;

            animation: spread-layer 1.5s ease-in-out infinite;

        }



        @keyframes spread-layer {

            0% {

                transform: translate(-50%, -50%) scale(1);

                opacity: 0.6;

            }



            70% {

                transform: translate(-50%, -50%) scale(1.8);

                opacity: 0;

            }



            100% {

                transform: translate(-50%, -50%) scale(1.8);

                opacity: 0;

            }

        }



        @keyframes pop-glow {



            0%,

            100% {

                box-shadow: 0 0 15px rgba(0, 114, 255, 0.6);

            }



            50% {

                box-shadow: 0 0 25px rgba(0, 114, 255, 1);

            }

        }

    </style>

@endsection

@section('content')

    <div class="row g-3">

        <div class="col-xxl-12 col-xl-12">

            <div class="card">

                <div class="card-header d-flex flex-between-center">

                    <a href="{{ url()->previous() }}" class="btn btn-falcon-default btn-sm">

                        <span class="fas fa-arrow-left"></span>

                    </a>



                    <div class="d-flex">
                        @if($details->status != 'Completed' && $details->status != 'Cancelled')
                        <button class="btn btn-falcon-primary btn-sm mx-2 refer-lab-btn" type="button"

                            data-bs-toggle="tooltip" data-bs-placement="top" title="Refer Tests to another Lab Note:- If you refer test before assign phlebotomist status will not reflect (Status will reflect after assigning the phlebotomist).">

                            <i class="fa-solid fa-microscope" data-fa-transform="shrink-2 down-2"></i>

                            <span class="d-none d-md-inline-block ms-1">Refer to another lab</span>

                        </button>

                        <button class="btn btn-falcon-success btn-sm mx-2 barcode-btn" type="button"

                            data-bs-toggle="tooltip" data-bs-placement="top" title="Click to generate test barcode.">

                            <i class="fa-solid fa-barcode" data-fa-transform="shrink-2 down-2"></i>

                            <span class="d-none d-md-inline-block ms-1">Generate Barcode</span>

                        </button>

                        <button type="button" class="btn btn-success mb-3 d-none" data-bs-toggle="modal"

                            data-bs-target="#barcode-scan-modal" onclick="startBarcodeScanner()">

                            <i class="bi bi-upc-scan"></i> Scan Barcode

                        </button>
                        @endif
                    </div>

                </div>

            </div>

            <div class="card my-3">

                <div class="card-header bg-body-tertiary">

                    <h5><i class="fa-solid fa-file-lines me-2"></i><span>Booking Details</span></h5>

                </div>



                <div class="card-body">



                    <div class="row">

                        <div class="col-auto col-sm-4  border-end">

                            <p class="mb-1 text-dark fs-10"><b>Order ID:</b>

                                {{ $details->order_id }}</p>

                            <p class="mb-1 text-dark fs-10"><b>Sample Collection : </b>

                                @if ($details->sample_collection == '1')

                                    <span class="badge bg-success">Yes</span>

                                @elseif($details->sample_collection == '0')

                                    <span class="badge bg-success">No</span>

                                @endif

                            </p>

                            <p class="mb-1 text-dark fs-10">

                                <b>Booking : </b> {!! getBookingStatusBadge($details->status) !!}

                            </p>

                            <p class="mb-1 text-dark fs-10">

                                <b>Payment : </b> {!! getPaymentBadge($details->payment_status) !!}



                            </p>



                        </div>

                        <div class="col-auto col-sm-4  border-end">

                            <p class="mb-1 text-dark fs-10"><b>Date : </b>

                                {{ \Carbon\Carbon::parse($details->booking_date)->format('d M, Y') }}</p>

                            <p class="mb-1 text-dark fs-10"><b>Time Slot : </b> {{ $details->time_slot }}</p>



                            @php

                                $address = App\Models\UserAddress::find($details->address);

                            @endphp

                            <p class="mb-1 text-dark fs-10"><b>Address : </b>

                                {{ $address->address }}, {{ $address->city }}, {{ $address->state }},

                                {{ $address->country }}, {{ $address->pin }}

                            </p>

                            <p class="mb-1 text-dark fs-10"><b>Google Map Location : </b>

                                <a href="{{ $address->google_map_location }}" target="_blank">{{ $address->google_map_location }}</a>

                            </p>

                        </div>

                        <div class="col-auto col-sm-4 align-content-center">

                            <div class="tracking-header d-flex justify-content-center align-items-center py-2 mb-3 gap-4">

                                <p class="assigned-info d-none text-dark text-start mb-0 fs-10"></p>



                                <p class="mb-0">

                                    <img src="{{ asset('backend/assets/img/phlebotomist_icon.png') }}"

                                        alt="phlebotomist icon" class="img-fluid" style="height: 50px;">

                                </p>

                            </div>
                            @if($details->status != 'Completed' && $details->status != 'Cancelled')
                            <div class="d-flex gap-2">

                                <button type="button" class="w-100 btn btn-sm btn-falcon-primary assign-phlebotomist-btn"

                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Click to assign Phlebotomist.">

                                    Assign Phlebotomist

                                </button>

                                <button type="button"

                                    class="w-100 btn btn-sm btn-falcon-success phlebotomist-live-tracking"

                                    data-bs-toggle="tooltip" data-bs-placement="top"

                                    title="Click to view live tracking of phlebotomist.">

                                    Live Tracking

                                </button>

                            </div>
                            @endif
                        </div>



                    </div>



                </div>

            </div>

            <div class="d-flex my-4"><span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i

                        class="fa-inverse fa-stack-1x text-primary fas fa-users"></i></span>

                <div class="col">

                    <h5 class="mb-0 text-primary position-relative"><span

                            class="bg-200 dark__bg-1100 pe-3">Patients</span><span

                            class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span>

                    </h5>



                </div>

            </div>

            <div class="accordion" id="accordionPanelsStayOpenExample">

                @php

                    // Prepare sample map: [test_id-patient_id] => sample

                    $sampleMap = [];

                    foreach ($details->trackSamples as $sample) {

                        $sampleMap[$sample->test_id . '-' . $sample->patient_id] = $sample;

                    }

                @endphp



                @foreach ($details->patients as $patient)

                    @php

                        $patientTests = $details->tests->where('booking_patient_id', $patient->id);

                        $testNames = $patientTests->pluck('package.name')->filter()->join(', ');



                        // Fetch first sample linked to any of the patient's tests

                            $sample = null;

                            foreach ($patientTests as $pt) {

                                $key = $pt->id . '-' . $patient->id;

                            if (isset($sampleMap[$key])) {

                                $sample = $sampleMap[$key];

                                break;

                            }

                        }

                    @endphp



                    <div class="accordion-item mb-2">

                        <h2 class="accordion-header">

                            <button class="accordion-button collapsed text-primary gap-2" type="button"

                                data-bs-toggle="collapse" data-bs-target="#collapse-{{ $patient->id }}"

                                aria-expanded="false" aria-controls="collapse-{{ $patient->id }}">

                                <i class="fa-solid fa-hospital-user me-2"></i> {{ $patient->name }} -

                                {{ $testNames ?: 'No test found' }} :

                                {{ $sample ? getSampleStatus($sample->status) : 'N/A' }}

                                @php

                                    $refer_test = \App\Models\ReferedTest::where(

                                        'refered_test_id',

                                        $sample->test_id ?? null,

                                    )->first();

                                    $refer_lab_name = $refer_test

                                        ? \App\Models\lab::where('lab_id', $refer_test->refered_lab_id)->first()

                                        : null;

                                @endphp



                                @if ($refer_test && $refer_lab_name)

                                    <small class="text-muted ms-2">

                                        (Referred to: {{ $refer_lab_name->lab_name }} {{ $refer_lab_name->lab_id }})

                                    </small>

                                @endif



                            </button>

                        </h2>

                        <div id="collapse-{{ $patient->id }}" class="accordion-collapse collapse">

                            <div class="accordion-body">

                                <div class="row">

                                    <div class="col-md-4 fs-10 text-dark border-end">

                                        <p class="border-bottom pb-2"><strong>Patient Information <i

                                                    class="fas fa-arrow-turn-down"></i></strong></p>

                                        <p class="mb-0"><strong>Phone:</strong> {{ $patient->phone }}</p>

                                        <p class="mb-0"><strong>Email:</strong> {{ $patient->email }}</p>

                                        <p class="mb-0"><strong>DOB:</strong> {{ $patient->dob }}</p>

                                        <p class="mb-0"><strong>Age:</strong> {{ $patient->age }} yrs</p>

                                        <p class="mb-0"><strong>Relation:</strong> {{ $patient->relation }}</p>

                                        <p class="mb-0"><strong>Prescription:</strong>
                                            @if($patient->prescription)
                                                <a href="{{ asset($patient->prescription) }}" target="_blank" rel="noopener noreferrer">
                                                    View Prescription
                                                </a>
                                            @else
                                                No Prescription Uploaded
                                            @endif
                                        </p>

                                    </div>



                                    <div class="col-md-4 fs-10 text-dark border-end">

                                        <p class="border-bottom pb-2"><strong>Sample <i

                                                    class="fas fa-arrow-turn-down"></i></strong></p>

                                        <p>

                                            <strong>Status - </strong>

                                            {{ $sample ? getSampleStatus($sample->status) : 'N/A' }}

                                            <br>

                                            @if ($sample)

                                                @if ($sample->status >= 1)

                                                    @if (!empty($sample->sample_image) && is_array($sample->sample_image))

                                                        <strong>Images:</strong>

                                                        <div class="d-flex flex-wrap gap-2 mt-2">

                                                            @foreach ($sample->sample_image as $img)

                                                                <a href="{{ asset($img) }}" class="glightbox"

                                                                    data-gallery="gallery{{ $sample->id }}"

                                                                    data-bs-toggle="tooltip"

                                                                    title="Click to view collected sample image">

                                                                    <img src="{{ asset($img) }}" alt="Sample Image"

                                                                        style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px;">

                                                                </a>

                                                            @endforeach

                                                        </div>

                                                    @endif



                                                    @if ($sample->status == 4 || $sample->status == 5)

                                                        <br>

                                                        <strong>Reason :</strong> <small> {{ $sample->reason }}</small>

                                                    @endif

                                                   

                                                    @if ($sample->sample_image !== 'N/A' && $sample->status < 5 && $details->status != 'Completed')

                                                     <br>

                                                    <strong>Sample Controls - </strong>

                                                    <br>

                                                    <br>

                                                        <div class="btn-group">

                                                            @if ($sample->status >= 1 && $sample->status != 3)

                                                                <button

                                                                    class="btn btn-outline-success btn-sm accept-sample"

                                                                    data-sample-id="{{ $sample->id }}"

                                                                    data-bs-toggle="tooltip" data-bs-placement="top"

                                                                    title="Accept Sample"><i

                                                                        class="fas fa-check"></i></button>

                                                            @endif

                                                            @if ($sample->status >= 1)

                                                                <button class="btn btn-outline-danger btn-sm reject-sample"

                                                                    data-sample-id="{{ $sample->id }}"

                                                                    data-bs-toggle="tooltip" data-bs-placement="top"

                                                                    title="Reject Sample"><i

                                                                        class="fas fa-xmark"></i></button>

                                                            @endif

                                                        </div>

                                                    @endif

                                                @endif

                                            @else

                                                No sample uploaded.

                                            @endif

                                        </p>

                                    </div>



                                    <div class="col-md-4 fs-10 text-dark">

                                        <p class="border-bottom pb-2"><strong>Report <i

                                                    class="fas fa-arrow-turn-down"></i></strong></p>



                                        @foreach ($patientTests as $test)

                                            <p>

                                                <strong>Verify Report - </strong>



                                                @if (!empty($test->report_file))

                                                    <span class="text-muted">

                                                        @if ($test->verify === 'Verified' && $test->verify_id)

                                                            Report verified by

                                                            <strong>{{ \App\Models\User::find($test->verify_id)?->name ?? 'Unknown Doctor' }}</strong>

                                                        @else

                                                            Report not verified.

                                                        @endif

                                                    </span>

                                                @else

                                                    <span class="text-muted">No report file uploaded.</span>

                                                @endif



                                                <br>



                                                <strong>Certify Report - </strong>



                                                @if (!empty($test->report_file))

                                                    <span class="text-muted">

                                                        @if ($test->certify === 'Certified' && $test->certify_id)

                                                            Report certified by

                                                            <strong>{{ \App\Models\User::find($test->certify_id)?->name ?? 'Unknown Doctor' }}</strong>

                                                        @else

                                                            Report not certified.

                                                        @endif

                                                    </span>

                                                @else

                                                    <span class="text-muted">No report file uploaded.</span>

                                                @endif

                                                <br>

                                                <strong>Forwarding - </strong>

                                                @if (!empty($test->fwd_id))

                                                    @php

                                                        $doctor = App\Models\User::find($test->fwd_id);

                                                    @endphp

                                                    <span class="text-muted">Report forwarded to

                                                        <strong>{{ $doctor->name }}</strong></span>

                                                @else

                                                    <span class="text-muted">No report forward to any doctor.</span>

                                                @endif

                                                <br>

                                                <br>

                                                <strong class="pb-0">Report Controls - </strong>

                                                <br>

                                                <br>

                                                @if (!empty($test->report_file))

                                                    <a href="{{ asset($test->report_file) }}" target="_blank"

                                                        class="btn btn-sm btn-falcon-success" data-bs-toggle="tooltip"

                                                        title="Download Report">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                    @if (empty($test->fwd_id))

                                                        <a href="{{ asset($test->report_file) }}" target="_blank"

                                                            class="btn btn-sm btn-falcon-primary ms-1 fwd-report-btn"

                                                            data-id="{{ $test->id }}" data-bs-toggle="tooltip"

                                                            title="Forward report to doctor (Verify/Certify).">

                                                            <i class="fa-solid fa-share-from-square"></i>

                                                        </a>

                                                    @elseif($details->status != 'Completed' && $details->status != 'Cancelled')
                                                        
                                                        <a href="{{ asset($test->report_file) }}" target="_blank"

                                                            class="btn btn-sm btn-falcon-primary ms-1 fwd-report-btn"

                                                            data-id="{{ $test->id }}" data-bs-toggle="tooltip"

                                                            title="Report already forwarded. Click to change the doctor.">

                                                            <i class="fa-solid fa-share-from-square"></i>

                                                        </a>
                                                       
                                                    @endif
                                                    @if($details->status != 'Completed' && $details->status != 'Cancelled')
                                                    <a href="javascript:void(0);" target="_blank"

                                                        class="btn btn-sm btn-falcon-danger ms-1 delete-report-btn"

                                                        data-id="{{ $test->id }}" data-bs-toggle="tooltip"

                                                        title="Delete Report">

                                                        <i class="fa-solid fa-trash"></i>

                                                    </a>
                                                    @endif

                                                @elseif($details->status != 'Cancelled')

                                                    <button type="button"

                                                        class="btn btn-sm btn-falcon-primary upload-report-btn"

                                                        data-bs-toggle="tooltip" title="Upload Report"

                                                        data-patient_id="{{ $patient->id }}">

                                                        <i class="fa-solid fa-upload"></i>

                                                    </button>

                                                @endif

                                            </p>

                                        @endforeach

                                    </div>

                                </div>



                            </div>

                        </div>

                    </div>

                @endforeach

            </div>



            <div class="card mt-3">

                <div class="card-header fw-bold bg-body-tertiary bg-gradient text-dark">Activity Logs</div>

                <div class="card-body" style="overflow-y: scroll;max-height: 600px;scrollbar-width: thin;">

                    @forelse ($logs as $log)

                        <p>

                            <strong>{{ $log->action }}</strong> <br>

                            {{ $log->description }} <br>

                            <small class="text-muted">

                                by {{ $log->user->name ?? 'System' }} on {{ $log->created_at->format('d M Y h:i A') }}

                            </small>

                        </p>

                        <hr>

                    @empty

                        <p>No activity logs.</p>

                    @endforelse

                </div>

            </div>

        </div>



    </div>

    <div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel"

        aria-hidden="true">

        <div class="modal-dialog">

            <form id="rejectReasonForm">

                @csrf

                <input type="hidden" name="sample_id" id="reject_sample_id">

                <input type="hidden" name="status" value="4">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Reject Sample</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <div class="form-group">

                            <label for="reason">Reason for Rejection</label>

                            <textarea name="reason" id="reject_reason" rows="4" class="form-control" required></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-danger">Submit Rejection</button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- Verify Report Modal -->

    <div class="modal fade" id="verifyReportModal" tabindex="-1" aria-labelledby="verifyReportModalLabel"

        aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">View & Verify Report</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <iframe id="reportPdfFrame" src="" width="100%" height="600px"

                        style="border: none;"></iframe>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-success" id="confirmVerifyBtn" data-test-id="">Verify</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!-- Certify Report Modal -->

    <div class="modal fade" id="certifyReportModal" tabindex="-1" aria-labelledby="certifyReportModalLabel"

        aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">View & Certify Report</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <iframe id="reportPdfFrame2" src="" width="100%" height="600px"

                        style="border: none;"></iframe>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-success" id="confirmCertifyBtn"

                        data-test-id="">Certify</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!-- Upload reportModal -->

    <div class="modal fade" id="upload-report-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">

            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"

                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">

                        <h4 class="mb-1">Upload Report</h4>

                    </div>

                    <div class="p-4">

                        <div class="row g-3">

                            <!-- Auto Upload Card -->

                            <div class="col-md-6">

                                <div class="card h-100 shadow-sm  text-center upload-option bg-success-subtle"

                                    data-type="auto" style="cursor: pointer;">

                                    <div class="card-body">

                                        <img src="{{ asset('backend/assets/img/auto_report.png') }}" alt="Auto Upload"

                                            class="img-fluid mb-2" style="max-height: 100px;">

                                        <h6 class="fw-semibold mt-2">Auto Upload</h6>

                                    </div>

                                </div>

                            </div>



                            <!-- Manual Upload Card -->

                            <div class="col-md-6">

                                <div class="card h-100 shadow-sm  text-center upload-option bg-primary-subtle"

                                    data-type="manual" style="cursor: pointer;">

                                    <div class="card-body">

                                        <img src="{{ asset('backend/assets/img/manual_report.png') }}"

                                            alt="Manual Upload" class="img-fluid mb-2" style="max-height: 100px;">

                                        <h6 class="fw-semibold mt-2">Manual Upload</h6>

                                    </div>

                                </div>

                            </div>



                        </div>



                        <!-- Hidden Upload Input Box -->

                        <div class="mt-4 d-none" id="manual-upload-box">

                            <input type="hidden" id="patient_id" name="patient_id">

                            <label for="manual-report" class="form-label">Upload Report File <span

                                    class="text-primary">(Upload PDF file without header & footer only.)</span></label>

                            <input type="file" class="form-control mb-3" id="manual-report" name="report_file">

                            <button class="btn btn-sm btn-falcon-primary" id="upload-manual-report-btn">Upload</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Fwd report to doctor --}}

    <div class="modal fade" id="fwd-report-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">

            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"

                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">

                        <h4 class="mb-1">Forward report to doctor</h4>

                    </div>

                    <div class="p-4">

                        <select name="staffDoctor" id="staffDoctor" class="form-select mb-4">

                            <option value="">--select doctor--</option>

                            @foreach ($doctors as $doctor)

                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>

                            @endforeach

                        </select>



                        <input type="hidden" id="fwd_test_id" name="fwd_test_id">

                        <!-- Hidden Upload Input Box -->



                        <button class="btn btn-sm btn-falcon-primary" id="submit-to-doctor">Submit</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Assign phlebotomist Modal --}}

    <div class="modal fade" id="assign-phlebotomist-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">

            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"

                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">

                        <h4 class="mb-1">Assign Phlebotomist</h4>

                    </div>

                    <div class="p-4">

                        <form id="store-sample-tracking" class="row">

                            <div class="form-group mb-3 col-12">

                                <label for="phlebotomist_id">Select Phlebotomist <span

                                        class="text-danger">*</span></label>

                                <select name="phlebotomist_id" id="phlebotomist_id" class="form-control js-choice w-100"

                                    data-options='{"removeItemButton":true,"placeholder":true}' required>

                                    <option value="">--select--</option>

                                    @foreach ($lab_phlebotomist as $phlebotomist)

                                        <option value="{{ $phlebotomist->user_id }}">{{ $phlebotomist->name }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <label>Select Patients and Tests <span class="text-danger">*</span></label>

                                <div class="border rounded p-2" style="max-height: 250px; overflow-y: auto;">

                                    @foreach ($details->patients as $index => $patient)

                                        <div class="mb-2">

                                            <strong>{{ $patient->name }}</strong>

                                            <div class="ms-3">

                                                @foreach ($details->tests->where('booking_patient_id', $patient->id) as $test)

                                                    <div class="form-check">

                                                        <input class="form-check-input" type="checkbox"

                                                            name="assignments[]"

                                                            id="assign_{{ $patient->id }}_{{ $test->id }}"

                                                            value="{{ $patient->id }}_{{ $test->id }}">

                                                        <label class="form-check-label"

                                                            for="assign_{{ $patient->id }}_{{ $test->id }}">

                                                            {{ $test->package->name }}

                                                        </label>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <label for="note">Note <span class="text-danger">*</span></label>

                                <textarea name="note" id="note" rows="3" class="form-control"

                                    placeholder="Type note for phlebotomist..." required></textarea>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <input type="hidden" name="booking_id" value="{{ $details->id }}">

                                <input type="hidden" id="booking_user_id" name="booking_user_id"

                                    value="{{ $details->user_id }}">

                                <input type="hidden" id="booking_order_id" name="booking_order_id"

                                    value="{{ $details->order_id }}">

                                <button type="submit" class="btn btn-primary bg-gradient w-100">Assign</button>

                            </div>



                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Refer Test Modal --}}

    <div class="modal fade" id="refer-lab-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">

            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"

                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">

                        <h4 class="mb-1">Refer tests To another lab</h4>

                    </div>

                    <div class="p-4">

                        <form id="store-refered-test" class="row">

                            @csrf

                            <div class="form-group mb-3 col-12">

                                <label>Select Refering Lab <span class="text-danger">*</span></label>

                                <select name="refered_lab_id" id="refered_lab_id" class="form-control js-choice w-100"

                                    data-options='{"removeItemButton":true,"placeholder":true}' required>

                                    <option value="">--select--</option>

                                    @foreach ($refering_labs as $refering_lab)

                                        <option value="{{ $refering_lab->lab_id }}">{{ $refering_lab->lab_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <label>Select Patients and Tests <span class="text-danger">*</span></label>

                                <div class="border rounded p-2" style="max-height: 250px; overflow-y: auto;">

                                    @foreach ($details->patients as $index => $patient)

                                        <div class="mb-2">

                                            <strong>{{ $patient->name }}</strong>

                                            <div class="ms-3">

                                                @foreach ($details->tests->where('booking_patient_id', $patient->id) as $test)

                                                    <div class="form-check">

                                                        <input class="form-check-input" type="checkbox"

                                                            name="assignments[]"

                                                            id="assignlab_{{ $patient->id }}_{{ $test->id }}"

                                                            value="{{ $patient->id }}_{{ $test->id }}">

                                                        <label class="form-check-label"

                                                            for="assignlab_{{ $patient->id }}_{{ $test->id }}">

                                                            {{ $test->package->name }}

                                                        </label>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <label for="note">Note <span class="text-danger">*</span></label>

                                <textarea name="note" id="lab_note" rows="3" class="form-control"

                                    placeholder="Type note for refering lab..." required></textarea>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <button type="submit" class="btn btn-primary bg-gradient w-100">Assign</button>

                            </div>



                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Barcode Modal Start --}}

    <div class="modal fade" id="barcode-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">

            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"

                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">

                        <h4 class="mb-1">Generate Barcode</h4>

                    </div>

                    <div class="p-4">

                        <form id="generate-barcode-form" class="row">



                            <div class="form-group mb-3 col-12">

                                <label>Select Patients and Tests <span class="text-danger">*</span></label>

                                <div class="border rounded p-2" style="max-height: 250px; overflow-y: auto;">

                                    @foreach ($details->patients as $index => $patient)

                                        <div class="mb-2">

                                            <strong>{{ $patient->name }}</strong>

                                            <div class="ms-3">

                                                @foreach ($details->tests->where('booking_patient_id', $patient->id) as $test)

                                                    <div class="form-check">

                                                        <input class="form-check-input" type="checkbox"

                                                            name="assignments[]"

                                                            id="assign_{{ $patient->id }}_{{ $test->id }}"

                                                            value="{{ $patient->id }}_{{ $test->id }}">

                                                        <label class="form-check-label"

                                                            for="assign_{{ $patient->id }}_{{ $test->id }}">

                                                            {{ $test->package->name }}

                                                        </label>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                            <div class="form-group mb-3 col-12">

                                <input type="hidden" name="booking_id" value="{{ $details->id }}">

                                <input type="hidden" id="booking_user_id" name="booking_user_id"

                                    value="{{ $details->user_id }}">

                                <input type="hidden" id="booking_order_id" name="booking_order_id"

                                    value="{{ $details->order_id }}">

                                <button type="submit" class="btn btn-primary bg-gradient w-100">Generate</button>

                            </div>



                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Barcode Modal End --}}

@endsection

@section('js')

    <script>

        $(document).ready(function() {

            $(document).on('click', '.upload-report-btn', function(e) {

                e.preventDefault();

                var patient_id = $(this).data('patient_id');

                $('#patient_id').val(patient_id);

                $('#upload-report-modal').modal('show');

            });



            $(document).on('click', '.fwd-report-btn', function(e) {

                e.preventDefault();

                var test_id = $(this).data('id');

                $('#fwd_test_id').val(test_id);

                $('#fwd-report-modal').modal('show');

            });



            $('#submit-to-doctor').on('click', function() {

                const doctorId = $('#staffDoctor').val();

                const testId = $('#fwd_test_id').val();



                if (!doctorId || !testId) {

                    Swal.fire({

                        icon: 'warning',

                        title: 'Please select a doctor.',

                        confirmButtonText: 'OK'

                    });

                    return;

                }



                Swal.fire({

                    title: 'Forwarding...',

                    text: 'Please wait while we forward the report.',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });



                $.ajax({

                    url: "{{ route('backend.reports.forward') }}", // update to your route name

                    type: 'POST',

                    data: {

                        _token: '{{ csrf_token() }}',

                        test_id: testId,

                        doctor_id: doctorId

                    },

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Report Forwarded!',

                            text: response.message ||

                                'The report has been successfully forwarded.',

                            timer: 2000,

                            showConfirmButton: false

                        });



                        $('#fwd-report-modal').modal('hide');





                        location.reload();

                    },

                    error: function(xhr) {

                        Swal.fire({

                            icon: 'error',

                            title: 'Failed!',

                            text: xhr.responseJSON?.message ||

                                'An error occurred while forwarding the report.',

                            confirmButtonText: 'OK'

                        });

                    }

                });

            });



            $(document).on('click', '.assign-phlebotomist-btn', function(e) {

                e.preventDefault();

                $('#assign-phlebotomist-modal').modal('show');

            });



            $(document).on('click', '.refer-lab-btn', function(e) {

                e.preventDefault();

                $('#refer-lab-modal').modal('show');

            });



            $(document).on('click', '.barcode-btn', function(e) {

                e.preventDefault();

                $('#barcode-modal').modal('show');

            });





            $(document).on('click', '.upload-option', function() {
            
                var type = $(this).data('type');
            
                if (type === 'auto') {
            
                    Swal.fire({
                        title: 'Fetching Auto Report...',
                        text: 'Please wait while we fetch and process your report.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
            
                    $.ajax({
                        url: "{{ route('upload.auto.report') }}",
                        method: 'POST',
                        data: {
                            patient_id: $('#patient_id').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Success!", response.message, "success");
                            $('#upload-report-modal').modal('hide');
                            window.location.reload();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            Swal.fire("Error", xhr.responseJSON?.message || "Auto upload failed", "error");
                        }
                    });
            
                    return;
                }
            
                // existing manual upload code
                if (type === 'manual') {
                    $('.upload-option').removeClass('border border-primary');
                    $(this).addClass('border border-primary');
                }
            
                if (type === 'manual') {
                    $('#manual-upload-box').removeClass('d-none');
                } else {
                    $('#manual-upload-box').addClass('d-none');
                }
            });

            $(document).on('click', '#upload-manual-report-btn', function(e) {

                e.preventDefault();

                const fileInput = document.getElementById('manual-report');

                const file = fileInput.files[0];



                if (!file) {

                    Swal.fire('Error', 'Please select a PDF file.', 'error');

                    return;

                }





                const formData = new FormData();

                formData.append('report_file', file);

                formData.append('report_type', 'manual');

                formData.append('patient_id', $('#patient_id').val());



                Swal.fire({

                    title: 'Uploading...',

                    text: 'Please wait while we add the header and footer to your PDF.',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });



                $.ajax({

                    url: "{{ route('upload.manual.report') }}",

                    method: 'POST',

                    data: formData,

                    processData: false,

                    contentType: false,

                    success: function(response) {

                        Swal.fire('Success!', 'Report uploaded successfully.', 'success');

                        // $('#manual-report').val('');

                        $('#upload-report-modal').modal('hide');

                        window.location.reload();

                    },

                    error: function(xhr) {

                        Swal.fire('Error', xhr.responseJSON?.message || 'Upload failed.',

                            'error');

                    }

                });

            });







            $(document).on('submit', '#store-sample-tracking', function(e) {

                e.preventDefault();



                let form = $(this);

                let data = form.serialize();



                Swal.fire({

                    title: 'Assigning...',

                    text: 'Please wait',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading()

                    }

                });



                $.ajax({

                    url: "{{ route('sample-tracking.store') }}",

                    method: "POST",

                    data: data,

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Success',

                            text: response.message

                        }).then(() => {

                            $('#assign-phlebotomist-modal').modal('hide');
                            window.location.reload();

                        });

                    },

                    error: function(xhr) {

                        console.log(xhr);

                        let error = xhr.responseJSON?.message || 'Something went wrong';

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: error

                        });

                    }

                });

            });



            $(document).on('submit', '#store-refered-test', function(e) {

                e.preventDefault();



                let form = $(this);

                let data = form.serialize();



                Swal.fire({

                    title: 'Refering to Lab...',

                    text: 'Please wait',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading()

                    }

                });



                $.ajax({

                    url: "{{ route('assign.refering_lab.test') }}",

                    method: "POST",

                    data: data,

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Success',

                            text: response.message

                        }).then(() => {

                            $('#refer-lab-modal').modal('hide');

                        });

                        window.location.reload();

                    },

                    error: function(xhr) {

                        console.log(xhr);

                        let error = xhr.responseJSON?.message || 'Something went wrong';

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: error

                        });

                    }

                });

            });



            function bookingStatus() {

                const bookingId = "{{ $details->id }}";



                $.ajax({

                    url: `/get-phlebotomist-info/${bookingId}`,

                    method: 'GET',

                    success: function(response) {

                        if (response.assigned) {

                            $('.assigned-info')

                                .removeClass('d-none')

                                .html(

                                    `<strong>Name - </strong> ${response.phlebotomist.name}  <br>  <strong>Phone - </strong>${response.phlebotomist.phone}`

                                );

                            // $('.assign-phlebotomist-btn').addClass('d-none');

                            $('.phlebotomist-live-tracking').removeClass('d-none');

                        } else {

                            $('.assigned-info').removeClass('d-none').html(

                                `<strong>No phlebotomist assigned</strong>`);

                            $('.assign-phlebotomist-btn').removeClass('d-none');

                            $('.phlebotomist-live-tracking').addClass('d-none');

                        }



                        // Tracking CSS

                        const currentStep = response.track_status;

                        const steps = document.querySelectorAll('.step');



                        steps.forEach((step, index) => {

                            step.classList.remove('active', 'inactive', 'last-active');

                            if (index < currentStep) {

                                step.classList.add('active');

                            } else if (index === currentStep) {

                                step.classList.add('active', 'last-active');

                            } else {

                                step.classList.add('inactive');

                            }

                        });

                    },

                    error: function(xhr) {

                        console.log(xhr);

                    }

                });

            }



            bookingStatus();



            $(document).on('change', '.verify-report-checkbox', function() {

                const reportUrl = $(this).data('report-url');

                const testId = $(this).data('test-id');

                const isAlreadyVerified = $(this).data('verified') == 1;



                $('#reportPdfFrame').attr('src', reportUrl);

                $('#confirmVerifyBtn').data('test-id', testId);



                if (isAlreadyVerified) {

                    $('#confirmVerifyBtn').hide();

                } else {

                    $('#confirmVerifyBtn').show();

                }

            });



            // Verify button click inside modal

            $(document).on('click', '#confirmVerifyBtn', function() {

                const testId = $(this).data('test-id');



                Swal.fire({

                    title: 'Verify Report?',

                    text: "Do you want to mark this report as verified?",

                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonText: 'Yes, verify it!'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ route('booking.report.verify') }}",

                            method: 'POST',

                            data: {

                                test_id: testId,

                                _token: $('meta[name="csrf-token"]').attr('content')

                            },

                            success: function(res) {

                                Swal.fire('Verified!', res.message, 'success');



                                // Update UI

                                const checkbox = $(

                                    `.verify-report-checkbox[data-test-id="${testId}"]`

                                );

                                checkbox.data('verified', 1).prop('disabled', true);

                                $('#confirmVerifyBtn').hide();

                                $('#verifyReportModal').modal('hide');

                                bookingStatus();

                            },

                            error: function(xhr) {

                                Swal.fire('Error', xhr.responseJSON?.message ||

                                    'Verification failed.', 'error');

                            }

                        });

                    }

                });

            });



            $(document).on('change', '.certify-report-checkbox', function() {

                const reportUrl = $(this).data('report-url');

                const testId = $(this).data('test-id');

                const isAlreadyVerified = $(this).data('certified') == 1;



                $('#reportPdfFrame').attr('src', reportUrl);

                $('#reportPdfFrame2').attr('src', reportUrl);

                $('#confirmCertifyBtn').data('test-id', testId);



                if (isAlreadyVerified) {

                    $('#confirmCertifyBtn').hide();

                } else {

                    $('#confirmCertifyBtn').show();

                }

            });



            // Certify button click inside modal

            $(document).on('click', '#confirmCertifyBtn', function() {

                const testId = $(this).data('test-id');



                Swal.fire({

                    title: 'Certify Report?',

                    text: "Do you want to mark this report as certified?",

                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonText: 'Yes, certify it!'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ route('booking.report.certify') }}",

                            method: 'POST',

                            data: {

                                test_id: testId,

                                _token: $('meta[name="csrf-token"]').attr('content')

                            },

                            success: function(res) {

                                Swal.fire('Certified!', res.message, 'success');



                                // Update UI

                                const checkbox = $(

                                    `.certify-report-checkbox[data-test-id="${testId}"]`

                                );

                                checkbox.data('certified', 1).prop('disabled', true);

                                $('#confirmCertifyBtn').hide();

                                $('#certifyReportModal').modal('hide');

                                bookingStatus();

                                window.location.reload();

                            },

                            error: function(xhr) {

                                console.log(xhr);

                                Swal.fire('Error', xhr.responseJSON?.message ||

                                    'Certification failed.', 'error');

                            }

                        });

                    }

                });

            });



            $(document).on('click', '.delete-report-btn', function(e) {

                e.preventDefault();

                let id = $(this).data('id');



                Swal.fire({

                    title: 'Are you sure?',

                    text: "This will delete the report permanently.",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#d33',

                    cancelButtonColor: '#6c757d',

                    confirmButtonText: 'Yes, delete it!'

                }).then((result) => {

                    if (result.isConfirmed) {



                        // Show loading

                        Swal.fire({

                            title: 'Deleting...',

                            text: 'Please wait while the report is being deleted.',

                            allowOutsideClick: false,

                            didOpen: () => {

                                Swal.showLoading();

                            }

                        });



                        $.ajax({

                            url: '/booking-test/' + id + '/delete-report',

                            type: 'DELETE',

                            data: {

                                _token: '{{ csrf_token() }}'

                            },

                            success: function(response) {

                                if (response.status) {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'Deleted!',

                                        text: response.message,

                                        timer: 2000,

                                        showConfirmButton: false

                                    }).then(() => {

                                        location.reload();

                                    });

                                } else {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'Failed!',

                                        text: 'Could not delete the report.'

                                    });

                                }

                            },

                            error: function() {

                                Swal.fire({

                                    icon: 'error',

                                    title: 'Error!',

                                    text: 'Something went wrong. Please try again.'

                                });

                            }

                        });

                    }

                });

            });



            // Accept sample

            $(document).on('click', '.accept-sample', function() {

                const sampleId = $(this).data('sample-id');



                Swal.fire({

                    title: 'Are you sure?',

                    text: "You are about to accept this sample.",

                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonColor: '#198754',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Yes, Accept it!',

                    cancelButtonText: 'Cancel'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ route('sample.update-status') }}",

                            type: "POST",

                            data: {

                                _token: "{{ csrf_token() }}",

                                sample_id: sampleId,

                                status: 3

                            },

                            success: function(res) {

                                Swal.fire('Accepted!', res.message, 'success');

                                setTimeout(() => {

                                    window.location.reload();

                                }, 1000);

                            },

                            error: function(xhr) {

                                Swal.fire('Error', xhr.responseJSON.message ||

                                    'Something went wrong.', 'error');

                            }

                        });

                    }

                });

            });





            // Open reject modal

            $(document).on('click', '.reject-sample', function() {

                const sampleId = $(this).data('sample-id');

                $('#reject_sample_id').val(sampleId);

                $('#reject_reason').val('');

                $('#rejectReasonModal').modal('show');

            });



            // Submit rejection form

            $('#rejectReasonForm').submit(function(e) {

                e.preventDefault();



                $.ajax({

                    url: "{{ route('sample.update-status') }}",

                    type: "POST",

                    data: $(this).serialize(),

                    success: function(res) {

                        $('#rejectReasonModal').modal('hide');

                        Swal.fire('Rejected!', res.message, 'success');

                        window.location.reload();

                    },

                    error: function(xhr) {

                        Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong.',

                            'error');

                    }

                });

            });



        });

    </script>

    <script>

        $(document).on('submit', '#generate-barcode-form', function(e) {

            e.preventDefault();



            const form = $(this);

            const submitBtn = form.find('button[type="submit"]');

            submitBtn.prop('disabled', true).text('Generating...');



            $.ajax({

                type: 'POST',

                url: '{{ route('barcode.generate') }}',

                data: form.serialize(),

                success: function(response) {

                    submitBtn.prop('disabled', false).text('Assign');



                    if (response.status && response.barcodes.length > 0) {

                        let html = `<div class="mt-3"><h5>Generated Barcodes</h5><div class="row">`;



                        response.barcodes.forEach(function(item, index) {

                            html += `

                            <div class="col-12 mb-3" id="barcode-block-${index}">

                                <div class="border p-2 rounded text-center printable-content">

                                    <img src="${item.barcode_image}" alt="Barcode" class="img-fluid" />

                                </div>

                                <div class="mt-1 text-center">

                                    <button class="btn btn-sm btn-secondary print-btn mt-2" data-target="barcode-block-${index}">

                                        Print

                                    </button>

                                </div>

                            </div>`;

                        });



                        html += `</div></div>`;

                        $('#barcode-modal .modal-body .p-4').append(html);

                    } else {

                        alert('No barcode generated.');

                    }

                },

                error: function(xhr) {

                    console.log(xhr);

                    submitBtn.prop('disabled', false).text('Assign');



                    let errors = xhr.responseJSON?.errors;

                    if (errors) {

                        let messages = Object.values(errors).flat().join('\n');

                        alert("Validation Error:\n" + messages);

                    } else {

                        alert('An error occurred. Please try again.');

                    }

                }

            });

        });



        // Print specific barcode block

        $(document).on('click', '.print-btn', function() {

            const targetId = $(this).data('target');

            const printContent = document.getElementById(targetId).querySelector('.printable-content').innerHTML;



            const printWindow = window.open('', '_blank');

            printWindow.document.write(`

            <html>

                <head>

                    <title>Print Barcode</title>

                    <style>

                        body { text-align: center; margin: 0; padding: 20px; }

                        img { max-width: 100%; height: auto; }

                    </style>

                </head>

                <body>${printContent}</body>

            </html>

        `);

            printWindow.document.close();

            printWindow.focus();

            printWindow.print();

            printWindow.close();

        });

    </script>

@endsection

