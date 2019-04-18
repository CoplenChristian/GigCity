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
$id = $_SESSION["id"];

$sql = "SELECT * FROM events WHERE event_id='" . $event_id . "'";
$result = mysqli_query($conn, $sql);

// Code to update status of the invite, if applicable
$invitesqls = "select * from invite_apply where event_id = " . $event_id . " and reciever_id = " . $id . ";";
$inviteresult = mysqli_query($conn, $invitesqls);
if (mysqli_num_rows($inviteresult) == 1) {
	while ($row = mysqli_fetch_assoc($inviteresult)) {
		$statuscheck = $row['status'];
		if ($statuscheck == 0) {
			$inviteupdate = "update invite_apply set status = 1 where event_id = " . $event_id . " and reciever_id = " . $id . ";";
			mysqli_query($conn, $inviteupdate);
		}
	}
}

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $event_name = $row["event_name"];
        $venue_name = $row["venue_name"];
		$hostid = $row['id'];
        $type = $row["type"];
        $description = $row["description"];
        $city = $row["city"];
        $state = $row["state"];
        $street = $row["street"];
        $price = $row["price"];
		$date = $row['event_date']; 
		$dateformat = date("F d, Y", strtotime($date));
        $time = $row["time"];
        $eventUserID = $row['id'];
		$eventPicture = $row["event_image"];
		$performerid = $row['performer_id'];
		if($eventPicture === NULL) {
			$eventPicture = "images/default_picture.png";
		}
		if ($eventPicture == "") {
			$eventPicture = "images/default_picture.png";
		}
		if ($date === NULL) {
			$dateformat = "Event has no date";
		}
    }
} else {
    $description = "0 results";
    }

	
$performersql = "SELECT * FROM users WHERE id = " . $performerid . ";";
$performerresult = mysqli_query($conn, $performersql);
if (mysqli_num_rows($performerresult) > 0) {
	while ($row2 = mysqli_fetch_assoc($performerresult)) {
		$performername = $row2['display_name'];
		
		$performer_display = "<div class='performer'><p> " . $performername . " is performing!</p></div>";
	}
}
else {
	$performer_display = "<div class='performer'><p>No performer is scheduled yet.</p></div>";
}

$applycheck = "select * from invite_apply where event_id =" . $event_id . " AND (reciever_id = " . $id . " OR sender_id = " . $id . ");";
$applyresult = mysqli_query($conn, $applycheck);

if ($id == $eventUserID) {
	$edit_button = "<input class='edit' type='submit' value='Edit Event'>";
	$delete_button = "<input class='delete' type='submit' value='Delete Event'>";
}
else if (mysqli_num_rows($applyresult) == 0 AND $performer_id === NULL){
	$apply_button = "<input class='apply' type='submit' value='Apply for Event'>";
}

$today = date("Y-m-d");

$paymentcheck = "SELECT * FROM payment WHERE event_id = " . $event_id . ";";
$paymentresult = mysqli_query($conn, $paymentcheck);

$emailcheck = 'select email from users where id = ' . $performerid . ";";
$emailresult = mysqli_query($conn, $emailcheck);

if (mysqli_num_rows($emailresult) > 0) {
	while ($row3 = mysqli_fetch_assoc($emailresult)) {
		$email = $row3['email'];
	}
}


if ($performerid != NULL AND $date >= $today AND $hostid == $id AND mysqli_num_rows($paymentresult) == 0) {
	$paypal = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="daxj3s@gmail.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax_rate" value="0.000">
<input type="hidden" name="shipping" value="0.00">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
<table>
<tr><td><input type="hidden" name="on0" value="Payment Amount">Payment Amount</td></tr><tr><td><select name="os0">
	<option value="$10">$10.00 USD</option>
	<option value="$20">$20.00 USD</option>
	<option value="$30">$30.00 USD</option>
	<option value="$40">$40.00 USD</option>
	<option value="$50">$50.00 USD</option>
	<option value="$75">$75.00 USD</option>
	<option value="$100">$100.00 USD</option>
	<option value="$150">$150.00 USD</option>
	<option value="$200">$200.00 USD</option>
	<option value="$250">$250.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="option_select0" value="$10">
<input type="hidden" name="option_amount0" value="10.00">
<input type="hidden" name="option_select1" value="$20">
<input type="hidden" name="option_amount1" value="20.00">
<input type="hidden" name="option_select2" value="$30">
<input type="hidden" name="option_amount2" value="30.00">
<input type="hidden" name="option_select3" value="$40">
<input type="hidden" name="option_amount3" value="40.00">
<input type="hidden" name="option_select4" value="$50">
<input type="hidden" name="option_amount4" value="50.00">
<input type="hidden" name="option_select5" value="$75">
<input type="hidden" name="option_amount5" value="75.00">
<input type="hidden" name="option_select6" value="$100">
<input type="hidden" name="option_amount6" value="100.00">
<input type="hidden" name="option_select7" value="$150">
<input type="hidden" name="option_amount7" value="150.00">
<input type="hidden" name="option_select8" value="$200">
<input type="hidden" name="option_amount8" value="200.00">
<input type="hidden" name="option_select9" value="$250">
<input type="hidden" name="option_amount9" value="250.00">
<input type="hidden" name="option_index" value="0">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>';
}
else if ($performerid != NULL AND $date <= $today AND $hostid == $id) {
	$payoutsql = "select * from payment where event_id = " . $event_id . ";";
	$payoutresult = mysqli_query($conn, $payoutsql);
	if (mysqli_num_rows($payoutresult) == 0)  {
		$paypal = "<form action='payout.php?payment=" . intval($price) . "&email=" . $email . "' method='post'> <input class='payout' type='submit' value='Pay Performer'></form> <br> <form action='externalpayment.php?event_id=" . $event_id . "&performer_id=" . $performerid . "' method='post'> <input class='external' type='submit' value='Pay Performer Outside of Gigcity'> </form>";
	}
	else {
		$paypal = "<div>Performer has been paid. Thank you for using GigCity!</div>";
	}
}
else {
	$paypal = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Event</title>
    <style>
    <?php include 'css/viewevent.css'; ?>
    </style>
</head>
<body>

<div class="container">
<div class="gradient">
<div class="whitebar">
<img src="images/gigcitylogo_transparent.png" class="logo" style="float:left">
<ul>
	<li><a href="profile.php" class="profilelink">Profile</a></li>
	<li><a href="welcome.php" class="welcomelink">Home</a></li>
	<li><a href="editprofile.php">Edit Profile</a></li>
</div>
<img src="<?php echo $eventPicture; ?>" class="eventPicture">
<div class="type">
 <!-- <h3>Performance Type</h3> -->
<p> <?php echo $type; ?> </p>
</div>

<div class="ename">
<p> <?php echo $event_name; ?> </p>
</div>

<div class="vname">
<p> <?php echo $venue_name; ?> </p>
</div>


<div class="location">
<p> <?php echo $street; ?> <?php echo $city; ?>,  <?php echo $state; ?></p>
</div>

<?php echo $performer_display; ?>

<div class="etime">
<p>Event Date:</p>
<p> <?php echo $dateformat; ?></p>
</div>

<div class="price">
<p>Pay: $<?php echo $price; ?></p>
</div>

<form method="post" action="editevent.php?event_id=<?php echo $event_id; ?>">
	<?php echo $edit_button; ?>
</form>

<form method="post" action="deleteevent.php?event_id=<?php echo $event_id; ?>">
	<?php echo $delete_button; ?>
</form>

<form method="post" action="createapplication.php?event_id=<?php echo $event_id; ?>">
	<?php echo $apply_button; ?>
</form>

<?php echo $paypal; ?>


</div>


<h1><b><?php echo $username; ?></b>'s Profile</h1> 
<div class="profile">
<div class="description">
<h3>Description:</h3>
<p> <?php echo $description; ?> </p>
</div>
</div>

</body>
</html>