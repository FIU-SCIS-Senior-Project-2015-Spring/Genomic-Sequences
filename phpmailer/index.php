<?php
require_once 'vendor/autoload.php';

// this is for use with gmail accounts, but you can use any other 
$m = new PHPMailer; // new php mailer object

$m->isSMTP();             // telling phpmailer we want to use the smpt option
$m->SMTPAuth = true;      // testing properties, for debuging
$m->SMTPDebug = 2;        // 1 for error codes, 2 for messages (displays)

$m->Host       = 'smtp.gmail.com';           // the smtp for gmail
$m->Username   = 'genomeprofiu@gmail.com';   // own user name 
$m->Password   = 'genomepro2015';            // password
$m->SMTPSecure = 'ssl';                      // secure type
$m->Port = 465;                              // port used

/*
$m->From = 'yordan.alvarez30@gmail.com';  // email sending from
$m->FromName = 'MySelf';                  
$m->addReplyTo('yordan.alvarez30@gmail.com', 'Reply address'); // method to reply to
$m->addAddress('yordan.alvarez30@gmail.com', 'Yordan Alvarez'); // send this to myself, can be used many times

$m->Subject = 'Here is an email';  // email proporties
$m->Body = 'This is the body';
$m->AltBody = 'This is the body';

// var_dump($m->send());  // will return true or false
if($m->send())
{
	echo 'Email sent';
}else{
	echo $m->ErrorInfo;
}
*/


