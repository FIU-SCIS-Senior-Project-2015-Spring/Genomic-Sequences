<?php
        //to execute the C program to find differences among two files
        
	//import general functions
	require "functions.php";

	//initialize shell variables       
	$first_file = '../fileUploads/'.$argv[1];    // path to first file
	$sec_file = '../fileUploads/'.$argv[2];      // path to second file
        $result_file = '../fileUploads/'.$argv[3];   // path to result file
        $fileOne = $argv[1];                         // id of first file
        $fileTwo = $argv[2];                         // id of second file
        $result_id = $argv[3];                       // id of result file
        $id = $argv[4];                              // user id
        $email = $argv[5];                           // email
        $fName = $argv[6];                           // first name
        $lName = $argv[7];                           // last name
        $file_one_name = $argv[8];                   // file 1 name 
        $file_two_name = $argv[9];                   // file 2 name
        $file_result_name = $argv[10];               // file result name
        
	//create call to c program executable passing the parameters needed
	$call = '../CProgram/differences '.$first_file.' '.$sec_file.' '.$result_file.' '.$file_one_name.' '.$file_two_name;

	//excecute the call 
	$execute =  shell_exec($call);

	//once here the file will be saved in the fileResult folder, now update the db and email the user results

	//conection to the database 
	$connectedDB  = connectToDB();
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "UPDATE find_differences SET processed=1 WHERE user_id=".$id." AND uploaded_id1=".$fileOne." AND uploaded_id2=".$fileTwo." AND result_id=".$result_id;
	$resultID = pg_query($connectedDB, $sql);
   
        
        //send email to user with file result attached
        $name = $fName.' '.$lName;
        $name = ucwords($name);
	$subject = "Your result";
        $msg = "Hello " .$name. ",\n\n";
        $msg = $msg."The results of finding the differences among " .$argv[8]. " and " .$argv[9]. " is in the attached result file\n\n";
        $msg = $msg." -GenomePro Team";
        
        //sending email with attachment to the user with php mailer, needs to be changed when server upload
        emailWithAttachments($email, $name, $subject, $msg, $result_file, $file_result_name);
        	
?>
