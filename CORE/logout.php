<?php   
        //logout 

	//import general functions
	require "functions.php";
	
	session_start();
	session_unset();    // freeing all variables
	session_destroy();  // destroying the session and redirecting the user to the main page
	returnValue("OK.");
?>
