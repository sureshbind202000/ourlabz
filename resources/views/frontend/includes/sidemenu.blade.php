<div class="sidebar">

    <div class="sidebar-top">

        <div class="sidebar-profile-img">



            <img

                src="{{ !empty(auth()->user()->profile) && auth()->user()->profile !== 'dummy' 

            ? asset(auth()->user()->profile) 

            : asset('backend/assets/img/team/avatar.png') }}"

                alt="Profile Image"

                id="currentProfileImage">





            <button type="button" class="profile-img-btn"><i class="far fa-camera"></i></button>

            <input type="file" class="profile-img-file" id="profile-image">

        </div>

        <h5>{{auth()->user()->name ?? 'User'}}</h5>

        <p>

            @php

            $email = auth()->user()->email;

            [$username, $domain] = explode('@', $email);

            $visibleEnd = substr($username, -2);

            $maskedUsername = str_repeat('x', strlen($username) - 2) . $visibleEnd;

            $maskedEmail = $maskedUsername . '@' . $domain;

            @endphp



        <p><a href="{{route('user.profile')}}">{{ $maskedEmail }}</a></p>

        </p>

    </div>

    <ul class="sidebar-list" id="sidebar-list">

        <li><a class=" " href="{{route('user.dashboard')}}"><i class="far fa-gauge-high"></i> Dashboard</a></li>

        <li><a class=" " href="{{route('abhaindex')}}"><i class="far fa-id-card"></i> ABHA Card</a></li>

        <li><a class=" " href="{{route('user.all.report')}}"><i class="far fa-file-lines"></i> All Reports</a></li>

        <li><a class=" " href="{{route('user.all.consultation')}}"><i class="far fa-stethoscope"></i> All Consultations</a></li>

        <li><a class=" " href="{{route('user.profile')}}"><i class="far fa-user"></i> My Profile</a></li>

        <li><a class=" " href="{{route('booking_list')}}"><i class="far fa-microscope"></i> My Bookings </a></li>

        <li><a class=" " href="{{route('order_list')}}"><i class="far fa-box-open"></i> My Orders </a></li>

        <li><a class=" " href="{{route('wishlist')}}"><i class="far fa-heart"></i> My Wishlist </a></li>

        <li><a class=" " href="{{route('user.addresses')}}"><i class="far fa-location-dot"></i> Addresses</a></li>

        {{-- <li><a class=" " href="{{route('user.support')}}"><i class="far fa-headset"></i> Support Tickets </a></li> --}}

        <li><a class=" " href="{{route('track_order')}}"><i class="fa-regular fa-truck-fast"></i> Track My Order</a></li>

        <li><a class=" " href="{{route('live.tracking')}}"><i class="far fa-map-location-dot"></i> Live Tracking</a></li>

        <li><a class=" " href="{{route('payment_method')}}"><i class="far fa-wallet"></i> Payment Methods</a></li>

        <li><a class=" " href="{{route('user_notification')}}"><i class="far fa-bell"></i> Notifications</a></li>

        <!-- <li><a class=" " href="{{route('user_setting')}}"><i class="far fa-gear"></i> Settings</a></li> -->

        <li>

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit" class="dropdown-item d-flex align-items-center">

                    <i class="far fa-sign-out me-2 text-primary"></i> {{ __('Logout') }}

                </button>

            </form>

        </li>



    </ul>

</div>