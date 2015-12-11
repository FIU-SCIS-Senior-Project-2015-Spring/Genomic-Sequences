<?php	
/* ABOUT.PHP **********************************************************
*	File: 			about.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		This PHP script's purpose for now is simply to grab
*					the HTML corresponding to this page and displaying
*					it on the browser. This is done to follow the 
*					pattern with the other pages, and if future
*				    variables are needed to add here and change.
*
*	Requirements: 	init.php must be in the 'core' directory, as it
*					contains necessary imports as well as defined 
*					variables for this script to use. Check the file
*					to understand its contents if needed.
*
*					about.php must also exist, as it is the HTML 
*					that contains information about what to display
*					to the web browser.
**********************************************************************/
?>

<?php require('core/init.php'); // import variables and libraries

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . ABOUT); // create new view

echo $template;	// print view to browser