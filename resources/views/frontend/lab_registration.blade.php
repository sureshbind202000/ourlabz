@extends('frontend.includes.layout')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    
.main {
    /* background-image: url(assets/img/hero/bg.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center; */
    background-color: #004e83;
    }
    .forms{
        background-color: #0065a8;
    }
    /* Body & Container */
    .billing-container {
        /* background: #fff; */
        /* max-width: 700px; */
        width: 100%;
        border-radius: 18px;
        /* box-shadow:
            0 8px 20px rgba(0, 149, 217, 0.12),
            0 4px 12px rgba(0, 149, 217, 0.15); */
        padding: 40px 50px 50px;
        transition: box-shadow 0.3s ease;
    }

    /* .billing-container:hover {
        box-shadow:
            0 12px 32px rgba(0, 149, 217, 0.25),
            0 6px 18px rgba(0, 149, 217, 0.3);
    } */

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
        border-radius:0.6rem;
        border: 1.5px solid #66b7e6;
        /* lighter blue */
        background: transparent;
        font-size: 1rem;
        font-weight: 500;
        padding-left: 1rem;
        color: #003f70;
        box-shadow: inset 0 2px 4px rgba(102, 183, 230, 0.07);
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    input.form-control::placeholder {
        color: hsl(0, 0%, 100%);
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
  content: "\f0f7";
  text-align: center;
}
#progressbar #login:before {
  font-family: FontAwesome;
  content: "\f007";
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
    /* margin: 0 auto 10px auto; */
    padding: 2px;
    z-index: 1;
}
#progressbar #personal:before{
   margin: 0 auto 10px 0;
}
#progressbar #location:before{
   margin: 0 auto 10px auto;
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


    <div class="shop-checkout py-2">
        <div class="container">
            <div class="row shadow forms">
                <div class="col-lg-5">
                     <h2 class="text-center pt-4">Registration Form</h2>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-7 mx-auto">
                    <div class="billing-container py-3">
                       
                        <form id="msform" class="">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="personal" style="text-align: start;"><strong>Lab Details</strong></li>
                                <li id="location" style="text-align: center;"><strong>Address</strong></li>
                                <li id="login" style="text-align: end;"><strong>Login</strong></li>
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
                                              
                                                <input type="text" class="form-control shadow-none" id="labName" placeholder="Enter Lab Name" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="labRegNumber">Lab Registration Number</label>
                                            <div class="input-group">
                                                <!-- <span class="input-group-text"><i class="bi bi-123"></i></span> -->
                                                <input type="text" class="form-control shadow-none" id="labRegNumber" placeholder="Alphanumeric Reg No." pattern="[A-Za-z0-9]+" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="accreditation">Accreditation Details</label>
                                            <div class="input-group">
                                                <!-- <span class="input-group-text"><i class="bi bi-award-fill"></i></span> -->
                                                <input type="text" class="form-control shadow-none" id="accreditation" placeholder="e.g., ISO 9001, NABL" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="labType">Type of Lab</label>
                                            <div class="input-group">
                                                <!-- <span class="input-group-text"><i class="bi bi-diagram-3-fill"></i></span> -->
                                                <select class="form-control shadow-none" id="labType" required>
                                                    <option value="" disabled selected>Select Lab Type</option>
                                                    <option>Pathology</option>
                                                    <option>Radiology</option>
                                                    <option>Diagnostic</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="yearEstablished">Year of Establishment</label>
                                            <div class="input-group">
                                                <!-- <span class="input-group-text"><i class="bi bi-calendar-range"></i></span> -->
                                                <input type="month" class="form-control shadow-none" id="yearEstablished" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="operatingHours">Operating Hours</label>
                                            <div class="input-group">
                                                <!-- <span class="input-group-text"><i class="bi bi-clock-history"></i></span> -->
                                                <input type="text" class="form-control shadow-none" id="operatingHours" placeholder="e.g., 9:00 AM - 6:00 PM" required />
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
                                        <div class="mb-4 col-md-6">
                                            <label for="contactName">Primary Contact Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                                                <input type="text" class="form-control shadow-none" id="contactName" placeholder="Enter Contact Name" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="contactPhone">Phone Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                <input type="tel" class="form-control shadow-none" id="contactPhone" placeholder="+1 123 456 7890" pattern="^\+?[0-9\s\-]+$" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="contactEmail">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                                <input type="email" class="form-control shadow-none" id="contactEmail" placeholder="email@example.com" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="website">Website (if any)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                                <input type="url" class="form-control shadow-none" id="website" placeholder="https://www.example.com" />
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
                                                <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                                <input type="text" class="form-control shadow-none" id="adminName" placeholder="Enter Admin Name" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="username">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                                <input type="text" class="form-control shadow-none" id="username" placeholder="Alphanumeric Username" pattern="[A-Za-z0-9]+" required />
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                                <input type="password" class="form-control shadow-none" id="password" placeholder="Choose a strong password" minlength="8" required />
                                            </div>
                                            <small class="text-muted">Password must be at least 8 characters</small>
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
    $(document).ready(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
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

        $(".previous").click(function() {

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
                step: function(now) {
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

        $(".submit").click(function() {
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