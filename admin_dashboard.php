<?php
require 'config.php';
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit();
}

if(isset($_POST['place'])){
    header("location: add_places.php");
}

if(isset($_POST['manage_place'])){
    header("location: manage_place.php");
}

?>


<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Elastic Image Slideshow with Thumbnail Preview" />
		<meta name="keywords" content="jquery, css3, responsive, image, slider, slideshow, thumbnails, preview, elastic" />
		<meta name="author" content="Codrops" />


        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <title>DASHBOARD | Motor Vloggers Assist</title>

        <link rel="stylesheet" href="newstyle.css">
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item margin">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

<form method = "POST">
    <br><br>
    <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-dark btn-lg my-2" type ="submit" name="place">Add places</button>
    </div>

    <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-dark btn-lg my-2" type ="submit" name="manage_place">Manage place</button>
    </div>
</form>



    <footer class="mainfooter bg-black fixed-bottom font" role="contentinfo">
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

    <script>
        function place() {
            header('location:place.php');
        }

        function startRide() {
            alert('Start Ride clicked');
        }

        function eventDiscovery() {
            alert('Event Discovery clicked');
        }

        function nearbyMechanics() {
            alert('Nearby Mechanics clicked');
        }

        function liveChat() {
            alert('Live Chat clicked');
        }
    </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

      </body>

</html>
