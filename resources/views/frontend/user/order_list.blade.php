@extends('frontend.includes.dashboard_layout')

@section('dash_content')

    <div class="user-wrapper">

        <div class="row">

            <div class="col-lg-12">

                <div class="user-card">

                    <div class="user-card-header mb-0 d-flex justify-content-between align-items-center flex-wrap">

                        <h4 class="user-card-title">My Orders List</h4>

                        <div class="user-card-header-right d-flex gap-2 flex-wrap">

                            <div class="user-card-filter">

                                <select class="form-select" id="statusFilter">

                                    <option value="">All Status</option>

                                    <option value="Pending">Pending</option>

                                    <option value="Confirmed">Confirmed</option>

                                    <option value="Cancelled">Cancelled</option>

                                </select>

                            </div>

                            <div class="user-card-search">

                                <div class="form-group position-relative">

                                    <input type="text" class="form-control" id="customSearch" placeholder="Search...">

                                    <i class="far fa-search position-absolute end-0 top-50 translate-middle-y me-2"></i>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="table-responsive mt-3">

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

                                @foreach ($detail as $order)

                                    <tr>

                                        <td><span class="table-list-code">#{{ $order->order_number }}</span></td>

                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</td>

                                        <td>₹{{ number_format($order->total, 2) }}</td>

                                        <td>

                                            @php

                                                $statusClass = match ($order->status) {

                                                    'Pending' => 'badge-info',

                                                    'Confirmed' => 'badge-success',

                                                    'Cancelled' => 'badge-danger',

                                                    default => 'badge-secondary',

                                                };

                                            @endphp

                                            <span class="badge {{ $statusClass }}">{{ $order->status }}</span>

                                        </td>

                                        <td>

                                            <a href="{{ route('order_detail', encrypt($order->id)) }}"

                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"

                                                title="Details">

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

        $(document).ready(function() {

            let table = $('#order-list').DataTable({

                dom: 'rtp', // only search, table, pagination

                ordering: false,

                responsive: true

            });



            // Search

            $('#customSearch').on('keyup', function() {

                table.search(this.value).draw();

            });



            // Status Filter

            $('#statusFilter').on('change', function() {

                table.column(3).search(this.value).draw();

            });

        });

    </script>

@endsection

