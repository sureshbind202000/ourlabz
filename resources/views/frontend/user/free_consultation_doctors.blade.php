@php
    // Function to calculate distance in KM
    function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) {
            return null;
        }

        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 1); // distance in km
    }

    $userLat = auth()->user()->latitude ?? null;
    $userLon = auth()->user()->longitude ?? null;
@endphp

@if ($doctors->count() > 0)
    <div class="row g-4">
        @foreach ($doctors as $doctor)
            @php
                $doctorLat = $doctor->latitude ?? null;
                $doctorLon = $doctor->longitude ?? null;
                $distance = getDistance($userLat, $userLon, $doctorLat, $doctorLon);

                $specializations = [];
                if (!empty($doctor->doctor_details->specialization)) {
                    if (is_array($doctor->doctor_details->specialization)) {
                        $specializations = $doctor->doctor_details->specialization;
                    } elseif (is_string($doctor->doctor_details->specialization)) {
                        $specializations = json_decode($doctor->doctor_details->specialization, true) ?? [];
                    }
                }
            @endphp

            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm border-0 h-100 hover-shadow transition consultation-glass">
                    <div class="card-body d-flex flex-column">

                        {{-- Doctor Header --}}
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset($doctor->profile) ?? asset('images/default-doctor.png') }}"
                                alt="{{ $doctor->name }}" class="rounded-circle me-3"
                                style="width:70px; height:70px; object-fit:cover; border:2px solid #0095d9;">

                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $doctor->name ?? '' }}</h5>
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    @if ($doctor->is_online == 1)
                                        <span class="badge bg-success">Online</span>
                                    @else
                                        <span class="badge bg-secondary">Offline</span>
                                    @endif

                                    @if ($distance)
                                        <span class="badge bg-info text-dark">{{ $distance }} km away</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Specializations --}}
                        @if (!empty($specializations))
                            <div class="text-muted small mb-2">
                                @foreach ($specializations as $spec)
                                    <span class="badge bg-primary me-1 mb-1"
                                        style="font-size: 10px;">{{ $spec }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted mb-2 d-block">No specialization listed</span>
                        @endif

                        {{-- Experience & Address --}}
                        <p class="text-muted small mb-3">
                            @if (!empty($doctor->doctor_details->year_of_experience))
                                <strong>Experience:</strong> {{ $doctor->doctor_details->year_of_experience }} yrs<br>
                            @endif
                            @if (!empty($doctor->user_details->address))
                                <strong>Clinic/Address:</strong> {{ $doctor->user_details->address }},
                                {{ $doctor->user_details->city }}, {{ $doctor->user_details->state }},
                                {{ $doctor->user_details->country }} - {{ $doctor->user_details->pin }}
                            @endif
                        </p>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Choose Consultation Mode:</label>
                            <div class="d-flex gap-2">
                                <div class="form-check">
                                    <input class="form-check-input consultation-mode" type="radio"
                                        name="consultation_mode_{{ $doctor->user_id }}"
                                        id="mode_online_{{ $doctor->user_id }}" value="2"
                                        data-doctor-id="{{ $doctor->user_id }}">
                                    <label class="form-check-label" for="mode_online_{{ $doctor->user_id }}">
                                        Online
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input consultation-mode" type="radio"
                                        name="consultation_mode_{{ $doctor->user_id }}"
                                        id="mode_offline_{{ $doctor->user_id }}" value="1"
                                        data-doctor-id="{{ $doctor->user_id }}">
                                    <label class="form-check-label" for="mode_offline_{{ $doctor->user_id }}">
                                        Visit Doctor
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Request Booking Button --}}
                        <div class="mt-auto text-center">
                            <a href="javascript:void(0);"
                                class="btn btn-primary btn-sm rounded-pill request-booking w-100 py-2"
                                data-doctor-id="{{ $doctor->user_id }}" data-consultation-mode="0">
                                <i class="fa-solid fa-calendar-check me-1"></i> Request Booking
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5 text-muted">
        <i class="fa-solid fa-user-md fa-4x mb-3"></i>
        <h5 class="mb-2">No doctors available for this test</h5>
        <p class="small">Please check back later or try another test.</p>
    </div>
@endif