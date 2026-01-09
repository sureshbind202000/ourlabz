<form action="{{route('doctor.checkout')}}" method="POST" class="py-5 px-4 rounded-2 border consult">

    @csrf

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="mb-0">Digital Consult</h5>

            <small class="text-muted">Available in 7 mins</small>

        </div>

        <div class="fw-bold">₹{{ $doctor->doctor_details?->price ?? 0 }}</div>

    </div>



    <div class="row mb-4">

        <div class="col-6 p-0">

            <input type="radio" class="form-check-input me-1" name="schedule_for" id="online_schedule" value="2" data-scheduler_id="{{$doctor->user_id}}">

            <label for="online_schedule">Online Consult</label>

        </div>

        <div class="col-6">

            <input type="radio" class="form-check-input me-1" name="schedule_for" id="offline_schedule" value="1" data-scheduler_id="{{$doctor->user_id}}">

            <label for="offline_schedule">Visit Doctor</label>

        </div>

    </div>



    <!-- Date Carousel -->

    <div class="owl-carousel owl-theme" id="dateCarousel">

        <!-- Dates will be dynamically inserted -->

    </div>



    <!-- Time Slots -->

    <div class="row">

        <div class="nav nav-tabs mb-2 mt-4 col-sm-12" id="nav-tab" role="tablist"  style="justify-content: space-around;">

            <button class="nav-link active text-primary" data-period="morning" type="button"><i class="fa-solid fa-sun"></i> Morning</button>

            <button class="nav-link text-primary" data-period="afternoon" type="button"><i class="fa-solid fa-cloud-sun"></i> After Noon</button>

            <button class="nav-link text-primary" data-period="evening" type="button"><i class="fa-solid fa-cloud-moon"></i> Evening</button>

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

        <input type="hidden" name="price" id="price" value="{{ $doctor->doctor_details?->price ?? 0 }}">

        <button type="submit" class="btn schedule-btn disabled user-login-trigger" id="scheduleBtn">Schedule

            Appointment</button>

    </div>



    <div class="text-muted text-center mt-2" style="font-size: 0.85rem;">

        *Free chat follow-up for up to 7 days post consultation

    </div>

</form>