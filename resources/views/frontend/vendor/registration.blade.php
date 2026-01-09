@extends('frontend.includes.layout')



@section('css')



<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



<style>

    /* Body & Container */

    .doctor-reg-image {

        /* object-fit: cover; */

        height: 100%;

        width: 100%;



    }



    .billing-container {



        background: #ffffff;



        /* max-width: 700px; */



        width: 100%;



        border-radius: 18px;



        padding: 40px 50px 50px;



        transition: box-shadow 0.3s ease;



    }







    /* Headings */



    h2 {



        color: #0095d9;



        /* font-weight: 700; */



        letter-spacing: 0.05em;



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



        letter-spacing: 0.03em;



        /* text-shadow: 0 1px 1px rgba(0, 0, 0, 0.07); */



    }







    /* Input Group & Icons */







    .input-group-text:hover {



        background-color: #b3d8fa;



    }







    /* Inputs */



    input.form-control,



    select.form-control {



        /* height: 3rem; */



        border: 1.5px solid #66b7e6;



        /* lighter blue */



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



        /* box-shadow: 0 0 8px 2px rgba(51, 153, 255, 0.4); */



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



        display: flex;



        justify-content: space-between;



        list-style-type: none;



        counter-reset: step;



        padding: 0;



        position: relative;



    }







    #progressbar li {



        text-align: center;



        position: relative;



        flex: 1;



        font-size: 15px;



        font-weight: 400;



        color: lightgray;



    }







    #progressbar li:before {



        content: counter(step);



        counter-increment: step;



        width: 50px;



        height: 50px;



        line-height: 50px;



        display: block;



        margin: 0 auto 10px auto;



        border-radius: 50%;



        background: lightgray;



        color: white;



        font-size: 20px;



        position: relative;



        z-index: 1;



    }







    #progressbar li:after {



        content: '';



        position: absolute;



        width: 100%;



        height: 2px;



        background: lightgray;



        top: 25px;



        left: -50%;



        z-index: 0;



    }



    #progressbar #address::before {



        font-family: FontAwesome;



        content: "\f041";



    }



    #progressbar #contact::before {



        font-family: FontAwesome;



        content: "\f095";



    }



    #progressbar #login::before {



        font-family: FontAwesome;



        content: "\f007";



    }



    #progressbar li:first-child:after {



        content: none;



    }







    #progressbar li.active {



        color: #0095d9;



    }







    #progressbar li.active:before {



        background: #0095d9;



    }







    #progressbar li.active+li:after {



        background: #0095d9;



    }

</style>



@endsection



@section('content')







<main class="main">



    <!-- shop checkout -->



    <div class="shop-checkout">



        <div class="container-fluid">



            <div class="row">



                <div class="d-none d-lg-block  col-lg-6 p-0">



                    <img src="{{asset('assets/img/vendor/vendor_reg.png')}}" alt="" class="doctor-reg-image">



                </div>



                <div class="col-sm-12 col-lg-6 border-start bg-white">



                    <div class="billing-container p-4">



                        <h2 class="text-center pb-3"><strong class="text-dark">Vendor</strong> <span class="text-primary">Registration Form</span></h2>



                        <hr>



                        <form id="msform" class="">



                            <!-- progressbar -->



                            <ul id="progressbar">



                                <li class="active" id="personal"><strong>Personal Details</strong></li>



                                <li id="address"><strong>Address</strong></li>



                                <li id="contact"><strong>Contact Info</strong></li>



                                <li id="login"><strong>Login</strong></li>



                            </ul>







                            <!-- fieldsets -->



                            <fieldset class="pb-0">



                                <div class="form-card">



                                    <!-- 1. Personal Details -->



                                    <h4>Personal Details</h4>



                                    <div class="row">



                                        <div class="mb-4 col-md-6">



                                            <label for="compName">Company Name</label>



                                            <div class="input-group">



                                                <input type="text" name="company_name" class="form-control shadow-none" id="compName"



                                                    placeholder="Company Name" required />



                                            </div>



                                        </div>











                                        <div class="mb-4 col-md-6">



                                            <label for="b_type">Business Type</label>



                                            <div class="input-group">







                                                <select class="form-control shadow-none" name="business_type" id="b_type" required>



                                                    <option value="" disabled selected>Select Business Type</option>



                                                    <option value="Manufacturer">Manufacturer</option>



                                                    <option value="Distributor">Distributor</option>



                                                    <option value="Reseller">Reseller</option>



                                                </select>



                                            </div>



                                        </div>







                                        <div class="mb-4 col-md-6">



                                            <label for="Establishment">Year of Establishment</label>



                                            <div class="input-group">



                                                <input type="date" name="establishment_year" class="form-control shadow-none" id="Establishment"



                                                    placeholder="Year of Establishment" required />



                                            </div>



                                        </div>



                                        <div class="mb-4 col-md-6">



                                            <label for="Registration_no">Company Registration Number</label>



                                            <div class="input-group">



                                                <input type="text" name="company_reg_no" class="form-control shadow-none" id="Registration_no"



                                                    placeholder="Company Registration Number" required />



                                            </div>



                                        </div>



                                        <div class="mb-4 col-md-12">



                                            <label for="Tax_Identification">Tax Identification Number <small>(GST/VAT/PAN etc.)</small></label>



                                            <div class="input-group">



                                                <input type="text" name="tin" class="form-control shadow-none" id="Tax_Identification"



                                                    placeholder="Tax Identification Number" required />



                                            </div>



                                        </div>







                                        <div class="mb-4 col-md-6">



                                            <label for="logo">Company Logo </label>



                                            <div class="input-group">



                                                <div id="profilePhoto" class="dropzone w-100"></div>



                                            </div>



                                        </div>



                                    </div>







                                </div>



                                <input type="button" name="next" class="next action-button theme-btn" value="Next" />



                            </fieldset>



                            <fieldset class="pb-0">



                                <div class="form-card">



                                    <!-- 2. Contact Information -->



                                    <h4>Address </h4>



                                    <div class="row">

                                        <div class="mb-4 col-md-12">



                                            <label for="head_address" class="form-label">Address</label>



                                            <div class="input-group">



                                                <input type="text" id="head_address" name="address" class="form-control shadow-none" placeholder="Address" required />



                                            </div>



                                        </div>









                                        <div class="mb-4 col-md-6">



                                            <label for="head_city" class="form-label">City</label>



                                            <div class="input-group">



                                                <input type="text" id="head_city" name="city" class="form-control shadow-none" placeholder="City" required />



                                            </div>



                                        </div>







                                        <div class="mb-4 col-md-6">



                                            <label for="head_state" class="form-label">State</label>



                                            <div class="input-group">



                                                <input type="text" id="head_state" name="state" class="form-control shadow-none" placeholder="State" required />



                                            </div>



                                        </div>



                                        <div class="mb-4 col-md-6">



                                            <label for="country_origin" class="form-label fw-bold">Country</label>



                                            <select id="country_origin" name="country" class="form-select form-control" required>



                                                <option value="">Select Country</option>



                                                <option value="Afghanistan">Afghanistan</option>



                                                <option value="Albania">Albania</option>



                                                <option value="Algeria">Algeria</option>



                                                <option value="Andorra">Andorra</option>



                                                <option value="Angola">Angola</option>



                                                <option value="Argentina">Argentina</option>



                                                <option value="Australia">Australia</option>



                                                <option value="Austria">Austria</option>



                                                <option value="Bangladesh">Bangladesh</option>



                                                <option value="Belgium">Belgium</option>



                                                <option value="Brazil">Brazil</option>



                                                <option value="Canada">Canada</option>



                                                <option value="China">China</option>



                                                <option value="Denmark">Denmark</option>



                                                <option value="Egypt">Egypt</option>



                                                <option value="Finland">Finland</option>



                                                <option value="France">France</option>



                                                <option value="Germany">Germany</option>



                                                <option value="India">India</option>



                                                <option value="Indonesia">Indonesia</option>



                                                <option value="Italy">Italy</option>



                                                <option value="Japan">Japan</option>



                                                <option value="Mexico">Mexico</option>



                                                <option value="Netherlands">Netherlands</option>



                                                <option value="New Zealand">New Zealand</option>



                                                <option value="Pakistan">Pakistan</option>



                                                <option value="Russia">Russia</option>



                                                <option value="Saudi Arabia">Saudi Arabia</option>



                                                <option value="Singapore">Singapore</option>



                                                <option value="South Africa">South Africa</option>



                                                <option value="Spain">Spain</option>



                                                <option value="Sweden">Sweden</option>



                                                <option value="Switzerland">Switzerland</option>



                                                <option value="Thailand">Thailand</option>



                                                <option value="Turkey">Turkey</option>



                                                <option value="UAE">United Arab Emirates</option>



                                                <option value="UK">United Kingdom</option>



                                                <option value="USA">United States</option>



                                            </select>



                                        </div>



                                        <div class="mb-4 col-md-6">



                                            <label for="head_zip" class="form-label">Zip Code</label>



                                            <div class="input-group">



                                                <input type="text" id="head_zip" name="pin" class="form-control shadow-none" placeholder="Zip Code" required />



                                            </div>



                                        </div>



                                    </div>



                                </div> <input type="button" name="next" class="next action-button theme-btn"



                                    value="Next" /> <input type="button" name="previous"



                                    class="previous action-button-previous theme-btn theme-btn2" value="Previous" />



                            </fieldset>



                            <fieldset class="pb-0">



                                <div class="form-card">







                                    <h4>Contact Details</h4>



                                    <div class="row">



                                        <div class="mb-4 col-md-6">



                                            <label for="username">Primary Contact Person Name</label>



                                            <div class="input-group">



                                                <input type="text" name="name" class="form-control shadow-none" id="username"



                                                    placeholder="Person Name" required />



                                            </div>



                                        </div>







                                        <div class="mb-4 col-md-6">



                                            <label for="Designation">Designation</label>



                                            <div class="input-group">



                                                <input type="text" name="designation" class="form-control shadow-none" id="Designation"



                                                    placeholder="Secure Designation" required />



                                            </div>



                                        </div>



                                        <div class="mb-4 col-md-6">



                                            <label for="mobileNumber">Phone</label>



                                            <div class="input-group">



                                                <input type="tel" name="phone" class="form-control shadow-none" id="mobileNumber"



                                                    placeholder="+91 9876543210" required />



                                            </div>



                                        </div>

                                        <div class="mb-4 col-md-6">



                                            <label for="altmobileNumber">Alternate Phone No</label>



                                            <div class="input-group">



                                                <input type="tel" name="alternate_phone" class="form-control shadow-none" id="altmobileNumber"



                                                    placeholder="+1 234 567 890" />



                                            </div>



                                        </div>



                                        <div class="mb-4 col-md-6">



                                            <label for="emailAddress">Email </label>



                                            <div class="input-group">







                                                <input type="email" name="email" class="form-control shadow-none" id="emailAddress"



                                                    placeholder="email@example.com" required />



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



                                    </div>



                                </div>



                                <input type="button" name="next" class="next action-button theme-btn"



                                    value="Next" />



                                <input type="button" name="previous" class="previous action-button-previous theme-btn theme-btn2" value="Previous" />



                            </fieldset>



                            <fieldset class="pb-0">



                                <div class="form-card">



                                    <!-- 4. Login & Account Setup -->



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



                                <input type="submit" class=" action-button theme-btn" value="Submit" />



                                <input type="button" name="previous" class="previous action-button-previous theme-btn theme-btn2" value="Previous" />



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

                    console.log(response);

                    Swal.close();

                    const phone = $("input[name='phone']").val() || "";

                    const email = $("input[name='email']").val() || "";



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

                        url: "{{ route('vendor.store.registration') }}",

                        method: "POST",

                        data: tempFormData,

                        processData: false,

                        contentType: false,

                        success: function(response) {

                            Swal.close();

                            Toast.fire({

                                icon: 'success',

                                title: 'Vendor registered successfully!'

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

                            console.log(xhr);

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

                    console.log(xhr);

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