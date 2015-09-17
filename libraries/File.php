<?php

class File {
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
	 
	public function getAllFiles(){
        $user_id = $_SESSION['user_id'];
        
		//Insert Query
		$this->db->query("SELECT * FROM website.files WHERE user_id = $user_id");
		
		$results = $this->db->resultset();
		
		return $results;
    }
    
    public function uploadFileToDatabase($name) {
        $user_id = $_SESSION['user_id'];
        $username = trim($_SESSION['username']);
        
        $this->db->query("INSERT INTO website.files (type_id, user_id, path, name)
                          VALUES (1, $user_id, :path, :name)");   
        
        $this->db->bind(':path', FILES_DIR . $username . '/' );
        $this->db->bind(':name', $name );
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}