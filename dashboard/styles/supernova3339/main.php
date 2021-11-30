
<?php

session_start();

// Check If User Logged In -->
if (!isset($_SESSION['user_data'])) // if user not logged in
{
        header("Location: ../");
        exit();
}

// Logout User on '?logout' -->
if(isset($_GET['logout']))
{
    logout();
}
// Logout Function -->
function logout(){
    session_destroy();
	header("Location: ../");
    exit();
}

$title = "Dashboard";
// Template admin header
function template_admin_header() {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Dashboard</title>
		<link href="admin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="admin">
        <header>
            <h1><p style="color:lightblue;">Dash</p>Board</h1>
            <a class="responsive-toggle" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </header>
        <aside class="responsive-width-100 responsive-hidden">
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
            <a href="key.php"><i class="fas fa-key"></i>Licensing</a>
            <a href="settings.php"><i class="fas fa-tools"></i>Settings</a>
            <a href="?logout"><i class="fas fa-sign-out-alt"></i>Log Out</a>
        </aside>
        <main class="responsive-width-100">
EOT;
}
// Template admin footer


function template_admin_footer() {
echo <<<EOT
        </main>
        <script>
        document.querySelector(".responsive-toggle").onclick = function(event) {
            event.preventDefault();
            var aside_display = document.querySelector("aside").style.display;
            document.querySelector("aside").style.display = aside_display == "flex" ? "none" : "flex";
        };
        </script>
    </body>
</html>
EOT;
}
?>
