<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$event_id = $_GET['event_id'];
$performer_id = $_GET['performer_id'];

$username = $_SESSION["username"];
$id = $_SESSION["id"];

$paymentcheck = 'SELECT * FROM payment WHERE sender_id = ' . $id . " AND reciever_id = " . $performer_id . ";";
$paymentresult = mysqli_query($conn, $paymentcheck);

if (mysqli_num_rows($paymentresult) == 0) {
	$sql = "insert into payment (sender_id, reciever_id, amt, in_app) VALUES (" . $id . ", " . $performer_id . ", 0, 'no');";
	if (mysqli_query($conn, $sql)) {
		header("location: viewevent.php?event_id=" . $event_id);
	}
}
else {
	header('Refresh: 3; URL=viewevent.php?event_id=' . $event_id);
	echo "You have already paid the user...redirecting...";
}
?>
