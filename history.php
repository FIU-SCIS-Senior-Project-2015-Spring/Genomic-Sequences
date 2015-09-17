<?php require('core/init.php'); 

if(isLoggedIn()) {
	/*
	*	Instantiate classes! (Model)
	*/
    
    $job = new Job;
    
	/*
	*	Instantiate templates! (View)
	*/

    $template = new Template(TEMPLATES_DIR.HISTORY);

	/*
	*	Pass information to the template.
	*/
    
    $template->jobs = $job->getAllJobs();
    
	/*
	*	Output the template.
	*/
	echo $template;						
} else {
	redirect('index.php');
}
