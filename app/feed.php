<?php
session_start();

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$username = $_SESSION["username"];
$id = $_SESSION["id"];

$today = date("Y-m-d");
$eventsql = "select * from events where event_date > " . $today . ";";
$eventresult = mysqli_query($conn, $eventsql);
$recentEvents = "";

for ($x = 0; $x <= mysqli_num_rows($eventresult); $x++) {
	while($row = mysqli_fetch_assoc($eventresult)) {
		$event_id = $row["event_id"];
		$event_name = $row["event_name"];
        $venue_name = $row["venue_name"];
        $type = $row["type"];
        $event_description = $row["description"];
        $city = $row["city"];
        $state = $row["state"];
        $street = $row["street"];
        $price = $row["price"];
        $date = $row['event_date'];
		$dateformat = date("F d, Y", strtotime($date));
		$time = $row["time"];
        $event_image = $row["event_image"];
		$performer_id = $row['performer_id'];
		if($event_image === NULL) {
			$event_image = "images/default_picture.png";
		}
		if ($performer_id === NULL) {
			$recentEvents .= "<div class='div1' style='text-align: center'>" . "<h3 class='h3'><p>Looking for performer:</p></h3>" . "<h3 class='h3'><p>" . $dateformat . "</p>" . $event_name . "</h3>" . "<p class='txt2'>" . $event_description .  "</p>" . "<a class= 'ee et txt1' href='viewevent.php?event_id=" . $event_id . "'>View Event</a>";
			$recentEvents .= " <br> ";
		}
		else {
			$recentEvents .= "<div class='div1' style='text-align: center'>" . "<h1><p>" . $dateformat . "</h1><h3>" . $event_name . "</h3>" . "<p class='txt2'>" . $event_description .  "</p>" . "<a class = 'ee et txt1' href='viewevent.php?event_id=" . $event_id . "'>View Event</a>";
			$recentEvents .= " <br> ";
		}
	}
}

if ($recentEvents == "") {
	$recentEvents = "This user has no recent event.";
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
	
	<title>Feed</title>
	
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
					<div class="txt3">Your Feed</div>
					<br>
					<div class="txt2" style='color: white'>View upcoming events in your area.</div>
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
					<?php echo $recentEvents ?>	
					
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