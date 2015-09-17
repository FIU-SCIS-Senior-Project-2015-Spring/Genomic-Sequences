<?php require('core/init.php');

//------------------------------ USER CLICKS LOGIN BUTTON ------------------------------//

if(isset($_POST['do_login'])) { // grab information from view (form)
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $user = new User;

    switch($user->login($username, $password)) {
        case 0: // user logged in successfully
            redirect('index.php', 'You have been logged in!', 'success');
            break;
        case 1: // user hasn't confirmed his/her email yet
            redirect('index.php', 'Your account has yet to be confirmed! Check your email, or register again.', 'error');
            break;
        case 2: // user gave incorrect credentials
            redirect('index.php', 'The credentials given are incorrect. Please try again.', 'error');
            break;
        default: //unknown problem
            redirect('index.php', 'Something went wrong. Please try again.', 'error');
    }
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . INDEX); // create new view

echo $template;	// print view