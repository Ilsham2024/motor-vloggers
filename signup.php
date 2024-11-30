<?php
require 'config.php';

if (isset($_POST['signup'])) {
    // Sanitize and validate user input
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmPassword'];

    // Validate email and name uniqueness
    $query = "SELECT * FROM user WHERE email = ? OR name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script> alert('Username or email is already taken'); </script>";
    } else if (empty($password)) {
        echo "<script> alert('Please enter a valid password'); </script>";
    } else if ($password !== $confirmpassword) {
        echo "<script> alert('Passwords do not match'); </script>";
    } else {
        // Hash the password securely before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user data into the database
        $query = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script> alert('Registration complete'); </script>";
            header("location: login.php");
        } else {
            echo "<script> alert('Error during registration. Please try again later.'); </script>";
        }
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
    <title>SIGN UP | Motor Vloggers Assist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newstyle.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
    <div class="container-fluid font">
        <a class="navbar-brand nav-link active" href="index.php"><img src="neww.jpg" alt="Motor Vloggers Assist" width="180" height="150"></a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link active" href="signup.php">Sign Up</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card-body p-md-5">
                <div class="row justify-content-center font-color">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                        <form class="mx-1 mx-md-4" method="POST">
                            <div class="form-outline mb-4">
                                <input type="text" id="name" name="name" class="form-control" required />
                                <label class="form-label" for="name">Name</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control" required />
                                <label class="form-label" for="email">Email</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" required />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required />
                                <label class="form-label" for="confirmPassword">Confirm password</label>
                            </div>

                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                <button type="submit" name="signup" class="btn btn-dark btn-lg">Sign up</button>
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
