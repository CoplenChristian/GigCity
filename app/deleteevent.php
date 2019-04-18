<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$event_id = $_GET['event_id'];

$user_id = $_SESSION["id"];

$sql = "SELECT * FROM events WHERE event_id = " . $event_id . ";";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		$id = $row['id'];
	}
	if ($id = $user_id) {
		$sql2 = "DELETE FROM events WHERE event_id = " . $event_id . ";";
		if (mysqli_query($conn, $sql2)) {
			$result = "<p>Your event has been deleted.</p>";
		}
		else {
			$result = "<p>An error occurred.</p>";
		}
	}
	else {
		$result = "<p>You do not have permission to do this.</p>";
	}
	
}


?>
<html>
	<head>
		<title>Delete Event</title>
	</head>
	<body>
	<?php echo $result; ?>
	<a href="https://cgi.sice.indiana.edu/~team45/myevents.php">Back to Your Events</a>
	</body>
</html>