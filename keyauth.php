<?php

namespace KeyAuth;

if(!isset($_SESSION))
    session_start();

class api {
    public $name, $ownerid;

    function __construct($name, $ownerid) {
        $this->name = $name;
        $this->ownerid = $ownerid;
    }

    function login($key){
        $data = array(
            "type" => "login",
            "key" => $key,
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

    function log($message){
        $logkey = $_SESSION["user_data"]["key"] ?? "NONE";

        $data = array(
            "type" => "log",
            "key" => $logkey,
            "name" => $this->name,
            "ownerid" => $this->ownerid
        );

        $this->req($data);
    }

    private function req($data){
        $curl = curl_init("https://keyauth.com/api/v4/");
        curl_setopt($curl, CURLOPT_USERAGENT, "KeyAuth");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_PINNEDPUBLICKEY, "sha256//UjJQOuTpgenjm6zOasOClsM8Ua6m6IJ09jzwC6YYDh0=");

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
