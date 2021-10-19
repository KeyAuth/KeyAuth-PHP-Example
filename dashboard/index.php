<?php

session_start();

if (!isset($_SESSION['user_data'])) // if user not logged in
{
        header("Location: ../");
        exit();
}

$username = $_SESSION["user_data"]["username"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;

if(isset($_POST['logout']))
{
	session_destroy();
	header("Location: ../");
    exit();
}
?>
<html>
<head>
<title>Dashboard</title>
<script src="https://cdn.keyauth.com/dashboard/unixtolocal.js"></script>
</head>
<body>
<form method="post"><button name="logout">Logout</button></form>
Logged in as <?php echo $username; ?>
<br>
Your Subscription:<?php echo $subscription; ?>
<br>
Your Subscription Expires: <script>document.write(convertTimestamp(<?php echo $expiry; ?>));</script>
</body>
</html>