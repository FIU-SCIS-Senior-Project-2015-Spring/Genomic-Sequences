<?php require('core/init.php');

if(isset($_POST['do_logout'])) {
	$user = new User;
	
	if($user->logout()) {
		redirect('index.php', 'You have successfully logged out', 'success');
	} else {
		redirect('index.php');
	}
}