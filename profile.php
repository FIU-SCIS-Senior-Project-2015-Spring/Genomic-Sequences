<?php 
    /********************************************************************* 
    Course     : CIS 4911 Senior Project
    Professor  : Masoud Sadjadi 
    Description: This is the profile page of the web application where the users
                 will be able to manage their profile and upload data to be processed
                 by the application.
    *********************************************************************/

    //checking if the user is logged in
    session_start();
    $userName = $_SESSION['user_name'];
    if( is_null($userName)){
        header('Location: http://localhost/GnomePro/index.php');
        exit();
    }
?>

<html>
    <head>
        <!-- Here are the scripts for the functionality of the profile page -->
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>GnomePro</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/mainStyle.css">   
    </head>
    <body>
        <!-- this is the navigation bar on top of the page -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://localhost/GnomePro/">GnomePro</a>
                    <p class="navbar-text"> 
                        <span class="glyphicon glyphicon-user" aria-hidden="true">
 <?php
    // printing name of the log in user
    $name = $_SESSION['user_name'];
    echo $name;
 ?>
                        </span>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="#help">Help</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="core/logOut.php">Log Out</a></li>
                    </ul>
                </div>  <!-- nav-collapse -->
            </div>  <!-- nav-container -->
        </nav>  <!-- nav -->
        
        <!-- content of the user profile page, here will be added profile management and application usage -->
        <div class="welcome-section">
            <div class="row">
                <center>
                    <h3>Welcome to your profile page</h3>
 <?php
    // printing name of the log in user
    $name = $_SESSION['user_name'];
    echo $name;
 ?>                    
                    
                </center> 
            </div>
        </div>
        
        <!-- dna-image-section -->
        <div class="row">
            <div class="col-md-12">
                <center>
                    <img src="images/dna1.png" alt="dna-image" style="width:100%;height:330px;padding-top: 10px;">
                </center>  
            </div>
        </div>
        
        <!-- footer -section -->
        <div class="row">
            <div class="col-md-1"></div>
                <div class="col-md-10">
                        <p class="navbar-text pull-left">Computing and Information Sciences</p>
                        <p class="navbar-text pull-right"><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> 2009-2015 Florida International University</p>
                </div>
            <div class="col-md-1"></div> 
        </div>
        
        <!-- scripts required for java script-->
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        
    </body>
</html>

