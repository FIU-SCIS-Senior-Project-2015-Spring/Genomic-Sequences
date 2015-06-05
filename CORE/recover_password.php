<?php
        //recoverd password in index.php

	//import general functions
	require "functions.php";
	
	//The information to connect to the database
        $host = "127.0.0.1";
        $user = "Dj_YAM";
        $pass = "djyaminthemix28";
        $db   = "genomepro";

	//conect to the database
	$connectedDB  = pg_connect("host=$host dbname=$db user=$user password=$pass") or die("Could not connect to server"); 

	//check input variables exist
	if(isEmpty(@$_POST['email'])) die ("missing data.");	
	
	//read variables from forget password user form
	$email = $_POST['email'];

	//query the db
	$sql = "SELECT email, id, first_name, last_name FROM users WHERE email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
	//check if the email provided exist in db
	if($userResultData == NULL)
	{
		throw new GeneralException('We cannot find that email. Have you registered?.', 002);
	}
	else  //email present, proceed with forgot password
	{	
                $email = $userResultData[0]; // get the email
                //compiling full users name
                $name = $userResultData[2]." ".$userResultData[3];
                $name = ucwords($name);
                
		//generating a random hashed number for the new password
                $generated_password = substr(md5(rand(999, 999999)), 0, 8);

		//encrypt new password to update in the database
		$password = md5($generated_password);

		//create and excecute sql to change old password to new password
 		$sql = "UPDATE users SET password='".$password."' WHERE email = '".strtolower($email)."'";
		$newuserResource = pg_query($connectedDB, $sql);
		
		//send email to user with new password to login
                $msg = "Hello " .$name. ",\n\n";
                $msg = $msg."Your new password is: " .$generated_password."\n\n";
                $msg = $msg." -GenomePro Team";
		mail($email,'Your password recovery', $msg);

		//return sent to the client
		returnValue("Sent.");
	}
?>
