<?php require('core/init.php'); 

/*
*	Instantiate classes! (Model)
*/

/*
*	Instantiate templates! (View)
*/

$template = new Template(TEMPLATES_DIR.ABOUT);

/*
*	Pass information to the template.
*/


/*
*	Output the template.
*/
echo $template;					