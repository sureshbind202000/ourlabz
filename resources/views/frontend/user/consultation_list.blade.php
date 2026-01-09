@extends('frontend.includes.dashboard_layout')

@section('css')

@endsection

@section('dash_content')

    <div class="user-wrapper">

        <div class="row">

            <div class="col-lg-12">

                <div class="user-card">

                    <div class="user-card-header mb-0">

                        <h4 class="user-card-title">All Consultations</h4>

                        <div class="user-card-header-right">

                            <div class="user-card-search">

                                <div class="form-group">

                                    <input type="text" class="form-control py-2 rounded-2" id="customSearch"

                                        placeholder="Search...">

                                    <i class="far fa-search"></i>

                                </div>

                            </div>

                            <a href="javascript:void(0);" id="free-consultation-btn"

                                class="btn btn-primary text-decoration-none border-glow-btn" data-tooltip="tooltip"

                                title="Click to book a free consultation now!, You have {{ $freeConsultationCount }} free consultations.">

                                <i class="fa-solid fa-stethoscope"></i> Free Consultations

                            </a>

                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-borderless text-nowrap" id="order-list">

                            <thead>

                                <tr>

                                    <th>Order ID</th>

                                    <th>Doctor</th>

                                    <th>Mode</th>

                                    <th>Prescription</th>

                                    <th>Date/Time</th>
                                    <th>Status</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($consultations as $consultation)

                                    <tr>

                                        <td><span class="table-list-code">#{{ $consultation->payment->order_id }}</span>

                                        </td>

                                        <td>{{ $consultation->doctor->name ?? 'N/A' }}</td>

                                        <td>{{ $consultation->consultation_type == 2 ? 'Online' : ($consultation->consultation_type == 1 ? 'Offline' : '-') }}

                                        </td>

                                        <td>

                                            @php

                                                $statusClass = match ($consultation->status) {

                                                    0 => 'bg-secondary',

                                                    1 => 'bg-success',

                                                    default => 'bg-secondary',

                                                };

                                            @endphp

                                            <span

                                                class="badge {{ $statusClass }}">{{ $consultation->status == 1 ? 'Available' : 'Pending' }}</span>

                                        </td>

                                        <td>

                                            @if (!empty($consultation->appointment_date) && !empty($consultation->appointment_time))

                                                {{ $consultation->appointment_date }} |

                                                {{ $consultation->appointment_time }}

                                            @else

                                                <span class="badge bg-secondary">Wait for scheduling</span>

                                            @endif

                                        </td>

                                        <td>
                                             @php

                                                $consultStatusClass = match ($consultation->status) {

                                                    0 => 'badge-success',

                                                    1 => 'bg-success',

                                                    2 => 'bg-danger',

                                                    default => 'bg-secondary',

                                                };

                                            @endphp

                                            <span

                                                class="badge {{ $consultStatusClass }}">{{ $consultation->status == 1 ? 'Completed' : ($consultation->status == 2 ? 'Cancelled' : 'Confirmed') }}</span>
                                        </td>

                                        <td>

                                            <a href="{{ route('user.consultation.details', ['id' => encrypt($consultation->id)]) }}"

                                                class="btn btn-outline-secondary btn-sm rounded-2" data-tooltip="tooltip"

                                                title="View consultation details">

                                                <i class="far fa-eye"></i>

                                            </a>

                                        </td>

                                    </tr>

                                @endforeach



                            </tbody>

                        </table>

                    </div>



                </div>

            </div>

        </div>

    </div>



    <!-- Free Consultation Modal -->

    <div class="modal fade" id="consultationTestsModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title"><i class="fa-solid fa-stethoscope"></i> Available Free Consultations</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body" id="consultationTestsBody">

                    <!-- Tests will load here -->

                </div>

            </div>

        </div>

    </div>



    <!-- Doctors Modal -->

    <div class="modal fade" id="doctorsModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title"><i class="fa-solid fa-user-md"></i> Available Doctors</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body" id="doctorsModalBody">

                    <div class="text-center py-5 text-muted">

                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>

                        <p>Loading doctors...</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>

        let table = new DataTable('#order-list', {

            dom: 'rtp',

            ordering: false

        });



        $('#customSearch').on('keyup', function() {

            table.search(this.value).draw();

        });



        // 🔽 Status Dropdown Filter

        $('#statusFilter').on('change', function() {

            let selected = this.value;



            let statusColumnIndex = 3;



            table.column(statusColumnIndex).search(selected).draw();

        });



        $(document).on('click', '#free-consultation-btn', function() {

            // Open modal

            $('#consultationTestsModal').modal('show');

        });



        $('#consultationTestsModal').on('show.bs.modal', function() {

            // Show loader

            $('#consultationTestsBody').html(`

        <div class="text-center py-5 text-muted">

            <i class="fa-solid fa-spinner fa-spin fa-2x"></i>

            <p>Loading tests...</p>

        </div>

        `);



            // Fetch tests via AJAX

            $.get("{{ route('user.free.consultations.tests') }}", function(data) {

                $('#consultationTestsBody').html(data);

            });

        });



        // When clicking on "Doctors" button

        $(document).on('click', '#chooseOthers', function() {

            let testId = $(this).data('id');

            // Hide modal

            $('#doctorChoiceModal').modal('hide');

            // Show modal

            $('#doctorsModal').modal('show');



            // Show loader

            $('#doctorsModalBody').html(`

            <div class="text-center py-5 text-muted">

                <i class="fa-solid fa-spinner fa-spin fa-2x"></i>

                <p>Loading doctors...</p>

            </div>

            `);



            // AJAX request

            $.ajax({

                url: `/user/free-consultation/doctors/${testId}`,

                method: 'GET',

                dataType: 'html',

                success: function(data) {

                    $('#doctorsModalBody').html(data);

                },

                error: function(xhr, status, error) {

                    $('#doctorsModalBody').html(`

                    <div class="text-center py-5 text-danger">

                        <i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i>

                        <p>Failed to load doctors. Please try again.</p>

                    </div>

                    `);

                }

            });

        });



        $(document).on('click', '.open-doctors', function() {

            let testId = $(this).data('id');



            // Hide previous modal

            $('#consultationTestsModal').modal('hide');



            // Show a custom selection modal

            let selectionModal = `

        <div class="modal fade" id="doctorChoiceModal" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow-lg rounded-3">

                    <div class="modal-header border-0">

                        <h5 class="modal-title">Choose Consultation</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <div class="row g-3">

                            <!-- Certified Doctor Card -->

                            <div class="col-md-6 border-end">

                                <div class="card choice-card h-100 text-center p-3 consultation-glass" id="chooseCertified" data-id="${testId}" style="cursor: pointer;">

                                    <i class="fa-solid fa-user-md fa-2x text-primary mb-3"></i>

                                    <h6>Certified Doctor</h6>

                                    <p class="small text-muted">Consult with the doctor who certified your lab report</p>

                                </div>

                            </div>

                            <!-- Other Doctors Card -->

                            <div class="col-md-6">

                                <div class="card choice-card h-100 text-center p-3 consultation-glass" id="chooseOthers" data-id="${testId}" style="cursor: pointer;">

                                    <i class="fa-solid fa-users fa-2x text-primary mb-3"></i>

                                    <h6>Other Doctors</h6>

                                    <p class="small text-muted">Browse and consult with other available doctors</p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        `;



            // Append to body (remove old if exists)

            $('#doctorChoiceModal').remove();

            $('body').append(selectionModal);



            // Show modal

            $('#doctorChoiceModal').modal('show');

        });



        $(document).on('click', '#chooseCertified', function() {

            let testId = $(this).data('id');



            let modeModal = `

     <div class="modal fade" id="consultationModeModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-3">

                <div class="modal-header border-0">

                    <h5 class="modal-title">Choose Consultation Mode</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <!-- Online Card -->

                        <div class="col-md-6">

                            <div class="card consultation-glass text-center p-4 chooseMode" data-id="${testId}" data-mode="2" style="cursor: pointer;">

                                <i class="fa-solid fa-video fa-2x text-primary mb-3"></i>

                                <h6 class="mb-1">Online</h6>

                                <p class="small text-muted mb-0">Google Meet / Video Consultation</p>

                            </div>

                        </div>

                        <!-- Visit Doctor Card -->

                        <div class="col-md-6">

                            <div class="card consultation-glass text-center p-4 chooseMode" data-id="${testId}" data-mode="1" style="cursor: pointer;">

                                <i class="fa-solid fa-hospital fa-2x text-primary mb-3"></i>

                                <h6 class="mb-1">Visit Doctor</h6>

                                <p class="small text-muted mb-0">Consult at doctor’s clinic / address</p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

     </div>`;



            // Remove old modal if exists

            $('#consultationModeModal').remove();

            $('body').append(modeModal);



            // Hide choice modal and show mode modal

            $('#doctorChoiceModal').modal('hide');

            $('#consultationModeModal').modal('show');

        });



        // Send enquiry to certified doctor

        $(document).on('click', '.chooseMode', function() {

            let testId = $(this).data('id');

            let mode = $(this).data('mode');

            // Hide modal

            $('#consultationModeModal').modal('hide');



            // Call AJAX to save enquiry

            $.ajax({

                url: "{{ route('certified.doctor.booking.free') }}",

                method: 'POST',

                data: {

                    test_id: testId,

                    consultation_type: mode,

                },

                success: function(res) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Booking request sent!',

                        text: 'Certified doctor will contact you soon.',

                        timer: 2000,

                        showConfirmButton: false

                    });

                }

            });

        });

        $(document).on('change', '.consultation-mode', function() {

            let doctorId = $(this).data('doctor-id');

            let selectedMode = $(this).val();



            // Update the corresponding Request Booking button

            $(`.request-booking[data-doctor-id="${doctorId}"]`).attr('data-consultation-mode', selectedMode);

        });



        $(document).on('click', '.request-booking', function(e) {

            e.preventDefault();



            let doctorId = $(this).data('doctor-id');

            let consultationType = $(this).data('consultation-mode');



            if (consultationType == 0) {

                Swal.fire({

                    icon: 'warning',

                    title: 'Select Consultation Mode',

                    text: 'Please choose Online or Visit Doctor before booking.'

                });

                return;

            }

            console.log(consultationType);

            // Show SweetAlert loading

            Swal.fire({

                title: 'Processing...',

                html: 'Please wait while we send your booking request.',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $.ajax({

                url: "{{ route('doctor.booking.free') }}",

                method: 'POST',

                data: {

                    doctor_id: doctorId,

                    consultation_type: consultationType,

                },

                success: function(response) {

                    Swal.close(); // Close loading



                    if (response.success) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Success!',

                            text: response.message,

                            timer: 2000,

                            showConfirmButton: false

                        });

                    } else {

                        Swal.fire({

                            icon: 'error',

                            title: 'Error!',

                            text: response.message

                        });

                    }

                },

                error: function(xhr) {

                    Swal.close(); // Close loading

                    if (xhr.status === 422) {

                        let res = xhr.responseJSON;



                        Swal.fire({

                            icon: 'warning',

                            title: 'Address Required',

                            text: res.message,

                            showCancelButton: true,

                            confirmButtonText: 'Go to Addresses',

                            cancelButtonText: 'Cancel'

                        }).then((result) => {

                            if (result.isConfirmed && res.redirect_url) {

                                window.location.href = res.redirect_url;

                            }

                        });

                    }

                    console.log(xhr);

                }

            });

        });

    </script>

@endsection

