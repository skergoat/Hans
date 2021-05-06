<?php 

Class NameChecker extends FieldChecker
{
    protected $min;
    protected $errors;

    public function __construct($post)
    {
        parent::__construct($post);
        $this->min = 3; 
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function check()
    {
        if(strlen($this->post['nom']) < $this->min) { 
            $this->errors = "Votre Nom doit contenir plus de 3 caractères";
            return false;
        }
        else {
            return true;
        }
    }
}