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
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="fs-10 fw-bold text-dark">Order ID : </span>
                <span>{{ $booking->payment->order_id }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">Patient Name: </span>
                <span class="me-1">{{ $booking->user->name ?? 'N/A' }}</span>
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

                @if($booking->consultation_type == 2 && $booking->meeting_url)
                <span class="fs-10 fw-bold text-dark">Meeting Link: </span>
                <a href="{{ $booking->meeting_url }}" target="_blank" class="text-primary text-decoration-underline">
                    Join Consultation
                </a>
                @endif
                <br>
                <a class="btn btn-sm btn-falcon-primary mt-3" href="{{ url()->previous() }}">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <a class="btn btn-sm btn-primary mt-3 ms-2" href="#write-prescription-form">
                    <i class="fa-solid fa-pen"></i> Write Prescription
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row g-0">
    <div class="col-lg-8 pe-lg-2">

        @if ($booking->prescription_upload)
        <div class="card mb-3">
            <div class="card-header bg-body-tertiary">
                <h5 class="mb-0">Patient Uploaded Prescriptions</h5>
            </div>
            <div class="card-body overflow-hidden">
                @if($booking->prescription_upload)
                <div class="row g-0">
                    <div class="col p-1 text-center">
                        @php
                        $ext = pathinfo($booking->prescription_upload, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                        @endphp

                        <a class="glightbox" href="{{ asset($booking->prescription_upload) }}" data-gallery="gallery1" data-glightbox="data-glightbox">
                            @if ($isImage)
                            <img class="img-fluid rounded mb-2" src="{{ asset($booking->prescription_upload) }}" alt="Prescription Image" style="max-height: 200px;" />
                            @else
                            <img class="img-fluid rounded mb-2" src="{{ asset($booking->prescription_upload) }}" alt="PDF File" style="height: 100px;" />
                            @endif
                            <p class="btn btn-falcon-primary w-100">View Prescription</p>
                        </a>
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
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#prescriptionAccordion">
                            <div class="accordion-body">
                                {{-- Written Prescription --}}
                                @if($item->written_prescription)
                                <p><strong>Written:</strong> {{ $item->written_prescription }}</p>
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

        {{-- Doctor Prescription Input (Write or Upload) --}}
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
                        <textarea name="written_prescription" id="written_prescription" rows="5" class="form-control"
                            placeholder="Enter the prescription here...">{{ old('written_prescription', $booking->prescription) }}</textarea>
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-3">
                        <label for="prescription_upload" class="form-label fw-semibold">Upload Prescription File</label>
                        <input type="file" name="prescription_upload" id="prescription_upload" class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf">
                        <small class="text-muted">Allowed formats: JPG, PNG, PDF — Max size: 5MB</small>
                    </div>

                    <button type="submit" class="btn btn-falcon-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Prescription
                    </button>
                </form>
            </div>
        </div>

    </div>
    <div class="col-lg-4 ps-lg-2">
        <div class="sticky-sidebar">

            {{-- Address --}}
            <div class="card mb-3">
                <div class="card-header bg-body-tertiary">
                    <h5 class="mb-0">Address</h5>
                </div>
                <div class="card-body fs-10">

                    <p class="mb-2">
                        @if ($booking->address)
                        {{ $booking->user->name ?? '' }}<br>
                        {{ $booking->address->address ?? '' }}<br>
                        {{ $booking->address->city }}
                        {{ $booking->address->state ?? '' }},
                        {{ $booking->address->country ?? '' }} -
                        {{ $booking->address->pin ?? '' }}<br>
                        <strong>Phone:</strong> {{ $booking->user->phone ?? '' }}
                        @else
                        <span class="text-muted">No address found</span>
                        @endif
                    </p>

                </div>
            </div>
          
        </div>
    </div>

</div>
<div class="row g-0 mt-3">
    <div class="col-lg-12">
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

@endsection
@section('js')

@endsection