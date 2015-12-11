<?php

class Job {
	
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
	
	public function submitJobMultiple($files, $tool_id, $args = NULL, $ignore = NULL, $start = 1, $finish = 1) {
        //Insert Query
        $this->db->query('INSERT INTO website.jobs (user_id, tool_id, status, args, start, finish) 
                          VALUES (:user_id, :tool_id, 1, :args, :start, :finish) RETURNING job_id');
        
        //Bind Values
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':tool_id', $tool_id);
        $this->db->bind(':args', $args);
        $this->db->bind(':start', $start);
        $this->db->bind(':finish', $finish);

        $result = $this->db->single();
        $job_id = $result->job_id;
        
        if(!$job_id) return 0; // return false
        
        if($ignore != NULL) foreach($ignore as $i) unset($files[$i]);   
            
        foreach($files as $file_id) {
            //Insert Query 
            $this->db->query('INSERT INTO website.involves (job_id, file_id) 
                              VALUES (:job_id, :file_id)');

            //Bind Values
            $this->db->bind(':job_id', $job_id);
            $this->db->bind(':file_id', $file_id);

            $result = $this->db->execute();
            
            if(!$result) return 0; // return false
        }
        
        return $job_id; // return true
    }
    
    public function submitJobSingle($file_id, $tool_id, $args = NULL) {
        //Insert Query
        $this->db->query('INSERT INTO website.jobs (user_id, tool_id, status, args) 
                          VALUES (:user_id, :tool_id, 1, :args) RETURNING job_id');
        
        //Bind Values
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':tool_id', $tool_id);
        $this->db->bind(':args', $args);

        $result = $this->db->single();

        if(!$result) return 0; // return false
        
        $job_id = $result->job_id;

        //Insert Query 
        $this->db->query('INSERT INTO website.involves (job_id, file_id) 
                          VALUES (:job_id, :file_id)');

        //Bind Values
        $this->db->bind(':job_id', $job_id);
        $this->db->bind(':file_id', $file_id);

        $result = $this->db->execute();
        
        if(!$result) return 0; // return false
        
        return $job_id; // return true
	}

    public function getAllJobsPending() {
        $user_id = $_SESSION['user_id'];
        
        
        $this->db->query("SELECT jobs.*, tools.name 
						  FROM website.jobs 
                          INNER JOIN website.tools
                          ON jobs.tool_id = tools.tool_id
                          WHERE user_id = $user_id
                          AND status = 1
                          ORDER BY job_id DESC");
        
        $result = $this->db->resultset();
        
        return $result;
    }
    
    public function getAllJobsCompleted() {
        $user_id = $_SESSION['user_id'];
        
        
        $this->db->query("SELECT jobs.*, tools.name 
													FROM website.jobs 
                         	INNER JOIN website.tools
                         	ON jobs.tool_id = tools.tool_id
                         	WHERE user_id = $user_id 
                         	AND status = 2 AND jobs.visible = TRUE
                         	ORDER BY job_id DESC");
        
        $result = $this->db->resultset();
        
        return $result;
    }
    
    
    public function clearHistory() {
        $user_id = $_SESSION['user_id'];
        
        $this->db->query("UPDATE website.jobs SET visible = FALSE WHERE user_id = $user_id AND status != 1");
        
        $result = $this->db->execute();
        
        if(!$result) return false;
        
        return true;
    }
    
    public function getJobCount() {
        $user_id = $_SESSION['user_id'];
        
        $this->db->query("SELECT * FROM website.jobs 
                         	WHERE user_id = $user_id");
        
        $result = $this->db->execute();
        
        return $this->db->rowCount();
    }
}