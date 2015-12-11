<?php
        // this file will accept an input file from account controller and will pass that data to analyzeCprogram

	//import general functions
	require "functions.php";
        
	$file_an = $_FILES["file_an"];    // getting the file to be analyzed
        inputValidation($file_an);        // validating the content of the probes file
        $file_result = $file_an["name"];  // creating the file result 
        
        // Once we are here all data file validation has been approved
        
	//conection to the database 
	$connectedDB  = connectToDB();
        
        //get logged user id, email, and name from session
	session_start();
	$id = $_SESSION['id'];
	$email = $_SESSION['email'];
        $fName = $_SESSION['first_name'];
        $lName = $_SESSION['last_name'];
        session_write_close();
        
        //insert entry of file one in docs table and save into $idOne the id of the first entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$file_an["name"]."','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idOne = $row['0'];
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$file_result.".results.txt','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idResult = $row['0'];
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "INSERT INTO data_type (user_id, an_uploaded_id, an_result_id, date, time_stamp) VALUES ('".$id."','".$idOne."','".$idResult."','".date("Y/m/d")."','now()')";
	$resultID = pg_query($connectedDB, $sql);
         
        //save in filesystem
	if(!move_uploaded_file($file_an['tmp_name'], "../fileUploads/".$idOne)) throw new GeneralException('File to be analyzed was not uploaded correctly.', 001);
        
        //excecuting php in different proccess or thread
        $call = $phpComp.' ../CProgram/analyzeCProgram.php '.$idOne.' '.$idResult.' '.$id.' '.$email.' '.$fName.' '.$lName.' '.$file_an["name"].' '.$file_result.'.results.txt &';        
        shell_exec($call);
     
	returnValue("ok.".$call);

?>

