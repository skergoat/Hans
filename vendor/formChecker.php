<?php

class formChecker 
{
    protected $errorMessages;
    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function Name()
    {

    }

    public function Mail()
    {
        return preg_match("#[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+#", $this->post['email']);
    }

    public function Message()
    {

    }
}