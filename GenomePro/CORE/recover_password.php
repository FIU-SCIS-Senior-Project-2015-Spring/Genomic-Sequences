<?php
//recoverd password in index.php

	//import general functions
	require "functions.php";

	//connecting to DB
	//$connectedDB = connectToDB();
	//connectToDB();
	
	//The information to connect to the database
	$host = "127.0.0.1";
	$user = "postgres";
	$pass = "1234";
	$db = "genomepro";

	//conection to the database
	$connectedDB  = pg_connect("host=$host dbname=$db user=$user password=$pass") or die("Could not connect to server"); 

	//check input variables exist
	if(isEmpty(@$_GET['email'])) die ("missing data.");	
	
	//read variables from login user form
	$email = $_GET['email'];

	//create new user inactive
	$sql = "SELECT password,email, id, first_name, last_name, ver_code FROM users WHERE email = '".strtolower($email)."'";
	$newuserResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
	//check if the result of data base query is empty
	if($userResultData == NULL)
	{
		throw new GeneralException('Email not found.', 002);
	}
	else  //email present, checking password
	{	
		//take the first 8 digit of the verification code and seved in $code for that to be the recover password	
		$code = substr($userResultData[5],0,8);

		//encrypt $code for next time
		$encode_code = md5($code);

		//create and excecute sql to change verification code and password
 		$sql = "UPDATE public.users SET password='".$encode_code."',ver_code='".md5($userResultData[5])."' WHERE email = '".strtolower($email)."'";
		$newuserResource = pg_query($connectedDB, $sql);
		
		//send email to user for him to know that needs to activate its account
		$msg = "A new password has been requested on FIU GenomePro Website. Your new password is: ".$code;
		mail($email,'New Password Request',$msg);

		//return sent to the client
		returnValue("Sent.");
	}
?>
