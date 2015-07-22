<?php
        
        // importing the phpmailer functionality for localhost
        require_once '/Applications/MAMP/htdocs/GenomePro/phpmailer/vendor/autoload.php';  
        
	//could be yordan, ubuntu or yohan
	$OSys = 'yordan';

	if ($OSys == 'ubuntu'){

		//The information to connect to the database
		$host = "127.0.0.1";
		$user = "postgres";
		$pass = "genomepro2015";
		$db   = "genomepro";
	
		//php compiler
		$phpComp = '/usr/bin/php';
	
	}else if($OSys == 'yordan'){

		//The information to connect to the database
		$host = "127.0.0.1";
		$user = "postgres";
		$pass = "1234";
		$db   = "genomepro";
	
		//php compiler
		$phpComp = '/Applications/MAMP/bin/php/php5.6.7/bin/php';	
	
	}else{

		//The information to connect to the database
		$host = "127.0.0.1";
		$user = "postgres";
		$pass = "1234";
		$db   = "genomepro";
	
		//php compiler
		$phpComp = '/usr/bin/php';
	
	}
        
        function connectToDB(){
		GLOBAL $host;
		GLOBAL $db;
		GLOBAL $user;
		GLOBAL $pass;
		$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die("Could not connect to server");
		return $conn;
	}
	
	//convert variables into post
	$_POST = json_decode(file_get_contents('php://input'), true);
        
        //function to send emails to the admin using php mailer
        function emailAdmin($email, $name, $subject, $msg){
            $adminEmail = "yalva054@fiu.edu";
            
	    $from       = $email;       	// sender email
            $senderName = $name;               	// sender name
	    $to         = $adminEmail;	        // destination (admin)
            $sub        = $subject;            	// subject
            $message    = $msg;              	// message

            // using gmail accounts for testing, we can change it once is on the server 
            $m = new PHPMailer;       // new php mailer object

            $m->isSMTP();             // telling phpmailer we want to use the smpt option
            $m->SMTPAuth = true;      // testing properties, for debuging

            $m->Host       = 'smtp.gmail.com';             // the smtp for gmail
            $m->Username   = 'genomeprofiu@gmail.com';     // email for the gmail host 
            $m->Password   = 'genomepro2015';              // password
            $m->SMTPSecure = 'ssl';                        // secure type
            $m->Port = 465;                                // port used

            $m->From = $from;                              // email sending from
            $m->FromName = $senderName;                    // sender name
            $m->addReplyTo($from, 'Reply address');        // method to reply to the sender
	    $m->addAddress($to, "Genome Pro");             // send this to destination (admin)

            $m->Subject = $sub;                            // email subject
            $m->Body = $message;                           // message of the email 

            if($m->send()) // email was successfully ACCEPTED for delivery
            {
                returnValue("sent.");
            }            
        }
        
        //function to send emails using php mailer
        function email($email, $name, $subject, $msg){
                        
            $from       = "genomeprofiu@gmail.com";  // sender email
            $senderName = $name;                     // sender name
            $to         = $email;                    // destination 
            $sub        = $subject;                  // subject
            $message    = $msg;                      // message

            // using gmail accounts for testing, we can change it once is on the server 
            $m = new PHPMailer;       // new php mailer object

            $m->isSMTP();             // telling phpmailer we want to use the smpt option
            $m->SMTPAuth = true;      // testing properties, for debuging

            $m->Host       = 'smtp.gmail.com';             // the smtp for gmail
            $m->Username   = 'genomeprofiu@gmail.com';     // email for the gmail host 
            $m->Password   = 'genomepro2015';              // password
            $m->SMTPSecure = 'ssl';                        // secure type
            $m->Port = 465;                                // port used

            $m->From = $from;                              // email sending from
            $m->FromName = "Genome Pro Team";              // sender name
            $m->addReplyTo($from, 'Reply address');        // method to reply to the sender
            $m->addAddress($to, $senderName);              // send this to destination (admin)

            $m->Subject = $sub;                            // email subject
            $m->Body = $message;                           // message of the email 

            if($m->send()) // email was successfully ACCEPTED for delivery
            {
                returnValue("sent.");
            }            
        }
        
        //function to send emails with attachments using php mailer
        function emailWithAttachments($email, $name, $subject, $msg, $result_file, $file_name) {
                        
            $from       = "genomeprofiu@gmail.com";    // sender email
            $senderName = $name;                       // sender name
            $to         = $email;                      // destination 
            $sub        = $subject;                    // subject
            $message    = $msg;                        // message
            $attach     = $result_file;

            // using gmail accounts for testing, we can change it once is on the server 
            $m = new PHPMailer;       // new php mailer object

            $m->isSMTP();             // telling phpmailer we want to use the smpt option
            $m->SMTPAuth = true;      // testing properties, for debuging

            $m->Host       = 'smtp.gmail.com';             // the smtp for gmail
            $m->Username   = 'genomeprofiu@gmail.com';     // email for the gmail host 
            $m->Password   = 'genomepro2015';              // password
            $m->SMTPSecure = 'ssl';                        // secure type
            $m->Port = 465;                                // port used

            $m->From = $from;                              // email sending from
            $m->FromName = "Genome Pro Team";              // sender name
            $m->addReplyTo($from, 'Reply address');        // method to reply to the sender
            $m->addAddress($to, $senderName);              // send this to destination (admin)
            $m->addAttachment($attach, $file_name);

            $m->Subject = $sub;                            // email subject
            $m->Body = $message;                           // message of the email 

            if($m->send()) // email was successfully ACCEPTED for delivery
            {
                returnValue("sent.");
            }            
        }
        
        // function to validate input data from the user
        function inputValidation($file) {
            // file type input validation for the probes file
            if (($file["type"] != "text/plain") && ($file["type"] != "application/octet-stream")) {
                throw new GeneralException('Invalid file type.', 005); 
            }
            else if($file["size"] > 1000000000){  // if the file exeeds 1G return an error
                throw new GeneralException('File '.$file["name"].' exceeds maximum of 1GB.', 006);
            }
            else { // if file type is ok and size is ok, check for content
                $myfile = fopen($file["tmp_name"], "r") or die("Unable to open file!"); // open the file to be read           
                while(!feof($myfile)) {                     // until end-of-file check data content
                    $line = trim(fgets($myfile));           // get a line
                    for($i = 0; $i < count($line); $i++) { 
                        $char = $line[$i];                  // check each character in each line
                        if(($char == 'a') || ($char == 'c') || ($char == 'g') || ($char == "\r\n") || ($char == 't') || ($char == 'u')) {
                            continue;  // if valid data continue reading
                        }
                        else {  // otherwise display an error
                            throw new GeneralException('File '.$file["name"].' contains invalid data', 007);
                        }
                    }
                }
                fclose($myfile); // close the file   
            }
            
        }
        
        // function ti validate the bash file inputted by the user
        function inputBashValidation($file) {
            // file type input validation for the bash file
            if($file["type"] != "text/plain") {
                throw new GeneralException('Invalid file type.', 005);
            }
            else if($file["size"] > 1024){  // if the file exeeds 1KB = 20 lines of sequences of 50 letters each return an error
                throw new GeneralException('File '.$file["name"].' exceeds maximum of 1KB.', 006);
            }
            else {  // if file type is ok and size is ok, check for content
                $myfile = fopen($file["tmp_name"], "r") or die("Unable to open file!"); // open the file to be read           
                while(!feof($myfile)) {                     // until end-of-file check data content
                    $line = trim(fgets($myfile));           // get a line
                    for($i = 0; $i < count($line); $i++) { 
                        $char = $line[$i];                  // check each character in each line
                        if(($char == 'a') || ($char == 'c') || ($char == 'g') || ($char == "\r\n") || ($char == 't') || ($char == 'u')) {
                            continue;  // if valid data continue reading
                        }
                        else {  // otherwise display an error
                            throw new GeneralException('File '.$file["name"].' contains invalid data', 007);
                        }
                    }
                }
                fclose($myfile); // close the file   
            }
            
        }
        
	//return a correct value
	function returnValue($result) {
		$return_values = json_encode($result);
		header('Content-Type: application/json');
		echo $return_values;
		exit;
	}
        
        //function that returns the real name of the file for the download in history
        function returnFile($title, $realName)
        {
                $myfile = fopen($title, "r") or die("Unable to open file!"); 
                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename="'.$realName.'";');
                /** Send file to browser to download */
                fpassthru($myfile);
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
			$ae = new GeneralException('We are sorry, system is temporarily unavailable', 1410);
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
