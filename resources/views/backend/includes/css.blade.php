<!-- ===============================================--><!--    Favicons--><!-- ===============================================-->
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> --}}
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/logo.png') }}">

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/logo/logo.png') }}">

<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logo/logo.png') }}">

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/logo.png') }}">

<meta name="msapplication-TileImage" content="{{ asset('assets/img/logo/logo.png') }}">

<meta name="theme-color" content="#ffffff">

<script src="{{ asset('backend/assets/js/config.js') }}"></script>

<script src="{{ asset('backend/vendors/simplebar/simplebar.min.js') }}"></script>



<!-- ===============================================--><!--    Stylesheets--><!-- ===============================================-->

<link rel="preconnect" href="https://fonts.gstatic.com/">

<link href="{{ asset('backend/vendors/choices/choices.min.css') }}" rel="stylesheet">

<link

    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"

    rel="stylesheet">

<link href="{{ asset('backend/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">

<link href="{{ asset('backend/assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">

<link href="{{ asset('backend/assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">

<link href="{{ asset('backend/assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">

<link href="{{ asset('backend/assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

<link rel="stylesheet" href="{{ asset('backend/vendors/glightbox/glightbox.min.css') }}">

<link rel="stylesheet" href="{{ asset('backend/vendors/flatpickr/flatpickr.min.css') }}">

<link href="{{ asset('backend/vendors/dropzone/dropzone.css') }}" rel="stylesheet">



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    var isRTL = JSON.parse(localStorage.getItem('isRTL'));

    if (isRTL) {

        var linkDefault = document.getElementById('style-default');

        var userLinkDefault = document.getElementById('user-style-default');

        linkDefault.setAttribute('disabled', true);

        userLinkDefault.setAttribute('disabled', true);

        document.querySelector('html').setAttribute('dir', 'rtl');

    } else {

        var linkRTL = document.getElementById('style-rtl');

        var userLinkRTL = document.getElementById('user-style-rtl');

        linkRTL.setAttribute('disabled', true);

        userLinkRTL.setAttribute('disabled', true);

    }
</script>

<style>
    .nav-link {
        transition: all 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: #2c7be5 !important;
        font-weight: 600;
    }

    .nav-link.active .nav-link-icon span,
    .nav-link:hover .nav-link-icon span {
        color: #2c7be5 !important;
    }


    #barcode-scanner video {

        width: 100% !important;

        height: 100% !important;

        object-fit: cover;

    }



    .choices__list--dropdown {

        z-index: 999 !important;

    }



    .dz-progress {

        display: none;

    }



    .dropzone .dz-message {

        margin: 0px;

    }



    /* Absolute Center Spinner */

    .loading {

        position: fixed;

        z-index: 999;

        width: 100vw;

        height: 100vh;

        display: flex;

        align-items: center;

        justify-content: center;

        z-index: 9999;

    }



    /* Transparent Overlay */

    .loading:before {

        content: "";

        display: block;

        position: fixed;

        top: 0;

        left: 0;

        width: 100%;

        height: 100%;

        background: radial-gradient(rgba(20, 20, 20, 0.8), rgba(0, 0, 0, 0.8));



        background: -webkit-radial-gradient(rgba(20, 20, 20, 0.8),

                rgba(0, 0, 0, 0.8));

    }



    .pill {

        background: #fff0;

        width: 15vmin;

        height: 40vmin;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-direction: column;

        transform: rotate(180deg);

        animation: spin 4s linear 0s infinite;

    }



    @keyframes spin {

        100% {

            transform: rotate(-540deg);

        }

    }



    .pill .side {

        background: white;

        position: relative;

        overflow: hidden;

        width: 30px;

        height: 45px;

        border-radius: 6vmin 6vmin 0 0;

    }



    .pill .side+.side {

        background: red;

        border-radius: 0 0 6vmin 6vmin;

        border-top: 1vmin solid #621e1a;

        animation: open 2s ease-in-out 0s infinite;

    }



    @keyframes open {



        0%,

        20%,

        80%,

        100% {

            margin-top: 0;

        }



        30%,

        70% {

            margin-top: 10vmin;

        }

    }



    .pill .side:before {

        content: "";

        position: absolute;

        width: 2vmin;

        height: 10vmin;

        bottom: 0;

        right: 1.5vmin;

        background: #fff2;

        border-radius: 1vmin 1vmin 0 0;

        animation: shine 1s ease-out -1s infinite alternate-reverse;

    }



    .pill .side+.side:before {

        bottom: inherit;

        top: 0;

        border-radius: 0 0 1vmin 1vmin;

    }



    .pill .side:after {

        content: "";

        position: absolute;

        width: 100%;

        height: 100%;

        bottom: 0;

        left: 0;

        border-radius: 6vmin 6vmin 0 0;

        border: 1.75vmin solid #00000022;

        border-bottom-color: #fff0;

        border-bottom-width: 0vmin;

        border-top-width: 1vmin;

        animation: shadow 1s ease -1s infinite alternate-reverse;

    }



    .pill .side+.side:after {

        bottom: inherit;

        top: 0;

        border-radius: 0 0 6vmin 6vmin;

        border-top-color: #fff0;

        border-top-width: 0vmin;

        border-bottom-width: 1vmin;

    }



    @keyframes shine {



        0%,

        46% {

            right: 1.5vmin;

        }



        54%,

        100% {

            right: 7.5vmin;

        }

    }



    @keyframes shadow {



        0%,

        49.999% {

            transform: rotateY(0deg);

            left: 0;

        }



        50%,

        100% {

            transform: rotateY(180deg);

            left: -3vmin;

        }

    }



    .medicine {

        position: absolute;

        width: calc(100% - 6vmin);

        height: calc(100% - 12vmin);

        background: #fff0;

        border-radius: 5vmin;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-wrap: wrap;

    }



    .medicine i {

        width: 1vmin;

        height: 1vmin;

        background: #47c;

        border-radius: 100%;

        position: absolute;

        animation: medicine-dust 1.75s ease 0s infinite alternate;

    }



    .medicine i:nth-child(2n + 2) {

        width: 1.5vmin;

        height: 1.5vmin;

        margin-top: -5vmin;

        margin-right: -5vmin;

        animation-delay: -0.2s;

    }



    .medicine i:nth-child(3n + 3) {

        width: 2vmin;

        height: 2vmin;

        margin-top: 4vmin;

        margin-right: 3vmin;

        animation-delay: -0.33s;

    }



    .medicine i:nth-child(4) {

        margin-top: -5vmin;

        margin-right: 4vmin;

        animation-delay: -0.4s;

    }



    .medicine i:nth-child(5) {

        margin-top: 5vmin;

        margin-right: -4vmin;

        animation-delay: -0.5s;

    }



    .medicine i:nth-child(6) {

        margin-top: 0vmin;

        margin-right: -3.5vmin;

        animation-delay: -0.66s;

    }



    .medicine i:nth-child(7) {

        margin-top: -1vmin;

        margin-right: 7vmin;

        animation-delay: -0.7s;

    }



    .medicine i:nth-child(8) {

        margin-top: 6vmin;

        margin-right: -1vmin;

        animation-delay: -0.8s;

    }



    .medicine i:nth-child(9) {

        margin-top: 4vmin;

        margin-right: -7vmin;

        animation-delay: -0.99s;

    }



    .medicine i:nth-child(10) {

        margin-top: -6vmin;

        margin-right: 0vmin;

        animation-delay: -1.11s;

    }



    .medicine i:nth-child(1n + 10) {

        width: 0.6vmin;

        height: 0.6vmin;

    }



    .medicine i:nth-child(11) {

        margin-top: 6vmin;

        margin-right: 6vmin;

        animation-delay: -1.125s;

    }



    .medicine i:nth-child(12) {

        margin-top: -7vmin;

        margin-right: -7vmin;

        animation-delay: -1.275s;

    }



    .medicine i:nth-child(13) {

        margin-top: -1vmin;

        margin-right: 3vmin;

        animation-delay: -1.33s;

    }



    .medicine i:nth-child(14) {

        margin-top: -3vmin;

        margin-right: -1vmin;

        animation-delay: -1.4s;

    }



    .medicine i:nth-child(15) {

        margin-top: -1vmin;

        margin-right: -7vmin;

        animation-delay: -1.55s;

    }



    @keyframes medicine-dust {



        0%,

        100% {

            transform: translate3d(0vmin, 0vmin, -0.1vmin);

        }



        25% {

            transform: translate3d(0.25vmin, 5vmin, 0vmin);

        }



        75% {

            transform: translate3d(-0.1vmin, -4vmin, 0.25vmin);

        }

    }



    input[type=number]::-webkit-outer-spin-button,

    input[type=number]::-webkit-inner-spin-button {

        -webkit-appearance: none;

        margin: 0;

    }



    input[type=number] {

        -moz-appearance: textfield;

    }
/* Select2 dropdown ko modal ke andar properly show karne ke liye */
.select2-container {
    z-index: 9999;
}

.select2-dropdown {
    z-index: 9999;
}

/* Modal ki z-index ensure karein */
.modal-backdrop {
    z-index: 1040;
}

.modal {
    z-index: 1050;
}

.select2-container {
    z-index: 9999;
}

.select2-dropdown {
    z-index: 9999;
}

.select2-selection__rendered img {
    vertical-align: middle;
}

/* Select2 dropdown container */
.select2-container--open {
    z-index: 9999;
}

/* Agar dropdown abhi bhi hide ho to ye try karein */
.select2-container--default .select2-results > .select2-results__options {
    max-height: 200px;
    overflow-y: auto;
}

    /* Select2 css */
    .select2-option-image {
    width: 20px;
    height: 20px;
    margin-right: 8px;
    vertical-align: middle;
    object-fit: cover;
}

.select2-option-text {
    vertical-align: middle;
}

.select2-option-with-image {
    display: inline-flex;
    align-items: center;
}
</style>

@yield('css')
