<?php

class Job{
	
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
	
	public function submitJob($tool_id, $file_id) {
        //Insert Query
		$this->db->query('INSERT INTO website.jobs (user_id, tool_id, status) 
						  VALUES (:user_id, :tool_id, 1) RETURNING job_id');
        
		//Bind Values
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':tool_id', $tool_id);
        
        $result = $this->db->single();
        
		if($result){
            $job_id = $result->job_id;
            
            //Insert Query 
			$this->db->query('INSERT INTO website.involves (job_id, file_id) 
                              VALUES (:job_id, :file_id)');
            
            //Bind Values
            $this->db->bind(':job_id', $job_id);
            $this->db->bind(':file_id', $file_id);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
		} else {
			return false;
		}
	}
    
    public function getAllJobs() {
        $user_id = $_SESSION['user_id'];
        
        
        $this->db->query("SELECT jobs.*, tools.name FROM website.jobs 
                         INNER JOIN website.tools
                         ON jobs.tool_id = tools.tool_id
                         WHERE user_id = $user_id");
        
        $result = $this->db->resultset();
        
        return $result;
    }
}