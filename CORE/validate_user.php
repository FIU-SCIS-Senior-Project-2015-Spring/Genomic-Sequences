<?php  
        //validate user
 
	//import general functions
	require "functions.php";
        //require "connectDB.php";
	
	//The information to connect to the database
	$host = "127.0.0.1";
	$user = "Dj_YAM";
	$pass = "djyaminthemix28";
	$db   = "genomepro";

	//conection to the database
	$connectedDB  = pg_connect("host=$host dbname=$db user=$user password=$pass") or die("Could not connect to server"); 
	
        
	//check input variables exist
	if(isEmpty(@$_POST['email']) || isEmpty(@$_POST['password'])) die ("missing data.");	
	
	//read variables from login user form
	$email = $_POST['email'];
	$pass = md5($_POST['password']);

        //$connectedDB = DBAPI::connectToDB();

	//get data to validate user
	$sql = "SELECT password, email, first_name, last_name FROM users WHERE email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
        //if email does not exist
	if($userResultData == NULL)
	{
		throw new GeneralException('We cannot find that email. Have you registered?.', 002);
	}
	else  //email present, checking password
	{ 
		//comparing password
		$passwordComparison = strcmp($pass, $userResultData[0]);
		if($passwordComparison !== 0){
			throw new GeneralException('Email or password incorrect.', 003);
		}
		else {  // email and password verified
			//updating time logged in
			session_start();
			$_SESSION['time_logged_in'] = time();
			$firstName = (string) $userResultData[2];
			$userName = $firstName." ".(string) $userResultData[3];
			$userName = ucwords($userName);
			$_SESSION['user_name'] = $userName;
			
			returnValue("OK.");
		}
	}

?>
