<?php
include '../keyauth.php';
include '../credentials.php';

if (!isset($_SESSION['sessionid'])) {
    $KeyAuthApp = new KeyAuth\api($name, $ownerid);
    $KeyAuthApp->init();
} else {
    $KeyAuthApp = new KeyAuth\api($name, $ownerid);
}
?>
<!DOCTYPE html>
<html lang="en" class="bg-custom-back-1 text-white overflow-x-hidden">

<head>
    <title>KeyAuth - Upgrade Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://cdn.keyauth.cc/global/imgs/Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.keyauth.cc/v4/css/oput.css">

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
    </div>

    <section class="flex items-center justify-center min-h-screen relative z-10">
        <div class="bg-custom-back rounded-xl p-4 md:p-10 w-full max-w-lg flex flex-col justify-center mx-2">
            <h1 class="mb-6 text-2xl md:text-3xl text-center font-semibold text-white">Upgrade Account</h1>
            <h3 class="mb-8 text-sm md:text-lg text-center font-normal text-gray-300">
                Redeem a license key to extend your subscription.
            </h3>

            <form class="space-y-6" method="post">
                <div class="relative">
                    <input type="text" name="username" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Username</label>
                </div>
                <div class="relative mt-6">
                    <input type="text" name="key" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">License Key</label>
                </div>
                <button name="upgrade" class="mt-6 w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition-colors">Upgrade</button>
                <div class="text-sm font-medium text-gray-400 mt-6 text-center">
                    <a href="../" class="text-blue-500 hover:underline">Back to Login</a>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
    if (isset($_POST['upgrade'])) {
        if ($KeyAuthApp->upgrade($_POST['username'], $_POST['key'])) {
            $KeyAuthApp->success("Upgraded successfully! Now please login.");
        }
    }
    ?>
</body>

</html>