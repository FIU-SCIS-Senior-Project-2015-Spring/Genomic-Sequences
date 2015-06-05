<?php   
        //user contact admin in index.php

	//import general functions
	require "functions.php";
        require_once '/Applications/MAMP/htdocs/GenomePro/phpmailer/vendor/autoload.php';  // importing the phpmailer functionality
	
	//check input variables exist
	if(isEmpty(@$_POST['from']) || isEmpty(@$_POST['subject']) || isEmpty(@$_POST['msg'])) die ("missing data.");	
	
	//read variables from register user form
	$email = $_POST['from'];
	$subject = $_POST['subject'];
	$msg = $_POST['msg'];
	

	//send email to user for him to know that needs to activate its account
	//mail($adminEmail,"Email Contact from ".$from.", subject: ".$subject, $msg);
	
	//return sent to client	
	//returnValue("sent.");
        
       
        $from = 'yordan.alvarez30@gmail.com';
        $senderName = 'Yordan Alvarez';
        $to         = $email;       // destination
        $sub        = $subject;     // subject
        $message    = $msg;         // message
        

        // using gmail accounts for testing, we can change it once is on the server 
        $m = new PHPMailer;       // new php mailer object

        $m->isSMTP();             // telling phpmailer we want to use the smpt option
        $m->SMTPAuth = true;      // testing properties, for debuging

        $m->Host = 'smtp.gmail.com';                   // the smtp for gmail
        $m->Username = $from;                          // own user name 
        $m->Password = 'yordanalvarez30';              // password
        $m->SMTPSecure = 'ssl';                        // secure type
        $m->Port = 465;                                // port used

        $m->From = $from;                              // email sending from, will be genomepro.cis.fiu.edu
        $m->FromName = $senderName;                    // here will be GnomePro Team
        $m->addReplyTo($from, 'Reply address');        // method to reply to, here will be genomepro.cis.fiu.edu
        $m->addAddress($to, $senderName);              // send this to users email (To)

        $m->Subject = $sub;                            // email subject
        $m->Body = $message;                           // message of the email 
                                       

        if($m->send()) // email was successfully ACCEPTED for delivery
        {
            returnValue("sent.");
        }
               
?>
