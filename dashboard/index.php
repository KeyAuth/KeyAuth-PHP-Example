<?php

if(!isset($_SESSION))
    session_start();

date_default_timezone_set('America/New_York'); // change this to whatever time zone you want expiry to display in

if (!isset($_SESSION['user_data'])) {
        header("Location: ../");
        exit();
}

$key = $_SESSION["user_data"]["key"];
$expiry = $_SESSION["user_data"]["expiry"];
?>
<html>
<head>
<title>Dashboard</title>
</head>
<body>
Logged in as <?php echo $key; ?>
<br>
Your Key Expires At <?php echo date('jS F Y h:i:s A (T)', $expiry); ?>
</body>
</html>