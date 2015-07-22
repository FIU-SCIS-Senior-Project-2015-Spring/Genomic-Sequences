<?php
        // receiving two files from files controller to find genome differences
        
	//import general functions
	require "functions.php";

	//conection to the database 
	$connectedDB  = connectToDB(); 

        //getting the files
	$fileOne = $_FILES["fileOne"];
        inputValidation($fileOne);                    // validating the content of file 1
	$fileTwo = $_FILES["fileTwo"];
        inputValidation($fileTwo);                    // validating the content of file 2
        
        $file1_name = $fileOne["name"];               // getting the name of the first file
        $file2_name = $fileTwo["name"];               // getting the name of the second file
        $file1_sub = substr($fileOne["name"], 0, 5);  // get a portion of the name of the first file
        $file2_sub = substr($fileTwo["name"], 0, 5);  // get a portion of the name of the second file
        $file_result = $file1_sub.$file2_sub;

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
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$fileTwo["name"]."','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idTwo = $row['0'];
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "INSERT INTO docs (user_id, doc_name, date, time_stamp) VALUES ('".$id."','".$file_result.".results.txt','".date("Y/m/d")."','now()') RETURNING id";
	$resultID = pg_query($connectedDB, $sql);
	$row = pg_fetch_row($resultID); 
	$idResult = $row['0'];
        
        //insert entry of file two and save into $idTwo the id of the second entry
	$sql = "INSERT INTO find_differences (user_id, uploaded_id1, uploaded_id2, result_id, date, time_stamp) VALUES ('".$id."','".$idOne."','".$idTwo."','".$idResult."','".date("Y/m/d")."','now()')";
	$resultID = pg_query($connectedDB, $sql);
	
	//save in filesystem
	if(!move_uploaded_file($fileOne['tmp_name'], "../fileUploads/".$idOne)) throw new GeneralException('File 1 was not uploaded correctly.', 001);
	if(!move_uploaded_file($fileTwo['tmp_name'], "../fileUploads/".$idTwo)) throw new GeneralException('File 2 was not uploaded correctly.', 002);

  	//excecuting php in different proccess or thread
	$call = $phpComp.' ../CProgram/differencesCProgram.php '.$idOne.' '.$idTwo.' '.$idResult.' '.$id.' '.$email.' '.$fName.' '.$lName.' '.$file1_name.' '.$file2_name.' '.$file_result.'.results.txt &';        
        shell_exec($call);
     
	returnValue("ok.");
?>
