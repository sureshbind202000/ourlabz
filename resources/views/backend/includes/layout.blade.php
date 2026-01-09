<!DOCTYPE html>

<html data-bs-theme="light" lang="en-US" dir="ltr">



<meta http-equiv="content-type" content="text/html;charset=utf-8" />



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ourlabz | Dashboard</title>



    <!-- Css Start -->

    @include('backend.includes.css')

    <!-- Css End -->

    <script>

        window.userId = "{{ auth()->id() }}";

    </script>



    @vite(['resources/js/app.js'])

</head>



<body>

    <!-- ===============================================--><!--    Main Content--><!-- ===============================================-->

    <main class="main" id="top">

        <div class="container" data-layout="container">

            <div class="loading" style="display: none;">

                <div class="pill">

                    <div class="medicine">

                        <i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>

                    </div>

                    <div class="side"></div>

                    <div class="side"></div>

                </div>

            </div>

            <script>

                var isFluid = 'true';

                if (isFluid) {

                    var container = document.querySelector('[data-layout]');

                    container.classList.remove('container');

                    container.classList.add('container-fluid');

                }

            </script>

            @include('backend.includes.sidebar')

            <div class="content">



                @include('backend.includes.header')

                @yield('content')

                @include('backend.includes.footer')

            </div>

            <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog"

                aria-labelledby="authentication-modal-label" aria-hidden="true">

                <div class="modal-dialog mt-6" role="document">

                    <div class="modal-content border-0">

                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">

                            <div class="position-relative z-1">

                                <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>

                                <p class="fs-10 mb-0 text-white">Please create your free Falcon account</p>

                            </div>

                            <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"

                                    data-bs-dismiss="modal" aria-label="Close"></button></div>

                        </div>

                        <div class="modal-body py-4 px-5">

                            <form>

                                <div class="mb-3"><label class="form-label" for="modal-auth-name">Name</label><input

                                        class="form-control" type="text" autocomplete="on" id="modal-auth-name" />

                                </div>

                                <div class="mb-3"><label class="form-label" for="modal-auth-email">Email

                                        address</label><input class="form-control" type="email" autocomplete="on"

                                        id="modal-auth-email" /></div>

                                <div class="row gx-2">

                                    <div class="mb-3 col-sm-6"><label class="form-label"

                                            for="modal-auth-password">Password</label><input class="form-control"

                                            type="password" autocomplete="on" id="modal-auth-password" /></div>

                                    <div class="mb-3 col-sm-6"><label class="form-label"

                                            for="modal-auth-confirm-password">Confirm

                                            Password</label><input class="form-control" type="password"

                                            autocomplete="on" id="modal-auth-confirm-password" /></div>

                                </div>

                                <div class="form-check"><input class="form-check-input" type="checkbox"

                                        id="modal-auth-register-checkbox" /><label class="form-label"

                                        for="modal-auth-register-checkbox">I

                                        accept the <a href="#!">terms </a>and <a class="white-space-nowrap"

                                            href="#!">privacy

                                            policy</a></label></div>

                                <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"

                                        name="submit">Register</button></div>

                            </form>

                            <div class="position-relative mt-5">

                                <hr />

                                <div class="divider-content-center">or register with</div>

                            </div>

                            <div class="row g-2 mt-2">

                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100"

                                        href="#"><span class="fab fa-google-plus-g me-2"

                                            data-fa-transform="grow-8"></span> google</a></div>

                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100"

                                        href="#"><span class="fab fa-facebook-square me-2"

                                            data-fa-transform="grow-8"></span> facebook</a></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Lock Screen Modal -->

            <div class="modal fade" id="lock-screenstaticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"

                tabindex="-1" aria-labelledby="lockScreenLabel" aria-hidden="true" style="background: #0000009c;">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content text-center p-4 border-0">

                        <div class="modal-body">

                            <img width="100" height="100" class="mb-3"

                                src="https://img.icons8.com/fluency/100/security-block.png"

                                alt="Access Restricted Icon" />

                            <h5 class="modal-title mb-3" id="lockScreenLabel">Access Restricted</h5>

                            <p id="lockScreenMessage" class="mb-3 text-muted">

                                <!-- Dynamic message will be inserted here -->

                            </p>

                            <div class="d-flex justify-content-center gap-2">

                                <form method="POST" action="{{ route('logout') }}">

                                    @csrf

                                    <button type="submit" class="btn btn-sm btn-secondary bg-gradient">

                                        {{ __('Log Out') }}

                                    </button>

                                </form>

                                @php

                                    $labid = auth()->user()->lab_id ?? null;

                                @endphp



                                @if ($labid)

                                    <a href="{{ route('lab.profile', ['labid' => $labid]) }}"

                                        class="btn btn-sm btn-falcon-primary">Update Profile</a>

                                @else

                                    <button class="btn btn-sm btn-secondary" disabled>No Lab Assigned</button>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>





        </div>

    </main>

    <!-- ===============================================--><!--    End of Main Content--><!-- ===============================================-->



    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================-->

    @include('backend.includes.js')

</body>



</html>

