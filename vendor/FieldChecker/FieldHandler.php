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

    // check fields 
    public function isValid() 
    {
        if(!$this->nameChecker->check())
        {
            $arrayErrors[] = $this->nameChecker->getErrors();
        }
        if(!$this->mailChecker->check())
        {
            $arrayErrors[] = $this->mailChecker->getErrors();
        }
        if(!$this->messageChecker->check())
        {
            foreach($this->messageChecker->getErrors() as $errors)
            {
                $arrayErrors[] = $errors;
            }
        }

        if(!empty($arrayErrors))
        {
            $this->setErrorMessage($arrayErrors);
            return false;
        }
        else {
            return true;
        }
    }

    // set error message 
    public function setErrorMessage(Array $array)
    {
        $this->errorMessage = $array;
    }

    // get error message 
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}