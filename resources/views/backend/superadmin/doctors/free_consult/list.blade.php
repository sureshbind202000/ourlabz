@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Free Consultation Bookings - Pending</h5>
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
                                    <th class="text-900 text-center">Action</th>
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
    <!-- Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="scheduleForm">
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time"
                                required>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveScheduleBtn">Save Schedule</button>
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
                    url: "{{ route('free-conult.booking.list') }}",
                    type: "GET",
                    success: function(data) {
                        $('.loading').hide();
                        let rows = "";

                        if (data.length === 0) {
                            rows =
                                `<tr><td colspan="6" class="text-center">No bookings found.</td></tr>`;
                        } else {
                            $.each(data, function(index, booking) {
                                let formattedDate = booking.appointment_date ?
                                    formatDate(booking.appointment_date) + ' ' + booking
                                    .appointment_time :
                                    '<a href="javascript:void(0);" class="btn btn-sm btn-falcon-warning fs-11" ' +
                                    'data-bs-toggle="modal" data-bs-target="#scheduleModal" ' +
                                    'title="Click to schedule date and time for patient." ' +
                                    'data-id="' + booking.id + '" id="booking-date-' + booking.id + '">Schedule</a>';
                                let consultationType = 'N/A';
                                if (booking.consultation_type == 1) {
                                    consultationType = 'Visit';
                                } else if (booking.consultation_type == 2) {
                                    consultationType = 'Online';
                                }

                                let userName = booking.user?.name ?? 'Unknown';
                                let phone = booking.user?.phone ?? 'Unknown';
                                let patientId = booking.user?.user_id ?? 'Unknown';
                                let bookingId = booking.encrypted_id ?? 'Unknown';

                                rows += `<tr>
                <td>${index + 1}</td>
                <td class="userid">${patientId}</td>
                <td class="name"><a href="/free-consultation/booking/${bookingId}/profile">${userName}</a></td>
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
                <td>
                    <div class="text-center">
                        <a class="btn btn-falcon-secondary btn-sm" href="/free-consultation/booking/${bookingId}/profile" data-bs-toggle="tooltip" title="View">
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

            $('#scheduleModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget); // Button that triggered the modal
                let bookingId = button.data('id'); // Extract info from data-id
                $("#scheduleForm").attr("data-id", bookingId); // Store in form for AJAX
            });

            $(document).on("click", "#saveScheduleBtn", function() {
                let date = $("#appointment_date").val();
                let time = $("#appointment_time").val();

                // get booking id from hidden field or modal data
                let bookingId = $("#scheduleForm").data("id");

                if (!date || !time) {
                    alert("Please select both date and time.");
                    return;
                }

                $.ajax({
                    url: "{{ route('update.free-conult.schedule') }}", // 🔹 Laravel route
                    type: "POST",
                    data: {
                        appointment_date: date,
                        appointment_time: time,
                        booking_id: bookingId, // ✅ now using correct dynamic id
                    },
                    success: function(response) {
                        // Close modal
                        $("#scheduleModal").modal("hide");

                        // Update formatted date cell without reload
                        if (response.appointment_date && response.appointment_time) {
                            let formatted = response.appointment_date + " " + response
                                .appointment_time;
                            $("#booking-date-" + bookingId).html(
                            formatted); // ✅ update correct row
                        } else {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert("Something went wrong. Please try again.");
                    }
                });
            });



        });
    </script>
@endsection
