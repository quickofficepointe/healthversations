let map;
let marker;

function initMap(latitude, longitude) {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: latitude, lng: longitude },
        zoom: 15,
    });

    marker = new google.maps.Marker({
        position: { lat: latitude, lng: longitude },
        map: map,
        draggable: true,
    });

    google.maps.event.addListener(marker, 'dragend', function () {
        updateAddressFromMarker();
    });
}

function updateAddressFromMarker() {
    const geocoder = new google.maps.Geocoder();
    const latLng = marker.getPosition();

    geocoder.geocode({ location: latLng }, (results, status) => {
        if (status === "OK" && results[0]) {
            document.getElementById("address").value = results[0].formatted_address;
        } else {
            alert("Unable to retrieve address");
        }
    });
}
function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                initMap(userLocation.lat, userLocation.lng);
                updateAddressFromMarker();
            },
            (error) => {
                alert("Unable to retrieve your location. Please enable location access.");
                console.error(error);
            }
        );
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}
