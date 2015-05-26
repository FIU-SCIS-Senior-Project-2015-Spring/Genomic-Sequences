<?php

//	$host = "127.0.0.1";
//	$dbname = "genomepro";
//	$user = "postgres";
//	$password = "1234";
	$adminEmail = "yohansantos13@gmail.com";

	//The information to connect to the database
	$host = "127.0.0.1";
	$user = "postgres";
	$pass = "1234";
	$db = "genomepro";
	$connectedDB = null;

	
	//convert variables into post
	$_POST = json_decode(file_get_contents('php://input'),true);	

	//return a correct value
	function returnValue($result) {
		$return_values = json_encode($result);
		header('Content-Type: application/json');
		echo $return_values;
		exit;
	}

	// this method connects to the database
	function connectToDB()
	{
        	//$connectedDB = pg_pconnect("dbname=".$dbname);
		$connectedDB  = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");
		return $connectedDB;
	}

	//check if the variable is empty
	function isEmpty($value = null){
		if($value == null) return true;
		elseif (empty($value)) return true;
		else return false;
	}

	//Exception handling
	function exception_handler_api($exception) {
		if ($exception instanceof GeneralException) $ae = &$exception;
		else { // Thrown a non API Exception
			$ae = new GeneralException('The service is temporarily unavailable', 1410);
		}
		$ae->fault();
		exit;
	}

	//set the exception handler so that every time there is an exception, is pass to the function exception_handler_api 	
	set_exception_handler('exception_handler_api');

	//this class take care of handler exception 
	class GeneralException extends Exception
	{		
		//variables		
		public $message;
		public $code;

		//constrcutor
		public function __construct($message = null, $code = 0) {
			$this->message = $message;
			$this->code = $code;
			parent::__construct($message, $code);
		}

		//function
		public function fault() {
			$fault = new stdClass;
			$fault->ErrorCode = $this->code;
			$fault->ErrorMsg = $this->message;
			$ret = json_encode($fault);
			
			header('Error', true, 400);
			header('Content-Length: '.strlen($ret));
			header('Content-Type: application/json; charset="utf-8"');
			echo($ret);
		}
	}
?>
