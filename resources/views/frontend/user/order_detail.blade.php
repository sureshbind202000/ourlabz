@extends('frontend.includes.dashboard_layout')

@section('css')

@endsection

@section('dash_content')

<div class="user-wrapper">

    <div class="row">

        <div class="col-lg-12">

            <div class="user-card user-order-detail">

                <div class="user-card-header">

                    <h4 class="user-card-title">Order Details (#{{ $detail->order_number }})</h4>

                    <div class="user-card-header-right">

                        <a href="{{ route('order_list') }}" class="theme-btn">

                            <span class="fas fa-arrow-left"></span> Order List

                        </a>

                    </div>

                </div>



                <div class="table-responsive">

                    <table class="table table-borderless text-nowrap">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th>Quantity</th>

                                <th>Total</th>

                                <th>Status</th>

                                <th></th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($detail->items as $item)

                            <tr>

                                <td>

                                    <div class="table-list-info">

                                        <a href="{{ route('product', ['slug' => $item->product->slug]) }}" target="_blank">

                                            <div class="table-list-img">

                                                <img src="{{ asset(optional($item->product->images->first())->image ?? 'assets/img/default.png') }}"

                                                    alt="Product Image">

                                            </div>

                                            <div class="table-list-content">

                                                <h6>{{ $item->product->product_name ?? 'N/A' }}</h6>

                                            </div>

                                        </a>

                                    </div>

                                </td>

                                <td>{{ $item->quantity }} {{ $item->unit ?? 'Pcs' }}</td>

                                <td>₹{{ number_format($item->total, 2) }}</td>

                                <td>
                                    @php

                                    $statusClass = match ($item->status) {

                                    'Pending' => 'badge-primary',

                                    'Processing' => 'badge-info',

                                    'Completed' => 'badge-success',

                                    'Cancelled' => 'badge-danger',
                                    'On hold' => 'badge-primary',

                                    default => 'badge-secondary',

                                    };

                                    @endphp
                                    <span class="fw-bold badge {{ $statusClass }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    @if($item->status != 'Cancelled' && $item->status != 'Completed')
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger cancelOrderBtn" data-order-id="{{ $item->id }}">
                                        Cancel Order
                                    </a>
                                    @endif
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>



                <div class="row">

                    <div class="col-lg-6">

                        <div class="order-detail-content">

                            <h5>Shipping Address</h5>

                            @if ($detail->address)

                            <p><i class="far fa-location-dot"></i>

                                {{ $detail->address->address }},

                                {{ $detail->address->city }},

                                {{ $detail->address->state }},

                                {{ $detail->address->pin }},

                                {{ $detail->address->country }}

                            </p>

                            @else

                            <p>No address found.</p>

                            @endif

                        </div>

                    </div>



                    <div class="col-lg-6">

                        <div class="order-detail-content">

                            <h5>Order Summary</h5>

                            <ul>

                                <li>Subtotal<span>₹{{ number_format($detail->subtotal, 2) }}</span></li>

                                <li>Shipping<span>{{ $detail->shipping_cost > 0 ? '₹' . number_format($detail->shipping_cost, 2) : 'Free' }}</span>

                                </li>

                                @if($detail->discount > 0)

                                <li>Discount<span>₹{{ number_format($detail->discount, 2) }}</span></li>

                                @endif

                                @if($detail->tax > 0)

                                <li>Tax<span>₹{{ number_format($detail->tax, 2) }}</span></li>

                                @endif

                                <li>Total<span>₹{{ number_format($detail->total, 2) }}</span></li>

                            </ul>

                        </div>

                    </div>

                </div>



            </div>

        </div>

    </div>

</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Cancel Order</h5>
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

                <input type="hidden" id="cancelOrderId">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmCancelOrderBtn">Confirm Cancel</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).on('click', '.cancelOrderBtn', function() {
        var orderId = $(this).data('order-id');
        $('#cancelOrderId').val(orderId);
        $('#cancelOrderModal').modal('show');
    });

    $('#viewPolicy').click(function(e) {
        e.preventDefault();
        $('#policyContent').removeClass('d-none');
    });

    $('#confirmCancelOrderBtn').click(function() {
        var orderId = $('#cancelOrderId').val();
        var reason = $('#cancelReason').val();

        if (!reason) {
            Swal.fire('Error', 'Please provide a reason for cancellation.', 'error');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('order.cancel') }}",
                    method: 'POST',
                    data: {
                        order_id: orderId,
                        reason: reason,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire('Cancelled!', res.message, 'success');
                        $('#cancelOrderModal').modal('hide');
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