@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Reports Verify/Certify - Completed</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3" data-list='{"valueNames":["name","status"],"page":10,"pagination":true}'>
                    <div class="row justify-content-end g-0">
                        <div class="col-auto col-sm-5 mb-3">
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
                                    <th class="text-900" data-sort="name">Test Info.</th>
                                    <th class="text-900">Verify</th>
                                    <th class="text-900">Certify</th>
                                    <th class="text-900">Report</th>
                                    <th class="text-900" data-sort="date">Date</th>
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
                    <iframe id="reportPdfFrame" src="" width="100%" height="600px" style="border: none;"></iframe>
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
                    <button type="button" class="btn btn-success" id="confirmCertifyBtn" data-test-id="">Certify</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            function formatDate(dateString) {
                let date = new Date(dateString);
                let day = date.getDate().toString().padStart(2, '0');
                let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
                let year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            fetchTests();

            function fetchTests() {
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Loading Tests...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('report.verify_certify_completed.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";

                        $.each(data, function(index, test) {
                            let hasReport = test.report_file !== null && test.report_file !==
                                "";
                            let isVerified = test.verify === "Verified";
                            let isCertified = test.certify === "Certified";

                            let verifyCheckbox = hasReport ?
                                `<div class="form-check">
                        <input type="checkbox"
                            class="form-check-input verify-report-checkbox mx-auto"
                            ${!isVerified ? 'data-bs-toggle="modal" data-bs-target="#verifyReportModal"' : ''}
                            data-report-url="${test.report_file ? assetPath(test.report_file) : ''}"
                            data-test-id="${test.id}"
                            data-verified="${isVerified ? '1' : '0'}"
                            ${isVerified ? 'checked disabled' : ''} />
                    </div>` :
                                '<span class="text-muted">No report</span>';

                            let certifyCheckbox = hasReport ?
                                `<div class="form-check">
                        <input type="checkbox"
                            class="form-check-input certify-report-checkbox mx-auto"
                            ${!isCertified ? 'data-bs-toggle="modal" data-bs-target="#certifyReportModal"' : ''}
                            data-report-url="${test.report_file ? assetPath(test.report_file) : ''}"
                            data-test-id="${test.id}"
                            data-certified="${isCertified ? '1' : '0'}"
                            ${isCertified ? 'checked disabled' : ''} />
                    </div>` :
                                '<span class="text-muted">No report</span>';

                            rows += `<tr>
                    <td>${index + 1}</td>
                    <td class="name"><strong>${test.package.name}</strong> <br> ${test.patient.name} <br> <small>Gender : ${test.patient.gender} | Age : ${test.patient.age ?? "N/A"}</small></td>
                    <td>${verifyCheckbox}</td>
                    <td>${certifyCheckbox}</td>
                    <td><a href="${test.report_file ? assetPath(test.report_file) : ''}" target="_blank">view</a></td>
                    <td class="date">${formatDate(test.created_at)}</td>
                </tr>`;
                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {
                            valueNames: ['name', 'date', 'status', 'sort'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            function assetPath(path) {
                return `${window.location.origin}/${path}`;
            }

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
                                console.log(xhr);
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

        });
    </script>
@endsection
