<?php

class User {
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
	
    public function registerConfirm($serial){
        $this->db->query("SELECT * FROM website.users WHERE serial = :serial");
        
        $this->db->bind(':serial', $serial);
        
        $this->db->execute();
        
        if($this->db->rowCount() == 1) {
            $this->db->query("UPDATE website.users SET type = 1, serial = NULL WHERE serial = :serial RETURNING user_id, username, email");
            
            $this->db->bind(':serial', $serial);
            
            $result = $this->db->single();
            
            $username = $result->username;
            $email = $result->email;
            
            $this->db->query("DELETE FROM website.users WHERE (username = '$username' OR email = '$email') AND (type != 1)");
            
            $this->db->execute();
                
            return true;
        } else {
            $this->db->query("DELETE FROM website.users WHERE serial = :serial");
            $this->db->bind(':serial', serial);
            
            return false;
        } 
    }
	
    public function registerCreate($data){
		//Insert Query
		$this->db->query('INSERT INTO website.users (username, password, email, type, about, avatar, name, serial) 
						  VALUES (:username, :password, :email, 0, :about, :avatar, :name, :serial)');
        
        $date = new DateTime();
        $serial = md5($data['password'].$date->getTimestamp());
        
        //Bind Values
		$this->db->bind(':username', $data['username']);
		$this->db->bind(':password', $data['password']);
		$this->db->bind(':email', $data['email']);
		$this->db->bind(':about', '');
		$this->db->bind(':avatar', 'images/default.jpg');
		$this->db->bind(':name', $data['name']);
        $this->db->bind(':serial', $serial);
		
		if($this->db->execute()){
            $url = BASE_DIR . "register.php?serial=" . $serial;
            $body = "Hello " . $data['username'] . ",\n\nGenomePro has created an account for you. Please confirm it by clicking on the URL below:\n\n" . $url;
            
            sendEmail(EMAIL_NAME, EMAIL_WHEN_SENDING, $data['username'], $data['email'], 'Welcome to GenomePro!', $body); 
            
			return true;
		} else {
			return false;
		}
		//echo $this->db->lastInsertId();
	}
	 
	public function login($username, $password) {
		$this->db->query("SELECT * FROM website.users
						  WHERE username = :username
						  AND password = :password");
		
		$this->db->bind(':username', $username);
		$this->db->bind(':password', $password);
		
		$row = $this->db->single();
		
        if($this->db->rowCount() == 0) {
            return 2; // credentials given are incorrect
        }
        
		if($row->type == 0) {
            return 1; // user needs to confirm email
        } else {
            $this->setUserData($row);
            return 0; // user successfully signed in!
        }
	}
	
    public function checkEmailExists($email) {
        $this->db->query("SELECT * FROM website.users
                          WHERE email = :email 
                          AND type != 0");
        
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
    }
    
    public function checkUsernameExists($username) {
        $this->db->query("SELECT * FROM website.users
                          WHERE username = :username 
                          AND type != 0");
        
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
    }
    
	private function setUserData($row) {
		$_SESSION['is_logged_in'] = true;
		$_SESSION['user_id'] = $row->user_id;
		$_SESSION['username'] = trim($row->username);
		$_SESSION['name'] = $row->name;
	}
	
	public function logout() {
		unset($_SESSION['is_logged_in']);
		unset($_SESSION['user_id']);
		unset($_SESSION['username']);
		unset($_SESSION['name']);
		
		return true;
	}
}