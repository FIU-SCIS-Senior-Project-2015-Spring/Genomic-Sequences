<?php  

        //admin
 
	//import general functions
	require "functions.php";

	//conection to the database 
	$connectedDB  = connectToDB();	

	session_start();
	$userData = $_SESSION;  
        session_write_close();

	//check input variables exist
	if(isEmpty(@$userData['email'])) die ("missing data.");	
	
	//read variables from login user form
	$email = $userData['email'];

	//get data to validate user	//user_type
	$sql = "SELECT id, email,user_type FROM users WHERE NOT email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_all($userResource); 
	
	if($userResultData == NULL)
	{
		throw new GeneralException('No Users where found.', 002);
	}
	else 
	{ 	
		returnValue($userResultData);
	}

?>
