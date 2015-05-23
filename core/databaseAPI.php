<?php
/********************************************************************* 
Course     : CIS 4911 Senior Project
Professor  : Masoud Sadjadi 
Description: This is the class database API where we are going to have
             all database accesses and queries to validate and retrieve user
             input data
             
            
*********************************************************************/

/**
 * class Database API contains all database functionalities + user related
 * example:
 * validate user login data
 * process login
 * validate users emails
 * retrieve password
 * update password
 */
class DBAPI
{
    // static variables to access the database
    public static $host     ="localhost";
    public static $dbname   ="genomepro";
    public static $user     ="Dj_YAM";
    public static $password ="djyaminthemix28";

    /**
     * this function connects to the database
     */
    public static function connectToDB()
    {
        $host       = DBAPI::$host;
        $dbname     = DBAPI::$dbname;
        $user       = DBAPI::$user;
        $password   = DBAPI::$password;
        
        $connectedDB = pg_pconnect("dbname=".$dbname);
       
        return $connectedDB;
    }//eom
    
    
   /**
    * this function validates the user input data for login session
    */
    public static function validateUserData($connectedDB, $email, $password)
    {
        $ver_password = md5($password); // hashing the user password 
        
        // if the database connection fails or database is down we want to notify the user
        if($connectedDB == FALSE){
            return -1;
        }

        // performing a query to the database 
        $userResource = pg_query($connectedDB, "SELECT password, email, id, first_name, last_name FROM users WHERE email = '".strtolower($email)."'");
        $userResultData = pg_fetch_row($userResource); 

        // if the email not present in the database, user needs to register
        if($userResultData == NULL)
        {
            return -3;
        }
        else  // email present, checking password
        { 
            // comparing password, if the password is invalid notify the user that password/email is incorrect
            // let them figure out which one is wrong, this is better for security purposes
            $passwordComparison = strcmp($ver_password, $userResultData[0]);
            if($passwordComparison !== 0){
                return -2;
            }
            else { // if email and password match, user is valid proceed to profile page
                //updating time logged in
                session_start();
                $_SESSION['time_logged_in'] = time();
                $firstName = (string) $userResultData[3];
                $userName = $firstName." ".(string) $userResultData[4];
                $userName = ucwords($userName);
                $_SESSION['user_name'] = $userName;
                
                return 0;
            }
        }
    }//eom
    
    
     /**
     * this function process the login information and informs the user the different scenarios tested by
     * the system
     * As the following errors:
     * - database unavailable
     * - email/password invalid
     * - email not registered
     */
    public static function processLogIn($number)
    {
?>
        <div class="panel panel-primary"> <!-- this is a panel to display to the user information related to login -->
            <div class="panel-heading">
<?php
        if($number == 0) // successfull connection and valid email and password - redirect to users page
        {
            //redirecting user to their profile page
            $usersPage = "http://localhost/GnomePro/profile.php";
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$usersPage.'">';
        }
        else if($number == -1) // problems with database connection
        {
            echo "We're sorry, system is temporarily unavailable";
        }
        else if($number == -2) // email or password invalid
        {
            echo "That Email/Password combination is Invalid";   
        }
        else if( $number == -3) // email not registered
        {    
            echo  "We cannot find that email. Have you registered?";
        }
?>
            </div>
        </div>

<?php 
       }//eom
     
       
    /**
     * this function validates user email before sending him/her a new password
     */
    public static function validateUserEmail($connectedDB, $email)
    {
        // if the database connection fails or database is down we want to notify the user
        if($connectedDB == FALSE){
            return -1;
        }
        
        // performing a query to the database 
        $userResource = pg_query($connectedDB, "SELECT email, id , first_name, last_name FROM users WHERE email = '".strtolower($email)."'");
        $userResultData = pg_fetch_row($userResource);
        
        // if the email provided is not present in the database, user needs to register
        if($userResultData == NULL)
        {
            return -3;
        }
        else // the email exists in the database
        {
            $email = $userResultData[0]; // get the email
            $id = $userResultData[1];    // get the id
            //compiling full users name
            $name = $userResultData[2]." ".$userResultData[3];
            $name = ucwords($name);
            
            $result = array(       // creating and populating an array to return
                'email' => $email,
                'id' => $id,
                'name' => $name,
            );
            return $result;
        }
    }//eom
    
    
    /**
     * this function creates a new random password
     */
    public static function createNewPassword()
    {
        // generating a random password
        $generated_password = substr(md5(rand(999, 999999)), 0, 8);
        if($generated_password === FALSE){
            return FALSE; //error occur while attempting to create new password
        }
        return $generated_password;
    }//eom
    
    
    /**
     * this function change user's password on database to the new password created
     */
    public static function updatePassword($connectedDB, $passwordDesired, $userID)
    {
        // $result = pg_query($connectedDB,"UPDATE users SET password = '$passwordDesired', password_recover = 0 WHERE id = '".$userID."'");

        // creating query to set the new password  
        $query = "UPDATE users SET password = '".$passwordDesired."' WHERE id = '".$userID."'";
        $result = pg_query($connectedDB, $query); // querying the database
        if($result === FALSE){
            return FALSE;
        }
        return $result;
    }//eom
    
    
    /**
     * this function emails the user their new password
     */
    public static function emailUserNewPassword($email, $newPassword, $name)
    {    
        echo "<p> email:".$email." | newpassword:".$newPassword." | name:".$name."</p>";   
         
        $to         = $email;
        $subject    = 'Your password recovery';
        $message    = "Hello ".$name. ",\n\n";
        $message    = $message."Your new password is: ".$newPassword."\n\n";
        $message    = $message."-GnomePro Team";
//      $headers    = 'From: genomepro.cis.fiu.edu';
        $headers    = 'From: yordanusas@yahoo.com';
        
        $result = email($to,$subject, $message, $headers);
        echo "<p> result of sending email: ".$result."</p>";
        if($result) //mail was successfully ACCEPTED for delivery
        {
            return 0;
        }else //mail was REJECTED for delivery
        {
            return -1;
        }
    }//eom
    
    
    /**
     * this function informs the user about different errors scenarios that can occur while retrieving their
     * password
     */
    public static function processForgotPassw($newPassword, $updatePassResult, $emailResult, $email)
    {
?>
        <div class="panel panel-primary"> <!-- this is a panel to display to the user information related to login -->
            <div class="panel-heading">
<?php

        $errorFlag = FALSE;
        //processing errors
        if($newPassword === FALSE){ // problems creating a new password
            echo "Please contact adminstrator. ERROR 150";
            $errorFlag = true;
        }
        if($updatePassResult === FALSE){ // problems updating their new password in the db
            echo "Please contact administrator. ERROR 160";
            $errorFlag = true;
        }
        if($emailResult === FALSE){  // problems emailing them the new password
            echo "Please contact adminstrator. ERROR 170";
            $errorFlag = true;
        }
      
        if(!$errorFlag){  //sucessfully notification
            echo "about to cange email, original email".$email;
            //updating new email, creating a yalxxxxx@domain.com format
            $newEmail = $email;
            $atPosition = strpos($email, "@");// find pos of @ - strpos
            for($iter = 2; $iter < $atPosition; $iter++){
                $newEmail[$iter] = "x";
            }
            //notifying user
            echo "A new password has been sent to ".$newEmail;
        }
?>
            </div>
        </div>

<?php 
       }//eom
    
       
     /**
     * This function will display proper error that correspond to forgot password
     * As the following errors:
     *  -database unavailable
     *  -invalid email
     */
    public static function forgotPasswError($validatedEmailResult)
    {
?>
        <div class="panel panel-primary"> <!-- this is a panel to display to the user information related to login -->
            <div class="panel-heading">
<?php
        if($validatedEmailResult == -1) // problems with database connection
        {
            echo "We're sorry, system is temporarily unavailable";
        }
        else if( $validatedEmailResult == -3) // email not registered
        {    
            echo  "We cannot find that email. Have you registered?";
        }
        else  // any other error than can occur we want to handle it
        {
            echo "Please contact administrator, ERROR 101!";
        }
?>
            </div>
        </div>
<?php 
       }//eom   
   
    }//eoc
?>


