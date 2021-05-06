<?php 

Class MessageChecker extends FieldChecker
{
    protected $min;
    protected $errors;

    public function __construct($post)
    {
        parent::__construct($post);
        $this->min = 3; 
        $this->max = 100; 
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function check()
    {
        if(strlen($this->post['message']) < $this->min) { 
            $arrayErrors[] = "Votre Message doit contenir plus de ". $this->min ." caractères";
        }
        if(strlen($this->post['message']) > $this->max) { 
            $arrayErrors[] = "Votre Message doit contenir moins de ". $this->max ." caractères";
        }
        
        if(!empty($arrayErrors))
        {
            $this->errors = $arrayErrors; 
            return false;
        }
        else {
            return true;
        }
    }
}