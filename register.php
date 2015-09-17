<?php require('core/init.php');

if(!isLoggedIn()){
    $user = new User;
	$validator = new Validator;
	
    if(isset($_GET['serial'])) {
        $serial = $_GET['serial'];
        
        if($user->registerConfirm($serial)) {
            $oldmask = umask(0);
            mkdir(FILES_DIR . $data['username'], 0777);
            umask($oldmask);
            
            redirect('index.php', 'Great! You can now login with your credentials.', 'success');
        } else {
            redirect('index.php', 'The confirmation code expired or is invalid. Please register again.', 'error');
        }
        
    }
    
	if(isset($_POST['register'])) {	// check if submit button was pressed in register page
		$data = array();
		
		$data['name'] = $_POST['name'];
		$data['email'] = $_POST['email'];
		$data['username'] = $_POST['username'];
		$data['password'] = md5($_POST['password']);
		$data['password2'] = md5($_POST['password2']);
		
		$field_array = array('email', 'username', 'password', 'password2');
		
		if(!$validator->isRequired($field_array)) {
            redirect('register.php', 'Please fill in all the required fields!', 'error');
        }
        
        if(!$validator->isValidEmail($data['email'])) {
            redirect('register.php', 'Please use a valid email address!', 'error');
        }
        
        if(!$validator->passwordsMatch($data['password'], $data['password2'])) {
            redirect('register.php', 'Your passwords did not match!', 'error');
        }
        
        if($user->checkEmailExists($data['email'])) {
            redirect('register.php', 'The email entered is already registered.', 'error');
        }   
        
        if($user->checkUsernameExists($data['username'])) {
            redirect('register.php', 'The username is already taken.', 'error');
        }   
		
		if($user->registerCreate($data)) {
			redirect('index.php', 'Congratulations! Please check your email to confirm your account with the system.', 'success');
		} else {
			redirect('index.php', 'Something went wrong with the registration', 'error');
		}
	}

	/*
	*	Create Template(s)
	*/

	$template = new Template(TEMPLATES_DIR.REGISTER);

	/*
	*	Assign Variables	
	*/

	/*
	*	Display Template(s)
	*/

	echo $template;			
} else {
	redirect("index.php");
}	