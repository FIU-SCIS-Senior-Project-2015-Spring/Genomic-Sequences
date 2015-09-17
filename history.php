<?php require('core/init.php'); 

if(!isLoggedIn()) redirect('index.php'); // if user isn't logged in, return to index page.

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$job = new Job; // create new job model

$template = new Template(TEMPLATES_DIR . HISTORY); // create new view

$template->jobs = $job->getAllJobs(); // give view all jobs from user logged in

echo $template; // print view