@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header position-relative min-vh-25 mb-7">
        <div class="bg-holder rounded-3 rounded-bottom-0"
            style="background-image:url({{ asset('backend/assets/img/generic/4.jpg') }});">
        </div><!--/.bg-holder-->
        <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm"
                src="@if ($user->profile == 'dummy') {{ asset('backend/assets/img/team/avatar.png') }} @else {{ asset($user->profile) }} @endif"
                width="200" alt="" /></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="mb-1">{{ $user->name }} <span data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Verified"><small class="fa fa-check-circle text-primary"
                            data-fa-transform="shrink-4 down-2"></small></span></h4>
                <span class="fs-10 fw-bold text-dark">Phone : </span> <span class="text-500">{{ $user->phone ?? 'N/A' }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">Email : </span> <span class="text-500">{{ $user->email ?? 'N/A'  }}</span>
                <br>
                <span class="fs-10 fw-bold text-dark">Password : </span> <span
                    class="text-500">{{ $user->show_password ?? 'N/A' }}</span>
                <br>
                @php
                $address = $user->user_details;
                $hasAddress = $address &&
                ($address->street_address || $address->city || $address->state || $address->country || $address->postal_code);
                @endphp

                <p class="mb-0">
                    <span class="fs-10 fw-bold text-dark">Address : </span>
                    @if ($hasAddress)
                    {{ $address->street_address ?? '' }}
                    {{ $address->city ? ', ' . $address->city : '' }}
                    {{ $address->state ? ', ' . $address->state : '' }}
                    {{ $address->country ? ', ' . $address->country : '' }}
                    {{ $address->postal_code ? ', ' . $address->postal_code : '' }}
                    @else
                    <span class="text-danger">No address found</span>
                    @endif
                </p>

                <a class="btn btn-falcon-primary btn-sm" href="{{url()->previous()}}"><i class="fa-solid fa-arrow-left"></i></a>
                @if(auth()->user()->role == 4)
                <button class="btn btn-falcon-primary btn-sm px-3 ms-2 editbtn" type="button" data-id="{{ $user->id ?? '' }}"><i class="fa-solid fa-pen-to-square"></i></button>
                <button class="btn btn-falcon-danger btn-sm px-3 ms-2 deletebtn" type="button" data-id="{{ $user->id ?? '' }}"><i class="fa-solid fa-trash-can"></i></button>
                @endif
                <div class="border-bottom border-dashed my-4 d-lg-none"></div>
            </div>
            <div class="col ps-2 ps-lg-3"><a class="d-flex align-items-center mb-2" href="#"><span
                        class="fas fa-user-circle fs-6 me-2 text-700" data-fa-transform="grow-2"></span>
                    <div class="flex-1">
                        <h6 class="mb-0">See followers (330)</h6>
                    </div>
                </a><a class="d-flex align-items-center mb-2" href="#"><img class="align-self-center me-2"
                        src="{{asset('backend/assets/img/logos/g.png')}}" alt="Generic placeholder image" width="30" />
                    <div class="flex-1">
                        <h6 class="mb-0">Google</h6>
                    </div>
                </a><a class="d-flex align-items-center mb-2" href="#"><img class="align-self-center me-2"
                        src="{{asset('backend/assets/img/logos/apple.png')}}" alt="Generic placeholder image" width="30" />
                    <div class="flex-1">
                        <h6 class="mb-0">Apple</h6>
                    </div>
                </a><a class="d-flex align-items-center mb-2" href="#"><img class="align-self-center me-2"
                        src="{{asset('backend/assets/img/logos/hp.png')}}" alt="Generic placeholder image" width="30" />
                    <div class="flex-1">
                        <h6 class="mb-0">Hewlett Packard</h6>
                    </div>
                </a></div>
        </div>
    </div>
</div>
<div class="row g-0">
    <div class="col-lg-8 pe-lg-2">
        <div class="card mb-3">
            <div class="card-header bg-body-tertiary">
                <h5 class="mb-0">Intro</h5>
            </div>
            <div class="card-body text-justify">
                <p class="mb-0 text-1000">Dedicated, passionate, and accomplished Full Stack Developer with 9+ years of
                    progressive experience working as an Independent Contractor for Google and developing and growing my
                    educational social network that helps others learn programming, web design, game development,
                    networking.</p>
                <div class="collapse show" id="profile-intro">
                    <p class="mt-3 text-1000">I’ve acquired a wide depth of knowledge and expertise in using my
                        technical
                        skills in programming, computer science, software development, and mobile app development to
                        developing solutions to help organizations increase productivity, and accelerate business
                        performance. </p>
                    <p class="text-1000">It’s great that we live in an age where we can share so much with technology
                        but
                        I’m but I’m ready for the next phase of my career, with a healthy balance between the virtual
                        world
                        and a workplace where I help others face-to-face.</p>
                    <p class="text-1000 mb-0">There’s always something new to learn, especially in IT-related fields.
                        People like working with me because I can explain technology to everyone, from staff to
                        executives
                        who need me to tie together the details and the big picture. I can also implement the
                        technologies
                        that successful projects need.</p>
                </div>
            </div>
            <div class="card-footer bg-body-tertiary p-0 border-top"><button
                    class="btn btn-link d-block w-100 btn-intro-collapse" type="button" data-bs-toggle="collapse"
                    data-bs-target="#profile-intro" aria-expanded="true" aria-controls="profile-intro">Show <span
                        class="less">less<span class="fas fa-chevron-up ms-2 fs-11"></span></span><span
                        class="full">full<span class="fas fa-chevron-down ms-2 fs-11"></span></span></button></div>
        </div>
        <div class="card mb-3">
            <div class="card-header bg-body-tertiary d-flex justify-content-between">
                <h5 class="mb-0">Associations</h5><a class="font-sans-serif"
                    href="../miscellaneous/associations.html">All Associations</a>
            </div>
            <div class="card-body fs-10 pb-0">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="d-flex position-relative align-items-center mb-2"><img
                                class="d-flex align-self-center me-2 rounded-3" src="{{asset('backend/assets/img/logos/apple.png')}}"
                                alt="" width="50" />
                            <div class="flex-1">
                                <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Apple</a></h6>
                                <p class="mb-1">3243 associates</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="d-flex position-relative align-items-center mb-2"><img
                                class="d-flex align-self-center me-2 rounded-3" src="{{asset('backend/assets/img/logos/g.png')}}"
                                alt="" width="50" />
                            <div class="flex-1">
                                <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Google</a></h6>
                                <p class="mb-1">34598 associates</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="d-flex position-relative align-items-center mb-2"><img
                                class="d-flex align-self-center me-2 rounded-3"
                                src="{{asset('backend/assets/img/logos/intel-2.png')}}" alt="" width="50" />
                            <div class="flex-1">
                                <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Intel</a></h6>
                                <p class="mb-1">7652 associates</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="d-flex position-relative align-items-center mb-2"><img
                                class="d-flex align-self-center me-2 rounded-3"
                                src="{{asset('backend/assets/img/logos/facebook.png')}}" alt="" width="50" />
                            <div class="flex-1">
                                <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Facebook</a></h6>
                                <p class="mb-1">765 associates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header bg-body-tertiary d-flex justify-content-between">
                <h5 class="mb-0">Activity log</h5><a class="font-sans-serif"
                    href="../../app/social/activity-log.html">All logs</a>
            </div>
            <div class="card-body fs-10 p-0">
                <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                    <div class="notification-avatar">
                        <div class="avatar avatar-xl me-3">
                            <div class="avatar-emoji rounded-circle "><span role="img"
                                    aria-label="Emoji">🎁</span></div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <p class="mb-1"><strong>Jennifer Kent</strong> Congratulated <strong>Anthony Hopkins</strong>
                        </p>
                        <span class="notification-time">November 13, 5:00 Am</span>
                    </div>
                </a>

                <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                    <div class="notification-avatar">
                        <div class="avatar avatar-xl me-3">
                            <div class="avatar-emoji rounded-circle "><span role="img"
                                    aria-label="Emoji">🏷️</span></div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <p class="mb-1"><strong>California Institute of Technology</strong> tagged <strong>Anthony
                                Hopkins</strong> in a post.</p>
                        <span class="notification-time">November 8, 5:00 PM</span>
                    </div>
                </a>

                <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                    <div class="notification-avatar">
                        <div class="avatar avatar-xl me-3">
                            <div class="avatar-emoji rounded-circle "><span role="img"
                                    aria-label="Emoji">📋️</span></div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <p class="mb-1"><strong>Anthony Hopkins</strong> joined <strong>Victory day cultural
                                Program</strong> with <strong>Tony Stark</strong></p>
                        <span class="notification-time">November 01, 11:30 AM</span>
                    </div>
                </a>

                <a class="notification border-x-0 border-bottom-0 border-300 rounded-top-0" href="#!">
                    <div class="notification-avatar">
                        <div class="avatar avatar-xl me-3">
                            <div class="avatar-emoji rounded-circle "><span role="img"
                                    aria-label="Emoji">📅️</span></div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <p class="mb-1"><strong>Massachusetts Institute of Technology</strong> invited
                            <strong>Anthony
                                Hopkin</strong> to an event
                        </p>
                        <span class="notification-time">October 28, 12:00 PM</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="card mb-3 mb-lg-0">
            <div class="card-header bg-body-tertiary">
                <h5 class="mb-0">Photos</h5>
            </div>
            <div class="card-body overflow-hidden">
                <div class="row g-0">
                    <div class="col-6 p-1"><a class="glightbox" href="{{asset('backend/assets/img/generic/4.jpg')}}"
                            data-gallery="gallery1" data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                src="{{asset('backend/assets/img/generic/4.jpg')}}" alt="..." /></a></div>
                    <div class="col-6 p-1"><a class="glightbox" href="{{asset('backend/assets/img/generic/5.jpg')}}"
                            data-gallery="gallery1" data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                src="{{asset('backend/assets/img/generic/5.jpg')}}" alt="..." /></a></div>
                    <div class="col-4 p-1"><a class="glightbox" href="{{asset('backend/assets/img/gallery/4.jpg')}}"
                            data-gallery="gallery1" data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                src="{{asset('backend/assets/img/gallery/4.jpg')}}" alt="..." /></a></div>
                    <div class="col-4 p-1"><a class="glightbox" href="{{asset('backend/assets/img/gallery/5.jpg')}}"
                            data-gallery="gallery1" data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                src="{{asset('backend/assets/img/gallery/5.jpg')}}" alt="..." /></a></div>
                    <div class="col-4 p-1"><a class="glightbox" href="{{asset('backend/assets/img/gallery/3.jpg')}}"
                            data-gallery="gallery1" data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                src="{{asset('backend/assets/img/gallery/3.jpg')}}" alt="..." /></a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 ps-lg-2">
        <div class="sticky-sidebar">
            <div class="card mb-3">
                <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Wallet</h5>
                    <a href="javascript:void(0)" class="text-primary fs-9" data-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#walletHistoryModal" id="walletHistoryTrigger">
                        <i class="fa fa-clock me-1"></i>History
                    </a>
                </div>
                <div class="card-body fs-10">
                    <div class="d-flex align-items-start">

                        <div class="flex-1 position-relative ps-3">


                            <p class="mb-1 fw-bold text-success fs-8">
                                ₹{{ number_format($user->wallet, 2) }}
                            </p>

                            <p class="text-1000 mb-0">Active Wallet</p>
                            <p class="text-1000 mb-0">Last updated: {{ now()->format('d M, Y h:i A') }}</p>

                            <div class="border-bottom border-dashed my-3"></div>
                        </div>

                        <i class="fa-solid fa-plus text-primary cursor-pointer rounded-circle bg-white p-2 shadow-sm ms-2 mt-1"
                            data-bs-toggle="modal" data-bs-target="#addWalletModal" title="Add to Wallet"
                            style="font-size: 16px;"></i>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-body-tertiary">
                    <h5 class="mb-0">Education</h5>
                </div>
                <div class="card-body fs-10">
                    <div class="d-flex"><a href="#!">
                            <div class="avatar avatar-3xl">
                                <div class="avatar-name rounded-circle"><span>SU</span></div>
                            </div>
                        </a>
                        <div class="flex-1 position-relative ps-3">
                            <h6 class="fs-9 mb-0"> <a href="#!">Stanford University<span
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small
                                            class="fa fa-check-circle text-primary"
                                            data-fa-transform="shrink-4 down-2"></small></span></a></h6>
                            <p class="mb-1">Computer Science and Engineering</p>
                            <p class="text-1000 mb-0">2010 - 2014 • 4 yrs</p>
                            <p class="text-1000 mb-0">California, USA</p>
                            <div class="border-bottom border-dashed my-3"></div>
                        </div>
                    </div>
                    <div class="d-flex"><a href="#!"> <img class="img-fluid"
                                src="{{asset('backend/assets/img/logos/staten.png')}}" alt="" width="56" /></a>
                        <div class="flex-1 position-relative ps-3">
                            <h6 class="fs-9 mb-0"> <a href="#!">Staten Island Technical High School<span
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small
                                            class="fa fa-check-circle text-primary"
                                            data-fa-transform="shrink-4 down-2"></small></span></a></h6>
                            <p class="mb-1">Higher Secondary School Certificate, Science</p>
                            <p class="text-1000 mb-0">2008 - 2010 &bull; 2 yrs</p>
                            <p class="text-1000 mb-0">New York, USA</p>
                            <div class="border-bottom border-dashed my-3"></div>
                        </div>
                    </div>
                    <div class="d-flex"><a href="#!"> <img class="img-fluid"
                                src="{{asset('backend/assets/img/logos/tj-heigh-school.png')}}" alt="" width="56" /></a>
                        <div class="flex-1 position-relative ps-3">
                            <h6 class="fs-9 mb-0"> <a href="#!">Thomas Jefferson High School for Science and
                                    Technology<span data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Verified"><small class="fa fa-check-circle text-primary"
                                            data-fa-transform="shrink-4 down-2"></small></span></a></h6>
                            <p class="mb-1">Secondary School Certificate, Science</p>
                            <p class="text-1000 mb-0">2003 - 2008 &bull; 5 yrs</p>
                            <p class="text-1000 mb-0">Alexandria, USA</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 mb-lg-0">
                <div class="card-header bg-body-tertiary">
                    <h5 class="mb-0">Events</h5>
                </div>
                <div class="card-body fs-10">
                    <div class="d-flex btn-reveal-trigger">
                        <div class="calendar"><span class="calendar-month">Feb</span><span
                                class="calendar-day">21</span>
                        </div>
                        <div class="flex-1 position-relative ps-3">
                            <h6 class="fs-9 mb-0"><a href="../../app/events/event-detail.html">Newmarket Nights</a>
                            </h6>
                            <p class="mb-1">Organized by <a href="#!" class="text-700">University of
                                    Oxford</a></p>
                            <p class="text-1000 mb-0">Time: 6:00AM</p>
                            <p class="text-1000 mb-0">Duration: 6:00AM - 5:00PM</p>Place: Cambridge Boat Club,
                            Cambridge<div class="border-bottom border-dashed my-3"></div>
                        </div>
                    </div>
                    <div class="d-flex btn-reveal-trigger">
                        <div class="calendar"><span class="calendar-month">Dec</span><span
                                class="calendar-day">31</span>
                        </div>
                        <div class="flex-1 position-relative ps-3">
                            <h6 class="fs-9 mb-0"><a href="../../app/events/event-detail.html">31st Night
                                    Celebration</a></h6>
                            <p class="mb-1">Organized by <a href="#!" class="text-700">Chamber Music
                                    Society</a></p>
                            <p class="text-1000 mb-0">Time: 11:00PM</p>
                            <p class="text-1000 mb-0">280 people interested</p>Place: Tavern on the Greend, New York
                            <div class="border-bottom border-dashed my-3"></div>
                        </div>
                    </div>
                    <div class="d-flex btn-reveal-trigger">
                        <div class="calendar"><span class="calendar-month">Dec</span><span
                                class="calendar-day">16</span>
                        </div>
                        <div class="flex-1 position-relative ps-3">
                            <h6 class="fs-9 mb-0"><a href="../../app/events/event-detail.html">Folk Festival</a></h6>
                            <p class="mb-1">Organized by <a href="#!" class="text-700">Harvard University</a>
                            </p>
                            <p class="text-1000 mb-0">Time: 9:00AM</p>
                            <p class="text-1000 mb-0">Location: Cambridge Masonic Hall Association</p>Place: Porter
                            Square,
                            North Cambridge
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-body-tertiary p-0 border-top"><a class="btn btn-link d-block w-100"
                        href="../../app/events/event-list.html">All Events<span
                            class="fas fa-chevron-right ms-1 fs-11"></span></a></div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Employee Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog mt-6 modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Employee</h4>
                    <p class="fs-10 mb-0 text-white">Update employee details.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <div class="theme-wizard">
                    <form class="row" id="updateUser" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">

                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-1"></i></span></span>
                                        <span class="d-none d-md-block mt-1 fs-10">Personal Details</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"
                                        data-bs-toggle="tab" data-wizard-step="2"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-2"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3"
                                        data-bs-toggle="tab" data-wizard-step="3"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-3"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Address Details</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                        data-bs-toggle="tab" data-wizard-step="4"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-4"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Medical Information</span></a>
                                </li>

                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                        data-bs-toggle="tab" data-wizard-step="5"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-5"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Login & Account</span></a>
                                </li>

                            </ul>
                        </div>
                        <div class="py-4">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1"
                                    data-wizard-form="1">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_name">Full Name</label>
                                            <input class="form-control" id="edit_name" name="name" type="text"
                                                placeholder="Enter name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="gender">Gender</label>
                                            <br>
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" id="edit_male" type="radio"
                                                    name="gender" value="Male" />
                                                <label class="form-check-label" for="edit_male">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" id="edit_female" type="radio"
                                                    name="gender" value="Female" />
                                                <label class="form-check-label" for="edit_female">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" id="edit_other" type="radio"
                                                    name="gender" value="Female" />
                                                <label class="form-check-label" for="edit_other">Other</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_date_of_birth">Date of Birth</label>
                                            <input class="form-control" id="edit_date_of_birth" name="date_of_birth"
                                                type="date" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_age">Age</label>
                                            <input class="form-control" id="edit_age" name="age" type="number"
                                                placeholder="Auto-calculated based on DOB" readonly />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_blood_group">Blood Group</label>
                                            <select name="blood_group" id="edit_blood_group" class="form-select">
                                                <option value="">--select--</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label">Upload Image (optional)</label>
                                            <input class="form-control" id="edit_profile" name="profile"
                                                type="file" />
                                            <br>
                                            <img src="" alt="" id="PreviewProfile" height="100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                    data-wizard-form="2">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_phone">Phone</label>
                                            <input class="form-control" id="edit_phone" name="phone"
                                                type="number" placeholder="Enter phone number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_alternate_phone">Alternate
                                                Phone</label>
                                            <input class="form-control" id="edit_alternate_phone"
                                                name="alternate_phone" type="number"
                                                placeholder="Enter alternate phone number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_email">Email (Optional)</label>
                                            <input class="form-control" id="edit_email" name="email"
                                                type="text" placeholder="Enter email" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_emergency_contact_name">Emergency
                                                Contact
                                                Name</label>
                                            <input class="form-control" id="edit_emergency_contact_name"
                                                name="emergency_contact_name" type="text"
                                                placeholder="Enter emergency contact name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_emergency_contact_phone">Emergency
                                                Contact
                                                Phone</label>
                                            <input class="form-control" id="edit_emergency_contact_phone"
                                                name="emergency_contact_phone" type="number"
                                                placeholder="Enter emergency contact phone number" />
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                    data-wizard-form="3">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_address">Street Address</label>
                                            <input class="form-control" id="edit_address" name="address"
                                                type="text" placeholder="Enter address" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_city">City</label>
                                            <input class="form-control" id="edit_city" name="city" type="text"
                                                placeholder="Enter city" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_state">State</label>
                                            <input class="form-control" id="edit_state" name="state"
                                                type="text" placeholder="Enter state" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_country">Country</label>
                                            <input class="form-control" id="edit_country" name="country"
                                                type="text" placeholder="Enter country" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_pin">Pin/Postal code</label>
                                            <input class="form-control" id="edit_pin" name="pin" type="text"
                                                placeholder="Enter pin/postal code" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_google_map_location">Google Map
                                                Location
                                                (optional)</label>
                                            <input class="form-control" id="edit_google_map_location"
                                                name="google_map_location" type="text"
                                                placeholder="Enter google map location" />
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4"
                                    data-wizard-form="4">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_medical_condition">Existing Medical
                                                Conditions </label>
                                            <select name="medical_condition[]" id="edit_medical_condition"
                                                class="form-select" multiple="multiple" size="1"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">--select--</option>
                                                <option value="Diabetes">Diabetes</option>
                                                <option value="Hypertension">Hypertension</option>
                                                <option value="Asthma">Asthma</option>
                                                <option value="Heart Disease">Heart Disease</option>
                                                <option value="Thyroid Disorder">Thyroid Disorder</option>
                                                <option value="Arthritis">Arthritis</option>
                                                <option value="Epilepsy">Epilepsy</option>
                                                <option value="Chronic Kidney Disease">Chronic Kidney Disease</option>
                                                <option value="Liver Disease">Liver Disease</option>
                                                <option value="Cancer">Cancer</option>
                                                <option value="Tuberculosis">Tuberculosis</option>
                                                <option value="Anemia">Anemia</option>
                                                <option value="Migraines">Migraines</option>
                                                <option value="HIV/AIDS">HIV/AIDS</option>

                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_allergies">Allergies (if any)</label>
                                            <select name="allergies[]" id="edit_allergies" class="form-select"
                                                multiple="multiple" size="1"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">--select--</option>
                                                <option value="Peanuts">Peanuts</option>
                                                <option value="Tree Nuts">Tree Nuts</option>
                                                <option value="Shellfish">Shellfish</option>
                                                <option value="Milk">Milk</option>
                                                <option value="Eggs">Eggs</option>
                                                <option value="Wheat">Wheat</option>
                                                <option value="Soy">Soy</option>
                                                <option value="Pollen">Pollen</option>
                                                <option value="Dust Mites">Dust Mites</option>
                                                <option value="Pet Dander">Pet Dander</option>
                                                <option value="Insect Stings">Insect Stings</option>
                                                <option value="Latex">Latex</option>
                                                <option value="Mold">Mold</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_current_medications">Current
                                                Medications</label>
                                            <textarea name="current_medications" id="edit_current_medications" rows="5" class="form-control"
                                                placeholder="Enter current medications"></textarea>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_family_doctor_name_contact">Family
                                                Doctor
                                                Name & Contact (Optional) </label>
                                            <input class="form-control" id="edit_family_doctor_name_contact"
                                                name="family_doctor_name_contact" type="text"
                                                placeholder="Enter family doctor name & contact" />
                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                    data-wizard-form="5">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_username">username</label>
                                            <input class="form-control" id="edit_username" name="username"
                                                type="text" placeholder="Enter username" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_password">Password</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control w-75" type="password" name="password"
                                                    id="edit_password" placeholder="Type or generate password." />
                                                <button type="button"
                                                    class="btn btn-success edit-generate-password"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Click to generate random password.">
                                                    <i class="fa-solid fa-key"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" id="edit_terms_condition"
                                                    type="checkbox" value="" name="terms_condition" />
                                                <label class="form-check-label" for="edit_terms_condition">Consent
                                                    to Terms & Conditions</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="edit_subscribe"
                                                    type="checkbox" value="" name="subscribe" />
                                                <label class="form-check-label"
                                                    for="edit_subscribe">Subscribe to Notifications &
                                                    Updates? </label>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-12 text-center">
                                            <button class="btn btn-primary bg-gradient px-5 "
                                                type="submit">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer" style="display: block !important;">
                            <div class="px-sm-3 px-md-5">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous"><button class="btn btn-falcon-primary px-5 px-sm-6"
                                            type="button" style="display: block !important;"><span
                                                class="fas fa-chevron-left me-2"
                                                data-fa-transform="shrink-3"></span>Prev</button></li>
                                    <li class="next"><button class="btn btn-primary px-5 px-sm-6"
                                            type="button">Next<span class="fas fa-chevron-right ms-2"
                                                data-fa-transform="shrink-3"> </span></button></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Employee Modal End -->

<!-- Add to Wallet Modal Start -->

<div class="modal fade" id="addWalletModal" tabindex="-1" aria-labelledby="addWalletModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addWalletForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="hidden" name="id" id="id" value="{{$user->id}}">
                        <input type="number" class="form-control" name="amount" required min="1" step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Add to Wallet Modal End -->
<!-- Wallet History Modal Start -->
<div class="modal fade" id="walletHistoryModal" tabindex="-1" aria-labelledby="walletHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="walletHistoryModalLabel">Wallet History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div id="walletHistoryLoader" class="text-center my-4">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                </div>
                <div id="walletHistoryContent" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>
<!-- Wallet History Modal End -->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#date_of_birth').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();

            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            $('#age').val(age >= 0 ? age : '');
        });
        $('#edit_date_of_birth').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();

            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            $('#edit_age').val(age >= 0 ? age : '');
        });

        function generatePassword() {
            let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let password = "";
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }

        // Event to generate a password when the button is clicked
        $(".generate-password").on("click", function() {
            var newPassword = generatePassword();
            $("#password").val(newPassword);
            $("#password").attr("type", "text").focus();
        });

        // Toggle password visibility when input is focused
        $("#password").on("focus", function() {
            $(this).attr("type", "text");
        });

        // Revert back to password type when focus is lost
        $("#password").on("blur", function() {
            $(this).attr("type", "password");
        });

        $(".edit-generate-password").on("click", function() {
            var newPassword = generatePassword();
            $("#edit_password").val(newPassword);
            $("#edit_password").attr("type", "text").focus();
        });

        // Toggle password visibility when input is focused
        $("#edit_password").on("focus", function() {
            $(this).attr("type", "text");
        });

        // Revert back to password type when focus is lost
        $("#edit_password").on("blur", function() {
            $(this).attr("type", "password");
        });


        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = date.getDate().toString().padStart(2, '0');
            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        $('#addModalBtn').on('click', function() {
            $('#addModal').modal('show');
        });



        $('#register-form').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages
            $('.error-text').text('');

            const name = $('#login-name').val();
            const phone = $('#login-phone').val();
            const corp_id = $('#corp_id').val();
            const corporate_id = $('#corporate_id').val();
            const terms = $('#terms-check').is(':checked');

            if (!terms) {
                $('#terms-error').text('Please accept the terms and conditions.');
                return;
            }

            $.ajax({
                url: "{{ route('corporate.employee.store') }}",
                type: 'POST',
                data: {
                    name: name,
                    phone: phone,
                    corp_id: corp_id,
                    corporate_id: corporate_id,
                    terms_condition: terms ? 1 : 0,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#register-form')[0].reset();
                    $('#addModal').modal('hide');
                    fetchEmployees(); // refresh the list
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.phone) {
                            $('#phone-error').text(errors.phone[0]);
                        }
                        if (errors.name) {
                            $('#name-error').text(errors.name[0]);
                        }
                        if (errors.terms_condition) {
                            $('#terms-error').text(errors.terms_condition[0]);
                        }
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                }
            });
        });
        $(document).on('click', '.editbtn', function() {
            $('.loading').show();
            let userId = $(this).data('id');

            $.ajax({
                url: '/user/' + userId + '/edit',
                type: 'GET',
                success: function(response) {
                    let user = response.user;

                    // Basic user info
                    $('#edit_id').val(user.id);
                    $('#edit_name').val(user.name);
                    $('#edit_username').val(user.username);
                    $('#edit_phone').val(user.phone);
                    $('#edit_email').val(user.email);
                    $('#edit_date_of_birth').val(user.date_of_birth || '');
                    $('#edit_age').val(user.age || '');
                    $('#edit_blood_group').val(user.blood_group || '');
                    $('#edit_terms_condition').prop('checked', user.terms_condition == 1);
                    $('#edit_subscribe').prop('checked', user.subscribe == 1);
                    if (user.profile == 'dummy') {
                        $('#PreviewProfile').attr('src', '/backend/assets/img/team/avatar.png');
                    } else {
                        $('#PreviewProfile').attr('src', '/' + user.profile);
                    }

                    // Gender
                    $('input[name="gender"]').prop('checked', false);
                    if (user.gender == 'Male') {
                        $('#edit_male').prop('checked', true);
                    }
                    if (user.gender == 'Female') {
                        $('#edit_female').prop('checked', true);
                    }
                    if (user.gender == 'Other') {
                        $('#edit_other').prop('checked', true);
                    }
                    // User Details
                    if (user.user_details) {
                        let details = user.user_details;
                        $('#edit_address').val(details.address || '');
                        $('#edit_city').val(details.city || '');
                        $('#edit_state').val(details.state || '');
                        $('#edit_country').val(details.country || '');
                        $('#edit_pin').val(details.pin || '');
                        $('#edit_google_map_location').val(details.google_map_location ||
                            '');
                        $('#edit_alternate_phone').val(details.alternate_phone || '');
                        $('#edit_emergency_contact_name').val(details
                            .emergency_contact_name || '');
                        $('#edit_emergency_contact_phone').val(details
                            .emergency_contact_phone || '');
                    } else {
                        $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone, #edit_emergency_contact_name, #edit_emergency_contact_phone')
                            .val('');
                    }

                    // Medical Information
                    if (user.medical_information) {
                        initOrResetChoices('#edit_medical_condition',
                            'editMedicalCondition', user.medical_information
                            .medical_condition);
                        initOrResetChoices('#edit_allergies', 'editAllergies', user
                            .medical_information.allergies);
                        $('#edit_current_medications').val(user.medical_information
                            .current_medications || '');
                        $('#edit_family_doctor_name_contact').val(user.medical_information
                            .family_doctor_name_contact || '');
                    } else {
                        $('#edit_medical_condition, #edit_allergies, #edit_current_medications, #edit_family_doctor_name_contact')
                            .val('');
                    }

                    $('#editModal').modal('show');
                    $('.loading').hide();
                },
                error: function() {
                    $('.loading').hide();
                    alert('Something went wrong while fetching user data.');
                }
            });
        });
        // Update User AJAX
        $('#updateUser').submit(function(e) {
            e.preventDefault();
            $('.loading').show();

            var userId = $('#edit_id').val();
            var formData = new FormData(this);
            formData.append('_method', 'PUT');
            $.ajax({
                url: '/user/' + userId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    $('.loading').hide();
                    window.location.reload();
                },
                error: function(xhr, error, status) {
                    console.log(xhr, error, status);
                    Swal.fire("Error!", "Something went wrong.", "error");
                    $('.loading').hide();
                }
            });
        });

        // Delete 
        $(document).on('click', '.deletebtn', function() {
            let empId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the user and all related data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();

                    $.ajax({
                        url: `/user/${empId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('.loading').hide();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The user and related data have been deleted.",
                                    "success");
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }
                        },
                        error: function(xhr) {
                            $('.loading').hide();
                            Swal.fire("Error!", "Failed to delete user.",
                                "error");
                        }
                    });
                }
            });
        });


        $('#addWalletForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '/corporate/employee/wallet/add',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.success) {
                        $('#addWalletModal').modal('hide');
                        Swal.fire('Success', res.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: res.message || 'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error : ", xhr, status, error)
                    let errorMessage = 'Something went wrong.';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            // Collect all validation errors
                            errorMessage = Object.values(xhr.responseJSON.errors)
                                .flat()
                                .join('\n');
                        } else if (xhr.responseJSON.message) {
                            // General error message
                            errorMessage = xhr.responseJSON.message;
                        }
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }

            });
        });
        $('#walletHistoryModal').on('shown.bs.modal', function() {
            const content = $('#walletHistoryContent');
            const loader = $('#walletHistoryLoader');
            const userId = $('#walletHistoryTrigger').data('user-id');
            console.log(userId);

            content.hide().empty();
            loader.show();

            $.ajax({
                url: '/corporate/employee/wallet/history',
                method: 'GET',
                data: {
                    user_id: userId
                },
                success: function(res) {
                    loader.hide();
                    if (res.success && res.data.length > 0) {
                        let html = `<div class="list-group list-group-flush">`;

                        res.data.forEach(item => {
                            const sign = item.type === 'credit' ? '+' : '-';
                            const amountColor = item.type === 'credit' ? 'text-success' : 'text-danger';
                            const icon = item.type === 'credit' ? 'fa-arrow-down' : 'fa-arrow-up';

                            html += `
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fa ${icon} ${amountColor}"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold ${amountColor}">
                                        ${sign} ₹${parseFloat(item.amount).toFixed(2)}
                                    </div>
                                    <div class="text-muted small">${item.note || '—'}</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">${item.date}</small>
                            </div>
                        </div>
                    `;
                        });

                        html += `</div>`;
                        content.html(html).fadeIn();
                    } else {
                        content.html('<p class="text-center text-muted my-4">No wallet history found.</p>').fadeIn();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                    loader.hide();
                    content.html('<p class="text-center text-danger my-4">Failed to load wallet history.</p>').fadeIn();
                }
            });
        });

    });
</script>
@endsection