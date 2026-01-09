@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Sample Collections - Pending</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["orderid","name","phone","timeslot","note","status","date"],"page":10,"pagination":true}'>
                    <div class="row justify-content-end g-0">
                        <div class="col-auto col-sm-5 mb-3 me-auto">
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
                                    <th class="text-900" data-sort="orderid">Order ID</th>
                                    <th class="text-900" data-sort="name">Name</th>
                                    <th class="text-900" data-sort="phone">Phone</th>
                                    <th class="text-900" data-sort="timeslot">Time Slot</th>
                                    <th class="text-900" data-sort="note">Note</th>
                                    <th class="text-900" data-sort="status">Status</th>
                                    <th class="text-900" data-sort="date">Date</th>
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
    <div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="rejectReasonForm">
                @csrf
                <input type="hidden" name="sample_id" id="reject_collection_id">
                <input type="hidden" name="status" value="5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Collection</h5>
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

            $('#addModalBtn').on('click', function() {
                $('#addModal').modal('show');
            });

            // Fetch
            fetchData();

            function fetchData() {
                $('.loading').show();
                $.ajax({
                    url: "{{ route('samplecollection.list') }}",
                    type: "GET",
                    success: function(data) {
                        $('.loading').hide();
                        let rows = "";
                        $.each(data, function(index, samplecollection) {
                            rows += `<tr>
                            <td>${index + 1}</td>
                            <td class="orderid">${samplecollection.order_id}</td>
                            <td class="name">${samplecollection.user.name}</td>
                            <td class="phone">${samplecollection.user.phone}</td>
                            <td class="timeslot">
                                <b>Date : </b> ${formatDate(samplecollection.booking.booking_date)} <br>
                                <b>Time : </b> ${samplecollection.booking.time_slot} <br>
                            </td>
                            <td class="note">${samplecollection.note}</td>
                            <td class="status">${getTrackStatusBadge(samplecollection.status)}</td>
                            <td class="date">${formatDate(samplecollection.created_at)}</td>
                            <td>
                                
                                     <a class="btn btn-sm btn-falcon-primary me-1 ${samplecollection.status == 5 ? 'd-none' : ''}" href="{{ url('/') }}/sample-collection/${samplecollection.encrypted_id}/details" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="View sample collection details"><span
                                                        class="fas fa-eye"></span></a>
                                     <a class="btn btn-sm btn-falcon-danger reject-collection ${samplecollection.status == 5 ? 'd-none' : ''}" data-collection-id="${samplecollection.id }" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Reject sample collection"><span
                                                        class="fas fa-ban"></span></a>
                                
                            </td>
                        </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ["orderid", "name", "phone", "timeslot", "note",
                                "status", "date", "orderid"
                            ],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            function getTrackStatusBadge(status) {
                switch (status) {
                    case 0:
                        return '<span class="badge bg-warning text-dark">Not Collected</span>';
                    case 1:
                        return '<span class="badge bg-info">Collected</span>';
                    case 2:
                        return '<span class="badge bg-success">Submitted</span>';
                    case 3:
                        return '<span class="badge bg-success">Accepted</span>';
                    case 4:
                        return '<span class="badge bg-danger">Rejected</span>';
                    case 5:
                        return '<span class="badge bg-danger">Collection Rejected By You</span>';
                    default:
                        return '<span class="badge bg-secondary">Unknown</span>';
                }
            }

        });

        // Open reject modal
        $(document).on('click', '.reject-collection', function() {
            const collection = $(this).data('collection-id');
            $('#reject_collection_id').val(collection);
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
    </script>
@endsection
