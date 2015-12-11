<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo SITE_TITLE; ?></title>
		<!--style sheet for html reset-->
		<link href="<?php echo BASE_DIR.TEMPLATES_DIR.'css/normalize.css' ?>" rel="stylesheet" type="text/css" media="all">
		<!--GenomePro main style sheet-->
		<link href="<?php echo BASE_DIR.TEMPLATES_DIR.'css/style.css' ?>" rel="stylesheet" type="text/css" media="all" />
		<!--Style sheet for multiselect boxes-->
		<link href="<?php echo BASE_DIR.TEMPLATES_DIR.'css/jquery-ui.css' ?>" rel="stylesheet" type="text/css" media="all" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Genome Data Processing" />
		<script src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/jquery-1.8.3.min.js' ?>"></script>
		<!--script for menu for smaller screens-->
		<script type="application/x-javascript">
		    addEventListener("load", function(){
		        setTimeout(hideURLbar, 0);
		    }, false);
		    function hideURLbar(){
		        window.scrollTo(0,1);
		    }
		</script>
		<!--this JS is for the arrow that points to top of each page-->
		<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/move-top.js' ?>"></script>
		<!--this JS works so that pages move to top at ease-->
		<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/easing.js' ?>"></script>
		<script type="text/javascript">
		    jQuery(document).ready(function($) {
		        $(".scroll").click(function(event){		
		            event.preventDefault();
		            $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
		        });
		    });
		</script>
		<!--script to fade out alert divs on every page-->
		<script>
			window.setTimeout(function() {
				$(".alert").fadeTo(30000, 30000).slideUp(500, function(){
				    $(this).remove();});
			}, 3000);
		</script>
	</head>
	<body>
		<div class="header-contact" id="home">
		    <div class="header-top">
		        <div class="container">
		            <div class="logotype">
		                <a href="index.php">Genome<span>Pro</span></a>
		            </div>
		            <div class="top-menu">
		                <span class="menu"><img src="<?php echo BASE_DIR.TEMPLATES_DIR.'images/nav.png'; ?>" alt=""/> </span>
		                <ul>
		                	<li><a href="index.php">home</a></li>
		                    <li><a href="about.php">about</a></li>
		                    <li><a href="contact.php">contact</a></li>
			                <!--if the user is logged in show all pages-->
	                    	<?php if(isLoggedIn()) : ?>
	                   			<li><a href="profile.php">profile</a></li>
	                    		<li><a href="tools.php">tools</a></li>
								<li><a href="charts.php">charts</a></li>
	                    		<li><a href="delivery/<?php echo $_SESSION['username']; ?>" target="_blank">FTP</a></li>
	                    	<?php endif; ?>
							<!--if the user is admin show admin tab-->
	                    	<?php if(isAdmin()) : ?>
	                    		<li><a href="<?php echo BASE_DIR . 'phppgadmin'; ?>">admin</a></li>
	                    	<?php endif; ?>
							<!--if user is logged in offer logout option-->
	                    	<?php if(isLoggedIn()) : ?>
	                    		<li>
	                        		<form role="form" method="post" action="logout.php">
	            						<div class="logout-submission">
	                            				<input class="logout" value="Logout" name="do_logout" type="submit">
	                           			</div>
	                        		</form>
	                    		</li>
	                    	<?php endif; ?>
	                	</ul>
	                	<!--if user is logged in show his user name-->
	                	<?php if(isLoggedIn()) : ?>
	                		<ul class="loggedin">
	                    		<li><label>Logged in as:</label>  <label style="text-transform:lowercase"><?php echo ucfirst($_SESSION['username']); ?></label></li>
	                		</ul>
	               		 <?php endif; ?>
	            	</div>
	                <!--script for navigation bar on smaller screens-->
	                <script>
	                   	$("span.menu").click(function(){
	                   		$(".top-menu ul").slideToggle("slow" , function(){
	                   		});
	                   	});
	                </script>
	            <div class="clearfix"></div>
	        	</div>
	    	</div><!--end of header-top-->
		</div><!--end of header-contact-->
	<!--the body tag is ended at the inluded footer for all pages-->
<!--the html tag is also ended at the included footer for all pages-->
<?php displayMessage(); ?>