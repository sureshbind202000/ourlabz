@extends('backend.includes.layout')

@section('content')

    <div class="card mb-3">

        <div class="card-header">

            <div class="row">

                <div class="col">

                    <h5 class="mb-2">Order ID : <a href="javascript:void(0);">{{ $detail->order_id }}</a> </h5>

                    {{-- <a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-plus fs-11 me-1"></span>Add

                        note</a><button class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none"

                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span

                            class="fas fa-ellipsis-h"></span></button>

                    <div class="dropdown-menu"><a class="dropdown-item" href="#">Edit</a><a class="dropdown-item"

                            href="#">Report</a><a class="dropdown-item" href="#">Archive</a>

                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#">Delete

                            user</a>

                    </div> --}}

                </div>

                <div class="col-auto d-none d-sm-block">

                    <b>Status : </b> {{ getSampleStatus($detail->status) }}

                </div>

            </div>

        </div>

    </div>

    <div class="card mb-3">

        <div class="card-header">

            <div class="row align-items-center">

                <div class="col">

                    <h5 class="mb-0"><span class="fas fa-user text-success me-2" data-fa-transform="down-5"></span>

                        Booking Details</h5>

                </div>

                <div class="col-auto">

                    @if ($detail->booking_patient?->trackBooking?->collection_status == 0)

                        <button id="startCollectionBtn" class="btn btn-sm btn-primary bg-gradient"><i

                                class="fa-solid fa-motorcycle"></i> Start Collection</button>

                    @endif

                    @if ($detail->status == 2 || $detail->status == 3)

                    @else

                        <a href="javascript:void(0);"

                            class="btn btn-falcon-success btn-sm bg-gradient final-submit-btn {{ $detail->status == 5 ? 'd-none' : '' }}"

                            data-id="{{ encrypt($detail->id) }}">

                            <i class="fa-solid fa-check-double me-1"></i>Final Submit

                        </a>

                    @endif

                </div>

            </div>

        </div>

        <div class="card-body bg-body-tertiary border-top">

            <div class="row border-bottom pb-4">

                <div class="col-lg col-xxl-5 border-end">

                    <h6 class="fw-semi-bold ls mb-3 text-uppercase text-primary">Contact Information</h6>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Name</p>

                        </div>

                        <div class="col">{{ $detail->booking_patient->name }}</div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Phone</p>

                        </div>

                        <div class="col">{{ $detail->booking_patient->phone }}</div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Address</p>

                        </div>

                        <div class="col">{{ $detail->booking?->bookingAddress?->address ?? 'Address not available' }}

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">City</p>

                        </div>

                        <div class="col">{{ $detail->booking?->bookingAddress?->city ?? 'City not available' }}</div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">State</p>

                        </div>

                        <div class="col">{{ $detail->booking?->bookingAddress?->state ?? 'State not available' }}</div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Country</p>

                        </div>

                        <div class="col">{{ $detail->booking?->bookingAddress?->country ?? 'Country not available' }}

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Pincode</p>

                        </div>

                        <div class="col">{{ $detail->booking?->bookingAddress?->pin ?? 'Pincode not available' }}</div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Map Location</p>

                        </div>

                        <div class="col">

                            <p class="fst-italic text-400 mb-1">

                                <a href="{{ $detail->booking?->bookingAddress?->google_map_location ?? 'javascript:void(0);' }}"

                                    target="_blank">View Location on Map</a>

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">

                    <h6 class="fw-semi-bold ls mb-3 text-uppercase text-primary">Scheduling Information</h6>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Booking Date</p>

                        </div>

                        <div class="col">

                            {{ $detail->booking?->booking_date ? \Carbon\Carbon::parse($detail->booking->booking_date)->format('d/m/Y') : 'Not Available' }}

                        </div>



                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Time Slot</p>

                        </div>

                        <div class="col">

                            {{ $detail->booking?->time_slot ?? 'Not Available' }}

                        </div>

                    </div>

                    <hr>

                    <h6 class="fw-semi-bold ls mb-3 text-uppercase text-primary">Test Information</h6>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Name</p>

                        </div>

                        <div class="col">

                            {{ $detail->bookingTest?->package?->name ?? 'Not Available' }}

                        </div>



                    </div>

                    @php

                        $requisites = $detail->bookingTest?->package?->requisites ?? [];

                    @endphp



                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1">Requisites</p>

                        </div>

                        <div class="col">

                            @if (count($requisites))

                                <ul type="none" class="mb-0 ps-0">

                                    @foreach ($requisites as $item)

                                        <li>{{ $item->icon }} {{ $item->name }}</li>

                                    @endforeach

                                </ul>

                            @else

                                <span>Not Available</span>

                            @endif

                        </div>

                    </div>



                </div>

            </div>



            <div class="row pt-4">

                <div class="col-lg col-xxl-6">

                    <h6 class="fw-semi-bold ls mb-3 text-uppercase text-primary">Collected Sample</h6>

                    <div class="row mb-3">

                        <div class="col-6 col-sm-6">

                            <p class="fw-semi-bold mb-1">{{ $detail->bookingTest?->package?->name ?? 'Not Available' }}</p>

                            @if (empty($detail->sample_image))

                                <span class="text-danger fs-10">Sample Not Uploaded Yet</span>

                            @else

                                <span class="text-success">Uploaded Successfully</span>

                            @endif

                        </div>

                        <div class="col">

                            @if (empty($detail->sample_image) || count($detail->sample_image) === 0)

                                <button

                                    class="btn btn-sm btn-falcon-primary upload-btn {{ $detail->status == 5 ? 'd-none' : '' }}"

                                    data-tracking_id="{{ $detail->booking_patient->id }}" data-id="{{ $detail->id }}">

                                    Upload

                                </button>

                            @else

                                @if (!empty($detail->sample_image) && is_array($detail->sample_image))

                                    <strong>Images:</strong>

                                    <div class="d-flex flex-wrap gap-2 mt-2">

                                        @foreach ($detail->sample_image as $img)

                                            <a href="{{ asset($img) }}" class="glightbox"

                                                data-gallery="gallery{{ $detail->id }}" data-bs-toggle="tooltip"

                                                title="Click to view collected sample image">

                                                <img src="{{ asset($img) }}" alt="Sample Image"

                                                    style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px;">

                                            </a>

                                        @endforeach

                                    </div>

                                @endif





                                @if (!in_array($detail->status, [2, 3]))

                                    <a href="javascript:void(0)" class="mt-2 btn btn-sm btn-falcon-danger delete-sample"

                                        data-id="{{ $detail->id }}">

                                        Delete

                                    </a>

                                @endif

                            @endif



                        </div>

                    </div>

                </div>

                <div class="col-lg-6 col-xxl-6 ">

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <h6 class="fw-semi-bold mb-1 text-uppercase text-primary">Sample to be collect</h6>

                        </div>

                        <div class="col">

                            {{ $detail->bookingTest?->package?->sample_type_specimen }}

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-5 col-sm-4">

                            <p class="fw-semi-bold mb-1 text-primary">Note</p>

                        </div>

                        <div class="col">

                            <p>

                                {{ $detail->note ?? 'Not Available' }}

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-12 col-xxl-12">

                    <div id="phleboMap" style="height: 200px; width: 100%;display:none;"></div>

                    <a id="getDirectionsBtn" class="btn btn-success w-100 rounded-top-0" target="_blank"

                        style="display: none;">

                        <i class="fa-solid fa-route"></i> Get Directions

                    </a>

                </div>

            </div>

        </div>

        <div class="card-footer border-top">

            @if ($detail->status == 2)

                <div class="alert alert-success border-0 d-flex align-items-center" role="alert">

                    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-6"></span></div>

                    <p class="mb-0 flex-1"> Sample is finally submitted</p>

                </div>

            @elseif($detail->status == 3)

                <div class="alert alert-success border-0 d-flex align-items-center" role="alert">

                    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-6"></span></div>

                    <p class="mb-0 flex-1"> Sample is accepted by lab.</p>

                </div>

            @elseif($detail->status == 4)

                <div class="alert alert-danger border-0 d-flex align-items-center" role="alert">

                    <div class="bg-danger me-3 icon-item"><span class="fas fa-xmark-circle text-white fs-6"></span></div>

                    <p class="mb-0 flex-1"> Sample Rejected Reason : {{ $detail->reason }}</p>

                </div>

            @endif

        </div>

    </div>

    <div class="card mt-3">

        <div class="card-header fw-bold bg-body-tertiary bg-gradient text-dark">Activity Logs</div>

        <div class="card-body">

            @forelse ($logs as $log)

                <p>

                    <strong>{{ $log->action }}</strong> <br>

                    {{ $log->description }} <br>

                    <small class="text-muted">

                        by {{ $log->user->name ?? 'System' }} on {{ $log->created_at->format('d M Y h:i A') }}

                    </small>

                </p>

                <hr>

            @empty

                <p>No activity logs yet.</p>

            @endforelse

        </div>

    </div>



    {{-- Upload Sample Image --}}

    <div class="modal fade" id="uploadSampleModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content p-3">

                <div class="modal-header">

                    <h5 class="modal-title">Upload Sample</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <form id="uploadSampleForm" enctype="multipart/form-data">

                    <div class="modal-body">

                        <input type="hidden" name="id" id="sampleTrackingId">

                        <input type="hidden" name="track_sample_id" id="trackSampleId">

                        <div class="mb-3">

                            <label for="sample_image" class="form-label">Choose Sample File</label>

                            <input class="form-control" type="file" name="sample_image[]" id="sample_image" multiple

                                required>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Upload</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- OTP Verification Modal -->

    <div class="modal fade" id="otpVerifyModal" tabindex="-1" aria-labelledby="otpVerifyModalLabel"

        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Verify OTP</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <form id="otpVerifyForm">

                        <input type="hidden" id="otpTrackingId">

                        <div class="mb-3">

                            <label>Enter OTP</label>

                            <input type="text" id="otpCode" class="form-control" placeholder="Enter 6-digit OTP"

                                maxlength="6" required>

                        </div>

                        <button type="submit" class="btn btn-primary w-100">Verify</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function() {

            // Open modal and set sampleTrackingId

            $(document).on('click', '.upload-btn', function() {

                var id = $(this).data('id');

                var tracking_id = $(this).data('tracking_id');

                $('#otpTrackingId').val(tracking_id);



                $('#trackSampleId').val(id);



                // 👇 Step 1: Show OTP modal first

                $('#otpVerifyModal').modal('show');

            });



            // 👇 Step 2: Handle OTP verification

            $('#otpVerifyForm').submit(function(e) {

                e.preventDefault();



                const trackingId = $('#otpTrackingId').val();

                const otp = $('#otpCode').val();



                if (!otp) {

                    Swal.fire('Error', 'Please enter OTP', 'error');

                    return;

                }



                // Optional: show loading

                Swal.fire({

                    title: 'Verifying OTP...',

                    allowOutsideClick: false,

                    didOpen: () => Swal.showLoading()

                });



                $.ajax({

                    url: "{{ route('verify.collection.otp') }}",

                    method: 'POST',

                    data: {

                        tracking_id: trackingId,

                        otp: otp,

                    },

                    success: function(response) {

                        Swal.close();



                        if (response.success) {

                            $('#otpVerifyModal').modal('hide');

                            $('#otpCode').val('');



                            $('#sampleTrackingId').val(trackingId);

                            $('#uploadSampleModal').modal('show');

                        } else {

                            Swal.fire('Invalid OTP', response.message || 'Please try again',

                                'error');

                        }

                    },

                    error: function() {

                        Swal.close();

                        Swal.fire('Error', 'Something went wrong. Try again later.', 'error');

                    }

                });

            });





            // Submit form with AJAX

            $('#uploadSampleForm').submit(function(e) {

                e.preventDefault();



                let formData = new FormData(this);



                Swal.fire({

                    title: 'Uploading...',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });



                $.ajax({

                    url: "{{ route('sample-tracking.upload') }}",

                    method: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Success',

                            text: response.message,

                        }).then(() => {

                            location.reload();

                        });

                    },

                    error: function(xhr) {

                        Swal.fire({

                            icon: 'error',

                            title: 'Upload Failed',

                            text: xhr.responseJSON?.message || 'Something went wrong.'

                        });

                    }

                });

            });

        });

        $(document).on('click', '.delete-sample', function(e) {

            e.preventDefault();

            var sampleId = $(this).data('id');



            Swal.fire({

                title: 'Are you sure?',

                text: "This will remove the sample image.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, delete it!',

                cancelButtonText: 'Cancel'

            }).then((result) => {

                if (result.isConfirmed) {



                    // Show SweetAlert loader

                    Swal.fire({

                        title: 'Deleting...',

                        text: 'Please wait',

                        allowOutsideClick: false,

                        allowEscapeKey: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });



                    // AJAX request

                    $.ajax({

                        url: `/sample-tracking/delete-sample/${sampleId}`,

                        type: 'GET',

                        success: function(response) {

                            if (response.success) {

                                // Show success alert

                                Swal.fire({

                                    icon: 'success',

                                    title: 'Deleted!',

                                    text: 'Sample image has been deleted.',

                                    timer: 2000,

                                    showConfirmButton: false

                                });



                                window.location.reload();

                            } else {

                                Swal.fire('Error', 'Failed to delete the sample.', 'error');

                            }

                        },

                        error: function(xhr) {

                            Swal.fire('Error', 'Something went wrong!', 'error');

                        }

                    });

                }

            });

        });



        $(document).on('click', '.final-submit-btn', function() {

            let sampleId = $(this).data('id');



            Swal.fire({

                title: 'Are you sure?',

                html: `

                <strong>Please confirm:</strong><br>

                - You have uploaded the correct sample images.<br>

                - The samples have been submitted to the lab.<br>

                <br><span class="text-danger">After final submit, you won't be able to revert it!</span>

            `,

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Final Submit',

                cancelButtonText: 'Cancel',

                reverseButtons: true,

                allowOutsideClick: false,

                showLoaderOnConfirm: true,

                preConfirm: () => {

                    return $.ajax({

                        url: '/sample-tracking/final-submit/' + sampleId,

                        type: 'POST',

                        data: {

                            _token: '{{ csrf_token() }}'

                        }

                    }).then(response => {

                        if (response.success) {

                            return true;

                        } else {

                            throw new Error('Submission failed.');

                        }

                    }).catch(error => {

                        console.log('XHR Error:', error);

                        Swal.showValidationMessage(

                            `Request failed: ${error}`

                        );

                    });

                }

            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire(

                        'Submitted!',

                        'The sample has been finalized.',

                        'success'

                    ).then(() => {

                        location.reload();

                    });

                }

            });

        });

    </script>

    <script

        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC3KMSw8T8g9IKdJWK18IU0YSkgJN-KeE&libraries=geometry&callback=initMap"

        async defer></script>

    <script>

        let map, phleboMarker, userMarker, directionsService, directionsRenderer;

        const trackingstatus = "{{ $detail->booking_patient->trackBooking->collection_status ?? '' }}";

        const trackingId = "{{ $detail->booking_patient->trackBooking->tracking_id ?? '' }}";



        if (navigator.geolocation) {

            // Update location every 10 seconds

            setInterval(function() {

                if (trackingstatus == 1) {

                    navigator.geolocation.getCurrentPosition(function(position) {

                        let latitude = position.coords.latitude;

                        let longitude = position.coords.longitude;



                        console.log("Sending location:", latitude, longitude);



                        $.ajax({

                            url: "{{ url('api/phlebotomist/update-location') }}",

                            type: "POST",

                            data: {

                                latitude: latitude,

                                longitude: longitude

                            },

                            headers: {

                                "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,

                                "Accept": "application/json"

                            },

                            success: function(response) {

                                console.log("Location updated:", response);

                            },

                            error: function(xhr) {

                                console.error("Failed to update location:", xhr

                                    .responseText);

                            }

                        });

                    });

                }

            }, 10000); // every 10 seconds

        } else {

            alert("Geolocation is not supported by this browser.");

        }



        if (trackingstatus == 1) {

            startCollection(trackingId);

        }



        $(document).on('click', '#startCollectionBtn', function(e) {

            e.preventDefault();

            startCollection(trackingId).then(() => {

                window.location.reload();

            });

        })



        function startCollection(trackingId) {

            $.ajax({

                url: `/api/phlebo/start-collection/${trackingId}`,

                method: "POST",

                headers: {

                    "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,

                    "Accept": "application/json"

                },

                success: function(res) {

                    if (res.success) {

                        Swal.fire({

                            toast: true,

                            position: 'top-end',

                            icon: 'success',

                            title: res.message || 'Collection started',

                            showConfirmButton: false,

                            timer: 2000

                        });

                        $('#phleboMap').show();

                        $('#getDirectionsBtn').show();

                        initMap();

                    }

                },

                error: function(err) {

                    Swal.fire({

                        toast: true,

                        position: 'top-end',

                        icon: 'error',

                        title: 'Failed to start collection',

                        showConfirmButton: false,

                        timer: 2000

                    });

                }

            });

        }



        function initMap() {

            const userLat = {{ $detail->booking?->bookingAddress?->latitude ?? 'null' }};

            const userLng = {{ $detail->booking?->bookingAddress?->longitude ?? 'null' }};





            if (!userLat || !userLng) {

                console.warn("User location not available");

                return;

            }



            // Initialize map

            map = new google.maps.Map(document.getElementById("phleboMap"), {

                zoom: 14,

                center: {

                    lat: userLat,

                    lng: userLng

                },

                mapTypeControl: false,

                streetViewControl: false,

                rotateControl: false,

                tilt: 0,

                fullscreenControl: true,

                gestureHandling: "greedy",

                disableDefaultUI: true,

            });



            directionsService = new google.maps.DirectionsService();

            directionsRenderer = new google.maps.DirectionsRenderer({

                suppressMarkers: true

            });

            directionsRenderer.setMap(map);



            // User marker

            userMarker = new google.maps.Marker({

                position: {

                    lat: userLat,

                    lng: userLng

                },

                map: map,

                icon: {

                    url: "{{ asset('assets/img/user_marker.png') }}",

                    scaledSize: new google.maps.Size(35, 50),

                },

                title: "User Location",

            });



            // Custom phlebo marker

            const phleboIcon = {

                url: "{{ asset('assets/img/ph_marker.png') }}",

                scaledSize: new google.maps.Size(35, 50),

                anchor: new google.maps.Point(25, 25),

            };



            phleboMarker = new google.maps.Marker({

                map: map,

                icon: phleboIcon,

                title: "Phlebotomist",

            });



            // Fetch & update phlebo position

            function updatePhleboLocation() {

                $.ajax({

                    url: `/api/user/track/${trackingId}`,

                    method: "GET",

                    headers: {

                        "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,

                        "Accept": "application/json"

                    },

                    success: function(res) {

                        if (res.latitude && res.longitude) {

                            const newPos = new google.maps.LatLng(res.latitude, res.longitude);



                            moveMarkerSmooth(phleboMarker, newPos);

                            calculateRoute(newPos, new google.maps.LatLng(userLat, userLng));



                            // Update Google Maps Directions URL

                            const directionsUrl =

                                `https://www.google.com/maps/dir/?api=1&origin=${res.latitude},${res.longitude}&destination=${userLat},${userLng}&travelmode=driving`;

                            document.getElementById("getDirectionsBtn").href = directionsUrl;

                        }

                    },

                    error: function(err) {

                        console.error("Tracking failed:", err);

                    }

                });

            }





            // Route calculation

            function calculateRoute(start, end) {

                directionsService.route({

                    origin: start,

                    destination: end,

                    travelMode: google.maps.TravelMode.DRIVING

                }, (response, status) => {

                    if (status === "OK") {

                        // Only render on map, no panel

                        directionsRenderer.setDirections(response);

                    } else {

                        console.error("Directions request failed:", status);

                    }

                });

            }







            // Smooth marker movement

            function moveMarkerSmooth(marker, newPos) {

                const oldPos = marker.getPosition();

                if (!oldPos) {

                    marker.setPosition(newPos);

                    return;

                }

                let i = 0;

                const interval = setInterval(() => {

                    i += 0.05;

                    if (i > 1) {

                        i = 1;

                        clearInterval(interval);

                    }

                    const lat = oldPos.lat() + (newPos.lat() - oldPos.lat()) * i;

                    const lng = oldPos.lng() + (newPos.lng() - oldPos.lng()) * i;

                    marker.setPosition(new google.maps.LatLng(lat, lng));

                }, 50);

            }



            // Start polling

            updatePhleboLocation();

            setInterval(updatePhleboLocation, 15000);

        }

    </script>

@endsection

