<?php
require 'config.php';
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nearby Mechanics Map">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>NEARBY MECHANICS | Motor Vloggers Assist</title>
    <link rel="stylesheet" href="newstyle.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand nav-link active" aria-current="page" href="index.php"><img src="neww.jpg" alt="Motor Vloggers Assist" width="180" height="150"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 nav-custom font">
                <li class="nav-item margin">
                    <a class="nav-link" href="place.php">Places</a>
                </li>
                <li class="nav-item margin">
                    <a class="nav-link" href="event.php">Events</a>
                </li>
                <li class="nav-item margin">
                    <a class="nav-link active" href="mechanics.php">Nearby Mechanics</a>
                </li>
                <li class="nav-item margin">
                    <a class="nav-link" href="ride.php">Start Ride</a>
                </li>
                <li class="nav-item margin">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
<p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 font-color">Nearby Mechanics</p>

    <!-- Display map -->
    <div id="map" style="height: 500px;"></div>

    <!-- List of mechanics below the map -->
    <div id="mechanics-list" class="mt-3">
    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 font-color">Mechanics List</p>
        <ul id="mechanics-ul" class="list-group"></ul>
    </div>
</div>

<footer class="mainfooter bg-black font" role="contentinfo">
    <div class="footer-middle">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 col-sm-7">
                    <div class="footer-pad custom-footer ">
                        <p>four wheels move the body but two wheels move the soul</p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="footer-pad custom-footer" style="margin-left: auto;">
                        <ul class="list-unstyled d-flex">
                            <li class="nav-item mb-2 space">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white;transform: ;msFilter:;margin-top: -5px;">
                                  <path d="m20.487 17.14-4.065-3.696a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a.997.997 0 0 0-.085-1.39z"></path>
                                </svg>
                                0772584692
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="footer-pad custom-footer" style="margin-left: auto;">
                        <ul class="list-unstyled d-flex">
                            <li class="nav-item mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white ;transform: ;msFilter:;">
                                <path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z"></path>
                                </svg>
                                motorvloggerassist@gmail.com
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
// Ensure the initMap function is available globally
let userLocation = null;
let map, service, infowindow;
let userLat, userLng;

function initMap() {
    // Initialize map centered around user's location
    infowindow = new google.maps.InfoWindow();

    // Try to get user's location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            userLat = position.coords.latitude;
            userLng = position.coords.longitude;

            userLocation = new google.maps.LatLng(userLat, userLng);

            map = new google.maps.Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 13
            });

            const marker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: "Your Location"
            });

            service = new google.maps.places.PlacesService(map);
            searchNearbyMechanics(userLat, userLng, 2000); // Start with a 2km search radius
        });
    } else {
        alert("Geolocation not supported by this browser.");
    }
}

function searchNearbyMechanics(lat, lng, radius) {
    const request = {
        location: new google.maps.LatLng(lat, lng),
        radius: radius,
        type: ['bicycle_store'] // Search for bike repair shops
    };

    service.nearbySearch(request, function(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            displayMechanicsOnMap(results);
            displayMechanicsList(results, lat, lng);
        } else {
            if (radius === 2000) {
                searchNearbyMechanics(lat, lng, 5000); // Expand search to 5km if no results within 2km
            } else {
                alert("No mechanics found within 5km.");
            }
        }
    });
}

function displayMechanicsOnMap(results) {
    results.forEach(function(place) {
        const marker = new google.maps.Marker({
            position: place.geometry.location,
            map: map,
            title: place.name
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                'Address: ' + place.vicinity + '</div>');
            infowindow.open(map, this);
        });
    });
}

function displayMechanicsList(results, userLat, userLng) {
    const mechanicsList = document.getElementById('mechanics-ul');
    mechanicsList.innerHTML = ""; // Clear previous list

    results.forEach(function(place) {
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item';

        // Check opening hours
        let isOpen = 'N/A';
        if (place.opening_hours) {
            isOpen = place.opening_hours.open_now ? 'Open Now' : 'Closed Now';
        }

        // Calculate distance to mechanic
        const mechanicLat = place.geometry.location.lat();
        const mechanicLng = place.geometry.location.lng();
        const mechanicLocation = new google.maps.LatLng(mechanicLat, mechanicLng);
        const distance = google.maps.geometry.spherical.computeDistanceBetween(userLocation, mechanicLocation);

        listItem.innerHTML = `<strong>${place.name}</strong><br>
                             Address: ${place.vicinity}<br>
                             Distance: ${(distance / 1000).toFixed(2)} km<br>
                             Status: <span class="text-${isOpen === 'Open Now' ? 'success' : 'danger'}">${isOpen}</span>`;
        mechanicsList.appendChild(listItem);
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBgxk0h_9oQsqHKYBDrtXTxi95i5SF3uM&callback=initMap&libraries=places,geometry" async defer></script>

</body>

</html>
