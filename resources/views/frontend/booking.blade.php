<!DOCTYPE html>
<html lang="en">

<head>
    <title>Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 offset-md-1 border p-4 shadow bg-light">
                <div class="col-12">
                    <h3 class="fw-normal text-secondary fs-4 text-uppercase mb-4">Test Booking form</h3>
                </div>
                <form id="bookingForm">
                    @csrf
                    <div class="row g-3">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->user_id }}">
                        <div class="col-6">
                            <label class="form-label">Lab</label>
                            <select class="form-select" name="lab_id" id="booking_lab_id">
                                <option value="">-- Select --</option>
                                @foreach ($labs as $lab)
                                    <option value="{{ $lab->lab_id }}">{{ $lab->lab_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tests</label>
                            <select class="form-select" name="package_id" id="package_id_select">
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <h4>
                            Patient Details <button type="button" class="btn btn-sm btn-primary mb-3"
                                data-bs-toggle="modal" data-bs-target="#addPatientModal">
                                + Add
                            </button>
                        </h4>
                        <div class="row">
                            <table class="table table-sm table-bordered border-primary text-center">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ auth()->user()->name }}</td>
                                        <td>{{ auth()->user()->age }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary edit-btn"
                                                data-index="0"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                data-index="0"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4 class="mb-3">
                            Address <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#addAddressModal">
                                + Add
                            </button>
                        </h4>

                        <div class="row" id="addressContainer">

                        </div>
                        <h4 class="mb-3">
                            Schedule Appointment
                        </h4>
                        <div class="col-12">
                            <label class="form-label">Home Sample Collection Required?</label>
                            <select class="form-select" name="sample_collection" id="sample_collection">
                                <option value="">--select--</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <!-- Time Category Tabs -->
                        <ul class="nav nav-tabs mb-3" id="timeTabs">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" data-category="Morning">
                                    <i class="fas fa-sun"></i> Morning
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-category="Afternoon">
                                    <i class="fas fa-cloud-sun"></i> Afternoon
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-category="Evening">
                                    <i class="fas fa-moon"></i> Evening
                                </button>
                            </li>
                        </ul>
                        <!-- Month & Date Selector -->
                        <div id="scheduleContainer"></div>

                        <!-- Time Slots -->
                        <div id="timeSlotsContainer" class="mt-4 row"></div>

                        <div class="col-12">
                            <textarea class="form-control" placeholder="Notes" name="note"></textarea>
                        </div>
                         <div class="col-6 ms-auto">
                            <label class="form-label">Total Amount</label>
                            <input type="number" class="form-control" name="total_amount" id="booking_total_amount"
                                readonly>
                        </div>
                        <input type="hidden" name="selected_address_id" id="selected_address_id">
                        <input type="hidden" name="selected_booking_date" id="selected_booking_date">
                        <input type="hidden" name="selected_time_slot" id="selected_time_slot">
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary float-end">Book Appointment</button>
                            <button type="button" class="btn btn-outline-secondary float-end me-2">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addPatientForm" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Full Name">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="label d-block mb-2">Gender</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male"
                                    value="Male">
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="femal"
                                    value="Female">
                                <label class="form-check-label" for="femal">Female</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="other_gender"
                                    value="Other">
                                <label class="form-check-label" for="other_gender">Other</label>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone" placeholder="Phone Number">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob"
                                placeholder="Enter DOB">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Relation</label>
                            <select name="relation" id="booking_relation" class="form-select">
                                <option value="">--select--</option>
                                <option value="Self" selected>Self</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addAddressForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body row">
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Street Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter address" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city"
                                placeholder="Enter city" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state"
                                placeholder="Enter state" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country"
                                placeholder="Enter country" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="pin" class="form-label">Pin/Postal Code</label>
                            <input type="text" class="form-control" id="pin" name="pin"
                                placeholder="Enter postal code" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="google_map_location" class="form-label">Google Map Location (Optional)</label>
                            <input type="text" class="form-control" id="google_map_location"
                                name="google_map_location" placeholder="Paste Google Maps link">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editAddressForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Street Address</label>
                            <input class="form-control" id="edit_address" name="address" type="text" />
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">City</label>
                            <input class="form-control" id="edit_city" name="city" type="text" />
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">State</label>
                            <input class="form-control" id="edit_state" name="state" type="text" />
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Country</label>
                            <input class="form-control" id="edit_country" name="country" type="text" />
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Pin/Postal code</label>
                            <input class="form-control" id="edit_pin" name="pin" type="text" />
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Google Map Location</label>
                            <input class="form-control" id="edit_map" name="google_map_location" type="text" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            var authUser = @json(Auth::user());
            let patients = [];
            if (authUser) {
                var dob = authUser.date_of_birth || null;
                var age = dob ? getAge(dob) : '';

                var defaultPatient = {
                    name: authUser.name || '',
                    gender: authUser.gender || '',
                    phone: authUser.phone || '',
                    email: authUser.email || '',
                    dob: dob,
                    relation: 'Self',
                    age: age
                };

                patients.push(defaultPatient);
                renderPatientTable();
            }
            let editIndex = null;

            // Handle form submission
            $('#addPatientForm').on('submit', function(e) {
                e.preventDefault();

                let name = $('input[name="name"]').val();
                let gender = $('input[name="gender"]:checked').val();
                let phone = $('input[name="phone"]').val();
                let email = $('input[name="email"]').val();
                let dob = $('input[name="dob"]').val();
                let relation = $('#booking_relation').val();

                let age = getAge(dob);

                let patient = {
                    name,
                    gender,
                    phone,
                    email,
                    dob,
                    relation,
                    age
                };

                if (editIndex !== null) {
                    patients[editIndex] = patient;
                    editIndex = null;
                } else {
                    patients.push(patient);
                }

                console.log(patients);
                $('#addPatientForm')[0].reset();
                $('#addPatientModal').modal('hide');

                renderPatientTable();
            });

            // Calculate age from DOB
            function getAge(dob) {
                let birthDate = new Date(dob);
                let ageDifMs = Date.now() - birthDate.getTime();
                let ageDate = new Date(ageDifMs);
                return Math.abs(ageDate.getUTCFullYear() - 1970);
            }

            // Render patients to table
            function renderPatientTable() {
                let table = $('table tbody');
                table.empty();
                patients.forEach((p, index) => {
                    table.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${p.name}</td>
                    <td>${p.age}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary edit-btn" data-index="${index}"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-index="${index}"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            `);
                });
            }

            // Edit button click
            $(document).on('click', '.edit-btn', function() {
                let index = $(this).data('index');
                let p = patients[index];

                $('input[name="name"]').val(p.name);
                $('input[name="gender"][value="' + p.gender + '"]').prop('checked', true);
                $('input[name="phone"]').val(p.phone);
                $('input[name="email"]').val(p.email);
                $('input[name="dob"]').val(p.dob);
                $('#booking_relation').val(p.relation);

                editIndex = index;

                $('#addPatientModal').modal('show');
            });

            // Delete button click
            $(document).on('click', '.delete-btn', function() {
                let index = $(this).data('index');
                patients.splice(index, 1);
                renderPatientTable();
            });

            let schedules = [];
            let selectedCategory = 'Morning';
            let sampleCollection = '1';

            $('#booking_lab_id').on('change', function() {
                const labId = $(this).val();

                // Reset test package and price
                $('#package_id_select').html('<option value="">-- Select --</option>');
                $('#booking_total_amount').val('');
                $('#scheduleContainer').empty();
                $('#timeSlotsContainer').empty();

                if (labId) {
                    // Get test packages
                    $.ajax({
                        url: '/get-tests-by-lab/' + labId,
                        type: 'GET',
                        success: function(data) {
                            $.each(data, function(key, test) {
                                $('#package_id_select').append('<option value="' + test
                                    .package_id + '">' + test.test_name +
                                    '</option>');
                            });
                        }
                    });

                    // Get schedules
                    $.ajax({
                        url: '/get-schedules-by-lab/' + labId + '/' + sampleCollection,
                        type: 'GET',
                        success: function(data) {
                            schedules = data;
                            renderMonthDateSelector();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });

                }
            });

            $('#sample_collection').on('change', function() {
                let selectedVal = $(this).val();

                if (selectedVal === '1') {
                    sampleCollection = '2';
                } else if (selectedVal === '0') {
                    sampleCollection = '1';
                } else {
                    sampleCollection = '';
                }
                var labId = $('#booking_lab_id').val();

                if (labId && sampleCollection !== '') {
                    $('#scheduleContainer').empty();
                    $('#timeSlotsContainer').empty();

                    $.ajax({
                        url: '/get-schedules-by-lab/' + labId + '/' + sampleCollection,
                        type: 'GET',
                        success: function(data) {
                            schedules = data;
                            renderMonthDateSelector();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }
            });


            $('#package_id_select').on('change', function() {
                const packageId = $(this).val();
                if (packageId) {
                    $.ajax({
                        url: '/get-test-price-by-package/' + packageId,
                        type: 'GET',
                        success: function(data) {
                            $('#booking_total_amount').val(data);
                        }
                    });
                }
            });

            // Handle category tab
            $(document).on('click', '#timeTabs .nav-link', function() {
                $('#timeTabs .nav-link').removeClass('active');
                $(this).addClass('active');
                selectedCategory = $(this).data('category');
                renderMonthDateSelector();
                $('#timeSlotsContainer').empty();
            });

            // Render month and dates by category
            function renderMonthDateSelector() {
                const container = $('#scheduleContainer').empty();
                const filtered = schedules.filter(s => s.time_category === selectedCategory);

                const renderedDates = [];

                let row = $('<div class="row gx-3"></div>');

                filtered.forEach(s => {
                    const date = new Date(s.date);
                    const monthYear = date.toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    });
                    const day = date.getDate().toString().padStart(2, '0');
                    const dateStr = date.toISOString().slice(0, 10); // "2025-05-08"

                    // Avoid duplicates if same date appears multiple times in DB
                    if (renderedDates.includes(dateStr)) return;
                    renderedDates.push(dateStr);

                    const card = $(`
            <div class="col-1 mb-3">
                <div class="card text-center shadow-sm rounded-3 h-100">
                    <div class="card-header bg-primary text-white fw-semibold py-2">
                        ${monthYear}
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center select-day-btn" data-month="${monthYear}"
                            data-day="${day}">
                        <span class="fw-bold fs-5">${day}</span>
                    </div>
                </div>
            </div>
        `);

                    row.append(card);
                });

                container.append(row);
            }


            // Handle day selection and show time slots
            $(document).on('click', '.select-day-btn', function() {
                const day = $(this).data('day');
                const monthText = $(this).data('month');
                const selectedDate = getDateFromMonthText(monthText, day);
                $('#selected_booking_date').val(selectedDate);

                const slots = schedules.filter(s => s.time_category === selectedCategory && s.date ===
                    selectedDate);
                const html = slots.map(s => `
        <div class="col-3"><div class="card mb-2 ">
            <div class="card-body py-2 px-3 select-timeslot-btn">
                ${formatTime(s.from_time)} - ${formatTime(s.to_time)}
            </div>
        </div></div>
    `).join('');

                $('#timeSlotsContainer').html(html ||
                    '<div class="text-muted">No time slots for this day.</div>');
            });

            function getDateFromMonthText(monthText, day) {
                const date = new Date(`${monthText} ${parseInt(day)}`);
                if (isNaN(date.getTime())) return null;

                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`; // Always in local time
            }

            function formatTime(timeStr) {
                const [hour, minute] = timeStr.split(':');
                const date = new Date();
                date.setHours(hour, minute);
                return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            $(document).on('click', '.select-timeslot-btn', function() {
                $('#selected_time_slot').val($(this).text().trim());
            });

            $('#bookingForm').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    lab_id: $('#booking_lab_id').val(),
                    user_id: $('#user_id').val(),
                    package_id: $('#package_id_select').val(),
                    patients: patients, // from your global array
                    sample_collection: $('select[name="sample_collection"]').val(),
                    total_amount: $('#booking_total_amount').val(),
                    note: $('textarea[name="note"]').val(),
                    selected_address_id: $('#selected_address_id').val(),
                    booking_date: $('#selected_booking_date').val(),
                    time_slot: $('#selected_time_slot').val(),
                };

                // Show loading SweetAlert
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we book your appointment.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('book.test') }}",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Booked!',
                            text: response.message,
                        });

                        // Optionally reset form or redirect
                        // $('#bookingForm')[0].reset();
                        // location.href = '/your-success-url';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: xhr.responseJSON?.message || 'Something went wrong.',
                        });
                    }
                });
            });





        });
    </script>

    <script>
        $(document).on('click', '.edit-address-btn', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_address').val($(this).data('address'));
            $('#edit_city').val($(this).data('city'));
            $('#edit_state').val($(this).data('state'));
            $('#edit_country').val($(this).data('country'));
            $('#edit_pin').val($(this).data('pin'));
            $('#edit_map').val($(this).data('map'));
            $('#editAddressModal').modal('show');
        });
        // Add address
        $('#addAddressForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.post("{{ route('addresses.store') }}", formData, function(response) {
                $('#addAddressForm')[0].reset();
                $('#addAddressModal').modal('hide');
                fetchAddresses();
            }).fail(function(xhr) {
                console.log(xhr)
            });
        });

        // Update address
        $('#editAddressForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let formData = $(this).serialize();

            $.ajax({
                url: "/user/addresses/" + id,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editAddressModal').modal('hide');
                    $('#card-' + id).remove(); // Remove old card
                    fetchAddresses();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        function fetchAddresses() {
            $.ajax({
                url: "{{ route('addresses.fetch') }}",
                type: 'GET',
                success: function(addresses) {
                    let html = '';
                    if (addresses.length === 0) {
                        html = '<p>No addresses found.</p>';
                    } else {
                        addresses.forEach(function(address) {
                            html += `
                        <div class="col-md-4" id="card-${address.id}">
                            <div class="card border mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">${address.address}</h5>
                                    <p class="card-text mb-1"><strong>City:</strong> ${address.city}</p>
                                    <p class="card-text mb-1"><strong>State:</strong> ${address.state}</p>
                                    <p class="card-text mb-1"><strong>Country:</strong> ${address.country}</p>
                                    <p class="card-text mb-1"><strong>Pin:</strong> ${address.pin}</p>
                                    <p class="card-text"><strong>Map:</strong> 
                                        <a href="${address.google_map_location}" target="_blank">${address.google_map_location ?? ''}</a>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-success btn-sm select-address-btn"
                                            data-id="${address.id}">Select</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm edit-address-btn"
                                            data-id="${address.id}"
                                            data-address="${address.address}"
                                            data-city="${address.city}"
                                            data-state="${address.state}"
                                            data-country="${address.country}"
                                            data-pin="${address.pin}"
                                            data-map="${address.google_map_location}">
                                            ✏️ Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        });
                    }

                    $('#addressContainer').html(html);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Call the function on page load
        $(document).ready(function() {
            fetchAddresses();
        });

        $(document).on('click', '.select-address-btn', function() {
            const addressId = $(this).data('id');

            // Set selected ID in hidden input
            $('#selected_address_id').val(addressId);

            // Reset all cards: remove both border and border-success classes
            $('.card').removeClass('border-success').removeClass('border');

            // Reset all buttons
            $('.select-address-btn').removeClass('btn-success').addClass('btn-outline-success').text('Select');

            // Highlight selected card
            $(`#card-${addressId} .card`).addClass('border-success');

            // Update button
            $(this).removeClass('btn-outline-success').addClass('btn-success').text('Selected');
        });
    </script>
    {{-- /Js Script --}}
</body>

</html>
