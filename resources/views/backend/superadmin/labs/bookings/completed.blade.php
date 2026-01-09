@extends('backend.includes.layout')

@section('content')

    <div class="card mb-3">

        <div class="card-header">

            <div class="row flex-between-end">

                <div class="col-auto align-self-center">

                    <h5 class="mb-0" data-anchor="data-anchor">Completed Bookings</h5>

                </div>

            </div>

        </div>

        <div class="card-body pt-0">

            <div class="tab-content">



                <div id="tableExample3"

                    data-list='{"valueNames":["userid","name","phone","schedule","payment","status","date","tests"],"page":10,"pagination":true}'>

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

                                    <th class="text-900" data-sort="userid">Patient ID</th>

                                    <th class="text-900" data-sort="name">Name</th>

                                    <th class="text-900" data-sort="phone">Phone</th>

                                    <th class="text-900" data-sort="status">Status</th>

                                    <th class="text-900" data-sort="payment">Payment</th>

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

            fetchData();



            function fetchData() {

                $('.loading').show();

                $.ajax({

                    url: "{{ route('patient.booking.list.completed') }}",

                    type: "GET",

                    success: function(data) {

                        $('.loading').hide();

                        let rows = "";

                        $.each(data, function(index, booking) {

                            rows += `<tr>

                            <td>${index + 1}</td>

                            <td class="userid">${booking.user ? booking.user.user_id : '-'}</td>

                            <td class="name">${booking.user ? booking.user.name : 'N/A'}</td>

                            <td class="phone">${booking.user ? booking.user.phone : 'N/A'}</td>

                            <td class="status">${getBookingStatusBadge(booking.status)}</td>

                            <td class="payment">${getPaymentBadge(booking.payment_status)}</td>

                            <td class="date">${formatDate(booking.created_at)}</td>

                            <td>

                                <div>

                                     <a class="btn btn-sm btn-falcon-primary" href="{{ url('/') }}/booking/${booking.encrypted_id}/details" data-bs-toggle="tooltip"

                                                    data-bs-placement="top" title="View" data-id="${booking.id}"><span

                                                        class="text-secondary fas fa-eye"></span></a>

                                                        </div>

                                

                            </td>

                        </tr>`;

                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {

                            valueNames: ['userid', 'name', 'phone', 'payment', 'status',

                                'schedule', 'tests',

                                'sample', 'date'

                            ],

                            page: 10,

                            pagination: true

                        });

                    },

                    error: function(xhr){

                        console.log(xhr);

                    }

                });

            } 



            function getPaymentBadge(status) {

                switch (status) {

                    case 'Paid':

                        return '<span class="badge bg-success">Paid</span>';

                    case 'Unpaid':

                        return '<span class="badge bg-warning text-dark">Unpaid</span>';

                    case 'Failed':

                        return '<span class="badge bg-danger">Failed</span>';

                    default:

                        return '<span class="badge bg-secondary">Unknown</span>';

                }

            }



            function getBookingStatusBadge(status) {

                switch (status) {

                    case 'Pending':

                        return '<span class="badge bg-warning text-dark">Pending</span>';

                    case 'Confirmed':

                        return '<span class="badge bg-info">Confirmed</span>';

                    case 'Cancelled':

                        return '<span class="badge bg-danger">Cancelled</span>';

                    case 'Completed':

                        return '<span class="badge bg-success">Completed</span>';

                    default:

                        return '<span class="badge bg-secondary">Unknown</span>';

                }

            }



            function getSampleIcon(status) {

                switch (status) {

                    case 1:

                        return 'Yes';

                    case 0:

                        return 'No';

                }

            }



        });

    </script>

@endsection

