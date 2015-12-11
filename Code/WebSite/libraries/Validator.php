<?php

class Validator {
    private $user;
	
	public function __construct() {
		$this->user = new User;
	}
    
	public function isRequired($field_array) {
		foreach($field_array as $field) {
			if($_POST[''.$field.''] == '') {
				return false;
			}
		}
		return true;
	}

    public function isValidUsername($username) { 
        if(strlen($username) < 3) return false; 
        
        return ctype_alnum($username); 
    }
    
	public function isValidEmail($email) { return filter_var($email, FILTER_VALIDATE_EMAIL); }
    
    public function passwordsMatch($pw1, $pw2) { return ($pw1 == $pw2); }
    
    public function isValidPassword($password) {
        $hasUppercase = false;
        $hasLowercase = false;
        $hasNumber = false;
        
        $length = strlen($password);
        
        if($length < 7 || $length > 15) return false;

        for($i = 0 ; $i < $length + 1 ; $i++) {
            $char = substr($password, $i, 1);
            
            if(ctype_upper($char)) $hasUppercase = true;
            if(ctype_lower($char)) $hasLowercase = true;
            if(is_numeric($char)) $hasNumber = true;
        }
        
        if($hasUppercase && $hasLowercase && $hasNumber) return true;
        
        return false;
    }
}