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
$sender_id = $_GET['sender_id'];

$approvesql = "UPDATE invite_apply SET status = 4 WHERE event_id = " . $eventidcheck . " AND sender_id = " . $id . " AND sender_id = " . $sender_id . ";";
$updateevent = "UPDATE events SET performer_id = " . $performing . " where event_id = " . $eventidcheck . " AND id = " . $id . ";";
if (mysqli_query($conn, $approvesql) AND mysqli_query($conn, $updateevent)) {
	header("location: viewevent.php?event_id=" . $eventidcheck . ")");
}
?>
<html>
<body>
<p><?php echo $approvesql; ?></p>
<p><?php echo $updateevent; ?></p>
<p><?php echo $eventidcheck; ?></p>
</body>
</html>