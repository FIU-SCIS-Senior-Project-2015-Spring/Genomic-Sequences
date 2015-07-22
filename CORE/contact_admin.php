<?php   
        //contact us in home page

	//import general functions
	require "functions.php";
	
	//check input variables exist	
	if(isEmpty(@$_POST['name'])) throw new GeneralException('Please enter your name.', 010);
        else if (isEmpty(@$_POST['from'])) throw new GeneralException('Please enter your email.', 011);
        else if (isEmpty(@$_POST['subject'])) throw new GeneralException('Please enter a subject.', 012);
        else if(isEmpty(@$_POST['msg'])) throw new GeneralException('Please enter a message.', 013);
            
	//read variables from register user form
        $name = $_POST['name'];
	$email = $_POST['from'];
	$subject = $_POST['subject'];
	$msg = $_POST['msg'];
        
        //send an email to the admin from the user, when upload to server needs to be changed
        emailAdmin($email, $name, $subject, $msg);
      
	//return sent to client	
	returnValue("sent.");
                            
?>
