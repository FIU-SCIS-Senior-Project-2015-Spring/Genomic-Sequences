<?php
/* JOB_PROCESSOR.PHP **************************************************
*   File: 			job_processor.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		12/02/2015
*
*	Purpose:		Ah, some might say this is the heart of GenomePro.
*					This script handles every single job except the
*					file validation as of 2.0. Using a mailing
*					function, it also provides the user a notification
*					for when their jobs have finished processing. 
*					You can imagine this script running once every
*					minute, depending on what time you have it set
*					at the system's crontab. Sometimes, when specific
*					jobs need to do specific things, this script will
*					split off code, but generally, all jobs are 
*					processed relatively the same way: grab all 
*					pending jobs, one by one run the tool with the
*					required files, save results at the user's FTP
*					and set the job as completed on the database.
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

$conn; // global database handler

/************************************************************************************
*   Below this is pretty much the main function (although not really a function)
*/

if(($pid = cronHelper::lock()) !== FALSE) { // do not let another instance of job_processor run
    global $conn;

    $conn = pg_connect("host=" . DB_HOST . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASS) or die('connection failed');

    // grab all pending jobs
    $q = "SELECT jobs.job_id, tools.type, tools.exe_path, users.username, users.email, jobs.args, users.user_id, tools.tool_id, tools.name, jobs.start, jobs.finish   
          FROM website.jobs 
          JOIN website.tools 
		  ON jobs.tool_id = tools.tool_id 
          JOIN website.users 
		  ON users.user_id = jobs.user_id 
          WHERE status = 1 AND tools.tool_id != " . TOOL_VALIDATE . " 
		  ORDER BY job_id"; // notice the '!='

    $jobs = pg_query($conn, $q);
    if(!$jobs) { echo "error executing query"; die(); }

    $users = array(); // contains the working data to create the 'body' of the email
    $emails = array(); // list of user emails saved here
    $date = new DateTime(); // for logging purposes

    while($row = pg_fetch_row($jobs)) { // for every job that is pending
        $job_id = $row[0];
        $type = $row[1]; // job type
        $exe_path = trim($row[2]); // where to find the tool executable
        $username = trim($row[3]);
        $email = trim($row[4]);
        $args = trim($row[5]); // if the program has some sort of arguments, NULL otherwise
        $user_id = $row[6]; 
        $tool_id = $row[7];
        $tool_name = trim($row[8]);
        $start = trim($row[9]);
        $finish = trim($row[10]);

        if(!array_key_exists($username, $users)) $users[$username] = $job_id; // used for email
        else $users[$username] = $users[$username] . "<br />" . $job_id;

        $emails[$username] = $email; 

        switch($type) {
            case KIND_SINGLE: // job takes one file as input
                echo "Job " . $job_id . " going into 'processJobSingle' at " . date('YmdHi', $date->getTimestamp()) . "\n";
                $url = processJobSingle($job_id, $exe_path, $username, $args, $user_id, $tool_id); // process job returns url of where to find results
                $users[$username] = $users[$username] . ': <a href="' . BASE_DIR . $url . '">' . $tool_name . '</a>';
                break;

            case KIND_MULTIPLE: // job takes multiple files as input
                echo "Job " . $job_id . " going into 'processJobMultiple' at " . date('YmdHi', $date->getTimestamp()) . "\n";
                $url = processJobMultiple($job_id, $exe_path, $username, $args, $user_id, $tool_id, $start, $finish); // process job returns url of where to find results
                $users[$username] = $users[$username] . ': <a href="' . BASE_DIR . $url . '">' . $tool_name . '</a>';
                break;

            default: // something went wrong, so skip job
        }
    }

    foreach($users as $key => $value) { // after all jobs are completed, we use those two arrays to create the emails
        $subject = 'Job(s) have finished processing!';
        $body = 'Hello ' . ucfirst($key) . ",<br /><br />" . 'The following jobs have finished processing:' . "<br /><br />" . $value;
        /* 
            Essentially, with the help of $emails and $users array, we can compose emails like so:

                Hello Blastoy,

                The following jobs have finished processing:

                164: http://genomepro.cis.fiu.edu/delivery/blastoy/results/201512021840_164/
                165: http://genomepro.cis.fiu.edu/delivery/blastoy/results/201512021841_165/
                ...
        */
        emailResults($emails[$key], ucfirst($key), $subject, $body);
    }

    cronHelper::unlock(); // free the lock
}

/************************************************************************************
*   Function: 		processJobSingle()
*		
*	Parameters:		$job_id			the id of the job
*					$exe_path:      executable direction
*					$username:	    user's username (used for finding his or her FTP)
*					$args: 			any extra arguments to run the program
*					$user_id:		the user's id
*					$tool_id:		the tool's id
*									
*	Summary:		This function does some of the easier jobs that require only
*					one file (no batch file) to process. Examples of these 
*					include Genome Probes, Unique Sequences, etc. You can expect
*					this function to simply grab the C program involved with a
*					tool, run it with a given input file, and save the results
*					somewhere. Nothing prior or after is done except letting the
*					DB know that the job has been completed.
*/

function processJobSingle($job_id, $exe_path, $username, $args, $user_id, $tool_id) {
    global $conn;

    if($args == NULL) $args = ""; // args as NULL can get nasty

    $q = "SELECT path, name 
          FROM website.files 
          JOIN website.involves 
          ON files.file_id = involves.file_id 
          WHERE job_id = $job_id";

    $result = pg_query($conn, $q); // essentially just grab that file row
    if(!$result) return;

    $row = pg_fetch_row($result);

    $path = trim($row[0]);
    $name = trim($row[1]);

    $file = SERVER_DIR . $path . $name; // where the input file is stored (absolute path)

    // note that '$o' is where the console 'prints' are stored, and '$r' is the return value below.
    $output = exec('"' . SERVER_DIR . PROGRAMS_DIR . $exe_path . '" "' . $file . '" ' . $args, $o, $r);

    $date = new DateTime(); // here we're just making the directory to store the results
    $destination = FILES_DIR . $username . '/' . RESULTS_DIR . date('YmdHi', $date->getTimestamp()) . '_' . $job_id . '/';

    mkdir(SERVER_DIR . $destination);

    $fp = fopen(SERVER_DIR . $destination . RESULTS_NAME, 'w'); // write console output to a file somewhere
    foreach($o as $s) fwrite($fp, $s . "\n");
    fclose($fp);

    $q = "UPDATE website.jobs 
          SET status = 2, timestamp = now(), results = '$destination'
          WHERE job_id = $job_id";

    $result = pg_query($conn, $q); // set this job as done and we're outta here!

    return $destination;
}

/************************************************************************************
*   Function: 		processJobMultiple()
*		
*   Parameters:		$job_id			the id of the job
*					$exe_path:      executable direction
*					$username:	    user's username (used for finding his or her FTP)
*					$args: 			any extra arguments to run the program
*					$user_id:		the user's id
*					$tool_id:		the tool's id
*		
*   Summary:		Similar to processing single jobs, this function does creates
*					and finds files required to get the job done (ironically). 
*					Only difference here is that these jobs instead of taking one
*					file take a couple, and most of them use the usage of a 'batch'
*					file to consolidate these arguments. As such, some preliminary
*					creation of the 'batch' file needs to be done. Also, this job
*					can get complicated with certain tools, like Genome Sequences,
*					which needs a permutation of files. However, at it's core, it
*					does things very similarly to processing a single file
*/

function processJobMultiple($job_id, $exe_path, $username, $args, $user_id, $tool_id, $start, $finish) {
    global $conn;

    $q = "SELECT path, name 
    FROM website.files 
    JOIN website.involves 
    ON files.file_id = involves.file_id 
    WHERE job_id = $job_id"; // grab all files related to this job

    $result = pg_query($conn, $q);
    if(!$result) return;

    $files = array();
    $names = array();

    while($row = pg_fetch_row($result)) { // split paths and names to arrays
        $path = trim($row[0]);
        $name = trim($row[1]);

        array_push($files, SERVER_DIR . $path . $name);
        array_push($names, $name);
    }

    $date = new DateTime(); // used below to create the directory where to store results
    $destination = FILES_DIR . $username . '/' . RESULTS_DIR . date('YmdHi', $date->getTimestamp()) . '_' . $job_id . '/';

    mkdir(SERVER_DIR . $destination);

    $result = "";
    $length = count($files);

    switch($tool_id) { // for making batch files
        case TOOL_GENSIG: // Genome Signatures (permuations)
            for($i = 0 ; $i < $length ; $i++) for($j = 0 ; $j < $length ; $j++) if($i != $j) $result = $result . $files[$i] . " " . $files[$j] . " " . SERVER_DIR . $destination . "\n";
            break;

        case TOOL_EXTFAST: // Extract Fasta/Fastq
            $a = explode(" ", $args); 
            for($i = 0 ; $i < $length ; $i++) $result = $result . $files[$i] . " " . $a[$i] . " " . SERVER_DIR . $destination . "\n";
            break;

        default: for($i = 0 ; $i < $length ; $i++) $result = $result . $files[$i] . " " . SERVER_DIR . $destination . "\n";     
    }

    $batch = SERVER_DIR . PROGRAMS_DIR . BATCH_NAME; // open and write the batch file created

    $fp = fopen($batch, 'w');
    fwrite($fp, $result);
    fclose($fp);

    // -- run the program with given batch file -- // note: return variable gets saved at $r, output at $o.
    $output = exec('"' . SERVER_DIR . PROGRAMS_DIR . $exe_path . '" "' . $batch . '"', $o, $r);

    $fp = fopen(SERVER_DIR . $destination . RESULTS_NAME, 'w');
    foreach($o as $s) fwrite($fp, $s . "\n");
    fclose($fp);

    switch($tool_id) { // switch case for handling jobs that need to move output to database as input files
		case TOOL_EXTFAST:
            for($i = 0 ; $i < $length ; $i++) { // TODO: UPDATE FIRST PART OF THE NAME
                $path = SERVER_DIR . $destination;
                $name = $names[$i] . "_" . $a[$i] . ".ext";

                if(file_exists($path . $name)) {
                    $q = "INSERT INTO website.files (type_id, user_id, path, name) 
                          VALUES (" . TYPE_EXT . ", $user_id, '$destination', '$name') RETURNING file_id"; // add file to database
                    
                    $result = pg_query($conn, $q);
    				if(!$result) break;

    				$row = pg_fetch_row($result);
					$ret_file_id = $row[0];
					
					if($start != $finish) {	// if jobs were submitted as a queue, gotta insert a new job for the next step			
                        $q = "SELECT next FROM website.steps WHERE tool_id = $tool_id";
                        $result = pg_query($conn, $q);
						
				        $row = pg_fetch_row($result);
				        $next = $row[0];
                        
                        $start++;
                        
						$q = "INSERT INTO website.jobs (user_id, tool_id, status, start, finish) 
							  VALUES ($user_id, $next, 1, $start, $finish) RETURNING job_id";
						
				        $result = pg_query($conn, $q);
                        
				        $row = pg_fetch_row($result);
				        $ret_job_id = $row[0];
						
						$q = "INSERT INTO website.involves (job_id, file_id)
							  VALUES ($ret_job_id, $ret_file_id)";
                        
                        $result = pg_query($conn, $q);
					}
                }
            }

            break;

		case TOOL_SORTSEQ: // very similar to above
            for($i = 0 ; $i < $length ; $i++) { // TODO: UPDATE FIRST PART OF THE NAME
                $path = SERVER_DIR . $destination;
                $name = $names[$i] . ".sorted";

                if(file_exists($path . $name)) {
                    $q = "INSERT INTO website.files (type_id, user_id, path, name) 
                          VALUES (" . TYPE_SORTED . ", $user_id, '$destination', '$name') RETURNING file_id";
                    
                    $result = pg_query($conn, $q);
    				if(!$result) break;

    				$row = pg_fetch_row($result);
					$ret_file_id = $row[0];
					
					if($start != $finish) {				
                        $q = "SELECT next FROM website.steps WHERE tool_id = $tool_id";
                        $result = pg_query($conn, $q);
						
				        $row = pg_fetch_row($result);
				        $next = $row[0];
                        
                        $start++;
                        
						$q = "INSERT INTO website.jobs (user_id, tool_id, status, start, finish) 
							  VALUES ($user_id, $next, 1, $start, $finish) RETURNING job_id";
						
				        $result = pg_query($conn, $q);
                        
				        $row = pg_fetch_row($result);
				        $ret_job_id = $row[0];
						
						$q = "INSERT INTO website.involves (job_id, file_id)
							  VALUES ($ret_job_id, $ret_file_id)";
                        
                        $result = pg_query($conn, $q);
					}
                }
            }

			break;
            
        case TOOL_MAPS: // no real step after this.
            for($i = 0 ; $i < $length ; $i++) {
                $path = SERVER_DIR . $destination;
				$name = $names[$i] . ".mapC";
                
				if(file_exists($path . $name)) {
					$q = "INSERT INTO website.files (type_id, user_id, path, name) 
						  VALUES (" . TYPE_MAPS . ", $user_id, '$destination', '$name')";

					$result = pg_query($conn, $q);
				}
            }
            
            break;

		default: // do nothing
    }

    $q = "UPDATE website.jobs 
          SET status = 2, timestamp = now(), results = '$destination' 
          WHERE job_id = $job_id"; // finish the job. we're outta here!

    $result = pg_query($conn, $q);

    return $destination;
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