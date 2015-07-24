<?php

	//import general functions
	require "functions.php";

	$filein = '../fileUploads/'.$argv[1];	
	$fileout = '../fileUploads/'.$argv[2];
        $fileOne = $argv[1];
        $result_id = $argv[2];
        $id = $argv[3];
        $email = $argv[4];
        $fName = $argv[5];
        $lName = $argv[6];
        $fileresultname = $argv[7];
         
        $output1 = shell_exec('java -cp "../JavaProgram/" RepeatedSequence '.$filein.' '.$fileout);
        
        //conection to the database 
	$connectedDB  = connectToDB();
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "UPDATE rep_sequences SET processed=1 WHERE user_id=".$id." AND seq_uploaded_id=".$fileOne." AND seq_result_id=".$result_id;
	$resultID = pg_query($connectedDB, $sql);

        //send email to user with file result attached
        $name = $fName.' '.$lName;
        $name = ucwords($name);
	$subject = "Your result";
        $msg = "Hello " .$name. ",\n\n";
        //$msg = $msg."Your result is in the attached file\n\n";
	$msg = $msg."The results of repeated sequences " .$argv[7]. " is in the attached result file\n\n";        
	$msg = $msg." -GenomePro Team";
      
        //sending email with attachment to the user with php mailer, needs to be changed when server upload
        emailWithAttachments($email, $name, $subject, $msg, $fileout, $fileresultname);	
      
?>
