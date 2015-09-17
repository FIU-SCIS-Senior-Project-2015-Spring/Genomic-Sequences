<?php require('core/init.php'); 

//--------------------------- USER CLICKS SEND MAIL BUTTON -----------------------------//

if(isset($_POST['do_contact'])) { // grab information from view (form)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $body = "FROM: $name\nSUBJECT: $subject\nEMAIL: $email\n--------------------\n$message\n";
    
    sendEmail($name, $email, EMAIL_NAME, EMAIL_WHEN_RECEIVING, EMAIL_CONTACT_SUBJECT, $body); 
    
    redirect('contact.php', 'Your message has been sent!', 'success');
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . CONTACT); // create new view

echo $template; // print view