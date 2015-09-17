<?php require('core/init.php'); 

if(isset($_POST['do_contact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $body = "FROM: $name\nSUBJECT: $subject\nEMAIL: $email\n--------------------\n$message\n";
    
    sendEmail($name, $email, EMAIL_NAME, EMAIL_WHEN_RECEIVING, EMAIL_CONTACT_SUBJECT, $body); 
    
    redirect('contact.php', 'Your message has been sent!', 'success');
}

/*
*	Instantiate classes! (Model)
*/

/*
*	Instantiate templates! (View)
*/

$template = new Template(TEMPLATES_DIR.CONTACT);

/*
*	Pass information to the template.
*/


/*
*	Output the template.
*/

echo $template;					