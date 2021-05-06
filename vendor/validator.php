<?php 

require "vendor/mailer.php";
require "vendor/FieldChecker/FieldHandler.php";
require "vendor/FieldChecker/FieldChecker.php";
require "vendor/FieldChecker/MailChecker.php";
require "vendor/FieldChecker/NameChecker.php";
require "vendor/FieldChecker/MessageChecker.php";

class Validator {

    protected $mail;
    protected $handler;
    protected $post;
    protected $empty;
    protected $emptyKeys;
    protected $success;
    protected $error;

	public function __construct($post) {
        $this->post = $post;
        // clean HTML 
        $this->specialChars();
        // init Class 
        $this->handler = new FieldHandler($this->post); // rules to validate fields 
        $this->mail = new Mail(); // send mail 
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
                            // "password" => htmlspecialchars($this->post['password']),
                            "message" => htmlspecialchars($this->post['message'])
                        );

        $this->post = array_replace($this->post, $replacements);
    }

    // set fields error message list 
    public function setErrorMessage($errorMessage)
    {
        $this->error = $errorMessage; 
    }

    // get fields error message list
    public function getErrorMessage()
    {
        return $this->error;
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
       // check if empty 
       if($this->isNotEmpty()) {
            // check fields value 
            if($this->handler->isValid()) {
                return true;
            } 
            else {
                $this->setErrorMessage($this->handler->getErrorMessage());
            } 
        }
    }

    // get keys of empty fields and send error message  
    public function getEmptyMessage()
    {
        return $this->emptyKeys;
    }

    // get and return empty error message 
    public function getEmptyErrorMessage()
    {
        return "Remplissez le champ, svp";
    }

    // display success or error message 
    public function getSuccessMessage() {
        return $this->success;
    }

    // edit and display success or error message 
    public function setSuccessMessage($message)
    {
        $this->success = $message;
    }
}