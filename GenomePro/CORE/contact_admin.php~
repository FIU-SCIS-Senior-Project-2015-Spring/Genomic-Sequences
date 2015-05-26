<?php   
//when user contact admin in index.php

	//import general functions
	require "functions.php";
	
	//check input variables exist
	if(isEmpty(@$_POST['from']) || isEmpty(@$_POST['subject']) || isEmpty(@$_POST['msg'])) die ("missing data.");	
	
	//read variables from register user form
	$from = $_POST['from'];
	$subject = $_POST['subject'];
	$msg = $_POST['msg'];
	

	//send email to user for him to know that needs to activate its account
	mail($adminEmail,"Email Contact from ".$from.", subject: ".$subject,$msg);
	
	//return sent to client	
	returnValue("sent.");
?>
