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
?>
<!DOCTYPE html>
<html lang="en" class="bg-custom-back-1 text-white overflow-x-hidden">

<head>
    <title>KeyAuth - Login to <?= $name; ?></title>
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
            <h1 class="mb-6 text-2xl md:text-3xl text-center font-semibold text-white"><?= $name; ?> Panel</h1>
            <h3 class="mb-8 text-sm md:text-lg text-center font-normal text-gray-300">
                New to the panel? <a href="register/" class="text-blue-500 hover:underline">Sign up</a>
            </h3>

            <div class="mb-4 flex justify-center">
                <div id="tabs-segmented" class="relative inline-flex rounded-2xl p-1 border border-white/10 bg-custom-back/90 gap-1 shadow-inner">
                    <span id="tabs-slider" class="absolute top-1 bottom-1 left-0 rounded-xl bg-gray-600/30 ring-1 ring-black/40 pointer-events-none transition-all duration-300"></span>
                    <button data-tab="user" class="relative z-10 px-4 py-2 rounded-xl font-semibold text-white transition-colors" type="button">Username</button>
                    <button data-tab="email" class="relative z-10 px-4 py-2 rounded-xl font-semibold text-white/70 hover:text-white transition-colors" type="button">Email</button>
                    <button data-tab="license" class="relative z-10 px-4 py-2 rounded-xl font-semibold text-white/70 hover:text-white transition-colors" type="button">License</button>
                </div>
            </div>

            <form class="mt-8 space-y-6" method="post">
                <!-- User Login -->
                <div id="user-content" class="tab-content">
                    <div class="relative">
                        <input type="text" name="username" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Username</label>
                    </div>
                    <div class="relative mt-6">
                        <input type="password" name="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
                    </div>
                    <div class="flex justify-end mt-1">
                        <a href="forgot/" class="text-xs text-blue-500 hover:underline">Forgot?</a>
                    </div>
                    <div class="relative mt-6">
                        <input type="text" name="tfa" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">2FA Code (Optional)</label>
                    </div>
                    <button name="login" class="mt-6 w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition-colors">Login</button>
                </div>

                <!-- Email Login -->
                <div id="email-content" class="tab-content hidden">
                    <div class="relative">
                        <input type="email" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                    </div>
                    <div class="relative mt-6">
                        <input type="password" name="password_email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
                    </div>
                    <div class="flex justify-end mt-1">
                        <a href="forgot/" class="text-xs text-blue-500 hover:underline">Forgot?</a>
                    </div>
                    <div class="relative mt-6">
                        <input type="text" name="tfa_email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">2FA Code (Optional)</label>
                    </div>
                    <button name="login_email" class="mt-6 w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition-colors">Login with Email</button>
                </div>

                <!-- License Login -->
                <div id="license-content" class="tab-content hidden">
                    <div class="relative">
                        <input type="text" name="key" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">License Key</label>
                    </div>
                    <div class="relative mt-6">
                        <input type="text" name="tfa_key" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-custom-back-lbl px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">2FA Code (Optional)</label>
                    </div>
                    <button name="login_license" class="mt-6 w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition-colors">Login with License</button>
                </div>

                <div class="text-sm font-medium text-gray-400 mt-6">
                    Need to upgrade? <a href="upgrade/" class="text-blue-500 hover:underline">Upgrade Now</a>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        document.querySelectorAll('button[data-tab]').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
                document.getElementById(tab + '-content').classList.remove('hidden');

                document.querySelectorAll('button[data-tab]').forEach(b => {
                    b.classList.remove('text-white');
                    b.classList.add('text-white/70');
                });
                btn.classList.add('text-white');
                btn.classList.remove('text-white/70');

                const slider = document.getElementById('tabs-slider');
                slider.style.width = btn.offsetWidth + 'px';
                slider.style.transform = `translateX(${btn.offsetLeft}px)`;
            });
        });
        // Init slider
        window.addEventListener('load', () => {
            const first = document.querySelector('button[data-tab="user"]');
            const slider = document.getElementById('tabs-slider');
            slider.style.width = first.offsetWidth + 'px';
        });
    </script>

    <?php
    if (isset($_POST['login'])) {
        if ($KeyAuthApp->login($_POST['username'], $_POST['password'], $_POST['tfa'])) {
            echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
            $KeyAuthApp->success("Logged in successfully!");
        }
    }
    if (isset($_POST['login_email'])) {
        if ($KeyAuthApp->loginEmail($_POST['email'], $_POST['password_email'], $_POST['tfa_email'])) {
            echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
            $KeyAuthApp->success("Logged in successfully!");
        }
    }
    if (isset($_POST['login_license'])) {
        if ($KeyAuthApp->license($_POST['key'], $_POST['tfa_key'])) {
            echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
            $KeyAuthApp->success("Logged in successfully!");
        }
    }
    ?>
</body>

</html>