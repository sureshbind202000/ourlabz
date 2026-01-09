<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand d-flex">

    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse"

        data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false"

        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

    <a class="navbar-brand me-1 me-sm-3" href="index.html">

        <div class="d-flex align-items-center"><img class="me-2"

                src="{{ asset('backend/assets/img/icons/spot-illustrations/falcon.png') }}" alt=""

                width="40" /><span class="font-sans-serif text-primary">Ourlabz</span></div>

    </a>

    <ul class="navbar-nav align-items-center d-none d-lg-block w-100">

        <li class="nav-item">

            <div class="search-box w-100 pe-3" data-list='{"valueNames":["title"]}'>

                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                    @php
                    $latestNotification = auth()->user()
                    ->unreadNotifications()
                    ->latest()
                    ->first();

                    $notificationText = $latestNotification
                    ? ($latestNotification->data['message'] ?? $latestNotification->data['title'] ?? 'New notification received')
                    : 'No new notifications';

                    // Strip HTML tags & decode entities
                    $notificationText = strip_tags(html_entity_decode($notificationText));
                    @endphp

                    <div class="marquee-container">
                        <div class="marquee-text"><marquee behavior="" direction="">{{ $notificationText }}</marquee></div>
                    </div>
                </form>

                <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"

                    data-bs-dismiss="search"><button class="btn btn-link btn-close-falcon p-0"

                        aria-label="Close"></button></div>
            </div>

        </li>

    </ul>

    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

        @if (auth()->user()->role == 4)

        <li>

            <div class="d-flex align-items-center gap-2 me-3" data-bs-toggle="tooltip" data-bs-placement="bottom"

                data-bs-original-title="Your current wallet balance">

                <i class="fa-solid fa-wallet" style="font-size:21px;"></i>

                <span class="text-success walletBalance" style="font-size: 16px;">₹0.00</span>

            </div>

        </li>

        @endif

        <li class="nav-item dropdown px-1">

            <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait"

                id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true"

                aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-bell"

                    data-fa-transform="shrink-6" style="font-size: 21px;"></span></a>

            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg"

                aria-labelledby="navbarDropdownNotification">

                <div class="card card-notification shadow-none">

                    <div class="card-header">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-auto">

                                <h6 class="card-header-title mb-0">Notifications</h6>

                            </div>

                            <div class="col-auto ps-0 ps-sm-3">



                            </div>

                        </div>

                    </div>

                    <div class="scrollbar-overlay" style="max-height:19rem">

                        <div class="list-group list-group-flush fw-normal fs-10">



                        </div>

                    </div>

                    <div class="card-footer text-center border-top"><a class="card-link d-block"

                            href="{{route('notifications')}}">View all</a></div>

                </div>

            </div>

        </li>

        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"

                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="avatar avatar-xl">

                    @if (auth()->user()->profile == 'dummy')

                    <img class="rounded-circle" src="{{ asset('backend/assets/img/user.png') }}"

                        alt="" />

                    @else

                    <img class="rounded-circle" src="{{ asset(auth()->user()->profile) }}" alt="" />

                    @endif

                </div>

            </a>

            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"

                aria-labelledby="navbarDropdownUser">

                <div class="bg-white dark__bg-1000 rounded-2 py-2">

                    @if (auth()->user()->role == 2)

                    @php

                    $labid = auth()->user()->lab_id ?? null;

                    @endphp

                    <a class="dropdown-item" href="{{ route('lab.profile', ['labid' => $labid]) }}">Profile</a>

                    <a class="dropdown-item"

                        href="{{ route('lab.user.profile', encrypt(auth()->user()->user_id)) }}">Settings</a>

                    @elseif(auth()->user()->role == 5)

                    @php

                    $vendorid = auth()->user()->user_id ?? null;

                    @endphp

                    <a class="dropdown-item"

                        href="{{ route('vendor.profile', ['vendorid' => $vendorid]) }}">Profile</a>

                    @elseif(auth()->user()->role == 3)

                    @php

                    $doctorid = auth()->user()->user_id ?? null;

                    @endphp

                    <a class="dropdown-item"

                        href="{{ route('doctor.profile', ['doctorid' => $doctorid]) }}">Profile</a>

                    @elseif(auth()->user()->role == 4)

                    @php

                    $corporateid = auth()->user()->user_id ?? null;

                    @endphp

                    <a class="dropdown-item"

                        href="{{ route('corporate.profile', ['corporateid' => $corporateid]) }}">Profile</a>

                    @endif

                    <form method="POST" id="logout-form" action="{{ route('logout') }}">

                        @csrf

                        <button type="submit" class="dropdown-item">

                            {{ __('Log Out') }}

                        </button>

                    </form>

                </div>

            </div>

        </li>

    </ul>

</nav>