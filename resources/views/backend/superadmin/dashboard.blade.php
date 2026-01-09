@extends('backend.includes.layout')
@section('css')
    <style>
        /* Floating circles for subtle movement */
        .circle-shape {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        /* Floating animation for images */
        .floating-img {
            animation: floatImg 4s ease-in-out infinite;
        }

        /* Keyframes for floating motion */
        @keyframes float {
            0% {
                transform: translateY(0);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-10px);
                opacity: 0.4;
            }

            100% {
                transform: translateY(0);
                opacity: 0.3;
            }
        }

        @keyframes floatImg {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }

            100% {
                transform: translateY(0);
            }
        }

        /* Gradient text */
        .text-gradient {
            background: linear-gradient(90deg, #2c7be5, #00b8d9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
@endsection
@section('content')

<div class="row g-3 mb-3">

    {{-- USERS --}}
    <div class="col-md-3 col-xxl-3 ">
        <div class="card h-md-100 ecommerce-card-min-width bg-primary bg-gradient text-white">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center text-white">
                    Ourlabz Users
                    <span class="ms-1" data-bs-toggle="tooltip" title="Last 7 days user registrations">
                        <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                    </span>
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-5">{{ $totalUsers }}</p>
                        <span class="badge {{ $userGrowth >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' }} rounded-pill fs-11">
                            {{ $userGrowth >= 0 ? '+' : '' }}{{ number_format($userGrowth, 1) }}%
                        </span>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="echart-bar" id="chart-users" style="width:130px;height:90px;"
                            data-labels='@json(collect($weeklyUserData)->pluck("day"))'
                            data-values='@json(collect($weeklyUserData)->pluck("count"))'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-xxl-9">
        <div class="card h-md-100 border-0 shadow-sm overflow-hidden position-relative">
            <div class="card-body position-relative">
                <div class="row align-items-center">
                    <!-- Left: Animated Illustration -->
                    <div class="col-md-4 d-flex justify-content-center mb-3 mb-md-0">
                        <img src="{{ asset('backend/assets/img/illustrations/healthcare-animation.jpg') }}"
                            alt="Healthcare Illustration" class="img-fluid rounded-3 floating-img"
                            style="max-height: 160px;">
                    </div>

                    <!-- Right: Text Content -->
                    <div class="col-md-8 text-md-start text-center">
                        <h4 class="fw-bold text-primary mb-2 animate__animated animate__fadeInDown">
                            👋 Welcome to <span class="text-gradient">OurLabz | {{auth()->user()->name}}</span>
                        </h4>
                        <p class="text-700 mb-2 animate__animated animate__fadeInUp" style="font-size: 0.95rem;">
                            OurLabz is a next-generation <strong>digital healthcare platform</strong>, seamlessly integrating
                            diagnostics, medical services, devices, and health management.
                        </p>
                        <p class="text-700 mb-0 animate__animated animate__fadeInUp animate__delay-1s" style="font-size: 0.95rem;">
                            We empower <strong>individuals, corporates,</strong> and <strong>healthcare providers</strong> with
                            accessible, affordable, and innovative healthcare solutions.
                        </p>
                    </div>
                </div>

                <!-- Floating Decorative Elements -->
                <div class="circle-shape position-absolute top-0 start-0 translate-middle bg-primary opacity-25"></div>
                <div class="circle-shape position-absolute bottom-0 end-0 translate-middle bg-info opacity-25"></div>
            </div>
        </div>
    </div>

    {{-- LABS --}}
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 ecommerce-card-min-width bg-warning bg-gradient text-white">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center text-white">
                    Labs
                    <span class="ms-1" data-bs-toggle="tooltip" title="Last 7 days lab registrations">
                        <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                    </span>
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-5">{{ $totalLabs }}</p>
                        <span class="badge {{ $labGrowth >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' }} rounded-pill fs-11">
                            {{ $labGrowth >= 0 ? '+' : '' }}{{ number_format($labGrowth, 1) }}%
                        </span>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="echart-bar" id="chart-labs" style="width:130px;height:90px;"
                            data-labels='@json(collect($weeklyLabData)->pluck("day"))'
                            data-values='@json(collect($weeklyLabData)->pluck("count"))'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DOCTORS --}}
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 ecommerce-card-min-width bg-success bg-gradient text-white">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center text-white">
                    Doctors
                    <span class="ms-1" data-bs-toggle="tooltip" title="Last 7 days doctor registrations">
                        <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                    </span>
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-5">{{ $totalDoctors }}</p>
                        <span class="badge {{ $doctorGrowth >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' }} rounded-pill fs-11">
                            {{ $doctorGrowth >= 0 ? '+' : '' }}{{ number_format($doctorGrowth, 1) }}%
                        </span>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="echart-bar" id="chart-doctors" style="width:130px;height:90px;"
                            data-labels='@json(collect($weeklyDoctorData)->pluck("day"))'
                            data-values='@json(collect($weeklyDoctorData)->pluck("count"))'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CORPORATES --}}
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 ecommerce-card-min-width bg-info bg-gradient text-white">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center text-white">
                    Corporates
                    <span class="ms-1" data-bs-toggle="tooltip" title="Last 7 days corporate registrations">
                        <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                    </span>
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-5">{{ $totalCorporates }}</p>
                        <span class="badge {{ $corporateGrowth >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' }} rounded-pill fs-11">
                            {{ $corporateGrowth >= 0 ? '+' : '' }}{{ number_format($corporateGrowth, 1) }}%
                        </span>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="echart-bar" id="chart-corporates" style="width:130px;height:90px;"
                            data-labels='@json(collect($weeklyCorporateData)->pluck("day"))'
                            data-values='@json(collect($weeklyCorporateData)->pluck("count"))'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VENDORS --}}
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 ecommerce-card-min-width bg-danger bg-gradient text-white">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center text-white">
                    Vendors
                    <span class="ms-1" data-bs-toggle="tooltip" title="Last 7 days vendor registrations">
                        <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                    </span>
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-5">{{ $totalVendors }}</p>
                        <span class="badge {{ $vendorGrowth >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' }} rounded-pill fs-11">
                            {{ $vendorGrowth >= 0 ? '+' : '' }}{{ number_format($vendorGrowth, 1) }}%
                        </span>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="echart-bar" id="chart-vendors" style="width:130px;height:90px;"
                            data-labels='@json(collect($weeklyVendorData)->pluck("day"))'
                            data-values='@json(collect($weeklyVendorData)->pluck("count"))'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-0">

    <div class="col-lg-6 pe-lg-2 mb-3">

        <div class="card h-lg-100 overflow-hidden">

            <div class="card-header bg-body-tertiary">

                <div class="row align-items-center">

                    <div class="col">

                        <h6 class="mb-0">Running Projects</h6>

                    </div>

                    <div class="col-auto text-center pe-x1"><select

                            class="form-select form-select-sm">

                            <option>Working Time</option>

                            <option>Estimated Time</option>

                            <option>Billable Time</option>

                        </select></div>

                </div>

            </div>

            <div class="card-body p-0">

                <div

                    class="row g-0 align-items-center py-2 position-relative border-bottom border-200">

                    <div class="col ps-x1 py-1 position-static">

                        <div class="d-flex align-items-center">

                            <div class="avatar avatar-xl me-3">

                                <div class="avatar-name rounded-circle bg-primary-subtle text-dark">

                                    <span class="fs-9 text-primary">F</span>
                                </div>

                            </div>

                            <div class="flex-1">

                                <h6 class="mb-0 d-flex align-items-center"><a

                                        class="text-800 stretched-link"

                                        href="#!">Falcon</a><span

                                        class="badge rounded-pill ms-2 bg-200 text-primary">38%</span>

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="col py-1">

                        <div class="row flex-end-center g-0">

                            <div class="col-auto pe-2">

                                <div class="fs-10 fw-semi-bold">12:50:00</div>

                            </div>

                            <div class="col-5 pe-x1 ps-2">

                                <div class="progress bg-200 me-2" style="height: 5px;"

                                    role="progressbar" aria-valuenow="38" aria-valuemin="0"

                                    aria-valuemax="100">

                                    <div class="progress-bar rounded-pill" style="width: 38%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div

                    class="row g-0 align-items-center py-2 position-relative border-bottom border-200">

                    <div class="col ps-x1 py-1 position-static">

                        <div class="d-flex align-items-center">

                            <div class="avatar avatar-xl me-3">

                                <div class="avatar-name rounded-circle bg-success-subtle text-dark">

                                    <span class="fs-9 text-success">R</span>
                                </div>

                            </div>

                            <div class="flex-1">

                                <h6 class="mb-0 d-flex align-items-center"><a

                                        class="text-800 stretched-link"

                                        href="#!">Reign</a><span

                                        class="badge rounded-pill ms-2 bg-200 text-primary">79%</span>

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="col py-1">

                        <div class="row flex-end-center g-0">

                            <div class="col-auto pe-2">

                                <div class="fs-10 fw-semi-bold">25:20:00</div>

                            </div>

                            <div class="col-5 pe-x1 ps-2">

                                <div class="progress bg-200 me-2" style="height: 5px;"

                                    role="progressbar" aria-valuenow="79" aria-valuemin="0"

                                    aria-valuemax="100">

                                    <div class="progress-bar rounded-pill" style="width: 79%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div

                    class="row g-0 align-items-center py-2 position-relative border-bottom border-200">

                    <div class="col ps-x1 py-1 position-static">

                        <div class="d-flex align-items-center">

                            <div class="avatar avatar-xl me-3">

                                <div class="avatar-name rounded-circle bg-info-subtle text-dark"><span

                                        class="fs-9 text-info">B</span></div>

                            </div>

                            <div class="flex-1">

                                <h6 class="mb-0 d-flex align-items-center"><a

                                        class="text-800 stretched-link"

                                        href="#!">Boots4</a><span

                                        class="badge rounded-pill ms-2 bg-200 text-primary">90%</span>

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="col py-1">

                        <div class="row flex-end-center g-0">

                            <div class="col-auto pe-2">

                                <div class="fs-10 fw-semi-bold">58:20:00</div>

                            </div>

                            <div class="col-5 pe-x1 ps-2">

                                <div class="progress bg-200 me-2" style="height: 5px;"

                                    role="progressbar" aria-valuenow="90" aria-valuemin="0"

                                    aria-valuemax="100">

                                    <div class="progress-bar rounded-pill" style="width: 90%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div

                    class="row g-0 align-items-center py-2 position-relative border-bottom border-200">

                    <div class="col ps-x1 py-1 position-static">

                        <div class="d-flex align-items-center">

                            <div class="avatar avatar-xl me-3">

                                <div class="avatar-name rounded-circle bg-warning-subtle text-dark">

                                    <span class="fs-9 text-warning">R</span>
                                </div>

                            </div>

                            <div class="flex-1">

                                <h6 class="mb-0 d-flex align-items-center"><a

                                        class="text-800 stretched-link"

                                        href="#!">Raven</a><span

                                        class="badge rounded-pill ms-2 bg-200 text-primary">40%</span>

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="col py-1">

                        <div class="row flex-end-center g-0">

                            <div class="col-auto pe-2">

                                <div class="fs-10 fw-semi-bold">21:20:00</div>

                            </div>

                            <div class="col-5 pe-x1 ps-2">

                                <div class="progress bg-200 me-2" style="height: 5px;"

                                    role="progressbar" aria-valuenow="40" aria-valuemin="0"

                                    aria-valuemax="100">

                                    <div class="progress-bar rounded-pill" style="width: 40%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row g-0 align-items-center py-2 position-relative">

                    <div class="col ps-x1 py-1 position-static">

                        <div class="d-flex align-items-center">

                            <div class="avatar avatar-xl me-3">

                                <div class="avatar-name rounded-circle bg-danger-subtle text-dark">

                                    <span class="fs-9 text-danger">S</span>
                                </div>

                            </div>

                            <div class="flex-1">

                                <h6 class="mb-0 d-flex align-items-center"><a

                                        class="text-800 stretched-link"

                                        href="#!">Slick</a><span

                                        class="badge rounded-pill ms-2 bg-200 text-primary">70%</span>

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="col py-1">

                        <div class="row flex-end-center g-0">

                            <div class="col-auto pe-2">

                                <div class="fs-10 fw-semi-bold">31:20:00</div>

                            </div>

                            <div class="col-5 pe-x1 ps-2">

                                <div class="progress bg-200 me-2" style="height: 5px;"

                                    role="progressbar" aria-valuenow="70" aria-valuemin="0"

                                    aria-valuemax="100">

                                    <div class="progress-bar rounded-pill" style="width: 70%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-body-tertiary p-0"><a

                    class="btn btn-sm btn-link d-block w-100 py-2" href="#!">Show all

                    projects<span class="fas fa-chevron-right ms-1 fs-11"></span></a></div>

        </div>

    </div>

    <div class="col-lg-6 ps-lg-2 mb-3">

        <div class="card h-lg-100">

            <div class="card-header">

                <div class="row flex-between-center">

                    <div class="col-auto">

                        <h6 class="mb-0">Total Sales</h6>

                    </div>

                    <div class="col-auto d-flex"><select

                            class="form-select form-select-sm select-month me-2">

                            <option value="0">January</option>

                            <option value="1">February</option>

                            <option value="2">March</option>

                            <option value="3">April</option>

                            <option value="4">May</option>

                            <option value="5">Jun</option>

                            <option value="6">July</option>

                            <option value="7">August</option>

                            <option value="8">September</option>

                            <option value="9">October</option>

                            <option value="10">November</option>

                            <option value="11">December</option>

                        </select>

                        <div class="dropdown font-sans-serif btn-reveal-trigger"><button

                                class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"

                                type="button" id="dropdown-total-sales" data-bs-toggle="dropdown"

                                data-boundary="viewport" aria-haspopup="true"

                                aria-expanded="false"><span

                                    class="fas fa-ellipsis-h fs-11"></span></button>

                            <div class="dropdown-menu dropdown-menu-end border py-2"

                                aria-labelledby="dropdown-total-sales"><a class="dropdown-item"

                                    href="#!">View</a><a class="dropdown-item"

                                    href="#!">Export</a>

                                <div class="dropdown-divider"></div><a

                                    class="dropdown-item text-danger" href="#!">Remove</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body h-100 pe-0">

                <!-- Find the JS file for the following chart at: src\js\charts\echarts\total-sales.js--><!-- If you are not using gulp based workflow, you can find the transpiled code at: public\assets\js\theme.js-->

                <div class="echart-line-total-sales h-100" data-echart-responsive="true"></div>

            </div>

        </div>

    </div>

</div>

<div class="row g-0">

    <div class="col-lg-6 col-xl-7 col-xxl-8 mb-3 pe-lg-2 mb-3">

        <div class="card h-lg-100">

            <div class="card-body d-flex align-items-center">

                <div class="w-100">

                    <h6 class="mb-3 text-800">Using Storage <strong class="text-1100">1775.06 MB

                        </strong>of 2 GB</h6>

                    <div class="progress-stacked mb-3 rounded-3" style="height: 10px;">

                        <div class="progress" style="width: 43.72%;" role="progressbar"

                            aria-valuenow="43.72" aria-valuemin="0" aria-valuemax="100">

                            <div

                                class="progress-bar bg-progress-gradient border-end border-100 border-2">

                            </div>

                        </div>

                        <div class="progress" style="width: 18.76%;" role="progressbar"

                            aria-valuenow="18.76" aria-valuemin="0" aria-valuemax="100">

                            <div class="progress-bar bg-info border-end border-100 border-2"></div>

                        </div>

                        <div class="progress" style="width: 9.38%;" role="progressbar"

                            aria-valuenow="9.38" aria-valuemin="0" aria-valuemax="100">

                            <div class="progress-bar bg-success border-end border-100 border-2"></div>

                        </div>

                        <div class="progress" style="width: 28.14%;" role="progressbar"

                            aria-valuenow="28.14" aria-valuemin="0" aria-valuemax="100">

                            <div class="progress-bar bg-200"></div>

                        </div>

                    </div>

                    <div class="row fs-10 fw-semi-bold text-500 g-0">

                        <div class="col-auto d-flex align-items-center pe-3"><span

                                class="dot bg-primary"></span><span>Regular</span><span

                                class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(895MB)</span>

                        </div>

                        <div class="col-auto d-flex align-items-center pe-3"><span

                                class="dot bg-info"></span><span>System</span><span

                                class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(379MB)</span>

                        </div>

                        <div class="col-auto d-flex align-items-center pe-3"><span

                                class="dot bg-success"></span><span>Shared</span><span

                                class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(192MB)</span>

                        </div>

                        <div class="col-auto d-flex align-items-center"><span

                                class="dot bg-200"></span><span>Free</span><span

                                class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(576MB)</span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-6 col-xl-5 col-xxl-4 mb-3 ps-lg-2">

        <div class="card h-lg-100">

            <div class="bg-holder bg-card"

                style="background-image:url({{asset('backend/assets/img/icons/spot-illustrations/corner-1.png')}});"></div>

            <!--/.bg-holder-->

            <div class="card-body position-relative">

                <h5 class="text-warning">Running out of your space?</h5>

                <p class="fs-10 mb-0">Your storage will be running out soon. Get more space and

                    powerful productivity

                    features.</p><a class="btn btn-link fs-10 text-warning mt-lg-3 ps-0"

                    href="#!">Upgrade storage<span class="fas fa-chevron-right ms-1"

                        data-fa-transform="shrink-4 down-1"></span></a>

            </div>

        </div>

    </div>

</div>

<div class="row g-0">

    <div class="col-lg-7 col-xl-8 pe-lg-2 mb-3">

        <div class="card h-lg-100 overflow-hidden">

            <div class="card-body p-0">

                <div class="table-responsive scrollbar">

                    <table class="table table-dashboard mb-0 table-borderless fs-10 border-200">

                        <thead class="bg-body-tertiary">

                            <tr>

                                <th class="text-900">Best Selling Products</th>

                                <th class="text-900 text-end">Revenue ($3333)</th>

                                <th class="text-900 pe-x1 text-end" style="width: 8rem">Revenue (%)

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr class="border-bottom border-200">

                                <td>

                                    <div class="d-flex align-items-center position-relative"><img

                                            class="rounded-1 border border-200"

                                            src="{{asset('backend/assets/img/products/12.png')}}" width="60"

                                            alt="" />

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-1 fw-semi-bold"><a

                                                    class="text-1100 stretched-link"

                                                    href="#!">Raven Pro</a>

                                            </h6>

                                            <p class="fw-semi-bold mb-0 text-500">Landing</p>

                                        </div>

                                    </div>

                                </td>

                                <td class="align-middle text-end fw-semi-bold">$1311</td>

                                <td class="align-middle pe-x1">

                                    <div class="d-flex align-items-center">

                                        <div class="progress me-3 rounded-3 bg-200"

                                            style="height: 5px; width:80px;" role="progressbar"

                                            aria-valuenow="39" aria-valuemin="0"

                                            aria-valuemax="100">

                                            <div class="progress-bar rounded-pill"

                                                style="width: 39%;"></div>

                                        </div>

                                        <div class="fw-semi-bold ms-2">39%</div>

                                    </div>

                                </td>

                            </tr>

                            <tr class="border-bottom border-200">

                                <td>

                                    <div class="d-flex align-items-center position-relative"><img

                                            class="rounded-1 border border-200"

                                            src="{{asset('backend/assets/img/products/10.png')}}" width="60"

                                            alt="" />

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-1 fw-semi-bold"><a

                                                    class="text-1100 stretched-link"

                                                    href="#!">Boots4</a>

                                            </h6>

                                            <p class="fw-semi-bold mb-0 text-500">Portfolio</p>

                                        </div>

                                    </div>

                                </td>

                                <td class="align-middle text-end fw-semi-bold">$860</td>

                                <td class="align-middle pe-x1">

                                    <div class="d-flex align-items-center">

                                        <div class="progress me-3 rounded-3 bg-200"

                                            style="height: 5px; width:80px;" role="progressbar"

                                            aria-valuenow="26" aria-valuemin="0"

                                            aria-valuemax="100">

                                            <div class="progress-bar rounded-pill"

                                                style="width: 26%;"></div>

                                        </div>

                                        <div class="fw-semi-bold ms-2">26%</div>

                                    </div>

                                </td>

                            </tr>

                            <tr class="border-bottom border-200">

                                <td>

                                    <div class="d-flex align-items-center position-relative"><img

                                            class="rounded-1 border border-200"

                                            src="{{asset('backend/assets/img/products/11.png')}}" width="60"

                                            alt="" />

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-1 fw-semi-bold"><a

                                                    class="text-1100 stretched-link"

                                                    href="#!">Falcon</a>

                                            </h6>

                                            <p class="fw-semi-bold mb-0 text-500">Admin</p>

                                        </div>

                                    </div>

                                </td>

                                <td class="align-middle text-end fw-semi-bold">$539</td>

                                <td class="align-middle pe-x1">

                                    <div class="d-flex align-items-center">

                                        <div class="progress me-3 rounded-3 bg-200"

                                            style="height: 5px; width:80px;" role="progressbar"

                                            aria-valuenow="16" aria-valuemin="0"

                                            aria-valuemax="100">

                                            <div class="progress-bar rounded-pill"

                                                style="width: 16%;"></div>

                                        </div>

                                        <div class="fw-semi-bold ms-2">16%</div>

                                    </div>

                                </td>

                            </tr>

                            <tr class="border-bottom border-200">

                                <td>

                                    <div class="d-flex align-items-center position-relative"><img

                                            class="rounded-1 border border-200"

                                            src="{{asset('backend/assets/img/products/14.png')}}" width="60"

                                            alt="" />

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-1 fw-semi-bold"><a

                                                    class="text-1100 stretched-link"

                                                    href="#!">Slick</a></h6>

                                            <p class="fw-semi-bold mb-0 text-500">Builder</p>

                                        </div>

                                    </div>

                                </td>

                                <td class="align-middle text-end fw-semi-bold">$343</td>

                                <td class="align-middle pe-x1">

                                    <div class="d-flex align-items-center">

                                        <div class="progress me-3 rounded-3 bg-200"

                                            style="height: 5px; width:80px;" role="progressbar"

                                            aria-valuenow="10" aria-valuemin="0"

                                            aria-valuemax="100">

                                            <div class="progress-bar rounded-pill"

                                                style="width: 10%;"></div>

                                        </div>

                                        <div class="fw-semi-bold ms-2">10%</div>

                                    </div>

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    <div class="d-flex align-items-center position-relative"><img

                                            class="rounded-1 border border-200"

                                            src="{{asset('backend/assets/img/products/13.png')}}" width="60"

                                            alt="" />

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-1 fw-semi-bold"><a

                                                    class="text-1100 stretched-link"

                                                    href="#!">Reign Pro</a>

                                            </h6>

                                            <p class="fw-semi-bold mb-0 text-500">Agency</p>

                                        </div>

                                    </div>

                                </td>

                                <td class="align-middle text-end fw-semi-bold">$280</td>

                                <td class="align-middle pe-x1">

                                    <div class="d-flex align-items-center">

                                        <div class="progress me-3 rounded-3 bg-200"

                                            style="height: 5px; width:80px;" role="progressbar"

                                            aria-valuenow="8" aria-valuemin="0"

                                            aria-valuemax="100">

                                            <div class="progress-bar rounded-pill"

                                                style="width: 8%;"></div>

                                        </div>

                                        <div class="fw-semi-bold ms-2">8%</div>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer bg-body-tertiary py-2">

                <div class="row flex-between-center">

                    <div class="col-auto"><select class="form-select form-select-sm">

                            <option>Last 7 days</option>

                            <option>Last Month</option>

                            <option>Last Year</option>

                        </select></div>

                    <div class="col-auto"><a class="btn btn-sm btn-falcon-default"

                            href="#!">View All</a></div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-5 col-xl-4 ps-lg-2 mb-3">

        <div class="card h-100">

            <div class="card-header d-flex flex-between-center bg-body-tertiary py-2">

                <h6 class="mb-0">Shared Files</h6><a class="py-1 fs-10 font-sans-serif"

                    href="#!">View All</a>

            </div>

            <div class="card-body pb-0">

                <div class="d-flex mb-3 hover-actions-trigger align-items-center">

                    <div class="file-thumbnail"><img

                            class="border h-100 w-100 object-fit-cover rounded-2"

                            src="{{asset('backend/assets/img/products/5-thumb.png')}}" alt="" /></div>

                    <div class="ms-3 flex-shrink-1 flex-grow-1">

                        <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"

                                href="#!">apple-smart-watch.png</a>

                        </h6>

                        <div class="fs-10"><span class="fw-semi-bold">Antony</span><span

                                class="fw-medium text-600 ms-2">Just Now</span></div>

                        <div class="hover-actions end-0 top-50 translate-middle-y"><a

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600"

                                data-bs-toggle="tooltip" data-bs-placement="top" title="Download"

                                href="assets/img/icons/cloud-download.svg" download="download"><img

                                    src="{{asset('backend/assets/img/icons/cloud-download.svg')}}" alt=""

                                    width="15" /></a><button

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600 shadow-none"

                                type="button" data-bs-toggle="tooltip" data-bs-placement="top"

                                title="Edit"><img src="{{asset('backend/assets/img/icons/edit-alt.svg')}}"

                                    alt="" width="15" /></button></div>

                    </div>

                </div>

                <hr class="text-200" />

                <div class="d-flex mb-3 hover-actions-trigger align-items-center">

                    <div class="file-thumbnail"><img

                            class="border h-100 w-100 object-fit-cover rounded-2"

                            src="{{asset('backend/assets/img/products/3-thumb.png')}}" alt="" /></div>

                    <div class="ms-3 flex-shrink-1 flex-grow-1">

                        <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"

                                href="#!">iphone.jpg</a></h6>

                        <div class="fs-10"><span class="fw-semi-bold">Antony</span><span

                                class="fw-medium text-600 ms-2">Yesterday at 1:30 PM</span></div>

                        <div class="hover-actions end-0 top-50 translate-middle-y"><a

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600"

                                data-bs-toggle="tooltip" data-bs-placement="top" title="Download"

                                href="assets/img/icons/cloud-download.svg" download="download"><img

                                    src="{{asset('backend/assets/img/icons/cloud-download.svg')}}" alt=""

                                    width="15" /></a><button

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600 shadow-none"

                                type="button" data-bs-toggle="tooltip" data-bs-placement="top"

                                title="Edit"><img src="{{asset('backend/assets/img/icons/edit-alt.svg')}}"

                                    alt="" width="15" /></button></div>

                    </div>

                </div>

                <hr class="text-200" />

                <div class="d-flex mb-3 hover-actions-trigger align-items-center">

                    <div class="file-thumbnail"><img class="img-fluid"

                            src="{{asset('backend/assets/img/icons/zip.png')}}" alt="" /></div>

                    <div class="ms-3 flex-shrink-1 flex-grow-1">

                        <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"

                                href="#!">Falcon v1.8.2</a></h6>

                        <div class="fs-10"><span class="fw-semi-bold">Jane</span><span

                                class="fw-medium text-600 ms-2">27

                                Sep at 10:30 AM</span></div>

                        <div class="hover-actions end-0 top-50 translate-middle-y"><a

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600"

                                data-bs-toggle="tooltip" data-bs-placement="top" title="Download"

                                href="assets/img/icons/cloud-download.svg" download="download"><img

                                    src="{{asset('backend/assets/img/icons/cloud-download.svg')}}" alt=""

                                    width="15" /></a><button

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600 shadow-none"

                                type="button" data-bs-toggle="tooltip" data-bs-placement="top"

                                title="Edit"><img src="{{asset('backend/assets/img/icons/edit-alt.svg')}}"

                                    alt="" width="15" /></button></div>

                    </div>

                </div>

                <hr class="text-200" />

                <div class="d-flex mb-3 hover-actions-trigger align-items-center">

                    <div class="file-thumbnail"><img

                            class="border h-100 w-100 object-fit-cover rounded-2"

                            src="{{asset('backend/assets/img/products/2-thumb.png')}}" alt="" /></div>

                    <div class="ms-3 flex-shrink-1 flex-grow-1">

                        <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"

                                href="#!">iMac.jpg</a></h6>

                        <div class="fs-10"><span class="fw-semi-bold">Rowen</span><span

                                class="fw-medium text-600 ms-2">23

                                Sep at 6:10 PM</span></div>

                        <div class="hover-actions end-0 top-50 translate-middle-y"><a

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600"

                                data-bs-toggle="tooltip" data-bs-placement="top" title="Download"

                                href="assets/img/icons/cloud-download.svg" download="download"><img

                                    src="{{asset('backend/assets/img/icons/cloud-download.svg')}}" alt=""

                                    width="15" /></a><button

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600 shadow-none"

                                type="button" data-bs-toggle="tooltip" data-bs-placement="top"

                                title="Edit"><img src="{{asset('backend/assets/img/icons/edit-alt.svg')}}"

                                    alt="" width="15" /></button></div>

                    </div>

                </div>

                <hr class="text-200" />

                <div class="d-flex mb-3 hover-actions-trigger align-items-center">

                    <div class="file-thumbnail"><img class="img-fluid"

                            src="{{asset('backend/assets/img/icons/docs.png')}}" alt="" /></div>

                    <div class="ms-3 flex-shrink-1 flex-grow-1">

                        <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"

                                href="#!">functions.php</a></h6>

                        <div class="fs-10"><span class="fw-semi-bold">John</span><span

                                class="fw-medium text-600 ms-2">1 Oct

                                at 4:30 PM</span></div>

                        <div class="hover-actions end-0 top-50 translate-middle-y"><a

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600"

                                data-bs-toggle="tooltip" data-bs-placement="top" title="Download"

                                href="assets/img/icons/cloud-download.svg" download="download"><img

                                    src="{{asset('backend/assets/img/icons/cloud-download.svg')}}" alt=""

                                    width="15" /></a><button

                                class="btn btn-tertiary border-300 btn-sm me-1 text-600 shadow-none"

                                type="button" data-bs-toggle="tooltip" data-bs-placement="top"

                                title="Edit"><img src="{{asset('backend/assets/img/icons/edit-alt.svg')}}"

                                    alt="" width="15" /></button></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-0">

    <div class="col-md-6 col-xxl-3 pe-md-2 mb-3 mb-xxl-0">

        <div class="card">

            <div class="card-header d-flex flex-between-center bg-body-tertiary py-2">

                <h6 class="mb-0">Active Users</h6>

                <div class="dropdown font-sans-serif btn-reveal-trigger"><button

                        class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"

                        type="button" id="dropdown-active-user" data-bs-toggle="dropdown"

                        data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span

                            class="fas fa-ellipsis-h fs-11"></span></button>

                    <div class="dropdown-menu dropdown-menu-end border py-2"

                        aria-labelledby="dropdown-active-user"><a class="dropdown-item"

                            href="#!">View</a><a class="dropdown-item"

                            href="#!">Export</a>

                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger"

                            href="#!">Remove</a>

                    </div>

                </div>

            </div>

            <div class="card-body py-2">

                <div class="d-flex align-items-center position-relative mb-3">

                    <div class="avatar avatar-2xl status-online">

                        <img class="rounded-circle" src="{{asset('backend/assets/img/team/1.jpg')}}" alt="" />

                    </div>

                    <div class="flex-1 ms-3">

                        <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"

                                href="pages/user/profile.html">Emma

                                Watson</a></h6>

                        <p class="text-500 fs-11 mb-0">Admin</p>

                    </div>

                </div>

                <div class="d-flex align-items-center position-relative mb-3">

                    <div class="avatar avatar-2xl status-online">

                        <img class="rounded-circle" src="{{asset('backend/assets/img/team/2.jpg')}}" alt="" />

                    </div>

                    <div class="flex-1 ms-3">

                        <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"

                                href="pages/user/profile.html">Antony Hopkins</a></h6>

                        <p class="text-500 fs-11 mb-0">Moderator</p>

                    </div>

                </div>

                <div class="d-flex align-items-center position-relative mb-3">

                    <div class="avatar avatar-2xl status-away">

                        <img class="rounded-circle" src="{{asset('backend/assets/img/team/3.jpg')}}" alt="" />

                    </div>

                    <div class="flex-1 ms-3">

                        <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"

                                href="pages/user/profile.html">Anna

                                Karinina</a></h6>

                        <p class="text-500 fs-11 mb-0">Editor</p>

                    </div>

                </div>

                <div class="d-flex align-items-center position-relative mb-3">

                    <div class="avatar avatar-2xl status-offline">

                        <img class="rounded-circle" src="{{asset('backend/assets/img/team/4.jpg')}}" alt="" />

                    </div>

                    <div class="flex-1 ms-3">

                        <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"

                                href="pages/user/profile.html">John

                                Lee</a></h6>

                        <p class="text-500 fs-11 mb-0">Admin</p>

                    </div>

                </div>

                <div class="d-flex align-items-center position-relative false">

                    <div class="avatar avatar-2xl status-offline">

                        <img class="rounded-circle" src="{{asset('backend/assets/img/team/5.jpg')}}" alt="" />

                    </div>

                    <div class="flex-1 ms-3">

                        <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"

                                href="pages/user/profile.html">Rowen Atkinson</a></h6>

                        <p class="text-500 fs-11 mb-0">Editor</p>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-body-tertiary p-0"><a

                    class="btn btn-sm btn-link d-block w-100 py-2"

                    href="app/social/followers.html">All active users<span

                        class="fas fa-chevron-right ms-1 fs-11"></span></a></div>

        </div>

    </div>

    <div class="col-md-6 col-xxl-3 ps-md-2 order-xxl-1 mb-3 mb-xxl-0">

        <div class="card h-100">

            <div class="card-header bg-body-tertiary d-flex flex-between-center py-2">

                <h6 class="mb-0">Bandwidth Saved</h6>

                <div class="dropdown font-sans-serif btn-reveal-trigger"><button

                        class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"

                        type="button" id="dropdown-bandwidth-saved" data-bs-toggle="dropdown"

                        data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span

                            class="fas fa-ellipsis-h fs-11"></span></button>

                    <div class="dropdown-menu dropdown-menu-end border py-2"

                        aria-labelledby="dropdown-bandwidth-saved"><a class="dropdown-item"

                            href="#!">View</a><a class="dropdown-item"

                            href="#!">Export</a>

                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger"

                            href="#!">Remove</a>

                    </div>

                </div>

            </div>

            <div class="card-body d-flex flex-center flex-column">

                <!-- Find the JS file for the following chart at: src/js/charts/echarts/bandwidth-saved.js--><!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->

                <div class="echart-bandwidth-saved" data-echart-responsive="true"></div>

                <div class="text-center mt-3">

                    <h6 class="fs-9 mb-1"><span class="fas fa-check text-success me-1"

                            data-fa-transform="shrink-2"></span>35.75 GB saved</h6>

                    <p class="fs-10 mb-0">38.44 GB total bandwidth</p>

                </div>

            </div>

            <div class="card-footer bg-body-tertiary py-2">

                <div class="row flex-between-center">

                    <div class="col-auto"><select class="form-select form-select-sm">

                            <option>Last 6 Months</option>

                            <option>Last Year</option>

                            <option>Last 2 Year</option>

                        </select></div>

                    <div class="col-auto"><a class="fs-10 font-sans-serif" href="#!">Help</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xxl-6 px-xxl-2">

        <div class="card h-100">

            <div class="card-header bg-body-tertiary py-2">

                <div class="row flex-between-center">

                    <div class="col-auto">

                        <h6 class="mb-0">Top Products</h6>

                    </div>

                    <div class="col-auto d-flex"><a class="btn btn-link btn-sm me-2"

                            href="#!">View Details</a>

                        <div class="dropdown font-sans-serif btn-reveal-trigger"><button

                                class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"

                                type="button" id="dropdown-top-products"

                                data-bs-toggle="dropdown" data-boundary="viewport"

                                aria-haspopup="true" aria-expanded="false"><span

                                    class="fas fa-ellipsis-h fs-11"></span></button>

                            <div class="dropdown-menu dropdown-menu-end border py-2"

                                aria-labelledby="dropdown-top-products">

                                <a class="dropdown-item" href="#!">View</a><a

                                    class="dropdown-item" href="#!">Export</a>

                                <div class="dropdown-divider"></div><a

                                    class="dropdown-item text-danger" href="#!">Remove</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body h-100">

                <!-- Find the JS file for the following chart at: src/js/charts/echarts/top-products.js--><!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->

                <div class="echart-bar-top-products h-100" data-echart-responsive="true"></div>

            </div>

        </div>

    </div>

</div>

@endsection
@section('js')
<script>
    var docReady = function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            setTimeout(fn, 1);
        }
    };
    /* -------------------------------------------------------------------------- */
    /*                                Weekly Sales                                */
    /* -------------------------------------------------------------------------- */

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.echart-bar').forEach(function(el) {
            const labels = JSON.parse(el.dataset.labels || '[]');
            const values = JSON.parse(el.dataset.values || '[]');
            const chart = echarts.init(el);

            const options = {
                tooltip: {
                    trigger: 'axis',
                    formatter: '{b0}: {c0}',
                    backgroundColor: utils.getGrays()['100'],
                    borderColor: utils.getGrays()['300'],
                    borderWidth: 1,
                    textStyle: {
                        color: utils.getGrays()['1100']
                    }
                },
                xAxis: {
                    type: 'category',
                    data: labels,
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        color: '#999'
                    }
                },
                yAxis: {
                    type: 'value',
                    show: false
                },
                series: [{
                    type: 'bar',
                    data: values,
                    barWidth: '10px',
                    itemStyle: {
                        color: '#ffffff',
                        barBorderRadius: [4, 4, 0, 0]
                    },
                    label: {
                        show: true,
                        position: 'top',
                        color: '#ffffff',
                        fontSize: 11,
                        fontWeight: 'bold',
                        formatter: '{c}'
                    }
                }],
                grid: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 5
                }
            };

            chart.setOption(options);
            window.addEventListener('resize', () => chart.resize());
        });
    });
</script>
@endsection