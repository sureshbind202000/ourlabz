<!-- modal popup banner  -->
<div class="modal popup-banner fade" id="popup-banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="far fa-xmark"></i></button>
            <div class="modal-body">
                <div class="popup-banner-content">
                    <div class="row">
                        <div class="col-lg-6 d-none d-md-block">
                            <div class="popup-banner-img">
                                <img src="{{ asset('assets/img/login_img.png') }}" alt="Login Image"
                                    style="object-fit: cover;max-height: 420px;">
                            </div>
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="popup-banner-info">
                                <div class="login-form shadow-none p-0">
                                    <div id="phone-section">
                                        <h2 class="text-center">Sign In</h2>
                                        <form action="#">
                                            <div class="form-group mb-2">
                                                <label for="login-name">Full Name</label>
                                                <input type="text" class="form-control" id="login-name"
                                                    placeholder="Enter your full name.">
                                            </div>
                                            <div class="form-group">
                                                <label for="login-phone">Phone Number</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text rounded-end-0">+91</span>
                                                    </div>
                                                    <input type="number" class="form-control" id="login-phone"
                                                        placeholder="xxx xxx xxxx">
                                                </div>
                                                <small>OTP will be sent to this number by SMS</small>
                                            </div>

                                            <!-- Terms & Conditions Checkbox -->
                                            <div class="form-group form-check mt-3">
                                                <input type="checkbox" class="form-check-input" id="terms-check">
                                                <label class="form-check-label" for="terms-check">
                                                    I agree to the <a href="#" target="_blank">Terms &
                                                        Conditions</a>
                                                </label>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <button type="button" class="theme-btn" onclick="validatePhone()">
                                                    <i class="far fa-sign-in"></i> Continue
                                                </button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal popup banner end -->

<!-- Registration OTP Modal Start -->
<div class="modal fade" id="registrationOtpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">OTP VERIFICATION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript: void(0)" class="otp-form text-center" name="otp-form">
                    <div class="title">
                        <p class="info">An otp has been sent to xxx-xxx-xxxx and ********ample@example.com</p>
                        <p class="msg">Please enter OTP to verify</p>
                    </div>
                    <div class="otp-input-fields">
                        <input type="number" class="otp__digit otp__field__1">
                        <input type="number" class="otp__digit otp__field__2">
                        <input type="number" class="otp__digit otp__field__3">
                        <input type="number" class="otp__digit otp__field__4">
                        <input type="number" class="otp__digit otp__field__5">
                        <input type="number" class="otp__digit otp__field__6">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="verifyRegistrationOtpBtn">Verify</button>
            </div>
        </div>
    </div>
</div>
<!-- Registration OTP Modal End -->

<!-- Login OTP Modal End -->
<div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">OTP VERIFICATION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript: void(0)" class="otp-form text-center" name="otp-form">
                    <div class="title">
                        <p class="info">An otp has been sent to xxx-xxx-xxxx and ********ample@example.com</p>
                        <p class="msg">Please enter OTP to verify</p>
                    </div>
                    <div class="otp-input-fields">
                        <input type="number" class="otp__digit otp__field__1">
                        <input type="number" class="otp__digit otp__field__2">
                        <input type="number" class="otp__digit otp__field__3">
                        <input type="number" class="otp__digit otp__field__4">
                        <input type="number" class="otp__digit otp__field__5">
                        <input type="number" class="otp__digit otp__field__6">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="verifyOtpBtn">Verify</button>
            </div>
        </div>
    </div>
</div>
<!-- login OTP Modal End -->

{{-- Start Cart Modal --}}
<!-- Cart Select Modal -->


<div class="modal fade" id="cartSelectModal" tabindex="-1" aria-labelledby="cartSelectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title w-100 text-center text-dark" id="cartSelectModalLabel">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i> Select Cart Type
                </h5>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body  text-center">
                <div class=" row text-center py-4">
                    <!-- Lab Test Cart -->
                    <div class="col-md-6 col-6 border-end">
                        <a href="{{ route('cart.view') }}" class="text-decoration-none">
                            <div class="btn btn-sm shadow-sm">
                                <div class="cart-icon">
                                    <img src="{{ asset('assets/img/microscope.png') }}" alt="Lab Test Cart"
                                        style="height: 50px;">
                                </div>
                                <div class="cart-label">Lab Test Cart</div>
                                <span id="cart-count" class="text-white rounded-circle"
                                    style="display:none;position: absolute;margin: -86px 30px;background-color: #0095d9;padding: 4px;height: 28px;width: 28px;">
                                    0
                                </span>
                            </div>
                        </a>
                    </div>

                    <!-- Product Cart -->
                    <div class="col-md-6 col-6">
                        <a href="{{ route('product.cart') }}" class="text-decoration-none">
                            <div class="btn btn-sm shadow-sm">
                                <div class="cart-icon">
                                    <img src="{{ asset('assets/img/product_cart.png') }}" alt="Product Cart"
                                        style="height: 50px;">
                                </div>
                                <div class="cart-label">Product Cart</div>
                                <span id="product-cart-count" class="text-white rounded-circle"
                                    style="display:none;position: absolute;margin: -86px 30px;background-color: #0095d9;padding: 4px;height: 28px;width: 28px;">
                                    0
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                <small>Continue to purchase from</small>
            </div>
        </div>
    </div>
</div>


{{-- End Cart Modal --}}

<!-- modal start  -->
<div class="modal fade" id="exampleModalToggle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 shadow-lg border-0">
            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center fw-semibold">Choose Your City</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 pb-4">
                <!-- Popular Cities -->
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                    <div class="col">
                        <div class="city-icon p-2 rounded-3 shadow-sm text-center border hover-card"
                            data-city="Bangalore">
                            <img src="{{ asset('assets/img/city/Bangalore.png') }}" class="img-fluid mb-2"
                                alt="Bangalore">
                            <p class="mb-0 fw-medium">Bangalore</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="city-icon p-2 rounded-3 shadow-sm text-center border hover-card"
                            data-city="Chennai">
                            <img src="{{ asset('assets/img/city/chennai.png') }}" class="img-fluid mb-2"
                                alt="Chennai">
                            <p class="mb-0 fw-medium">Chennai</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="city-icon p-2 rounded-3 shadow-sm text-center border hover-card"
                            data-city="Trivandrum">
                            <img src="{{ asset('assets/img/city/Trivandrum.png') }}" class="img-fluid mb-2"
                                alt="Trivandrum.png">
                            <p class="mb-0 fw-medium">Trivandrum</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="city-icon p-2 rounded-3 shadow-sm text-center border hover-card"
                            data-city="Mumbai">
                            <img src="{{ asset('assets/img/city/Mumbai.png') }}" class="img-fluid mb-2"
                                alt="Mumbai">
                            <p class="mb-0 fw-medium">Mumbai</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="city-icon p-2 rounded-3 shadow-sm text-center border hover-card"
                            data-city="Delhi">
                            <img src="{{ asset('assets/img/city/Delhi.png') }}" class="img-fluid mb-2"
                                alt="Delhi">
                            <p class="mb-0 fw-medium">Delhi</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="city-icon p-2 rounded-3 shadow-sm text-center border hover-card"
                            data-city="Jaipur">
                            <img src="{{ asset('assets/img/city/Jaipur.png') }}" class="img-fluid mb-2"
                                alt="Jaipur">
                            <p class="mb-0 fw-medium">Jaipur</p>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="mt-4">
                    <!-- Google will replace this input automatically -->
                    <input type="text" id="searchCityLocation"
                        class="form-control form-control-lg rounded-pill shadow-sm"
                        placeholder="🔍 Search for your city...">

                    <ul id="citySuggestions" class="list-group list-group-flush mt-3 shadow-sm rounded d-none"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .pac-container {
        z-index: 2000 !important;
    }
</style>
<!-- modal end -->

<!-- Map modal start -->

<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Select Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px; width: 100%;"></div>
                <!-- Loading overlay -->
                <div id="mapLoading"
                    style="display: none !important; position: absolute; top: 0; left: 0; 
                width: 100%; height: 100%; 
                background: rgba(255,255,255,0.7); 
                z-index: 10; 
                display: flex; 
                align-items: center; 
                justify-content: center;">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
                <button type="button" id="recenterMap" class="btn bg-white shadow-sm rounded-circle p-2"
                    style="position:absolute;right: 28px;bottom: 165px;height: 37px;width: 37px;"
                    data-tooltip="tooltip" title="Click to select current location">
                    <i class="fa-solid fa-location-crosshairs fs-5"></i>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal"
                    data-open="addAddressModal" id="save-location-btn">Save Location</button>
            </div>
        </div>
    </div>
</div>

<!-- Map modal end -->
