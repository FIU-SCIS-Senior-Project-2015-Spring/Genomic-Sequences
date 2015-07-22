<?php
        //change first name

	//import general functions
	require "functions.php";
        
        //check input variables exist
	if(isEmpty(@$_POST['newFirstName'])) throw new GeneralException('Please enter your name.', 008);
        
        //read variables from POST to get the new first name
	$newFirstName = $_POST['newFirstName'];
	
	//conection to the database 
	$connectedDB  = connectToDB();
        
        //get data from the user logged in
        session_start();
        $id = $_SESSION['id'];
        session_write_close();
        
        //get data to update first name
        $sql = "UPDATE users SET first_name='".$newFirstName."' WHERE id=".$id;
	$userResource = pg_query($connectedDB, $sql);
	                    
        //if the query no was succeful return an exception
        if (!$userResource) {
            throw new GeneralException('General Error.', 002);
        }
        else{  // update the first name variable in current session
            session_start();
            $_SESSION['first_name'] = $newFirstName;
            session_write_close();
            returnValue("ok.");
        }      
?>



