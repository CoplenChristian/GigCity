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
$event_id = $_GET["event_id"];

$sql = "SELECT * FROM events WHERE event_id = " . $event_id . ";";
$result1 = mysqli_query($conn, $sql);

if (mysqli_num_rows($result1) > 0) {
	while($row = mysqli_fetch_assoc($result1)) {
		$event_name = $row['event_name'];
		$host_id = $row['id'];
	}
}
else {
	$event_name = "This isn't working.";
}
if(isset($_POST["submit"])){
	$application_message = $_POST['message'];
	$sqlCheck = "SELECT * FROM invite_apply WHERE event_id = " . $event_id . " AND sender_id = " . $id . ";";
	$resultCheck = mysqli_query($conn, $sqlCheck);
	if (mysqli_num_rows($resultCheck) == 0) {
		$sql2 = "INSERT INTO invite_apply (sender_id, reciever_id, event_id, message, status) VALUES (" . $id . ", " . $host_id . ", " . $event_id . ", '" . $application_message . "', 0);";
		if(mysqli_query($conn, $sql2)) {
			$queryResult = "Success";
			header("location: outgoing.php");
		}
		else {
			$queryResult = "failure";
		}
	}
	else {
		$checkStatus = "You have already applied to this event.";
		$applicationLink = "<a href='outgoing.php'>Click here to view your applications to events</a>";
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
						<form action="createapplication.php?event_id=<?php echo $event_id; ?>" method="post">
							<span class="msg-header"><b><?php echo $event_name; ?></b></span>
						</form>
						<span class="txt1">Please fill out the following message to apply to this event.</span>
					</div>
					
					<form action="createapplication.php?event_id=<?php echo $event_id; ?>" method="post">
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
									<textarea class="input-box" type="text" placeholder="Tell the host why you should perform" name="message" size="75" maxlength="500" rows="10"> </textarea>
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
												<button type="submit" class="login-login" name="submit" method="post">Create</button>
										</div>
									</div>
								</div>
								
								<p><?php echo $checkStatus; ?> </p>
								<p><?php echo $applicationLink; ?></p>
								
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