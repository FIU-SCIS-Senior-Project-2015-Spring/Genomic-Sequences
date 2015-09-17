<?php require('core/init.php');

define('BROWSE_FORM_NAME', 'data'); // the name of the 'browse' div that selects files in the HTML page

if(isLoggedIn()) {
    /*
	*	Instantiate classes! (Model)
	*/

	$tool = new Tool;
    $file = new File;
    
    if(isset($_POST['do_job'])) { 
        $tool_id = $_POST['radio'];       
        $file_id = $_POST['selector'];
      
        $job = new Job;
        
        if($job->submitJob($tool_id, $file_id)){
			redirect('tools.php', 'Your job has been submitted!', 'success');
		} else {
			redirect('tools.php', 'Something went wrong with your submission.', 'error');
		}
    }
    
    if(isset($_POST['do_upload'])) {
        $name = uploadFileToServer(BROWSE_FORM_NAME);
        
        $result = $file->uploadFileToDatabase($name);
        
        if($result){
            redirect('tools.php', "Your file '" . $name . "' was uploaded successfully!", 'success');
        } else {
            redirect('tools.php', 'Uh-oh. Something is not right. Please try again.', 'error');
            //removeFileFromDatabase($file_name);
        }
    }

	/*
	*	Instantiate templates! (View)
	*/

	$template = new Template(TEMPLATES_DIR.TOOLS);

	/*
	*	Pass information to the template.
	*/

	$template->tools = $tool->getAllTools();
    $template->files = $file->getAllFiles();

	/*
	*	Output the template.
	*/
	echo $template;					  
} else {
	redirect("index.php");
}