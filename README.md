# KeyAuth-PHP-Example : Please star 🌟
PHP example for the https://keyauth.cc authentication system.

## **Video Tutorial:**

<a href="http://www.youtube.com/watch?feature=player_embedded&v=hU6yXGR5R1Y
" target="_blank"><img src="https://i.imgur.com/IFHFaiI.png" 
alt="Click here to see Installation Video!" width="500" height="250" border="10" /></a>

## **Bugs**

If the default example not added to your software isn't functioning how it should, please report a bug here https://keyauth.cc/app/?page=forms

However, we do **NOT** provide support for adding KeyAuth to your project. If you can't figure this out you should use Google or YouTube to learn more about the programming language you want to sell a program in.

## Copyright License

KeyAuth is licensed under **Elastic License 2.0**

* You may not provide the software to third parties as a hosted or managed
service, where the service provides users with access to any substantial set of
the features or functionality of the software.

* You may not move, change, disable, or circumvent the license key functionality
in the software, and you may not remove or obscure any functionality in the
software that is protected by the license key.

* You may not alter, remove, or obscure any licensing, copyright, or other notices
of the licensor in the software. Any use of the licensor’s trademarks is subject
to applicable law.

Thank you for your compliance, we work hard on the development of KeyAuth and do not appreciate our copyright being infringed.

## Anti-DDoS Security 

Please add a Cloudflare firewall rule to show challenge to users, then set challenge passage to 1 year so they don't have to frequently complete challenge
![image](https://user-images.githubusercontent.com/83034852/168191187-236e8be7-1b1c-4398-9360-462baa800fac.png)
![image](https://user-images.githubusercontent.com/83034852/168191204-d553f134-943b-466e-a98f-255fbab204c6.png)


## **What is KeyAuth?**

KeyAuth is an Open source authentication system with cloud hosting plans as well. Client SDKs available for [C#](https://github.com/KeyAuth/KeyAuth-CSHARP-Example), [C++](https://github.com/KeyAuth/KeyAuth-CPP-Example), [Python](https://github.com/KeyAuth/KeyAuth-Python-Example), [Java](https://github.com/KeyAuth-Archive/KeyAuth-JAVA-api), [JavaScript](https://github.com/mazkdevf/KeyAuth-JS-Example), [VB.NET](https://github.com/KeyAuth/KeyAuth-VB-Example), [PHP](https://github.com/KeyAuth/KeyAuth-PHP-Example), [Rust](https://github.com/KeyAuth/KeyAuth-Rust-Example), [Go](https://github.com/mazkdevf/KeyAuth-Go-Example), [Lua](https://github.com/mazkdevf/KeyAuth-Lua-Examples), [Ruby](https://github.com/mazkdevf/KeyAuth-Ruby-Example), and [Perl](https://github.com/mazkdevf/KeyAuth-Perl-Example). KeyAuth has several unique features such as memory streaming, webhook function where you can send requests to API without leaking the API, discord webhook notifications, ban the user securely through the application at your discretion. Feel free to join https://t.me/keyauth if you have questions or suggestions.

## **`KeyAuthApp` instance definition**

Visit https://keyauth.cc/app/ and select your application, then click on the **PHP** tab

It'll provide you with the code which you should replace with in the `credentials.php` file.

```php
$KeyAuthApp = new KeyAuth\api("appNameHere", "keyAuthOwnerIDHere");
```

## **Initialize application**

You must call this function prior to using any other KeyAuth function. Otherwise the other KeyAuth function won't work.

```php
$KeyAuthApp->init();
```

## **Display application information**

```php
$numKeys = $_SESSION["numUsers"];
$numUsers = $_SESSION["numKeys"];
$numOnlineUsers = $_SESSION["numOnlineUsers"];
$customerPanelLink = $_SESSION["customerPanelLink"];
```

## **Login with username/password**

```php
if ($KeyAuthApp->login("userNameHere", "passWordHere")) {
  // send user to dashboard or wherever you prefer
}
```

## **Register with username/password/key**

```php
if ($KeyAuthApp->register("userNameHere", "passWordHere", "licenseKeyHere")) {
  // send user to dashboard or wherever you prefer
}
```

## **Upgrade user username/key**

Used so the user can add extra time to their account by claiming new key.

> **Warning**
> No password is needed to upgrade account. So, unlike login, register, and license functions - you should **not** log user in after successful upgrade.

```php
if ($KeyAuthApp->upgrade("userNameHere", "licenseKeyHere")) {
			// don't login, upgrade function is not for authentication, it's simply for redeeming keys
      // make the user login with their username and password now.
}
```

## **Login with just license key**

Users can use this function if their license key has never been used before, and if it has been used before. So if you plan to just allow users to use keys, you can remove the login and register functions from your code.

```php
if ($KeyAuthApp->license("licenseKeyHere")) {
      // send user to dashboard or wherever you prefer
}
```

## **User Data**

Show information for current logged-in user.

```php
$username = $_SESSION["user_data"]["username"];
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;
for ($i = 0; $i < count($subscriptions); $i++) {
    echo "#" . $i + 1 . " Subscription: " . $subscriptions[$i]->subscription . " - Subscription Expires: " . "<script>document.write(convertTimestamp(" . $subscriptions[$i]->expiry . "));</script>";
}
```

## **Check subscription name of user**

If you want to wall off parts of your app to only certain users, you can have multiple subscriptions with different names. Then, when you create licenses that correspond to the level of that subscription, users who use those licenses will get a subscription with the name of the subscription that corresponds to the level of the license key they used.

```php
if(findSubscription("default", $_SESSION["user_data"]["subscriptions"])) {
    // user has subscription with name "default"
}
else {
    // user does not have subscription with name "default"
}
```

## **Application variables**

A string that is kept on the server-side of KeyAuth. On the dashboard you can choose for each variable to be authenticated (only logged in users can access), or not authenticated (any user can access before login). These are global and static for all users, unlike User Variables which will be dicussed below this section.

```php
//* Get Public Variable
$var = $KeyAuthApp->var("varName");
echo "Variable Data: " . $var;
```

## **User Variables**

User variables are strings kept on the server-side of KeyAuth. They are specific to users. They can be set on Dashboard in the Users tab, via SellerAPI, or via your loader using the code below. `discord` is the user variable name you fetch the user variable by. `test#0001` is the variable data you get when fetching the user variable.

```php
//* Set Up User Variable
$KeyAuthApp->setvar("varName", "varData");
```

And here's how you fetch the user variable:

```php
//* Get User Variable
$var = $KeyAuthApp->getvar("varName");
echo "Variable Data: " . $var;
```

## **Application Logs**

Can be used to log data. Good for anti-debug alerts and maybe error debugging. If you set Discord webhook in the app settings of the Dashboard, it will send log messages to your Discord webhook rather than store them on site. It's recommended that you set Discord webhook, as logs on site are deleted 1 month after being sent.

You can use the log function before login & after login.

```php
//* Log Something to the KeyAuth webhook that you have set up on app settings
$KeyAuthApp->log("message");
```


## Server-sided webhooks

Tutorial video https://www.youtube.com/watch?v=ENRaNPPYJbc

> **Note**
> Read documentation for KeyAuth webhooks here https://keyauth.readme.io/reference/webhooks-1

Send HTTP requests to URLs securely without leaking the URL in your application. You should definitely use if you want to send requests to SellerAPI from your application, otherwise if you don't use you'll be leaking your seller key to everyone. And then someone can mess up your application.

1st example is how to send request with no POST data. just a GET request to the URL. `7kR0UedlVI` is the webhook ID, `https://keyauth.win/api/seller/?sellerkey=sellerkeyhere&type=black` is what you should put as the webhook endpoint on the dashboard. This is the part you don't want users to see. And then you have `&ip=1.1.1.1&hwid=abc` in your program code which will be added to the webhook endpoint on the keyauth server and then the request will be sent.

2nd example included post data, JSON. It's an example request to Discord webhook `7kR0UedlVI` is the webhook ID, `https://discord.com/api/webhooks/...` is the webhook endpoint.

```php
$result = $KeyAuthApp->webhook("7kR0UedlVI", "&ip=1.1.1.1&hwid=abc");
echo "<br> Result from Webhook: " . $result;

$result = $KeyAuthApp->webhook("7kR0UedlVI", "", "{\"content\": \"webhook message here\",\"embeds\": null}", "application/json"); // if Discord webhook message successful, response will be empty
echo "<br> Result from Webhook: " . $result;
```

## Ban the user

Ban the user and blacklist their HWID and IP Address.

Function only works after login.

The reason paramater will be the ban reason displayed to the user if they try to login, and visible on the KeyAuth dashboard.

```php
$KeyAuthApp->ban('Broke the rules');
```

Looking for a Discord bot made by the KeyAuth & RestoreCord founder that you can use to backup your Discord members, server settings, and messages? Go to https://vaultcord.com
