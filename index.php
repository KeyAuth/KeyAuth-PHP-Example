<?php
	
require 'keyauth.php';

/*
WATCH VIDEO TO SETUP: https://youtube.com/watch?v=NCZkg_O92sA
*/

if (isset($_SESSION['user_data'])) 
{
	header("Location: dashboard/");
    exit();
}

$name = ""; // your application name
$ownerid = ""; // your KeyAuth account's ownerid, located in account settings 
$KeyAuthApp = new KeyAuth\api($name, $ownerid);

if (!isset($_SESSION['sessionid'])) 
{
	$KeyAuthApp->init();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://keyauth.com/assets/img/favicon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-51">
						KeyAuth PHP Example
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Key is required">
						<input class="input100" type="text" name="key" placeholder="Key">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button name="login" class="login100-form-btn">
							Login
						</button>
					</div>
					
					<div class="container-login100-form-btn m-t-17">
						<button name="register" class="login100-form-btn">
							Register
						</button>
					</div>
					
					<div class="container-login100-form-btn m-t-17">
						<button name="license" class="login100-form-btn">
							License
						</button>
					</div>
					
					<div class="container-login100-form-btn m-t-17">
						<button name="upgrade" class="login100-form-btn">
							Upgrade
						</button>
					</div>

				</form>
			</div>	
		</div>
	</div>
	
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
        if (isset($_POST['login']))
        {
		// login with username and password
		if($KeyAuthApp->login($_POST['username'],$_POST['password']))
		{
			echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
			                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully logged in!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';     
		}
		}
		
		if (isset($_POST['register']))
        {
		// register with username,password,key
		if($KeyAuthApp->register($_POST['username'],$_POST['password'],$_POST['key']))
		{
			echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
			                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully logged in!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';     
		}
		}
		
		if (isset($_POST['license']))
        {
		// login with just key
		if($KeyAuthApp->license($_POST['key']))
		{
			echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
			                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully logged in!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';     
		}
		}
		
		if (isset($_POST['upgrade']))
        {
		// login with just key
		if($KeyAuthApp->upgrade($_POST['username'],$_POST['key']))
		{
							// don't login, upgrade function is not for authentication, it's simply for redeeming keys
			                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'Upgraded Successful!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';     
		}
		}
    ?>
	<div id="dropDownSelect1"></div>
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
