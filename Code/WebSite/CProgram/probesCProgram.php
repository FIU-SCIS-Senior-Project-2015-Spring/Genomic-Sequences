<?php
        //to pass the data and execute the C program to find the genomic probes
        
	//import general functions
	require "functions.php";

	//initialize shell variables
	$first_file = '../fileUploads/'.$argv[1];   // path to probe file
	$sec_file = '../fileUploads/'.$argv[2];     // path to bash file
	$result_file = '../fileUploads/'.$argv[3];  // path to result file
        $file1_id = $argv[1];                       // id of probes file
        $file2_id = $argv[2];                       // id of bash file
        $result_id = $argv[3];                      // id of result file
        $id = $argv[4];                             // user id
        $email = $argv[5];                          // email
        $fName = $argv[6];                          // first name
        $lName = $argv[7];                          // last name
        $prob_file_name = $argv[8];                 // probs file name
        $bash_file_name = $argv[9];                 // bash file name
        $result_name = $argv[10];                   // result file name
                
	//create call to c program executable passing the parameters needed
	$call = '../CProgram/probes '.$first_file.' '.$sec_file.' '.$result_file;

	//excecute the call 
	$execute =  shell_exec($call);

	//once here the file will be saved in the fileUpload folder, now update the db and email the user results

	//conection to the database 
	$connectedDB  = connectToDB();
        
        //update entry of probe file, bash file, and result file in probes table
	$sql = "UPDATE probes SET processed=1 WHERE user_id=".$id." AND prob_uploaded_id1=".$file1_id." AND prob_uploaded_id2=".$file2_id." AND prob_result_id=".$result_id;
	$resultID = pg_query($connectedDB, $sql);

        //send email to user with file result attached
        $name = $fName.' '.$lName;
        $name = ucwords($name);
	$subject = "Your result";
        $msg = "Hello " .$name. ",\n\n";
        $msg = $msg."The results of finding probes in file " .$argv[8]. " given bash file " .$argv[9]. " is in the attached result file\n\n";
        $msg = $msg." -GenomePro Team";
        
        //sending email with attachment to the user with php mailer, needs to be changed when server upload
        emailWithAttachments($email, $name, $subject, $msg, $result_file, $result_name);
        	
?>



