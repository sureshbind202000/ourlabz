<!-- favicon -->

<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/logo.png') }}">



<!-- css -->

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lc-lightbox-lite@1.5.0/css/lc_lightbox.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lc-lightbox-lite@1.5.0/skins/light.css">

<link rel="stylesheet" href="{{ asset('assets/css/all-fontawesome.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/flex-slider.min.css') }}">

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.2.0/dist/css/splide.min.css" />

<style>
    .choices__list--multiple .choices__item {

        background-color: #0095d9 !important;

        border: 1px solid #0095d9 !important;

    }



    .notification-read {

        background-color: aliceblue;

    }



    .blink-dot {

        width: 12px;

        height: 12px;

        background-color: #28a745;

        /* Green */

        border-radius: 50%;

        display: inline-block;

        box-shadow: 0 0 0 rgba(40, 167, 69, 0.7);

        animation: pulse 1.5s infinite;

    }



    @keyframes pulse {

        0% {

            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);

        }



        70% {

            box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);

        }



        100% {

            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);

        }

    }



    /* Base card look */

    .hover-card {

        cursor: pointer;

        background-color: #fff;

        transition: transform .25s ease, box-shadow .25s ease;

        will-change: transform;

        transform-style: preserve-3d;

    }



    /* Lift + soft glow on hover */

    .hover-card:hover {

        transform: translateY(-4px) scale(1.03);

        box-shadow: 0 12px 28px rgba(0, 0, 0, .12);

        background: #f8f9fa;

        border: 1px solid #0095d9 !important;

        color: #0095d9;

    }



    /* Image grayscale -> color on hover */

    .city-icon img {

        filter: grayscale(1);

        transition: filter .25s ease, transform .25s ease;

        backface-visibility: hidden;

    }



    .hover-card:hover img {

        filter: grayscale(0);

    }



    /* Suggestion list hover */

    #citySuggestions li {

        cursor: pointer;

        transition: background .2s;

    }



    #citySuggestions li:hover {

        background-color: #f1f1f1;

    }



    /* Add perspective to the grid so 3D tilt looks real */

    .modal-body .row {

        perspective: 900px;

    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    a,
    span {
        word-break: break-all;
        overflow-wrap: break-word;
        white-space: normal;
    }
</style>

@yield('css')
