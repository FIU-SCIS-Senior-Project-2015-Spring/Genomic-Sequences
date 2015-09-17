<?php require('core/init.php');

if(isLoggedIn()) redirect('index.php'); // user can't be logged in for this page

$user = new User;
$validator = new Validator;

//------------------------- USER CLICKS EMAIL CONFIRMATION LINK ------------------------//

if(isset($_GET['serial'])) {
    $serial = $_GET['serial']; // get confirmation code from url

    if($user->registerConfirm($serial)) { // confirm user
        $oldmask = umask(0);
        mkdir(FILES_DIR . $data['username'], 0777); // create a personal user directory for files
        umask($oldmask);

        redirect('index.php', 'Great! You can now login with your credentials.', 'success');
    } else {
        redirect('index.php', 'The confirmation code expired or is invalid. Please register again.', 'error');
    }
}

//------------------------ USER CLICKS SUBMIT REGISTRATION BUTTON ----------------------//

if(isset($_POST['register'])) {
    $data = array(); // collect all of the html form information in an array

    $data['name'] = $_POST['name'];
    $data['email'] = $_POST['email'];
    $data['username'] = $_POST['username'];
    $data['password'] = md5($_POST['password']);
    $data['password2'] = md5($_POST['password2']);

    $field_array = array('email', 'username', 'password', 'password2');

    if(!$validator->isRequired($field_array)) { // make sure there are no blanks
        redirect('register.php', 'Please fill in all the required fields!', 'error');
    }

    if(!$validator->isValidEmail($data['email'])) { // make sure email is valid
        redirect('register.php', 'Please use a valid email address!', 'error');
    }

    if(!$validator->passwordsMatch($data['password'], $data['password2'])) { // check passwords match
        redirect('register.php', 'Your passwords did not match!', 'error');
    }

    if($user->checkEmailExists($data['email'])) { // check if another user with the same email exists
        redirect('register.php', 'The email entered is already registered.', 'error');
    }   

    if($user->checkUsernameExists($data['username'])) { // check for duplicate username
        redirect('register.php', 'The username is already taken.', 'error');
    }   

    if($user->registerCreate($data)) { // voila! add user to the database (user still needs to confirm though)
        redirect('index.php', 'Congratulations! Please check your email to confirm your account with the system.', 'success');
    } else {
        redirect('index.php', 'Something went wrong with the registration', 'error');
    }
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . REGISTER); // create new view

echo $template;	// print view