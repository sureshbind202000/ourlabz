@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">All Bookings - New</h5>

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

                    <div class="col-auto ms-auto">

                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i

                                class="fa-solid fa-plus"></i> Add</button>

                    </div>

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

<!-- Add Consultation Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog mt-6 modal-xl" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add New Consultation</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new Consultation.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form action="{{ route('doctor.self.booking') }}" id="doctorBookingStore" method="POST" enctype="multipart/form-data" class="row text-dark">
                    @csrf

                    <div class="col-md-6 mb-3">
                        <label for="doc_name" class="form-label">Consultation Doctor</label>
                        <input type="text" name="doc_name" id="doc_name" class="form-control" value="{{ $doctor->name }}" readonly>
                        <input type="hidden" name="doctor_id" value="{{ $doctor->user_id }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="date" class="form-label">Booking Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="time" class="form-label">Time Slot</label>
                        <input type="time" name="time" id="time" class="form-control" required>
                    </div>



                    <div class="col-md-4 mb-3">
                        <label for="patient" class="form-label">Select Patient</label>
                        <select name="patient" id="patient" class="form-select js-choice" required>
                            <option value="">--select--</option>
                            @foreach($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->name }} - ({{ $user->user_id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- {{-- Schedule For (Home/Lab) --}} -->
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Consultation Mode</label>
                        <select name="consult_mode" class="form-select" required>
                            <option value="">--select--</option>
                            <option value="2">Online</option>
                            <option value="1">Offline</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                         <label class="form-label">Prescription (Optional)</label>
                         <input type="file" name="prescription" id="prescription" class="form-control">
                    </div>

                    <!-- Hidden until patient selected -->
                    <div class="patient-dependent">
                        <div class="row">
                            <!-- {{-- Auto-Filled Patient Info --}} -->
                            <div class="col-md-3 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Patient name" required readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="">--select--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Patient phone" required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Select Address</label>
                                <select name="address" id="address" class="form-select" required>
                                    <option value="">--select--</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Subtotal</label>
                                <input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="Auto calculate" value="{{$doctor->doctor_details->price}}" required readonly>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Total Amount</label>
                                <input type="text" name="total_amount" id="total_amount" class="form-control" placeholder="Auto calculate" value="{{$doctor->doctor_details->price}}" required readonly>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-success">Submit Booking</button>
                    </div>
                </form>


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

                class="badge ${booking.status == 0 ? 'bg-success' : booking.status == 1 ? 'bg-success' : 'bg-secondary'}"  

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
<!-- Booking Script -->
<script>
    // Add New Booking Modal
    $('#addModalBtn').on('click', function() {

        $('#addModal').modal('show');

    });

    $(document).ready(function() {

        // 🔹 Hide all dependent sections initially
        $('.patient-dependent').hide();

        // 🔹 When patient is selected
        $('#patient').on('change', function() {
            let patientId = $(this).val();

            if (patientId) {
                $.ajax({
                    url: "{{ url('/get-patient-info') }}/" + patientId,
                    type: "GET",
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;

                            // Fill patient info
                            $('#name').val(data.name ?? '');
                            $('#gender').val(data.gender ?? '');
                            $('#dob').val(data.dob ?? '');
                            $('#age').val(data.age ?? '');
                            $('#phone').val(data.phone ?? '');

                            // Populate addresses
                            $('#address').empty().append('<option value="">--select--</option>');
                            $.each(data.addresses, function(key, addr) {
                                $('#address').append('<option value="' + addr.id + '">' + addr.full + '</option>');
                            });

                            // 🔹 Show other sections now
                            $('.patient-dependent').slideDown();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire('Error', 'Failed to fetch patient info.', 'error');
                    }
                });
            } else {
                // Reset fields and hide sections if no patient selected
                $('#name, #gender, #dob, #age, #phone').val('');
                $('#address').empty().append('<option value="">--select--</option>');
                $('.patient-dependent').slideUp();
            }
        });

        // Razorpay Checkout Integration
        $('#doctorBookingStore').on('submit', async function(e) {
            e.preventDefault();

            const patientId = $('#patient').val();
            const totalAmount = $('#total_amount').val();

            if (!patientId) return Swal.fire('Error', 'Please select a patient', 'error');

            Swal.fire({
                title: 'Processing Payment...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                // Step 1️⃣ — Create Razorpay order
                const razorRes = await fetch("{{ url('/razorpay/checkout') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        amount: totalAmount,
                        type: 'test'
                    })
                });

                const data = await razorRes.json();
                Swal.close();

                if (!data.order_id) {
                    return Swal.fire('Error', 'Failed to initiate payment', 'error');
                }

                // Step 2️⃣ — Open Razorpay Payment
                const options = {
                    key: "{{ config('services.razorpay.key') }}",
                    amount: data.amount,
                    currency: data.currency,
                    name: "OurLabz",
                    description: "Doctor Consultation Booking Payment",
                    order_id: data.order_id,
                    handler: async function(response) {
                        Swal.fire({
                            title: 'Finalizing Booking...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        // Step 3️⃣ — Save booking after payment success
                        const formData = new FormData($('#doctorBookingStore')[0]);
                        formData.append('payment_status', 'Paid');
                        formData.append('razorpay_payment_id', response.razorpay_payment_id);
                        formData.append('razorpay_order_id', response.razorpay_order_id);
                        formData.append('razorpay_signature', response.razorpay_signature);

                        $.ajax({
                            url: "{{ route('doctor.self.booking') }}",
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Booking Confirmed!',
                                    text: res.message
                                }).then(() => window.location.reload());
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                Swal.fire('Error', xhr.responseJSON?.message || 'Booking failed', 'error');
                            }
                        });
                    },
                    theme: {
                        color: "#528FF0"
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();

            } catch (err) {
                Swal.close();
                Swal.fire('Error', 'Something went wrong while initiating payment', 'error');
                console.error(err);
            }
        });
    });
</script>

@endsection