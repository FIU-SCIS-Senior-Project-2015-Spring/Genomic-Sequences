<?php  
        //to download the files
 
	//import general functions
	require "functions.php";
      
	if(isEmpty(@$_POST['fileName'])) die ("missing data.");	
        if(isEmpty(@$_POST['realName'])) die ("missing data.");
        
        $title = $_POST['fileName'];
        $realName = $_POST['realName'];
        
	session_start();
	$userData = $_SESSION;  
        session_write_close();	

        returnFile($title, $realName);
        
?>
