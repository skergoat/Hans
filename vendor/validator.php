<?php 

require "vendor/mailer.php";
require "vendor/formChecker.php";

class Validator {

    protected $mail;
    protected $checker;
    protected $post;
    protected $empty;
    protected $emptyKeys;
    protected $success;
    protected $error;

	public function __construct($post) {
        $this->post = $post;
        // clean HTML 
        $this->specialChars();
        $this->mail = new Mail();
        $this->checker = new formChecker($this->post);
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

    public function setErrorMessage($errorMessage)
    {
        $this->error[] = $errorMessage;
        print_r($this->error);
    }

    // public function nameChecker()
    // {
    //     return $this->checker->Name() ? true : $this->handleErrorMessage($this->checker->Name()); 
    // }

    public function mailChecker()
    {
        return $this->checker->Mail() ? true : $this->setErrorMessage("veuillez entrer un mail valide, svp");
    }

    // public function messageChecker()
    // {
    //     return $this->checker->Message() ? true : $this->handleErrorMessage($this->checker->Message()); 
    // }

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
    //    // clean HTML 
    //    $this->specialChars();
       // check if empty 
       if($this->isNotEmpty()) {
        
            // if($this->nameChecker())
            // {
                if($this->mailChecker())
                {
                    // if($this->messageChecker())
                    // {
                        return true;
                    // }
                }  
            // }
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
        return $this->getErrorMessage("Remplissez le champ, svp");
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