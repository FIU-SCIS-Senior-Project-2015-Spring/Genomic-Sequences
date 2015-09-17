<?php

function uploadFileToServer($form_name){
    // Check for errors
    if($_FILES[$form_name]['error'] > 0){
        redirect('tools.php', 'An error occured submitting your file. Please try again.', 'error');
    }

//    if(!getimagesize($_FILES[$form_name]['tmp_name'])){
//        redirect('tools.php', 'Error! Did you upload an image?', 'error');
//    }

    // Check filetype
    if($_FILES[$form_name]['type'] != 'text/plain'){
        redirect('tools.php', 'Unsupported filetype detected!', 'error');
    }

    // Check filesize
    if($_FILES[$form_name]['size'] > 500000){
        redirect('tools.php', 'File exceeded maximum upload size!', 'error');
    }
    
    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    
    $parts = pathinfo($_FILES[$form_name]["name"]);
    $name = $timestamp . '_' . $parts['filename'] . '.' . $parts['extension'];
    
    $username = $_SESSION['username'];
    
    if(file_exists(FILES_DIR . $username . '/' . $name)){
        redirect('tools.php', 'An error occured submitting your file. Please try again.', 'error');
    }
    
    $username = trim($username);

    // Upload file
    if(!move_uploaded_file($_FILES[$form_name]['tmp_name'], FILES_DIR . $username . '/' . $name)) {
         redirect('tools.php', 'umAn error occured submitting your file. Please try again.', 'error');
    }
    
    return $name;
}

function redirect($page = FALSE, $message = NULL, $message_type = NULL) {
	if(is_string($page)) {
		$location = $page;
	} else {
		$location = $_SERVER['SCRIPT_NAME']; // if we don't include a page, it'll redirect to current page
	}
	
	if($message != NULL) {
		$_SESSION['message'] = $message; // if there's a message, message can be accessed from any page
	}
	
	if($message_type != NULL) {
		$_SESSION['message_type'] = $message_type; // message type? error? success? etc.
	}
	
	header('Location: '.$location);
	
	exit;
}

function displayMessage() {
	if(!empty($_SESSION['message'])) {
		$message = $_SESSION['message'];
		
		if(!empty($_SESSION['message_type'])) {
			$message_type = $_SESSION['message_type'];
			
			if($message_type == 'error' ) {
				echo '<div class="alert alert-danger">' . $message . '</div>';
			} else {
				echo '<div class="alert alert-success">' . $message . '</div>';
			}
		}
		
		unset($_SESSION['message']);
		unset($_SESSION['message_type']);
	} else {
		echo '';
	}
}

function isLoggedIn() {
	if(isset($_SESSION['is_logged_in'])) {
		return true;
	} else {
		return false;
	}
}

function getUser() {
	$userArray = array();
	$userArray['user_id'] = $_SESSION['user_id'];
	$userArray['username'] = $_SESSION['username'];
	$userArray['name'] = $_SESSION['name'];
	
	return $userArray;
}

function sendEmail($sender_name, $sender_email, $receiver_name, $receiver_email, $subject, $body) {
    //SMTP needs accurate times, and the PHP time zone MUST be set
    //This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');

    require 'mailer/PHPMailerAutoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = EMAIL_USERNAME;

    //Password to use for SMTP authentication
    $mail->Password = EMAIL_PASSWORD;

    //Set who the message is to be sent from
    $mail->setFrom($sender_email, $sender_name);

    //Set an alternative reply-to address
    //$mail->addReplyTo('genomeprofiu@gmail.com', 'First Last');

    //Set who the message is to be sent to
    $mail->addAddress($receiver_email, $receiver_name);

    //Set the subject line
    $mail->Subject = $subject;
    
    $mail->Body = $body;

    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');

    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}