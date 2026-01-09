@extends('frontend.includes.layout')

@section('css')



@endsection

@section('content')

<main class="main">







    <!-- contact area -->

    <div class="contact-area pt-100 pb-80">

        <div class="container">

            <div class="contact-wrapper">

                <div class="row">

                    <div class="col-lg-5">

                        <div class="contact-content">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="contact-info">

                                        <div class="contact-info-icon">

                                            <i class="fal fa-map-location-dot"></i>

                                        </div>

                                        <div class="contact-info-content">

                                            <h5>Office Address</h5>

                                            <p>{{$contactInfo->office_address ?? ''}}</p>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="contact-info">

                                        <div class="contact-info-icon">

                                            <i class="fal fa-headset"></i>

                                        </div>

                                        <div class="contact-info-content">

                                            <h5>Call Us</h5>
                                            @foreach($contactInfo->phone as $p)
                                            <p>{{ $p }}</p>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="contact-info">

                                        <div class="contact-info-icon">

                                            <i class="fal fa-envelopes"></i>

                                        </div>

                                        <div class="contact-info-content">

                                            <h5>Email Us</h5>

                                            @foreach($contactInfo->email as $e)
                                            <p><a href="mailto:{{ $e }}">{{ $e }}</a></p>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-7">

                        <div class="contact-form">

                            <div class="contact-form-header">

                                <h2>Get In Touch</h2>

                                <p>It is a long established fact that a reader will be distracted by the readable

                                    content of a page words which even slightly when looking at its layout. </p>

                            </div>

                            <form method="post" id="contact-form">
                                <input type="text" name="website" id="website" style="display:none">
                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <input type="text" class="form-control" name="name"

                                                placeholder="Your Name" required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <input type="email" class="form-control" name="email"

                                                placeholder="Your Email" required>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <input type="text" class="form-control" name="subject"

                                        placeholder="Your Subject" required>

                                </div>

                                <div class="form-group">

                                    <textarea name="message" cols="30" rows="4" class="form-control"

                                        placeholder="Write Your Message" required></textarea>

                                </div>

                                <button type="submit" class="theme-btn">Send

                                    Message <i class="far fa-paper-plane"></i></button>

                                <div class="col-md-12 my-3">

                                    <div class="form-messege text-success"></div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end contact area -->





    <!-- newsletter area -->

    <div class="newsletter-area pb-100">

        <div class="container wow fadeInUp" data-wow-delay=".25s">

            <div class="newsletter-wrap">

                <div class="row">

                    <div class="col-lg-6 mx-auto">

                        <div class="newsletter-content">

                            <h3>Get <span>20%</span> Off Discount Coupon</h3>

                            <p>By Subscribe Our Newsletter</p>

                            <div class="subscribe-form">

                                <form id="newsletter-form">
                                    @csrf

                                    <!-- Honeypot field -->
                                    <input type="text" name="website" style="display:none">

                                    <input type="email" class="form-control" name="email" placeholder="Your Email Address" required>

                                    <button class="theme-btn" type="submit">
                                        Subscribe <i class="far fa-paper-plane"></i>
                                    </button>
                                </form>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- newsletter area end -->





    <!-- map -->

    <div class="contact-map">
        @if(!empty($contactInfo->map_address))
        {!! $contactInfo->map_address !!}
        @endif
    </div>

    <!-- end map -->



</main>





@endsection

@section('js')
<script>
    $('#contact-form').submit(function(e) {
        e.preventDefault();

        // Show loading alert
        Swal.fire({
            title: 'Sending...',
            text: 'Please wait while we submit your message.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('website.contact.submit') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                Swal.close(); // Close loader

                $('.form-messege')
                    .text(res.success)
                    .removeClass('text-danger')
                    .addClass('text-success');

                $('#contact-form')[0].reset();
            },
            error: function(xhr) {
                Swal.close(); // Close loader

                let msg = xhr.responseJSON?.message ?? "Something went wrong!";

                $('.form-messege')
                    .text(msg)
                    .removeClass('text-success')
                    .addClass('text-danger');
            }
        });
    });

    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Please wait...',
            text: 'Subscribing to newsletter...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('website.newsletter.submit') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                Swal.close();

                Swal.fire({
                    icon: 'success',
                    title: 'Subscribed!',
                    text: res.success,
                });

                $('#newsletter-form')[0].reset();
            },
            error: function(xhr) {
                Swal.close();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: xhr.responseJSON?.message ?? "Something went wrong!",
                });
            }
        });
    });
</script>

@endsection