<?php
/********************************************************************* 
Course     : CIS 4911 Senior Project
Professor  : Masoud Sadjadi 
Description: This is the log out functionality
            
*********************************************************************/
    session_start();
    session_unset();    // freeing all variables
    session_destroy();  // destroying the session and redirecting the user to the main page
    header("Location: http://localhost/GnomePro/index.php");
    exit();
?>