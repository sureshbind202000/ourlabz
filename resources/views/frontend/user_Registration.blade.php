@extends('frontend.includes.layout')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .main {
    background-image: url(assets/img/hero/bg.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    }

    /* Body & Container */
    .billing-container {
        background: #ffffff;
        /* max-width: 700px; */
        width: 100%;
        border-radius: 18px;
        box-shadow:
            0 8px 20px rgba(0, 149, 217, 0.12),
            0 4px 12px rgba(0, 149, 217, 0.15);
        padding: 40px 50px 50px;
        transition: box-shadow 0.3s ease;
    }

    .billing-container:hover {
        box-shadow:
            0 12px 32px rgba(0, 149, 217, 0.25),
            0 6px 18px rgba(0, 149, 217, 0.3);
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
        color: #005a9c;
        letter-spacing: 0.03em;
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
        /* height: 3rem; */
        border-radius: 0 0.6rem 0.6rem 0;
        border: 1.5px solid #66b7e6;
        /* lighter blue */
        font-size: 1rem;
        font-weight: 500;
        padding-left: 1rem;
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
#progressbar #location:before {
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
#progressbar #personal:before{
   margin: 0 auto 10px 0;
}
#progressbar #login:before{
   margin: 0 0 10px auto;
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
    <div class="shop-checkout py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
                    <div class="billing-container shadow">
                        <h2 class="text-center">User Registration Form</h2>
                        <hr>
                        <form id="msform" class="">
                           <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active " id="personal" style="text-align: start;"><strong>Personal Details</strong></li>
                                <li id="location" style="text-align: center;"><strong>Address</strong></li>
                                <li id="login" style="text-align: end;"><strong>Login</strong></li>
                            </ul>

                            <!-- fieldsets -->
                            <fieldset class="pb-0">
                                <div class="form-card">
                                    <!-- 1. Personal Details -->
                                    <h4>Personal Details</h4>
                                    <div class="row">
                                        <div class="mb-4 col-md-12">
                                            <label for="fullName">Full Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                                <input type="text" class="form-control shadow-none" id="fullName"
                                                    placeholder="Full Name" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="gender">Gender</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-gender-ambiguous"></i></span>
                                                <select class="form-control shadow-none" id="gender" required>
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
                                                <span class="input-group-text"><i
                                                        class="bi bi-calendar-event-fill"></i></span>
                                                <input type="date" class="form-control shadow-none" id="dob" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-12">
                                            <label for="profilePhoto">Profile Photo</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-image-fill"></i></span>
                                                <input type="file" class="form-control shadow-none form-control-lg"
                                                    id="profilePhoto" accept="image/*" required />
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
                                                <span class="input-group-text"><i
                                                        class="bi bi-envelope-at-fill"></i></span>
                                                <input type="email" class="form-control shadow-none" id="emailAddress"
                                                    placeholder="email@example.com" required />
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="mobileNumber">Mobile Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-phone-fill"></i></span>
                                                <input type="tel" class="form-control shadow-none" id="mobileNumber"
                                                    placeholder="+1 234 567 890" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="alternateNumber">Alternate Contact Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-telephone-plus-fill"></i></span>
                                                <input type="tel" class="form-control shadow-none" id="alternateNumber"
                                                    placeholder="+1 987 654 321" />
                                            </div>
                                        </div>



                                        <div class="mb-4 col-md-6">
                                            <label for="emergencyContact">Emergency Contact Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-exclamation-circle-fill"></i></span>
                                                <input type="text" class="form-control shadow-none"
                                                    id="emergencyContact" placeholder="Name" required />
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="emergencyContact">Emergency Contact Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-exclamation-circle-fill"></i></span>
                                                <input type="number" class="form-control shadow-none"
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
                                            <span class="input-group-text"><i
                                                    class="bi bi-person-badge-fill"></i></span>
                                            <input type="text" class="form-control shadow-none" id="username"
                                                placeholder="Alphanumeric Username" pattern="[a-zA-Z0-9]+" required />
                                        </div>
                                    </div>

                                    <div class="mb-4 col-md-12">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" class="form-control shadow-none" id="password"
                                                placeholder="Secure Password" required />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-12">
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox"
                                                id="consentTerms" required>
                                            <label class="form-check-label" for="consentTerms">
                                                I agree to the <a href="#">Terms & Conditions</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-4 col-12">
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox"
                                                id="subscribeUpdates">
                                            <label class="form-check-label" for="subscribeUpdates">
                                                Subscribe to notifications & updates
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <input type="submit" class="next action-button theme-btn" value="Submit" />
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
    $(document).ready(function () {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function () {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

           
            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function () {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }

        $(".submit").click(function () {
            return false;
        })

    });



$(".next").click(function () {
    let current_fs = $(this).parent();
    let next_fs = $(this).parent().next();

    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    next_fs.show();

    current_fs.animate(
        { opacity: 0 },
        {
            step: function (now) {
                let opacity = 1 - now;
                current_fs.css({ display: "none", position: "relative" });
                next_fs.css({ opacity: opacity });
            },
            duration: 500,
            complete: function () {
                $("html, body").animate({ scrollTop: 0 }, 600, "swing");
            }
        }
    );

    setProgressBar(++current);
});

$(".previous").click(function () {
    let current_fs = $(this).parent();
    let previous_fs = $(this).parent().prev();

    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    previous_fs.show();

    current_fs.animate(
        { opacity: 0 },
        {
            step: function (now) {
                let opacity = 1 - now;
                current_fs.css({ display: "none", position: "relative" });
                previous_fs.css({ opacity: opacity });
            },
            duration: 500,
            complete: function () {
                $("html, body").animate({ scrollTop: 0 }, 600, "swing");
            }
        }
    );

    setProgressBar(--current);
});


</script>

@endsection