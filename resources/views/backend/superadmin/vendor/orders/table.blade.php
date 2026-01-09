@php

    $statusColors = [

        'Completed' => 'success',

        'Processing' => 'primary',

        'Pending' => 'warning',

        'Cancelled' => 'danger',

        'On hold' => 'secondary',

        'Partial' => 'info', // for mixed status

    ];



    $statusIcons = [

        'Completed' => 'fa-check',

        'Processing' => 'fa-redo',

        'Pending' => 'fa-stream',

        'Cancelled' => 'fa-ban',

        'On hold' => 'fa-ban',

        'Partial' => 'fa-exclamation', // mixed

    ];

@endphp



@foreach ($orders as $order)

    <tr class="btn-reveal-trigger">

        <td class="align-middle text-center fw-bold">

            {{ $loop->iteration }}.

        </td>



        <td class="order py-2 align-middle white-space-nowrap">

            <a href="{{ route('vendor.order.details', ['id' => encrypt($order->id)]) }}">

                <strong>#{{ $order->order_number }}</strong>

            </a> by <strong>{{ $order->user->name ?? 'N/A' }}</strong><br />

           <strong>Phone : </strong> <a href="tel:{{ $order->user->phone ?? '' }}">{{ $order->user->phone ?? '' }}</a>

        </td>



        <td class="address py-2 align-middle white-space-nowrap">

            {{ $order->address->address ?? 'N/A' }} <br>

            {{ $order->address->city ?? '' }},

            {{ $order->address->state ?? '' }},

            {{ $order->address->country ?? '' }},

            {{ $order->address->pin ?? '' }}

        </td>



        <td class="amount py-2 align-middle text-center fs-9 fw-medium">

            ₹{{ number_format($order->total, 2) }}

        </td>



        @php

            // Get common status of items

            $itemStatuses = $order->items->pluck('status')->unique();

            $commonStatus = $itemStatuses->count() === 1 ? $itemStatuses->first() : 'Partial';

            $color = $statusColors[$commonStatus] ?? 'secondary';

            $icon = $statusIcons[$commonStatus] ?? 'fa-ban';

        @endphp

        <td class="status py-2 align-middle text-center fs-9 white-space-nowrap">

            <span class="badge badge rounded-pill d-block badge-subtle-{{ $color }}">

                {{ ucfirst($commonStatus) }}

                <span class="ms-1 fas {{ $icon }}" data-fa-transform="shrink-2"></span>

            </span>

        </td>



        <td class="date py-2 align-middle text-center">

            {{ $order->created_at->format('d/m/Y') }}

        </td>



        <td class="py-2 align-middle white-space-nowrap text-end">

            <div class="dropdown font-sans-serif position-static">

                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button"

                    id="order-dropdown-{{ $loop->index }}" data-bs-toggle="dropdown" data-boundary="viewport"

                    aria-haspopup="true" aria-expanded="false">

                    <span class="fas fa-ellipsis-h fs-10"></span>

                </button>

                <div class="dropdown-menu dropdown-menu-end border py-0"

                    aria-labelledby="order-dropdown-{{ $loop->index }}">

                    <div class="py-2">

                        <a class="dropdown-item change-status" data-status="Completed" data-id="{{ $order->id }}"

                            href="#">Completed</a>

                        <a class="dropdown-item change-status" data-status="Processing" data-id="{{ $order->id }}"

                            href="#">Processing</a>

                        <a class="dropdown-item change-status" data-status="On hold" data-id="{{ $order->id }}"

                            href="#">On Hold</a>

                        <a class="dropdown-item change-status" data-status="Pending" data-id="{{ $order->id }}"

                            href="#">Pending</a>

                        <a class="dropdown-item change-status" data-status="Cancelled" data-id="{{ $order->id }}"

                            href="#">Cancelled</a>

                    </div>

                </div>

            </div>

        </td>

    </tr>

@endforeach



@if ($orders->isEmpty())

    <tr>

        <td colspan="7" class="text-center">No orders found</td>

    </tr>

@endif

