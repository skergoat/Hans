<?php

class Recaptcha 
{
    protected $post;

    public function __construct($post) {
        $this->post = $post;
	}

    function checkRecaptcha()
    {
        define("RECAPTCHA_V3_SECRET_KEY", '');

        $name = filter_input(INPUT_POST, $this->post['nom'], FILTER_VALIDATE_EMAIL);
        $mail = filter_input(INPUT_POST, $this->post['email'], FILTER_SANITIZE_STRING);
        // $password = filter_input(INPUT_POST, $this->post['password'], FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, $this->post['message'], FILTER_SANITIZE_STRING);
        
        $token = $this->post['token'];
        $action = $this->post['action'];
        
        // call curl to POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $arrResponse = json_decode($response, true);
        
        // verify the response
        if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5)  {
            return true;
        } else {
            return false;
        } 
    }
}

