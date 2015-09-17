<?php

class Tool{
	
	private $db;
	
	public function __construct() {
		$this->db = new Database;
	}
	
	public function getAllTools() {
		$this->db->query("SELECT * 
						  FROM website.tools");
						  
		$results = $this->db->resultset();
		
		return $results;
	}
}