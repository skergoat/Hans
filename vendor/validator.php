<?php 

require "vendor/mailer.php";

class Validator {

    protected $mail;
    protected $post;
    protected $empty;
    protected $emptyKeys;
    protected $success;

	public function __construct($post) {
        $this->mail = new Mail();
        $this->post = $post;
        print_r("Validator");
	}

    // send mail
    public function send()
    {
        return $this->mail->sendMail($this->post) ? $this->success = 'success' : $this->success = 'error';
    }

    // clean HTML
    public function specialChars()
    {  
        $replacements = array(
                            "nom" => htmlspecialchars($this->post['nom']), 
                            "email" => htmlspecialchars($this->post['email']),
                            "password" => htmlspecialchars($this->post['password']),
                            "message" => htmlspecialchars($this->post['message'])
                        );

        $this->post = array_replace($this->post, $replacements);
        // var_dump($this->post);
    }

    public function errorMessage()
    {

    }

    // create array with empty fields keys 
    public function handleEmptyMessage()
    {
        $this->emptyKeys = array_keys($this->empty);
    }

    // check if POST empty
    public function isNotEmpty() {
        foreach($this->post as $name => $value) 
        {
            if(empty($value)) {
                $this->empty[$name] = $value;
            }
        }
        return empty($this->empty) ? true : $this->handleEmptyMessage(); 
    }

    // is valid
    public function isValid()
    {
       // clean HTML 
       $this->specialChars();
       // check if empty 
       if($this->isNotEmpty()) {
           // if there is no error in fields 
           // if captcha is ok

           define("RECAPTCHA_V3_SECRET_KEY", '');
  
            $name = filter_input(INPUT_POST, $this->post['nom'], FILTER_VALIDATE_EMAIL);
            $mail = filter_input(INPUT_POST, $this->post['email'], FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, $this->post['password'], FILTER_SANITIZE_STRING);
            $message = filter_input(INPUT_POST, $this->post['message'], FILTER_SANITIZE_STRING);
           
            $token = $_POST['token'];
            $action = $_POST['action'];
           
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
            if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
                // then 
                return true;
            } else {
                $this->success = 'recaptcha';
            }

        // then 
        //    return true;
       }
    }

    // 
    public function getEmptyMessage()
    {
        return $this->emptyKeys;
    }

    // liste of erros message to display
    public function getErrorMessage($error)
    {
        switch($error)
        {
            case "empty" :
            return "Remplissez le champ, svp";
            break;
        }
    }

    // get and return empty error message 
    public function getEmptyErrorMessage()
    {
        return $this->getErrorMessage("empty");
    }

    public function getSuccessMessage() {
        return $this->success;
    }
}