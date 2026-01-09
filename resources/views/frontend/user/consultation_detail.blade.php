@extends('frontend.includes.dashboard_layout')

@section('css')

@endsection

@section('dash_content')

<div class="user-wrapper">

    <div class="row">

        <div class="col-lg-12">

            <div class="user-card user-order-detail">

                <div class="user-card-header">

                    <h4 class="user-card-title">Consultation Details ({{ $consultation->payment->order_id }})</h4>

                    <div class="user-card-header-right">

                        <a href="{{ route('user.all.consultation') }}" class="theme-btn">

                            <span class="fas fa-arrow-left"></span> All Consultations

                        </a>

                        @if($consultation->status != 1 && $consultation->status != 2)
                            <a href="javascript:void(0);" class="btn btn-danger py-2 cancelBookingBtn" data-booking-id="{{ $consultation->id }}">
                                <span class="fas fa-ban"></span> Cancel
                            </a>
                            @endif

                    </div>

                </div>



                <div class="row">

                    <div class="col-lg-6">

                        <div class="order-detail-content text-dark">
                            <h5>Appointment Details</h5>
                            <div class="row">
                                <div class="col-md-6">

                                    <p>

                                        <strong class="text-dark">Name : </strong>{{ $consultation->user->name }}

                                        <br>

                                        <strong class="text-dark">Phone : </strong>{{ $consultation->user->phone }}

                                        <br>

                                        <strong class="text-dark">Date : </strong>{{ \Carbon\Carbon::parse($consultation->appointment_date)->format('d M Y') }}

                                    </p>

                                </div>

                                <div class="col-md-6">

                                    <p>

                                        <strong class="text-dark">Mode :</strong>

                                        {{ $consultation->consultation_type == 2 ? 'Online' : 'Visit Doctor' }}

                                        <br>

                                        <strong class="text-dark">Doctor : </strong>{{ $consultation->doctor->name ?? 'N/A' }}
                                        <br>

                                        <strong class="text-dark">Time : </strong>{{ \Carbon\Carbon::parse($consultation->appointment_time)->format('h:i A') }}

                                    </p>

                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-6">
                        <div class="order-detail-content text-dark">
                            <h5>Address</h5>
                            <strong>Address : </strong> {{ $consultation->address->address }}
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>

                                        <strong>City : </strong> {{ $consultation->address->city }}
                                        <br>
                                        <strong>Country : </strong> {{ $consultation->address->country }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <strong>State : </strong> {{ $consultation->address->state }}
                                        <br>
                                        <strong>Postal Code : </strong> {{ $consultation->address->pin }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="col-lg-6">

                        <div class="order-detail-content text-dark">

                            <h5>Prescription</h5>

                            @foreach ($consultation->prescriptions as $prescription)

                            <p class="mb-2 p-2 border rounded bg-light">



                                {{-- Written Prescription --}}

                                @if (!empty($prescription->written_prescription))

                                <small>Written : </small>

                                <br>

                                <a href="{{ route('prescription.download.text', $prescription->id) }}"

                                    class="btn btn-sm btn-primary w-100" data-tooltip="tooltip"

                                    title="Download Written Prescription">

                                    <i class="fa fa-download"></i> Download

                                </a>

                                @endif



                                {{-- File Prescription --}}

                                @if (!empty($prescription->file_prescription))

                                <small>File : </small>

                                <br>

                                <a href="{{ asset($prescription->file_prescription) }}"

                                    class="btn btn-sm btn-success w-100" data-tooltip="tooltip"

                                    title="Download Prescription File" download>

                                    <i class="fa fa-download"></i> Download

                                </a>

                                @endif



                            </p>

                            @endforeach

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="order-detail-content text-dark">

                            <h5>Order Summary</h5>

                            <ul>

                                <li>Subtotal <span>₹{{ number_format($consultation->payment->subtotal, 2) }}</span></li>
                                @if($consultation->payment->tax > 0)
                                <li>Tax <span>₹{{ number_format($consultation->payment->tax, 2) }}</span></li>
                                @endif
                                @if($consultation->payment->discount > 0)
                                <li>Discount <span>₹{{ number_format($consultation->payment->discount, 2) }}</span></li>
                                @endif


                                <li>Total <span>₹{{ number_format($consultation->payment->total, 2) }}</span></li>

                            </ul>

                            {{-- <p class="mt-4">Paid by {{ ucfirst($detail->payment->payment_method ?? 'N/A') }}</p> --}}

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
                text: "Do you really want to cancel this consultation?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('doctor.booking.cancel') }}",
                        method: 'POST',
                        data: {
                            consultation_id: bookingId,
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
</script>
@endsection