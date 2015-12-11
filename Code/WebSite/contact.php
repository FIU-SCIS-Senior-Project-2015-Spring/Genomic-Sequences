<?php	
/* CONTACT.PHP ********************************************************
*	File: 			contact.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		This PHP script's purpose is to sent emails to 
*					GenomePro by registered or guest users. This is
*					helpful for users who have a concern they'd like
*					the developers to know. Its a very simple page 
*					that has only one action, which is the submit 
*					button on a form that contains the user's
*					information and message. As such, this isn't a
*					complicated controller.
*
*	Requirements: 	init.php must be in the 'core' directory, as it
*					contains necessary imports as well as defined 
*					variables for this script to use. Check the file
*					to understand its contents if needed.
*
*					contact.php must also exist, as it is the HTML 
*					that contains information about what to display
*					to the web browser.
*
*					PHPmailer should be installed somewhere and 
*					imported on the init.php since it is required
*					for sending emails. In this particular case,
*					we have a sendMail() function found within the
*					'system_helper.php' that imports the PHPMailer
*					mail functions. In other words, the system_helper
*					is a good requirement as any.
**********************************************************************/

require('core/init.php'); 

//--------------------------- USER CLICKS SEND MAIL BUTTON -----------------------------//

if(isset($_POST['do_contact'])) { // grab information from view (form)
    $name = $_POST['name'];				// name of the person sending the email
    $email = $_POST['email'];			// his or her email
    $subject = $_POST['subject']; // the subject given
    $message = $_POST['message']; // the message to be sent
    
    $validator = new Validator; // make sure email given is valid
    
    if(!$validator->isValidEmail($email)) redirect('contact.php', 'The email provided is invalid! Message was not sent', 'error');
    
    $body = "FROM: $name\nSUBJECT: $subject\nEMAIL: $email\n--------------------\n$message\n"; // message sent to GenomePro
    
    sendEmail($name, $email, EMAIL_NAME, EMAIL_WHEN_RECEIVING, EMAIL_CONTACT_SUBJECT, $body); // send email
    
    redirect('contact.php', 'Your message has been sent!', 'success'); // redirect to contact page
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . CONTACT); // create new view

echo $template; // print view
?>