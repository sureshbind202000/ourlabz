@extends('frontend.includes.dashboard_layout')
@section('css')
    <style>
        #map {
            width: 100%;
            height: 200px;
            border-radius: 8px;
        }

        .tracking-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .phlebo-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .phlebo-img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0095d9;
        }

        .phlebo-details {
            display: flex;
            flex-direction: column;
        }

        .phlebo-name {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .phlebo-phone {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .tracking-status {
            text-align: right;
        }

        .eta-text {
            font-weight: 600;
            font-size: 14px;
            color: #222;
        }

        .status-text {
            margin-top: 4px;
            font-size: 14px;
            font-weight: 500;
            color: #0095d9;
        }
    </style>
@endsection

@section('dash_content')
    <div class="user-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="user-card user-track-order">
                    <h4 class="user-card-title">Live Tracking</h4>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="selectTrackingId" class="fw-bold">Select Tracking ID</label>
                            <select name="selectTrackingId" id="selectTrackingId" class="form-select">
                                <option value="">--Select--</option>
                                @foreach ($trackings as $tracking)
                                    <option value="{{ $tracking->tracking_id }}"
                                        data-phname="{{ $tracking->trackSample->phlebotomist->name ?? '-' }}"
                                        data-phphone="{{ $tracking->trackSample->phlebotomist->phone ?? '-' }}"
                                        data-phprofile="{{ $tracking->trackSample->phlebotomist->profile == 'dummy' ? asset('assets/img/user.png') : asset($tracking->trackSample->phlebotomist->profile) }}">
                                        {{ $tracking->patient->name ?? '-' }} |
                                        {{ $tracking->patient->test->package->name ?? '-' }} |
                                        {{ $tracking->tracking_id ?? '-' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="map-div" style="display: none;">
                        <div id="map" class="rounded-bottom-0"></div>
                        <div class="tracking-header card-shadow rounded-top-0">
                            <div class="phlebo-info">
                                <img src="{{ asset('assets/img/phlebo_default.png') }}" alt="Phlebo" class="phlebo-img">
                                <div class="phlebo-details">
                                    <h5 class="phlebo-name">John Doe</h5>
                                    <p class="phlebo-phone">+91 98765 43210</p>
                                </div>
                            </div>
                            <div class="tracking-status">
                                <div id="eta" class="eta-text">Estimated Arrival: calculating...</div>
                                <div id="status" class="status-text">Status: Waiting for Phlebotomist...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

<script>
    let userMarker;
    let phleboMarker;
    let directionsService;
    let directionsRenderer;
    let routePath = [];
    let routeIndex = 0;
    let stepFraction = 0;
    let animationSpeed = 0.095;
    let isAnimating = false;
    let echoInstance = null;
    let currentChannel = null;

    // Helper: calculate bearing
    function getBearing(startLatLng, endLatLng) {
        const startLat = startLatLng.lat() * Math.PI / 180;
        const startLng = startLatLng.lng() * Math.PI / 180;
        const endLat = endLatLng.lat() * Math.PI / 180;
        const endLng = endLatLng.lng() * Math.PI / 180;

        const y = Math.sin(endLng - startLng) * Math.cos(endLat);
        const x = Math.cos(startLat) * Math.sin(endLat) -
            Math.sin(startLat) * Math.cos(endLat) * Math.cos(endLng - startLng);
        const brng = Math.atan2(y, x) * 180 / Math.PI;
        return (brng + 360) % 360;
    }

    // Animate marker
    function animateAlongRoute() {
        if (!routePath.length || !phleboMarker) return;

        if (routeIndex >= routePath.length - 1) {
            isAnimating = false;
            return;
        }

        const current = routePath[routeIndex];
        const next = routePath[routeIndex + 1];

        const lat = current.lat() + (next.lat() - current.lat()) * stepFraction;
        const lng = current.lng() + (next.lng() - current.lng()) * stepFraction;
        const newPos = new google.maps.LatLng(lat, lng);
        phleboMarker.setPosition(newPos);

        const bearing = getBearing(current, next);
        phleboMarker.setIcon({
            url: "{{ asset('assets/img/ph_marker.png') }}",
            scaledSize: new google.maps.Size(35, 50),
            rotation: bearing - 90
        });

        stepFraction += animationSpeed;
        if (stepFraction >= 1) {
            stepFraction = 0;
            routeIndex++;
        }

        requestAnimationFrame(animateAlongRoute);
    }

    // Route + ETA
    function calculateRouteAndETA() {
        if (!userMarker || !phleboMarker) return;

        const origin = phleboMarker.getPosition();
        const destination = userMarker.getPosition();
        if (!origin || !destination) return;

        directionsService.route({
            origin,
            destination,
            travelMode: 'DRIVING'
        }, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);

                routePath = [];
                const legs = result.routes[0].legs;
                legs.forEach(leg => {
                    leg.steps.forEach(step => {
                        step.path.forEach(pt => routePath.push(pt));
                    });
                });

                routeIndex = 0;
                stepFraction = 0;

                if (!isAnimating) {
                    isAnimating = true;
                    animateAlongRoute();
                }
            } else {
                console.error("Directions request failed:", status);
            }
        });

        // ETA
        const service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [origin],
            destinations: [destination],
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC
        }, (response, status) => {
            if (status === 'OK') {
                const element = response.rows[0].elements[0];
                if (element.status === "OK") {
                    const durationText = element.duration.text;
                    const durationVal = element.duration.value;

                    const minutes = Math.round(durationVal / 60);
                    document.getElementById('eta').innerText =
                        `Estimated Arrival: ${durationText}`;

                    let statusMsg = "🚴 On the way";
                    if (minutes <= 5 && minutes > 1) {
                        statusMsg = "🏠 Arriving at your location";
                    } else if (minutes <= 1) {
                        statusMsg = "✅ Reached";
                    }
                    document.getElementById('status').innerText = `Status: ${statusMsg}`;
                }
            }
        });
    }

    // Update phlebo
    function updatePhleboMarker(lat, lng) {
        lat = parseFloat(lat);
        lng = parseFloat(lng);
        if (!isFinite(lat) || !isFinite(lng)) return;

        const newPos = new google.maps.LatLng(lat, lng);
        phleboMarker.setPosition(newPos);
        map.panTo(newPos);
        calculateRouteAndETA();
    }

    // Map init
    function initMap(center) {
        map = new google.maps.Map(document.getElementById("map"), {
            center: center,
            zoom: 15,
            disableDefaultUI: true
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers: true
        });

        // User marker
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const userPos = {
                    lat: pos.coords.latitude,
                    lng: pos.coords.longitude
                };
                userMarker = new google.maps.Marker({
                    position: userPos,
                    map: map,
                    icon: {
                        url: "{{ asset('assets/img/user_marker.png') }}",
                        scaledSize: new google.maps.Size(35, 50)
                    }
                });
                calculateRouteAndETA();
            });
        }

        // Phlebo marker
        phleboMarker = new google.maps.Marker({
            position: center,
            map: map,
            icon: {
                url: "{{ asset('assets/img/ph_marker.png') }}",
                scaledSize: new google.maps.Size(35, 50)
            }
        });
    }

    // Pusher init
    function initEcho(phleboId) {
        if (!echoInstance) {
            echoInstance = new Echo({
                broadcaster: 'pusher',
                key: "{{ config('broadcasting.connections.pusher.key') }}",
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                forceTLS: true
            });
        }

        if (currentChannel) {
            echoInstance.leave(currentChannel);
        }

        currentChannel = `phlebo-tracking.${phleboId}`;

        echoInstance.channel(currentChannel)
            .listen('.LocationUpdated', e => {
                updatePhleboMarker(e.latitude, e.longitude);
            });
    }

    // Load map
    function loadTrackingMap(trackingId) {
        if (!trackingId) return;

        fetch(`/api/user/track/${trackingId}`, {
                headers: {
                    "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
                    "Accept": "application/json"
                }
            }).then(res => res.json())
            .then(data => {
                if (data.collection_status == 1) {
                    const center = {
                        lat: parseFloat(data.latitude) || 12.9716,
                        lng: parseFloat(data.longitude) || 77.5946
                    };
                    $('#map-div').show();
                    initMap(center);
                    initEcho(data.phlebo_id);
                } else {
                    $('#map-div').show().html(
                        `<p style='color:red; font-weight:bold;'>Tracking will be available once phlebotomist starts collection.</p>`
                    );
                }
            })
            .catch(err => {
                console.error("Failed to fetch tracking status:", err);
                $('#map-div').show().html(
                    `<p style='color:red; font-weight:bold;'>Tracking unavailable.</p>`
                );
            });
    }

    // Event bindings
    document.addEventListener("DOMContentLoaded", function() {
        // dropdown change
        $('#selectTrackingId').on('change', function() {
            const trackingId = $(this).val();

            if (trackingId) {
                const option = $(this).find(':selected');
                $('.phlebo-name').text(option.data('phname') || '-');
                $('.phlebo-phone').text(option.data('phphone') || '-');
                $('.phlebo-img').attr('src', option.data('phprofile') ||
                    "{{ asset('assets/img/phlebo_default.png') }}");

                loadTrackingMap(trackingId);
            } else {
                $('#map-div').hide();
            }
        });
    });

    // Update ETA every 10s
    setInterval(calculateRouteAndETA, 10000);
</script>
@endsection

