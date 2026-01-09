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



    html {

        scroll-behavior: smooth;

    }
</style>

@endsection

@section('content')

@php



@endphp

<div class="card mb-3">

    <div class="card-header position-relative min-vh-25">

        <div class="bg-holder rounded-3 rounded-bottom-0"

            style="background-image:url({{ asset('backend/assets/img/generic/4.webp') }});">

        </div><!--/.bg-holder-->

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <span class="fs-10 fw-bold text-dark">Booking ID : </span>

                <span>{{ $booking->payment->order_id }}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Patient Name: </span>

                <span class="me-1">{{ $booking->user->name ?? 'N/A' }}</span>

                <br>
                <span class="fs-10 fw-bold text-dark">Patient Phone : </span>
                <span>{{ $booking->user->phone ?? '' }}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Booking Date: </span>

                <span class="me-1">{{ \Carbon\Carbon::parse($booking->appointment_date)->format('d/m/Y') }}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Booking Time: </span>

                <span class="me-1">{{ ($booking->appointment_time) }}</span>

                <br>

                <span class="fs-10 fw-bold text-dark">Consultation Type: </span>

                <span class="badge bg-{{ $booking->consultation_type == 1 ? 'success' : 'info' }}">

                    {{ $booking->consultation_type == 1 ? 'Visit' : 'Online' }}

                </span>

                <br>

                <a class="btn btn-sm btn-falcon-primary mt-3" href="{{ url()->previous() }}">

                    <i class="fa-solid fa-arrow-left"></i> Back

                </a>
                @if($booking->status != 1 && $booking->status != 2)
                <a class="btn btn-sm btn-primary mt-3 ms-2" href="#write-prescription-form">

                    <i class="fa-solid fa-pen"></i> Write Prescription

                </a>

                <a class="btn btn-sm btn-warning mt-3 ms-2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#referDoctorModal">

                    <i class="fa-solid fa-share-nodes"></i> Refer

                </a>
                @endif

            </div>

            <div class="col-md-6">
                <span class="fs-10 fw-bold text-dark">Address : </span>
                <span>{{ $booking->address->address ?? '' }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">City : </span>
                <span>{{ $booking->address->city ?? '' }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">State : </span>
                <span>{{ $booking->address->state ?? '' }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">Country : </span>
                <span>{{ $booking->address->country ?? '' }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">Postal Code : </span>
                <span>{{ $booking->address->pin ?? '' }}</span>
                @if($booking->consultation_type == 2 && $booking->meeting_url)
                <br>
                <span class="fs-10 fw-bold text-dark">Meeting Link: </span>
                <a href="{{ $booking->meeting_url }}" target="_blank" class="text-primary text-decoration-underline">
                    Join Consultation
                </a>
                @endif
            </div>

        </div>

    </div>

</div>

<div class="row g-0">

    <div class="col-md-12">

        @if ($booking->prescription_upload)

        <div class="card mb-3">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Patient Uploaded Prescriptions</h5>

            </div>

            <div class="card-body overflow-hidden">

                @if($booking->prescription_upload)
                <div class="row g-0">
                    <div class="col-md-2 col-sm-2 col-2">
                        @php
                        $ext = strtolower(pathinfo($booking->prescription_upload, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp

                        @if ($isImage)
                        <a class="glightbox d-block text-decoration-none shadow-sm rounded overflow-hidden"
                            href="{{ asset($booking->prescription_upload) }}" data-gallery="gallery1"
                            style="background: linear-gradient(135deg, #007bff, #66b3ff); color: white;">
                            <div class="py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-file-image fa-2x mb-2"></i>
                                <span class="fw-semibold">View Prescription (Image)</span>
                            </div>
                        </a>
                        @elseif($ext === 'pdf')
                        <a href="{{ asset($booking->prescription_upload) }}" target="_blank"
                            class="d-block text-decoration-none shadow-sm rounded overflow-hidden"
                            style="background: linear-gradient(135deg, #dc3545, #ff6b6b); color: white;">
                            <div class="py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-file-pdf fa-2x mb-2"></i>
                                <span class="fw-semibold">View Prescription (PDF)</span>
                            </div>
                        </a>
                        @else
                        <a href="{{ asset($booking->prescription_upload) }}" target="_blank"
                            class="d-block text-decoration-none shadow-sm rounded overflow-hidden"
                            style="background: linear-gradient(135deg, #6c757d, #adb5bd); color: white;">
                            <div class="py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-file-alt fa-2x mb-2"></i>
                                <span class="fw-semibold">Download File</span>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
                @endif


                @if($booking->doctor_uploaded_prescription)

                <div class="row g-0">

                    {{-- Doctor Uploaded Prescription --}}

                    <h6>Doctor Uploaded</h6>

                    <div class="col p-1 text-center">

                        @php

                        $ext = pathinfo($booking->doctor_uploaded_prescription, PATHINFO_EXTENSION);

                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);

                        @endphp



                        <a class="glightbox" href="{{ asset($booking->doctor_uploaded_prescription) }}" data-gallery="gallery1" data-glightbox="data-glightbox">

                            @if ($isImage)

                            <img class="img-fluid rounded mb-2" src="{{ asset($booking->doctor_uploaded_prescription) }}" alt="Prescription Image" style="max-height: 200px;" />

                            @else

                            <img class="img-fluid rounded mb-2" src="{{ asset($booking->doctor_uploaded_prescription) }}" alt="PDF File" style="height: 100px;" />

                            @endif

                            <p class="btn btn-falcon-primary w-100">View Prescription</p>

                        </a>

                    </div>

                </div>

                @endif

            </div>

        </div>

        @endif



        {{-- Doctor Prescription Input (Write or Upload) --}}
       @if($booking->status != 1 && $booking->status != 2)
        <div class="card mb-3" id="write-prescription-form">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Consultation Prescription</h5>

            </div>

            <div class="card-body fs-10">

                <form action="{{ route('doctor.prescription.submit', $booking->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf



                    {{-- Written Prescription --}}

                    <div class="mb-3">
                        <label for="written_prescription" class="form-label fw-semibold">Write Prescription</label>
                        <textarea
                            name="written_prescription"
                            id="written_prescription"
                            rows="10"
                            class="tinymce"
                            placeholder="Enter the prescription here...">{{ old('written_prescription', $booking->prescription) }}</textarea>
                    </div>



                    {{-- Upload File --}}

                    <div class="mb-3">

                        <label for="prescription_upload" class="form-label fw-semibold">Upload Prescription File</label>

                        <input type="file" name="prescription_upload" id="prescription_upload" class="form-control"

                            accept=".jpg,.jpeg,.png,.pdf">

                        <small class="text-muted">Allowed formats: JPG, PNG, PDF — Max size: 5MB</small>

                    </div>

                    <div class="mb-3">
                        <label for="submit_type" class="form-label fw-semibold">What would you like to submit?</label>
                        <select name="submit_type" id="submit_type" class="form-select" required>
                            <option value="">-- Select an option --</option>
                            <option value="written">Written Prescription</option>
                            <option value="upload_file">Uploaded File Prescription</option>
                            <option value="both">Both</option>
                        </select>
                    </div>



                    <button type="submit" class="btn btn-falcon-primary">

                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Prescription

                    </button>

                </form>

            </div>

        </div>
        @endif
    </div>
</div>

<div class="row g-0">

    <div class="col-lg-12">
         @if($booking->prescriptions->count())

        <div class="card mb-3">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Prescription History</h5>

            </div>

            <div class="card-body fs-10">

                <div class="accordion" id="prescriptionAccordion">

                    @foreach($booking->prescriptions as $index => $item)

                    <div class="accordion-item">

                        <h2 class="accordion-header" id="heading{{ $index }}">

                            <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">

                                Prescription #{{ $booking->prescriptions->count() - $index }} — {{ $item->created_at->format('d M Y, h:i A') }}

                            </button>

                        </h2>

                        <div id="collapse{{ $index }}" class="accordion-collapse collapse " aria-labelledby="heading{{ $index }}" data-bs-parent="#prescriptionAccordion">

                            <div class="accordion-body">

                                {{-- Written Prescription --}}

                                @if($item->written_prescription)

                                <p><strong>Written:</strong> {!! $item->written_prescription !!}</p>

                                @endif



                                {{-- Uploaded File --}}

                                @if($item->file_prescription)

                                @php

                                $ext = pathinfo($item->file_prescription, PATHINFO_EXTENSION);

                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);

                                @endphp

                                <a class="glightbox" href="{{ asset($item->file_prescription) }}" data-gallery="prescriptions">

                                    @if($isImage)

                                    <img class="img-fluid rounded mb-2" src="{{ asset($item->file_prescription) }}" alt="Uploaded Prescription" style="max-height: 200px;" />

                                    @else

                                    <img class="img-fluid rounded mb-2" src="{{ asset('backend/assets/img/pdf-icon.png') }}" alt="PDF File" style="height: 100px;" />

                                    @endif

                                    <p class="btn btn-outline-primary btn-sm mt-1 w-100">View Uploaded File</p>

                                </a>

                                @endif

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

        @endif

        <div class="card mb-3">

            <div class="card-header bg-body-tertiary">

                <h5 class="mb-0">Activity Log</h5>

            </div>

            <div class="card-body">

                @forelse ($booking->activityLogs as $log)

                <p>

                    <strong>{{ $log->action }}</strong><br>

                    {{ $log->description }}

                    <small class="text-muted">

                        by {{ $log->user->name ?? 'System' }} on {{ $log->created_at->format('d M Y h:i A') }}

                    </small>

                </p>

                <hr>

                @empty

                <p>No activity logs yet.</p>

                @endforelse

            </div>

        </div>

    </div>



</div>

<!-- Refer Doctor Modal -->

<div class="modal fade" id="referDoctorModal" tabindex="-1" aria-labelledby="referDoctorModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="referDoctorModalLabel">Refer to a Doctor</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>



            <div class="modal-body">

                @php

                $doctors = \App\Models\User::where('role', 3)

                ->where('refering_id', auth()->user()->id)

                ->get();

                @endphp



                @if($doctors->count())

                <form id="referDoctorForm">

                    <div class="mb-3">

                        <label for="doctorSelect" class="form-label">Select Doctor</label>

                        <select class="form-select" id="doctorSelect" name="doctor_id" required>

                            <option value="">-- Choose a Doctor --</option>

                            @foreach($doctors as $doctor)

                            @if($doctor->id != auth()->id())

                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>

                            @endif

                            @endforeach

                        </select>



                    </div>



                    <div class="mb-3">

                        <label for="referNotes" class="form-label">Notes</label>

                        <textarea class="form-control" id="referNotes" name="notes" rows="4" placeholder="Enter any additional notes..."></textarea>

                    </div>



                    <input type="hidden" name="booking_id" id="referBookingId" value="{{ $booking->id }}">



                    <div class="text-end">

                        <button type="submit" class="btn btn-primary">Send</button>

                    </div>

                </form>

                @else

                <p class="text-muted">No doctors found to refer.</p>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {

        $(document).on('submit', '#referDoctorForm', function(e) {

            e.preventDefault();



            const formData = {

                doctor_id: $('#doctorSelect').val(),

                booking_id: $('#referBookingId').val(),

                notes: $('#referNotes').val(),

                _token: '{{ csrf_token() }}'

            };



            $.ajax({

                url: "{{ route('doctor.booking.refer') }}",

                type: "POST",

                data: formData,

                success: function(response) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Referred!',

                        text: response.message,

                        confirmButtonColor: '#3085d6',

                        confirmButtonText: 'OK'

                    }).then(() => {

                        $('#referDoctorModal').modal('hide');

                    });

                },

                error: function(xhr, status, error) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Oops...',

                        text: 'Failed to refer. Please try again.',

                        confirmButtonColor: '#d33'

                    });

                }

            });

        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let docName = "{{auth()->user()->name ?? 'Dr. Name'}}";
        let docReg = "{{auth()->user()->doctor_details->medical_license_number ?? 'DL-XXXX-XXXX'}}";
        let docQualifications = @json(auth()->user()->doctor_details->qualification ?? []);
        let clinicAddr = "{{auth()->user()->doctor_details->hospital_clinic_address ?? 'Clinic Address'}}";
        let formattedQualification = Array.isArray(docQualifications) ?
            docQualifications.join(', ') :
            docQualifications;
        let ptName = "{{ $booking->user->name ?? 'Name' }}";
        let ptAge = "{{ $booking->user->age ?? 'Age' }}";
        let ptGender = "{{ $booking->user->gender ?? 'Gender' }}";
        tinymce.init({
            selector: "textarea.tinymce",
            height: 500,
            menubar: false,
            plugins: "lists table code",
            toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | code",
            setup: function(editor) {
                editor.on("init", function() {
                    // Check if editor is empty (ignores HTML tags)
                    const content = editor.getContent({
                        format: 'text'
                    }).trim();
                    if (!content) {
                        const defaultLayout = `
<div style="font-family: Arial, sans-serif; border:1px solid #ccc; padding:20px; border-radius:10px;">
    <div style="text-align:center; border-bottom:2px solid #0095d9; padding-bottom:10px; margin-bottom:15px;">
        <h3 style="color:#0095d9; margin:0;">Dr. ${docName}</h3>
        <p style="margin:0;">${formattedQualification}</p>
        <p style="margin:0;">Reg. No: ${docReg}</p>
        <p style="margin-top:5px;">${clinicAddr}</p>
    </div>

    <div style="margin-bottom:15px;">
        <p><strong>Patient Name:</strong> ${ptName}</p>
        <p><strong>Age/Sex:</strong> ${ptAge} / ${ptGender}</p>
        <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
    </div>

    <div style="border-top:2px solid #0095d9; padding-top:10px;">
        <h4 style="color:#0095d9;">Diagnosis:</h4>
        <ul>
        <li></li>
        </ul>

        <h4 style="color:#0095d9;">Prescription:</h4>
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr>
                    <th style="border-bottom:1px solid #ccc; padding:6px;">Medicine</th>
                    <th style="border-bottom:1px solid #ccc; padding:6px;">Dosage</th>
                    <th style="border-bottom:1px solid #ccc; padding:6px;">Duration</th>
                    <th style="border-bottom:1px solid #ccc; padding:6px;">Instructions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:6px;"></td>
                    <td style="padding:6px;"></td>
                    <td style="padding:6px;"></td>
                    <td style="padding:6px;"></td>
                </tr>
            </tbody>
        </table>

        <h4 style="color:#0095d9; margin-top:15px;">Advice:</h4>
        <ul>
        <li></li>
        </ul>
    </div>

    <div style="text-align:right; margin-top:30px;">
        <p style="margin:0; font-weight:bold;">Dr. ${docName}</p>
        <p style="margin:0; font-size:13px;">Signature</p>
    </div>
</div>`;

                        editor.setContent(defaultLayout);
                    }
                });
            }
        });
    });
</script>

@endsection