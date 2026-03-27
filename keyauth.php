<?php

namespace KeyAuth;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class api
{
    public $name;
    public $ownerid;

    public function __construct($name, $ownerid)
    {
        $this->name = $name;
        $this->ownerid = $ownerid;
    }

    public function init()
    {
        if (empty($this->name) || strlen($this->ownerid) != 10) {
            die("Go to <a href=\"https://keyauth.cc/app/\" target=\"blank\">https://keyauth.cc/app/</a> and click the <b>PHP</b> button in the App credentials code. Copy that & paste in <code style=\"background-color: #eee;border-radius: 3px;font-family: courier, monospace;padding: 0 3px;\">credentials.php</code>");
        }

        $data = array(
            "type" => "init",
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);

        if ($response == "KeyAuth_Invalid") {
            die("Go to <a href=\"https://keyauth.cc/app/\" target=\"blank\">https://keyauth.cc/app/</a> and click the <b>PHP</b> button in the App credentials code. Copy that & paste in <code style=\"background-color: #eee;border-radius: 3px;font-family: courier, monospace;padding: 0 3px;\">credentials.php</code>");
        }

        $json = json_decode($response);

        if (!$json->success) {
            die($json->message);
        } else {
            $_SESSION['sessionid'] = $json->sessionid;
        }
    }

    // Authentication Functions
    public function login($username, $password, $code = null)
    {
        $data = array(
            "type" => "login",
            "username" => $username,
            "pass" => $password,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        if (!is_null($code)) $data["code"] = $code;

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            unset($_SESSION['sessionid']);
            $this->error($json->message);
        } else {
            $_SESSION["user_data"] = (array)$json->info;
        }

        return $json->success;
    }

    public function loginEmail($email, $password, $code = null)
    {
        $data = array(
            "type" => "loginEmail",
            "email" => $email,
            "pass" => $password,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        if (!is_null($code)) $data["code"] = $code;

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            unset($_SESSION['sessionid']);
            $this->error($json->message);
        } else {
            $_SESSION["user_data"] = (array)$json->info;
        }

        return $json->success;
    }

    public function register($username, $password, $key)
    {
        $data = array(
            "type" => "register",
            "username" => $username,
            "pass" => $password,
            "key" => $key,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            unset($_SESSION['sessionid']);
            $this->error($json->message);
        } else {
            $_SESSION["user_data"] = (array)$json->info;
        }

        return $json->success;
    }

    public function license($key, $code = null)
    {
        $data = array(
            "type" => "license",
            "key" => $key,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        if (!is_null($code)) $data["code"] = $code;

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            unset($_SESSION['sessionid']);
            $this->error($json->message);
        } else {
            $_SESSION["user_data"] = (array)$json->info;
        }

        return $json->success;
    }

    public function upgrade($username, $key)
    {
        $data = array(
            "type" => "upgrade",
            "username" => $username,
            "key" => $key,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            unset($_SESSION['sessionid']);
            $this->error($json->message);
        }

        return $json->success;
    }

    public function forgot($username, $email)
    {
        $data = array(
            "type" => "forgot", 
            "username" => $username,
            "email" => $email, 
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            $this->error($json->message);
        }

        return $json->success;
    }

    // Account Actions
    public function logout()
    {
        $data = array(
            "type" => "logout",
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $this->req($data);
    }

    public function enable2fa($code = null)
    {
        $data = array(
            "type" => "2faenable",
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid,
            "code" => $code
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if (isset($json->sessionid)) $_SESSION['sessionid'] = $json->sessionid;

        if ($json->success) {
            if (empty($code)) {
                if (isset($json->{'2fa'}->secret_code)) {
                    $secretCode = trim($json->{'2fa'}->secret_code);
                    echo "<script>
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText('" . addslashes($secretCode) . "')
                                .then(() => alert('Your 2FA Secret Code copied to clipboard: " . addslashes($secretCode) . "'))
                                .catch(() => alert('Your 2FA Secret Code: " . addslashes($secretCode) . "'));
                        } else {
                            alert('Your 2FA Secret Code: " . addslashes($secretCode) . "');
                        }
                    </script>";
                }
            } else {
                echo "<script>alert('2FA successfully enabled!');</script>";
            }
        } else {
            $this->error($json->message);
        }
    }

    public function disable2fa($code)
    {
        $data = array(
            "type" => "2fadisable",
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid,
            "code" => $code
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if ($json->success) {
            echo "<script>alert('2FA successfully disabled!');</script>";
        } else {
            $this->error($json->message);
        }
    }

    public function ban($reason)
    {
        $data = array(
            "type" => "ban",
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid,
            "reason" => $reason
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) $this->error($json->message);

        return $json->success;
    }

    // Variable Functions
    public function var($varid)
    {
        $data = array(
            "type" => "var",
            "varid" => $varid,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        if (!$json->success) {
            unset($_SESSION['sessionid']);
            $this->error($json->message);
        } else {
            return $json->message;
        }
    }

    public function setvar($varname, $data)
    {
        $data = array(
            "type" => "setvar",
            "var" => $varname,
            "data" => $data,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $this->req($data);
    }

    public function getvar($varid)
    {
        $data = array(
            "type" => "getvar",
            "var" => $varid,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        return $json->success ? $json->response : null;
    }

    // Misc Functions
    public function log($message)
    {
        $data = array(
            "type" => "log",
            "pcuser" => gethostname(),
            "message" => $message,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $this->req($data);
    }

    public function webhook($webid, $param, $body = "", $conttype = "")
    {
        $data = array(
            "type" => "webhook",
            "webid" => $webid,
            "params" => $param,
            "body" => $body,
            "conttype" => $conttype,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        return $json->success ? $json->response : null;
    }

    public function fetchOnline()
    {
        $data = array(
            "type" => "fetchOnline",
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        return $json->success ? $json->response : null;
    }

    public function checkBlack()
    {
        $data = array(
            "type" => "checkBlack",
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        return $json->success ? $json->response : null;
    }

    public function chatGet($channel)
    {
        $data = array(
            "type" => "chatget",
            "channel" => $channel,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        return $json->success ? $json->messages : null;
    }

    public function chatSend($message, $channel)
    {
        $data = array(
            "type" => "chatsend",
            "message" => $message,
            "channel" => $channel,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);
        $json = json_decode($response);

        return $json->success ? $json->message : null;
    }

    // Core Helpers
    private function req($data)
    {
        $curl = curl_init("https://keyauth.win/api/1.3/");
        curl_setopt($curl, CURLOPT_USERAGENT, "KeyAuth");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_code == 429) {
            die("You're connecting too faster to loader, slow down");
        }

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header_str = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $headers = array();
        foreach (explode("\r\n", $header_str) as $line) {
            $parts = explode(': ', $line, 2);
            if (isset($parts[1])) {
                $headers[strtolower(trim($parts[0]))] = trim($parts[1]);
            }
        }

        $this->sigCheck($body, $headers, $data['type']);

        $json = json_decode($body);
        if ($json && isset($json->ownerid) && $json->ownerid != $this->ownerid) {
            die("Application mismatch. Terminating process.");
        }

        return $body;
    }

    private function sigCheck(string $resp, array $headers, string $type): void
    {
        $skipTypes = ['log', 'file', '2faenable', '2fadisable'];

        if (in_array($type, $skipTypes, true)) {
            return;
        }

        $signatureHeader = $headers['x-signature-ed25519'] ?? null;
        $timestampHeader = $headers['x-signature-timestamp'] ?? null;

        if (!is_string($signatureHeader) || !is_string($timestampHeader)) {
            $this->failSignatureCheck();
        }

        if (!extension_loaded('sodium')) {
            die("The 'sodium' extension is required.");
        }

        if (!ctype_digit($timestampHeader)) {
            $this->failSignatureCheck();
        }

        $timestamp = (int) $timestampHeader;

        // More realistic replay window
        if (abs(time() - $timestamp) > 300) {
            throw new \RuntimeException("Clock skew too large or request expired.");
        }

        $publicKeyHex = '5586b4bc69c7a4b487e4563a4cd96afd39140f919bd31cea7d1c6a1e8439422b';
        $signedMessage = $timestampHeader . $resp;

        try {
            $signature = sodium_hex2bin($signatureHeader);
            $publicKey = sodium_hex2bin($publicKeyHex);

            if (!sodium_crypto_sign_verify_detached($signature, $signedMessage, $publicKey)) {
                $this->failSignatureCheck();
            }
        } catch (\Throwable $e) {
            $this->failSignatureCheck();
        }
    }

    private function failSignatureCheck(): void
    {
        http_response_code(401);
        exit('Signature verification failed.');
    }

    public function error($msg)
    {
        echo "<script>
            const notyf = new Notyf();
            notyf.error({
                message: '" . addslashes($msg) . "',
                duration: 3500,
                dismissible: true
            });
        </script>";
    }

    public function success($msg)
    {
        echo "<script>
            const notyf = new Notyf();
            notyf.success({
                message: '" . addslashes($msg) . "',
                duration: 3500,
                dismissible: true
            });
        </script>";
    }
}
