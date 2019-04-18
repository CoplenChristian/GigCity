<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$username = $_SESSION["username"];
$id = $_SESSION["id"];
$user_id = $_GET['profile_id'];
$sql = "SELECT * FROM users WHERE id=" . $user_id . ";";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $description = $row["description"];
        $display_name = $row["display_name"];
        $type = $row["type"];
        $city = $row["city"];
        $state = $row["state"];
        $price = $row["price"];
        $fname = $row["fname"];
        $lname = $row["lname"];
		$youtube = $row['youtube_link'];
		$instagram = $row['instagram_link'];
		$soundcloud = $row['soundcloud_link'];
		$profilePicture = $row["profile_image"];
		if($profilePicture === NULL) {
			$profilePicture = "images/default_picture.png";
		}
		if($youtube === NULL) {
			$youtube = "#";
		}
		if($instagram === NULL) {
			$instagram = "#";
		}
		if($soundcloud === NULL) {
			$soundcloud = "#";
		}
    }
} else {
    $description = "0 results";
    }

$sql2 = "SELECT * FROM links WHERE id=" . $user_id . ";";
$result2 = mysqli_query($conn, $sql2);

if (mysqli_num_rows($result2) > 0) {
	while ($row = mysqli_fetch_assoc($result2)) {
		$videoLink = $row["link"];
		if ($videoLink === NULL) {
			$videoLink = "https://www.youtube.com/embed/0YZ5lQDlHSc";
		} else {
			$videoLink = str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $videoLink);
		}
	}
}
$today = date("Y-m-d");
$eventsql = "select * from events where (performer_id = " . $user_id . " OR id = " . $user_id . ") AND event_date BETWEEN DATE_SUB('" . $today . "', INTERVAL 30 DAY) AND DATE_ADD('" . $today . "', INTERVAL 30 DAY);";
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
		if($event_image === NULL) {
			$event_image = "images/default_picture.png";
		}
		if ($x % 2 != 0) {
			$recentEvents .= "<div class='div1' style='text-align: center'>" . "<h3 class='h3'><p>" . $dateformat . "</p>" . $event_name . "</h3>" . "<p class='txt2'>" . $event_description .  "</p>" . "<a class= 'ee et txt1' href='viewevent.php?event_id=" . $event_id . "'>View Event</a>";
			$recentEvents .= " <br> ";
		}
		if ($x % 2 == 0) {
			$recentEvents .= "<div class='div1' style='text-align: center'>" . "<h1><p>" . $dateformat . "</h1><h3>" . $event_name . "</h3>" . "<p class='txt2'>" . $event_description .  "</p>" . "<a class = 'ee et txt1' href='viewevent.php?event_id=" . $event_id . "'>View Event</a>";
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
    <?php include 'css/profile.css'; ?>
    </style>
	
	<title>View Profile</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<nav>
				<div class="menu-icon">
					<i class="fa fa-bars fa-2x"></i>
				</div>
			
				<div class = "menu">

				<div class="logo"><img class="logo" src="gigcitylogo_transparent.png" alt="GigCity"></div>
					<ul>
						<!--<li><img class = 'logo' src="gigcitylogo_transparent.png" alt="GigCity"></li> -->
						<li><a class = 'ex' href='editprofile.php'>Edit Profile</a></li>
						<li><a class = 'ex' href='search.php'>Search</a></li>
						<li><a class = 'ex' href='welcome.php'>Home</a></li>
						<li><a class = 'ex' href='logout.php'>Log Out</a></li>
					</ul>
				</div>
			</nav>
			<form action="invite.php?user_id=<?php echo $user_id; ?>" method="post">
				<div class="container-main">
					<div class="container">
						<img class="pic" src="<?php echo $profilePicture; ?>">
						
						<div class="info">
							<div class="txt3"> <?php echo $type; ?> </div>
							<div class="txt3"> <?php echo $display_name; ?> </div>
							<div class="txt4"> <?php echo $city; ?>,  <?php echo $state; ?></div>
							<div class="button-container">
								<button class="invite-butt">Invite</button>
							</div>
						</div>
					</div>
					<div class="socialmedia">
							<a class="social-butt-yt social-butt" href="<?php echo $youtube; ?>"><i class="fab fa-youtube-square"></i></a> 
							<a class="social-butt" href="<?php echo $instagram ?>"><i class="fab fa-instagram"></i></a> 
							<a class="social-butt-sc social-butt" href="<?php echo $soundcloud; ?>"><i class="fab fa-soundcloud"></i></a> 
					</div>
					<div class="price">
						<div class="txt3">Asking for: $<?php echo $price; ?></div>
					</div>
				</div>
			</form>
		</header>
		
		<div class="content">
			<form action="profile.php" method="post">
				<div class="row">
					<div class="left">
						<div class="info-group">
							<div class="txt1 bottom-marg">My Story</div>
							<div class="txt2"> <?php echo $description; ?> </div>
						</div>
						<div class="info-group">
							<div class="txt1 bottom-marg">Previous Work</div>
							<div class="vid-wrapper">
								<iframe width="420" height="300" src="<?php echo $videoLink ?>" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
					
					<div class="right">
						<div class="info-group">
							<div class="txt1 bottom-marg">Recent Events</div>
							<div class="txt2"> <?php echo $recentEvents; ?></div>	
						</div>
					</div>
				</div>
				
			</form>
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