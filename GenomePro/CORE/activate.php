<?php
//When user activate account

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
	if(isEmpty(@$_GET['use'])) die ("missing data.");	
	
	//read variables from login user form
	$activation = $_GET['use'];

	//create sql to activate user
	$sql ="UPDATE public.users SET verified=1 WHERE ver_code='fb469d7ef430b0baf0cab6c436e70375'";

	//query to database
	$newuserResource = pg_query($connectedDB, $sql);

	//check for query succeful
	if (!$newuserResource) {

		//if not succeful create exception
                 throw new GeneralException('General Error.', 002);
	}
	
	//redirect to home because user is already active
	header('Location: http://localhost/GenomePro/index.php#/home/activated');
?>
