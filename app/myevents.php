<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$today = date("Y-m-d");

$id = $_SESSION["id"];
$sql = "SELECT * FROM events WHERE (id=" . $id . " OR performer_id = " . $id . ") AND event_date > DATE_SUB('" . $today . "', INTERVAL 30 DAY) ORDER BY event_date;";
$result = mysqli_query($conn, $sql);

$events = "";
 
if (mysqli_num_rows($result) === 0) {
	$events .= "<p class='txt2'>You have no events coming up.</p>";
}
else {
for ($x = 0; $x <= mysqli_num_rows($result); $x++) {
	while($row = mysqli_fetch_assoc($result)) {
		$event_id = $row["event_id"];
		$event_name = $row["event_name"];
        $venue_name = $row["venue_name"];
        $type = $row["type"];
        $description = $row["description"];
        $city = $row["city"];
        $state = $row["state"];
        $street = $row["street"];
        $price = $row["price"];
        $date = $row['event_date'];
		$dateformat = date("F d, Y", strtotime($date));
		$time = $row["time"];
        $event_image = $row["event_image"];
		if($event_image === NULL) {
			$event_image = "images/default_picture.png";
		}
		if ($x % 2 != 0) {
			$events .= "<div class='div1'>" . "<h3 class='h3'><p>" . $dateformat . "</p>" . $event_name . "</h3>" . "<p class='txt2'>" . $description .  "</p>" . "<a class= 'ee et txt1' href='viewevent.php?event_id=" . $event_id . "'>View Event</a>";
			$events .= " <br> ";
			$events .= " <br> ";
			$events .= " <br> ";
		}
		if ($x % 2 == 0) {
			$events .= "<div class='div1'>" . "<h1><p>" . $dateformat . "</h1><h3>" . $event_name . "</h3>" . "<p class='txt2'>" . $description .  "</p>" . "<a class = 'ee et txt1' href='viewevent.php?event_id=" . $event_id . "'>View Event</a>";
			$events .= " <br> ";
			$events .= " <br> ";
			$events .= " <br> ";
		}
	}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="http://code.jquery.com/jquery-3.2.1.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Quicksand|Poppins|Montserrat|Open Sans' rel='stylesheet'>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
	
    <style>
    <?php include 'css/myevents.css'; ?>
    </style>
	
	<title>My Profile</title>
	
</head>
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
						<li><a class = 'ex' href='logout.php'>Log Out</a></li>
					</ul>
				</div>
			</nav>
			
			<div class="container-main">
				<div class="container-2">
					<div class="txt3">Your Events</div>
					<br>
					<div class="txt2" style='color: white'>Events disappear from this screen 30 days after their scheduled date.</div>
				</div>
			</div>
				
		</header>
		
		<div class="content">
				<div class="button-container">
					<a href="createevent.php"><button class="invite-butt">Create New Event</button></a>
				</div>	
				<!--
				<div class="center">
					<a class = "ee et txt1" href="createevent.php">Create New Event</a>
				</div>
				-->
				<div class="eventscontainer">
					<?php echo $events ?>	
					
				</div>
				
			
		</div>
	</div> <!-- end of wrapper -->
<script type='text/javascript'>
		//menu-toggle
		$(document).ready(function(){
			$(".menu-icon").on("click", function(){
				$("nav ul").toggleClass("showing");
			});
		});

		//scrolling effect
		$(window).on("scroll",function(){
			if($(window).scrollTop()){
				$('nav').addClass('black');
			}else{
				$('nav').removeClass('black');
			}
		})
</script>
</body>
</html>