<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

$link=mysqli_connect("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }
	
 if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
	if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
          
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
          
            $param_username = $username;
            
         
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
              
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                  
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                     
                            session_start();
                            
                        
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            
                            header("location: welcome.php");
                        } else{
                           
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                   
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
	<!-- font reference Google Fonts API -->
	<link href='https://fonts.googleapis.com/css?family=Quicksand|Poppins|Montserrat|Open Sans' rel='stylesheet'>
    <title>Login</title>
   <style>
	<?php include 'css/login.css';?>
	   .container {
		   width: 100%;
		   position: absolute;
		   height: auto;
	   }
   </style>
</head>
<body>
    <div class="limiter">
		<div class="container-bg" style="background-image: url('images/bluesalmon.png');">
			<div class="wrap-login">
				<span class="login-header">
					Login
				</span>
				
				<form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="form-group user-margin <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
						<span class="label-input">Username</span>
						<input class="input-box" type="text" placeholder="Enter username" name="username" class="form-control" value="<?php echo $username; ?>">
						<span class="help-block"><?php echo $username_err; ?></span>
					</div> 
					
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
						<span class="label-input">Password</span>
						<input class="input-box" type="password" placeholder="Enter password" name="password" class="form-control" value="<?php echo $username; ?>">
						<span class="help-block"><?php echo $password_err; ?></span>
					</div>
					
					<div class="login-btn">
						<div class="wraplogin-btn">
							<div class="btn-bg"></div>
							<button class="login-login">Login</button>
						</div>
					</div>
					
					<div class="flex-col-c">
						<span class="txt1">
							Don't have an account?
						</span>
						<div class="nounderline">
							<a href="register.php" class="txt2 ex et">
								Create Account
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
	
	
	<div class="container">
		
	</div>
	<script>
		
	</script>
</body>
</html>