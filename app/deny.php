<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$id = $_SESSION["id"];
$denyid = $_GET['event_id'];

$denyquery = "UPDATE events SET performer_id = " . $id . " WHERE event_id = " . $denyid . ";";
if (mysqli_query($conn, $denyquery)) {
	header("location: notifications.php");
}
?>