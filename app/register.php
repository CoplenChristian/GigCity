
<?php

$link=mysqli_connect("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");


$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
		$sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            
			if(mysqli_stmt_execute($stmt)){
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
       
        mysqli_stmt_close($stmt);
    }
    
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
   
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
           
			if(mysqli_stmt_execute($stmt)){
              
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
       
        mysqli_stmt_close($stmt);
    }
	mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Quicksand|Poppins|Montserrat|Open Sans' rel='stylesheet'>
    <title>Register</title>
	
	<style>
		<?php include 'css/register.css';?>
	</style>
	
    
</head>
<body>
	<div class="limiter">
		<div class="container-bg" style="background-image: url('images/bluesalmon.png');">
			<div class="wrap-login">
					<span class="login-header">
						<h1>Register</h1>
					</span>
					
					<form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group user-margin <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
							<span class="label-input">Username</span>
							<input class="input-box" type="text" placeholder="Enter username" name="username" class="form-control" value="<?php echo $username; ?>">
							<span class="help-block"><?php echo $username_err; ?></span>
						</div>
						
						<div class="form-group user-margin <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
							<span class="label-input">Password</span>
							<input class="input-box" type="password" placeholder="Enter password" name="password" class="form-control" value="<?php echo $password; ?>"p
							<span class="help-block"><?php echo $password_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
							<span class="label-input">Confirm Password</span>
							<input class="input-box" type="password" placeholder="Confirm password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
							<span class="help-block"><?php echo $confirm_password_err; ?></span>
						</div>
						
						<p class="notice txt1">By clicking on Sign up, you agree to GigCity's <a href="#" class="et ex" >Terms and Conditions of Use</a>.
						</p>
						
						<div class="login-btn">
							<div class="wraplogin-btn">
								<div class="btn-bg"></div>
								<button type="submit" value="Submit" class="login-login">sign up</button>
							</div>
						</div>
						
						<div>
							<!-- <input type="submit" class="btn btn-primary" value="Submit"> -->
							<input type="reset" class="btn btn-default" value="Reset">
						</div>

						<div class="flex-col-c">
						<span class="txt1">
							Already have an account?
						</span>
						<div class="nounderline">
							<a href="login.php" class="txt2 ex et">
								Login
							</a>
						</div>
					</div>
					</form>
				
			</div>
		</div>
	</div>
</body>
</html>