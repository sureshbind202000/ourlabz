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
                    <h4 class="mb-1">{{ $user->name }} ({{$user->user_id}}) <span data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Verified"><small class="fa fa-check-circle text-primary"
                                data-fa-transform="shrink-4 down-2"></small></span></h4>
                    <span class="badge btn-falcon-primary">
                    @php
                        $roles = [1 => 'Admin', 2 => 'Manager', 3 => 'Technician'];
                        echo $roles[$user->lab_user_role] ?? 'Unknown';
                    @endphp
                    </span>
                    <br>
                    <span class="fs-10 fw-bold text-dark">Lab ID : </span> <span>{{ $user->lab_id }}</span>
                    <br>
                    <span class="fs-10 fw-bold text-dark">Phone : </span> <span>{{ $user->phone }}</span>
                    <br>
                    <span class="fs-10 fw-bold text-dark">Email : </span> <span>{{ $user->email }}</span>
                    <br>
                    <span class="fs-10 fw-bold text-dark">Username : </span> <span>{{ $user->username }}</span>
                    <br>
                    <span class="fs-10 fw-bold text-dark">Password : </span>
                    <span>{{ $user->show_password }}</span>

                    <br>
                    @php
                        $details = $user->user_details->first();
                    @endphp

                    <p><span class="fs-10 fw-bold text-dark">Address : </span>
                        @if ($details)
                            {{ $details->address }}, {{ $details->city }},
                            {{ $details->state }}, {{ $details->country }},
                            {{ $details->pin }}
                        @endif
                    </p>
                    <a class="btn btn-falcon-primary btn-sm" href="{{ url()->previous() }}"><i
                            class="fa-solid fa-arrow-left"></i></a>
                    <button class="btn btn-falcon-primary btn-sm px-3 ms-2 edit-btn" type="button" data-id="{{$user->id}}"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn btn-falcon-danger btn-sm px-3 ms-2 delete-btn" type="button" data-id="{{$user->id}}"><i class="fa-solid fa-trash-can"></i></button>
                    <div class="border-bottom border-dashed my-4 d-lg-none"></div>
                </div>
                <div class="col ps-2 ps-lg-3"><a class="d-flex align-items-center mb-2" href="#"><span
                            class="fas fa-user-circle fs-6 me-2 text-700" data-fa-transform="grow-2"></span>
                        <div class="flex-1">
                            <h6 class="mb-0">See followers (330)</h6>
                        </div>
                    </a><a class="d-flex align-items-center mb-2" href="#"><img class="align-self-center me-2"
                            src="{{ asset('backend/assets/img/logos/g.png') }}" alt="Generic placeholder image"
                            width="30" />
                        <div class="flex-1">
                            <h6 class="mb-0">Google</h6>
                        </div>
                    </a><a class="d-flex align-items-center mb-2" href="#"><img class="align-self-center me-2"
                            src="{{ asset('backend/assets/img/logos/apple.png') }}" alt="Generic placeholder image"
                            width="30" />
                        <div class="flex-1">
                            <h6 class="mb-0">Apple</h6>
                        </div>
                    </a><a class="d-flex align-items-center mb-2" href="#"><img class="align-self-center me-2"
                            src="{{ asset('backend/assets/img/logos/hp.png') }}" alt="Generic placeholder image"
                            width="30" />
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
                                    class="d-flex align-self-center me-2 rounded-3"
                                    src="{{ asset('backend/assets/img/logos/apple.png') }}" alt=""
                                    width="50" />
                                <div class="flex-1">
                                    <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Apple</a></h6>
                                    <p class="mb-1">3243 associates</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex position-relative align-items-center mb-2"><img
                                    class="d-flex align-self-center me-2 rounded-3"
                                    src="{{ asset('backend/assets/img/logos/g.png') }}" alt="" width="50" />
                                <div class="flex-1">
                                    <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Google</a></h6>
                                    <p class="mb-1">34598 associates</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex position-relative align-items-center mb-2"><img
                                    class="d-flex align-self-center me-2 rounded-3"
                                    src="{{ asset('backend/assets/img/logos/intel-2.png') }}" alt=""
                                    width="50" />
                                <div class="flex-1">
                                    <h6 class="fs-9 mb-0"><a class="stretched-link" href="#!">Intel</a></h6>
                                    <p class="mb-1">7652 associates</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex position-relative align-items-center mb-2"><img
                                    class="d-flex align-self-center me-2 rounded-3"
                                    src="{{ asset('backend/assets/img/logos/facebook.png') }}" alt=""
                                    width="50" />
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
                        <div class="col-6 p-1"><a class="glightbox"
                                href="{{ asset('backend/assets/img/generic/4.jpg') }}" data-gallery="gallery1"
                                data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                    src="{{ asset('backend/assets/img/generic/4.jpg') }}" alt="..." /></a></div>
                        <div class="col-6 p-1"><a class="glightbox"
                                href="{{ asset('backend/assets/img/generic/5.jpg') }}" data-gallery="gallery1"
                                data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                    src="{{ asset('backend/assets/img/generic/5.jpg') }}" alt="..." /></a></div>
                        <div class="col-4 p-1"><a class="glightbox"
                                href="{{ asset('backend/assets/img/gallery/4.jpg') }}" data-gallery="gallery1"
                                data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                    src="{{ asset('backend/assets/img/gallery/4.jpg') }}" alt="..." /></a></div>
                        <div class="col-4 p-1"><a class="glightbox"
                                href="{{ asset('backend/assets/img/gallery/5.jpg') }}" data-gallery="gallery1"
                                data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                    src="{{ asset('backend/assets/img/gallery/5.jpg') }}" alt="..." /></a></div>
                        <div class="col-4 p-1"><a class="glightbox"
                                href="{{ asset('backend/assets/img/gallery/3.jpg') }}" data-gallery="gallery1"
                                data-glightbox="data-glightbox"><img class="img-fluid rounded"
                                    src="{{ asset('backend/assets/img/gallery/3.jpg') }}" alt="..." /></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 ps-lg-2">
            <div class="sticky-sidebar">
                <div class="card mb-3">
                    <div class="card-header bg-body-tertiary">
                        <h5 class="mb-0">Experience</h5>
                    </div>
                    <div class="card-body fs-10">
                        <div class="d-flex"><a href="#!"> <img class="img-fluid"
                                    src="{{ asset('backend/assets/img/logos/g.png') }}" alt=""
                                    width="56" /></a>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-9 mb-0">Big Data Engineer<span data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Verified"><small
                                            class="fa fa-check-circle text-primary"
                                            data-fa-transform="shrink-4 down-2"></small></span></h6>
                                <p class="mb-1"> <a href="#!">Google</a></p>
                                <p class="text-1000 mb-0">Apr 2012 - Present &bull; 6 yrs 9 mos</p>
                                <p class="text-1000 mb-0">California, USA</p>
                                <div class="border-bottom border-dashed my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex"><a href="#!"> <img class="img-fluid"
                                    src="{{ asset('backend/assets/img/logos/apple.png') }}" alt=""
                                    width="56" /></a>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-9 mb-0">Software Engineer<span data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Verified"><small
                                            class="fa fa-check-circle text-primary"
                                            data-fa-transform="shrink-4 down-2"></small></span></h6>
                                <p class="mb-1"> <a href="#!">Apple</a></p>
                                <p class="text-1000 mb-0">Jan 2012 - Apr 2012 &bull; 4 mos</p>
                                <p class="text-1000 mb-0">California, USA</p>
                                <div class="border-bottom border-dashed my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex"><a href="#!"> <img class="img-fluid"
                                    src="{{ asset('backend/assets/img/logos/nike.png') }}" alt=""
                                    width="56" /></a>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-9 mb-0">Mobile App Developer<span data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Verified"><small
                                            class="fa fa-check-circle text-primary"
                                            data-fa-transform="shrink-4 down-2"></small></span></h6>
                                <p class="mb-1"> <a href="#!">Nike</a></p>
                                <p class="text-1000 mb-0">Jan 2011 - Apr 2012 &bull; 1 yr 4 mos</p>
                                <p class="text-1000 mb-0">Beaverton, USA</p>
                            </div>
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
                                    src="{{ asset('backend/assets/img/logos/staten.png') }}" alt=""
                                    width="56" /></a>
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
                                    src="{{ asset('backend/assets/img/logos/tj-heigh-school.png') }}" alt=""
                                    width="56" /></a>
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

    <!-- Edit Lab User Modal Start -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog mt-6 modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Lab User</h4>
                        <p class="fs-10 mb-0 text-white">Update lab user details.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="updateUser" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="edit_id" name="id">
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab7" data-bs-toggle="tab" data-wizard-step="1"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab8"
                                            data-bs-toggle="tab" data-wizard-step="2"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"
                                        data-wizard-form="1">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_name">Name</label>
                                                <input class="form-control" id="edit_name" name="edit_name"
                                                    type="text" placeholder="Enter name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_phone">Phone</label>
                                                <input class="form-control" id="edit_phone" name="edit_phone"
                                                    type="number" placeholder="Enter phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_email">Email (Optional)</label>
                                                <input class="form-control" id="edit_email" name="edit_email"
                                                    type="text" placeholder="Enter email" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_gender">Gender</label>
                                                <br>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_male" type="radio"
                                                        name="edit_gender" value="Male" />
                                                    <label class="form-check-label" for="edit_male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_female" type="radio"
                                                        name="edit_gender" value="Female" />
                                                    <label class="form-check-label" for="edit_female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_other" type="radio"
                                                        name="edit_gender" value="Other" />
                                                    <label class="form-check-label" for="edit_other">Other</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Upload Image (Optional)</label>
                                                <input class="form-control" id="edit_profile" name="edit_profile"
                                                    type="file" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Role</label>
                                                <select  class="form-select" name="edit_lab_user_role" id="edit_lab_user_role">
                                                    <option value="">-- Select --</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">Technician</option>
                                                    <option value="4">Phlebotomist</option>
                                                    <option value="5">Doctor</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab8" id="bootstrap-wizard-tab8"
                                        data-wizard-form="2">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_address">Address</label>
                                                <input class="form-control" id="edit_address" name="edit_address"
                                                    type="text" placeholder="Enter address" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_city">City</label>
                                                <input class="form-control" id="edit_city" name="edit_city"
                                                    type="text" placeholder="Enter city" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_state">State</label>
                                                <input class="form-control" id="edit_state" name="edit_state"
                                                    type="text" placeholder="Enter state" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_country">Country</label>
                                                <input class="form-control" id="edit_country" name="edit_country"
                                                    type="text" placeholder="Enter country" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_pin">Pin/Postal code</label>
                                                <input class="form-control" id="edit_pin" name="edit_pin"
                                                    type="text" placeholder="Enter pin/postal code" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control w-75" type="password" name="edit_password"
                                                        id="edit_password" placeholder="Type or generate password." />
                                                    <button type="button" class="btn btn-success edit-generate-password"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Click to generate random password.">
                                                        <i class="fa-solid fa-key"></i>
                                                    </button>
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
    <!-- Edit Lab User Modal End -->
@endsection
@section('js')
    <script>
        // Edit
            // Open Edit Modal & Load Data
            $(document).on('click', '.edit-btn', function() {
                $('.loading').show();
                let userId = $(this).data('id');

                $.ajax({
                    url: '/lab/user/' + userId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        var user = response.user;

                        $('#edit_id').val(user.id);
                        $('#edit_name').val(user.name);
                        $('#edit_phone').val(user.phone);
                        $('#edit_email').val(user.email);
                        $('#edit_lab_user_role').val(user.lab_user_role).change();
                        if (user.user_details) {
                            let details = user.user_details; // Access first element
                            $('#edit_address').val(details.address || '');
                            $('#edit_city').val(details.city || '');
                            $('#edit_state').val(details.state || '');
                            $('#edit_country').val(details.country || '');
                            $('#edit_pin').val(details.pin || '');
                        } else {
                            // ✅ Set empty values if no user_details
                            $('#edit_address').val('');
                            $('#edit_city').val('');
                            $('#edit_state').val('');
                            $('#edit_country').val('');
                            $('#edit_pin').val('');
                        }

                        // Select Gender
                        $('input[name="edit_gender"]').prop('checked',
                            false); // Reset all gender options
                        if (user.gender) {
                            $('input[name="edit_gender"][value="' + user.gender + '"]').prop(
                                'checked', true);
                        }
                        $('#editModal').modal('show');
                        $('.loading').hide();
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
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire("Error!", "Something went wrong.", "error");
                        $('.loading').hide();
                    }
                });
            });

             // Delete 
             $(document).on('click', '.delete-btn', function() {
                let packageId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the lab user and all related data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.loading').show();

                        $.ajax({
                            url: `/user/${packageId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('.loading').hide();

                                if (response.success) {
                                    Swal.fire("Deleted!",
                                        "The lab user and related data have been deleted.",
                                        "success");
                                    fetchUsers();
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
    </script>
@endsection
