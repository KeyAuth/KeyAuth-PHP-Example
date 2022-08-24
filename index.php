<?php
include 'keyauth.php';
include 'credentials.php';

if (isset($_SESSION['user_data'])) {
	header("Location: dashboard/");
	exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

if (!isset($_SESSION['sessionid'])) {
	$KeyAuthApp->init();
}

$numKeys = $_SESSION["numUsers"];
$numUsers = $_SESSION["numKeys"];
$numOnlineUsers = $_SESSION["numOnlineUsers"];
$customerPanelLink = $_SESSION["customerPanelLink"];
?>

<html lang="en">
<head>
	<title>KeyAuth PHP Example</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="https://cdn.keyauth.win/assets/img/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

	<link href="https://cdn.keyauth.cc/v2/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.keyauth.cc/v2/assets/css/style.bundle.css" rel="stylesheet" type="text/css">
</head>

<body class="bg-dark">
	<div class="d-flex flex-column flex-root">
		<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
					<form class="form w-100" method="post">
						<div class="text-center mb-10">
							<h1 class="text-light mb-3">KeyAuth PHP Example</h1>
						</div>

						<div class="fv-row mb-10">
							<!-- username -->
							<label class="form-label fs-6 fw-bolder text-light">Username</label>
							<input class="form-control form-control-lg form-control-solid" type="text" name="username" autocomplete="on" />
							<div class="form-group row">
								</br>
							</div>
							<!-- password -->
							<div class="fv-row mb-4">
								<div class="d-flex flex-stack mb-2">
									<label class="form-label fw-bolder text-light fs-6 mb-0">Password</label>
								</div>
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="on" />
							</div>
							<!-- License -->
							<div class="fv-row mb-6">
								<div class="d-flex flex-stack mb-2">
									<label class="form-label fw-bolder text-light fs-6 mb-0">License</label>
								</div>
								<input class="form-control form-control-lg form-control-solid" type="text" name="key" autocomplete="on" />
							</div>
							<div class="text-center">
								<button name="login" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Login</span>
								</button>
								<button name="register" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Register</span>
								</button>
								<button name="upgrade" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Upgrade</span>
								</button>
								<button name="license" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">License</span>
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<a class="text-muted text-hover-primary px-2">Online Users: <?php echo $numOnlineUsers; ?></a>
						<a class="text-muted text-hover-primary px-2">Total Keys: <?php echo $numKeys; ?></a>
						<a class="text-muted text-hover-primary px-2">Total Users: <?php echo $numUsers; ?></a>
					</div>
					<!--end::Links-->
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

	<?php
	if (isset($_POST['login'])) {
		// login with username and password
		if ($KeyAuthApp->login($_POST['username'], $_POST['password'])) {
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

	if (isset($_POST['register'])) {
		// register with username,password,key
		if ($KeyAuthApp->register($_POST['username'], $_POST['password'], $_POST['key'])) {
			echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
			echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully registered!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';
		}
	}

	if (isset($_POST['license'])) {
		// login with just key
		if ($KeyAuthApp->license($_POST['key'])) {
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

	if (isset($_POST['upgrade'])) {
		// login with just key
		if ($KeyAuthApp->upgrade($_POST['username'], $_POST['key'])) {
			// don't login, upgrade function is not for authentication, it's simply for redeeming keys
			echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'Upgraded Successfully! Now login please.\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';
		}
	}
	?>

</body>
</html>
