@extends('frontend.includes.labProfile_layout')
@section('css')
    <style>
        .search-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 7px 15px;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 400px;
            margin-bottom: 0;
            position: relative;
        }

        .search-box i {
            color: #888;
            margin-right: 10px;
        }

        .search-box input {
            border: none;
            outline: none;
            flex-grow: 1;
        }

        .service-dropdown {
            position: absolute;
            background-color: white;
            z-index: 1;
            border: 1px solid #ddd;
            border-top: none;
            max-width: 400px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            display: none;
        }

        .service-item {
            padding: 10px 15px;
            cursor: pointer;
        }

        .service-item:hover {
            background-color: #f8f9fa;
        }


        .owl-stage {
            display: flex !important;
            gap: 6px;
            /* adds consistent spacing */
        }

        /* Owl Nav Buttons */
        .cate .owl-nav {
            position: absolute;
            top: 50%;
            width: 95%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .cate .owl-nav button.owl-prev,
        .cate .owl-nav button.owl-next {
            background: #007bff !important;
            color: #fff !important;
            border: none;
            font-size: 18px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            pointer-events: all;
        }

        .cate .owl-nav button.owl-prev {
            margin-left: -20px;
        }

        .cate .owl-nav button.owl-next {
            margin-right: -15px;
        }


        .small-banner .owl-nav button.owl-prev,
        .small-banner .owl-nav button.owl-next {
            position: absolute;
            top: 40%;
            background: #0095d9;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            color: #fff;
            border: none;
            /* padding: 0px 20px !important; */
            font-size: 23px;
            font-weight: bold;
            cursor: pointer;
        }

        .small-banner .owl-nav button.owl-prev {
            left: -10px;
        }

        .small-banner .owl-nav button.owl-next {
            right: -10px;
        }

        .scroll-area::-webkit-scrollbar {
            width: 3px;
            /* Width of vertical scrollbar */
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        scroll-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }



        .hours-card {
            width: 350px;
            border: none;
        }

        .hours-header {
            background-color: #0095d9;
            color: white;
            padding: 1rem 1.25rem;
            border-radius: 0.375em 0.375em 0em 0em;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .hours-item:last-child {
            border-bottom: none;
        }

        .today {
            font-weight: bold;
            color: #007bff;
        }

        .closed {
            color: #dc3545;
            font-weight: 500;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .cate .owl-dots {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11 mx-auto py-2 px-4">
                <p>Ourlabz / {{ $lab->lab_name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-11 mx-auto">
                <div class="big-banner pb-5">
                    <div class="row ">
                        <div class="col-sm-12 item-3 ">
                            <!-- testimonial area -->
                            <div class="big-slider owl-carousel owl-theme rounded-4 w-100  ">
                                @foreach ($lab->slider as $slider)
                                    <div class="banner-item">
                                        <img src="{{ asset($slider->image) }}" alt="" class="rounded-4">
                                    </div>
                                @endforeach
                            </div>
                            <!-- testimonial area end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <main class="main">

        <div class="container py-5">
            <div class="team-single">
                <div class="row justify-content-center">

                    <div class="col-sm-12 px-4">
                        <div class="">

                            <div class="row g-0 justify-content-between" id="home">
                                <div class="col-md-2 p-2 border rounded-3" style="height: 200px; width:200px">
                                    <img src="{{ asset($lab->lab_logo) }}" class="" alt="Lab Logo"
                                        style="object-fit: cover;height: 180px;">
                                </div>
                                <div class="col-md-10 p-2 pt-0">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <h3 class="mb-3">{{ $lab->lab_name }}
                                                    <span class="text-success small badge"
                                                        style="font-size: 14px !important;">
                                                        <i class="fas fa-check-circle"></i>
                                                        Verified
                                                    </span>
                                                </h3>

                                                @if ($reviews->count() > 0)
                                                    <div class="d-flex align-items-center mb-2 gap-3">
                                                        <span class="rating-badge">
                                                            {{ number_format($reviews->avg('rating'), 1) }}
                                                            <i class="fas fa-star text-warning"></i>
                                                        </span>
                                                        <small class="text-muted">{{ $reviews->count() }}
                                                            {{ Str::plural('Review', $reviews->count()) }}</small>
                                                    </div>
                                                @endif

                                                <div class="text-muted">
                                                    <i class="fa-solid fa-location-crosshairs me-2"></i>
                                                    {{ $lab?->street_address ?? 'N/A' }},
                                                    {{ $lab?->city ?? 'N/A' }},
                                                    {{ $lab?->state ?? 'N/A' }},
                                                    {{ $lab?->country ?? 'N/A' }},
                                                    {{ $lab?->postal_code ?? 'N/A' }}
                                                    <br>
                                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                                    <span>
                                                        {{ (int) \Carbon\Carbon::parse($lab->year_of_establishment)->diffInYears(now()) }}
                                                        Years of Establishment
                                                    </span>
                                                </div>
                                                <div class="text-muted">
                                                    <i class="fa-solid fa-people-roof me-2"></i>
                                                    Home Sample Collection For :
                                                    <small class="btn btn-sm text-muted">
                                                        <i class="fa-solid fa-user-group"></i>
                                                        Users :
                                                        {!! $lab->home_sample_collection == 'Yes'
                                                            ? '<span class="badge bg-success">Yes</span>'
                                                            : '<span class="badge bg-danger">No</span>' !!}
                                                    </small>
                                                    |
                                                    <small class="btn btn-sm text-muted">
                                                        <i class="fa-solid fa-building-user"></i>
                                                        Corporate :
                                                        {!! $lab->sample_collection == 'Yes'
                                                            ? '<span class="badge bg-success">Yes</span>'
                                                            : '<span class="badge bg-danger">No</span>' !!}
                                                    </small>

                                                </div>

                                                <div class="text-muted mb-2">
                                                    <i class="fa-solid fa-id-card me-2"></i>
                                                    Insurance Accepted :
                                                    {!! $lab->insurance_partner_accepted == 'Yes'
                                                        ? '<span class="badge bg-success">Yes</span>'
                                                        : '<span class="badge bg-danger">No</span>' !!}
                                                </div>
                                                <div class="text-muted mb-4">
                                                    <i class="fa-solid fa-flask me-2"></i>
                                                    Lab Facilities :
                                                    @php
                                                        $types = is_array($lab->lab_type)
                                                            ? $lab->lab_type
                                                            : json_decode($lab->lab_type, true);
                                                    @endphp

                                                    @if ($types)
                                                        @foreach ($types as $type)
                                                            <span class="badge bg-primary me-1">{{ $type }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </div>

                                                <div class="d-flex flex-wrap gap-2">

                                                    <a href="javascript:void(0);"class="btn btn-sm btn-outline-primary me-2"
                                                        data-bs-toggle="modal" data-bs-target="#ReviewModal"><i
                                                            class="fas fa-pen me-2"></i> Write a Review</a>
                                                    <button class="btn btn-sm btn-outline-primary" id="shareBtn"><i
                                                            class="fa-solid fa-share-nodes me-2"></i> Share</button>

                                                </div>

                                                <div class="row text-center mt-4">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="d-flex rounded shadow-sm">
                                                            <img src="{{ asset('assets/img/certified.png') }}"
                                                                alt="Certified Icon" height="50" width="50"
                                                                style="object-fit: cover;">
                                                            <div class="mx-auto text-muted">Certified
                                                                <br>
                                                                <strong>Labs</strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <div class="d-flex rounded shadow-sm">
                                                            <img src="{{ asset('assets/img/collection.png') }}"
                                                                alt="Collection Icon" height="50" width="50"
                                                                style="object-fit: cover;">
                                                            <div class="mx-auto text-muted">Verified
                                                                <br>
                                                                <strong>Reports</strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <div class="d-flex rounded shadow-sm">
                                                            <img src="{{ asset('assets/img/report.png') }}"
                                                                alt="Report Icon" height="50" width="50"
                                                                style="object-fit: cover;">
                                                            <div class="mx-auto text-muted">Report in
                                                                <br>
                                                                <strong>{{ $lab->tat_for_reports }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>

                                        <div class="card hours-card shadow-sm">
                                            <div class="hours-header ">
                                                <h5 class="text-white"><i class="fas fa-clock me-2"></i>Business Hours
                                                </h5>
                                            </div>
                                            <div class="hours-list pt-2 pb-4 ps-4">
                                                @foreach ($lab->operating_hours as $hour)
                                                    <div class="d-flex align-items-start">
                                                        <div class="me-3 mt-1">
                                                            <i class="fa fa-calendar-days fs-5 text-secondary"></i>
                                                        </div>
                                                        <div class="flex-1" style="line-height: 25px;">
                                                            <span class="fw-bold text-dark">{{ $hour['day'] }}</span><br>
                                                            @if ($hour['status'] == 'Open')
                                                                <span class="text-dark">
                                                                    {{ \Carbon\Carbon::createFromFormat('H:i', $hour['from_time'])->format('h:i A') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::createFromFormat('H:i', $hour['to_time'])->format('h:i A') }}
                                                                </span>
                                                            @endif
                                                            @if ($hour['status'] == 'Open')
                                                                <span
                                                                    class="badge bg-success ms-2">{{ $hour['status'] }}</span>
                                                            @else
                                                                <span class="badge bg-danger">{{ $hour['status'] }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="shadow my-4 mb-5 rounded-3 overflow-hidden" id="test">

                                <div class="row p-4">
                                    <div class="row">
                                        <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                                            <div class="site-heading-inline">
                                                <h2 class="site-title">Lab Test</h2>
                                                <a href="{{ route('lab.test') }}">View All <i
                                                        class="fas fa-angle-double-right"></i></a>
                                            </div>
                                            <div class="item-tab">
                                                <ul class="nav nav-pills mt-40 mb-35" id="item-tab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active filter-tab" id="item-tab1"
                                                            data-type="All" data-bs-toggle="pill"
                                                            data-bs-target="#pill-item-tab1" type="button"
                                                            role="tab" aria-controls="pill-item-tab1"
                                                            aria-selected="true">All</button>
                                                    </li>
                                                    @foreach ($test_types as $type)
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link filter-tab" id="item-tab"
                                                                data-type="{{ $type }}" data-bs-toggle="pill"
                                                                data-bs-target="#pill-item-tab1" type="button"
                                                                role="tab" aria-controls="pill-item-tab1"
                                                                aria-selected="true">{{ $type }}</button>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-content wow fadeInUp" data-wow-delay=".25s" id="item-tabContent">
                                        <div class="tab-pane show active" id="pill-item-tab1" role="tabpanel"
                                            aria-labelledby="item-tab1" tabindex="0">
                                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3"
                                                id="item-container">
                                                @foreach ($packages as $package)
                                                    <div class="col">
                                                        <div class="card h-100 p-3 border">
                                                            <div class="card-body p-0 mb-4">
                                                                <div class="d-flex gap-2">
                                                                    <div class="border p-1 rounded-2 test-image">
                                                                        @php
                                                                            $icon = $package->package_icon
                                                                                ? asset($package->package_icon)
                                                                                : ($package->categoryDetails &&
                                                                                $package->categoryDetails
                                                                                    ->category_image
                                                                                    ? asset(
                                                                                        $package->categoryDetails
                                                                                            ->category_image,
                                                                                    )
                                                                                    : asset('default.png'));
                                                                        @endphp
                                                                        <img src="{{ $icon }}" alt="">
                                                                    </div>
                                                                    <div>
                                                                        <h6 class=" my-2 fw-bold ">
                                                                            <a
                                                                                href="{{ route('test.details', ['slug' => $package->slug]) }}">{{ $package->name }}</a>
                                                                        </h6>
                                                                        <div class=" d-flex gap-3 mt-2">
                                                                            <div>
                                                                                <h6 class="small text-muted">Parameters
                                                                                </h6>
                                                                                <p class="text-muted small">
                                                                                    {{ count($package->parameters) }} Test
                                                                                </p>
                                                                            </div>
                                                                            <div>
                                                                                <h6 class="small text-muted">Reports Within
                                                                                </h6>
                                                                                <p class="text-muted small">
                                                                                    {{ $package->reports_within }}
                                                                                    Hours</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex w-100 price">
                                                                <div>
                                                                    <span
                                                                        class="pe-2 text-dark fw-bold">₹{{ $package->price }}</span>
                                                                    <!-- <del class="text-muted small px-0">₹60.00</del>
                                                                                                                                        <span class="text-danger small px-0">30% Off</span> -->
                                                                </div>
                                                                <a href="javascript:void(0);" type="button"
                                                                    class="btn btn-primary px-4 add-to-cart"
                                                                    data-id="{{ $package->id }}" data-type="package">Add
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (count($lab->gallery) > 0)
                                <div id="gallery">
                                    <div class=" ps-4 mt-5">
                                        <h3 class="">Gallery</h3>
                                    </div>
                                    <div class="">
                                        <div class="small-banner py-5">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-12 item-3 ">
                                                        <!-- testimonial area -->
                                                        <div class="banner-slider owl-carousel owl-theme ">
                                                            @foreach ($lab->gallery as $gallery)
                                                                <div class="banner-item">
                                                                    <img src="{{ asset($gallery->image) }}"
                                                                        alt="" class="rounded-4">
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- testimonial area end -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>
                            <div class="row" id="about">
                                <div class="col-sm-8">
                                    <div class="py-3">
                                        <h3 class="">About</h3>
                                    </div>
                                    <div class="pb-4">
                                        <p>
                                            {!! $lab->lab_description !!}
                                        </p>

                                    </div>
                                </div>
                                @if ($reviews->count() > 0)
                                    <div class="col-sm-4">
                                        <div class="card hours-card shadow-sm w-100">
                                            <div class="hours-header">
                                                <h5 class="mb-0 text-white">User Reviews</h5>
                                            </div>
                                            <div class="p-3 review-card-outer">
                                                @foreach ($reviews as $review)
                                                    <div class="review-card card border p-2 mb-2">
                                                        <div class="review-header bg-light px-2 py-1">
                                                            <div class="review-user">
                                                                <img src="{{ asset('assets/img/user.png') }}"
                                                                    alt="{{ $review->name ?? 'Anonymous' }}">
                                                                <div>
                                                                    <strong>{{ $review->name ?? 'Anonymous' }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="review-date">
                                                                {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}
                                                            </div>
                                                        </div>

                                                        <div class="review-stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                            @endfor
                                                        </div>

                                                        <p>{{ $review->comment }}</p>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <div class="contact-map" id="map">
        {!! $lab->google_map_location !!}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="reviewForm" action="{{ route('lab.review.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lab_id" value="{{ $lab->id }}">
                    <input type="hidden" name="website" value="" autocomplete="off" tabindex="-1"
                        style="position:absolute;left:-9999px">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ReviewModalLabel">Write a Review</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reviewName" class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name."
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="reviewEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                placeholder="Enter your correct email." required>
                        </div>

                        <div class="mb-3">
                            <label for="reviewRating" class="form-label">Rating</label>
                            <select class="form-select" name="rating" required>
                                <option value="">Choose Rating</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="reviewText" class="form-label">Your Review</label>
                            <textarea class="form-control" name="comment" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        // testimonial slider
        $('.big-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            responsive: {
                0: {
                    items: 1
                }
            }
        });
    </script>
    <script>
        // testimonial slider
        $('.banner-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            autoplay: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
                // 1400: {
                //     items: 4
                // }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Owl Carousel
            $('#dateCarousel').owlCarousel({
                margin: 10,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 5
                    },

                }
            });

            // Toggle active time slot
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.addEventListener('click', () => {
                    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove(
                        'active'));
                    slot.classList.add('active');
                });
            });

            // Toggle selected date
            $('.day-button').click(function() {
                $('.day-button').removeClass('catrgory-selected');
                $(this).addClass('catrgory-selected');
            });
        });


        const stars = document.querySelectorAll('.star-rating i');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = parseInt(star.getAttribute('data-value'));
                stars.forEach(s => {
                    s.classList.remove('active');
                    if (parseInt(s.getAttribute('data-value')) <= rating) {
                        s.classList.add('active');
                    }
                });
            });
        });


        document.getElementById('shareBtn').addEventListener('click', async () => {
            const shareData = {
                title: 'Wizify Technologies',
                text: 'Check out Wizify Technologies in Lucknow!',
                url: window.location.href
            };

            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else {
                    alert("Sharing not supported on this browser. Copy the URL: " + window.location.href);
                }
            } catch (err) {
                console.error('Error sharing:', err);
            }
        });

        const searchInput = document.getElementById('searchInput');
        const serviceDropdown = document.getElementById('serviceDropdown');
        const serviceItems = document.querySelectorAll('.service-item');

        searchInput.addEventListener('focus', () => {
            serviceDropdown.style.display = 'block';
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-box') && !e.target.closest('.service-dropdown')) {
                serviceDropdown.style.display = 'none';
            }
        });

        serviceItems.forEach(item => {
            item.addEventListener('click', () => {
                searchInput.value = item.textContent;
                serviceDropdown.style.display = 'none';
            });
        });
    </script>
    <script>
        document.querySelectorAll('.scroll-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const target = document.getElementById(targetId);
                const offset = 100;

                if (target) {
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.scrollY - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <script>
        const labSlug = "{{ $lab->slug }}";
        const labId = "{{ request()->route('id') }}";
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.filter-tab', function() {
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('.filter-tab').removeClass('active');
                $(this).addClass('active');

                const type = $(this).data('type');

                $.ajax({
                    url: `/lab-profile/${labSlug}/${labId}`,
                    method: "GET",
                    data: {
                        type: type
                    },
                    success: function(items) {
                        Swal.close();
                        let html = '';

                        if (items.length === 0) {
                            html = '<div class="col"><p>No Test Found.</p></div>';
                        }

                        items.forEach(function(item) {
                            const parameters = item.parameters.length;
                            html += `
                        <div class="col">
                            <div class="card h-100 p-3 border">
                                <div class="card-body p-0 mb-4">
                                    <div class="d-flex gap-2">
                                        <div class="border p-1 rounded-2 test-image">
                                            <img src="${item.icon_url}" alt="">
                                        </div>
                                        <div>
                                            <h6 class="my-2 fw-bold">
                                                <a href="/lab-test/${item.slug}">${item.name}</a>
                                            </h6>
                                            <div class="d-flex gap-3 mt-2">
                                                <div>
                                                    <h6 class="small text-muted">Parameters</h6>
                                                    <p class="text-muted small">${parameters} Test</p>
                                                </div>
                                                <div>
                                                    <h6 class="small text-muted">Reports Within</h6>
                                                    <p class="text-muted small">${item.reports_within} Hours</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 price">
                                    <div>
                                        <span class="pe-2 text-dark fw-bold">₹${item.price}</span>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-primary px-4 add-to-cart" data-id="${item.id}"
                                        data-type="package">Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                        });

                        $('#item-container').html(html);
                    },
                    error: function() {
                        Swal.close();
                        showToast('error', 'Something went wrong');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#reviewForm').on('submit', function(e) {

                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                // Honeypot check
                let honeypot = form.find('input[name="website"]').val().trim();
                if (honeypot !== '') {
                    showToast('error', 'Spam detected!');
                    return;
                }

                Swal.fire({
                    title: 'Submitting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        Swal.close();
                        showToast('success', response.message ||
                            'Review submitted successfully!');
                        form.trigger('reset');
                        $('#ReviewModal').modal('hide');
                    },
                    error: function(xhr) {
                        Swal.close();
                        let errorText = 'Something went wrong!';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                errorText = '';
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorText += value[0] + '\n';
                                });
                            } else if (xhr.responseJSON.error) {
                                errorText = xhr.responseJSON.error;
                            }
                        }
                        showToast('error', errorText);
                    }
                });
            });


        });
    </script>
@endsection
