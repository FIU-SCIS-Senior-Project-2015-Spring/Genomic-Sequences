<?php  
        // to display the history of repeated sequences
 
	//import general functions
	require "functions.php";
        
	//conection to the database 
	$connectedDB  = connectToDB();
	
        //getting user logged in data
	session_start();
	$userData = $_SESSION;  
        session_write_close();

	//check input variables exist
	if(isEmpty(@$userData['id'])) die ("missing data.");	
	
	//read variables from login user form
	$id = $userData['id'];

        //get data to populate history table
	$sql = "
	SELECT doc_uploadedone.doc_name AS file1,
	       doc_uploadedone.id AS file1id,
	       doc_uploadedtwo.doc_name AS file2,
	       doc_uploadedtwo.id AS file2id,
               rep_sequences.processed
               FROM rep_sequences,
	       docs doc_uploadedone,
	       docs doc_uploadedtwo
	       WHERE rep_sequences.user_id = ".$id." AND doc_uploadedone.id = rep_sequences.seq_uploaded_id AND doc_uploadedtwo.id = rep_sequences.seq_result_id;";
	
	//perform query and get results
	$userResource = pg_query($connectedDB, $sql);
	$userResultData = pg_fetch_all($userResource); 
	
	if($userResultData == NULL)
	{
		throw new GeneralException('No Files has been found.', 002);
	}
	else 
	{ 	
		returnValue($userResultData);
	}

?>
