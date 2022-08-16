<?php
error_reporting(0);

require '../keyauth.php';
require '../credentials.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_data'])) // if user not logged in
{
	header("Location: ../");
	exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

// Check if user is logged in method 2
if (!$KeyAuthApp->check()) {
	session_destroy();
	header("Location: ../");
	exit();
}

function findSubscription($name, $list)
{
	for ($i = 0; $i < count($list); $i++) {
		if ($list[$i]->subscription == $name) {
			return true;
		}
	}
	return false;
}

$username = $_SESSION["user_data"]["username"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;

if (isset($_POST['logout'])) {
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

	<?php
	// Check Subscriptions..
	for ($i = 0; $i < count($subscriptions); $i++) {
		echo "#" . $i + 1 . " Subscription: " . $subscriptions[$i]->subscription . " - Subscription Expires: " . "<script>document.write(convertTimestamp(" . $subscriptions[$i]->expiry . "));</script>";
	}

	// Check Online users..
	$onlineUsers = $KeyAuthApp->fetchOnline();
	if ($onlineUsers == null) {
		$Online = "No online Users";
	} else {
		$Online = "Online Users: <br>";
		for ($i = 0; $i < count($onlineUsers); $i++) {
			if ($i == count($onlineUsers) - 1) {
				$Online .= $onlineUsers[$i]->credential;
			} else {
				$Online .= $onlineUsers[$i]->credential . "<br>";
			}
		}

		echo "<br><p style=\"font-weight: bold; font-size: 12px;\">" . $Online . "</p>";
	}

	// Check chat Messages

	//$KeyAuthApp->chatSend("MESSAGE", "CHANNEL"); // Send a message to a channel
	$chatMessages = $KeyAuthApp->chatGet("CHANNEL"); // Return Message Array if existing.
	if ($chatMessages == null) {
		$Msgs = "No chat Messages";
	} else {
		$Msgs = "Chat Messages: <br>";
		for ($i = 0; $i < count($chatMessages); $i++) {
			if ($i == count($chatMessages) - 1) {
				$Msgs .= "<script>document.write(convertTimestamp(" . $chatMessages[$i]->timestamp . "));</script>" . " - " . $chatMessages[$i]->author . ": " . $chatMessages[$i]->message;
			} else {
				$Msgs .= "<script>document.write(convertTimestamp(" . $chatMessages[$i]->timestamp . "));</script>" . " - " . $chatMessages[$i]->author . ": " . $chatMessages[$i]->message . "<br>";
			}
		}
	}

	echo "<br><p style=\"font-weight: bold; font-size: 12px;\">" . $Msgs . "</p>";
	?>

	<br>
	Does subscription with name <code style="background-color: #eee;border-radius: 3px;font-family: courier, monospace;padding: 0 3px;">default</code> exist: <?php echo ((findSubscription("default", $_SESSION["user_data"]["subscriptions"]) ? 1 : 0) ? 'yes' : 'no'); ?>
</body>
</html>

<?php
#region Extra Functions
/*
//* Get Public Variable
$var = $KeyAuthApp->var("varName");
echo "Variable Data: " . $var;

//* Get User Variable
$var = $KeyAuthApp->getvar("varName");
echo "Variable Data: " . $var;

//* Set Up User Variable
$KeyAuthApp->setvar("varName", "varData");

//* Log Something to the KeyAuth webhook that you have set up on app settings
$KeyAuthApp->log("message");

//* Basic Webhook with params
$result = $KeyAuthApp->webhook("WebhookID", "&type=add&expiry=1&mask=XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX&level=1&amount=1&format=text");
echo "<br> Result from Webhook: " . $result;

//* Webhook with body and content type
$result = $KeyAuthApp->webhook("WebhookID", "", "{\"content\": \"webhook message here\",\"embeds\": null}", "application/json");
echo "<br> Result from Webhook: " . $result;


//* If first sub is what ever then run code
if ($subscription === "Premium") {
	Premium Subscription Code ...
}

*/
#endregion
?>