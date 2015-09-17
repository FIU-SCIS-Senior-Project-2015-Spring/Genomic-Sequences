<?php require('core/init.php');

define('BROWSE_FORM_NAME', 'data'); // stores the name of the form with data in the html page

if(!isLoggedIn()) redirect('index.php'); // kick user out if not logged in

$tool = new Tool; // create new tool model
$file = new File; // create new file model

//---------------------------- USER CLICKS SUBMIT JOB BUTTON ---------------------------//

if(isset($_POST['do_job'])) { // contains info from the html form
    $tool_id = $_POST['radio'];
    $file_id = $_POST['selector'];

    $job = new Job; // create new job model

    if($job->submitJob($tool_id, $file_id)) { // attempt to submit the job
        redirect('tools.php', 'Your job has been submitted!', 'success');
    } else {
        redirect('tools.php', 'Something went wrong with your submission.', 'error');
    }
}

//--------------------------- USER CLICKS SUBMIT FILE BUTTON ---------------------------//

if(isset($_POST['do_upload'])) {
    $name = uploadFileToServer(BROWSE_FORM_NAME);

    $result = $file->uploadFileToDatabase($name);

    if($result){
        redirect('tools.php', "Your file '" . $name . "' was uploaded successfully!", 'success');
    } else {
        redirect('tools.php', 'Uh-oh. Something is not right. Please try again.', 'error');
        //removeFileFromDatabase($file_name); -- unimplemented yet
    }
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . TOOLS);

$template->tools = $tool->getAllTools();
$template->files = $file->getAllFiles();

echo $template;					  