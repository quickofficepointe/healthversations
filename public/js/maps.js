let map;
let marker;
let userLocation;

function initMap(latitude, longitude) {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: latitude, lng: longitude },
        zoom: 15,
    });

    marker = new google.maps.Marker({
        position: { lat: latitude, lng: longitude },
        map: map,
        draggable: true, // Allow the user to adjust the marker
    });

    // Update the address input when the marker is dragged
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
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                initMap(userLocation.lat, userLocation.lng);
                updateAddressFromMarker();
            },
            () => {
                alert("Unable to retrieve your location");
            }
        );
    } else {
        alert("Geolocation is not supported by your browser");
    }
}

function toggleOrderType(type) {
    let pickupForm = document.getElementById("pickupForm");
    let deliveryForm = document.getElementById("deliveryForm");
    let pickupBtn = document.getElementById("pickupBtn");
    let deliveryBtn = document.getElementById("deliveryBtn");

    if (type === 'pickup') {
        pickupForm.classList.remove("hidden");
        deliveryForm.classList.add("hidden");
        document.getElementById("deliveryCost").textContent = '$0';
        updateTotalPrice();
        pickupBtn.classList.add("bg-gray-300");
        deliveryBtn.classList.remove("bg-gray-300");
    } else {
        deliveryForm.classList.remove("hidden");
        pickupForm.classList.add("hidden");
        getUserLocation();
        deliveryBtn.classList.add("bg-gray-300");
        pickupBtn.classList.remove("bg-gray-300");
    }
}

function updateTotalPrice() {
    let basePrice = 100; // Example base price
    let deliveryCost = parseFloat(document.getElementById("deliveryCost").textContent.replace('$', ''));
    document.getElementById("finalPrice").textContent = '$' + (basePrice + deliveryCost);
}

function initMap(latitude, longitude) {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: latitude, lng: longitude },
        zoom: 15,
    });

    marker = new google.maps.Marker({
        position: { lat: latitude, lng: longitude },
        map: map,
        draggable: true, // Allow the user to adjust the marker
    });

    // Update the address input when the marker is dragged
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
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                initMap(userLocation.lat, userLocation.lng);
                updateAddressFromMarker();
            },
            () => {
                alert("Unable to retrieve your location");
            }
        );
    } else {
        alert("Geolocation is not supported by your browser");
    }
}

function toggleOrderType(type) {
    let pickupForm = document.getElementById("pickupForm");
    let deliveryForm = document.getElementById("deliveryForm");
    let pickupBtn = document.getElementById("pickupBtn");
    let deliveryBtn = document.getElementById("deliveryBtn");

    if (type === 'pickup') {
        pickupForm.classList.remove("hidden");
        deliveryForm.classList.add("hidden");
        document.getElementById("deliveryCost").textContent = '$0';
        updateTotalPrice();
        pickupBtn.classList.add("bg-gray-300");
        deliveryBtn.classList.remove("bg-gray-300");
    } else {
        deliveryForm.classList.remove("hidden");
        pickupForm.classList.add("hidden");
        getUserLocation();
        deliveryBtn.classList.add("bg-gray-300");
        pickupBtn.classList.remove("bg-gray-300");
    }
}

function updateTotalPrice() {
    let basePrice = 35; // Example base price
    let deliveryCost = parseFloat(document.getElementById("deliveryCost").textContent.replace('$', ''));
    document.getElementById("finalPrice").textContent = '$' + (basePrice + deliveryCost);
}
