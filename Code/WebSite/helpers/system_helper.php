<?php

function deleteAvatarFromServer($avatar) { unlink(AVATAR_DIR . $avatar); }

function uploadAvatarToServer($form_name) {
    if($_FILES[$form_name]['error'] > 0) redirect('profile.php', 'An error occured submitting your file. Please try again.', 'error');
    if(!getimagesize($_FILES[$form_name]['tmp_name'])) redirect('profile.php', 'Error! Did you upload an image?', 'error');
    if($_FILES[$form_name]['size'] > 1000000) redirect('profile.php', 'File exceeded maximum upload size!', 'error');

    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    $timestamp = date('YmdHi', $timestamp);
    
    $parts = pathinfo($_FILES[$form_name]["name"]);
    $name = $timestamp . '_' . $parts['filename'] . '.' . $parts['extension'];
    
    if(file_exists(AVATAR_DIR . $name)) redirect('profile.php', 'There was a problem with your request. Please try again after one minute.', 'error');
    if(!move_uploaded_file($_FILES[$form_name]['tmp_name'], AVATAR_DIR . $name)) redirect('profile.php', 'An error occured submitting your file. Please try again.', 'error');
    
    return $name;
}

function uploadFileToServer($form_name) {
    if($_FILES[$form_name]['error'] > 0) redirect('tools.php', 'An error occured submitting your file. Please try again.', 'error');
    if(!($_FILES[$form_name]['type'] == 'application/octet-stream' || $_FILES[$form_name]['type'] == 'text/plain')) redirect('tools.php', 'Unsupported filetype detected!', 'error');    
    
    $parts = pathinfo($_FILES[$form_name]["name"]);
    
    //if(!($parts['extension'] == 'txt' || $parts['extension'] == 'fa' || $parts['extension'] == 'dna' || $parts['extension'] == 'gbk' || $parts['extension'] == 'fastq')) redirect('tools.php', 'Unsupported filetype detected!', 'error');  

    $date = new DateTime();
    $timestamp = $date->getTimestamp();  
    $timestamp = date('YmdHi', $timestamp);
    
    $name = $timestamp . '_' . $parts['filename'] . '.' . $parts['extension'];
    $username = trim($_SESSION['username']);
    
    if(file_exists(FILES_DIR . $username . '/' . UPLOADS_DIR . $name)) redirect('tools.php', 'There was a problem with your request. Please try again after one minute.', 'error');
    if(!move_uploaded_file($_FILES[$form_name]['tmp_name'], FILES_DIR . $username . '/' . UPLOADS_DIR . $name)) redirect('tools.php', 'An error occured submitting your file. Please try again.', 'error');
    
    return $name;
}

function getSequences($name, $path) {
  $fp = fopen(SERVER_DIR . $path . $name, "r");
  
  $sequences = array();
  
  while(!feof($fp)) {
    $line = fgets($fp);
    $token = strtok($line, " ");
    if(ctype_alpha($token)) array_push($sequences, $token);
  }
  
  fclose($fp);
  
  return $sequences;
}
  
function createChart($name, $path, $seq_list) {
  $fp = fopen(SERVER_DIR . $path . $name, "r");

  $seq = 0;
  $max = count($seq_list);
  $header = "Sequences";
  $body = "";
  $comma = ",";

  while(!feof($fp)) {
    $line = fgets($fp);
    $token = strtok($line, " ");

    if($token == $seq_list[$seq]) {
      $token = strtok(" ");
      $header = $header . ',' . $seq_list[$seq] . '=' . $token;

      $token = strtok(" ");

      while($token != false) {
        if(is_numeric($token)){
          $body .= $token . $comma . ($seq + 1) . "\n"; 
        } 
        $token = strtok(" ");
      }

      $seq++;
      $comma .= ",";
      if($seq == $max) break;
    }
  } 

  fclose($fp);
  
  $header .= "\n" . $body;
  return $header;
}

function redirect($page = FALSE, $message = NULL, $message_type = NULL) {
	if(is_string($page)) $location = $page;
	else $location = $_SERVER['SCRIPT_NAME']; // if we don't include a page, it'll redirect to current page
	
	if($message != NULL) $_SESSION['message'] = $message; // if there's a message, message can be accessed from any page	
	if($message_type != NULL) $_SESSION['message_type'] = $message_type; // message type? error? success? etc.
	
	header('Location: '.$location);
	
	exit;
}

function displayMessage() {
	if(!empty($_SESSION['message'])) {
		$message = $_SESSION['message'];
		
		if(!empty($_SESSION['message_type'])) {
			$message_type = $_SESSION['message_type'];
			
			if($message_type == 'error') echo '<div class="alert alert-danger">' . $message . '</div>';
			else if($message_type == 'info') echo '<div class="alert alert-info">' . $message . '</div>';
			else echo '<div class="alert alert-success">' . $message . '</div>';
		}
		
		unset($_SESSION['message']);
		unset($_SESSION['message_type']);
	} else echo '';
}

function isLoggedIn() {
	if(!isset($_SESSION['is_logged_in'])) return false;

    return true;
}

function isAdmin() {
    if(isset($_SESSION['type'])) if($_SESSION['type'] == 2) return true;
    
    return false;
}

function getUser() {
	$userArray = array();
	$userArray['user_id'] = $_SESSION['user_id'];
	$userArray['username'] = $_SESSION['username'];
	$userArray['name'] = $_SESSION['name'];
	
	return $userArray;
}

function sendEmail($sender_name, $sender_email, $receiver_name, $receiver_email, $subject, $body) {
    date_default_timezone_set('Etc/UTC');

    require '/var/www/html/helpers/mailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;
    $mail->isSMTP();

    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = EMAIL_USERNAME;
    $mail->Password = EMAIL_PASSWORD;
    $mail->setFrom($sender_email, $sender_name);
    $mail->addAddress($receiver_email, $receiver_name);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if(!$mail->send()) echo "Mailer Error: " . $mail->ErrorInfo;
    else echo "Message sent!";
}

function crypt_apr1_md5($plainpasswd)
{
    $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
    $len = strlen($plainpasswd);
    $text = $plainpasswd.'$apr1$'.$salt;
    $bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
    
    for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
    for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd{0}; }
    
    $bin = pack("H32", md5($text));
    
    for($i = 0; $i < 1000; $i++) {
        $new = ($i & 1) ? $plainpasswd : $bin;
        if ($i % 3) $new .= $salt;
        if ($i % 7) $new .= $plainpasswd;
        $new .= ($i & 1) ? $bin : $plainpasswd;
        $bin = pack("H32", md5($new));
    }
    
    for ($i = 0; $i < 5; $i++) {
        $k = $i + 6;
        $j = $i + 12;
        if ($j == 16) $j = 5;
        $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
    }
    
    $tmp = chr(0).chr(0).$bin[11].$tmp;
    $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
    "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");

    return "$"."apr1"."$".$salt."$".$tmp;
}

function createFTP($username, $credentials) {
    mkdir(FILES_DIR . $username);
    copy(HELPERS_DIR . 'ftp/index.php', FILES_DIR . $username . '/index.php');
    mkdir(FILES_DIR . $username . '/uploads');
    mkdir(FILES_DIR . $username . '/results');
    
    $text = $credentials . "\n";
    
    $file = fopen(FILES_DIR . $username . "/.htpasswd", "w") or die("Unable to open file!");
    fwrite($file, $text); fclose($file);

    $text = 'AuthUserFile /var/www/html/delivery/' . $username . '/.htpasswd' . "\n"
    . 'AuthName "Enter your account credentials to access your files! Also, please make sure your username is all lowercase"' . "\n"
    . 'AuthType Basic' . "\n"
    . '<Limit GET POST>' . "\n"
    . 'require valid-user' . "\n"
    . '</Limit>' . "\n";

    $file = fopen(FILES_DIR . $username . "/.htaccess", "w") or die("Unable to open file!");
    fwrite($file, $text); fclose($file);
}
