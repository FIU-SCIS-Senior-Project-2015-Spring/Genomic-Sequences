<?php
        //change last name

	//import general functions
	require "functions.php";
        
        //check input variables exist
	if(isEmpty(@$_POST['newLastName'])) throw new GeneralException('Please enter your last name.', 009);
        
        //read variables from POST to get the new last name
	$newLastName = $_POST['newLastName'];
	
	//conection to the database 
	$connectedDB  = connectToDB();
        
        //get data from the user logged in
        session_start();
        $id = $_SESSION['id'];
        session_write_close();
        
        //get data to update last name
        $sql = "UPDATE users SET last_name='".$newLastName."' WHERE id=".$id;
	$userResource = pg_query($connectedDB, $sql);
	                    
        //if the query no was succeful return an exception
        if (!$userResource) {
            throw new GeneralException('General Error.', 002);
        }
        else{  // update the last name variable in current session
            session_start();
            $_SESSION['last_name'] = $newLastName;
            session_write_close();
            returnValue("ok.");
        }
?>

