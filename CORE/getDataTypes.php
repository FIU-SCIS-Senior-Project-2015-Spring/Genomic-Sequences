<?php  
        // to display the history of analyze data type
 
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
               data_type.processed
               FROM data_type,
	       docs doc_uploadedone,
	       docs doc_uploadedtwo
	       WHERE data_type.user_id = ".$id." AND doc_uploadedone.id = data_type.an_uploaded_id AND doc_uploadedtwo.id = data_type.an_result_id;";
	
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
