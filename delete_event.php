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


if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Delete event from the database
    $stmt = $pdo->prepare("DELETE FROM event WHERE event_id = :event_id AND user_id = :user_id");
    $stmt->execute([':event_id' => $event_id, ':user_id' => $_SESSION['id']]);

    echo "<script> alert('Event deleted successfully!'); window.location.href='event.php'; </script>";
}
