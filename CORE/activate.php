<?php
        //user activate account

	//import general functions
	require "functions.php";

	 //conection to the database 
	$connectedDB  = connectToDB();

	//check input variables exist
	if(isEmpty(@$_GET['use'])) die ("missing data.");	
	
	//read variables from login user form
	$activation = $_GET['use'];

	//create sql to activate user
	$sql ="UPDATE users SET verified=1 WHERE ver_code='".$activation."'";

	//query to database
	$newuserResource = pg_query($connectedDB, $sql);

	//check for query success
	if (!$newuserResource) {

		//if not successful create exception
                 throw new GeneralException('General Error.', 002);
	}
	
	//redirect to home because user is already active
	header('Location: http://localhost/GenomePro/index.php#/home/activated');
?>
