<?php 

Class MailChecker extends FieldChecker
{
    protected $errors;

    public function __construct($post)
    {
        parent::__construct($post);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function check()
    {
        if(!preg_match("#[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+#", $this->post['email'])) { 
            $this->errors =  "veuillez rentrer un mail valide, svp";
            return false;
        }
        else {
            return true;
        }
    }
}