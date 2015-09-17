<?php
    
        //user image upload

        //import general functions
        require "functions.php";
        
	//get logged user id from session to store the photo
	session_start();
	$id = $_SESSION['id'];
        session_write_close();
    
        //getting the image from controller
	$image = $_FILES["image"];
        
        //saving the image in filesystem
        if(!move_uploaded_file($image['tmp_name'], "../Images/".$id)) throw new GeneralException('Unable to upload image.', 001);

	returnValue("ok."); // if success return ok       
?>

