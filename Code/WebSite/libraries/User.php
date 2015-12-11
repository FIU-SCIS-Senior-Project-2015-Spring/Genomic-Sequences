<?php

class User {
    
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
    
    public function uploadAvatarToDatabase($avatar) {
        $user_id = $_SESSION['user_id'];
        
        $this->db->query("SELECT avatar FROM website.users WHERE user_id = $user_id");
        $result = $this->db->single();
        
        $previousAvatar = trim($result->avatar);
        if($previousAvatar != DEFAULT_AVATAR) deleteAvatarFromServer();

        $this->db->query("UPDATE website.users
                          SET avatar = :avatar
                          WHERE user_id = $user_id;");   

        $this->db->bind(':avatar', $avatar);
        
        $result = $this->db->execute();

        if(!$result) return false;
        
        return true;   
    }
    
    public function getTypeAndIDBySerial($serial) {
        $this->db->query("SELECT user_id, type
                          FROM website.users
                          WHERE serial = :serial");
        
        $this->db->bind(':serial', $serial);
        
        $result = $this->db->single();
        
        return $result;   
    }
    
    public function getProfile() {
        $user_id = $_SESSION['user_id'];
        
        $this->db->query("SELECT * FROM website.users WHERE user_id = $user_id");
        
        $result = $this->db->single();  
        
        if(!$result) return false;
        
        return $result;
    }
    
    public function beginModifyEmail($user_id, $username, $email) {   
        $date = new DateTime();
        $serial = md5($username . $date->getTimestamp());
            

        if(!$this->changeEmail($user_id, $email)) return false;
        if(!$this->changeSerial($user_id, $serial)) return false;
        
        $this->db->query("DELETE FROM website.users WHERE email = '$email' AND type = 0");
        
        $this->db->execute();
        
        $url = BASE_DIR . "register.php?serial=" . $serial;
        $body = "Hello " . ucfirst($username) . ",\n\nGenomePro has updated your email for you. Please confirm it by clicking on the URL below:\n\n" . $url;

        sendEmail(EMAIL_NAME, EMAIL_WHEN_SENDING, ucfirst($username), $email, 'From the GenomePro Team', $body); 
        
        return true;
    }
    
    public function changePassword($user_id, $password, $username) { 
        $ftp = $username . ':' . crypt_apr1_md5($password);
        
        $this->db->query("UPDATE website.users
                          SET password = :password, ftp = '$ftp'
                          WHERE user_id = :user_id");
        
        $this->db->bind(':password', md5($password));
        $this->db->bind(':user_id', $user_id);
        
        $result = $this->db->execute();
        
        if(!$result) return false;

        createFTP($username, $ftp);
        
        return true;
    }
    
    public function changeFirstName($user_id, $firstname) {
          $this->db->query("UPDATE website.users
                            SET firstname = :firstname
                            WHERE user_id = :user_id");
        
        $this->db->bind(':firstname', $firstname);
        $this->db->bind(':user_id', $user_id);
        
        $result = $this->db->execute();
        
        if(!$result) return false;
        
        return true;  
    }
    
    public function changeLastName($user_id, $lastname) {
          $this->db->query("UPDATE website.users
                            SET lastname = :lastname
                            WHERE user_id = :user_id");
         
        $this->db->bind(':lastname', $lastname);
        $this->db->bind(':user_id', $user_id);
        
        $result = $this->db->execute();
        
        if(!$result) return false;
        
        return true;  
    }
    
    public function changeEmail($user_id, $email) {
        $this->db->query("UPDATE website.users
                          SET email = :email
                          WHERE user_id = :user_id");
        
        $this->db->bind(':email', $email);
        $this->db->bind(':user_id', $user_id);
        
        $result = $this->db->execute();
        
        if(!$result) return false;
        
        return true;
    }
    
    public function changeType($user_id, $type) {
        $this->db->query("UPDATE website.users
                          SET type = :type
                          WHERE user_id = :user_id");
        
        $this->db->bind(':type', $type);
        $this->db->bind(':user_id', $user_id);
        
        $result = $this->db->execute();
        
        if(!$result) return false;
        
        return true;
    }
    
   public function changeSerial($user_id, $serial) {
        $this->db->query("UPDATE website.users
                          SET serial = :serial
                          WHERE user_id = :user_id");
        
        $this->db->bind(':serial', $serial);
        $this->db->bind(':user_id', $user_id);
        
        $result = $this->db->execute();
        
        if(!$result) return false;
        
        return true;
    }
    
    public function registerConfirm($serial) {
        $this->db->query("SELECT user_id FROM website.users WHERE serial = :serial");
        
        $this->db->bind(':serial', $serial);
        
        $this->db->execute();
        
        if($this->db->rowCount() != 1) {
            $this->db->query("DELETE FROM website.users WHERE serial = :serial");
            $this->db->bind(':serial', serial);
            
            return false; // return false
        }
        
        $this->db->query("UPDATE website.users SET type = 1, serial = NULL WHERE serial = :serial RETURNING user_id, username, email");
        $this->db->bind(':serial', $serial);
        $result = $this->db->single();

        $username = $result->username;
        $email = $result->email;

        $this->db->query("DELETE FROM website.users WHERE (username = '$username' OR email = '$email') AND (type = 0)");
        $this->db->execute();
        
        $username = trim($username);
        
        $this->db->query("SELECT ftp FROM website.users WHERE username = :username");  
        $this->db->bind(':username', $username); 
        $result = $this->db->single();
        $credentials = $result->ftp;
        
        createFTP($username, $credentials);

        return true;
    }
	
    public function registerCreate($data) {
		//Insert Query
		$this->db->query('INSERT INTO website.users (username, password, email, type, about, avatar, firstname, lastname, serial, ftp) 
						  VALUES (:username, :password, :email, 0, :about, :avatar, :firstname, :lastname, :serial, :ftp)');
        
        $date = new DateTime();
        $serial = md5($data['password'] . $date->getTimestamp());
        $ftp = $data['username'] . ':' . crypt_apr1_md5($data['password']);
        
        //Bind Values
		$this->db->bind(':username', strtolower($data['username']));
		$this->db->bind(':password', md5($data['password']));
		$this->db->bind(':email', strtolower($data['email']));
		$this->db->bind(':about', '');
		$this->db->bind(':avatar', 'default.jpg');
		$this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':serial', $serial);
        $this->db->bind(':ftp', $ftp);
		
        $result = $this->db->execute();
        
		if(!$result) return false;
        
        $url = BASE_DIR . "register.php?serial=" . $serial;
        $body = "Hello " . ucfirst($data['username']) . ",\n\nGenomePro has created an account for you. Please confirm it by clicking on the URL below:\n\n" . $url . "\n\nIf you did not register for GenomePro, please ignore this email!";

        sendEmail(EMAIL_NAME, EMAIL_WHEN_SENDING, $data['username'], $data['email'], 'Welcome to GenomePro!', $body); 

        return true;
	}
 
    private function randomString($length) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0','9'));
        $max = count($characters) - 1;

        for($i = 0 ; $i < $length ; $i++) {
            $rand = mt_rand(0, $max);
            $str = $str . $characters[$rand];
        }
        
        return $str;
    }
    
    public function forgotPassword($email) {
        $this->db->query("SELECT user_id, username FROM website.users
                          WHERE email = :email
                          AND type != 0");
    
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
		
        if($this->db->rowCount() == 0) return 0; // false
        
        $user_id = $row->user_id;
        $username = trim($row->username);
        
        $temp = $this->randomString(10); // generate a random password of length 10;
        $temp_md5 = md5($temp);
        
        $this->db->query("UPDATE website.users
                          SET temp = '$temp_md5'
                          WHERE user_id = $user_id");
        
        $this->db->execute();
        
        $body = "Hello " . ucfirst($username) . ",\n\nGenomePro has created a temporary password for you. Use it to log in, then change the password to your preferred one following the instructions on your profile page.\n\nYour password: " . $temp . "\n\nIf you did not request this, please ignore this email!";

        sendEmail(EMAIL_NAME, EMAIL_WHEN_SENDING, $username, $email, 'Recover Access to Your Account', $body);  
        
        return 1;
    }
    
	public function login($username, $password) {
		$this->db->query("SELECT user_id, username, type, serial FROM website.users
						  WHERE username = :username
						  AND password = :password");
		
		$this->db->bind(':username', strtolower($username));
		$this->db->bind(':password', $password);
		
		$row = $this->db->single();
		
        if($this->db->rowCount() == 0) // account not found, but try with temp password
        {
            $this->db->query("SELECT user_id, username, type, serial FROM website.users
                              WHERE username = :username
                              AND temp = :password");
            
            $this->db->bind(':username', strtolower($username));
            $this->db->bind(':password', $password);
            
            $row = $this->db->single();
            
            if($this->db->rowCount() == 0) return 0; // credentials given are incorrect
        } 
        
        if($row->type == 0) return 1; // user needs to confirm email
        if($row->serial != NULL) return 2; // user needs to finish changing his email
      
        $this->setUserData($row);
        
        return 3; // user successfully signed in with password!
	}
	
    public function checkEmailExists($email) {
        $this->db->query("SELECT user_id FROM website.users
                          WHERE email = :email 
                          AND type != 0");
        
        $this->db->bind(':email', $email);
        
        $result = $this->db->execute();
        
        if($this->db->rowCount() < 1) return false;
		
		return true;
    }
    
    public function checkUsernameExists($username) {
        $this->db->query("SELECT user_id FROM website.users
                          WHERE username = :username 
                          AND type != 0");
        
        $this->db->bind(':username', $username);
        
        $row = $this->db->execute();
        
        if($this->db->rowCount() < 1) return false;

        return true;
    }
    
	private function setUserData($row) {
		$_SESSION['is_logged_in'] = true;
		$_SESSION['user_id'] = $row->user_id;
		$_SESSION['username'] = trim($row->username);
        $_SESSION['type'] = $row->type;
	}
	
	public function logout() {
		unset($_SESSION['is_logged_in']);
		unset($_SESSION['user_id']);
		unset($_SESSION['username']);
        unset($_SESSION['type']);
		
		return true;
	}
}