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
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM users WHERE id = " . $user_id . ";";
$result1 = mysqli_query($conn, $sql);

if (mysqli_num_rows($result1) > 0) {
	while($row = mysqli_fetch_assoc($result1)) {
		$username = $row['username'];
	}
}
else {
	$event_name = "This isn't working.";
}
$sqlevents = "SELECT * FROM events WHERE id = " . $id . ";";
$eventsresult = mysqli_query($conn, $sqlevents);
$dropdown = "";

if (mysqli_num_rows($eventsresult) > 0) {
	while($row = mysqli_fetch_assoc($eventsresult)) {
		$event_id = $row['event_id'];
		$event_name = $row['event_name'];
		$dropdown .= "<option value='" . $event_id . "'>" . $event_name . "</option>";
	}
}
if(isset($_POST["submit1"])){
	$application_message = $_POST['message'];
	$event_chose = $_POST['event'];
	$sqlChecks = "SELECT * FROM invite_apply WHERE event_id = " . $event_chose . " AND sender_id = " . $id . " AND reciever_id = " . $user_id . ";";
	$sqlexisting = "SELECT * FROM events WHERE event_id = " . $event_chose . " AND performer_id = " . $user_id . ";";
	$resultsChecks = mysqli_query($conn, $sqlChecks);
	$existingcheck = mysqli_query($conn, $sqlexisting);
	if (mysqli_num_rows($resultsChecks) == 0 AND mysqli_num_rows($existingcheck) == 0) {
		$sqlinsert = "INSERT INTO invite_apply (sender_id, reciever_id, event_id, message, status) VALUES (" . $id . ", " . $user_id . ", " . $event_chose . ", '" . $application_message . "', 0);";
		if(mysqli_query($conn, $sqlinsert)) {
			$queryResult = "Success";
			header("location: notifications.php");
		}
		else {
			$queryResult = "failure";
		}
	}
	else {
		$checkStatus = "You have already sent an invite to this user for this event.";
		$applicationLink = "<a href='myapplications.php'>Click here to view your outgoing invitations.</a>";
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
    <title>Apply for Event</title>
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
						<form method="post">
							<span class="msg-header"><b><?php echo $username; ?></b></span>
						</form>
						<span class="txt1">Please fill out the following message to invite the user to the event.</span>
					</div>
					
					<form action="invite.php?user_id=<?php echo $user_id; ?>" method="post">
						<fieldset>
							<ul>
								<!-- Checkbox for payment outside of application 
								<div class="preference">
								<input type="checkbox" value="Yes" name="pType" id="pType">
								<label for="pType">Payment outside of Application</label>
								</div> -->
								
								<!-- Event name field no label -->
								<li class="form-group user-margin">
									<span class="label-input">Application message</span>
									<textarea class="input-box" type="text" placeholder="Tell the performer why you are interested..." name="message" size="75" maxlength="500" rows="10"> </textarea>
								</li>
								
								<li class="form-group user-margin">
								<span class="label-input">Select the event you would like to invite them to:</span><br>
									<select name='event'>
										<?php echo $dropdown; ?>
									</select>
								</li>

								<div class="col-center">
									<div class="nounderline">
										<a href="welcome.php" class="txt2 ex et">		
											back to search
										</a>
									</div>
								</div>
								
								<!-- save changes and submit -->
								<div class="col-center">
									<div class="login-btn">
										<div class="wraplogin-btn">
											<div class="btn-bg"></div>
												<input type="submit" class="login-login" name="submit1">
										</div>
									</div>
								</div>
								
								<p><?php echo $checkStatus; ?> </p>
								<p><?php echo $applicationLink; ?></p>
								
								<p><?php echo $sqlChecks; ?></p>
								<p><?php echo $sqlexisting; ?></p>
								
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