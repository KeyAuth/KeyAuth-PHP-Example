<?php
/*
* KEYAUTH.CC PHP EXAMPLE
*
* Edit credentials.php file and enter name & ownerid from https://keyauth.cc/app
*
* READ HERE TO LEARN ABOUT KEYAUTH FUNCTIONS https://github.com/KeyAuth/KeyAuth-PHP-Example#keyauthapp-instance-definition
*
*/
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

<html lang="en" class="bg-[#09090d] text-white overflow-x-hidden">

<head>
    <title>KeyAuth PHP Example</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://cdn.keyauth.cc/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/dist/output.css">
</head>

<body>
    <header>
        <nav class="border-gray-200 px-4 lg:px-6 py-2.5 mb-14">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="../" class="flex items-center">
                    <img src="https://cdn.keyauth.cc/v2/assets/media/logos/logo-1-dark.png" class="mr-3 h-12 mt-2"
                        alt="KeyAuth Logo" />
                </a>
                <div class="flex items-center lg:order-2">
                    <a href="https://keyauth.cc" target="_blank"
                        class="text-white focus:ring-0 font-medium rounded-lg text-sm px-4 py-2 lg:px-5 lg:py-2.5 mr-2 hover:opacity-60 transition duration-200 focus:outline-none focus:ring-gray-800">
                        Help Via Ticket
                    </a>
                    <a href="https://t.me/keyauth" target="_blank"
                        class="text-white focus:ring-0 font-medium rounded-lg text-sm px-4 py-2 lg:px-5 lg:py-2.5 mr-2 bg-blue-600 hover:opacity-80 focus:outline-none focus:ring-blue-800 transition duration-200">
                        Help Via Telegram
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <section>
        <div class="relative z-10 flex flex-wrap md:-m-8 ml-8 md:ml-24">
            <div class="w-full md:w-1/2 md:p-8">
                <div class="md:max-w-lg md:mx-auto md:pt-36">
                    <h2
                        class="mb-7 md:mb-12 text-3xl md:text-6xl font-bold font-heading tracking-px-n leading-tight text-center">
                        Welcome to the <span
                            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400 inline-block">KeyAuth
                            PHP Example</span>
                        👋
                    </h2>

                    <h3 class="mb-9 text-sm md:text-xl font-bold font-heading leading-normal">
                        The best authentication platform for your software.
                    </h3>
                </div>
            </div>
            <div class="w-full md:w-1/2 md:p-8 -ml-4 md:-ml-12">
                <div class="p-2 md:p-4 py-16 flex flex-col justify-center h-full">
                    <form class="md:max-w-md md:ml-32 space-y-4 md:space-y-6" method="post" data-postform="1">
                        <div class="relative mb-4" data-username="1">
                            <input type="text" id="username" name="username"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer"
                                placeholder=" " autocomplete="on">
                            <label for="username"
                                class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Username</label>
                        </div>

                        <div class="relative mb-4" data-password="1">
                            <input type="password" id="password" name="password"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer"
                                placeholder=" " autocomplete="on">
                            <label for="password"
                                class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
                        </div>

                        <div class="relative mb-4" data-twofactor="1">
                            <input type="text" id="key" name="key"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer"
                                placeholder=" " autocomplete="on">
                                <label for="key"
                                class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Key</label>
                        </div>

                        <button name="login" data-loginbutton="1"
                            class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                            <span class="inline-flex">
                                Login
                                <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                </svg></span>
                        </button>

                        <button name="register" data-loginbutton="1"
                            class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                            <span class="inline-flex">
                                Register
                                <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                </svg></span>
                        </button>

                        <button name="upgrade" data-loginbutton="1"
                            class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                            <span class="inline-flex">
                                Upgrade
                                <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                </svg></span>
                        </button>

                        <button name="license" data-loginbutton="1"
                            class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                            <span class="inline-flex">
                                License Register/Login
                                <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                </svg></span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
        if (isset($_POST['login'])) {
                // login with username and password
                if ($KeyAuthApp->login($_POST['username'], $_POST['password'])) {
                        echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
                        $KeyAuthApp->success("You have successfully logged in!");
                }
        }

        if (isset($_POST['register'])) {
                // register with username,password,key
                if ($KeyAuthApp->register($_POST['username'], $_POST['password'], $_POST['key'])) {
                        echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
                        $KeyAuthApp->success("You have successfully registered!");
                }
        }

        if (isset($_POST['license'])) {
                // login with just key
                if ($KeyAuthApp->license($_POST['key'])) {
                        echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
                        $KeyAuthApp->success("You have successfully logged in!");
                }
        }

        if (isset($_POST['upgrade'])) {
                if ($KeyAuthApp->upgrade($_POST['username'], $_POST['key'])) {
                        // don't login, upgrade function is not for authentication, it's simply for redeeming keys
                        $KeyAuthApp->success("Upgraded Successfully! Now login please.");
                }
        }
        ?>

</body>

</html>
