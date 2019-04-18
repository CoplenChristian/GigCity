<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$event_id = $_GET['event_id'];

$username = $_SESSION["username"];
$sql = "SELECT * FROM events WHERE event_id='" . $event_id . "'";
$result = mysqli_query($conn, $sql);

$edit_id = $_GET['edit'];
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $event_name = $row["event_name"];
        $venue_name = $row["venue_name"];
        $type = $row["type"];
        $description = $row["description"];
        $city = $row["city"];
        $state = $row["state"];
        $street = $row["street"];
        $price = $row["price"];
        $date = $row['event_date'];
		$time = $row['time'];
        $event_image = $row["event_image"];
		$queryResult = "";
    }
} else {
    $description = "0 results";
    }
if(isset($_POST["submit"])){
	$newevent_name = $_POST['event_name'];
	$newvenue_name = $_POST['venue_name'];
	$newtype = $_POST['type'];
	$newdescription = $_POST['description'];
	$newcity = $_POST['city'];
	$newstate = $_POST['state'];
	$newstreet = $_POST['street'];
	$newdate = $_POST['date'];
	$newPrice = $_POST['price'];
	$newPicture = $_POST['picture'];
	$newTime = $_POST['time'];
	
	$today = date("Y-m-d");
	
	if($newdate < $today) {
		$dateErr = "Selected date must be greater than the current date.";
	} else {
		$sql2 = "UPDATE events SET event_name='" . $newevent_name . "', venue_name='" . $newvenue_name . "', type='" . $newtype . "', description='" . $newdescription . "', city='" . $newcity . "', state='" . $newstate . "', street='" . $newstreet . "', event_date='" . $newdate . "', price=" . $newPrice . ", event_image='" . $newPicture . "', time = '" . $newTime . "' WHERE event_id=" . $event_id . ";";
	}
	
	$newPriceInt = (int)$newprice;
	
	if(mysqli_query($conn, $sql2)) {
		$queryResult .= "success";
		$description = $newDescription;
		$display_name = $newDisplayName;
		$type = $newType;
		$price = $newPrice;
		header("location: viewevent.php?event_id=" . $event_id);
	}
	else {
		$queryResult = "failure";
	}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
</head>
<body>
<form action="viewevent.php" method="post">

<a href="welcome.php" class="btn btn-danger">Home</a>

<h1>Event: <b><?php echo $event_name; ?></b></h1>

<a href="viewevent.php?event_id=<?php echo $event_id ?>" class="btn btn-danger">Back to Event</a>

</form>

<form action="editevent.php?event_id=<?php echo $event_id; ?>" method="post">

	<label><h3>Event Name</h3></label>
	<input type="text" value="<?php echo $event_name; ?>" name="event_name">

	<h3>Venue Name</h3>
	<input type="text" value="<?php echo $venue_name; ?>" name="venue_name">
	
	<h3>Performance Type</h3>
	<input type="text" value="<?php echo $type; ?>" name="type">

	<h3>Description</h3>
	<input size="75" type="text" value="<?php echo $description; ?>" name="description">

	<h3>Street Address</h3>
	<input type="text" value="<?php echo $street; ?>" name="street">
	
	<h3>City</h3>
	<input type="text" value="<?php echo $city; ?>" name="city">
	
	<h3>State</h3>
	<input type="text" value="<?php echo $state; ?>" name="state">
	
	<h3>Pay</h3>
	$ <input type="text" value="<?php echo $price; ?>" name="price">
	
	<h3>Date</h3>
	<input type="date" value="<?php echo $date; ?>" name="date">
	
	<p style="color:red"><?php echo $dateErr; ?></p>
	
	<h3>Time</h3>
	<input type="time" value="<?php echo $time; ?>" name="time">
	
	<h3>Event Image (Currently does not support hosting on our servers. You must host the image elsewhere)</h3>
	<input size="75" type="text" value="<?php echo $event_image; ?>" name="picture">
	
	
	<br>
	<br>
	<input type="submit" value="Save Changes" name="submit">

</form>

</body>
</html>