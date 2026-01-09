@if ($tests->count() > 0)
    <div class="row g-3">
        @foreach ($tests as $test)
            <div class="col-md-6">
                <div class="consultation-glass p-3 rounded-4 shadow-sm d-flex flex-column h-100">
                    
                    <!-- Content (top part) -->
                    <div>
                        <h5 class="fw-semibold text-dark mb-2">
                            <i class="fa-solid fa-vials text-primary me-2"></i>
                            {{ $test->package->name ?? '-' }}
                        </h5>
                        <p class="mb-1 text-muted small">
                            <i class="fa-solid fa-user me-1 text-secondary"></i>
                            Patient: <strong>{{ $test->patient->name ?? '-' }}</strong>
                        </p>
                        <p class="mb-2 text-muted small">
                            <i class="fa-regular fa-calendar me-1 text-secondary"></i>
                            Updated: <strong>{{ \Carbon\Carbon::parse($test->updated_at)->format('d/m/Y') }}</strong>
                        </p>
                    </div>

                    <!-- Buttons (bottom part) -->
                    <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                        <a href="{{ asset($test->report_file) }}" target="_blank" 
                           class="btn btn-outline-danger btn-sm px-3 rounded-pill">
                            <i class="fa-solid fa-file-pdf me-1"></i> View Report
                        </a>
                        <button class="btn btn-primary btn-sm rounded-pill open-doctors px-3" 
                                data-id="{{ $test->id }}">
                            <i class="fa-solid fa-user-md me-1"></i> Doctors
                        </button>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center text-muted py-5">
        <i class="fa-solid fa-stethoscope fa-2x mb-2 text-secondary"></i>
        <p>No free consultation tests available.</p>
    </div>
@endif

<style>
.consultation-glass {
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.consultation-glass:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.15);
}
</style>
