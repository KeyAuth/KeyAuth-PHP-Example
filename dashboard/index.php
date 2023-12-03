<?php
/*
* KEYAUTH.CC PHP EXAMPLE
*
* Edit credentials.php file and enter name & ownerid from https://keyauth.cc/app
*
* READ HERE TO LEARN ABOUT KEYAUTH FUNCTIONS https://github.com/KeyAuth/KeyAuth-PHP-Example#keyauthapp-instance-definition
*
*/
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
$ip = $_SESSION["user_data"]["ip"];
$creationDate = $_SESSION["user_data"]["createdate"];
$lastLogin = $_SESSION["user_data"]["lastlogin"];

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../");
    exit();
}
?>
<html lang="en" class="bg-[#09090d] text-white overflow-x-hidden">

<head>
    <title>Dashboard</title>
    <script src="https://cdn.keyauth.cc/dashboard/unixtolocal.js"></script>

    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/dist/output.css">
</head>

<body>
    <?php
        $KeyAuthApp->log("New login from: " . $username); // sends a log to the KeyAuth logs page https://keyauth.cc/app/?page=logs.
    ?>

    <form method="post">
        <button
            class="inline-flex text-white bg-red-700 hover:opacity-60 focus:ring-0 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 transition duration-200"
            name="logout">
            Logout
        </button>
    </form>

    <p class="text-md">Logged in as <?= $username; ?></p>
    <p class="text-md">IP <?= $ip; ?></p>
    <p class="text-md">Creation Date <?= date('Y-m-d H:i:s', $creationDate) ?></p>
    <p class="text-md">Last Login <?= date('Y-m-d H:i:s', $lastLogin) ?></p>
    <p class="text-md">Does subscription with name <code
            style="background-color: #1a56db;border-radius: 3px;font-family: courier, monospace;padding: 0 3px;">default</code>
        exist: <?= ((findSubscription("default", $_SESSION["user_data"]["subscriptions"]) ? 1 : 0) ? 'yes' : 'no'); ?>
    </p>

    <?php
    for ($i = 0; $i < count($subscriptions); $i++) {
        echo "#" . $i + 1 . " Subscription: " . $subscriptions[$i]->subscription . " - Subscription Expires: " . "<script>document.write(convertTimestamp(" . $subscriptions[$i]->expiry . "));</script>";
    }
    ?>
</body>

</html>
