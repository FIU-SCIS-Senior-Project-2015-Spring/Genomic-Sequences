<?php
        // this file will accept two input files from account controller and will pass that data to probesCprogram

	// import general functions
	require "functions.php";
        
	$probesFile = $_FILES["probesFile"];              // getting the file that contains the probes
        inputValidation($probesFile);                     // validating the content of the probes file
        $bashFile = $_FILES["bashFile"];                  // getting the bash file that has the probes to look for
        inputBashValidation($bashFile);                   // validating the content of the bash file
        $file1_sub = substr($probesFile["name"], 0, 5);   // get a portion of the name of the first file
        $file2_sub = substr($bashFile["name"], 0, 5);     // get a portion of the name of the second file
        $file_result = $file1_sub.$file2_sub;             // create the name of the result file concatinating substrings
        
        // Once we are here all data file validation has been approved
        
	//conection to the database 
	$connectedDB  = connectToDB();
         
        // get logged user id, email, and name from session
	session_start();
	$id = $_SESSION['id'];
	$email = $_SESSION['email'];
        $fName = $_SESSION['first_name'];
        $lName = $_SESSION['last_name'];
        session_write_close();
        
        //insert entry of probe file in docs table and save into $idOne the id of that entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$probesFile["name"]."','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idOne = $row['0'];
        
        //insert entry of bash file in docs table and save into $idTwo the id of that entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$bashFile["name"]."','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idTwo = $row['0'];
        
        //insert entry of result file in docs table and save into $idResult the id of that entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$file_result.".results.txt','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idResult = $row['0'];
        
        //insert entry of probe file, bash file, and result file in probes table
	$sql = "INSERT INTO probes (user_id, prob_uploaded_id1, prob_uploaded_id2, prob_result_id, date, time_stamp) VALUES ('".$id."','".$idOne."','".$idTwo."','".$idResult."','".date("Y/m/d")."','now()')";
	$resultID = pg_query($connectedDB, $sql);
        
        //save in file system by file id
	if(!move_uploaded_file($probesFile['tmp_name'], "../fileUploads/".$idOne)) throw new GeneralException('File to find probes was not uploaded correctly.', 001);
        if(!move_uploaded_file($bashFile['tmp_name'], "../fileUploads/".$idTwo)) throw new GeneralException('Bash file was not uploaded correctly.', 002);
        
        //excecuting php in different proccess or thread
	$call = $phpComp.' ../CProgram/probesCProgram.php '.$idOne.' '.$idTwo.' '.$idResult.' '.$id.' '.$email.' '.$fName.' '.$lName.' '.$probesFile["name"].' '.$bashFile["name"].' '.$file_result.'.results.txt &';           
        shell_exec($call);
     
	returnValue("ok.".$call);
        
        
        // file types to check for input validation:
        // application/octet-stream
        // text/plain

?>

