@extends('frontend.includes.dashboard_layout')
@section('css')
    <style>
        .timeline-steps {
            position: relative;
            padding: 20px 15px;
        }

        .step {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .step:last-child::before {
            content: none;
        }

        .step::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 19px;
            height: calc(100% + 15px);
            width: 3px;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            z-index: 0;
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 20px;
            flex-shrink: 0;
            z-index: 1;
            /* box-shadow: 0 0 10px rgba(0, 114, 255, 0.3); */
            transition: background 0.3s, color 0.3s;
        }

        .step-content {
            flex: 1;
            z-index: 1;
        }

        .step-content h5 {
            margin: 0;
            font-weight: 600;
            font-size: 14px;
        }

        .step-content small {
            color: #6c757d;
        }

        .step.active .icon-wrapper {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            /* box-shadow: 0 0 10px rgba(40, 167, 69, 0.5); */
        }

        .step.inactive .icon-wrapper {
            background: white;
            color: #666;
            box-shadow: none;
            border: 2px solid rgba(0, 114, 255, 0.6);
        }

        .step.inactive .step-content h5,
        .step.inactive .step-content small {
            color: #aaa;
        }

        .step.last-active .icon-wrapper {
            position: relative;
            z-index: 1;
            animation: pop-glow 1.5s ease-in-out infinite;
        }

        .step.last-active .icon-wrapper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background: rgba(0, 114, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(1);
            z-index: -1;
            animation: spread-layer 1.5s ease-in-out infinite;
        }

        @keyframes spread-layer {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.6;
            }

            70% {
                transform: translate(-50%, -50%) scale(1.8);
                opacity: 0;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.8);
                opacity: 0;
            }
        }

        @keyframes pop-glow {

            0%,
            100% {
                box-shadow: 0 0 15px rgba(0, 114, 255, 0.6);
            }

            50% {
                box-shadow: 0 0 25px rgba(0, 114, 255, 1);
            }
        }
    </style>
@endsection
@section('dash_content')
    <div class="user-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="user-card user-track-order">
                    <h4 class="user-card-title">Track My Order</h4>

                    <div class="track-order-content">
                        <div class="track-order-step row">
                            {{-- Track input --}}
                            <div class="timeline-steps col-7">
                                <h5 class="mb-4">Tracking Order Number: <span id="tracking-code">N/A</span></h5>
                                <div class="user-form">
                                    <div class="form-group">
                                        <input type="text" id="order_id" class="form-control mb-2"
                                            placeholder="Enter tracking order ID">
                                        <button type="button" id="trackOrderBtn" class="theme-btn mt-2">
                                            <i class="fal fa-truck-fast"></i> Track Order
                                        </button>

                                    </div>
                                </div>
                                <div id="track-error" class="text-danger mt-2"></div>
                            </div>
                            {{-- Timeline --}}
                            <div class="timeline-steps col-5" id="timeline-steps" style="display:none;">
                                <div class="step">
                                    <div class="icon-wrapper"><i class="fas fa-file-medical"></i></div>
                                    <div class="step-content">
                                        <h5>Booking Confirm</h5>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="step">
                                    <div class="icon-wrapper"><i class="fas fa-calendar-check"></i></div>
                                    <div class="step-content">
                                        <h5>Collection Scheduled</h5>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="step">
                                    <div class="icon-wrapper"><i class="fas fa-vial"></i></div>
                                    <div class="step-content">
                                        <h5>Sample Collected & <br> Received at Lab</h5>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="step">
                                    <div class="icon-wrapper"><i class="fas fa-file-alt"></i></div>
                                    <div class="step-content">
                                        <h5>Report Ready</h5>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="step">
                                    <div class="icon-wrapper"><i class="fas fa-envelope-open-text"></i></div>
                                    <div class="step-content">
                                        <h5>Report Delivered</h5>
                                        <small></small>
                                        <br>
                                        <a href="#" id="download-report-btn" style="display:none;" target="_blank">
                                            <i class="fas fa-download"></i> Download Report
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#trackOrderBtn').on('click', function() {
            const orderId = $('#order_id').val().trim();

            if (!orderId) {
                Swal.fire({
                    toast: true,
                    icon: 'warning',
                    title: 'Please enter a valid tracking order ID.',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                return;
            }

            Swal.fire({
                title: 'Tracking Order...',
                text: 'Please wait while we fetch tracking details.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('track.booking.status') }}',
                method: 'GET',
                data: {
                    tracking_id: orderId
                },
                success: function(res) {
                    Swal.close();

                    if (res.status) {
                        $('#tracking-code').text('#' + orderId);
                        const currentStatus = parseInt(res.status_code);
                        const steps = document.querySelectorAll('.step');

                        steps.forEach((step, index) => {
                            const statusCode = index + 1;
                            const stepData = res.steps[statusCode];

                            // Set date inside <small>
                            const small = step.querySelector('small');
                            if (small) {
                                small.textContent = stepData ? stepData.date : '';
                            }

                            step.classList.remove('active', 'inactive', 'last-active');

                            if (statusCode < currentStatus) {
                                step.classList.add('active');
                            } else if (statusCode === currentStatus) {
                                step.classList.add('active', 'last-active');
                            } else {
                                step.classList.add('inactive');
                            }
                        });

                        // Show download button if delivered
                        if (currentStatus === 5) {
                            $('#download-report-btn')
                                .show()
                                .attr('href', '/download-report/' + orderId);
                        } else {
                            $('#download-report-btn').hide();
                        }

                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: res.title || 'Tracking updated successfully.',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        $('#timeline-steps').show();
                        $('#order_id').val('');
                    } else {
                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            title: res.message || 'No tracking information found.',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'Something went wrong. Please try again later.',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            });
        });
    </script>

    @if (isset($steps))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const currentStatus = {{ $status_code ?? '' }};
                const trackingId = '{{ $tracking_id ?? '' }}';

                const stepData = @json(
                    $steps->mapWithKeys(fn($s) => [
                            $s->status => $s->updated_at->format('d M Y, h:i A'),
                        ]));

                const steps = document.querySelectorAll('.step');

                steps.forEach((step, index) => {
                    const statusCode = index + 1;
                    const small = step.querySelector('small');

                    step.classList.remove('active', 'inactive', 'last-active');

                    if (statusCode < currentStatus) {
                        step.classList.add('active');
                    } else if (statusCode === currentStatus) {
                        step.classList.add('active', 'last-active');
                    } else {
                        step.classList.add('inactive');
                    }

                    if (small && stepData[statusCode]) {
                        small.textContent = stepData[statusCode];
                    }
                });

                document.getElementById('timeline-steps').style.display = 'block';
                document.getElementById('tracking-code').innerText = '#' + trackingId;

                const downloadBtn = document.getElementById('download-report-btn');
                if (parseInt(currentStatus) === 5) {
                    downloadBtn.href = '/download-report/' + trackingId;
                    downloadBtn.style.display = 'inline-block';
                } else {
                    downloadBtn.style.display = 'none';
                }
            });
        </script>
    @endif
@endsection
