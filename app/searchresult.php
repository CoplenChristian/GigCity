<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

if(isset($_GET['keywords'])) {
	$keywords = $_GET['keywords'];
}

$userQuery = "SELECT * FROM users WHERE description LIKE '%" . $keywords . "%' OR display_name LIKE '%" . $keywords . "%' OR type LIKE '%" . $keywords . "%' OR username LIKE '%" . $keywords . "%';";
$eventQuery = "SELECT * FROM events WHERE description LIKE '%" . $keywords . "%' OR event_name LIKE '%" . $keywords . "%' OR venue_name LIKE '%" . $keywords . "%' OR type LIKE '%" . $keywords . "%';";

$userQueryResult = mysqli_query($conn, $userQuery);
$eventQueryResult = mysqli_query($conn, $eventQuery);

$userResults = "";
$eventResults = "";

if (mysqli_num_rows($userQueryResult) == 0) {
	$userResults = "<p>No users found</p>";
}
else {
	for ($x = 0; $x <= mysqli_num_rows($userQueryResult); $x++) {
		while($row = mysqli_fetch_assoc($userQueryResult)) {
			$username = $row['display_name'];
			$description = $row['description'];
			$user_id = $row['id'];
			
			$userResults .= "<div> <h3>" . $username . "</h3> <p>" . $description . "</p> <a href='viewprofile.php?profile_id=" . $user_id . "'>View Profile</a> </div>";
			$userResults .= "<br>";
			$userResults .= "<br>";
		}
	}
}
if (mysqli_num_rows($eventQueryResult) == 0) {
	$eventResults = "<p>No events found</p>";
}
else {
	for ($x = 0; $x <= mysqli_num_rows($eventQueryResult); $x++) {
		while($row = mysqli_fetch_assoc($eventQueryResult)) {
			$event_name = $row['event_name'];
			$event_description = $row['description'];
			$event_id = $row['event_id'];
			
			$eventResults .= "<div sytle='border-top; 1px solid #dfe0e6'> <h3>" . $event_name . "</h3> <p>" . $event_description . "</p> <a href='viewevent.php?event_id=" . $event_id . "'>View Event</a> </div>";
			$eventResults .= "<br>";
			$eventResults .= "<br>";
		}
	}
}
	
	
?>

<html>
	
	<head>
		<title>Search Results</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<script src="http://code.jquery.com/jquery-3.2.1.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Quicksand|Poppins|Montserrat|Open Sans' rel='stylesheet'>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	
		<style>
    	<?php include 'css/searchresult.css'; ?>
    	</style>
	<head>
	<body>
		<div class="wrapper">
		<header>
			<nav>
				<div class="menu-icon">
					<i class="fa fa-bars fa-2x"></i>
				</div>
			
				<div class = "menu">
						
				<div class="logo"><a href="welcome.php"><img class="logo" src="gigcitylogo_transparent.png" alt="GigCity"></a></div>
					<ul>
						<li><a class = 'ex' href='welcome.php'>Home</a></li>
						<li><a class = 'ex' href='profile.php'>My Profile</a></li>
					</ul>
				</div>
			</nav>
			
			<div class="container-main">
				<div class="container-2">
					<div class="txt3">Search Results</div>
					<div class="txt3"><?php echo $keywords; ?></div>
				</div>
			</div>
				
		</header>
		
		<div class="content">
				<!--
				<div class="center">
					<a class = "ee et txt1" href="createevent.php">Create New Event</a>
				</div>
				-->
				<div class="eventscontainer">
					<div class="userResults">
						<h1>User Results:</h1>
						<?php echo $userResults; ?>
					</div>
					<div class="eventResults">
						<h1>Event Results: </h1>
						<?php echo $eventResults; ?>
					</div>
					
					
				</div>
				
			
		</div>
	</div> <!-- end of wrapper -->



	</body>
</html>
