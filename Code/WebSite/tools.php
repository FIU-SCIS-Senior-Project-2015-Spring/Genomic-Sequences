<?php require('core/init.php');

define('BROWSE_FORM_NAME', 'data'); // stores the name of the form with data in the html page

if(!isLoggedIn()) redirect('index.php'); // kick user out if not logged in

$tool = new Tool; // create new tool model
$file = new File; // create new file model
$job = new Job; // create new job model
$validator = new Validator;

if(isset($_POST['do_clear_history'])) $job->clearHistory();

if(isset($_POST['do_delete'])) {
    $package = $_POST['files'];
    
    if(!isset($package)) redirect('tools.php', "You didn't select any files!", 'error');
    
    $files = array();
    
    foreach($package as $p) { $pieces = explode("|", $p); array_push($files, $pieces[0]); }
    foreach($files as $f) $file->deleteFile($f);
    
    redirect('tools.php', "The files selected were deleted!", 'success');
}

//---------------------------- USER CLICKS SUBMIT JOB BUTTON ---------------------------//

if(isset($_POST['do_job'])) { // contains info from the html form
    $tools = $_POST['tools'];
    $package = $_POST['files'];
    
    $files = array();
    $types = array();
    
    $arguments_single = $_POST['arguments_single'];
    $arguments_multiple = $_POST['arguments_multiple'];

    foreach($package as $p) {
        $pieces = explode("|", $p);
        
        array_push($files, $pieces[0]);
        $types[$pieces[0]] = $pieces[1];
    }
    
    if(!isset($tools)) redirect('tools.php', "You didn't select any tools!", 'error');
    if(!isset($files)) redirect('tools.php', "You didn't select any files!", 'error');
    
    $f_length = count($files);
    
    $job = new Job; // create new job model
    
    $message = 'Information about your submission:';
    
    foreach($tools as $t) {
        $tool_name = trim($tool->getNameByID($t));
        
        switch($t) {
            case 6: case 8:// Sort Sequences
                $ignore = array();
                
                for($i = 0 ; $i < $f_length ; $i++) if($types[$files[$i]] != TYPE_EXT) { array_push($ignore, $i); }
                $i_length = count($ignore);
                
                //if(($f_length - $i_length) < 1) { $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] requires at least one valid file selected!"; break; }
                
                $job_id = $job->submitJobMultiple($files, $t, NULL); //removed $ignore
                    
                if($job_id != 0) {
                    $message = $message . "<br />SUCCESS: Job [ " . $job_id . " ] using Tool [ " . $tool_name . " ] on the files selected";
                 
                    if($i_length > 0) $message = $message . ", with some files skipped.";
                }
                else $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] on the files selected";
                
                break;
            
            case 1: // Genome Signatures
                if(f_length < 2 && $t == 1) { $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] requires two or more valid files selected!"; break; }
                
                $job_id = $job->submitJobMultiple($files, $t);

                if($job_id != 0) $message = $message . "<br />SUCCESS: Job [ " . $job_id . " ] using Tool [ " . $tool_name . " ] on the files selected";
                else $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] on the files selected";
                break;
            
            case 2: case 4: // Repeated Sequences and Unique Sequences
                foreach($files as $f) {
                    $file_name = $file->getNameByID($f);
                    $job_id = $job->submitJobSingle($f, $t);
                    
                    if($job_id != 0) $message = $message . "<br />SUCCESS: Job [ " . $job_id . " ] using Tool [ " . $tool_name . " ] on File [ " . $file_name . "]";
                    else $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] on File [ " . $file_name . "]";
                }
                
                break;
            
            case 3: // Genome Probes
                $subfiles = explode("|", $arguments_multiple);
                $sf_length = count($subfiles);
                
                for($i = 0 ; $i < $sf_length ; $i++) if(ctype_space($subfiles[$i]) || $subfiles[$i] == "") unset($subfiles[$i]);    
                
                if(empty($subfiles)) $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] does not have any valid arguments!";
                else if(count($subfiles) != count($files)) $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] does not have the same number of arguments as files. Please check FAQ for more information.";
                else {         
                    for($i = 0 ; $i < $sf_length ; $i++) {
                        $subfile = trim($subfiles[$i]);
                        $subseq = explode(" ", $subfile);
                        $ss_length = count($subseq);
                        $f = $files[$i];

                        for($j = 0 ; $j < $ss_length ; $j++) if(ctype_space($subseq[$j]) || $subseq[$j] == "" || !ctype_alpha($subseq[$j])) unset($subseq[$j]);
                        
                        $subseq = array_unique($subseq);
                        
                        $args = "";
                        foreach($subseq as $s) $args .= strtolower($s) . " ";
                        
                        $file_name = $file->getNameByID($f);
                        $job_id = $job->submitJobSingle($f, $t, $args);

                        if($job_id != 0) $message = $message . "<br />SUCCESS: Job [ " . $job_id . " ] using Tool [ " . $tool_name . " ] on File [ " . $file_name . "]";
                        else $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] on File [ " . $file_name . "]";
                    }
                }
                
                break;
            
            case 5: // Extract Fasta/Fastq
                $subseq = explode(" ", $arguments_single);
                $length = count($subseq);
                
                $start = 1;
                $finish = 1;
                
                for($i = 0 ; $i < $length ; $i++) if(!is_numeric($subseq[$i]) || !$subseq[$i] > 0 || $subseq[$i] == "") unset($subseq[$i]);    
                
                if(empty($subseq)) $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] does not have any valid arguments!";
                else if(count($subseq) != count($files)) $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] does not have the same number of arguments as files. Please check FAQ for more information.";
                else {
                    $args = "";
                    foreach($subseq as $s) $args = $args . $s . " ";

					if(isset($_POST['ext_options'])) {
						$ext_option = $_POST['ext_options'];

						switch($ext_option) {
							case 1: break; // default $t is fine
							case 2: $finish = STEPS_EXT2SORT; break; // extract and sort
							case 3: $finish = STEPS_EXT2MAPS; break; // extract, sort, and map													
							default: // no option was selected
						}
					}

                    $job_id = $job->submitJobMultiple($files, $t, $args, NULL, $start, $finish);

                    if($job_id != 0) $message = $message . "<br />SUCCESS: Job [ " . $job_id . " ] using Tool [ " . $tool_name . " ] on the files selected";
                    else $message = $message . "<br />FAILURE: Tool [ " . $tool_name . " ] on the files selected";    
                }
                
                break;
            
            default:
                $message = $message . "<br />FAILURE: Unable to get tool type for [ " . $tool_name . " ]";
        }
    } 
  
    $message = $message . "<br /><br />An email will be send to you when any successful job is finished.";
  
    redirect('tools.php', $message, 'info');
}

//--------------------------- USER CLICKS SUBMIT FILE BUTTON ---------------------------//

if(isset($_POST['do_upload'])) {
    if(empty($_FILES[BROWSE_FORM_NAME]['name'])) redirect('tools.php', "You didn't select any files!", 'error');
    
    $_FILES[BROWSE_FORM_NAME]['name'] = str_replace(' ', '_', $_FILES[BROWSE_FORM_NAME]['name']);

    $name = uploadFileToServer(BROWSE_FORM_NAME);
    $file_id = $file->submitFile($name);
	
	if($file_id == 0) redirect('tools.php', 'Uh-oh. Something is not right. Please try again.', 'error');
	
	$job_id = $job->submitJobSingle($file_id, TOOL_VALIDATE);

	if($job_id != 0) redirect('tools.php', "Your file '" . $name . "' will be validated shortly. Please wait. We will send you an email when it's done!", 'info');
	else redirect('tools.php', 'Uh-oh. Something is not right. Please try again.', 'error');
}

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . TOOLS);

$template->tools = $tool->getAllTools();
$template->files = $file->getAllFiles();

$template->jobs = $job->getAllJobsCompleted(); // give view all jobs from user logged in

echo $template;					  