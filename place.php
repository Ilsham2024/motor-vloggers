<?php
require 'config.php';
session_start();
if(!isset($_SESSION["id"])){
    header("location: login.php");
    exit;
}

$query = "SELECT * FROM places";
$result = mysqli_query($conn, $query);
$places = [];
while($row = mysqli_fetch_assoc($result)){
    $places[] = $row;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PLACE SUGGESTION | Motor Vloggers Assist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBgxk0h_9oQsqHKYBDrtXTxi95i5SF3uM"></script>
    <link rel="stylesheet" href="newstyle.css">
    <script>
        function redirectToGoogleMaps(destinationLat, destinationLng) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${destinationLat},${destinationLng}&travelmode=two-wheeler`;
                    window.open(googleMapsUrl, '_blank');
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function initStaticMap(placeId, lat, lng) {
            const map = new google.maps.Map(document.getElementById('map-' + placeId), {
                center: {lat: lat, lng: lng},
                zoom: 15
            });
            new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map
            });
        }
    </script>
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
                        <a class="nav-link active" href="place.php">Places</a>
                    </li>
                    <li class="nav-item margin">
                        <a class="nav-link" href="event.php">Events</a>
                    </li>
                    <li class="nav-item margin">
                        <a class="nav-link" href="mechanics.php">Nearby Mechanics</a>
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

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($places as $place):
                $location = json_decode($place['location'], true);
            ?>
                <div class="col-md-6 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="<?php echo $place['image_url']; ?>" class="card-img-top" alt="<?php echo $place['place_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $place['place_name']; ?></h5>
                            <p class="card-text"><?php echo $place['place_description']; ?></p>
                            <div id="map-<?php echo $place['place_id']; ?>" style="height: 300px;"></div>
                            <button class="btn btn-light mt-3" onclick="redirectToGoogleMaps(<?php echo $location['lat']; ?>, <?php echo $location['lng']; ?>)">
                                Show Route
                            </button>
                        </div>
                    </div>
                </div>
                <script>
                    initStaticMap('<?php echo $place['place_id']; ?>', <?php echo $location['lat']; ?>, <?php echo $location['lng']; ?>);
                </script>
            <?php endforeach; ?>
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
                        <div class ="footer-pad custom-footer" style = "margin-left: auto;">
                            <ul class="list-unstyled d-flex">
                                <li class="nav-item mb-2 space">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white;transform: ;msFilter:;margin-top: -5px;">
                                  <path d="m20.487 17.14-4.065-3.696a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a.997.997 0 0 0-.085-1.39z"></path></svg>
                                  0772584692
                                </li>
                                </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class ="footer-pad custom-footer" style = "margin-left: auto;">
                            <ul class="list-unstyled d-flex">
                                <li class="nav-item mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white ;transform: ;msFilter:;">
                                <path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z"></path></svg>
                                motorvloggerassist@gmail.com

                                </li>
                                </ul>
                        </div>
                    </div>

                </div>
		    </div>
		</div>
	</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
