@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Free Consultation Bookings - Completed</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">
            <div id="tableExample3"
                data-list='{"valueNames":["userid","name","phone","email"],"page":10,"pagination":true}'>
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
                    {{-- <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i
                                class="fa-solid fa-plus"></i> Add</button>
                    </div> --}}
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900">S.No.</th>
                                <th class="text-900" data-sort="userid">Patient Id</th>
                                <th class="text-900" data-sort="name">Name</th>
                                <th class="text-900" data-sort="phone">Phone</th>
                                <th class="text-900" data-sort="booking_date">Booking Date</th>
                                <th class="text-900" data-sort="phone">Consultation Type</th>
                                <th class="text-900" data-sort="status">Status</th>
                                <th class="text-900" data-sort="referred_to">Referred To</th>
                                <th class="text-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <tr>
                                <td>1</td>
                                <td class="name">PT12345</td>
                                <td class="date">user</td>
                                <td class="phone">xxx xxx xxx</td>
                                <td class="date">dd/mm/yy</td>
                                <td class="email">Online</td>
                                <td class="email">inactive</td>
                                <td class="email">doctor</td>
                                <td>
                                    <div><a class="btn btn-link p-0" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="View"><span
                                                class="text-500 fas fa-eye"></span></a>
                                        <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><span
                                                class="text-500 fas fa-edit"></span></button><button
                                            class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><span
                                                class="text-500 fas fa-trash-alt"></span></button>
                                    </div>
                                </td>
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
        fetchBookings();

        function fetchBookings() {
            $('.loading').show();
            $.ajax({
                url: "{{ route('doctor.bookings.get') }}",
                type: "GET",
                success: function(data) {
                    $('.loading').hide();
                    let rows = "";

                    if (data.length === 0) {
                        rows = `<tr><td colspan="6" class="text-center">No bookings found.</td></tr>`;
                    } else {
                        $.each(data, function(index, booking) {
                            let formattedDate = formatDate(booking.appointment_date);
                            let consultationType = 'N/A';
                            if (booking.consultation_type == 1) {
                                consultationType = 'Visit';
                            } else if (booking.consultation_type == 2) {
                                consultationType = 'Online';
                            }

                            let userName = booking.user?.name ?? 'Unknown';
                            let phone = booking.user?.phone ?? 'Unknown';
                            let patientId = booking.user?.user_id ?? 'Unknown';
                            let bookingId = booking.id ?? 'Unknown';
                            let referredToName = booking.referred?.referred_to_user?.name ?? 'N/A';
                            rows += `<tr>
                <td>${index + 1}</td>
                <td class="userid">${patientId}</td>
                <td class="name"><a href="/booking/${bookingId}/profile">${userName}</a></td>
                <td class="phone">${phone}</td>
                <td class="booking_date">${formattedDate}</td>
                <td class="consultation_type">${consultationType}</td>
                <td>
                <a href="javascript:void(0)" style="text-decoration:none" 
                class="badge ${booking.status == 0 ? 'bg-primary' : booking.status == 1 ? 'bg-success' : 'bg-secondary'}"  
                data-id="${booking.id}">
                ${booking.status == 0 ? 'Confirmed' : booking.status == 1 ? 'Completed' : 'Unknown'}
                </a>
                </td>
                <td class="consultation_type">${referredToName}</td>
                <td>
                    <div>
                        <a class="btn btn-link p-0" href="/booking/${bookingId}/profile" data-bs-toggle="tooltip" title="View">
                            <span class="text-secondary fas fa-eye"></span>
                        </a>
                    </div>
                </td>
            </tr>`;
                        });
                    }

                    $("tbody.list").html(rows);

                    if (!window.listInitialized) {
                        new List('tableExample3', {
                            valueNames: ['userid', 'name', 'phone', 'email'],
                            page: 10,
                            pagination: true
                        });
                        window.listInitialized = true;
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Ajax Error", xhr, status, error);
                }
            });
        }

        // Helper function to format date
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return `${date.getDate().toString().padStart(2, '0')}/${
                (date.getMonth() + 1).toString().padStart(2, '0')
            }/${date.getFullYear()}`;
        }
        $(document).on('click', '.status-toggle', function() {
            const $this = $(this);
            const bookingId = $this.data('id');

            let currentStatus = $this.text().trim() === 'Confirmed' ? 0 : 1;
            let newStatus = currentStatus === 0 ? 1 : 0;
            console.log(newStatus);
            $.ajax({
                url: `/booking/${bookingId}/toggle-status`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function(response) {
                    fetchBookings();
                    $this.text(newStatus === 0 ? 'Confirmed' : 'Completed');
                    Swal.fire('Success', response.message, 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Unable to update status.', 'error');
                }
            });
        });

    });
</script>
@endsection