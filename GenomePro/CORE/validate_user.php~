<?php  
//validate log in user
 
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
	if(isEmpty(@$_POST['email']) || isEmpty(@$_POST['password'])) die ("missing data.");	
	
	//read variables from login user form
	$email = $_POST['email'];
	$pass = md5($_POST['password']);
	
	
	//get data to validate user
	$sql = "SELECT password,email, id, first_name, last_name FROM users WHERE email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
	if($userResultData == NULL)
	{
		throw new GeneralException('Login or password incorrect.', 002);
	}
	else  //email present, checking password
	{ 
		//comparing password
		$passwordComparison = strcmp($pass, $userResultData[0]);
		if($passwordComparison !== 0){
			throw new GeneralException('Login or password incorrect.', 003);
		}
		else {
			//updating time logged in
			session_start();
			$_SESSION['time_logged_in'] = time();
			$firstName = (string) $userResultData[3];
			$userName = $firstName." ".(string) $userResultData[4];
			$userName = ucwords($userName);
			$_SESSION['user_name'] = $userName;
			
			returnValue("OK");
		}
	}

?>
