<?php 
    /********************************************************************* 
    Course     : CIS 4911 Senior Project
    Professor  : Masoud Sadjadi 
    Description: This is the index page of the web application where the users
                 will be able to log in to their profile page if they have one, if
                 they don't they can register in order to use the application. 
                 In addition the users will be able to retrieve their password
                 if they forget it.

    *********************************************************************/

    //checking if user is logged in
    session_start();
    $userName = $_SESSION['user_name'];
    if( !empty($userName) ){
        header("Location: http://localhost/GnomePro/profile.php");
        exit();
    }
?>

<html>
    <head>
        <!-- Here are the scripts for the functionality of the index page -->
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>GnomePro</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="css/mainStyle.css">
        <link rel="stylesheet" href="css/signin.css">
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
                </div>
                <div class="collapse navbar-collapse">
                  <ul class="nav navbar-nav pull-right">
                    <li><a href="#help">Help</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                  </ul>
                </div> 
            </div>
        </nav> 
        <!-- this is the signing section of the page -->
        <div class="row">
            <center>  
                <div class="col-md-1"></div>   <!-- Do Not delete, left blank Intentionally -->
                <div class="col-md-5">
                    <form class="form-signin" action="index.php" method ="POST" id="login-form" autocomplete="on">
                    <h2 class="form-signin-heading">Please log in</h2>
                        <input name= "email" type ="text" placeholder ="Email Address" class="form-control">
                        <input name= "password" type ="password" placeholder ="Password" class="form-control">

                            <!-- NEED TO IMPLEMENT THE BELOW FOR THE FORGET PASSWORD -->
                            <label>
                                <a href="javascript:;" class="forget" data-toggle="modal" data-target=".forget-modal">Forgot your password?</a>
                            </label>

                        <button type="submit" class="btn btn-lg btn-primary btn-block">Log In</button>
                   

                    <!-- Below is hidden, only shown when forgot password is clicked -->
                    <div class="modal fade forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Recovery password</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Type your email account</p>
                                    <input name="forgotPasswordEmail" type="forgotemail" id="recovery-email" class="form-control" autocomplete="off">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-custom">Recovery</button>
                                </div>
                            </div> <!-- /.modal-content -->
                        </div> <!-- /.modal-dialog -->
                    </div> <!-- /.modal fade -->
                 
                    </form> 
                </div> <!-- col-mid-5 -->
                
                <!-- this is the registration section -->
                <div class="col-md-5">
                    <form class="form-signin" action="registerUser.php">
                        <p id="registerParagraph">New to GnomePro?<br>Register now to get your own profile</p>
                        <button class="btn btn-lg btn-primary btn-block" id="registerbnt" type="submit">Register</button>
                    </form>
                </div>
                <div class="col-md-1"></div>  <!-- Do Not delete, left blank Intentionally  -->
            </center>
        </div> <!-- end of row-->
            
        <!-- message result to user from log in validation -->
        <div class="msg-box">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <center>
                
<?php   

    session_start(); //saving variables for current session
    require_once 'CORE/users.php';  // including the users.php file
    $user = new USER;               // creating a new instance of the class USER
    
    $forgotPasswordEmail = $_POST['forgotPasswordEmail']; // check if user forgot their password
    
    if( !empty($forgotPasswordEmail) ){  // if they did proceed to retrieving password process
        
        $_SESSION['email'] = $forgotPasswordEmail;
        $user->retrievePassw();
    }
    else  // otherwise the user is trying to log in, then proceed to the user validation process
    {
        $email      = $_POST['email'];
        $password   = $_POST['password'];

        //double checking required fields are filled
        if(!empty($email) && !empty($password))
        {
            $_SESSION['email']      = $email;   
            $_SESSION['password']   = $password;
            $result = $user->validateUser();
        }
    }
    
?> 
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
        
        <!-- dna-image-section -->
        <div class="row">
            <div class="col-md-12">
                <center>
                    <img src="images/dna1.png" alt="dna-image" style="width:100%;height:330px;padding-top: 30px;">
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