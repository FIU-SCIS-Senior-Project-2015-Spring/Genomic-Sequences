<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo SITE_TITLE; ?></title>
		<link href="<?php echo BASE_DIR.TEMPLATES_DIR.'css/normalize.css' ?>" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo BASE_DIR.TEMPLATES_DIR.'css/style.css' ?>" rel="stylesheet" type="text/css" media="all" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Genome Data Processing" />
		<script src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/jquery-1.8.3.min.js' ?>"></script>
		<script type="application/x-javascript">
			addEventListener("load", function(){
				setTimeout(hideURLbar, 0);
			}, false);
			function hideURLbar(){
				window.scrollTo(0,1);
			}
		</script>
		<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/move-top.js' ?>"></script>
		<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/easing.js' ?>"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
				});
			});
		</script>
		<!---End of script for menu---->
		<!-- script for slider starts Here -->
		<script src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/responsiveslides.min.js' ?>"></script>
		<script>
			$(function () {
			$("#slider3").responsiveSlides({
			auto: true, pager:true, nav:false, speed: 500, namespace: "callbacks", before: function (){
				$('.events').append("<li>before event fired.</li>");
			}, after: function (){
				$('.events').append("<li>after event fired.</li>");
				}});
			});
		</script>
		<!--end script for slider -->
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

							<?php if(isLoggedIn()) : ?>
							
							<li><a href="tools.php">tools</a></li>
							<li><a href="history.php">history</a></li>
							<li>
								<form role="form" method="post" action="logout.php">
									<button name="do_logout" type="submit">Logout</button>
								</form>
							</li>
							
							<?php endif; ?>

						</ul>
					</div>
					 <!--script-nav-->
					 <script>
					 $("span.menu").click(function(){
						$(".top-menu ul").slideToggle("slow" , function(){
						});
					 });
					 </script>
					<div class="clearfix"></div>
				</div>
			</div><!--end of header-top-->
			<div class="nav-bottom"></div><!--whhite bar separating menu from front background-->
		</div><!--end of header-contact-->
		
		<?php displayMessage(); ?>