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
	<link href="StyleFiles/mainStyle.css" rel="stylesheet">
	<link href="StyleFiles/signin.css" rel="stylesheet">
	<script src="JSFiles/angular-file-upload-shim.min.js"></script> 
	<script src="JSFiles/angular.min.js"></script>
	<script src="JSFiles/angular-route.js"></script>
	<script src="JSFiles/angular-file-upload.min.js"></script>
	<script src="JSFiles/indexControllers.js"></script>
</head>			
	
<body>
	<!--navigation bar-->
	<nav class="navbar navbar-inverse"  ng-controller="ControllerNavbar">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Genome Pro</a>
			</div>

			<!-- Collect the navigation links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#/home">Home</a></li>
					<li><a href="#/home">Help</a></li>
					<li><a href="#/home">About</a></li>
					<li><a href="#/contact">Contact</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav><!--end of navigation bar-->

	<!--all pages will be thrown here-->
	<div id="main">
	        <div ng-view></div>
	</div>
	
	<!-- dna-image-section -->
	<div class="row">
		<div class="col-md-12">
			<center>
				<img src="Images/dna1.png" alt="dna-image" style="width:100%;height:330px;padding-top: 30px;">
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
			
	<!-- to display alert to the users -->
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
