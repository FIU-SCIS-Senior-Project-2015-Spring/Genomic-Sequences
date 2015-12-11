<?php

class Tool {
	
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
    
    public function checkType($tool_id) {
        $this->db->query("SELECT type FROM website.tools WHERE tool_id = :tool_id");
        
        $this->db->bind(':tool_id', $tool_id);
        
        $result = $this->db->single();
        
        $type = $result->type;
        
        if(!$type) return 0;
        
        return $type;
    }
	
	public function getAllTools() {
		$this->db->query("SELECT * FROM website.tools WHERE visible = TRUE ORDER BY tool_id");
						  
		$results = $this->db->resultset();
		
		return $results;
	}
    
    public function getNameByID($tool_id) {
        $this->db->query("SELECT name FROM website.tools WHERE tool_id = :tool_id");
        
        $this->db->bind(':tool_id', $tool_id);
        
        $result = $this->db->single();
        
        if(!$result) return 'UNKNOWN';
        
        return $result->name;
    }
}