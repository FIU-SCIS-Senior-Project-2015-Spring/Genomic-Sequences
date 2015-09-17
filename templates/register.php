<?php include('includes/header.php'); ?>
		
		<!--start of content main division-->
		<div class="content" id="register">
			<div class="register">
				<h3>CREATE AN ACCOUNT</h3>
				<div class="register-form">
					<form method="post" action="register.php">
						<input name="username" type="text" placeholder="Username*" class="user"/>
						<input name="email" type="text" placeholder="Email*" class="email" />
						
						<div class="col-md-6">
							<input name="password" type="password" placeholder="Password*" class="password"/>
						</div>
						<div class="col-md-6">
							<input name="password2" type="password" placeholder="Confirm Password*" class="confirm"/>
					  	</div>
						
						<input name="name" type="text" placeholder="Real Name" class="email" />
						
					  	<div class="send-button">
					    	<input name="register" type="submit" value="Register" />
					  	</div>
					    <p>Already have an account?<a href="index.php">&nbsp;Log in</a></p>
					</form>
				</div>
			</div>
		</div><!--end of content main division-->
		
<?php include('includes/footer.php'); ?>
