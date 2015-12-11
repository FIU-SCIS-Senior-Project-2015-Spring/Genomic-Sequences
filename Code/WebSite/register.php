<?php	
/* REGISTER.PHP **********************************************************
*   File: 			register.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		Register goodies. This page controls the taking
*                   of input from the register page and validates
*                   it. Also handles when a user comes to confirm 
*                   his/her email through the provided serial. Not
*                   much going on besides that.
*
*	Requirements: 	init.php must be in the 'core' directory, as it
*					contains necessary imports as well as defined 
*					variables for this script to use. Check the file
*					to understand its contents if needed.
*
*					register.php must also exist, as it is the HTML 
*					that contains information about what to display
*					to the web browser.
*
*					User.php is an essential model for this to work,
*					as it contains register and confirm logic.
**********************************************************************/
?>

<?php require('core/init.php');

if(isLoggedIn()) redirect('index.php'); // user can't be logged in for this page

$user = new User;
$validator = new Validator;

//------------------------- USER CLICKS EMAIL CONFIRMATION LINK ------------------------//

if(isset($_GET['serial'])) {
    $serial = $_GET['serial']; // get confirmation code from url
    
    $result = $user->getTypeAndIDBySerial($serial);
    if(!$result) redirect('index.php', 'Your account expired. Please register again.', 'error');
    
    $user_id = $result->user_id;
    $type = $result->type;
    
    if($type == 0) { // new user
        if(!$user->registerConfirm($serial)) redirect('index.php', 'The confirmation code expired or is invalid. Please register again.', 'error');

        redirect('index.php', 'Great! You can now login with your credentials.', 'success');
    } else if($type == 1) { // user changing email
        if(!$user->changeSerial($user_id, NULL)) redirect('index.php', 'Something went wrong. Contact us for support.', 'error');
        
        redirect('index.php', 'Great! You can now login with your credentials.', 'success');
    }
}

//------------------------ USER CLICKS SUBMIT REGISTRATION BUTTON ----------------------//

if(isset($_POST['do_register'])) {
    $data = array(); // collect all of the html form information in an array

    $data['firstname'] = $_POST['firstname'];
    $data['lastname'] = $_POST['lastname'];
    $data['email'] = strtolower($_POST['email']);
    $data['username'] = strtolower($_POST['username']);
    $data['password'] = $_POST['password'];
    $data['password2'] = $_POST['password2'];
    
    if($data['firstname'] == "") $data['firstname'] = NULL;
    if($data['lastname'] == "") $data['lastname'] = NULL;

    $field_array = array('email', 'username', 'password', 'password2');

    if(!$validator->isRequired($field_array)) redirect('register.php', 'Please fill in all the required fields!', 'error');
    if(!$validator->isValidUsername($data['username'])) redirect('register.php', 'Usernames can only consist of letters and numbers and must be at least (3) letters long.', 'error');
    if(!$validator->isValidEmail($data['email'])) redirect('register.php', 'Please use a valid email address!', 'error');
    if(!$validator->isValidPassword($data['password'])) redirect('register.php', 'Password must consist of at least (1) lowercase letter, (1) uppercase letter, (1) number, and consist of 7-15 characters.', 'error');
    if(!$validator->passwordsMatch($data['password'], $data['password2'])) redirect('register.php', 'Your passwords did not match!', 'error');
    if($user->checkEmailExists($data['email'])) redirect('register.php', 'The email entered is already registered.', 'error');
    if($user->checkUsernameExists($data['username'])) redirect('register.php', 'The username is already taken.', 'error');  

    if($user->registerCreate($data)) redirect('index.php', 'Congratulations! Please check your email to confirm your account with the system.', 'success');
    else redirect('index.php', 'Something went wrong with the registration', 'error');
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . REGISTER); // create new view

echo $template;	// print view