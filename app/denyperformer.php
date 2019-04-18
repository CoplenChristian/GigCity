<?php 

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$id = $_SESSION["id"];
$eventidcheck = $_GET['event_id'];
$performing = $_GET['performer_id'];


$denysql = "UPDATE invite_apply SET status = 4 WHERE event_id = " . $eventidcheck . " AND sender_id = " . $id . ";";

if (mysqli_query($conn, $denysql)) {
	header("location: outgoing.php");
}
?>