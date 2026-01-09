@extends('backend.includes.layout')



@section('content')

    <div class="card mb-3">

        <div class="bg-holder d-none d-lg-block bg-card"

            style="background-image:url({{ asset('assets/img/icons/spot-illustrations/corner-4.png') }});opacity: 0.7;">

        </div>

        <!--/.bg-holder-->



        <div class="card-body position-relative">

            <h5>Order Details: #{{ $order->order_number }}</h5>

            <p class="fs-10 mb-0">{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y, h:i A') }}</p>

        </div>

    </div>



    {{-- Address and Payment Info --}}

    <div class="card mb-3">

        <div class="card-body">

            <div class="row">

                {{-- Billing Address --}}

                <div class="col-md-4 col-lg-4 mb-4 mb-lg-0 text-dark">

                    <h5 class="mb-3 fs-9">Billing Information</h5>

                    <p class="mb-1 fs-10"><strong>Name : </strong>{{ $order->user->name ?? 'N/A' }} <br><strong>Address : </strong>{{ $order->user->user_details->address ?? 'N/A' }} <br><strong>City : </strong> {{ $order->user->user_details->city ?? 'N/A' }} <br><strong>State : </strong> {{ $order->user->user_details->state ?? 'N/A' }} <br><strong>Country : </strong> {{ $order->user->user_details->country ?? 'N/A' }} <br><strong>Postal Code : </strong> {{ $order->user->user_details->pin ?? 'N/A' }}</p>

                </div>



                <!-- Shipping Address -->

                <div class="col-md-4 col-lg-4 mb-4 mb-lg-0 text-dark">

                    <h5 class="mb-3 fs-9">Shipping Address</h5>

                    <h6 class="mb-2">{{ $order->shipping_name }}</h6>

                    <p class="mb-0 fs-10"><strong>Address : </strong> {{ $order->address->address ?? 'N/A' }} <br> <strong>City : </strong> {{ $order->address->city ?? 'N/A' }} <br><strong>State : </strong> {{ $order->address->state ?? 'N/A' }} <br><strong>Country : </strong> {{ $order->address->country ?? 'N/A' }} <br><strong>Postal Code : </strong> {{ $order->address->pin ?? 'N/A' }}</p>

                </div>

                <!-- Contact Information -->
                <div class="col-md-4 col-lg-4 mb-4 mb-lg-0 text-dark">

                    <h5 class="mb-3 fs-9">Contact Information</h5>

                     <p class="mb-0 fs-10"> <strong>Email : </strong> <a

                            href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></p>

                    <p class="mb-0 fs-10"> <strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>

                </div>

                {{-- <div class="col-md-6 col-lg-3">

                    <h5 class="mb-3 fs-9">Vendor Information</h5>

                    @auth

                        @if (Auth::user()->role === 0 && $order->vendor)

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h5 class="mb-3 fs-9">Vendor Information</h5>

                                    <p class="mb-1 fs-10"><strong>Name:</strong> {{ $order->vendor->name }}</p>

                                    <p class="mb-1 fs-10"><strong>Email:</strong> <a

                                            href="mailto:{{ $order->vendor->email }}">{{ $order->vendor->email }}</a></p>

                                    <p class="mb-1 fs-10"><strong>Phone:</strong> <a

                                            href="tel:{{ $order->vendor->phone }}">{{ $order->vendor->phone }}</a></p>

                                    @if ($order->vendor->address)

                                        <p class="mb-0 fs-10"><strong>Address:</strong> {{ $order->vendor->address }}</p>

                                    @endif

                                </div>

                            </div>

                        @endif

                    @endauth

                </div> --}}



            </div>

        </div>

    </div>



    {{-- Product Items --}}

    <div class="card mb-3">

        <div class="card-body">

            <div class="table-responsive fs-10">

                <table class="table table-striped border-bottom">

                    <thead class="bg-200">

                        <tr>

                            <th class="text-900 border-0">Products</th>

                            <th class="text-900 border-0 text-center">Quantity</th>

                            <th class="text-900 border-0 text-end">Rate</th>

                            <th class="text-900 border-0 text-end">Amount</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($order->items as $item)

                            <tr class="border-200">

                                <td class="align-middle">

                                    <h6 class="mb-0 text-nowrap">{{ $item->product->product_name ?? 'N/A' }}</h6>

                                </td>

                                <td class="align-middle text-center">{{ $item->quantity }}</td>

                                <td class="align-middle text-end">₹{{ number_format($item->price, 2) }}</td>

                                <td class="align-middle text-end">₹{{ number_format($item->price * $item->quantity, 2) }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>



            {{-- Order Summary --}}

            <div class="row g-0 justify-content-end mt-3">

                <div class="col-auto">

                    <table class="table table-sm table-borderless fs-10 text-end">

                        <tr>

                            <th class="text-900">Subtotal:</th>

                            <td class="fw-semi-bold">₹{{ number_format($order->subtotal, 2) }}</td>

                        </tr>

                        <tr>

                            <th class="text-900">Shipping Cost:</th>

                            <td class="fw-semi-bold">₹{{ number_format($order->shipping_cost ?? 0, 2) }}</td>

                        </tr>

                        <tr>

                            <th class="text-900">Tax:</th>

                            <td class="fw-semi-bold">₹{{ number_format($order->tax ?? 0, 2) }}</td>

                        </tr>

                        <tr>

                            <th class="text-900">Discount:</th>

                            <td class="fw-semi-bold">₹{{ number_format($order->discount ?? 0, 2) }}</td>

                        </tr>

                        <tr class="border-top">

                            <th class="text-900">Total:</th>

                            <td class="fw-semi-bold">₹{{ number_format($order->total, 2) }}</td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection

