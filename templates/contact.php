<?php include('includes/header.php'); ?>
		
		<!--start of content main division-->
		<div class="content">		
			<div class="contact-page" id="contact">
				<div class="container">
					<div class="contact-page-header">
						<h3>contact us</h3>
					</div>
					<div class="contact-page-grid">
						<div class="col-md-6 contact-details-grid">
							<h4>contact form</h4>
			           		<form method="post" action="contact.php">
								<h5>name <span>*</span></h5><input name="name" type="text">
								<h5>email address <span>*</span></h5><input name="email" type="text">
			           			<h5>subject <span>*</span></h5><input name="subject" type="text">
			           			<h5>message <span>*</span></h5><textarea name="message"></textarea>
			          			<input name="do_contact" type="submit" value="send">
							</form>
			  			</div>
			           	<div class="col-md-6 contact-details-grid1">
				           		<h4>Address</h4>
				           	    <p>Florida International University,</p>
							    <p>Modesto Campus - Miami</p>
							    <p>USA</p>
							   	<p>Phone:305.999.9999</p>
							   	<p>Fax: 305.888.8888</p>
							 	<p>Email: <a href="mailto:mmesq001@fiu.edu">mmesq001@fiu.edu</a></p>
						</div>
					</div>
					<div class="clearfix"> </div>
		   		</div>
		   	</div><!--end of contact-page-->
		   	
		   	<!--start of footer-section-->
			<div class="footer-section">
					<div class="footer-bottom">
							<p>Copyright &copy; 2015 <span>GenomePro</span>All rights reserved</p>
					</div>
			</div><!--end of footer-->
		</div><!--end of content main division--->
	</body>
</html>