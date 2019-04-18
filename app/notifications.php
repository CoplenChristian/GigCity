<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$id = $_SESSION["id"];
$eventStatus = $_GET['event_id'];
$sql = "SELECT * FROM invite_apply WHERE reciever_id=" . $id . ";";
$result = mysqli_query($conn, $sql);

$invites = "";
    
if (mysqli_num_rows($result) == 0) {
	$invites .= "<p class='txt2'>You have no notifications.</p>";
}
else {
	$ids = "";
for ($x = 0; $x <= mysqli_num_rows($result); $x++) {
	while($row = mysqli_fetch_assoc($result)) {
		$senderid = $row['sender_id'];
		$message = $row['message'];
		$eventID = $row['event_id'];
		$ids .= $eventID . " ";
		$status = $row['status'];
		$sendersql = "select * from users where id = " . $senderid . ";";
		$senderresult = mysqli_query($conn, $sendersql);
		while($row2 = mysqli_fetch_assoc($senderresult)) {
			$sendername = $row2['username'];
		}
		if($status == 0) {
			$background = "; background-color: lightblue;";
			$invites .= "<div style='border-top: 1px solid #dfe0e6" . $background . "'>";
			$invites .= "<p>From: " . $sendername . "</p>";
			$invites .="<p>Message: " . $message . "</p>";
			$invites .="<p>View Event: <a href='viewevent.php?event_id=" . $eventID . "'>View Event</a></p> <form action='accept.php?event_id=" . $eventID . "' method='post'> <input type = 'submit' name='accept' value = 'Accept'> <input type = 'submit' name = 'deny' value = 'Deny'> </form><br>";
			$invites .= "</div>";
		}
		else if ($status == 1) {
			$background = "";
			$invites .= "<div style='border-top: 1px solid #dfe0e6" . $background . "'>";
			$invites .= "<p>From: " . $sendername . "</p>";
			$invites .="<p>Message: " . $message . "</p>";
			$invites .="<p>View Event: <a href='viewevent.php?event_id=" . $eventID . "'>View Event</a></p> <form action='accept.php?event_id=" . $eventID . "' method='post'> <input type = 'submit' name='accept' value = 'Accept'> <input type = 'submit' name = 'deny' value = 'Deny'> </form><br>";
			$invites .= "</div>";
		}
		else {
		}
	}
	
}
}
if ($invites == "") {
	$invites = "<p class='none'>You have no notifications.</p>";
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
	
    <title>Invites</title>
    <style>
    <?php include 'css/myevents.css'; ?>
    </style>
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
			<!-- <form action = "outgoing.php" method = "post"> -->
				
				<div class="container-main">
					<div class="container-2">
						<div class="txt3">
							Your Invites
							<!--<input class = "outgoing" type="submit" name = "submit" value = "Click here to see Outgoing Invites"> -->
						</div>
					</div>
				</div>			
			<!--</form>	-->
		</header>
		
		<div class="content">
			<form action = "outgoing.php" method = "post">
				<div class="button-container">
					<button class="invite-butt">See Outgoing Invites</button>
				</div>
			
			</form>
				<div class="eventscontainer">
					<?php echo $invites ?>
				</div>
				
				<div class="eventscontainer">
					<div class="txt">
					</div>
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