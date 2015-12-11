<?php 
        //delete user 
  
	//import general functions
	require "functions.php";
		
	//conection to the database 
	$connectedDB  = connectToDB();
	
	//check input variables exist
	if(isEmpty(@$_POST['id'])) die ("missing data.");	
	
	//read variables from register user form
	$id = $_POST['id'];

	//get SESION INFO and check that user exists
	session_start();
	$userData = $_SESSION;
        session_write_close();
	if( is_null($userData) ){
		header('Location: http://genomepro.cis.fiu.edu/index.php');
		exit();
	}

	$sql = "SELECT user_type FROM users WHERE id = ".$userData['id']*1;
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
	//if the user exist throw an exception
	if($userResultData == NULL)
	{
		throw new GeneralException('An error ocurred please log off and log back in.', 002);
	}
        
	//if user is not admin log off
	if($userResultData[0] !='Admin'){
		header('Location: http://genomepro.cis.fiu.edu/index.php');
		exit();
	}


	$sql ="DELETE FROM users WHERE id=".$id;

	//query to database
	$newuserResource = pg_query($connectedDB, $sql);

	//return added to the client
	returnValue("The user has been deleted.");
?>
