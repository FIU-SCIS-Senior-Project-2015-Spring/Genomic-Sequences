<?php

	//import general functions
	require "functions.php";

	//checking if user is logged in
	session_start();
	$userName = $_SESSION['user_name'];
	if( is_null($userName)){
		header('Location: http://localhost/GenomePro/index.php');
		exit();
	}

	//return sent to client	
	returnValue($userName);	
?>
