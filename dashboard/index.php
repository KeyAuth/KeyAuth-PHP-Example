<?php
/*
* KEYAUTH.CC PHP EXAMPLE
*
* Edit credentials.php file and enter name & ownerid from https://keyauth.cc/app
*
* READ HERE TO LEARN ABOUT KEYAUTH FUNCTIONS https://github.com/KeyAuth/KeyAuth-PHP-Example#keyauthapp-instance-definition
*
*/

/*error_reporting(E_ALL);
ini_set('display_errors', 1); You can use this code for better error handling - recommended for local testing only*/

require '../keyauth.php';
require '../credentials.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

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
    $KeyAuthApp->logout();
    session_destroy();
    header("Location: ../");
    exit();
}

if (isset($_POST['enable2fa'])) {
    $KeyAuthApp->enable2fa($_POST['2facode']);
}

if (isset($_POST['disable2fa'])) {
    $KeyAuthApp->disable2fa($_POST['2facode']);
}
?>
<!DOCTYPE html>
<html lang="en" class="bg-[#09090d] text-white overflow-x-hidden">

<head>
    <title>Dashboard</title>
    <script src="https://cdn.keyauth.cc/dashboard/unixtolocal.js"></script>

    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/dist/output.css">
</head>

<body class="min-h-screen bg-[#09090d] text-white">
  <div class="container mx-auto px-4">
    <!-- Header -->
    <header class="flex justify-end py-4">
      <form method="post">
        <button
          name="logout"
          class="inline-flex text-white bg-red-700 hover:opacity-60 focus:ring-0 font-medium rounded-lg text-sm px-5 py-2.5 transition duration-200">
          Logout
        </button>
      </form>
    </header>

    <!-- Main section for user data -->
    <main class="flex flex-col items-center justify-center py-8">
      <div class="text-center mb-8">
        <p class="text-md"><b>Logged in as:</b> <?= $username; ?></p>
        <p class="text-md">
            <b>IP:</b>
            <span class="inline-block ml-1 filter blur-sm hover:blur-none transition duration-300">
                <?= $ip; ?>
            </span>
        </p>
        <p class="text-md"><b>Creation Date:</b> <?= date('Y-m-d H:i:s', $creationDate); ?></p>
        <p class="text-md"><b>Last Login:</b> <?= date('Y-m-d H:i:s', $lastLogin); ?></p>
        <p class="text-md">
          <b>Does subscription with name:</b>
          <code class="bg-blue-800 rounded-md font-mono px-1">default</code>
          exist: <?= ((findSubscription("default", $_SESSION["user_data"]["subscriptions"]) ? 1 : 0) ? 'yes' : 'no'); ?>
        </p>
        <?php 
          for ($i = 0; $i < count($subscriptions); $i++) {
            echo "<p class='text-md'>#" . ($i+1) . " Subscription: " . $subscriptions[$i]->subscription . " - Subscription Expires: <script>document.write(convertTimestamp(" . $subscriptions[$i]->expiry . "));</script></p>";
          }
        ?>
      </div>
    </main>

    <!-- 2FA Section-->
    <section class="max-w-lg mx-auto pb-8">
      <form method="post">
        <div class="relative mb-4">
          <input type="text" id="2facode" name="2facode"
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border border-gray-300 appearance-none focus:ring-0 peer"
            autocomplete="on">
          <label for="2facode"
            class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
            2FA Code
          </label>
        </div>

        <div class="flex justify-around">
          <button
            name="enable2fa"
            class="inline-flex text-white bg-blue-700 hover:opacity-60 focus:ring-0 font-medium rounded-lg text-sm px-5 py-2.5 transition duration-200">
            Enable 2FA
          </button>

          <button
            name="disable2fa"
            class="inline-flex text-white bg-red-700 hover:opacity-60 focus:ring-0 font-medium rounded-lg text-sm px-5 py-2.5 transition duration-200 ml-2">
            Disable 2FA
          </button>
        </div>
      </form>
    </section>
  </div>
</body>
</html>
