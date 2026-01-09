@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')

<main class="main">

<!-- register area -->
<div class="login-area py-100">
    <div class="container">
        <div class="col-md-5 mx-auto">
            <div class="login-form">
                <div class="login-header">
                    <img src="assets/img/logo/logo.png" alt="">
                    <p>Create your free medica account</p>
                </div>
                <form action="#">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Your Password">
                    </div>
                    <div class="form-check form-group">
                        <input class="form-check-input" type="checkbox" value="" id="agree">
                        <label class="form-check-label" for="agree">
                           I agree with the <a href="#">Terms Of Service.</a>
                        </label>
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="submit" class="theme-btn"><i class="far fa-paper-plane"></i> Register</button>
                    </div>
                </form>
                <div class="login-footer">
                    <p>Already have an account? <a href="{{route('login')}}">Login.</a></p>
                    <div class="social-login">
                        <span class="social-divider">or</span>
                        <p>Continue with social media</p>
                        <div class="social-login-list">
                            <a href="#" class="fb-auth"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="#" class="gl-auth"><i class="fab fa-google"></i> Google</a>
                            <a href="#" class="tw-auth"><i class="fab fa-x-twitter"></i> Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- register area end -->

</main>


@endsection
@section('js')

@endsection