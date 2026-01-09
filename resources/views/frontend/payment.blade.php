@extends('frontend.includes.layout')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* Body & Container */
    .billing-container {
        background: #fff;
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
        color: #007acc;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 15px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    /* Labels */
    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #005a9c;
        letter-spacing: 0.03em;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.07);
    }

    /* Input Group & Icons */
    .input-group-text {
        background-color: #cce7fb;
        /* lighter blue */
        color: #007acc;
        border: 1.5px solid #66b7e6;
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
    input.form-control {
        height: 3.4rem;
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
        padding: 14px;
        border-radius: 12px;
        color: #fff;
        box-shadow: 0 8px 15px rgba(0, 149, 217, 0.35);
        transition: all 0.3s ease;
        width: 100%;
    }

    .pay-button:hover {
        background: linear-gradient(135deg, #007acc, #005f9e);
        box-shadow: 0 12px 25px rgba(0, 118, 184, 0.6);
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
</style>
@endsection
@section('content')

<main class="main">
    <!-- shop checkout -->
    <div class="shop-checkout py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 mx-auto">
                    <div class="billing-container shadow">
                        <h2>Billing Details</h2>
                        <p><strong>Order ID:</strong> ORD-8RQX8MU7</p>

                        <form>
                            <div class="row g-4 my-4">
                                <div class="col-md-6">
                                    <label for="firstName">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="firstName"
                                            placeholder="First Name"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="lastName"
                                            placeholder="Last Name"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input
                                        type="email"
                                        class="form-control shadow-none"
                                        id="email"
                                        placeholder="email@example.com"
                                        required />
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="phone">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                    <input
                                        type="tel"
                                        class="form-control shadow-none"
                                        id="phone"
                                        placeholder="+1 234 567 890"
                                        required />
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="address">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                    <input
                                        type="text"
                                        class="form-control shadow-none"
                                        id="address"
                                        placeholder="1234 Main St"
                                        required />
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="city">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="city"
                                            placeholder="City"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="state">State</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="state"
                                            placeholder="State"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="zip">Zip Code</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-mailbox2"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="zip"
                                            placeholder="Zip Code"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="country">Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="country"
                                            placeholder="Country"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="cardNumber">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                                    <input
                                        type="text"
                                        class="form-control shadow-none"
                                        id="cardNumber"
                                        placeholder="1234 5678 9012 3456"
                                        maxlength="19"
                                        required />
                                </div>
                            </div>

                            <div class="row g-3 mb-4 expiry-cvv-group">
                                <div class="col-md-4">
                                    <label for="expMonth">Exp. Month (MM)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-month-fill"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="expMonth"
                                            placeholder="MM"
                                            maxlength="2"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="expYear">Exp. Year (YY)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-fill"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="expYear"
                                            placeholder="YY"
                                            maxlength="2"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="cvv">CVV</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="cvv"
                                            placeholder="CVV"
                                            maxlength="4"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="amount">Amount (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                    <input
                                        type="number"
                                        class="form-control shadow-none"
                                        id="amount"
                                        placeholder="Amount"
                                        min="1"
                                        required />
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="agreeTerms"
                                    required />
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the
                                    <a href="#">Privacy Policy</a>,
                                    <a href="#">Refund Policy</a>, and
                                    <a href="#">Terms & Conditions</a>.
                                </label>
                            </div>

                            <button type="submit" class="pay-button">
                                Pay Now ✅
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop checkout end -->

</main>

<!-- information form  -->
<div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="information" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Patient</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="contact-form shadow-none form-group">
                    <div class="form-card">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label d-block mb-2">Patient Name</label>
                                    <input type="text" class="form-control shadow-none" name="name" placeholder="Patient Name"
                                        required="" fdprocessedid="aoar9">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 ">
                                <label class="label d-block mb-2">Gender</label>
                                <div class="d-flex gap-5">
                                    <div class="form-group ">
                                        <input type="radio" class="form-check-input" name="gender" id="male"
                                            value="Male">
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-group ">
                                        <input type="radio" class="form-check-input" name="gender" id="femal"
                                            value="Female">
                                        <label class="form-check-label" for="femal">Female</label>
                                    </div>
                                    <div class="form-group ">
                                        <input type="radio" class="form-check-input" name="gender" id="other_gender"
                                            value="Other">
                                        <label class="form-check-label" for="other_gender">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 form-group">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" class="form-control shadow-none" id="inputEmail" name="email"
                                    placeholder="Enter Email" required>
                            </div>
                            <div class="col-md-12 col-lg-6 form-group ">
                                <label for="inputPhone" class="form-label">Phone No</label>
                                <input type="number" class=" form-control" id="inputPhone" name="phone"
                                    placeholder="Enter Phone No" required>
                            </div>
                            <div class="col-md-12 col-lg-6 form-group">
                                <label for="inputdob" class="form-label">Date of Birth</label>
                                <input type="Date" class=" form-control " id="inputdob" name="dob"
                                    placeholder="Enter Date of Birth" required>
                            </div>
                            <div class="col-md-12 col-lg-6 form-group">
                                <label for="inputdob" class="form-label">Relation</label>
                                <select name="relation" id="booking_relation" class="form-control shadow-none form-select" required>
                                    <option value="">--select--</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- information form  -->
<!-- address form  -->
<div class="modal fade  modal-lg py-3 overflow-y-auto " aria-label="Close" id="address" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Address</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="contact-form shadow-none form-group">
                    <div class="form-card">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="inputAddress" class="form-label">Street Address</label>
                                <input type="name" class="form-control shadow-none " id="inputAddress" name=""
                                    placeholder="Enter Address">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="inputCity" class="form-label">City</label>
                                <input type="name" class="form-control shadow-none " id="inputCity" name=""
                                    placeholder="Enter City">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="inputState" class="form-label">State</label>
                                <input type="name" class="form-control shadow-none " id="inputState" name=""
                                    placeholder="Enter State">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="inputCountry" class="form-label">Country</label>
                                <input type="name" class="form-control shadow-none " id="inputCountry" name=""
                                    placeholder="Enter Country">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="inputPin" class="form-label">Pin/Postal Code</label>
                                <input type="name" class="form-control shadow-none " id="inputPin" name=""
                                    placeholder="Enter Pin code">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="inputMap" class="form-label">Google Map Location
                                    (Optional)</label>
                                <input type="name" class="form-control shadow-none " id="inputMap" name=""
                                    placeholder="Paste Google Map Link">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- address form  -->
@endsection
@section('js')


@endsection