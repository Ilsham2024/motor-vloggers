<?php
require 'config.php';
session_start();
if(!isset($_SESSION["id"])){
    header("location: login.php");
}



if(isset($_POST['create'])){
  $user_id = $_SESSION["id"];
  $name = $_POST['name'];
  $type = $_POST['type'];
  $min_participants = $_POST['min_participants'];
  $max_participants = $_POST['max_participants'];
  $location = $_POST['location'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $date = $_POST['date'];
  $description = $_POST['description'];

    $query = "INSERT INTO event(user_id, event_name, event_type, min_participants, max_participants, event_location, event_date, start_time, end_time, event_description) VALUES('$user_id','$name','$type', '$min_participants', '$max_participants', '$location', '$date', '$start_time', '$end_time', '$description')";
    mysqli_query($conn,$query);
    echo
      "<script> alert('event created successesfully'); </script>";

}

//$query=mysqli_query($conn,"SELECT * FROM event");
//$rec=mysqli_fetch_assoc($query);
//echo json_encode($rec);

$host = 'localhost';
$db = 'motor_vlogger_assist';
$user = 'root';
$pass = '';

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db";

// Set up options for the PDO connection
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Query to fetch all events
$query = "SELECT * FROM event";
$stmt = $pdo->query($query);
$events = $stmt->fetchAll();

// Query to fetch all events created by the user
$user_id = $_SESSION["id"];
$query = "SELECT * FROM event WHERE user_id = '$user_id'";
$stmc = $pdo->query($query);
$userevents = $stmc->fetchAll();


// Query to fetch signed-up events for the user
$query = "
    SELECT event.*
    FROM event_signup
    INNER JOIN event ON event_signup.event_id = event.event_id
    WHERE event_signup.user_id = :user_id
";
$stms = $pdo->prepare($query);
$stms->execute(['user_id' => $user_id]);
$signedupevents = $stms->fetchAll();


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

        <title>EVENT CREATION | Motor Vloggers Assist</title>

        <link rel="stylesheet" href="newstyle.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">

        <style>
            .event-card {
                margin-bottom: 20px;
                font-family:"audiowide", sans-serif;
                color:#ECF0F1;
            }
            .title {
                font-weight:bold;
            }
            .type {
                font-size: 20px;
                margin-top: 20px;
            }
        </style>
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
                        <a class="nav-link active" href="event.php">Events</a>
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


        <div class="container my-2 p-2 container-width">
            <nav>
                <form method="POST">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active event-custom font" id="nav-create-tab" data-bs-toggle="tab" data-bs-target="#nav-create"
                    type="button" role="tab" aria-controls="nav-create" aria-selected="true">Event Creation</button>

                    <button class="nav-link event-custom font" id="nav-discovery-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery"
                    type="button" role="tab" aria-controls="nav-discovery" aria-selected="true">Event Discovery</button>

                    <button class="nav-link event-custom2 font" id="nav-yourevents-tab" data-bs-toggle="tab" data-bs-target="#nav-yourevents"
                    type="button" role="tab" aria-controls="nav-yourevents" aria-selected="true">Your Events</button>
                </div>
                </form>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show show-custom active p-3" id="nav-create" role="tabpanel" aria-labelledby="nav-project-tab">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-lg-12 col-xl-11">
                            <div class="card-body p-md-5">
                              <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1 font-color">

                                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Event Creation</p>

                                  <form class="mx-1 mx-md-4" method="POST">



                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="name" name="name" class="form-control" required/>
                                        <label class="form-label" for="name">Event Name</label>
                                      </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                      <select class="form-select" id="type" name="type" required>
                                        <option value="">Choose your event type...</option>
                                        <option value="Rally">Rally</option>
                                        <option value="Bike Show">Bike Shows</option>
                                        <option value="Charity Rides">Charity Rides</option>
                                        <option value="Races">Races</option>
                                        <option value="Night Rides">Night Rides</option>
                                        <option value="Festivals">Festivals</option>
                                        <option value="Off Road">Off Road</option>
                                      </select>
                                        <label class="form-label" for="type">Event Type</label>
                                      </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="description" name="description" class="form-control"  required/>
                                        <label class="form-label" for="event_description">Event Description</label>
                                      </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                      <div class="input-group">
                                      <span class="input-group-text">Min</span>
                                      <input type="text"  id="min_participants" name="min_participants" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                      <span class="input-group-text">Max</span>
                                      <input type="text"  id="max_participants" name="max_participants" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                    </div>


                                    <label class="form-label" for="max_participants">Number of Participants</label>

                                      </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="location" name="location" class="form-control"  required/>
                                        <label class="form-label" for="location">Location</label>
                                      </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                          <input
                                            type="date"
                                             id="date"
                                             name="date"
                                            class="form-control"
                                            required
                                            min=""
                                          />
                                      <label class="form-label" for="date">Date</label>
                                      </div>
                                    </div>

                                    <script>
                                            // Set the minimum date to today
                                       const today = new Date().toISOString().split('T')[0];
                                       document.getElementById('date').setAttribute('min', today);
                                    </script>




                                    <div class="d-flex flex-row align-items-center mb-4">
                                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                      <div class="form-outline flex-fill mb-0">
                                      <div class="input-group">
                                      <span class="input-group-text">Start Time</span>
                                      <input type="time"  id="start_time" name="start_time" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                      <span class="input-group-text">End Time</span>
                                      <input type="time" id="end_time" name="end_time" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                    </div>


                                    <label class="form-label" for="start_time">Time</label>

                                      </div>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                      <button  type="submit" name="create" id="create" class="btn btn-dark btn-lg">Create</button>
                                    </div>


                                  </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane fade show-custom p-3" id="nav-discovery" role="tabpanel" aria-labelledby="nav-discovery-tab">
                      <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 font-color" >Event Discovery</p>
                      <div class="row">
                          <?php foreach ($events as $event): ?>
                              <div class="col-md-4 event-card">
                                  <div class="card">
                                      <div class="card-body bg-dark">
                                          <center><h3 class="card-title title"><?= htmlspecialchars($event['event_name']) ?></h3></center>
                                          <p class="card-text type"><?= htmlspecialchars($event['event_type']) ?></p>
                                          <p class="card-text"><?= htmlspecialchars($event['event_description']) ?></p>
                                          <p class="card-text"><small>Date: <?= htmlspecialchars($event['event_date']) ?></small></p>
                                          <p class="card-text"><small>Time: From <?= htmlspecialchars($event['start_time']) ?> to <?= htmlspecialchars($event['end_time']) ?></small></p>
                                          <p class="card-text"><small>Location: <?= htmlspecialchars($event['event_location']) ?></small></p>

                                          <a href='signup_events.php?get_id=<?= $event['event_id'] ?>'>
                                            <button type='button' class='btn bg-black font-color btn-lg btn-block'>Sign Up</button>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          <?php endforeach; ?>
                      </div>
                    </div>

                    <div class="tab-pane fade show-custom p-3" id="nav-yourevents" role="tabpanel" aria-labelledby="nav-yourevents-tab">
                      <nav>
                        <form method="POST">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active event-custom font" id="nav-created-tab" data-bs-toggle="tab" data-bs-target="#nav-created"
                            type="button" role="tab" aria-controls="nav-created" aria-selected="true">Created Events</button>

                            <button class="nav-link event-custom font" id="nav-signedup-tab" data-bs-toggle="tab" data-bs-target="#nav-signedup"
                            type="button" role="tab" aria-controls="nav-signedup" aria-selected="true">Signed Up Events</button>
                        </div>
                        </form>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show show-custom active p-3" id="nav-created" role="tabpanel" aria-labelledby="nav-created-tab">
                              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 font-color" >Created Events</p>
                              <div class="row">
                                <?php if (empty($signedupevents)): ?>
                                    <p class="text-center font-color">You have not created any events yet.</p>
                                <?php else: ?>
                                <?php foreach ($userevents as $event): ?>
                                      <div class="col-md-4 event-card">
                                          <div class="card">
                                              <div class="card-body bg-dark">
                                                  <center><h3 class="card-title title"><?= htmlspecialchars($event['event_name']) ?></h3></center>
                                                  <p class="card-text type"><?= htmlspecialchars($event['event_type']) ?></p>
                                                  <p class="card-text"><?= htmlspecialchars($event['event_description']) ?></p>
                                                  <p class="card-text"><small>Date: <?= htmlspecialchars($event['event_date']) ?></small></p>
                                                  <p class="card-text"><small>Time: From <?= htmlspecialchars($event['start_time']) ?> to <?= htmlspecialchars($event['end_time']) ?></small></p>
                                                  <p class="card-text"><small>Location: <?= htmlspecialchars($event['event_location']) ?></small></p>

                                                  <a href='edit_event.php?event_id=<?= $event['event_id'] ?>'>
                                                      <button type='button' class='btn bg-white btn-lg btn-block'>Edit</button>
                                                  </a>
                                                  <a href='delete_event.php?event_id=<?= $event['event_id'] ?>' onclick="return confirm('Are you sure you want to delete this event?');">
                                                      <button type='button' class='btn bg-black font-color btn-lg btn-block'>Delete</button>
                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                              </div>
                            </div>

                            <div class="tab-pane fade show-custom p-3" id="nav-signedup" role="tabpanel" aria-labelledby="nav-signedup-tab">
                              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 font-color" >Signed up Events</p>
                              <div class="row">
                                <?php if (empty($signedupevents)): ?>
                                    <p class="text-center font-color">You have not signed up for any events yet.</p>
                                <?php else: ?>
                                    <?php foreach ($signedupevents as $event): ?>
                                        <div class="col-md-4 event-card">
                                            <div class="card">
                                                <div class="card-body bg-dark">
                                                    <center><h3 class="card-title title"><?= htmlspecialchars($event['event_name']) ?></h3></center>
                                                    <p class="card-text type"><?= htmlspecialchars($event['event_type']) ?></p>
                                                    <p class="card-text"><?= htmlspecialchars($event['event_description']) ?></p>
                                                    <p class="card-text"><small>Date: <?= htmlspecialchars($event['event_date']) ?></small></p>
                                                    <p class="card-text"><small>Time: From <?= htmlspecialchars($event['start_time']) ?> to <?= htmlspecialchars($event['end_time']) ?></small></p>
                                                    <p class="card-text"><small>Location: <?= htmlspecialchars($event['event_location']) ?></small></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                              </div>
                            </div>
                        </div>
                    </nav>
                    </div>
                </div>
            </nav>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

      </body>

</html>
