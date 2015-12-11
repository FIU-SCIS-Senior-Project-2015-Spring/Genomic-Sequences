<?php

    require "functions.php";

    //check if variable filename is sent from client
    if(isEmpty(@$_POST['fileName'])) die ("missing data.");	

    //read variables from register user form
    $name = $_POST['fileName'];

    //open the file
    $myfile = fopen("../fileUploads/".$name, "r") or die("Unable to open file!");

    //declare array
    $data = array();
    $data["name"] = array();
    $data["count"] = array();
    
    //initialize array counter
    $counter = 0;

    //fill the array with the information on the file
    while(!feof($myfile)) {
       $line = fgets($myfile);
       if($line===null) break;
       $pieces = explode(" ", $line);
       $data["name"][$counter] = $pieces[0];
       $data["count"][$counter] = $pieces[2]*1;
       $counter++;
    }
    fclose($myfile);

    //delete any empty spaces in the array name and count
    $data["name"] = array_filter($data["name"]);
    $data["count"] = array_filter($data["count"]);

    //return to client the data
    returnValue($data);

?>
