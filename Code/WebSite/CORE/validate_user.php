<?php  
        //validate user is used for log in, it checks who is logging in, user or admin
 
	//import general functions
	require "functions.php";
	
	//conection to the database 
	$connectedDB  = connectToDB(); 
	
	//check input variables exist
	if(isEmpty(@$_POST['email']) || isEmpty(@$_POST['password'])) die ("missing data.");	
	
	//read variables from logged in user 
	$email = $_POST['email'];
	$pass = md5($_POST['password']);
               
	//get data to validate user
	$sql = "SELECT password, email, first_name, last_name, user_type, id, verified FROM users WHERE email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource); 
	
        //if email does not exist
	if($userResultData == NULL)
	{
		throw new GeneralException('Email or password incorrect.', 002); // email is not in the system
	}
        elseif($userResultData[6] != 1) //user have not activated his/her account
        {
                throw new GeneralException('Please go to your email and verify your account.', 003); // email is not in the system
        }
	else  //email present, checking password
	{ 
		//comparing password
		$passwordComparison = strcmp($pass, $userResultData[0]);
		if($passwordComparison !== 0){
			throw new GeneralException('Email or password incorrect.', 004);
		}
		else {  // email and password verified
			//updating time logged in
			session_start();
			$_SESSION['time_logged_in'] = time();
			$_SESSION['first_name'] = $userResultData[2];
			$_SESSION['last_name'] = $userResultData[3];
			$_SESSION['email'] = $userResultData[1];
			$_SESSION['id'] = $userResultData[5];
                        session_write_close();
			
			if( $userResultData[4] == 'Admin')  //if user is admin
				returnValue("admin.php");
			else                                //if user is regular user
				returnValue("account.php");
		}
	}

?>
