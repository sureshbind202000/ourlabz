@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">New Bookings</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3"

                data-list='{"valueNames":["userid","name","phone","schedule","payment","status","date","tests"],"page":10,"pagination":true}'>

                {{-- <div class="row justify-content-end g-0">

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

                </div> --}}

                <div class="row align-items-center g-0 mb-2">

                    <!-- Search -->
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group">
                                <input class="form-control form-control-sm shadow-none search"
                                    type="search"
                                    placeholder="Search..."
                                    aria-label="search" />
                                <div class="input-group-text bg-transparent">
                                    <span class="fa fa-search fs-10 text-600"></span>
                                </div>
                            </div>
                        </form>
                    </div>

                     <!-- Legend -->
                    <div class="col-auto me-3 ms-auto">
                       <span class="badge bg-danger bg-opacity-10 text-danger border border-danger me-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Emergency
                        </span>

                        <span class="badge bg-info bg-opacity-10 text-info border border-info">
                            <i class="fa-solid fa-envelope-open-text me-1"></i> Unread
                        </span>

                    </div>
                    <!-- Add Button -->
                    <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1"
                                type="button"
                                id="addModalBtn">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </div>

                </div>

                <div class="table-responsive scrollbar">

                    <table class="table table-bordered table-striped fs-10 mb-0">

                        <thead class="bg-200">

                            <tr>

                               <th class="text-900" data-sort="date">Date</th>

                                <th class="text-900" data-sort="userid">Patient ID</th>

                                <th class="text-900" data-sort="name">Name</th>

                                <th class="text-900" data-sort="phone">Phone</th>

                                <th class="text-900" data-sort="status">Status</th>

                                <th class="text-900" data-sort="payment">Payment</th>

                                <th class="test-900" data-sort="emergency">Emergency</th>


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


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

    aria-hidden="true">

    <div class="modal-dialog mt-6 modal-xl" role="document">

        <div class="modal-content border-0">

            <div class="modal-header position-relative modal-shape-header bg-shape">

                <div class="position-relative z-1">

                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add New Booking</h4>

                    <p class="fs-10 mb-0 text-white">Fill the form to create new booking.</p>

                </div>

                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                        data-bs-dismiss="modal" aria-label="Close"></button></div>

            </div>

            <div class="modal-body  px-4 pb-4">

                <form action="{{ route('lab.booking.store') }}" id="labBookingStore" method="POST" enctype="multipart/form-data" class="row text-dark">
                    @csrf

                    <div class="col-md-6 mb-3">
                        <label for="lab_name" class="form-label">Booking Lab</label>
                        <input type="text" name="lab_name" id="lab_name" class="form-control" value="{{ $lab->lab_name }}" readonly>
                        <input type="hidden" name="lab_id" value="{{ $lab->lab_id }}">
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
                        <label class="form-label">Schedule For</label>
                        <select name="schedule_for" class="form-select" required>
                            <option value="">--select--</option>
                            <option value="1">Home Collection</option>
                            <option value="0">Lab Visit</option>
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
                                <input type="date" id="dob" name="dob" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Patient phone" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Select Address</label>
                                <select name="address" id="address" class="form-select">
                                    <option value="">--select--</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="booking_test" class="form-label">Select Tests</label>
                                <select name="booking_test[]" id="booking_test" class="form-select js-choice" multiple required>
                                    <option value="">--select--</option>
                                    @foreach($tests as $test)
                                    <option value="{{ $test->package_id }}">{{ $test->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Subtotal</label>
                                <input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="Auto calculate" required readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Total Amount</label>
                                <input type="text" name="total_amount" id="total_amount" class="form-control" placeholder="Auto calculate" required readonly>
                            </div>

                            <div class="col-12">
                                <ul id="testList" class="list-group"></ul>
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

                url: "{{ route('patient.booking.list', request()->query()) }}",

                type: "GET",

                success: function(data) {

                    $('.loading').hide();

                    let rows = "";

                    $.each(data, function(index, booking) {


                        let rowClass = '';

                        if (booking.is_emergency == 1) {
                            rowClass = 'table-danger bg-opacity-10'; // light red
                        } else if (booking.is_read == 0) {
                            rowClass = 'table-info bg-opacity-10'; // light yellow
                        }

                        rows += `<tr class="${rowClass}">

                            <td class="date">${formatDate(booking.created_at)}</td>

                            <td class="userid">${booking.user ? booking.user.user_id : '-'}</td>

                            <td class="name">${booking.user ? booking.user.name : 'N/A'}</td>

                            <td class="phone">${booking.user ? booking.user.phone : 'N/A'}</td>

                            <td class="status">${getBookingStatusBadge(booking.status)}</td>

                            <td class="payment">${getPaymentBadge(booking.payment_status)}</td>

                            <!-- Emergency Toggle Column -->
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input
                                        class="form-check-input emergency-toggle"
                                        type="checkbox"
                                        data-id="${booking.id}"
                                        ${booking.is_emergency == 1 ? 'checked' : ''}
                                    >
                                </div>
                            </td>

                            <td class="text-center">

                                <div>

                                     <a class="btn btn-sm btn-falcon-primary" href="{{ url('/') }}/booking/${booking.encrypted_id}/details" data-bs-toggle="tooltip"

                                                    data-bs-placement="top" title="View" data-id="${booking.id}"><span

                                                        class="text-secondary fas fa-eye"></span></a>

                                                        <!-- @if (has_permission('booking', 'delete'))

                                                        <button

                                                    class="btn btn-sm btn-falcon-danger ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                                                    data-bs-placement="top" title="Reject" data-id="${booking.id}"><i class="fa-solid fa-xmark"></i></button>

                                                    @endif -->

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

                error: function(xhr) {

                    console.log(xhr);

                }

            });

        }

        $(document).on('change', '.emergency-toggle', function () {

            let bookingId = $(this).data('id');
            let isEmergency = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('patient.booking.toggle-emergency') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    booking_id: bookingId,
                    is_emergency: isEmergency
                },
                success: function (res) {
                    fetchData(); // reload table
                },
                error: function () {
                    alert('Something went wrong');
                }
            });
        });



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

                case 'In Progress':

                    return '<span class="badge bg-info ">In Progress</span>';

                default:

                    return '<span class="badge bg-secondary">Unknown</span>';

            }

        }





        // Delete

        $(document).on('click', '.delete-btn', function() {

            let bookingId = $(this).data('id');



            Swal.fire({

                title: "Are you sure?",

                text: "This will delete the booking and all related data!",

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#d33",

                cancelButtonColor: "#3085d6",

                confirmButtonText: "Yes, delete it!"

            }).then((result) => {

                if (result.isConfirmed) {

                    $('.loading').show();



                    $.ajax({

                        url: `/bookings/${bookingId}`, // <-- URL to DELETE

                        type: "DELETE",

                        data: {

                            _token: "{{ csrf_token() }}"

                        },

                        success: function(response) {

                            $('.loading').hide();



                            if (response.success) {

                                Swal.fire("Deleted!",

                                    "The booking and related data have been deleted.",

                                    "success");

                                fetchData(); // Reload your bookings list

                            } else {

                                Swal.fire("Error!", "Something went wrong.",

                                    "error");

                            }

                        },

                        error: function(xhr) {

                            $('.loading').hide();

                            Swal.fire("Error!", "Failed to delete booking.",

                                "error");

                        }

                    });

                }

            });

        });

        // Add New Booking Modal
        $('#addModalBtn').on('click', function() {

            $('#addModal').modal('show');

        });



    });
</script>

<script>
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

        // 🔹 Calculate totals when test selected
        function calculateTotals() {
            let selectedIds = $('#booking_test').val();
            let patientId = $('#patient').val();

            if (!patientId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select a patient first',
                    text: 'Please select a patient before choosing tests.',
                });
                $('#booking_test').val([]).trigger('change');
                return;
            }

            if (!selectedIds || selectedIds.length === 0) {
                $('#subtotal').val('0.00');
                $('#total_amount').val('0.00');
                $('#testList').html('<li class="list-group-item text-muted">No tests selected</li>');
                return;
            }

            $.ajax({
                url: "{{ route('get.tests.prices') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    test_ids: selectedIds,
                    patient_id: patientId
                },
                success: function(response) {
                    let subtotal = 0;
                    let selectedTests = [];

                    response.tests.forEach(test => {
                        let price = parseFloat(test.final_price) || 0;
                        subtotal += price;
                        selectedTests.push({
                            name: test.name,
                            price
                        });
                    });

                    $('#subtotal').val(subtotal.toFixed(2));
                    $('#total_amount').val(subtotal.toFixed(2));

                    let listHtml = selectedTests.map(test => `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${test.name}
                        <span class="badge bg-primary rounded-pill">₹${test.price}</span>
                    </li>
                `).join('');

                    $('#testList').html(listHtml);
                },
                error: function() {
                    Swal.fire('Error', 'Failed to fetch test details.', 'error');
                }
            });
        }

        // Trigger calculation when test changes
        $('#booking_test').on('change', calculateTotals);

        // Razorpay Checkout Integration
        $('#labBookingStore').on('submit', async function(e) {
            e.preventDefault();

            const patientId = $('#patient').val();
            const totalAmount = $('#total_amount').val();

            if (!patientId) return Swal.fire('Error', 'Please select a patient', 'error');
            if (!totalAmount || totalAmount <= 0) return Swal.fire('Error', 'Please select at least one test', 'error');

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
                    key: "{{ config('serv-ices.razorpay.key') }}",
                    amount: data.amount,
                    currency: data.currency,
                    name: "OurLabz",
                    description: "Lab Test Booking Payment",
                    order_id: data.order_id,
                    handler: async function(response) {
                        Swal.fire({
                            title: 'Finalizing Booking...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        // Step 3️⃣ — Save booking after payment success
                        const formData = new FormData($('#labBookingStore')[0]);
                        formData.append('payment_status', 'Paid');
                        formData.append('razorpay_payment_id', response.razorpay_payment_id);
                        formData.append('razorpay_order_id', response.razorpay_order_id);
                        formData.append('razorpay_signature', response.razorpay_signature);

                        $.ajax({
                            url: "{{ route('lab.booking.store') }}",
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
