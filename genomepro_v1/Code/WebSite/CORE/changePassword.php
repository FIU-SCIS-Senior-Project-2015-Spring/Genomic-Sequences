<?php
        //change password

	//import general functions
	require "functions.php";
        
        //check input variables exist
	if(isEmpty(@$_POST['currentPassword']) || isEmpty(@$_POST['newPassword']) || isEmpty(@$_POST['newPasswordAgain'])) throw new GeneralException('white spaces are not allowed.', 012);
        
        //read variables from forget password user form and hash them
	$currentPassword     = md5($_POST['currentPassword']);
        $newPassword         = md5($_POST['newPassword']);
        $newPasswordAgain    = md5($_POST['newPasswordAgain']);
	
	//conection to the database 
	$connectedDB  = connectToDB();
        
        //get data from the user
        session_start();
        $email               = $_SESSION['email'];
        session_write_close();
        
        //get data to validate current password
	$sql = "SELECT password FROM users WHERE email = '".strtolower($email)."'";
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_row($userResource);
        
        //comparing current password
        $currentPasswordComparison = strcmp($currentPassword, $userResultData[0]);
        
        //comparing new passwords
        $newPasswordsComparison = strcmp($newPassword, $newPasswordAgain);
        
        if($currentPasswordComparison !== 0){
            throw new GeneralException('Your current password is incorrect.', 005); // password entered does not match current
        }
        else if($newPasswordsComparison !== 0){
            throw new GeneralException('Your new passwords do not match.', 006); // new passwords entered does not match each other
            
        }
        else{ // current and new passwords match 
            //create and excecute sql to change old password to new password
            $sql = "UPDATE users SET password='".$newPassword."' WHERE email = '".strtolower($email)."'";
            $newuserResource = pg_query($connectedDB, $sql);
            
            //if the query no was succeful return an exception
	    if (!$newuserResource) {
                throw new GeneralException('General Error.', 002);
	    }
            else{
                returnValue("ok.");
            }
            
        }
        
?>
        



