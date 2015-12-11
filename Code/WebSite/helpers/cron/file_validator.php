<?php
/* FILE_PROCESSOR.PHP **************************************************
*   File: 			file_processor.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		12/02/2015
*
*	Purpose:		One of the only reasons that this is apart from the
*                   job_processor (as it almost does the same thing) is
*                   that we want to separate validating files from the 
*                   queue of jobs being processed without getting too 
*                   tehnical. Essentially these two run in parallel,
*                   and this one might get expanded later on if needed
*                   be. Also, this one can be entirely on a different
*                   machine if things are done correctly. Of course,
*                   this locks itself, but it doesn't care about the
*                   locks that job_processor might currently be having.
*
*	Requirements:   config.php must exist, as this script requires a
*					lot of different global definitions. It is done
*					this way in case the structure of the database
*					changes or if something major changes, that way
*					changing only the global variable will do the
*					trick for this file and many others.
*
*					PHPmailer should be installed somewhere and 
*                   imported since it is required. In this particular
*					case, we have a emailResults() function found at 
*					the bottom that handles the emails.
*/

require '/var/www/html/config/config.php'; // super important!!
require '/var/www/html/helpers/cron/cron.helper.php';
require '/var/www/html/helpers/mailer/PHPMailerAutoload.php';

$conn = pg_connect("host=" . DB_HOST . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASS) or die('connection failed');

/************************************************************************************
*   Below this is pretty much the main function (although not really a function)
*/

if(($pid = cronHelper::lock()) !== FALSE) { // lock this file as I'm running
	$q = "SELECT jobs.job_id, files.file_id, files.name, files.path, users.username, users.email, tools.exe_path
          FROM website.jobs 
          JOIN website.tools 
		  ON jobs.tool_id = tools.tool_id 
          JOIN website.users 
		  ON users.user_id = jobs.user_id 
 		  JOIN website.involves
		  ON involves.job_id = jobs.job_id
		  JOIN website.files
		  ON files.file_id = involves.file_id
          WHERE status = 1 AND tools.tool_id = " . TOOL_VALIDATE . " 
		  ORDER BY job_id";
	
    $jobs = pg_query($conn, $q); // pretty much grab all jobs to validate files
    if(!$jobs) { echo "error executing query"; die(); }

    $users = array();
    $emails = array();
    $goodFiles = array();
    $badFiles = array();

    while($row = pg_fetch_row($jobs)) { 
        $job_id = $row[0];
		$file_id = $row[1];
		$name = trim($row[2]);
		$path = trim($row[3]);
		$username = trim($row[4]);
		$email = trim($row[5]);
        $exe_path = trim($row[6]);
        
        if(!in_array($username, $users)) array_push($users, $username); //add user to list of users if not there
        if(!array_key_exists($username, $emails)) $emails[$username] = $email;

        $date = new DateTime(); // here we're just making the directory to store the results
    	$destination = FILES_DIR . $username . '/' . RESULTS_DIR . date('YmdHi', $date->getTimestamp()) . '_' . $job_id . '/';
        
        mkdir(SERVER_DIR . $destination);
        
        echo "Validating file: '" . $path . $name . "', Result: ";
        
		// remember '$o' stores all the prints, '$r' stores the return value of the program.
        exec('"' . SERVER_DIR . PROGRAMS_DIR . $exe_path . '" "' . SERVER_DIR . $path . $name . '" "' . SERVER_DIR . $destination . RESULTS_NAME . '"', $o, $r);
		
        echo $r . "\n";
        
		$q = "UPDATE website.jobs 
			  SET status = " . JOB_DONE . ", timestamp = now(), results = '$destination' 
			  WHERE job_id = $job_id";
        
        $result = pg_query($conn, $q); // set this job as done as well as change the file type to the result
            
        $q = "UPDATE website.files
			  SET type_id = $r
			  WHERE file_id = $file_id";

    	$result = pg_query($conn, $q); // set this job as done as well as change the file type to the result
		
        if($r == TYPE_INV) { // bad file so we gotta delete that nonsense
			if(!array_key_exists($username, $badFiles)) $badFiles[$username] = $file_id . ': <a href="' . BASE_DIR . $destination . '">' . $name . '</a>';
            else $badFiles[$username] = $badFiles[$username] . "<br>" . $file_id . ': <a href="' . BASE_DIR . $destination . '">' . $name . '</a>';

            unlink(SERVER_DIR . $path . $name);
		} else {
			if(!array_key_exists($username, $goodFiles)) $goodFiles[$username] = $file_id . ': <a href="' . BASE_DIR . $destination . '">' . $name . '</a>';
            else $goodFiles[$username] = $goodFiles[$username] . "<br>" . $file_id . ': <a href="' . BASE_DIR . $destination . '">' . $name . '</a>';
		}
    }

    foreach($users as $user) {
        $subject = 'File(s) have been validated!';
        $body = 'Hello ' . ucfirst($user) . ',';

        if(array_key_exists($user, $goodFiles)) $body = $body . "<br><br>" . 'The following files were valid:' . "<br><br>" . $goodFiles[$user];
        if(array_key_exists($user, $badFiles)) $body = $body . "<br><br>" . 'The following files were invalid:' . "<br><br>" . $badFiles[$user];
        
        emailResults($emails[$user], ucfirst($user), $subject, $body);
    }
    
    cronHelper::unlock();
}

/************************************************************************************
*   This function does things and stuff. Should be pretty self explanatory
*/

function emailResults($email, $username, $subject, $body) {
    date_default_timezone_set('Etc/UTC');

    $mail = new PHPMailer;
    $mail->isSMTP();

    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = EMAIL_USERNAME;
    $mail->Password = EMAIL_PASSWORD;
    $mail->setFrom(EMAIL_WHEN_SENDING, EMAIL_NAME);

    $mail->addAddress($email, $username);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->isHTML(true);
    $mail->send();
}
?>
