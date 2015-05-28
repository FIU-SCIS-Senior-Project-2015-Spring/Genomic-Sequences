<?php 
// register user in index.php
  
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
	if(isEmpty(@$_POST['first_name']) || isEmpty(@$_POST['last_name']) || isEmpty(@$_POST['email'])|| isEmpty(@$_POST['password'])||isEmpty(@$_POST['conf_password'])) die ("missing data.");	
	
	//read variables from register user form
	$name = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$email = $_POST['email'];
	$pass = md5($_POST['password']);
	$confpass = md5($_POST['conf_password']);
	$ver_code = md5($pass);

	//check if user exist
	$sql = "SELECT password,email, id, first_name, last_name FROM users WHERE email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
	//if the user exist throw an exception
	if($userResultData != NULL)
	{
		throw new GeneralException('A user with that email already exist.', 002);
	}

	
	//compare passwords to know they match
	$passwordComparison = strcmp($pass, $confpass);
	if($passwordComparison !== 0){
		throw new GeneralException('Password and Password Confirmation do not match.', 001);
	}

	//create new user inactive
	$sql = "INSERT INTO public.users (user_type, first_name, last_name, email, password, verified, ver_code) VALUES ('Regular User','".$name."','".$lname."','".$email."','".$pass."',0,'".$ver_code."')";
	$newuserResource = pg_query($connectedDB, $sql);

	//if the query no was succeful return an exception
	if (!$newuserResource) {
                 throw new GeneralException('General Error.', 002);
	}

	//send email to user for him to know that needs to activate its account
	$msg = "FIU genome pro has created an account for you. Click on the following link to activate the account: http://localhost/GenomePro/CORE/activate.php?use=".$ver_code;
	mail($email,"New Account Creation",$msg);
	
	//return added to the client
	returnValue("Added.");
?>
