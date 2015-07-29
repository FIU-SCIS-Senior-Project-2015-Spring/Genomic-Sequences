<?php 
    //checking if user is logged in
    session_start();
    if(is_null($_SESSION)){
        header('Location: http://genomepro.cis.fiu.edu/index.php');
        exit();
    }
    session_write_close();
?>
<!DOCTYPE html>
<html lang="en" ng-app="GenomePro">
<head>
	<title>Genome Pro</title>
    		<meta charset="utf-8">
    		<meta http-equiv="X-UA-Compatible" content="IE=edge, no-cache, no-store, must-revalidate">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		<script src="JSFiles/jquery-1.11.1.min.js"></script>
		<link href="StyleFiles/bootstrap.min.css" rel="stylesheet">
		<script src="JSFiles/angular-file-upload-shim.min.js"></script> 
		<script src="JSFiles/angular.min.js"></script>
		<script src="JSFiles/angular-route.js"></script>
		<script src="JSFiles/angular-file-upload.min.js"></script>
		<script src="JSFiles/adminControllers.js"></script>
</head>			
	
<body>
	<!--navigation bar-->
	<nav class="navbar navbar-inverse" ng-controller="ControllerNavbar">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>					
					<span class="icon-bar"></span>	
			  	</button>
			  	<a class="navbar-brand" href="#">Genome Pro</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					
					<li><a href="#/profile">Profile</a></li>
					<li><a href="#/admin">Administration</a></li>
					<li><a href="" ng-click="logOut()">Logout</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav><!--end of navigation bar-->

	<!--ng view-->
	<div id="main">
	        <div ng-view></div>
	</div>
	
	<!--alert-->
	<div class="modal fade" id="showAlert">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="showAlertTitle">title</h4>
				</div>
				<div class="modal-body">
					<p id="showAlertText">text</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->			
	
	<script src="JSFiles/bootstrap.js"></script>
</body>
</html>
