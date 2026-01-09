@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Refered Tests</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["labid","labname","phone","status","date","test"],"page":10,"pagination":true}'>
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
                                    <th class="text-900" data-sort="labid">Lab ID</th>
                                    <th class="text-900" data-sort="labname">Name</th>
                                    <th class="text-900" data-sort="phone">Phone</th>
                                    <th class="text-900" data-sort="test">Test</th>
                                    <th class="text-900" data-sort="status">Status</th>
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

            $('#addModalBtn').on('click', function() {
                $('#addModal').modal('show');
            });

            // Fetch
            fetchData();

            function fetchData() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Fetching referred tests, please wait.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "{{ route('refering-tests-list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";
                        $.each(data, function(index, refered) {
                            let patientName = refered.test?.patient?.name ?? '-';
                            let patientPhone = refered.test?.patient?.phone ?? '-';
                            let packageName = refered.test?.package?.name ?? '-';

                            rows += `<tr>
                            <td>${index + 1}</td>
                            <td class="labid">${refered.lab.lab_id ?? '-' }</td>
                            <td class="labname">${refered.lab.lab_name ?? '-' }</td>
                            <td class="phone">${refered.lab.phone ?? '-' }</td>
                            <td class="testpatient">
                    ${packageName}
                    <br>
                    <small><strong>Patient:</strong> ${patientName}</small><br>
                    <small><strong>Phone:</strong> ${patientPhone}</small>
                </td>
                            <td class="status change-status cursor-pointer" data-id="${refered.id}" data-current="${refered.status}">
                       
                            ${getReferedStatusBadge(refered.status)}
                    </td>
                            <td class="date">${formatDate(refered.created_at)}</td>
                        </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['labid', 'labname', 'testpatient', 'date', 'status'],
                            page: 10,
                            pagination: true
                        });
                        attachEventHandlers();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.close();
                    }
                });
            }

            function getReferedStatusBadge(status) {
                switch (status) {
                    case 0:
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    case 1:
                        return '<span class="badge bg-info">Confirmed</span>';
                    case 2:
                        return '<span class="badge bg-danger">Cancelled</span>';
                    case 3:
                        return '<span class="badge bg-success">Completed</span>';
                    default:
                        return '<span class="badge bg-secondary">Unknown</span>';
                }
            }

            function attachEventHandlers() {
                // Delete
                $(".delete-btn").click(function() {
                    let id = $(this).data("id");

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this referral?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/refering-tests/delete/${id}`,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    Swal.fire('Deleted!', res.message, 'success');
                                    fetchData();
                                }
                            });
                        }
                    });
                });

                // Change Status
                $(".change-status").click(function() {
                    let id = $(this).data("id");
                    let current = $(this).data("current");

                    Swal.fire({
                        title: 'Update Status',
                        input: 'select',
                        inputOptions: {
                            0: 'Pending',
                            1: 'Confirmed',
                            2: 'Cancelled',
                            3: 'Completed'
                        },
                        inputValue: current,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                    }).then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('refering-tests.changeStatus') }}",
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id,
                                    status: result.value
                                },
                                success: function(res) {
                                    Swal.fire('Updated!', res.message, 'success');
                                    fetchData();
                                }
                            });
                        }
                    });
                });
            }

        });
    </script>
@endsection
