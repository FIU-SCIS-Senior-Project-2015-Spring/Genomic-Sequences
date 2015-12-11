<?php	
/* INDEX.PHP **********************************************************
*   File: 			index.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		This PHP script does a couple of things. One of 
*					them is to log the user in, as the user can only
*   				log in from the index page. Within this controller,
*					we also have functionality to change the user's
*					password. Like all other controllers, we also
*					grab the corresponding view and print it, although
*					we don't really instantiate any new variables 
*					within the template since we don't really need any.
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
*					as it contains login and password-forgetting
*					instructions.
**********************************************************************/
?>

<?php require('core/init.php');

$user = new User; // create new user model
$validator = new Validator;

//--------------------------- USER CLICKS FORGET PASS BUTTON ---------------------------//

if(isset($_POST['do_forget'])) { // form to forget password
    $email = $_POST['email']; // get email from form
    
    // check validity, then process the forget password sequence
    if(!$validator->isValidEmail($email)) redirect('index.php', 'Please enter a valid email!', 'error');
    if(!$user->forgotPassword($email)) redirect('index.php', 'We could not process your request. Make sure the email provided is correct!', 'error');

    redirect('index.php', 'Request processed! Please visit your email for your new password.', 'success');
}

//------------------------------ USER CLICKS LOGIN BUTTON ------------------------------//

if(isset($_POST['do_login'])) { // grab information from view (form)
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    switch($user->login($username, $password)) {
        case 0: // user gave incorrect credentials
            redirect('index.php', 'The credentials given are incorrect. Please try again.', 'error');
            break;
        case 1: // user hasn't confirmed his/her email yet
            redirect('index.php', 'Your account has yet to be confirmed! Check your email, or register again.', 'error');
            break;
        case 2: // user hasn't confirmed his/her email change yet
            redirect('index.php', 'An email confirmation is pending. Please check your email, or contact us for support.', 'error');
            break;
        case 3: // user logged in successfully
            redirect('index.php', 'You have successfully logged in!', 'success');
            break;
        default: //unknown problem
            redirect('index.php', 'Something went wrong. Please try again.', 'error');
    }
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . INDEX); // create new view

echo $template;	// print view