@extends('frontend.includes.dashboard_layout')
@section('css')

@endsection
@section('dash_content')

<div class="user-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="user-card">
                <div class="user-card-header mb-0">
                    <h4 class="user-card-title">My Boooking List</h4>
                    <div class="user-card-header-right">
                        <div class="user-card-filter">
                            <select class="select" id="statusFilter">
                                <option value="">Default</option>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="user-card-search">
                            <div class="form-group">
                                <input type="text" class="form-control" id="customSearch" placeholder="Search...">
                                <i class="far fa-search"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-borderless text-nowrap" id="order-list">
                        <thead>
                            <tr>
                                <th>#Order ID</th>
                                <th>Purchased Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><span class="table-list-code">#{{ $order->order_id }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</td>
                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @php
                                    $statusClass = match($order->status) {
                                    'Pending' => 'badge-info',
                                    'Processing' => 'badge-primary',
                                    'Confirmed' => 'badge-success',
                                    'Cancelled' => 'badge-danger',
                                    'Completed' => 'bg-success',
                                    default => 'badge-secondary',
                                    };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('booking_detail', encrypt($order->id)) }}"
                                        class="btn btn-outline-secondary btn-sm rounded-2"
                                        data-tooltip="tooltip" title="Details">
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
</script>

@endsection