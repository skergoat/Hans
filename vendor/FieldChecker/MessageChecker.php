<?php 

Class MessageChecker extends FieldChecker
{
    public function __construct($post)
    {
        parent::__construct($post);
    }

    public function check()
    {
        // print_r($this->post['message']);  
    }
}