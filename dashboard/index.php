<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_data'])) // if user not logged in
{
        header("Location: ../");
        exit();
}

function findSubscription($name, $list) {
   for ($i = 0;$i < count($list);$i++)
   {
	 if ($list[$i]->subscription == $name)
	 {
		 return true;
	 }
	}
   return false;
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
<script src="https://cdn.keyauth.win/dashboard/unixtolocal.js"></script>
</head>
<body>
<form method="post"><button name="logout">Logout</button></form>
Logged in as <?php echo $username; ?>
<br>
Your Subscription:<?php echo $subscription; ?>
<br>
Your Subscription Expires: <script>document.write(convertTimestamp(<?php echo $expiry; ?>));</script>
<br>
Does subscription with name <code style="background-color: #eee;border-radius: 3px;font-family: courier, monospace;padding: 0 3px;">default</code> exist: <?php echo ((findSubscription("default", $_SESSION["user_data"]["subscriptions"]) ? 1 : 0) ? 'yes' : 'no'); ?>
</body>
</html>
