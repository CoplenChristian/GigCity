<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");
if (!$conn) { die("Connection failed: " . mysqli_connect_error());}
$username = ucfirst($_SESSION["username"]);
$id = $_SESSION["id"];

if(isset($_POST["submit"])){
	$eventName = $_POST['displayname'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$venueName = $_POST['venuename'];
	$type = $_POST['type'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	
	$today = date("Y-m-d");
	
	if($date < $today) {
		$dateErr = "Selected date must be greater than the current date.";
	} else {
		$sql2 = "INSERT INTO events (id, event_name, venue_name, type, description, city, state, street, price, event_date, time) VALUES (" . $id . ", '" . $eventName . "', '" . $venueName . "', '" . $type . "', '" . $description . "', '" . $city . "', '" . $state . "', '" . $street . "', " . $price . ", '" . $date . "', '". $time . "');";

		if(mysqli_query($conn, $sql2)) {
			$queryResult . "success";
			$description = $newDescription;
			$display_name = $newDisplayName;
			$type = $newType;
			$price = $newPrice;
			header("location: welcome.php");
		}
		else {
			$queryResult = "failure";
		}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- font reference Google Fonts API -->
	<link href='https://fonts.googleapis.com/css?family=Quicksand|Poppins|Montserrat|Open Sans' rel='stylesheet'>
    <title>Create Event</title>
	<style>
		<?php include 'css/createevent.css';?>
	</style>
</head>
<body>
	<div class="limiter">
		<div class="container-bg">
		
			<div class="signup-header">
				<div class="container-header">
					<div class="logo">
						<a href="welcome.php"><img src="gigcitylogo_transparent.png" alt="GigCity">
						</a>
					</div>
				</div>
			</div>
			
			<div class="signup-body">
			
				<div class="container-header top-pad">
					<div class="body-header">
						<form action="profile.php" method="post">
							<span class="msg-header"><b><?php echo $username; ?></b>'s Event</span>
						</form>
						<span class="txt1">To get started, please fill out the following form below.</span>
					</div>
					
					<form action="createevent.php" method="post">
						<fieldset>
							<ul>
								<!-- Checkbox for payment outside of application 
								<div class="preference">
								<input type="checkbox" value="Yes" name="pType" id="pType">
								<label for="pType">Payment outside of Application</label>
								</div> -->
								
								<!-- Event name field no label -->
								<li class="form-group user-margin">
									<span class="label-input">Create event</span>
									<input class="input-box" type="text" placeholder="Enter an event name " name="displayname" size= "30" maxlength="35">
								</li>
								
								<li class="form-group user-margin">
									<span class="label-input">Venue name</span>
									<input class="input-box" type="text" placeholder="What is the name of the venue . . ." name="venuename" size= "30" maxlength="35">
								</li>
								<!-- Location -->
								<li class="loc-form form-group user-margin">
									<span class="label-input label-padding">Location</span>
									<input class="location-input" type="text" name="street" placeholder="Enter Street">
									<input class="location-input" type="text" name="city" placeholder="Enter City">
									<input class="location-input" type="text" name="state" placeholder="Enter State">
								</li>
								
								<!-- Date and time --> <!--
								<li>
								</li> -->

								<!-- Performance type 
								<label><h3>Performance Type</h3></label>
								<input type="text" value="" name="type"> -->
								
								<!-- Description of the event -->
								<li class="form-group user-margin">
									<span class="label-input">Description</span>
									<input class="input-box" size="75" type="text" name="description" placeholder = "Tell others about your event . . .">
								</li>
								
								<li class="form-group user-margin">
									<span class="label-input">Event Type</span>
									<input class="input-box" size="30" type="text" name="type" placeholder="What type of event is this . . .">
									</li>
								<!-- This is in here twice
								<li>
								<label><h3>City</h3></label>
								<input type="text" name="city" placeholder = "Where is your event located..." size=50>
								</li>
								
								<li>
								<label><h3>State</h3>
								<input type="text" name="state" placeholder = "What State is your event in..." size=50>
								</li>
								-->
								<li class="form-group">
									<span class="label-input">Price</span>
									<input class="input-box" type="text" name="price" placeholder = "How much are you willing to pay for this event . . ." size=50>
								</li>
								
								<li class="form-group">
									<span class="label-input">Date of Event</span>
									<input class="input-box" type="date" name = "date">
								</li>
								
								<p style="color:red"><?php echo $dateErr; ?></p>
								
								<li class="form-group">
									<span class="label-input">Time of Event</span>
									<input class="input-box" type="time" name = "time">
								</li>
								

								<p class="notice txt1">* Changes to event will be locked 24 hours prior to start time</p>
								<!-- link back to user profile/homepage -->
								<div class="col-center">
									<div class="nounderline">
										<a href="myevents.php" class="txt2 ex et">		
											back to your events
										</a>
									</div>
								</div>
								
								<!-- save changes and submit -->
								<div class="col-center">
									<div class="login-btn">
										<div class="wraplogin-btn">
											<div class="btn-bg"></div>
												<button type="submit" class="login-login" name="submit" method="post">Create</button>
										</div>
									</div>
								</div>
								

								
								<!-- <input type="submit" value="Create" name="submit" method="post"> -->
								
							</ul>
							
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>