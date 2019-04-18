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

$keywords = $_POST['keywords'];
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Quicksand|Poppins|Montserrat|Open Sans' rel='stylesheet'>
		<title>Search</title>
		
		<style>
		<?php include 'css/search.css';?>
		</style>
	
	</head>
	<body>
		<div class="limiter">
			<div class="container-bg" style="background-image: url('images/bluesalmon.png');">
				<div class="wrap-login">
					<span class="login-header">
						Search
					</span>
	
					<form class="login-form" action="searchresult.php?keywords=<?php echo $keywords; ?>" method="get">
						
						<div class="form-group">
							<input class="input-box" type="text" placeholder="Enter a keyword" autocomplete="off" name='keywords'>
						</div>
						
						<div class="login-btn">
							<div class="wraplogin-btn">
								<div class="btn-bg"></div>
									<button class="login-login">search</button>
							</div>
						</div>
						
						<div class="col-center">
							<div class="nounderline">
								<a href="welcome.php" class="txt2 ex et">back to home</a>
							</div>
						</div>
						
					</form
				</div>
			</div>		
		</div>
	</body>
</html>