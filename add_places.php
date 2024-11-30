<?php
require 'config.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit();
}

if (isset($_POST['create_place'])) {
    $place_name = $_POST['place_name'];
    $type = $_POST['type'];
    $description = $_POST['place_description'];
    $location_input = $_POST['location']; // Single input for lat,lng
    $image_url = $_POST['image_url']; // Use online image URL

    // Parse the latitude and longitude from the input
    $location_parts = explode(',', $location_input);
    if (count($location_parts) == 2) {
        $latitude = (float)trim($location_parts[0]);
        $longitude = (float)trim($location_parts[1]);

        // Combine latitude and longitude into JSON
        $location = json_encode([
            "lat" => $latitude,
            "lng" => $longitude
        ]);

        // Validate the image URL
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            // Insert place data into the database
            $query = "INSERT INTO places (place_name, type, place_description, location, image_url)
                      VALUES ('$place_name', '$type', '$description', '$location', '$image_url')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Place created successfully');</script>";
            } else {
                echo "<script>alert('Database error: Unable to create place');</script>";
            }
        } else {
            echo "<script>alert('Invalid image URL');</script>";
        }
    } else {
        echo "<script>alert('Invalid location format. Use: latitude,longitude');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Place | Motor Vloggers Assist</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="newstyle.css">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand nav-link active" aria-current="page" href="index.php">
                <img src="neww.jpg" alt="Motor Vloggers Assist" width="180" height="150">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 nav-custom font">
                    <li class="nav-item margin">
                        <a class="nav-link" href="admin_dashboard.php">Dash Board</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 font-color">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Add New Place</p>
                                <form class="mx-1 mx-md-4" method="POST">
                                    <div class="mb-4">
                                        <label class="form-label" for="place_name">Place Name</label>
                                        <input type="text" id="place_name" name="place_name" class="form-control" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="type">Place Type</label>
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="">Select place type...</option>
                                            <option value="Natural">Natural</option>
                                            <option value="Architectural">Architectural</option>
                                            <option value="Mountain">Mountain</option>
                                            <option value="Beach">Beach</option>
                                            <option value="Historical Site">Historical Site</option>
                                            <option value="Park">Park</option>
                                            <option value="Urban">Urban</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="place_description">Place Description</label>
                                        <textarea id="place_description" name="place_description" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="location">Location (Latitude,Longitude)</label>
                                        <input type="text" id="location" name="location" class="form-control" placeholder="e.g., 6.773735,80.831160" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="image_url">Image URL</label>
                                        <input type="url" id="image_url" name="image_url" class="form-control" placeholder="Enter image URL" required />
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" name="create_place" class="btn btn-dark btn-lg">Create Place</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Updated Footer -->
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
