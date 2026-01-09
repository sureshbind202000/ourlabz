@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')

<main class="main">
    <!-- forgot password -->
    <div class="login-area py-100">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header">
                        <img src="assets/img/logo/logo.png" alt="">
                        <p>Reset your medica account password</p>
                    </div>
                    <form action="#">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" class="theme-btn"><i class="far fa-key"></i> Send Reset
                                Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- forgot password end -->

</main>


@endsection
@section('js')

@endsection