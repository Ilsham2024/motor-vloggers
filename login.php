<?php
require 'config.php';
session_start();
ob_start(); // Start output buffering to prevent header issues
unset($_SESSION['id']);

if (isset($_POST['login'])) {
    // Sanitize user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Prepare query to check if the user exists
    $query = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password using password_hash
        if (password_verify($password, $row['password'])) {
            $_SESSION["id"] = $row["user_id"];
            // Check if the user is an admin
            if ($row['is_admin'] == 1) {
                header("location: admin_dashboard.php");
                exit(); // Ensure redirection stops further execution
            } else {
                header("location: dashboard.php");
                exit();
            }
        } else {
            echo "<script> alert('Incorrect password'); </script>";
        }
    } else {
        echo "<script> alert('User not registered'); </script>";
    }

    $stmt->close();
    $conn->close();
}
?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN | Motor Vloggers Assist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newstyle.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top font">
    <div class="container-fluid">
        <a class="navbar-brand nav-link active" href="index.php"><img src="neww.jpg" alt="Motor Vloggers Assist" width="180" height="150"></a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card-body p-md-5 font-color">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>
                        <form class="mx-1 mx-md-4" method="POST">
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control" required />
                                <label class="form-label" for="email">Email</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" required />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                <button type="submit" name="login" class="btn btn-dark btn-lg">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mainfooter bg-black font" role="contentinfo">
    <div class="footer-middle">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 col-sm-7">
                    <p>four wheels move the body but two wheels move the soul</p>
                </div>
                <div class="col-md-2">
                    <ul class="list-unstyled d-flex">
                        <li>0772584692</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled d-flex">
                        <li>motorvloggerassist@gmail.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
