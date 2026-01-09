@extends('backend.includes.layout')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-between-center">
            <a href="{{ url()->previous() }}" class="btn btn-falcon-default btn-sm">
                <span class="fas fa-arrow-left"></span>
            </a>

            <div class="d-flex">
                <button class="btn btn-falcon-primary btn-sm mx-2 upload-sign-btn" type="button" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Upload doctor signature.">
                    <i class="fa-solid fa-file-signature"></i>
                    <span class="d-none d-md-inline-block ms-1">Upload Signature</span>
                </button>
                
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body text-center">
            <div id="signaturePreview">
                @php
                    $signature = \App\Models\DoctorSignature::where('doctor_id', auth()->id())->first();
                @endphp

                @if ($signature && file_exists(public_path($signature->signature)))
                    <img src="{{ asset($signature->signature) }}" alt="Doctor Signature" class="img-fluid"
                        style="max-height: 150px;">
                        <br>
                        <span class="text-muted">Uploaded Signature</span>
                @else
                    <p class="text-muted">No signature uploaded yet.</p>
                @endif
                
            </div>
        </div>
        <div class="card-footer">
            <p class="text-center fs-10">
                    <strong>Note : </strong>
                    Recommended Signature (200 x 80px) for best placement in report.
                </p>
        </div>
    </div>


    {{-- Hidden File Input --}}
    <input type="file" id="signatureInput" class="d-none" accept="image/png">
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.upload-sign-btn', function() {
                $('#signatureInput').click(); // Open file dialog
            });

            $('#signatureInput').on('change', function() {
                const file = this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('signature', file);
                formData.append('_token', '{{ csrf_token() }}');

                Swal.fire({
                    title: 'Uploading...',
                    text: 'Please wait while we upload the signature.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: '{{ route('backend.doctor.signature.upload') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Uploaded!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#signaturePreview').html(`
        <img src="${res.path}?t=${new Date().getTime()}" alt="Doctor Signature" class="img-fluid" style="max-height: 150px;">
    `);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: xhr.responseJSON?.message || 'An error occurred.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
