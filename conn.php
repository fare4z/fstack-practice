<?php 
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "booking_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB connection error: " . $conn->connect_error);
}
?>
