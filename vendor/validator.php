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
        

        // then 
           return true;
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

    // public function setSuccessMessage($message)
    // {
    //     $this->success = $message;
    // }
}