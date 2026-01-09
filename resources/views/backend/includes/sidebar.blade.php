<nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-card">



    <div class="d-flex align-items-center">

        <div class="toggle-icon-wrapper">

            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"

                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span

                        class="toggle-line"></span></span></button>

        </div><a class="navbar-brand" href="index.html">

            <div class="d-flex align-items-center py-3"><img class="me-2"

                    src="{{ asset('assets/img/logo/logo.png') }}" alt="" width="40" /><span

                    class="font-sans-serif text-primary">Ourlabz</span></div>

        </a>

    </div>

    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">

        <div class="navbar-vertical-content scrollbar">

            @php

            $role = auth()->user()->role;

            $lab_user_role = auth()->user()->lab_user_role;

            @endphp

            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                <li class="nav-item">

                    <!-- parent pages--><a class="nav-link" href="{{ route('dashboard') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-chart-pie"></span></span><span

                                class="nav-link-text ps-1">Dashboard</span></div>

                    </a>

                </li>

                <li class="nav-item"><!-- label-->

                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">

                        <div class="col-auto navbar-vertical-label">App</div>

                        <div class="col ps-0">

                            <hr class="mb-0 navbar-vertical-divider" />

                        </div>

                    </div>

                    @if ($role === 0)

                    <a class="nav-link" href="{{ route('website.coupon.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-ticket fs-9"></i></span><span

                                class="nav-link-text ps-1">Coupons</span></div>

                    </a>

                    <a class="nav-link dropdown-indicator" href="#admin-menu-packages" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="admin-menu-packages">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-cubes fs-9"></i></span><span

                                class="nav-link-text ps-1">Packages & Test</span></div>

                    </a>

                    <ul class="nav collapse" id="admin-menu-packages">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('package.category') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Category</span></div>

                            </a>

                        </li>
                        <li class="nav-item">

                            <a class="nav-link " href="{{ route('requisites') }}">

                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Requestige</span>
                                </div>
                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('tests') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Test</span></div>

                            </a>

                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('packages') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Packages</span></div>

                            </a>

                        </li>
                          <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.package.review') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Reviews</span></div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('corporate.packages') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Corporate

                                        Packages</span></div>

                            </a>

                        </li>





                    </ul>



                    <a class="nav-link dropdown-indicator" href="#admin-menu-patient" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="admin-menu-patient">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-bed-pulse fs-9"></i></span><span

                                class="nav-link-text ps-1">Patients</span></div>

                    </a>

                    <ul class="nav collapse" id="admin-menu-patient">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('patients') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Bookings</span></div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('patients') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Patients</span></div>

                            </a>

                        </li>



                    </ul>



                    <a class="nav-link dropdown-indicator" href="#admin-menu-labs" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="admin-menu-labs">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-flask-vial"></i></span><span

                                class="nav-link-text ps-1">Labs</span></div>

                    </a>

                    <ul class="nav collapse" id="admin-menu-labs">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('lab.facility') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Facility</span></div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('labs') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Labs</span></div>

                            </a>

                        </li>



                    </ul>



                    <a class="nav-link dropdown-indicator" href="#admin-menu-doctor" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="admin-menu-doctor">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-user-doctor fs-9"></i></span><span

                                class="nav-link-text ps-1">Doctors</span></div>

                    </a>

                    <ul class="nav collapse" id="admin-menu-doctor">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('doctor.faq') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Faq's</span></div>

                            </a>

                        </li>

                        <!-- <li class="nav-item">

                            <a class="nav-link" href="{{ route('doctor.reviews') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Reviews</span></div>

                            </a>

                        </li> -->

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('speciality') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Speciality</span></div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('doctors') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Doctors</span></div>

                            </a>

                        </li>

                    </ul>

                    <a class="nav-link" href="{{ route('corporates') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-building fs-9"></i></span><span

                                class="nav-link-text ps-1">Corporates</span></div>

                    </a>

                    <a class="nav-link dropdown-indicator" href="#admin-menu-notifications" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="admin-menu-notifications">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fas fa-comments"></span></span>

                            <span class="nav-link-text ps-1">Notifications</span>

                        </div>

                    </a>

                    <ul class="nav collapse" id="admin-menu-notifications">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('notifications') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Notifications</span></div>

                            </a>

                        </li>

                        @if ($role == 0)

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('notification.messages') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Nofication

                                        Messages</span>

                                </div>

                            </a>

                        </li>

                        @endif

                    </ul>

                    @endif



                    @if ($role == 0)

                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">

                        <div class="col-auto navbar-vertical-label">E-Commerce</div>

                        <div class="col ps-0">

                            <hr class="mb-0 navbar-vertical-divider" />

                        </div>

                    </div>

                    <a class="nav-link dropdown-indicator" href="#e-commerce" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="e-commerce">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-shopping-cart"></span></span><span class="nav-link-text ps-1">E

                                commerce</span>

                        </div>

                    </a>

                    <ul class="nav collapse" id="e-commerce">

                        <li class="nav-item">

                            <a class="nav-link dropdown-indicator" href="#menu-product-category" role="button"

                                data-bs-toggle="collapse" aria-expanded="false"

                                aria-controls="menu-product-category">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Category</span>

                                </div>

                            </a>

                            <ul class="nav collapse" id="menu-product-category">

                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('product.type') }}">

                                        <div class="d-flex align-items-center"><span

                                                class="nav-link-text ps-1">Type</span>

                                        </div>

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('product.category') }}">

                                        <div class="d-flex align-items-center"><span

                                                class="nav-link-text ps-1">Category</span>

                                        </div>

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('product.sub_category') }}">

                                        <div class="d-flex align-items-center"><span

                                                class="nav-link-text ps-1">Sub-Category</span>

                                        </div>

                                    </a>

                                </li>

                            </ul>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('product.attribute') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">Attributes</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('vendors') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">Vendors</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">Products</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">

                        <div class="col-auto navbar-vertical-label">Corporate Front</div>

                        <div class="col ps-0">

                            <hr class="mb-0 navbar-vertical-divider" />

                        </div>

                    </div>

                    <a class="nav-link dropdown-indicator" href="#menu-corporate-homepage" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-corporate-homepage">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">Homepage</span>

                        </div>

                    </a>

                    <ul class="nav collapse" id="menu-corporate-homepage">

                        <li class="nav-item"><a class="nav-link" href="{{ route('corporate.banner') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">Banners</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('corporate.about') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">About</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item"><a class="nav-link"

                                href="{{ route('backend.corporate.services') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">Services</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    <a class="nav-link" href="{{ route('corporate.wellness') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">Wellness Program</span></div>

                    </a>

                    <a class="nav-link" href="{{ route('corporate.doctor_consult') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">Doctor Consultation</span></div>

                    </a>

                    <a class="nav-link" href="{{ route('corporate.lab_test') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">Lab Test</span></div>

                    </a>

                    <a class="nav-link" href="{{ route('corporate.hospital_assistance') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">Hospital Assistance</span></div>

                    </a>

                    @endif

                    @if ($role === 2)

                    @php

                    $lab_user_role = auth()->user()->lab_user_role;

                    @endphp



                    <!-- Lab Admin -->

                    @if (has_permission('scheduling', 'view'))

                    <a class="nav-link" href="{{ route('scheduling') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-calendar-days fs-9"></span></span>

                            <span class="nav-link-text ps-1">Scheduling</span>

                        </div>

                    </a>

                    @endif



                    @if (has_permission('booking', 'view'))

                    <a class="nav-link dropdown-indicator" href="#menu-patient" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-patient">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-bed-pulse fs-9"></i></span><span

                                class="nav-link-text ps-1">Bookings</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-patient">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('patient.bookings') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">New</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('patient.bookings.completed') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Completed</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    @endif



                    @if (has_permission('refering', 'view'))

                    <a class="nav-link dropdown-indicator" href="#menu-refering-lab" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-refering-lab">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-flask-vial"></i></span><span

                                class="nav-link-text ps-1">Refering</span></div>

                    </a>



                    <ul class="nav collapse" id="menu-refering-lab">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('refering-labs') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Labs</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('refering-tests') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Tests</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    @endif



                    @php

                    $hasReportPermissions =

                    has_permission('report-layout', 'view') ||

                    has_permission('all-reports', 'view') ||

                    $lab_user_role == 5;

                    @endphp

                    @if ($lab_user_role == 5)

                    <a class="nav-link dropdown-indicator" href="#menu-lab-free-consult" role="button"

                        data-bs-toggle="collapse" aria-expanded="false"

                        aria-controls="menu-lab-free-consult">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-stethoscope fs-9"></i></span><span

                                class="nav-link-text ps-1">Free Consultations</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-lab-free-consult">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('free-conult.booking') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Pending</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('free-conult.booking.completed') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Completed</span>

                                </div>

                            </a>

                        </li>



                    </ul>

                    @endif

                    @if ($hasReportPermissions)

                    <a class="nav-link dropdown-indicator" href="#menu-report" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-report">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-file-lines fs-9"></i></span><span

                                class="nav-link-text ps-1">Reports</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-report">

                        @if (has_permission('report-layout', 'view'))

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('report.layout') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Layout</span>

                                </div>

                            </a>

                        </li>

                        @endif

                        @if (has_permission('all-reports', 'view'))

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('lab.all.report') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">All

                                        Reports</span>

                                </div>

                            </a>

                        </li>

                        @endif

                        @if ($lab_user_role == 5)

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('report.signature.layout') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Signature</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('report.verify_certify') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Verify/Certify

                                        <small>(Pending)</small></span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('report.verify_certify_completed') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Verify/Certify

                                        <small>(Completed)</small></span>

                                </div>

                            </a>

                        </li>

                        @endif

                    </ul>

                    @endif



                    @if (has_permission('manage', 'view'))

                    <a class="nav-link dropdown-indicator" href="#menu-manage" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-manage">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-users fs-9"></i></span><span

                                class="nav-link-text ps-1">Manage</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-manage">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('manage.staff') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Staff</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    @endif



                    @if ($lab_user_role == 4)

                    <!-- Lab Phlebotomist -->

                    <a class="nav-link dropdown-indicator" href="#menu-sample-collection" role="button"

                        data-bs-toggle="collapse" aria-expanded="false"

                        aria-controls="menu-sample-collection">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-vial fs-9"></i></span><span

                                class="nav-link-text ps-1">Sample Collection</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-sample-collection">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('samplecollection.index') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Pending</span>

                                </div>

                            </a>

                            <a class="nav-link" href="{{ route('samplecollection.completed') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Completed</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    @endif



                    @if (has_permission('website', 'view'))

                    <a class="nav-link dropdown-indicator" href="#menu-website" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-website">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-globe"></span></span><span

                                class="nav-link-text ps-1">Website</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-website">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('lab.sliders') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Slider</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('lab.gallery') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Gallery</span>

                                </div>

                            </a>

                        </li>

                        @php

                        $auth = auth()->user();

                        $lab = \App\Models\lab::where('lab_id', $auth->lab_id)->first();

                        @endphp

                        <li class="nav-item">

                            <a class="nav-link"

                                href="{{ route('lab-profile', [\Illuminate\Support\Str::slug($lab->lab_name), encrypt($auth->lab_id)]) }}"

                                target="_blank">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Link</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    @endif



                    @if (has_permission('reviews', 'view'))

                    <a class="nav-link" href="{{ route('lab.reviews') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-comment-dots fs-9"></i></span><span

                                class="nav-link-text ps-1">Reviews</span></div>

                    </a>

                    @endif



                    <a class="nav-link" href="{{ route('notifications') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fas fa-comments"></span></span>

                            <span class="nav-link-text ps-1">Notifications</span>

                        </div>

                    </a>



                    <a class="nav-link" href="{{ route('sign.agreements.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></i></span><span

                                class="nav-link-text ps-1">Sign Agreements</span>

                        </div>

                    </a>



                    @endif

                    @if ($role == 3)

                    <a class="nav-link" href="{{ route('scheduling') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-calendar-days fs-9"></span></span>

                            <span class="nav-link-text ps-1">Scheduling</span>

                        </div>

                    </a>



                    <a class="nav-link dropdown-indicator" href="#menu-doctor-bookings" role="button"

                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="menu-doctor-bookings">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-bed-pulse fs-9"></i></span><span

                                class="nav-link-text ps-1">Bookings</span></div>

                    </a>

                    <ul class="nav collapse" id="menu-doctor-bookings">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('doctor.bookings.view') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">New</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('doctor.bookings.completed') }}">

                                <div class="d-flex align-items-center">

                                    <span class="nav-link-text ps-1">Completed</span>

                                </div>

                            </a>

                        </li>

                    </ul>



                    <a class="nav-link" href="{{ route('doctor.referring_docotor.list') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-user-doctor fs-9"></span></span>

                            <span class="nav-link-text ps-1">Referring Doctor</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('doctor.reviews') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-message fs-9"></span></span>

                            <span class="nav-link-text ps-1">Reviews</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('notifications') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fas fa-comments"></span></span>

                            <span class="nav-link-text ps-1">Notifications</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('sign.agreements.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></i></span><span

                                class="nav-link-text ps-1">Sign Agreements</span>

                        </div>

                    </a>

                    @endif

                    @if ($role == 4)

                    <a class="nav-link" href="{{ route('corporate.employee.list') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-users fs-9"></span></span>

                            <span class="nav-link-text ps-1">Employees</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('corporate.wallet.index') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-wallet fs-9"></span></span>

                            <span class="nav-link-text ps-1">Wallet</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('corporate.index.package') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-box-open fs-9"></span></span>

                            <span class="nav-link-text ps-1">Packages</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('corporate.payments') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><span class="fa fa-indian-rupee fs-9"></span></span>

                            <span class="nav-link-text ps-1">Payments</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('sign.agreements.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></i></span><span

                                class="nav-link-text ps-1">Sign Agreements</span>

                        </div>

                    </a>

                    @endif

                    @if ($role == 5)

                    <a class="nav-link" href="{{ route('vendor.orders') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon">

                                <i class="fa-solid fa-box-open"></i>

                            </span>

                            <span class="nav-link-text ps-1">Orders</span>

                        </div>

                    </a>



                    <a class="nav-link" href="{{ route('product.reviews') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon">

                                <span class="fa fa-message"></span>

                            </span>

                            <span class="nav-link-text ps-1">Reviews</span>

                        </div>

                    </a>



                    <a class="nav-link" href="{{ route('products') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon">

                                <i class="fa-brands fa-product-hunt fs-9"></i>

                            </span>

                            <span class="nav-link-text ps-1">Products</span>

                        </div>

                    </a>



                    <a class="nav-link" href="{{ route('notifications') }}">

                        <div class="d-flex align-items-center">

                            <span class="nav-link-icon"><i class="fa fa-comments fs-9"></i></span>

                            <span class="nav-link-text ps-1">Notifications</span>

                        </div>

                    </a>

                    <a class="nav-link" href="{{ route('sign.agreements.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></i></span><span

                                class="nav-link-text ps-1">Sign Agreements</span>

                        </div>

                    </a>

                    @endif



                </li>

                @if ($role == 0)

                <li class="nav-item"><!-- label-->

                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">

                        <div class="col-auto navbar-vertical-label">Website Front</div>

                        <div class="col ps-0">

                            <hr class="mb-0 navbar-vertical-divider" />

                        </div>

                    </div>

                    <a class="nav-link dropdown-indicator" href="#homepage" data-bs-toggle="collapse"

                        aria-expanded="false" aria-controls="authentication">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></i></span><span

                                class="nav-link-text ps-1">Homepage</span>

                        </div>

                    </a><!-- more inner pages-->

                    <ul class="nav collapse" id="homepage">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.banner') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Banner</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.home.offer') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Offers</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.home.feature') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Features</span></div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.home.brands') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">

                                        Brands

                                    </span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.home.testimonials') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Testimonial</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.home.videos') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Videos</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    <a class="nav-link dropdown-indicator" href="#web-about-menu" data-bs-toggle="collapse"

                        aria-expanded="false" aria-controls="authentication">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">About</span>

                        </div>

                    </a><!-- more inner pages-->

                    <ul class="nav collapse" id="web-about-menu">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.about.index') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">About</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.team.index') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Teams</span>
                                </div>

                            </a>

                        </li>

                    </ul>



                    <a class="nav-link dropdown-indicator" href="#blog-menu" data-bs-toggle="collapse"

                        aria-expanded="false" aria-controls="authentication">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></span><span

                                class="nav-link-text ps-1">Blog</span>

                        </div>

                    </a><!-- more inner pages-->

                    <ul class="nav collapse" id="blog-menu">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.blog.comments') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Comments</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.blogs') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All

                                        Blogs</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    <a class="nav-link dropdown-indicator" href="#contact-menu" data-bs-toggle="collapse"

                        aria-expanded="false" aria-controls="authentication">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-address-card fs-9"></span></span><span

                                class="nav-link-text ps-1">Contact</span>

                        </div>

                    </a><!-- more inner pages-->

                    <ul class="nav collapse" id="contact-menu">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.contact.index') }}">

                                <div class="d-flex align-items-center"><span

                                        class="nav-link-text ps-1">Contact Us</span>

                                </div>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.contact.enquiry.index') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Enquiries</span>

                                </div>

                            </a>

                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('website.newsletter.index') }}">

                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Newsletters</span>

                                </div>

                            </a>

                        </li>

                    </ul>

                    <a class="nav-link" href="{{ route('website.faq.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-question fs-9"></i></span><span

                                class="nav-link-text ps-1">Faq's</span></div>

                    </a>

                </li>

                <li class="nav-item"><!-- label-->

                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">

                        <div class="col-auto navbar-vertical-label">Agreements</div>

                        <div class="col ps-0">

                            <hr class="mb-0 navbar-vertical-divider" />

                        </div>

                    </div>

                    <a class="nav-link" href="{{ route('agreements.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span

                                    class="fas fa-file-lines fs-9"></span></i></span><span

                                class="nav-link-text ps-1">Agreements</span>

                        </div>

                    </a>

                     <a class="nav-link" href="{{ route('website.policy.index') }}">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><i

                                    class="fa-solid fa-file-lines fs-9"></i></span><span

                                class="nav-link-text ps-1">Policy Pages</span></div>

                    </a>

                </li>

                @endif

            </ul>

        </div>

    </div>

</nav>