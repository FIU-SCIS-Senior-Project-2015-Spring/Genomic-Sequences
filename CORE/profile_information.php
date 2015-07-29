<?php
	//import general functions
	require "functions.php";

	//checking if user is logged in
	session_start();
	$userData = $_SESSION;
        session_write_close();
	if( is_null($userData)){
		header('Location: http://genomepro.cis.fiu.edu/index.php');
		exit();
	}
	//return sent to client	
	returnValue($userData);	
?>
