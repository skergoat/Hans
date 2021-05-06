<?php

class FieldHandler 
{
    protected $errorMessages;
    protected $mailChecker;
    protected $nameChecker;
    protected $messageChecker;

    public function __construct($post)
    {
        $this->mailChecker = new MailChecker($post); 
        $this->nameChecker = new NameChecker($post); 
        $this->messageChecker = new MessageChecker($post);
    }

    public function isValid() 
    {
        if($this->mailChecker->check())
        {
            print_r("is valid");
        }
        else 
        {
            $arrayErrors[] = "veuillez rentrer un mail valid, svp";
        }

        if($this->nameChecker->check())
        {
            print_r("is valid");
        }
        else 
        {
            $arrayErrors[] = "veuillez rentrer un nom valid, svp";
        }

        if($this->messageChecker->check())
        {
            print_r("is valid");
        }
        else 
        {
            $arrayErrors[] = "veuillez rentrer un message valid, svp";
        }

        $this->setErrorMessage($arrayErrors);
        $this->getErrorMessage();

        return false;
    }

    public function setErrorMessage(Array $array)
    {
        $this->errorMessage = $array;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}