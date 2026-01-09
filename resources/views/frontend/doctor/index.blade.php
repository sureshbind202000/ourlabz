@extends('frontend.includes.layout')

@section('css')

<style>
    .offcanvas-end {



        width: 33% !important;



    }



    @media (max-width: 1024px) {

        .offcanvas-end {

            width: 40% !important;



        }

    }



    @media (max-width: 768px) {

        .offcanvas-end {

            width: 60% !important;



        }

    }



    @media (max-width: 426px) {

        .offcanvas-end {

            width: 100% !important;



        }

    }



    @media (max-width: 320px) {

        .offcanvas-end {

            width: 100% !important;



        }

    }





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

        padding: 4px 20px;

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

        max-height: 200px;

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
     @media (max-width: 425px) {
        button.nav-link {
            font-size: 12px;
            padding: 6px;
        }
     }
</style>

@endsection

@section('content')

<main class="main bg">

    <div class="container py-4">

        <img src="{{ asset('assets/img/banner/doc-banner-desktop.png') }}" alt="">

    </div>

    <div class="shop-area">

        <div class="container">

            <div class="row">

                {{-- Filters --}}

                <div class="col-lg-3 " id="mainFilter">

                    @include('frontend.doctor.filters', ['specialities' => $specialities])

                </div>

                {{-- Packages --}}

                <div class="col-lg-9">

                    <div class="col-md-12">

                        <div class="shop-sort d-block d-md-flex">

                            <div class="shop-search-form">

                                <form action="#">

                                    <div class="form-group">

                                        <input type="text" id="search" placeholder="Search..."

                                            class="form-control  rounded-2 py-2">

                                        <button type="search"><i class="far fa-search"></i></button>

                                    </div>

                                </form>

                            </div>


                            <div class=" mt-2 mt-md-0 row">
                                <div class="col-6 col-lg-12">

                                    <select id="sort_by" class="form-select w-100">

                                        <option value="">Sort By</option>

                                        <option value="latest">Latest</option>

                                        <option value="price_low_high">Low to High</option>

                                        <option value="price_high_low">High to Low</option>

                                    </select>
                                </div>
                                <div class="col-6">
                                    <a class="btn  bg-white border d-lg-none w-100" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                        <i class="fa-solid fa-filter"></i> Filter
                                    </a>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div id="doctor-list">

                        @include('frontend.doctor.doctor_list', ['doctors' => $doctors])

                    </div>



                </div>

            </div>

        </div>

    </div>

</main>

<!-- consult now start -->



<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">



    <div class="offcanvas-header">



        <h5 class="offcanvas-title" id="offcanvasRightLabel">Schedule Appointment</h5>



        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>



    </div>



    <div class="offcanvas-body">



        <div class="consult ">



            <div class=" d-flex align-items-center mb-3  gap-4">



                <div>



                    <img src="{{ asset('assets/img/doctor/doctor3.webp') }}" alt="" class="img-fluid rounded-3"

                        style="width: 60px;" id="doctor-image">



                </div>



                <div class="fw-bold">



                    <h5 id="doctor-name">Dr. Shubham Shekhar</h5>



                </div>



            </div>



            <hr>



            <div class=" d-flex justify-content-between align-items-center mb-2">



                <div>



                    <h5 class="mb-0">Digital Consult</h5>



                    <small class="text-muted">Available in 7 mins</small>



                </div>



                <div class="fw-bold">₹499</div>



            </div>



            <hr>



            <form action="{{ route('doctor.checkout') }}" method="POST" id="appointmentForm"

                class="py-5 px-4 rounded-2 border consult">

                @csrf

                <div class="row mb-4">

                    <div class="col-6 p-0">

                        <input type="radio" class="form-check-input me-1" name="schedule_for" id="online_schedule"

                            value="2" data-scheduler_id="">

                        <label for="online_schedule">Online Consult</label>

                    </div>

                    <div class="col-6">

                        <input type="radio" class="form-check-input me-1" name="schedule_for" id="offline_schedule"

                            value="1" data-scheduler_id="">

                        <label for="offline_schedule">Visit Doctor</label>

                    </div>

                </div>



                <!-- Date Carousel -->

                <div class="owl-carousel owl-theme" id="dateCarousel">

                    <!-- Dates will be dynamically inserted -->

                </div>



                <!-- Time Slots -->

                <div class="row">

                    <div class="nav nav-tabs mb-2 mt-4 col-sm-12" id="nav-tab" role="tablist" style="justify-content: space-around;">

                        <button class="nav-link active text-primary" data-period="morning" type="button"><i

                                class="fa-solid fa-sun"></i> Morning</button>

                        <button class="nav-link text-primary" data-period="afternoon" type="button"><i

                                class="fa-solid fa-cloud-sun"></i> After Noon</button>

                        <button class="nav-link text-primary" data-period="evening" type="button"><i

                                class="fa-solid fa-cloud-moon"></i> Evening</button>

                    </div>



                    <div class="scroll-area py-3">

                        <div class="d-flex flex-wrap gap-2 justify-content-start">

                            <!-- Time slots will be rendered here -->

                        </div>

                    </div>

                </div>



                <!-- Schedule Button -->

                <div class="mt-4">

                    <input type="hidden" name="booking_schedule_for" id="booking_schedule_for">

                    <input type="hidden" name="booking_scheduler_id" id="booking_scheduler_id">

                    <input type="hidden" name="booking_date" id="booking_date">

                    <input type="hidden" name="booking_time" id="booking_time">

                    <input type="hidden" name="price" id="price">



                </div>





                <div class="text-muted text-center mt-2" style="font-size: 0.85rem;">

                    *Free chat follow-up for up to 7 days post consultation

                </div>







        </div>



    </div>



    <div class="my-4 px-4">

        <button type="submit" class="btn schedule-btn disabled" id="scheduleBtn">Schedule

            Appointment</button>

    </div>

    </form>



</div>


<!-- filter start -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="filteroffcanvas">

    </div>
</div>
<!-- filter end -->


<!-- consult now end -->

@endsection



@section('js')

<script>
    function moveFilterToOffcanvas() {

        const mainFilter = document.getElementById("mainFilter");
        const filterOffcanvas = document.getElementById("filteroffcanvas");

        if (!mainFilter || !filterOffcanvas) return;

        // if small screen → move inside offcanvas
        if (window.innerWidth <= 992) {
            if (mainFilter.children.length > 0) {
                filterOffcanvas.append(...mainFilter.childNodes); // CUT + PASTE
            }
        }
        // if large screen → move back to mainFilter
        else {
            if (filterOffcanvas.children.length > 0) {
                mainFilter.append(...filterOffcanvas.childNodes); // REVERT
            }
        }
    }

    // call on load + on resize
    window.addEventListener("load", moveFilterToOffcanvas);
    window.addEventListener("resize", moveFilterToOffcanvas);
</script>


<script>
    $(document).ready(function() {

        $('#appointmentForm').on('submit', function(e) {

            if (!isLoggedIn) {

                e.preventDefault();

                $('#popup-banner').modal('show');

            }

        });

    });



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

        // Initialize slider

        if ($(".price-range").length) {

            $(".price-range").slider({

                range: true,

                min: 0,

                max: 10000,

                values: [0, 5000],

                slide: function(event, ui) {

                    $("#price-amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);

                    $("#min_price").val(ui.values[0]);

                    $("#max_price").val(ui.values[1]);

                },

                change: function() {

                    fetchData(); // Trigger AJAX on change

                }

            });



            $("#price-amount").val("₹" + $(".price-range").slider("values", 0) + " - ₹" + $(".price-range")

                .slider("values", 1));

            $("#min_price").val($(".price-range").slider("values", 0));

            $("#max_price").val($(".price-range").slider("values", 1));

        }



        // AJAX filter

        function fetchData(page = 1) {

            let data = {

                search: $('#search').val(),

                sort_by: $('#sort_by').val(),

                type: $('input[name="type[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                speciality: $('input[name="speciality[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                rating: $('input[name="rating[]"]:checked').map(function() {

                    return this.value;

                }).get(),

                min_price: $('#min_price').val(),

                max_price: $('#max_price').val(),

                page: page

            };



            $.ajax({

                url: `?page=${page}`,

                method: 'GET',

                data: data,

                success: function(response) {

                    $('#doctor-list').html(response);

                },

                error: function(xhr) {

                    console.log(xhr);

                }

            });

        }



        $(document).on('change keyup',

            '#search, #sort_by, input[name="type[]"], input[name="speciality[]"], input[name="rating[]"]',

            function() {

                fetchData();

            });



        $(document).on('click', '.pagination a', function(e) {

            e.preventDefault();

            let page = $(this).attr('href').split('page=')[1];

            fetchData(page);

        });

    });
</script>

<script>
    $(document).on('click', '.consult-btn', function() {

        const doctorName = $(this).data('name');

        const doctorImage = $(this).data('image');

        const doctorPrice = $(this).data('price');

        const schedulerId = $(this).data('scheduler_id');



        // Set values in the offcanvas

        $('#offcanvasRight .offcanvas-title').text('Schedule Appointment');

        $('#price').val(doctorPrice);

        $('#offcanvasRight #doctor-image').attr('src', doctorImage);

        $('#doctor-name').text(doctorName);

        $('#offcanvasRight .fw-bold:last').text('₹' + doctorPrice);



        // Also update radio buttons with correct scheduler_id

        $('#offcanvasRight input[name="schedule_for"]').each(function() {

            $(this).attr('data-scheduler_id', schedulerId);

        });



        // Clear previous selections

        selectedType = null;

        selectedDate = null;

        selectedTime = null;

        $('#scheduleBtn').addClass('disabled');

        $('#dateCarousel').trigger('destroy.owl.carousel').html('');

        $('.scroll-area > .d-flex').html('');

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

        $(document).on('change', 'input[name="schedule_for"]', function() {

            selectedType = $(this).val();

            schedulerId = $(this).data('scheduler_id');

            $('#booking_schedule_for').val(selectedType);

            selectedDate = null;

            selectedTime = null;

            $('#scheduleBtn').addClass('disabled');

            console.log(selectedType);

            console.log(schedulerId);

            $.ajax({

                url: "{{ route('doctor.schedule.dates') }}",

                type: 'POST',

                data: {

                    scheduling_for: selectedType,

                    scheduler_id: schedulerId,

                },

                success: function(data) {

                    console.log(data);

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

@endsection