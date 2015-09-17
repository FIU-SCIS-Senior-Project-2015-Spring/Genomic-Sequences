<?php
        //to execute the C program to analyze the input files
        
	//import general functions
	require "functions.php";

	//initialize shell variables
	$first_file = '../fileUploads/'.$argv[1];     // path to analyze file
	$result_file = '../fileUploads/'.$argv[2];    // path to result file
        $fileOne = $argv[1];                          // id of analyze file
        $result_id = $argv[2];                        // id of result file
        $id = $argv[3];                               // user id
        $email = $argv[4];                            // email
        $fName = $argv[5];                            // first name
        $lName = $argv[6];                            // last name
        $an_file_name = $argv[7];                     // analyze file name
        $file_result_name = $argv[8];                 // result file name
        
	//create call to c program executable passing the parameters needed
	$call = '../CProgram/analyze '.$first_file.' '.$result_file.' '.$an_file_name;

	//excecute the call 
	$execute =  shell_exec($call);

	//once here the file will be saved in the fileUpload folder, now update the db and email the user results
        
	//conection to the database 
	$connectedDB  = connectToDB();
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "UPDATE data_type SET processed=1 WHERE user_id=".$id." AND an_uploaded_id=".$fileOne." AND an_result_id=".$result_id;
	$resultID = pg_query($connectedDB, $sql);
                                
        //send email to user with file result attached
        $name = $fName.' '.$lName;
        $name = ucwords($name);
	$subject = "Your result";
        $msg = "Hello " .$name. ",\n\n";
        $msg = $msg."The results of analyzing " .$argv[7]. " is in the attached result file\n\n";
        $msg = $msg." -GenomePro Team";
        
        //sending email with attachment to the user with php mailer, needs to be changed when server upload
        emailWithAttachments($email, $name, $subject, $msg, $result_file, $file_result_name);
        	
?>


