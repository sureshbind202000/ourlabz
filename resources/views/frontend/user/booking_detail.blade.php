@extends('frontend.includes.dashboard_layout')

@section('css')

    <style>

        .timeline-steps {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            position: relative;

            padding: 40px 20px;

        }



        .step {

            display: flex;

            flex-direction: column;

            /* icon above, text below */

            align-items: center;

            position: relative;

            flex: 1;

            text-align: center;

        }





        .step::before {

            content: '';

            position: absolute;

            top: 20px;

            /* align with center of icon */

            left: 50%;

            height: 3px;

            width: 100%;

            background-color: #0095d9;

            z-index: 0;

            transform: translateX(-50%);

        }



        .icon-wrapper {

            width: 40px;

            height: 40px;

            background-color: #0095d9;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 20px;

            flex-shrink: 0;

            z-index: 1;

            /* box-shadow: 0 0 10px rgba(0, 114, 255, 0.3); */

            transition: background 0.3s, color 0.3s;

        }



        .step-content {

            flex: 1;

            z-index: 1;

            margin-top: 15px;

        }



        .step-content h5 {

            margin: 0;

            font-weight: 600;

            font-size: 14px;

        }



        .step-content small {

            color: #6c757d;

        }



        .step.active .icon-wrapper {

            background: linear-gradient(to right, #00c6ff, #0095d9);

            /* box-shadow: 0 0 10px rgba(40, 167, 69, 0.5); */

        }



        .step.inactive .icon-wrapper {

            background: white;

            color: #666;

            box-shadow: none;

            border: 2px solid #0095d9;

        }



        .step.inactive .step-content h5,

        .step.inactive .step-content small {

            color: #aaa;

        }



        .step.last-active .icon-wrapper {

            position: relative;

            z-index: 1;

            animation: pop-glow 1.5s ease-in-out infinite;

        }



        .step.last-active .icon-wrapper::before {

            content: '';

            position: absolute;

            top: 50%;

            left: 50%;

            width: 100%;

            height: 100%;

            background: rgba(0, 114, 255, 0.3);

            border-radius: 50%;

            transform: translate(-50%, -50%) scale(1);

            z-index: -1;

            animation: spread-layer 1.5s ease-in-out infinite;

        }



        @keyframes spread-layer {

            0% {

                transform: translate(-50%, -50%) scale(1);

                opacity: 0.6;

            }



            70% {

                transform: translate(-50%, -50%) scale(1.8);

                opacity: 0;

            }



            100% {

                transform: translate(-50%, -50%) scale(1.8);

                opacity: 0;

            }

        }



        @keyframes pop-glow {



            0%,

            100% {

                box-shadow: 0 0 15px rgba(0, 114, 255, 0.6);

            }



            50% {

                box-shadow: 0 0 25px rgba(0, 114, 255, 1);

            }

        }

    </style>

@endsection

@section('dash_content')

    <div class="user-wrapper">

        <div class="row">

            <div class="col-lg-12">

                <div class="user-card user-order-detail">

                    <div class="user-card-header">

                        <h4 class="user-card-title">Booking Details ({{ $detail->order_id }})</h4>

                        <div class="user-card-header-right">

                            <a href="{{ route('booking_list') }}" class="theme-btn">
                                
                                <span class="fas fa-arrow-left"></span> Booking List
                                
                            </a>
                            @if($detail->status != 'Cancelled' && $detail->status != 'Completed')
                            <a href="javascript:void(0);" class="btn btn-danger py-2 cancelBookingBtn" data-booking-id="{{ $detail->id }}">
                                <span class="fas fa-ban"></span> Cancel
                            </a>
                            @endif

                        </div>

                    </div>



                    <div class="table-responsive">

                        <table class="table table-borderless text-nowrap">

                            <thead>

                                <tr>

                                    <th class="text-dark">Product</th>

                                    <th class="text-dark">Name</th>

                                    <th class="text-dark">Phone</th>

                                    <th class="text-dark">Email</th>

                                    <th class="text-dark">Total</th>

                                    <th class="text-dark">Tracking ID</th>

                                </tr>

                            </thead>

                            <tbody style="font-size: 14px;">

                                @foreach ($detail->patients as $patient)

                                    @php

                                        $tests = $detail->tests->where('booking_patient_id', $patient->id);

                                        $testNames = $tests->pluck('package.name')->join(', ');

                                        $tracking = \App\Models\TrackBookingStatus::where(

                                            'booking_patient_id',

                                            $patient->id,

                                        )->first();

                                        $total = $tests->sum('price_at_booking_time');

                                    @endphp

                                    <tr>

                                        <td>{{ $testNames }}</td>

                                        <td>{{ $patient->name }}</td>

                                        <td>{{ $patient->phone }}</td>

                                        <td>{{ $patient->email }}</td>

                                        <td>₹{{ number_format($total, 2) }}</td>

                                        <td>

                                            @if ($tracking)

                                                <button type="button" class="btn btn-sm btn-outline-primary track-btn"

                                                    data-tracking="{{ $tracking->tracking_id }}">

                                                    {{ $tracking->tracking_id }}

                                                </button>

                                            @else

                                                N/A

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                        <div id="tracking-status-container" style="display:none; margin-top:20px;">

                            <h6 class="text-center">Tracking Status (<span id="tracking-code"></span>)</h6>

                            <div class="timeline-steps col-12" id="timeline-steps">

                                <div class="step">

                                    <div class="icon-wrapper"><i class="fas fa-file-medical"></i></div>

                                    <div class="step-content">

                                        <h5>Booking Confirm</h5>

                                        <small></small>

                                    </div>

                                </div>

                                <div class="step">

                                    <div class="icon-wrapper"><i class="fas fa-calendar-check"></i></div>

                                    <div class="step-content">

                                        <h5>Collection Scheduled</h5>

                                        <small></small>

                                    </div>

                                </div>

                                <div class="step">

                                    <div class="icon-wrapper"><i class="fas fa-vial"></i></div>

                                    <div class="step-content">

                                        <h5>Sample Collected & <br> Received at Lab</h5>

                                        <small></small>

                                    </div>

                                </div>

                                <div class="step">

                                    <div class="icon-wrapper"><i class="fas fa-file-alt"></i></div>

                                    <div class="step-content">

                                        <h5>Report Ready</h5>

                                        <small></small>

                                    </div>

                                </div>

                                <div class="step">

                                    <div class="icon-wrapper"><i class="fas fa-envelope-open-text"></i></div>

                                    <div class="step-content">

                                        <h5>Report Delivered</h5>

                                        <small></small>

                                        <br>

                                        <a href="#" id="download-report-btn" style="display:none;" target="_blank">

                                            <i class="fas fa-download"></i> Download Report

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>







                    <div class="row">

                        <div class="col-lg-6">
                        <div class="order-detail-content text-dark">
                            <h5>Shipping Address</h5>
                            <strong>Address : </strong> {{ $detail->bookingAddress->address }}
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>

                                        <strong>City : </strong> {{ $detail->bookingAddress->city }}
                                        <br>
                                        <strong>Country : </strong> {{ $detail->bookingAddress->country }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <strong>State : </strong> {{ $detail->bookingAddress->state }}
                                        <br>
                                        <strong>Postal Code : </strong> {{ $detail->bookingAddress->pin }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-lg-6">

                            <div class="order-detail-content text-dark">

                                <h5>Order Summary</h5>

                                <ul>

                                    <li>Subtotal <span>₹{{ number_format($detail->sub_total, 2) }}</span></li>

                                    @if($detail->discount > 0)

                                    <li>Discount <span>₹{{ number_format($detail->discount, 2) }}</span></li>

                                    @endif

                                    @if($detail->tax > 0)

                                    <li>Tax <span>₹{{ number_format($detail->tax, 2) }}</span></li>

                                    @endif

                                    <li>Total <span>₹{{ number_format($detail->total_amount, 2) }}</span></li>

                                </ul>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Cancel Booking</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2 text-muted">Before canceling, please review our <a href="#" id="viewPolicy">cancellation policy</a>.</p>
                
                <div id="policyContent" class="border rounded p-3 mb-3 bg-light d-none">
                    <h6 class="fw-bold mb-2">Cancellation Policy</h6>
                    <p class="small mb-1">
                        1️⃣ You can cancel your booking **within 24 hours** before the scheduled collection time for a full refund.  
                    </p>
                    <p class="small mb-1">
                        2️⃣ Cancellations made **after 24 hours** of scheduled time may not be eligible for a full refund.  
                    </p>
                    <p class="small mb-1">
                        3️⃣ If a sample has already been collected, the booking **cannot be cancelled**.  
                    </p>
                    <p class="small mb-0 text-muted">
                        For more details, please contact support@medicarelabs.in
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Reason for Cancellation</label>
                    <textarea class="form-control" id="cancelReason" rows="3" placeholder="Enter reason..."></textarea>
                </div>

                <input type="hidden" id="cancelBookingId">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBookingBtn">Confirm Cancel</button>
            </div>

        </div>
    </div>
</div>


@endsection

@section('js')

    <script>
        $(document).on('click', '.cancelBookingBtn', function() {
            var bookingId = $(this).data('booking-id');
            $('#cancelBookingId').val(bookingId);
            $('#cancelBookingModal').modal('show');
        });

        $('#viewPolicy').click(function(e) {
            e.preventDefault();
            $('#policyContent').removeClass('d-none');
        });

        $('#confirmCancelBookingBtn').click(function() {
            var bookingId = $('#cancelBookingId').val();
            var reason = $('#cancelReason').val();
        
            if (!reason) {
                Swal.fire('Error', 'Please provide a reason for cancellation.', 'error');
                return;
            }
        
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel this booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('booking.cancel') }}",
                        method: 'POST',
                        data: {
                            booking_id: bookingId,
                            reason: reason,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            Swal.fire('Cancelled!', res.message, 'success');
                            $('#cancelBookingModal').modal('hide');
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || 'Cancellation failed.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.track-btn', function() {

            const trackingId = $(this).data('tracking');

            if (!trackingId) return;



            navigator.clipboard.writeText(trackingId);



            Swal.fire({

                title: 'Loading Tracking Status...',

                allowOutsideClick: false,

                didOpen: () => {

                    Swal.showLoading();

                }

            });



            $.ajax({

                url: '{{ route('track.booking.status') }}',

                method: 'GET',

                data: {

                    tracking_id: trackingId

                },

                success: function(res) {

                    Swal.close();



                    if (res.status) {

                        $('#tracking-code').text('#' + trackingId);

                        const currentStatus = parseInt(res.status_code);

                        const steps = document.querySelectorAll('#timeline-steps .step');



                        steps.forEach((step, index) => {

                            const statusCode = index + 1;

                            const stepData = res.steps[statusCode];



                            const small = step.querySelector('small');

                            if (small) {

                                small.textContent = stepData ? stepData.date : '';

                            }



                            step.classList.remove('active', 'inactive', 'last-active');



                            if (statusCode < currentStatus) {

                                step.classList.add('active');

                            } else if (statusCode === currentStatus) {

                                step.classList.add('active', 'last-active');

                            } else {

                                step.classList.add('inactive');

                            }

                        });



                        // show download link if delivered

                        if (currentStatus === 5) {

                            $('#download-report-btn')

                                .show()

                                .attr('href', '/download-report/' + trackingId);

                        } else {

                            $('#download-report-btn').hide();

                        }



                        $('#tracking-status-container').show();



                    } else {

                        Swal.fire('Error', res.message || 'No tracking info found.', 'error');

                    }

                },

                error: function() {

                    Swal.fire('Error', 'Something went wrong.', 'error');

                }

            });

        });

    </script>

@endsection

