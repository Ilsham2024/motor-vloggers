<?php
require 'config.php';

session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['get_id'])) {
    $event_id = (int)$_GET['get_id'];
} else {
    die('No event ID provided.');
}

if (isset($_POST['login'])) {
    $user_id = $_SESSION["id"];
    $email = $_POST['email'];

    // Fetch the event details to check the max participants
    $event_query = "SELECT * FROM event WHERE event_id = '$event_id'";
    $event_result = mysqli_query($conn, $event_query);
    $event = mysqli_fetch_assoc($event_result);

    if (!$event) {
        die('Event not found.');
    }

    $max_participants = $event['max_participants'];

    // Check how many users have already signed up for this event
    $check_signup_query = "SELECT COUNT(*) as total_signups FROM event_signup WHERE event_id = '$event_id'";
    $check_signup_result = mysqli_query($conn, $check_signup_query);
    $signup_data = mysqli_fetch_assoc($check_signup_result);
    $total_signups = $signup_data['total_signups'];

    // Check if the number of signups has reached the max participants
    if ($total_signups >= $max_participants) {
        echo "<script>alert('Sorry, the event is full. You cannot sign up.'); window.location.href='event.php';</script>";
    } else {
        // Check if the user has already signed up for this event
        $check_query = "SELECT * FROM event_signup WHERE event_id = '$event_id' AND user_id = '$user_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // User already signed up for this event
            echo "<script>alert('You have already signed up for this event.'); window.location.href='event.php';</script>";
        } else {
            // Insert the signup record
            $query = "INSERT INTO event_signup (event_id, user_id, email) VALUES ('$event_id', '$user_id', '$email')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Sign-up successful!'); window.location.href='event.php';</script>";
            } else {
                echo "<script>alert('Error signing up. Please try again.'); window.location.href='event.php';</script>";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newstyle.css">
    <title>SIGN UP | Motor Vloggers Assist</title>
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
                <li class="nav-item margin"><a class="nav-link" href="place.php">Places</a></li>
                <li class="nav-item margin"><a class="nav-link" href="event.php">Events</a></li>
                <li class="nav-item margin"><a class="nav-link" href="mechanics.php">Nearby Mechanics</a></li>
                <li class="nav-item margin"><a class="nav-link" href="ride.php">Start Ride</a></li>
                <li class="nav-item margin"><a class="nav-link" href="chat.php">Live Chat</a></li>
                <li class="nav-item margin"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1 font-color">
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                        <form class="mx-1 mx-md-4" method="POST">
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="email" id="email" name="email" class="form-control" required />
                                    <label class="form-label" for="email">Email</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                <button type="submit" name="login" id="login" class="btn btn-dark btn-lg">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mainfooter bg-black fixed-bottom font" role="contentinfo">
    <div class="footer-middle">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 col-sm-7">
                    <div class="footer-pad custom-footer">
                        <p>Four wheels move the body but two wheels move the soul</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="footer-pad custom-footer" style="margin-left: auto;">
                        <ul class="list-unstyled d-flex">
                            <li class="nav-item mb-2 space">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white;transform: ;msFilter:;margin-top: -5px;">
                                    <path d="m20.487 17.14-4.065-3.696a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a.997.997 0 0 0-.085-1.39z"></path>
                                </svg> 0772584692
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-pad custom-footer" style="margin-left: auto;">
                        <ul class="list-unstyled d-flex">
                            <li class="nav-item mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white;transform: ;msFilter:;">
                                    <path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z"></path>
                                </svg> motorvloggerassist@gmail.com
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
