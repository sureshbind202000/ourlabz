<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
    @forelse($doctors as $doctor)
        <div class="col">
            <div class="card h-100">
                <div class="card-body border rounded-3">
                    <div class="d-flex doctor gap-3">
                        {{-- Doctor Image --}}
                        <div class="doctor-image">
                            <img src="{{ asset($doctor->profile ?? 'default-avatar.png') }}" alt="{{ $doctor->name }}"
                                class="img-fluid rounded-3" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>

                        {{-- Doctor Content --}}
                        <div class="doctor-content w-100">
                            <h5 class="card-title mb-1">{{ $doctor->name }}</h5>
                            @php
                                $specializationsRaw = $doctor->doctor_details?->specialization ?? null;

                                // Decode JSON if it's a string; fallback to empty array if invalid
                                if (is_string($specializationsRaw)) {
                                    $decoded = json_decode($specializationsRaw, true);
                                    $specializations = is_array($decoded) ? $decoded : [];
                                } elseif (is_array($specializationsRaw)) {
                                    $specializations = $specializationsRaw;
                                } else {
                                    $specializations = [];
                                }
                            @endphp

                            <p class="text-muted card-text text-truncate truncate-fixed mb-1">
                                @if (!empty($specializations))
                                    {{ implode(', ', $specializations) }}.
                                @else
                                    N/A
                                @endif
                            </p>


                            @php
                                $qualificationsRaw = $doctor->doctor_details?->qualification ?? [];
                                $qualifications = is_string($qualificationsRaw)
                                    ? json_decode($qualificationsRaw, true)
                                    : $qualificationsRaw;

                                // Ensure it's an array
                                $qualifications = is_array($qualifications) ? $qualifications : [];
                            @endphp

                            <p class="text-primary card-text text-truncate truncate-fixed mb-1">
                                @if (!empty($qualifications))
                                    {{ implode(', ', $qualifications) }}
                                @else
                                    N/A
                                @endif
                            </p>


                            <p class="text-muted card-text text-truncate truncate-fixed mb-2">
                                {{ $doctor->doctor_details?->hospital_clinic_address ?? 'N/A' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                @if (!empty($doctor->doctor_details?->year_of_experience))
                                    <p class="card-text fw-bold mb-0">{{ $doctor->doctor_details->year_of_experience }}
                                        year{{ $doctor->doctor_details->year_of_experience > 1 ? 's' : '' }} experience
                                    </p>
                                @else
                                    <p class="card-text mb-0 text-muted">No experience data</p>
                                @endif

                                <h5 class="mb-0 text-primary">₹{{ $doctor->doctor_details?->price ?? '0' }}</h5>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="hero-btn w-100 mt-3 d-flex gap-2" data-animation="fadeInUp" data-delay="1s">
                        <a href="{{ route('doctor.details', ['id' => encrypt($doctor->id)]) }}"
                            class="btn btn-outline-primary btn-sm w-50 py-2 rounded-3">View Detail</a>

                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-50 py-2 rounded-3 consult-btn"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-name="{{ $doctor->name }}"
                            data-image="{{ asset($doctor->profile ?? 'default-avatar.png') }}"
                            data-price="{{ $doctor->doctor_details?->price ?? '0' }}"
                            data-scheduler_id="{{ $doctor->user_id }}">
                            Consult Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center mx-auto">
            <div class="alert alert-primary">No doctor found.</div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="pagination-area mt-3">
    {{ $doctors->links('vendor.pagination.custom') }}
</div>
