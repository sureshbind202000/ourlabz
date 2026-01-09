@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')

<main class="main">
    <!-- login area -->
    <div class="login-area py-90">
        <div class="container">
            <div class="col-md-7 col-lg-5 mx-auto">
                <div class="login-form">
                    <div class="login-header">
                        <!-- <img src="assets/img/logo/logo.png" alt=""> -->
                        <h2 class="text-center">OurLabz</h2>
                       <p>Login with your phone number</p>
                    </div>
                    <div id="phone-section">
                    <form action="#">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" class="form-control" id="phone" placeholder="Phone number">
                        </div>
                        <p id="message"></p>
                        <div class="d-flex justify-content-between mb-4">
                            <p ><a href="#" class="text-primary">Resend OTP</a></p>
                                                <p><a href="#">Change phone number</a></p>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <button type="button" class="theme-btn" onclick="validatePhone()"><i class="far fa-sign-in"></i> Send OTP</button>
                        </div>

                    </form>
                    </div>
                   

                    <!-- OTP  -->
                    <div id="otp-section">
                    <form action="#">
                       
                        <label>Enter OTP </label>
                            <div class="otp-boxes pb-4">
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                            </div>
                      
                        <div class="d-flex align-items-center">
                            <button type="button" class="theme-btn" onclick="validatePhone()"><i class="far fa-sign-in"></i> Submit</button>
                        </div>

                    </form>
                    </div>
                    <!-- <div class="login-footer">
                            <p>Don't have an account? <a href="{{route('register')}}">Register.</a></p>
                            <div class="social-login">
                                <span class="social-divider">or</span>
                                <p>Continue with social media</p>
                                <div class="social-login-list">
                                    <a href="#" class="fb-auth"><i class="fab fa-facebook-f"></i> Facebook</a>
                                    <a href="#" class="gl-auth"><i class="fab fa-google"></i> Google</a>
                                    <a href="#" class="tw-auth"><i class="fab fa-x-twitter"></i> Twitter</a>
                                </div>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->

</main>


@endsection
@section('js')

@endsection