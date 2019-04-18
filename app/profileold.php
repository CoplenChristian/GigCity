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
$sql = "SELECT * FROM users WHERE username='" . $username . "'";
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
		$profilePicture = $row["profile_image"];
		if($profilePicture === NULL) {
			$profilePicture = "images/default_picture.png";
		}
    }
} else {
    $description = "0 results";
    }

$sql2 = "SELECT * FROM links WHERE id=" . $id . ";";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Quicksand|Montserrat|Open Sans' rel='stylesheet'>
	
    <style>
    <?php include 'css/profile.css'; ?>
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

				<div class="logo"><img class="logo" src="gigcitylogo_transparent.png" alt="GigCity"></div>
					<ul>
						<li><a class = 'ex' href='editprofile.php'>Edit Profile</a></li>
						<li><a class = 'ex' href='searcg.php'>Search</a></li>
						<li><a class = 'ex' href='welcome.php'>Home</a></li>
						<li><a class = 'ex' href='logout.php'>Log Out</a></li>
					</ul>
				</div>
			</nav>
		</header>
		<div class="content">
		</div>



		

		<form action="profile.php" method="post">

		<div class="container">
		<div class="gradient">
		<div class="whitebar">
		<img src="images/gigcitylogo_transparent.png" class="logo" style="float:left">
		<ul>
			<li><a class = "ex" href="logout.php">Log Out</a></li>
			<li><a href="profile.php" class="profilelink">My Profile</a></li>
			<li><a href="welcome.php" class="welcomelink">Home</a></li>
			<li><a class = "ex" href="search.php">Search</a></li>

			<li><a href="editprofile.php">Edit Profile</a></li>
		</div>
		<img src="<?php echo $profilePicture; ?>" class="profilepicture">
		<div class="type">
		 <!-- <h3>Performance Type</h3> -->
		<p> <?php echo $type; ?> </p>
		</div>
		<div class="name">
		<p> <?php echo $display_name; ?> </p>
		</div>
		<div class="location">
		<p> <?php echo $city; ?>,  <?php echo $state; ?></p>
		</div>
		<div class="price">
		<p>Asking for: $<?php echo $price; ?></p>
		</div>



</div>

<a href="welcome.php" class="home">Home</a>

	<h1><b><?php echo $username; ?></b>'s Profile</h1>

	<a href="editprofile.php?" class="btn btn-danger">Edit Profile</a>
	<div class="profile">
		<div class="description">
			<h3>Description:</h3>
			<p> <?php echo $description; ?> </p>
		</div>
		<div class="video">
			<iframe width="420" height="300" src="<?php echo $videoLink ?>">
			</iframe>
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