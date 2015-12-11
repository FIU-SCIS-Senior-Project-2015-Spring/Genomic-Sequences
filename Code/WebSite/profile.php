<?php	
/* PROFILE.PHP ********************************************************
*	File: 			profile.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		This PHP script displays some of the user's info,
*					as well as provides the functionality to change
*					passwords or email. It also lets the user change
*					his name and his avatar as well. This page can
*					also provide the user with some information about
*					when he registered, jobs pending, and how many 
*					files he has submitted in total.
*
*	Requirements: 	init.php must be in the 'core' directory, as it
*					contains necessary imports as well as defined 
*					variables for this script to use. Check the file
*					to understand its contents if needed.
*
*					profile.php must also exist, as it is the HTML 
*					that contains information about what to display
*					to the web browser.
*
*					User.php is an essential model for this to work,
*					as it contains login and password-forgetting
*					instructions.
*
*					Job.php is also essential for pending jobs.
**********************************************************************/
?>

<?php require('core/init.php'); 

define('BROWSE_FORM_NAME', 'avatar');

if(!isLoggedIn()) redirect('index.php'); // user can't be logged in for this page

$user = new User;
$job = new Job;

if(isset($_POST['do_update'])) {
    $validator = new Validator;
    
    $user_id = $_SESSION['user_id'];
    $username = trim($_SESSION['username']);
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    
    $user_id = $_SESSION['user_id'];
    
    if($email != '') {
        if(!$validator->isValidEmail($email)) redirect('profile.php', 'Please submit a valid email!', 'error');
        if($user->checkEmailExists($email)) redirect('profile.php', 'That email is already registered.', 'error');
        if(!$user->beginModifyEmail($user_id, $username, $email)) redirect('index.php', 'There was a problem with your request. Please contact customer support for help', 'error');
        
        $user->logout();
        
        redirect('index.php', 'Your email has been changed successfully. Please confirm it through your new email.', 'success');
    }
    
    else if($password != '') {
        if(!$validator->isValidPassword($password)) redirect('profile.php', 'Password must consist of at least (1) lowercase letter, (1) uppercase letter, (1) number, and consist of 7-15 characters.', 'error');
        if(!$validator->passwordsMatch($password, $password2)) redirect('profile.php', 'Passwords do not match!', 'error');  
        if(!$user->changePassword($user_id, $password, $username)) redirect('profile.php', 'Something went wrong. Please try again', 'error');
        
        $user->logout();
        
        redirect('profile.php', 'Your password has been changed. Please login again.', 'success');                                                        
    }
    
    if($firstname != '') if(!$user->changeFirstName($user_id, $firstname)) redirect('profile.php', 'Unable to change first name', 'error');
    if($lastname != '') if(!$user->changeLastName($user_id, $lastname)) redirect('profile.php', 'Unable to change last name', 'error');
}

if(isset($_POST['do_upload'])) {
    if(empty($_FILES[BROWSE_FORM_NAME]['name'])) redirect('profile.php', "You didn't select any files!", 'error');
    
    $name = uploadAvatarToServer(BROWSE_FORM_NAME);
    $result = $user->uploadAvatarToDatabase($name);
    
    if($result) redirect('profile.php', "Your avatar was changed successfully!", 'success');
    else redirect('profile.php', 'Uh-oh. Something is not right. Please try again.', 'error');
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$profile = $user->getProfile();

if(!$profile) redirect('index.php', 'There was a problem accessing your profile. Please try again!', 'error');

$template = new Template(TEMPLATES_DIR . PROFILE); // create new view

$template->firstname = $profile->firstname;
$template->lastname = $profile->lastname;
$template->username = $profile->username;
$template->avatar = $profile->avatar;
$template->email = $profile->email;
$template->timestamp = $profile->timestamp;

$template->jobCount = $job->getJobCount();
$template->jobs = $job->getAllJobsPending();

echo $template;	// print view