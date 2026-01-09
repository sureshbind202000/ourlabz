<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC3KMSw8T8g9IKdJWK18IU0YSkgJN-KeE&libraries=marker,places&callback=initGoogle&loading=async"
    async defer></script>
<script>
    function initGoogle() {
        if (document.getElementById("searchCityLocation")) {
            initAutocomplete();
        }
        if (document.getElementById("map")) {
            initMap();
        }
    }
    let autocomplete;
    let debounceTimer;

    function initAutocomplete() {
        const input = document.getElementById('searchCityLocation');

        // Wrap Autocomplete in a debounce
        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                if (!autocomplete) {
                    autocomplete = new google.maps.places.Autocomplete(input, {
                        types: ['(cities)']
                    });

                    // On place selection
                    autocomplete.addListener("place_changed", function() {
                        let place = autocomplete.getPlace();
                        if (!place.geometry) {
                            console.log("No geometry found for input");
                            return;
                        }

                        let city = place.name;

                        // fallback if place.name missing
                        if (!city && place.address_components) {
                            let locality = place.address_components.find(c => c.types.includes(
                                "locality"));
                            if (locality) city = locality.long_name;
                        }

                        $('#searchCityLocation').val(city);
                        setCity(city);
                    });
                }
            }, 500);
        });
    }

    let map;
    let marker;
    let selectedType = null;

    function initMap() {
        // Try to detect user location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                renderMap(userPos);
            }, function() {
                // fallback to Bangalore if denied
                renderMap({
                    lat: 12.9716,
                    lng: 77.5946
                });
            });
        } else {
            // fallback if geolocation not supported
            renderMap({
                lat: 12.9716,
                lng: 77.5946
            });
        }
    }

    function renderMap(center) {
        map = new google.maps.Map(document.getElementById("map"), {
            center: center,
            zoom: 15,
        });

        // Place marker on center by default
        marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: true, // allow drag
            icon: {
                url: "/assets/img/location_marker.png", // custom icon
                scaledSize: new google.maps.Size(48, 48) // resize if needed
            }
        });

        // update hidden fields immediately
        saveLatLng(center);

        // When user clicks anywhere on map, move marker
        map.addListener("click", function(e) {
            marker.setPosition(e.latLng);
            saveLatLng(e.latLng);
        });

        // When marker dragged
        marker.addListener("dragend", function(e) {
            saveLatLng(e.latLng);
        });

        // Handle recenter button
        document.getElementById("recenterMap").addEventListener("click", () => {
            showMapLoading(true);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((pos) => {
                    const current = {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude
                    };
                    map.setCenter(current);
                    marker.setPosition(current);
                    saveLatLng(current);
                    showMapLoading(false);
                }, () => {
                    alert("Unable to fetch location");
                    showMapLoading(false);
                });
            } else {
                alert("Geolocation not supported!");
                showMapLoading(false);
            }
        });
    }

    function saveLatLng(latLng) {
        let lat, lng;

        // Handle both google.maps.LatLng object and plain object
        if (typeof latLng.lat === "function") {
            lat = latLng.lat();
            lng = latLng.lng();
        } else {
            lat = latLng.lat;
            lng = latLng.lng;
        }

        if (selectedType === "add") {
            $('#latitude').val(lat);
            $('#longitude').val(lng);
            $('#google_map_location').val(`https://www.google.com/maps?q=${lat},${lng}`);
        } else if (selectedType === "edit") {
            $('#edit_latitude').val(lat);
            $('#edit_longitude').val(lng);
            $('#edit_google_map_location').val(`https://www.google.com/maps?q=${lat},${lng}`);
        }
    }

    function showMapLoading(show) {
        document.getElementById("mapLoading").style.display = show ? "flex" : "none";
    }



    // 1️⃣ Auto-detect location if no city in session
    @if (!session('selected_city'))
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;

                $.post("{{ route('get.city') }}", {
                    lat: lat,
                    lng: lon
                }, function(response) {
                    if (response.city) {
                        console.log(response.city);
                        setCity(response.city);
                    } else {
                        $('#exampleModalToggle').modal('show');
                    }
                }).fail(function() {
                    $('#exampleModalToggle').modal('show');
                });

            }, function() {
                $('#exampleModalToggle').modal('show');
            });
        } else {
            $('#exampleModalToggle').modal('show');
        }
    @else
        renderCity("{{ session('selected_city') }}");
    @endif

    // 3️⃣ Select city from suggestion list
    $(document).on('click', '.city-icon', function() {
        let selectedCity = $(this).data('city');
        setCity(selectedCity);
        $('#exampleModalToggle').modal('hide');
    });

    // 4️⃣ Function to save city in session via AJAX
    function setCity(city) {
        $.ajax({
            url: "{{ route('set.city') }}",
            method: "POST",
            data: {
                city: city
            },
            success: function(res) {
                if (res.success) {
                    renderCity(res.city);
                    setTimeout(() => location.reload(), 500); // reload once if needed
                }
            }
        });
    };

    function renderCity(city) {
        $('#selectedCityLabel').val(city);
        $('#selectedCityLabel2').val(city);
        $('#selectedCityLabel3').val(city);
    }
</script>
