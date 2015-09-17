<?php require('core/init.php');

//----------------------------- USER CLICKS LOGOUT BUTTON ------------------------------//

if(isset($_POST['do_logout'])) {
    $user = new User; // create new user model
    
    $user->logout(); // logout the user
}