<?php
session_start();
$id = $_SESSION["id"];

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$username = ucfirst($_SESSION["username"]);

$invitesql = "select * from invite_apply where reciever_id = " . $id . " and status = 0;";
$inviteresult = mysqli_query($conn, $invitesql);
if($inviteresult === NULL) {
	$notificationNumber = 0;
} else{
	$notificationNumber = mysqli_num_rows($inviteresult);
}
$outgoingupdate = "select * from invite_apply where sender_id = " . $id . " and status = 2 or status = 3;";
$outgoingresult = mysqli_query($conn, $outgoingupdate);

if ($outgoingresult === NULL) {
	$notificationNumber += 0;
}
else {
	$notificationNumber += mysqli_num_rows($outgoingresult);
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	$profile_text = "Login";
	$logout_text = "";
}
else {
	$navBar = "<li><a class = 'ex' href='search.php'>Search</a></li> <li><a class = 'ex' href='myevents.php'>My Events</a></li>";
	$profile_text = "My Profile";
	$notifications = "<li><a class = 'ex' href='notifications.php'>Notifications: " . $notificationNumber . "</a></li>";
	$logout_text = "<li><a class = 'ex' href='logout.php'>Log Out</a></li>";
}
?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="http://code.jquery.com/jquery-3.2.1.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Quicksand|Montserrat|Open Sans' rel='stylesheet'>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<style>
	<?php include 'css/welcome.css';?>
	</style>
	
    <title>Gigcity</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<nav>
				<div class="menu-icon">
					<i class="fas fa-bars"></i>
				</div>
				
				<div class="logo">
					<img class="logo" src="gigcitylogo_transparent.png" alt="GigCity">
				</div>
				
				<div class = "menu">
					<ul>
						<li><a class= "ex" href="feed.php">Feed</a></li>
						<?php echo $navBar; ?>
						<li><a class = "ex" href="profile.php"><?php echo $profile_text; ?></a></li>
						<?php echo $notifications; ?>
						<?php echo $logout_text; ?>
					</ul>
				</div>
			</nav>
			
			<div class="container-main">
				<div class="container-2">
					<div class="txt3">Welcome <?php echo $username; ?></div>
				</div>
			</div>
			
		</header>
		<div class = "content">
			<p>
				Our Story
			</p>
			<!-- <i class="fas fa-bars"></i> -->

			<p class="bodytext">
				Welcome to GigCity! We are an event services booking platform. We aim to connect users with each other, facilitating transactions between host and performer. 
			<br>
			<br>
				Imagine this, you and your roommates want to throw a house party. Everything is prepared, but your friend waldo, the amateur, who was supposed to dj can't be found. Now you need a DJ who can play tunes for the night. Using the search feature, you can quickly and efficiently advertise your event and find relevant local performers.
			<br>
			<br>			
				Additionally, we  want to grow local talent by acting as a facilitator. Currently, our focus is on the Bloomington area. This service is in demand, especially in college communities, and can be adopted by other communities nationwide with minor modifications. 
			<br>
			<br>
				Our website utilizes PHP, SQL, HTML, CSS, and JavaScript. Also, we are using Google Font API to use fonts outside of the Web-safe fonts.
			</p>
		</div>
	</div>
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