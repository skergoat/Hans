<?php 

class Validator {

    protected $post;
    protected $empty;
    protected $emptyKeys;

	public function __construct($post) {
        $this->post = $post;
        print_r("Validator");
	}

    public function errorMessage()
    {

    }

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
       return $this->isNotEmpty();
    }

    // 
    public function getEmptyMessage()
    {
        return $this->emptyKeys;
    }

    // liste of erros message to display
    public function getErrorMessage($error)
    {
        switch($error)
        {
            case "empty" :
            return "Remplissez le champ, svp";
            break;
        }
    }

    // get and return empty error message 
    public function getEmptyErrorMessage()
    {
        return $this->getErrorMessage("empty");
    }
}