<?php
/********************************************************************* 
Course     : CIS 4911 Senior Project
Professor  : Masoud Sadjadi 
Description: This is the class user where we are going to have the user
             functionalities
            
*********************************************************************/

/**
 * class user contains all user functionalities
 * example:
 * validate user login
 * retrieve password
 */
class USER
{
    /**
     * this function validates user for log in session
     */
    public static function validateUser()
    {
        session_start(); // getting variables
        $emailprovided  = $_SESSION['email'];
        $password       = $_SESSION['password'];
       
        require "databaseAPI.php";          // including the database API file to access corresponding functions
        $db = new DBAPI;  
        $connectedDB = $db->connectToDB();  // connecting to the database
        $userResult = $db->validateUserData($connectedDB, $emailprovided, $password);  // validating user email and password
        $db->processLogIn($userResult);    // if validation was successful proceed to log in
        
    }//eom
    
    
    /**
     * this function retrieves user password 
     */
    public static function retrievePassw()
    {
        session_start(); // getting variables
        $emailprovided  = $_SESSION['email'];
        
        require "databaseAPI.php";  // including the database API file to access corresponding functions
        $db = new DBAPI;
        $connectedDB = $db->connectToDB(); // connecting to the database
        $validatedResult = $db->validateUserEmail($connectedDB, $emailprovided);  //validate user's email
        
        if($validatedResult < 0){  // display errors if the user emails does not exist in db
            $db->forgotPasswError($validatedResult);
        }
        else {  // if the email exists in the db 
           
            $email = $validatedResult['email'];
            $userId = $validatedResult['id'];
            $name = $validatedResult['name'];
           
            $newPassword = $db->createNewPassword();  // create new password for user 
            $updatePassResult = $db->updatePassword($connectedDB, $newPassword, $userId); // update new password on DB
            $emailResult = $db->emailUserNewPassword($email, $newPassword, $name); // email user new password
            echo "<p> email result ".$emailResult."</p>";
            $db->processForgotPassw($newPassword, $updatePassResult, $emailResult, $email);  // notify user about errors 
        }   
    }//eom
      
}//eoc

?>


