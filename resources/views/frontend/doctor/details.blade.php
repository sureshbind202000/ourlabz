@extends('frontend.includes.layout')

@section('css')

<style>
    .day-button {

        cursor: pointer;

        border-radius: 5px;

        padding: 5px;

    }



    .day-selected {

        background-color: #0095d9;

        color: #fff;

    }



    .time-slot {

        padding: 4px 10px;

        border: 1px solid green;

        border-radius: 5px;

        margin: 6px;

        cursor: pointer;

        line-height: 1.2;

        text-align: center;

        color: green;

    }



    .time-slot.active {

        background-color: #0095d9;

        color: white;

        font-weight: bold;

        border: none;

    }



    .slot-count {

        font-size: 12px;

        margin-left: 4px;

        color: green;

    }



    .time-slot.active .slot-count {

        color: white !important;

    }



    .disabled-slot,

    .disabled-date {

        border: 1px solid #ccc;

        pointer-events: none;

        color: red !important;

        opacity: 0.6;

    }



    .schedule-btn {

        width: 100%;

        background-color: #004d61;

        color: white;

        padding: 12px;

        font-weight: bold;

    }



    .schedule-btn:hover {

        background-color: #006d87;

    }



    .scroll-area {

        max-height: 155px;

        overflow-y: auto;

    }



    #dateCarousel {

        position: relative;

    }



    .owl-stage {

        display: flex !important;

        gap: 6px;

        /* adds consistent spacing */

    }



    /* Owl Nav Buttons */

    .owl-nav {

        position: absolute;

        top: 35%;

        width: 100%;

        display: flex;

        justify-content: space-between;

        transform: translateY(-50%);

        pointer-events: none;

    }



    .owl-nav button.owl-prev,

    .owl-nav button.owl-next {

        background: #0095d9 !important;

        color: #fff !important;

        border: none;

        font-size: 18px;

        width: 30px;

        height: 30px;

        border-radius: 50%;

        pointer-events: all;

    }



    .owl-nav button.owl-prev {

        margin-left: -20px;

    }



    .owl-nav button.owl-next {

        margin-right: -20px;

    }



    .scroll-area::-webkit-scrollbar {

        width: 6px;

        /* Width of vertical scrollbar */

    }



    .scroll-area::-webkit-scrollbar-thumb {

        background-color: #ccc;

        border-radius: 4px;

    }



    scroll-area::-webkit-scrollbar-track {

        background: #f1f1f1;

    }



    .consult {

        max-height: 600px;

    }

    @media (max-width: 427px) {

        .site-title,
        #heading,
        .product-list-title,
        .card-title {
            font-size: 19px !important;
        }
    }

    @media (max-width: 425px) {
        button.nav-link {
            font-size: 12px;
            padding: 6px;
        }

        .list-group-flush>.list-group-item {
            border-width: 0 0 var(--bs-list-group-border-width);
            font-size: 11px;
        }
    }
</style>

@endsection

@section('content')



<main class="main">

    <div class="container py-3">

        <img src="{{ asset('assets/img/banner/doc-banner-desktop.png') }}" alt="" class="w-100">

    </div>

    <div class="container py-5">

        <div class="team-single">

            <div class="row justify-content-center">



                <div class="col-lg-8 col-md-12 px-4">



                    <div class="" style="position: sticky;top: 15%;">

                        <div class="row g-0 justify-content-between">

                            <div class="col-md-4 p-2 ">

                                <img src="{{ asset($doctor->profile) }}" class="img-fluid  border rounded-3 p-1" alt="..."

                                    style="height: 200px;object-fit:cover;">

                            </div>

                            <div class="col-md-8 p-2">

                                <div class="card-body px-0 px-md-3">

                                    <h3 class="card-title text-dark mb-3">{{ $doctor->name }}</h3>

                                    @php

                                    $specializationsRaw = $doctor->doctor_details?->specialization ?? null;



                                    // Decode JSON if it's a string; fallback to empty array if invalid

                                    if (is_string($specializationsRaw)) {

                                    $decoded = json_decode($specializationsRaw, true);

                                    $specializations = is_array($decoded) ? $decoded : [];

                                    } elseif (is_array($specializationsRaw)) {

                                    $specializations = $specializationsRaw;

                                    } else {

                                    $specializations = [];

                                    }

                                    @endphp



                                    <p class="text-muted card-text mb-1">

                                        @if (!empty($specializations))

                                        {{ implode(', ', $specializations) }}.

                                        @else

                                        N/A

                                        @endif

                                    </p>





                                    @php

                                    $qualificationsRaw = $doctor->doctor_details?->qualification ?? [];

                                    $qualifications = is_string($qualificationsRaw)

                                    ? json_decode($qualificationsRaw, true)

                                    : $qualificationsRaw;



                                    // Ensure it's an array

                                    $qualifications = is_array($qualifications) ? $qualifications : [];

                                    @endphp



                                    <p class="text-primary card-text text-truncate truncate-fixed mb-1">

                                        @if (!empty($qualifications))

                                        {{ implode(', ', $qualifications) }}

                                        @else

                                        N/A

                                        @endif

                                    </p>

                                    <p class="text-muted "><i class="fa-solid fa-map-location-dot pe-2 fs-6"></i>

                                        {{ $doctor->doctor_details?->hospital_clinic_address ?? 'N/A' }}

                                    </p>

                                    <p class="text-muted "><i class="fa-solid fa-calendar-days pe-2 fs-6"></i>

                                        @if (!empty($doctor->doctor_details?->year_of_experience))

                                        {{ $doctor->doctor_details->year_of_experience }}

                                        year{{ $doctor->doctor_details->year_of_experience > 1 ? 's' : '' }}

                                        experience

                                        @else

                                        No experience data

                                        @endif

                                    </p>

                                    <!-- <p class="text-muted ">Hindi, English</p> -->

                                    <div class="d-flex align-items-center">



                                        <div class="ms-auto ">

                                            <h4 class="text-primary">₹{{ $doctor->doctor_details?->price ?? '0' }}</h4>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <h4 class="my-4"><i class="fa-solid fa-user-doctor text-primary"></i> About Me</h4>





                        <div class="mb-5">

                            {!! $doctor->doctor_details->about !!}

                        </div>

                        <hr>



                        {{-- <div class="education-card py-2">

                                <h5 class="mb-3"><i class="fa-solid fa-graduation-cap text-primary "></i> Education

                                </h5>

                                <!-- Education 1 -->

                                <div class="d-flex mb-2">

                                    <div class="edu-degree ps-4">

                                        @if (!empty($doctor->doctor_details?->qualification) && is_array($doctor->doctor_details->qualification))

                                            {{ implode(', ', $doctor->doctor_details->qualification) }}

                        @else

                        N/A

                        @endif

                    </div>

                </div>

            </div> --}}

            {{-- <hr> --}}

            <!-- Specializations Section -->

            {{-- <div class="custom-card py-2">

                                <h5 class="mb-3"><i class="fa-solid fa-briefcase-medical text-primary"></i>

                                    Specializations</h5>

                                <div class="d-flex mb-2">

                                    <div class="edu-degree ps-4">

                                        @if (!empty($doctor->doctor_details?->specialization) && is_array($doctor->doctor_details->specialization))

                                            {{ implode(', ', $doctor->doctor_details->specialization) }}

            @else

            N/A

            @endif

        </div>

    </div>

    </div> --}}

    </div>



    </div>

    <div class="col-lg-4 col-md-8 ">



        @include('frontend.doctor.appointment')



        @php

        use Carbon\Carbon;

        @endphp



        <form action="javascript:void(0);" class="py-5 px-4 rounded-2 mt-4 border consult">

            <h5 class="mb-4">Operating Hours</h5>

            <ul class="list-group list-group-flush">

                @foreach ($doctor->doctor_operating_hours as $operating_hours)

                <li class="list-group-item d-flex justify-content-between align-items-center">

                    <div>

                        <i class="fas fa-calendar-day text-primary me-2"></i>

                        <strong>{{ $operating_hours->day }}</strong>

                    </div>

                    <div>

                        @if ($operating_hours->status == 'Open')

                        <i class="fas fa-clock me-1 text-success"></i>

                        <span class="text-success">

                            {{ Carbon::parse($operating_hours->from_time)->format('g:i A') }} -

                            {{ Carbon::parse($operating_hours->to_time)->format('g:i A') }}

                        </span>

                        @else

                        <i class="fas fa-clock me-1 text-danger"></i>

                        <span class="text-danger">Closed</span>

                        @endif

                    </div>

                </li>

                @endforeach

            </ul>

        </form>







    </div>

    </div>

    <hr>

    @if (!empty($doctor->doctor_reviews))

    <div class="row py-4">

        <div class="col-lg-12" id="comment-section">

            <!-- review start -->



            <div class="row">

                <div class="col-lg-8 wow fadeInUp" data-wow-delay=".25s">

                    <h4 class="mb-4">Reviews</h4>

                    <!-- testimonial area -->

                    <div class="testimonial-area">

                        <div class="container">

                            <div class="review-slider owl-carousel owl-theme wow fadeInUp"

                                data-wow-delay=".25s">

                                @foreach ($doctor->doctor_reviews as $review)

                                <div class="testimonial-item">

                                    <div class="testimonial-author">

                                        <div class="testimonial-author-img">

                                            <img src="{{ asset('assets/img/user.png') }}"

                                                alt="Profile Image" style="height:50px;width:50px;">

                                        </div>

                                        <div class="testimonial-author-info">

                                            <h4>{{ $review->name }}</h4>

                                        </div>

                                    </div>

                                    <div class="testimonial-quote">

                                        <p>

                                            {{ $review->comment }}

                                        </p>

                                    </div>

                                    <div class="testimonial-rate">

                                        @for ($i = 1; $i <= 5; $i++)

                                            @if ($i <=$review->rating)

                                            <i class="fas fa-star text-warning"></i>

                                            @else

                                            <i class="fas fa-star"></i>

                                            @endif

                                            @endfor

                                    </div>

                                    <div class="testimonial-quote-icon"><img

                                            src="{{ asset('assets/img/icon/quote.svg') }}"

                                            alt=""></div>

                                </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    <div id="review-section"></div>

                    <!-- testimonial area end -->

                </div>

                <div class="col-lg-4">

                    <div class="blog-comments-form mt-4">

                        <h5 class="mb-4">Leave a review</h5>

                        <form id="commentForm" method="POST" action="{{ route('doctor.review.store') }}"

                            autocomplete="off">

                            @csrf

                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">



                            <input type="text" name="website" value="" autocomplete="off"

                                tabindex="-1" style="position:absolute;left:-9999px">



                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <input type="text" name="name" class="form-control"

                                            placeholder="Your Name*" required>

                                    </div>

                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <input type="email" name="email" class="form-control"

                                            placeholder="Your Email*" required>

                                    </div>

                                </div>

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <select name="rating" class="form-control form-select" required>

                                            <option value="">Ratings</option>

                                            <option value="5">5</option>

                                            <option value="4">4</option>

                                            <option value="3">3</option>

                                            <option value="2">2</option>

                                            <option value="1">1</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <textarea name="comment" class="form-control" rows="3" placeholder="Write a review here*" required></textarea>

                                    </div>

                                    <button type="submit" class="theme-btn">

                                        <span class="far fa-paper-plane"></span> Submit

                                    </button>

                                </div>

                            </div>

                        </form>





                    </div>

                </div>

            </div>

        </div>

    </div>

    <hr>

    @endif

    <div class="row pb-4">

        <div class="col-sm-12" style="padding-left:30px ;">

            <h5 class="mb-4"><i class="fa-regular fa-circle-question text-primary"></i> FAQ's

            </h5>

            <div class="accordion" id="accordionExample">

                @foreach ($doctor_faqs as $faq)

                <div class="accordion-item border-0 border-bottom">

                    <h2 class="accordion-header" id="headingOne{{ $faq->id }}">

                        <button class="accordion-button collapsed border-0 shadow-none fw-bold"

                            type="button" data-bs-toggle="collapse"

                            data-bs-target="#collapseOne{{ $faq->id }}" aria-expanded="false"

                            aria-controls="collapseOne{{ $faq->id }}">

                            {{ $faq->question }}

                        </button>

                    </h2>

                    <div id="collapseOne{{ $faq->id }}" class="accordion-collapse collapse"

                        aria-labelledby="headingOne{{ $faq->id }}"

                        data-bs-parent="#accordionExample">

                        <div class="accordion-body">

                            <p class="text-muted">{{ $faq->answer }}</p>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>



    </div>

    </div>

</main>







@endsection

@section('js')

<script>
    $(document).ready(function() {

        // Initialize Owl Carousel

        $('#dateCarousel').owlCarousel({

            margin: 10,

            nav: true,

            dots: true,

            responsive: {

                0: {

                    items: 3

                },

                600: {

                    items: 5

                },

                1000: {

                    items: 7

                }

            }

        });



        // testimonial slider

        $('.review-slider').owlCarousel({

            loop: false,

            margin: 20,

            nav: true,

            dots: true,

            autoplay: true,

            responsive: {

                0: {

                    items: 1

                },

                600: {

                    items: 2

                },

                1000: {

                    items: 2

                }

                // 1400: {

                //     items: 4

                // }

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

            $('.day-button').removeClass('day-selected');

            $(this).addClass('day-selected');

        });

    });
</script>

<script>
    $(document).ready(function() {

        let selectedType = null;

        let selectedDate = null;

        let selectedTime = null;

        let schedulerId = null;



        function initCarousel() {

            $('#dateCarousel').owlCarousel({

                margin: 10,

                nav: true,

                dots: true,

                responsive: {

                    0: {

                        items: 3

                    },

                    600: {

                        items: 5

                    },

                    1000: {

                        items: 5

                    }

                }

            });

        }



        // Load Dates on Radio Select

        $('input[name="schedule_for"]').on('change', function() {

            selectedType = $(this).val();

            schedulerId = $(this).data('scheduler_id');

            $('#booking_schedule_for').val(selectedType);

            selectedDate = null;

            selectedTime = null;

            $('#scheduleBtn').addClass('disabled');

            $.ajax({

                url: "{{ route('doctor.schedule.dates') }}",

                type: 'POST',

                data: {

                    scheduling_for: selectedType,

                    scheduler_id: schedulerId,

                    _token: '{{ csrf_token() }}'

                },

                success: function(data) {

                    let html = '';

                    const today = new Date().setHours(0, 0, 0, 0);



                    data.forEach(item => {

                        const itemDate = new Date(item.date).setHours(0, 0, 0, 0);

                        const isPast = itemDate < today;

                        const day = item.day.substring(0, 3);

                        const dateNum = new Date(item.date).getDate();



                        html += `

                        <div class="item">

                            <div class="day-button text-center ${isPast ? 'text-danger disabled-date' : ''}" data-date="${item.date}" data-scheduler_id="${item.scheduler_id}" ${isPast ? 'style="pointer-events: none; opacity: 0.6;"' : ''}>

                                <div>${day}</div>

                                <div class="fw-bold fs-5 mt-0">${dateNum}</div>

                            </div>

                        </div>

                    `;

                    });



                    $('#dateCarousel').trigger('destroy.owl.carousel');

                    $('#dateCarousel').html(html);

                    initCarousel();

                },

                error: function() {

                    Swal.fire("Error!", "Could not load dates.", "error");

                }

            });

        });



        // Date Click

        $(document).on('click', '.day-button:not(.disabled-date)', function() {

            $('.day-button').removeClass('day-selected');

            $(this).addClass('day-selected');

            selectedDate = $(this).data('date');

            selectedTime = null;

            $('#booking_date').val(selectedDate);

            $('#scheduleBtn').addClass('disabled');



            loadSlots('morning');

        });



        // Tab Change (Morning, Afternoon, Evening)

        $('#nav-tab button').on('click', function() {

            $('#nav-tab button').removeClass('active');

            $(this).addClass('active');



            const period = $(this).data('period');

            loadSlots(period);

        });



        // Load Slots

        function loadSlots(period) {

            if (!selectedType || !selectedDate || !schedulerId) return;



            $.ajax({

                url: "{{ route('doctor.schedule.slots') }}",

                type: 'POST',

                data: {

                    scheduling_for: selectedType,

                    date: selectedDate,

                    scheduler_id: schedulerId,

                    _token: '{{ csrf_token() }}'

                },

                success: function(data) {

                    const now = new Date();

                    const isToday = new Date(selectedDate).toDateString() === now.toDateString();

                    const slots = data[period] || [];

                    let html = '';



                    slots.forEach(t => {

                        const timeStr = typeof t === 'string' ? t : t.time;

                        const available = typeof t === 'string' ? 1 : t.available_slots;

                        const slotTime = new Date(`${selectedDate} ${timeStr}`);



                        const isPast = isToday && slotTime < now;

                        const isZero = available === 0;



                        const disabled = isPast || isZero;

                        const slotClass =

                            `time-slot ${disabled ? 'disabled-slot text-danger' : ''}`;

                        const style = disabled ? 'pointer-events: none; opacity: 0.6;' : '';



                        html += `

                    <div class="${slotClass}" style="${style}" data-time="${timeStr}">

                        ${timeStr} <br><span class="slot-count">(${available} slot${available !== 1 ? 's' : ''})</span>

                    </div>

                `;

                    });



                    $('.scroll-area > .d-flex').html(html);

                },

                error: function() {

                    Swal.fire("Error!", "Could not load time slots.", "error");

                }

            });

        }





        // Time Slot Click

        $(document).on('click', '.time-slot:not(.disabled-slot)', function() {

            $('.time-slot').removeClass('active');

            $(this).addClass('active');

            selectedTime = $(this).text();

            var bookingTime = $(this).data('time');

            $('#booking_time').val(bookingTime);

            $('#booking_scheduler_id').val(schedulerId);

            if (selectedType && selectedDate && selectedTime) {

                $('#scheduleBtn').removeClass('disabled');

            }

        });



        // Init Carousel (empty initially)

        initCarousel();

    });
</script>

<script>
    $(document).ready(function() {

        $('#commentForm').on('submit', function(e) {

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