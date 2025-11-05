<div id="{{ $mapId }}" {{ $attributes->merge(['class' => 'w-full']) }}  style="height: {{ $height }}"></div>


<script>
    (function() {
        // Use a unique function name to avoid conflicts
        const uniqueMapId = "{{ $mapId }}";

        window['initMap_' + uniqueMapId] = function() {
            console.log("initMap called for:", uniqueMapId);

            const map = new google.maps.Map(document.getElementById(uniqueMapId), {
                zoom: {{ $zoom }},
                center: { lat: {{ $centerLat }}, lng: {{ $centerLng }} },
                zoomControl: true,
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: false,
                mapTypeControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                gestureHandling: 'cooperative',
                mapId: uniqueMapId
            });

            // Create My Location Button
            const locationButton = document.createElement("button");
            locationButton.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="8" fill="#4285F4"/>
                    <circle cx="12" cy="12" r="3" fill="#fff"/>
                    <path d="M12 2v3M12 19v3M2 12h3M19 12h3" stroke="#4285F4" stroke-width="2" stroke-linecap="round"/>
                </svg>
            `;
            locationButton.title = "Show your location";

            // Style the button
            locationButton.style.backgroundColor = "#fff";
            locationButton.style.border = "none";
            locationButton.style.borderRadius = "2px";
            locationButton.style.boxShadow = "0 1px 4px rgba(0,0,0,0.3)";
            locationButton.style.cursor = "pointer";
            locationButton.style.margin = "10px";
            locationButton.style.padding = "8px";
            locationButton.style.width = "40px";
            locationButton.style.height = "40px";
            locationButton.style.display = "flex";
            locationButton.style.alignItems = "center";
            locationButton.style.justifyContent = "center";

            locationButton.addEventListener("mouseover", () => {
                locationButton.style.backgroundColor = "#ebebeb";
            });

            locationButton.addEventListener("mouseout", () => {
                locationButton.style.backgroundColor = "#fff";
            });

            // Add the button to the map
            map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(locationButton);

            // User location marker
            let userLocationMarker = null;

            // Handle location button click
            locationButton.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

                console.log("Location button clicked");
                console.log("Geolocation available:", !!navigator.geolocation);

                if (!navigator.geolocation) {
                    alert("Geolocation is not supported by your browser.");
                    return;
                }

                const originalContent = locationButton.innerHTML;
                locationButton.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#666" stroke-width="2" fill="none" opacity="0.3"/>
                        <path d="M12 2 A10 10 0 0 1 22 12" stroke="#4285F4" stroke-width="2" fill="none" stroke-linecap="round">
                            <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                        </path>
                    </svg>
                `;
                locationButton.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        console.log("Successfully got position:", position.coords);

                        const userPos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        // Center map on user's location
                        map.setCenter(userPos);
                        map.setZoom(15);

                        // Remove old marker if exists
                        if (userLocationMarker) {
                            userLocationMarker.setMap(null);
                        }

                        // Add marker at user's location
                        userLocationMarker = new google.maps.Marker({
                            position: userPos,
                            map: map,
                            title: "Your Location",
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 10,
                                fillColor: "#4285F4",
                                fillOpacity: 1,
                                strokeColor: "#ffffff",
                                strokeWeight: 3,
                            },
                            zIndex: 9999
                        });

                        locationButton.innerHTML = originalContent;
                        locationButton.disabled = false;
                    },
                    (error) => {
                        console.error("Geolocation error:", error);
                        console.error("Error code:", error.code);
                        console.error("Error message:", error.message);

                        let errorMessage = "Unable to get your location.";

                        if (error.code === 1) { // PERMISSION_DENIED
                            errorMessage = "Location permission denied. Please enable location access.";
                        } else if (error.code === 2) { // POSITION_UNAVAILABLE
                            errorMessage = "Location information unavailable.";
                        } else if (error.code === 3) { // TIMEOUT
                            errorMessage = "Location request timed out.";
                        }

                        alert(errorMessage);
                        locationButton.innerHTML = originalContent;
                        locationButton.disabled = false;
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            });

            const pinData = {!! $pinsJson !!};

            function createCustomMarker(color, overlayImageURL) {
                const basePinUrl = '/assets/images/' + color + '-pin.png';
                return new Promise((resolve, reject) => {
                    const canvas = document.createElement("canvas");
                    canvas.width = 81;
                    canvas.height = 120.45;
                    const ctx = canvas.getContext("2d");

                    const baseImg = new Image();
                    const overlayImg = new Image();

                    baseImg.crossOrigin = "anonymous";
                    overlayImg.crossOrigin = "anonymous";

                    baseImg.onload = () => {
                        ctx.drawImage(baseImg, 0, 0, canvas.width, canvas.height);

                        overlayImg.onload = () => {
                            const cx = 39;
                            const cy = 43.7;
                            const r = 31;

                            ctx.save();
                            ctx.beginPath();
                            ctx.arc(cx, cy, r, 0, Math.PI * 2);
                            ctx.closePath();
                            ctx.clip();

                            ctx.drawImage(overlayImg, cx - r, cy - r, r * 2, r * 2);
                            ctx.restore();

                            const img = document.createElement("img");
                            img.src = canvas.toDataURL();
                            img.style.width = "40px";
                            img.style.height = "56px";

                            resolve(img);
                        };

                        overlayImg.onerror = reject;
                        overlayImg.src = overlayImageURL;
                    };

                    baseImg.onerror = reject;
                    baseImg.src = basePinUrl;
                    console.log(basePinUrl);
                });
            }

            const infoWindow = new google.maps.InfoWindow();

            const markerPromises = pinData.map(pin => {
                if (pin.color === 'default') {
                    const marker = new google.maps.Marker({
                        map: map,
                        position: pin.position,
                        title: pin.description || '',
                        icon: {
                            url: '/assets/images/default-pin.png',
                            scaledSize: new google.maps.Size(40, 56),
                            anchor: new google.maps.Point(20, 56),
                        }
                    });
                    return Promise.resolve(marker);
                } else {
                    // Custom marker with overlay + click event
                    return createCustomMarker(pin.color, pin.logo)
                        .then(markerContent => {
                            const marker = new google.maps.marker.AdvancedMarkerElement({
                                map: map,
                                position: pin.position,
                                content: markerContent
                            });

                            marker.addListener("click", () => {
                                infoWindow.close();
                                infoWindow.setContent(`
                                    <div style="width: 267px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; border-radius: 20px; overflow: hidden;">
                                        <div style="position: relative; height: 130px; overflow: hidden;">
                                            <img src="${pin.image}" alt="Location" style="width: 100%; height: 100%; object-fit: cover; display: block;" />
                                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);"></div>
                                        </div>
                                        <div style="padding: 20px; background: #fff;">
                                            <p style="margin: 0 0 20px 0; font-size: 15px; line-height: 1.6; color: #4a5568;">${pin.description}</p>
                                            <a href="${pin.redirect}" target="_blank" style="display: block; text-align: center; padding: 14px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all 0.3s ease;">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                `);
                                infoWindow.open(map, marker);
                            });

                            return marker;
                        })
                        .catch(error => {
                            console.error("Error creating AdvancedMarkerElement:", error);
                            return null;
                        });
                }
            });


            Promise.all(markerPromises).then(markers => {
                const validMarkers = markers.filter(Boolean);
                new markerClusterer.MarkerClusterer({
                    map,
                    markers: validMarkers
                });
            });
        };

        // Set as global initMap if not already set
        if (!window.initMap) {
            window.initMap = window['initMap_' + uniqueMapId];
        }
    })();
</script>


<!-- Google Maps JS API with Advanced Markers enabled -->
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('autoc.map_key') }}&libraries=marker,places&callback=initMap&loading=async"
    async
    defer>
</script>

<!-- Marker Clusterer -->
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
