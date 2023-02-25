<?php
error_reporting(0);

require '../keyauth.php';
require '../credentials.php';

session_start();

if (!isset($_SESSION['user_data'])) // if user not logged in
{
    header("Location: ../");
    exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

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
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../");
    exit();
}
?>
<html lang="en">

<head>
    <title>Dashboard</title>
    <script src="https://cdn.keyauth.win/dashboard/unixtolocal.js"></script>
</head>

<body>
    <form method="post"><button name="logout">Logout</button></form>
    Logged in as <?php echo $username; ?>
    <br>

    <?php
    for ($i = 0; $i < count($subscriptions); $i++) {
        echo "#" . $i + 1 . " Subscription: " . $subscriptions[$i]->subscription . " - Subscription Expires: " . "<script>document.write(convertTimestamp(" . $subscriptions[$i]->expiry . "));</script>";
    }
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
//* Ban Function
 $KeyAuthApp->ban('Ban Reason Here');
*/
#endregion
?>
