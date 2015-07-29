<?php 
        //register user 
  
	//import general functions
	require "functions.php";
		
	//conection to the database 
	$connectedDB  = connectToDB(); 
	
	//check input variables exist
	if(isEmpty(@$_POST['first_name']) || isEmpty(@$_POST['last_name']) || isEmpty(@$_POST['email'])|| isEmpty(@$_POST['password'])|| isEmpty(@$_POST['conf_password'])) die ("missing data.");	
	
	//read variables from register user form
	$name = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$email = $_POST['email'];
	$pass = md5($_POST['password']);
	$confpass = md5($_POST['conf_password']);
	$ver_code = md5($pass);

	//check if user exist
	$sql = "SELECT password, email, id, first_name, last_name FROM users WHERE email = '".strtolower($email)."'";
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
	$sql = "INSERT INTO users (user_type, first_name, last_name, email, password, verified, ver_code) VALUES ('Regular User','".$name."','".$lname."','".$email."','".$pass."',0,'".$ver_code."')";
	$newuserResource = pg_query($connectedDB, $sql);

	//if the query no was succeful return an exception
	if (!$newuserResource) {
                throw new GeneralException('General Error.', 002);
	}

	//send email to user for him to know that needs to activate its account
        $fullName = $name.' '.$lname;
        $fullName = ucwords($fullName);
        $subject = "New Account Creation";
	$msg = "Hello " .$fullName. ",\n\n";
        $msg = $msg."FIU genome pro has created an account for you. Click on the following link to activate the account:\n\n";
        $msg = $msg."http://genomepro.cis.fiu.edu/CORE/activate.php?use=".$ver_code."\n\n";
        $msg = $msg." -GenomePro Team";
	
        //send email to the user with php mailer, needs to be changed when upload to server
        email($email, $fullName, $subject, $msg);
        
	//return added to the client
	returnValue("Added.");
?>
