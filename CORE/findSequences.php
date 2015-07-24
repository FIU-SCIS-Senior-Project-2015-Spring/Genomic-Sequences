<?php
        // whenever we upload this to the server, we need to change the call functions
        // in the shell_exec part

	//import general functions
	require "functions.php";

	//conection to the database 
	$connectedDB  = connectToDB(); 

        //getting the files
	$fileOne = $_FILES["fileOne"];
        inputValidation($fileOne);        
        $file_result = $fileOne["name"];

	//get logged user id, email, and name from session
	session_start();
	$id = $_SESSION['id'];
	$email = $_SESSION['email'];
        $fName = $_SESSION['first_name'];
        $lName = $_SESSION['last_name'];
        session_write_close();
        
        //insert entry of file one in docs table and save into $idOne the id of the first entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$fileOne["name"]."','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idOne = $row['0'];
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$file_result.".results.txt','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idResult = $row['0'];
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "INSERT INTO rep_sequences (user_id, seq_uploaded_id, seq_result_id, date, time_stamp) VALUES ('".$id."','".$idOne."','".$idResult."','".date("Y/m/d")."','now()')";
	$resultID = pg_query($connectedDB, $sql);

	if(!move_uploaded_file($fileOne['tmp_name'], "../fileUploads/".$idOne)) throw new GeneralException('File 1 was not uploaded correctly.', 001);
	
        //excecuting php in different proccess or thread
	$call = $phpComp.' ../JavaProgram/excecuteJavaProgram.php '.$idOne.' '.$idResult.' '.$id.' '.$email.' '.$fName.' '.$lName.' '.$file_result.'.results.txt &';

        shell_exec($call);
  
	returnValue("ok.");
?>
