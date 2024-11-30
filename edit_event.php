<?php
require 'config.php';
session_start();

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

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Check if the event ID is passed
if (!isset($_GET['event_id'])) {
    echo "<script>alert('No event selected!'); window.location.href='event.php';</script>";
    exit;
}

$event_id = intval($_GET['event_id']);

// Fetch the event details
$query = "SELECT * FROM event WHERE event_id = :event_id AND user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['event_id' => $event_id, 'user_id' => $user_id]);
$event = $stmt->fetch();

if (!$event) {
    echo "<script>alert('Event not found or you do not have permission to edit this event.'); window.location.href='event.php';</script>";
    exit;
}

// Handle form submission to update the event
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $min_participants = $_POST['min_participants'];
    $max_participants = $_POST['max_participants'];
    $location = $_POST['location'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $updateQuery = "UPDATE event SET
        event_name = :name,
        event_type = :type,
        min_participants = :min_participants,
        max_participants = :max_participants,
        event_location = :location,
        event_date = :date,
        start_time = :start_time,
        end_time = :end_time,
        event_description = :description
        WHERE event_id = :event_id AND user_id = :user_id";

    $stmt = $pdo->prepare($updateQuery);

    try {
        $stmt->execute([
            'name' => $name,
            'type' => $type,
            'min_participants' => $min_participants,
            'max_participants' => $max_participants,
            'location' => $location,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'description' => $description,
            'event_id' => $event_id,
            'user_id' => $user_id,
        ]);

        echo "<script>alert('Event updated successfully!'); window.location.href='event.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating event: " . $e->getMessage() . "');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EDIT EVENT | Motor Vloggers Assist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container h-100">
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
                      <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($event['event_name']); ?>" required/>
                      <label class="form-label" for="name">Event Name</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <select class="form-select" id="type" name="type" required>
                      <option value="Rally" <?php echo ($event['event_type'] == 'Rally') ? 'selected' : ''; ?>>Rally</option>
                      <option value="Bike Show" <?php echo ($event['event_type'] == 'Bike Show') ? 'selected' : ''; ?>>Bike Shows</option>
                      <option value="Charity Rides" <?php echo ($event['event_type'] == 'Charity Rides') ? 'selected' : ''; ?>>Charity Rides</option>
                      <option value="Races" <?php echo ($event['event_type'] == 'Races') ? 'selected' : ''; ?>>Races</option>
                      <option value="Night Rides" <?php echo ($event['event_type'] == 'Night Rides') ? 'selected' : ''; ?>>Night Rides</option>
                      <option value="Festivals" <?php echo ($event['event_type'] == 'Festivals') ? 'selected' : ''; ?>>Festivals</option>
                      <option value="Off Road" <?php echo ($event['event_type'] == 'Off Road') ? 'selected' : ''; ?>>Off Road</option>
                    </select>
                      <label class="form-label" for="type">Event Type</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="description" name="description" class="form-control"  value="<?php echo htmlspecialchars($event['event_description']); ?>"required/>
                      <label class="form-label" for="event_description">Event Description</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <div class="input-group">
                    <span class="input-group-text">Min</span>
                    <input type="text"  id="min_participants" name="min_participants" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $event['min_participants']; ?>" required>
                    <span class="input-group-text">Max</span>
                    <input type="text"  id="max_participants" name="max_participants" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $event['max_participants']; ?>" required>
                  </div>


                  <label class="form-label" for="max_participants">Number of Participants</label>

                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($event['event_location']); ?>" required/>
                      <label class="form-label" for="location">Location</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="date" id="date" name="date" class="form-control" value="<?php echo $event['event_date']; ?>" required/>
                      <label class="form-label" for="date">Date</label>
                    </div>
                  </div>



                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <div class="input-group">
                    <span class="input-group-text">Start Time</span>
                    <input type="time"  id="start_time" name="start_time" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $event['start_time']; ?>" required>
                    <span class="input-group-text">End Time</span>
                    <input type="time" id="end_time" name="end_time" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $event['end_time']; ?>" required>
                  </div>


                  <label class="form-label" for="start_time">Time</label>

                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button  type="submit" name="update" id="update" class="btn btn-dark btn-lg">Update</button>
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
