@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Reports</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["patientid", "trackingid", "test","status","date"],"page":10,"pagination":true}'>
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
                                    <th class="text-900" data-sort="patientid">Patient ID</th>
                                    <th class="text-900" data-sort="trackingid">Tracking ID</th>
                                    <th class="text-900" data-sort="test">Test</th>
                                    <th class="text-900">Report</th>
                                    <th class="text-900" data-sort="status">Status</th>
                                    <th class="text-900" data-sort="date">Date</th>
                                    {{-- <th class="text-900">Action</th> --}}
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

            // Fetch
            fetchAllReports();

            function fetchAllReports() {
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Loading referring labs...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "{{ route('lab.all.report.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";

                        $.each(data, function(_, report) {
                            let reportHtml = report.report ?
                                `<a href="${report.report}" target="_blank">View Report</a>` :
                                'No Report';

                            rows += `<tr>
                <td>${report.sr_no}</td>
                <td class="patientid">${report.patient}</td>
                <td class="trackingid">${report.tracking_id}</td>
                <td class="test">${report.test}</td>
                <td>${reportHtml}</td>
                <td class="status">
                    <span class="badge ${report.status.includes("Not") ? 'bg-warning' : 'bg-success'}">${report.status}</span>
                </td>
                <td class="date">${report.date}</td>
            </tr>`;
                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {
                            valueNames: ['patientid', 'trackingid', 'test', 'status', 'date'],
                            page: 10,
                            pagination: true
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.close();
                        $("tbody.list").html('');
                    }
                });

            }
        });
    </script>
@endsection
