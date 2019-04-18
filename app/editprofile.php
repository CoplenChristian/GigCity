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
$sql = "SELECT * FROM users WHERE username='" . $username . "';";
$result = mysqli_query($conn, $sql);

$edit_id = $_GET['edit'];
$run = mysqli_query("select * from users where id = $edit_id");
$videoQuery = "Select link from links where id = " . $id . ";";
$videoQueryResult = mysqli_query($conn, $videoQuery);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $description = $row["description"];
        $display_name = $row["display_name"];
        $type = $row["type"];
        $city = $row["city"];
        $state = $row["state"];
        $price = $row["price"];
        $profile_image = $row["profile_image"];
        $fname = $row["fname"];
        $lname = $row["lname"];
		$youtube = $row['youtube_link'];
		$instagram = $row['instagram_link'];
		$soundcloud = $row['soundcloud_link'];
		$queryResult = "";
    }
} else {
    $description = "0 results";
    }
if (mysqli_num_rows($videoQueryResult) > 0) {
	while($row = mysqli_fetch_assoc($videoQueryResult)) {
		$videoLink = $row["link"];
	}
} else {
	$videoLink = NULL;
	} 
if(isset($_POST["submit"])){
	$newDisplayName = $_POST['displayname'];
	$newType = $_POST['type'];
	$newDescription = $_POST['description'];
	$newCity = $_POST['city'];
	$newState = $_POST['state'];
	$newLocation = $_POST['location'];
	$newPrice = $_POST['price'];
	$newVideo = $_POST["video"];
	$newYoutube = $_POST['youtube'];
	$newInstagram = $_POST['instagram'];
	$newSoundcloud = $_POST['soundcloud'];
	$newprofileimage = $_POST['profile_image'];
	
	if ($newYoutube == "") {
		$newYoutube = NULL;
	}
	if ($newInstagram == "") {
		$newInstagram = NULL;
	}
	if ($newSoundcloud == "") {
		$newSoundcloud = NULL;
	}
	if ($newprofileimage == "") {
		$newprofileimage = NULL;
	}
	
	$newPriceInt = (int)$newPrice;
	
	$sql2 = "UPDATE users SET display_name='" . $newDisplayName . "', type='" . $newType . "', description='" . $newDescription . "', price=" . $newPriceInt . ", city='" . $newCity . "', state='" . $newState . "', youtube_link = '" . $newYoutube . "', instagram_link = '" . $newInstagram . "', soundcloud_link = '" . $newSoundcloud . "', profile_image = '" . $newprofileimage . "' WHERE username='" . $username . "';";
	
	if (isset($_POST['video']) && $videoLink === NULL) {
		$sql3 = "INSERT INTO links (id, link) VALUES (" . $id . ", '" . $newVideo . "');";
	}
	else if (isset($_POST['video'])) {
		$sql3 = "UPDATE links SET link='" . $newVideo . "' where id=" . $id . ";";
	}
	
	
	if(mysqli_query($conn, $sql2) AND mysqli_query($conn, $sql3)) {
		$queryResult . "success";
		$description = $newDescription;
		$display_name = $newDisplayName;
		$type = $newType;
		$price = $newPrice;
		header("location: profile.php");
	}
	else {
		$queryResult = "An error occured, try again later.";
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
    <title>Edit Profile</title>
	
	<style>
		<?php include 'css/editprofile.css';?>
		
	</style>
</head>
<body>
	<div class="limiter">
		<div class="container-bg">
		
			<div class="edit-header">
				<div class="container-header">
					<div class="logo">
						<a href="welcome.php"><img src="gigcitylogo_transparent.png" alt="GigCity">
						</a>
					</div>
				</div>
			</div>
			
			<div class="edit-body">
				<div class="container-header top-pad">
					<div class="body-header">

						<form action="profile.php" method="post">
							<span class="msg-header"><b><?php echo $username; ?></b>'s Profile</span>
						</form>
						<span class="txt1">To edit your profile, please fill out the following form below.</span>
					</div>

						<form class="edit-form" action="editprofile.php" method="post">
							<div class="form-group user-margin">
								<span class="label-input">Display Name</span>
								<input class="input-box" type="text" placeholder="Enter display name" name="displayname" value="<?php echo $display_name; ?>">
							</div>
							
							<div class="form-group user-margin">
								<span class="label-input">Performance Type</span>
								<input class="input-box" type="text" placeholder="Enter performance type" name="type" value="<?php echo $type; ?>">
							</div>
							
							<div class="form-group user-margin">
								<span class="label-input">Description</span>
								<input class="input-box" type="text" placeholder="What should others know about you?" name="description" value="<?php echo $description; ?>">
							</div>
							
							<div class="form-group user-margin">
								<span class="label-input">City</span>
								<input class="input-box" type="text" placeholder="Enter City" name="city" value="<?php echo $city; ?>">
							</div>
							
							<div class="form-group user-margin">
								<span class="label-input">State</span>
								<input class="input-box" type="text" placeholder="Enter State" name="state" value="<?php echo $state; ?>">
							</div>
							
							<div class="form-group user-margin">
								<span class="label-input">Price</span>
								<input class="input-box" type="text" placeholder="Enter price" name="price" value="<?php echo $price; ?>">
							</div>
							
							<div class="form-group">
								<span class="label-input">Video Link (Currently only supports Youtube videos)</span>
								<input class="input-box" type="text" placeholder="Enter a video link" name="video" value="<?php echo $videoLink; ?>" size="75">
							</div>
							
							<div class="form-group">
								<span class="label-input">Youtube Profile Link</span>
								<input class="input-box" type="text" placeholder="Enter a link to your profile on Youtube" name="youtube" value="<?php echo $youtube; ?>" size="75">
							</div>
							
							<div class="form-group">
								<span class="label-input">Instagram Link</span>
								<input class="input-box" type="text" placeholder="Enter a link to your profile on Instagram" name="instagram" value="<?php echo $instagram; ?>" size="75">
							</div>
							
							<div class="form-group">
								<span class="label-input">SoundCloud Link</span>
								<input class="input-box" type="text" placeholder="Enter a link to your Soundcloud" name="soundcloud" value="<?php echo $soundcloud; ?>" size="75">
							</div>
							
							<div class="form-group">
								<span class="label-input">Profile Picture Link</span>
								<input class="input-box" type="text" placeholder="Enter a link to a picture to use it as a profile picture" name="profile_image" value="<?php echo $profile_image; ?>" size="75">
							</div>
							
							<div class="col-center top-pad">
									<div class="nounderline">
										<a href="profile.php" class="txt2 ex et">		
											back to profile
										</a>
									</div>
								</div>
							<div class="col-center">
								<div class="login-btn">
									<div class="wraplogin-btn">
										<div class="btn-bg"></div>
										<button class="login-login" type="submit" value="Save Changes" name="submit">accept & save changes</button>
									</div>
								</div>
							</div>

							<!-- <input type="submit" value="Save Changes" name="submit"> -->

						</form>
					
				</div>
			</div>
		</div>
	</div>

<p><?php echo $queryResult; ?></p>
<p><?php echo $sql2; ?></p>
<p><?php echo $sql3; ?></p>
</body>
</html>