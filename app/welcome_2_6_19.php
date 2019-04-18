<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>

<h1>Welcome to GigCity!</h1>

<a href="logout.php" class="btn btn-danger">Log Out</a>

<a href="profile.php" class="btn btn-danger">My Profile</a>

<a href="createevent.php" class="btn btn-danger">Create Event</a>

<h3>Search</h3>
</body>
</html>