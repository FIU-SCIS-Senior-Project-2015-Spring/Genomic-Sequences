<?php	
/* LOGOUT.PHP *********************************************************
*	File: 			logout.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		All it does is log you out by unsetting SESSIONs.
*
*	Requirements: 	init.php must be in the 'core' directory, as it
*					contains necessary imports as well as defined 
*					variables for this script to use. Check the file
*					to understand its contents if needed.
*
*					index.php must also exist, as it is the HTML 
*					that contains information about what to display
*					to the web browser.
*
*					User.php is an essential model for this to work,
*					as it contains logout instructions.
**********************************************************************/
?>

<?php require('core/init.php');

//----------------------------- USER CLICKS LOGOUT BUTTON ------------------------------//

if(!isLoggedIn()) redirect('index.php'); // user can't be logged out for this page

if(isset($_POST['do_logout'])) {
    $user = new User; // create new user model
    
    $user->logout(); // logout the user
    
    redirect('index.php', 'You have successfully logged out.', 'success');
}