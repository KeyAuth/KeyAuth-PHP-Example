<?php

namespace KeyAuth;

session_start();

class api {
    public $name, $ownerid;

    function __construct($name, $ownerid) {
        $this->name = $name;
        $this->ownerid = $ownerid;
    }
	
	function init(){
        $data = array(
            "type" => "init",
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);

        $json = json_decode($response);

        if(!$json->success)
            $this->error($json->message);
        else if($json->success)
            $_SESSION['sessionid'] = $json->sessionid;
    }

    function login($username,$password){
        $data = array(
            "type" => "login",
            "username" => $username,
            "pass" => $password,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);

        $json = json_decode($response);

        if(!$json->success)
            $this->error($json->message);
        else if($json->success)
            $_SESSION["user_data"] = (array)$json->info;

        return $json->success;
    }
	
	function register($username,$password,$key){
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

        if(!$json->success)
            $this->error($json->message);
        else if($json->success)
            $_SESSION["user_data"] = (array)$json->info;

        return $json->success;
    }
	
	function license($key){
        $data = array(
            "type" => "license",
            "key" => $key,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);

        $json = json_decode($response);

        if(!$json->success)
            $this->error($json->message);
        else if($json->success)
            $_SESSION["user_data"] = (array)$json->info;

        return $json->success;
    }
	
	function upgrade($username,$key){
        $data = array(
            "type" => "license",
            "username" => $username,
            "key" => $key,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);

        $json = json_decode($response);

        if(!$json->success)
            $this->error($json->message);
        else if($json->success)
            $_SESSION["user_data"] = (array)$json->info;

        return $json->success;
    }
	
	function var($varid){
        $data = array(
            "type" => "var",
            "varid" => $varid,
            "sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $response = $this->req($data);

        $json = json_decode($response);

        if(!$json->success)
            $this->error($json->message);
        else if($json->success)
            return $json->message;
    }

    function log($message){
        $logkey = $_SESSION["user_data"]["key"] ?? "NONE";

        $data = array(
            "type" => "log",
            "pcuser" => "Server",
            "message" => $message,
			"sessionid" => $_SESSION['sessionid'],
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $this->req($data);
    }

    private function req($data){
        $curl = curl_init("https://keyauth.com/api/1.1/");
        curl_setopt($curl, CURLOPT_USERAGENT, "KeyAuth");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, "sha256//zaXl1uxtEA6FAR8KKoew4FYX+X3Khlfd/zjVD+SdMpc=");
		curl_setopt($curl, CURLOPT_DNS_SERVERS, "1.1.1.1,1.0.0.1");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function error($msg){
                        echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .error({
                    message: \''.$msg.'\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';  
    }
}
