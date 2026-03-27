<?php
require '../keyauth.php';
require '../credentials.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['user_data'])) {
    header("Location: ../");
    exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

$username = $_SESSION["user_data"]["username"];
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$ip = $_SESSION["user_data"]["ip"];
$hwid = $_SESSION["user_data"]["hwid"] ?? "Not assigned";
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
<html lang="en" class="bg-custom-back-1 text-white overflow-x-hidden">

<head>
    <title>Dashboard - <?= $name; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://cdn.keyauth.cc/global/imgs/Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.keyauth.cc/v4/css/oput.css">
    <script src="https://cdn.keyauth.cc/dashboard/unixtolocal.js"></script>
</head>

<body class="min-h-screen">
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Navbar -->
        <nav class="flex justify-between items-center bg-custom-back/80 backdrop-blur-md p-4 rounded-xl border border-white/10 mb-8 shadow-lg">
            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent"><?= $name; ?> Dashboard</h1>
            <form method="post">
                <button name="logout" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white px-4 py-2 rounded-lg border border-red-600/30 transition-all font-semibold">Logout</button>
            </form>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- User Info Card -->
            <div class="bg-custom-back rounded-xl p-6 border border-white/10 shadow-xl">
                <h2 class="text-xl font-semibold mb-6 border-b border-white/10 pb-2">User Information</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Username:</span>
                        <span class="font-medium text-white"><?= htmlspecialchars($username); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">IP Address:</span>
                        <span class="font-medium text-white blur-sm hover:blur-none transition-all cursor-pointer"><?= htmlspecialchars($ip); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">HWID:</span>
                        <span class="font-medium text-white transition-all"><?= htmlspecialchars($hwid); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Created:</span>
                        <span class="font-medium text-white"><?= date('Y-m-d H:i', $creationDate); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Last Login:</span>
                        <span class="font-medium text-white"><?= date('Y-m-d H:i', $lastLogin); ?></span>
                    </div>
                </div>
            </div>

            <!-- Subscriptions Card -->
            <div class="bg-custom-back rounded-xl p-6 border border-white/10 shadow-xl">
                <h2 class="text-xl font-semibold mb-6 border-b border-white/10 pb-2">Your Subscriptions</h2>
                <div class="space-y-4 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
                    <?php if (empty($subscriptions)): ?>
                        <p class="text-gray-400 italic">No active subscriptions found.</p>
                    <?php else: ?>
                        <?php foreach ($subscriptions as $i => $sub): ?>
                            <div class="bg-white/5 p-4 rounded-lg border border-white/5">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-blue-400"><?= htmlspecialchars($sub->subscription); ?></span>
                                    <span class="text-xs bg-blue-500/20 text-blue-300 px-2 py-1 rounded">Active</span>
                                </div>
                                <div class="text-sm text-gray-400 mt-2">
                                    Expires: <script>
                                        document.write(convertTimestamp(<?= $sub->expiry; ?>));
                                    </script>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 2FA Management Card -->
            <div class="bg-custom-back rounded-xl p-6 border border-white/10 shadow-xl md:col-span-2 max-w-2xl mx-auto w-full">
                <h2 class="text-xl font-semibold mb-6 border-b border-white/10 pb-2">Security (2FA)</h2>
                <form method="post" class="space-y-6">
                    <div class="relative">
                        <input type="text" name="2facode" id="2facode" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label for="2facode" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">2FA Code</label>
                    </div>
                    <div class="flex gap-4">
                        <button name="enable2fa" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">Enable 2FA</button>
                        <button name="disable2fa" class="flex-1 bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white border border-red-600/30 font-bold py-3 px-4 rounded-lg transition-colors">Disable 2FA</button>
                    </div>
                    <p class="text-xs text-gray-500 text-center italic">Leave blank when first enabling to receive your secret code.</p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</body>

</html>