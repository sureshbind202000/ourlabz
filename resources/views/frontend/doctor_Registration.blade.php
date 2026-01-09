@extends('frontend.includes.layout')

@section('css')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .doctor-reg-image {
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

    h2 {

        color: #0095d9;

        /* letter-spacing: 0.05em; */

        margin-bottom: 15px;

        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);

    }



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

    .input-group-text {

        background-color: #cce7fb;

        /* lighter blue */

        color: #0095d9;

        border: 1.5px solid #0095d9;

        /* softer blue */

        border-radius: 0.6rem 0 0 0.6rem;

        min-width: 48px;

        justify-content: center;

        font-size: 1.2rem;

        box-shadow: 0 0 6px rgba(102, 183, 230, 0.15);

        transition: background-color 0.3s ease;

    }



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



    /* Checkbox */

    .form-check-label a {

        color: #0095d9;

        font-weight: 600;

        text-decoration: none;

        transition: color 0.3s ease;

    }



    .form-check-label a:hover {

        color: #007acc;

        text-decoration: underline;

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

        content: "\f007";

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

            <div class="row form ">

                <div class="d-none d-md-block  col-md-6 ps-0">



                    <img src="{{asset('assets/img/doctor/doc_reg.png')}}" alt="" class="doctor-reg-image">

                </div>

                <div class="col-sm-12 col-md-6 bg-white">

                    <div class="billing-container p-4">

                        <h2 class="text-center py-1 "><strong class="text-dark">Doctor</strong> <span class="text-primary">Registration Form</span></h2>

                        <hr class="pb-3">



                        <form id="msform" class="" novalidate>

                            <!-- progressbar -->

                            <ul id="progressbar">

                                <li class="active " id="personal"><strong>Personal</strong></li>

                                <li id="contact-info"><strong>Contact</strong></li>

                                <li id="login"><strong>Login</strong></li>

                            </ul>



                            <!-- fieldsets -->

                            <fieldset class="pb-0">

                                <div class="form-card">

                                    <!-- 1. Personal Details -->

                                    <h4>Personal Details</h4>

                                    <div class="row">

                                        <div class="mb-4 col-md-12">

                                            <label for="name">Full Name</label>

                                            <div class="input-group">



                                                <input type="text" class="form-control shadow-none" id="name" name="name"

                                                    placeholder="Full Name" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="gender">Gender</label>

                                            <div class="input-group">



                                                <select class="form-control shadow-none" id="gender" name="gender" required>

                                                    <option value="" disabled selected>Select Gender</option>

                                                    <option>Male</option>

                                                    <option>Female</option>

                                                    <option>Other</option>

                                                </select>

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="dob">Date of Birth</label>

                                            <div class="input-group">



                                                <input type="date" name="date_of_birth" class="form-control shadow-none" id="dob" required />
                                                <input type="hidden" name="age" id="age">
                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-12">

                                            <label>Profile Photo</label>

                                            <div class="input-group">



                                                <div id="profilePhoto" class="dropzone"></div>

                                            </div>

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

                                        <div class="mb-4 col-md-12">

                                            <label for="emailAddress">Email Address</label>

                                            <div class="input-group">



                                                <input type="email" name="email" class="form-control shadow-none" id="emailAddress"

                                                    placeholder="email@example.com" required />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">

                                            <label for="phoneNumber">Phone Number</label>

                                            <div class="input-group">



                                                <input type="tel" name="phone" class="form-control shadow-none" id="phoneNumber"

                                                    placeholder="+919876543210" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-6">

                                            <label for="alternateNumber">Alternate Phone Number</label>

                                            <div class="input-group">



                                                <input type="tel" name="alternate_phone" class="form-control shadow-none" id="alternateNumber"

                                                    placeholder="+1 987 654 321" />

                                            </div>

                                        </div>







                                        <div class="mb-4 col-md-6">

                                            <label for="emergencyContactname">Emergency Contact Name</label>

                                            <div class="input-group">



                                                <input type="text" name="emergency_contact_name" class="form-control shadow-none"

                                                    id="emergencyContactname" placeholder="Name" required />

                                            </div>

                                        </div>

                                        <div class="mb-4 col-md-6">

                                            <label for="emergencyContact">Emergency Contact Number</label>

                                            <div class="input-group">



                                                <input type="number" name="emergency_contact_phone" class="form-control shadow-none"

                                                    id="emergencyContact" placeholder=" +1 111 222 3333" required />

                                            </div>

                                        </div>

                                    </div>

                                </div> <input type="button" name="next" class="next action-button theme-btn"

                                    value="Next" /> <input type="button" name="previous"

                                    class="previous action-button-previous theme-btn theme-btn2" value="Previous" />

                            </fieldset>

                            <fieldset class="pb-0">

                                <div class="form-card">

                                    <!-- 3. Login & Account Setup -->

                                    <h4>Login & Account Setup</h4>

                                    <div class="row">

                                        <div class="mb-4 col-md-12">

                                            <label for="username">Username</label>

                                            <div class="input-group">



                                                <input type="text" name="username" class="form-control shadow-none" id="username"

                                                    placeholder="Alphanumeric Username" pattern="[A-Za-z0-9]+" required />

                                            </div>

                                        </div>



                                        <div class="mb-4 col-md-12">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control shadow-none" id="password"
                                                    placeholder="Secure Password" required />
                                                <button class="btn btn-outline-primary toggle-password" type="button">
                                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                                </button>
                                            </div>
                                        </div>



                                        <div class="mb-3 col-12">

                                            <div class="form-check">

                                                <input class="form-check-input shadow-none" name="terms_condition" type="checkbox"

                                                    id="consentTerms" required>

                                                <label class="form-check-label" for="consentTerms">

                                                    I agree to the <a href="#">Terms & Conditions</a>

                                                </label>

                                            </div>

                                        </div>



                                        <div class="mb-4 col-12">

                                            <div class="form-check">

                                                <input class="form-check-input shadow-none" type="checkbox"

                                                    id="subscribeUpdates" name="subscribe">

                                                <label class="form-check-label" for="subscribeUpdates">

                                                    Subscribe to notifications & updates

                                                </label>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <input type="submit" class="submit  action-button theme-btn" value="Submit" />

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

        // Age Calculator
        $('#dob').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();

            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            $('#age').val(age >= 0 ? age : '');
        });

    });
</script>


<script>
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        // Dropzone File Uploader
        const profilePhotoDropzone = new Dropzone("#profilePhoto", {

            url: "/do-not-upload",
            autoProcessQueue: false,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictDefaultMessage: "Click or drag a file here",
            init: function() {
                this.on("addedfile", function(file) {});
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            }

        });

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

                    return false; // Stop checking after first invalid field
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            if (!isValid) return; // Do not proceed to next step

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

            if (profilePhotoDropzone.files.length > 0) {
                formData.append("profile", profilePhotoDropzone.files[0]);
            }

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

            var email = $("input[name='email']").val(); // grab from form
            var phone = $("input[name='phone']").val(); // grab from form

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
                        url: "{{ route('doctor.store.registration') }}",
                        method: "POST",
                        data: tempFormData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.close();
                            Toast.fire({
                                icon: 'success',
                                title: 'Doctor registered successfully!'
                            });
                            $('#msform').trigger('reset');
                            if (profilePhotoDropzone) {
                                profilePhotoDropzone.removeAllFiles(true);
                            }
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