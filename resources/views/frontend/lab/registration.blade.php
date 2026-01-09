@extends('frontend.includes.layout')

@section('css')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .choices__inner {
        background-color: #ffffff !important;
        border: 1px solid #0095d9 !important;
    }

    .lab-reg-image {
        object-fit: cover;
        height: 100%;
        width: 100%;

    }

    /* Body & Container */

    .billing-container {

        width: 100%;

        border-radius: 18px;

        transition: box-shadow 0.3s ease;

    }



    /* Headings */





    h4 {

        color: #125371;

        margin-bottom: 15px;

    }



    /* Labels */

    label {

        /* font-weight: 600; */

        margin-bottom: 6px;

        display: block;

        color: #000000;

        /* letter-spacing: 0.03em; */

        /* text-shadow: 0 1px 1px rgba(0, 0, 0, 0.07); */

    }



    /* Input Group & Icons */



    .input-group-text:hover {

        background-color: #b3d8fa;

    }



    /* Inputs */

    input.form-control,

    select.form-control {
        border: 1.5px solid #66b7e6;
        font-size: 1rem;
        font-weight: 500;
        color: #003f70;
        box-shadow: inset 0 2px 4px rgba(102, 183, 230, 0.07);
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }



    input.form-control::placeholder {

        color: #6a8dbd;

        font-weight: 400;

        letter-spacing: 0.01em;

    }



    input.form-control:focus {

        border-color: #3399ff;

        box-shadow: 0 0 8px 2px rgba(51, 153, 255, 0.4);

        outline: none;

        z-index: 0 !important;

    }



    /* Expiry & CVV inputs spacing */

    .expiry-cvv-group>div {

        flex: 1;

    }



    /* Amount input icon override for padding */

    #amount~.input-group-text {

        padding-left: 0.6rem;

        padding-right: 0.6rem;

    }


    /* Pay Button */

    .pay-button {

        background: linear-gradient(135deg, #0095d9, #007acc);

        border: none;

        font-weight: 700;

        font-size: 1.2rem;

        padding: 10px;

        border-radius: 12px;

        color: #fff;

        /* box-shadow: 0 8px 15px rgba(0, 149, 217, 0.35); */

        transition: all 0.3s ease;

        width: 100%;

    }



    .pay-button:hover {

        background: linear-gradient(135deg, #007acc, #005f9e);

        /* box-shadow: 0 12px 25px rgba(0, 118, 184, 0.6); */

        /* transform: scale(1.05); */

        cursor: pointer;

    }





    /* Responsive tweaks */

    @media (max-width: 575.98px) {

        .billing-container {

            padding: 30px 25px;

        }



        .expiry-cvv-group {

            flex-direction: column;

            gap: 15px;

        }



        .expiry-cvv-group>div {

            width: 100%;

        }

    }

    #progressbar {

        margin-bottom: 30px;

        color: lightgrey;
        text-align: center;

        overflow: hidden;

    }

    #progressbar #personal:before {

        font-family: FontAwesome;

        content: "\f0f7";

        text-align: center;

    }

    #progressbar #login:before {

        font-family: FontAwesome;

        content: "\f007";

        text-align: center;



    }

    #progressbar #contact-info:before {

        font-family: FontAwesome;

        content: "\f124";

        text-align: center;

    }

    #progressbar li:before {

        position: relative;

        width: 50px;

        height: 50px;

        line-height: 45px;

        display: block;

        font-size: 20px;

        color: #ffffff;

        background: lightgray;

        border-radius: 50%;

        margin: 0 auto 10px auto;

        padding: 2px;

        z-index: 1;

    }


    #progressbar li:after {

        content: '';

        width: 100%;

        height: 2px;

        background: lightgray;

        position: absolute;

        left: 0;

        top: 25px;

        z-index: 0;

    }
</style>

@endsection

@section('content')



<main class="main">

    <!-- shop checkout -->





    <div class="shop-checkout">

        <div class="container-fluid">

            <div class="row shadow forms rounded-5">

                <div class="d-none d-md-block  col-md-6 p-0">



                    <img src="{{asset('assets/img/lab/lab_reg.png')}}" alt="" class="lab-reg-image">

                </div>

                <div class="col-sm-12 col-lg-6 border-start bg-white">

                    <div class="billing-container p-4">

                        <h2 class="text-center pb-3"><strong class="text-dark">Lab</strong> <span class="text-primary">Registration Form</span></h2>

                        <hr>

                        <form id="msform">

                            <!-- progressbar -->

                            <ul id="progressbar">

                                <li class="active" id="personal" style="text-align: center;"><strong>Lab</strong></li>

                                <li id="location" style="text-align: center;"><strong>Contact</strong></li>

                                <li id="login" style="text-align: center;"><strong>Login</strong></li>

                            </ul>

                            <!-- fieldsets -->

                            <fieldset class="pb-0">

                                <div class="form-card"> 

                                    <!-- 1. Lab Details -->

                                    <h4>Lab Details</h4>

                                    <div class="row">

                                        <div class="mb-4 col-md-6">

                                            <label for="labName">Lab Name</label>

                                            <div class="input-group">

                                                <input type="text" name="lab_name" class="form-control shadow-none" id="labName" placeholder="Enter lab name" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="labRegNumber">Lab Registration Number</label>

                                            <div class="input-group">



                                                <input type="text" name="lab_registration_no" class="form-control shadow-none" id="labRegNumber" placeholder="Enter lab reg. no." required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="accreditation">Accreditation Details (Optional)</label>

                                            <div class="input-group">



                                                <input type="file" name="accreditation_details" class="form-control shadow-none" id="accreditation" placeholder="e.g., ISO 9001, NABL" />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">

                                            <label for="yearEstablished">Year of Establishment</label>

                                            <div class="input-group">



                                                <input type="date" name="year_of_establishment" class="form-control shadow-none" id="yearEstablished" required />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-12">
                                            <label for="lab_type">Lab Facilities</label>
                                            <select class="form-control shadow-none multi-select w-100" name="lab_type[]" id="lab_type" multiple required>

                                                <option value="" disabled>--Select--</option>

                                                @foreach($facilities as $facility)
                                                    <option value="{{$facility->facility}}">{{$facility->facility}}</option>
                                                    @endforeach

                                            </select>
                                        </div>





                                    </div>

                                </div>

                                <input type="button" name="next" class="next action-button theme-btn" value="Next" />

                            </fieldset>

                            <fieldset class="pb-0">

                                <div class="form-card">

                                    <!-- 2. Contact Information -->

                                    <h4>Contact Information</h4>

                                    <div class="row">

                                        <div class="mb-4 col-md-6">

                                            <label for="contactName">Primary Contact Name</label>

                                            <div class="input-group">

                                                <input type="text" name="primary_contact_name" class="form-control shadow-none" id="contactName" placeholder="Enter primary contact name" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="contactPhone">Phone Number</label>

                                            <div class="input-group">

                                                <input type="tel" name="phone" class="form-control shadow-none" id="contactPhone" placeholder="+91 xxx xxx xxxx" pattern="^\+?[0-9\s\-]+$" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="contactEmail">Email Address</label>

                                            <div class="input-group">

                                                <input type="email" name="email" class="form-control shadow-none" id="contactEmail" placeholder="email@example.com" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="website">Website (if any)</label>

                                            <div class="input-group">

                                                <input type="url" name="website_url" class="form-control shadow-none" id="website" placeholder="https://www.example.com" />

                                            </div>

                                        </div>

                                    </div>

                                </div> <input type="button" name="next" class="next action-button theme-btn"

                                    value="Next" /> <input type="button" name="previous"

                                    class="previous action-button-previous theme-btn theme-btn2" value="Previous" />

                            </fieldset>

                            <fieldset class="pb-0">

                                <div class="form-card">

                                    <!-- Admin Credentials -->

                                    <h4>Login Details</h4>

                                    <div class="row">

                                        <div class="mb-4 col-md-6">

                                            <label for="adminName">Admin Name</label>

                                            <div class="input-group">

                                                <input type="text" name="name" class="form-control shadow-none" id="adminName" placeholder="Enter admin name" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="username">Username</label>

                                            <div class="input-group">

                                                <input type="text" name="lab_username" class="form-control shadow-none" id="username" placeholder="Enter Username" required />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">

                                            <label for="gender">Gender</label>

                                            <div class="input-group">



                                                <select class="form-control shadow-none" id="gender" name="gender" required="">

                                                    <option value="" disabled="" selected="">Select Gender</option>

                                                    <option>Male</option>

                                                    <option>Female</option>

                                                    <option>Other</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control shadow-none" id="password" placeholder="Secure Password" required="">
                                                <button class="btn btn-outline-primary toggle-password" type="button">
                                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <input type="submit" class="action-button theme-btn" value="Submit" />

                                <input type="button" name="previous"

                                    class="previous action-button-previous theme-btn theme-btn2" value="Previous" />

                            </fieldset>

                        </form>





                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- shop checkout end -->



</main>





<!-- address form  -->

@endsection

@section('js')

<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            const passwordInput = $('#password');
            const icon = $('#togglePasswordIcon');

            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);

            // Toggle the icon class
            icon.toggleClass('bi-eye');
            icon.toggleClass('bi-eye-slash');
        });

    });
</script>


<script>
    $(document).ready(function() {

        // Multistep From 
        let current_fs, next_fs, previous_fs;
        let current = 1;
        const steps = $("fieldset").length;

        setProgressBar(current);

        // SweetAlert2 toast setup
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // Next step with validation
        $(".next").click(function() {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            let isValid = true;

            // Validate required fields only in current step
            current_fs.find("input[required], select[required], textarea[required]").each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass("is-invalid");

                    const label = $(this).closest('div').find('label').text().trim() || 'Field';
                    Toast.fire({
                        icon: 'error',
                        title: `${label} is required`
                    });

                    return false;
                } else {
                    $(this).removeClass("is-invalid");
                }

            });
            
            if ($('#lab_type').val().length === 0) {
                isValid = false;
                $('#lab_type').addClass("is-invalid");
                Toast.fire({
                    icon: 'error',
                    title: `Please select at least one lab facility!`
                });
            }

            if (!isValid) return;


            // Proceed to next step
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();

            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    let opacity = 1 - now;
                    current_fs.css({
                        display: 'none',
                        position: 'relative'
                    });
                    next_fs.css({
                        opacity: opacity
                    });
                },
                duration: 500,
                complete: function() {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 600, "swing");
                }
            });

            setProgressBar(++current);
        });

        // Previous step
        $(".previous").click(function() {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            previous_fs.show();

            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    let opacity = 1 - now;
                    current_fs.css({
                        display: 'none',
                        position: 'relative'
                    });
                    previous_fs.css({
                        opacity: opacity
                    });
                },
                duration: 500,
                complete: function() {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 600, "swing");
                }
            });

            setProgressBar(--current);
        });

        // Update progress bar
        function setProgressBar(curStep) {
            let percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar").css("width", percent + "%");
        }

        // Form submit with final validation
        let tempFormData = null;

        $("#msform").on("submit", function(e) {
            e.preventDefault();

            let isValid = true;
            const form = $(this);

            // Clear previous errors
            form.find(".is-invalid").removeClass("is-invalid");

            // Manual Validation
            form.find("input[required], select[required], textarea[required]").each(function() {
                const type = $(this).attr("type");
                const pattern = $(this).attr("pattern");
                const value = $(this).val();
                const label = $(this).closest("div").find("label").text().trim() || "Field";

                if (type === "checkbox" && !$(this).is(":checked")) {
                    isValid = false;
                    $(this).addClass("is-invalid");
                    Toast.fire({
                        icon: "error",
                        title: `${label} is required`
                    });
                    return false;
                }

                if (pattern && !new RegExp(pattern).test(value)) {
                    isValid = false;
                    $(this).addClass("is-invalid");
                    Toast.fire({
                        icon: "error",
                        title: `${label} format is invalid`
                    });
                    return false;
                }

                if (!value) {
                    isValid = false;
                    $(this).addClass("is-invalid");
                    Toast.fire({
                        icon: "error",
                        title: `${label} is required`
                    });
                    return false;
                }
            });

            if (!isValid) return;

            Swal.fire({
                title: "Sending OTP...",
                text: "Please wait while we send the OTP to your email and phone.",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let formData = new FormData(document.getElementById("msform"));

            // Save formData for final registration step
            tempFormData = formData;

            // Send OTP request
            $.ajax({
                url: "{{ route('send.otp') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close();
                    var phone = $("input[name='phone']").val() || "";
                    var email = $("input[name='email']").val() || "";

                    if (phone && email) {
                        maskPhoneAndEmail(phone, email);
                        $('#registrationOtpModal').modal('show');
                    } else {
                        Swal.close();
                        Toast.fire({
                            icon: 'error',
                            title: 'Phone or Email is missing, cannot proceed with OTP!'
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.close();
                    let errorMessage = "Failed to send OTP.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    Toast.fire({
                        icon: "error",
                        title: errorMessage
                    });
                }
            });
        });

        function maskPhoneAndEmail(phone, email) {
            // Mask phone (keep last 4 digits)
            const maskedPhone = phone.replace(/\d(?=\d{4})/g, 'x').replace(/(\d{3})(\d{3})(\d{4})/, 'xxx-xxx-$3');

            // Mask email
            const atIndex = email.indexOf("@");
            const emailName = email.substring(0, atIndex);
            const emailDomain = email.substring(atIndex);
            const maskedEmail = '*'.repeat(emailName.length - 2) + emailName.slice(-2) + emailDomain;

            // Insert into modal
            $(".info").text(`An OTP has been sent to ${maskedPhone} and ${maskedEmail}`);
        }

        $('#verifyRegistrationOtpBtn').on('click', function() {
            let otp = '';
            $('.otp__digit').each(function() {
                otp += $(this).val();
            });

            const email = $("input[name='email']").val(); // grab from form
            const phone = $("input[name='phone']").val(); // grab from form

            if (otp.length !== 6) {
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter all 6 digits of the OTP'
                });
                return;
            }

            Swal.fire({
                title: 'Verifying OTP...',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('verify.otp') }}", // Your OTP verification route
                method: "POST",
                data: {
                    otp: otp,
                    email: email,
                    phone: phone,
                },
                success: function() {
                    // Proceed with final registration
                    $.ajax({
                        url: "{{ route('lab.store.registration') }}",
                        method: "POST",
                        data: tempFormData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.close();
                            Toast.fire({
                                icon: 'success',
                                title: 'Lab registered successfully!'
                            });
                            $('#msform').trigger('reset');
                            $('.otp__digit').val('');
                            $('#registrationOtpModal').modal('hide');
                            window.location.href = "{{ route('dashboard') }}";
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMessage = "Registration failed!";
                            if (xhr.responseJSON?.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                            $('.otp__digit').val('');
                        }
                    });
                },
                error: function(xhr) {
                    Swal.close();
                    let errorMessage = "OTP verification failed!";
                    if (xhr.responseJSON?.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    Toast.fire({
                        icon: 'error',
                        title: errorMessage
                    });
                }
            });
        });



        // Remove invalid class on input
        $("input[required], select[required], textarea[required]").on("keyup change", function() {
            if ($(this).val()) {
                $(this).removeClass("is-invalid");
            }
        });
    });
</script>
@endsection