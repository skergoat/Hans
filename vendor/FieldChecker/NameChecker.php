<?php 

Class NameChecker extends FieldChecker
{
    public function __construct($post)
    {
        parent::__construct($post);
    }

    public function check()
    {
        return false;
        // print_r($this->post['nom']);    
    }
}