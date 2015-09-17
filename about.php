<?php require('core/init.php'); 

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . ABOUT); // create new view

echo $template;	// print view