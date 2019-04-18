<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$id = $_SESSION["id"];
$acceptid = $_GET['event_id'];

$acceptquery = "UPDATE events SET performer_id = " . $id . " WHERE event_id = " . $acceptid . ";";
$statusquery = "UPDATE invite_apply set status = 2 where event_id = " . $acceptid . " and reciever_id = " . $id . ";";
if (mysqli_query($conn, $acceptquery) AND mysqli_query($conn, $statusquery)) {
	header("location: notifications.php");
	$result = "success";
}
else {
	$result = "failure";
}
?>
<html>
<body>
<p><?php echo $result; ?></p>
<p><?php echo $acceptquery; ?></p>
<p><?php echo $statusquery; ?></p>
</body>
</html>