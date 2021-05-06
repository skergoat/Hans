<?php 

Class MailChecker extends FieldChecker
{
    public function __construct($post)
    {
        parent::__construct($post);
    }

    public function check()
    {
        return false;
        // return preg_match("#[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+#", $this->post['email']);   
    }
}