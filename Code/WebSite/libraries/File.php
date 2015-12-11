<?php

class File {
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
	 
	public function getAllFiles(){
        $user_id = $_SESSION['user_id'];
        
		//Insert Query
		$this->db->query("SELECT * FROM website.files WHERE user_id = $user_id AND type_id != 1 ORDER BY name desc");
		
		$results = $this->db->resultset();
		
		return $results;
  }
  
  public function getFile($file_id){
    $user_id = $_SESSION['user_id'];
        
		//Insert Query
		$this->db->query("SELECT * FROM website.files WHERE file_id = :file_id");
		
        $this->db->bind(":file_id", $file_id);
    
		$result = $this->db->single();
		
		return $result;
  }
  
  public function getAllMaps(){
    $user_id = $_SESSION['user_id'];
        
		//Insert Query
		$this->db->query("SELECT * FROM website.files WHERE user_id = $user_id AND type_id = 6");
		
		$results = $this->db->resultset();
		
		return $results;
  }
    
  public function getNameByID($file_id) {
    $this->db->query("SELECT name FROM website.files WHERE file_id = :file_id");

    $this->db->bind(':file_id', $file_id);

    $result = $this->db->single();

    if(!$result) return 'UNKNOWN';

    return $result->name;
  }
    
  public function deleteFile($file_id) {
    $this->db->query("DELETE FROM website.files WHERE file_id = :file_id RETURNING name, path");

    $this->db->bind(':file_id', $file_id);

    $result = $this->db->single();

    if($result) {
      $name = trim($result->name);
      $path = trim($result->path);

      $file = SERVER_DIR . $path . $name;

      unlink($file);
    }
  }
      
  public function submitFile($name) {
    $user_id = $_SESSION['user_id'];
    $username = trim($_SESSION['username']);

    $this->db->query("INSERT INTO website.files (type_id, user_id, path, name)
                      VALUES (" . TYPE_UNK . ", $user_id, :path, :name) RETURNING file_id");   

    $this->db->bind(':path', FILES_DIR . $username . '/' . UPLOADS_DIR);
    $this->db->bind(':name', $name );

    $result = $this->db->single();

    if($result) return $result->file_id;
	else return 0;
  }
}