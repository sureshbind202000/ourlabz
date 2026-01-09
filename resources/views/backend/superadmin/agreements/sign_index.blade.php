@extends('backend.includes.layout')
@section('css')
    <style>
        #signaturePad {
            border: 2px dashed #ccc;
            width: 100%;
            height: 200px;
            touch-action: none;
            /* ✅ needed for touch devices */
        }
    </style>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Sign Agreements</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["sign","title","target","status","date","createdBy"],"page":10,"pagination":true}'>
                    <div class="row justify-content-end g-0">
                        <div class="col-auto col-md-12 mb-3">
                            <form>
                                <div class="input-group"><input class="form-control form-control-sm shadow-none search"
                                        type="search" placeholder="Search..." aria-label="search" />
                                    <div class="input-group-text bg-transparent"><span
                                            class="fa fa-search fs-10 text-600"></span></div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-900">S.No.</th>
                                    <th class="text-900" data-sort="title">Title</th>
                                    <th class="text-900" data-sort="sign">Sign.</th>
                                    <th class="text-900" data-sort="status">Status</th>
                                    <th class="text-900" data-sort="date">Created At</th>
                                    <th class="text-900" data-sort="createdBy">Created By</th>
                                    <th class="text-900">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1"
                            type="button" title="Previous" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"
                            title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0 shadow-sm">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="viewModalLabel"><i
                            class="fas fa-file-contract me-2"></i>Agreement Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">
                    <!-- Basic Info Card -->
                    <div class="card mb-3 shadow-sm text-dark">
                        <div class="card-header bg-light">
                            <strong>Agreement Information</strong>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12"><strong>Title:</strong> <span id="view_title"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6"><strong>Status:</strong> <span id="view_status"></span></div>
                                <div class="col-md-6"><strong>Activated At:</strong> <span id="view_activated_at"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6"><strong>Created By:</strong> <span id="view_created_by"></span>
                                </div>
                                <div class="col-md-6"><strong>Created At:</strong> <span id="view_created_at"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6"><strong>Updated By:</strong> <span id="view_updated_by"></span>
                                </div>
                                <div class="col-md-6"><strong>Updated At:</strong> <span id="view_updated_at"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    <div class="card mb-3 shadow-sm text-dark">
                        <div class="card-header bg-light">
                            <strong>Description</strong>
                        </div>
                        <div class="card-body">
                            <div id="view_description"></div>
                        </div>
                    </div>

                    <!-- Signatures Card -->
                    <div class="card shadow-sm text-dark">
                        <div class="card-header bg-light">
                            <strong>Signature</strong>
                        </div>
                        <div class="card-body" id="view_signatures" style="display: flex; flex-wrap: wrap; gap: 20px;">
                            <!-- Signature images will be injected here -->
                        </div>
                    </div>
                </div>

                <!-- Footer (optional actions) -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="signAgreementBtn">
                        <i class="fas fa-pen me-2"></i>Sign Agreement
                    </button>
                    <button type="button" class="btn btn-primary" id="downloadAgreementBtn"><i
                            class="fas fa-download me-2"></i>Download PDF</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Signature Modal --}}
    <div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-signature me-2"></i>Sign Agreement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <canvas id="signaturePad"></canvas>
                    <div class="mt-3">
                        <button class="btn btn-warning btn-sm" id="clearSignature">
                            <i class="fas fa-eraser me-1"></i>Clear
                        </button>
                        <button class="btn btn-primary btn-sm" id="saveSignature">
                            <i class="fas fa-save me-1"></i>Save Signature
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const CURRENT_USER_ID = {{ auth()->id() }};
    </script>
    <script>
        $(document).ready(function() {

            function formatDate(dateString) {
                let date = new Date(dateString);
                let day = date.getDate().toString().padStart(2, '0');
                let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
                let year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            // Fetch
            fetchAgreement();

            function fetchAgreement() {
                Swal.fire({
                    title: 'Please Wait...',
                    text: 'Agreements Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "{{ route('sign.agreements.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";
                        $.each(data, function(index, agreement) {
                            rows += `<tr>
                    <td>${index + 1}</td>
                    <td>${agreement.title}</td>
                    <td>${agreement.signed === 'Signed' ? '<span class="badge bg-success">Signed</span>' : '<span class="badge bg-warning">Pending</span>'}</td>
                    <td>${agreement.status}</td>
                    <td>${agreement.date}</td>
                    <td>${agreement.createdBy}</td>
                    <td>
                        <div>
                            <button class="btn btn-link p-0 view-btn" type="button" data-id="${agreement.id}" title="View">
                                <span class="text-secondary fas fa-eye"></span>
                            </button>
                        </div>
                    </td>
                </tr>`;
                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {
                            valueNames: ['type', 'title', 'target', 'status', 'date',
                                'createdBy'
                            ],
                            page: 10,
                            pagination: true
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }

            $(document).on('click', '.view-btn', function() {
                let agreementId = $(this).data('id');

                Swal.fire({
                    title: 'Please wait...',
                    text: 'Loading agreement...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: `/sign-agreement/${agreementId}`,
                    type: 'GET',
                    success: function(response) {
                        Swal.close();

                        const agreement = response.agreement;
                        currentAgreementId = agreement.id;

                        function formatDate(date) {
                            return date ? new Date(date).toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            }) : '-';
                        }

                        $('#view_title').text(agreement.title);
                        $('#view_description').html(agreement.description);
                        $('#view_status').text(agreement.status);
                        $('#view_activated_at').text(formatDate(agreement.activated_at));
                        $('#view_created_by').text(agreement.created_by);
                        $('#view_created_at').text(formatDate(agreement.created_at));
                        $('#view_updated_by').text(agreement.updated_by || '-');
                        $('#view_updated_at').text(formatDate(agreement.updated_at));

                        // Render only authenticated user's signature
                        let signaturesHtml = '';
                        if (agreement.signature) {
                            signaturesHtml = `<small class="text-center">
                    <img src="${agreement.signature.signature}" alt="Signature" style="height:100px; border:1px solid #ccc;">
                    <br>
                    ${agreement.signature.user_name} | ${agreement.signature.signed_at}
                </small>`;
                            $('#signAgreementBtn').hide(); // user already signed
                        } else {
                            signaturesHtml = '<p>No signature yet.</p>';
                            $('#signAgreementBtn').show(); // show button if not signed
                        }
                        $('#view_signatures').html(signaturesHtml);

                        $('#viewModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.close();
                        Swal.fire('Error', 'Unable to fetch agreement details.', 'error');
                    }
                });
            });



            $(document).on('click', '#downloadAgreementBtn', function() {
                // Select the modal body content
                const element = document.querySelector('#viewModal .modal-body');

                // PDF options
                var opt = {
                    margin: 0,
                    filename: `Agreement_${$('#view_title').text()}.pdf`,
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'portrait'
                    }
                };

                // Generate PDF
                html2pdf().set(opt).from(element).save();
            });

        });
    </script>
    <script>
        let signaturePad;
        let currentAgreementId = null;

        $(document).on('click', '#signAgreementBtn', function() {
            const canvas = document.getElementById('signaturePad');
            resizeCanvas(canvas);

            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
            });

            $('#signatureModal').modal('show');
        });

        // Fix for canvas not drawing
        function resizeCanvas(canvas) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const rect = canvas.getBoundingClientRect();

            canvas.width = rect.width * ratio;
            canvas.height = rect.height * ratio;

            const ctx = canvas.getContext('2d');
            ctx.scale(ratio, ratio);
        }

        // Resize again after modal shown (important!)
        $('#signatureModal').on('shown.bs.modal', function() {
            const canvas = document.getElementById('signaturePad');
            resizeCanvas(canvas);
            if (signaturePad) signaturePad.clear();
        });

        // Clear signature
        $(document).on('click', '#clearSignature', function() {
            if (signaturePad) signaturePad.clear();
        });

        // Save signature
        $(document).on('click', '#saveSignature', function() {
            if (!signaturePad || signaturePad.isEmpty()) {
                Swal.fire('Empty Signature', 'Please sign before saving.', 'warning');
                return;
            }

            const signatureData = signaturePad.toDataURL('image/png');

            Swal.fire({
                title: 'Saving signature...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            navigator.geolocation.getCurrentPosition(function(pos) {
                sendSignature(signatureData, pos.coords.latitude, pos.coords.longitude);
            }, function() {
                sendSignature(signatureData, null, null);
            });

            function sendSignature(signature, lat, long) {
                $.ajax({
                    url: '/sign-agreement/' + currentAgreementId + '/sign',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        signature: signature,
                        sign_lat: lat,
                        sign_long: long
                    },
                    success: function(res) {
                        Swal.close();
                        $('#signatureModal').modal('hide');
                        Swal.fire('Signed!', res.message, 'success');
                        $('#viewModal').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        Swal.close();
                        Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong.',
                            'error');
                    }
                });
            }
        });
    </script>
@endsection
