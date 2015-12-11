<?php include('includes/header.php'); ?>
		
<!--start of content main division-->
<div class="content" id="register">
	<div class="register">
		<h3>CREATE AN ACCOUNT</h3>
		<div class="register-form">
			<form method="post" action="register.php">
				<input name="username" type="text" placeholder="Username*" class="user">
				<input name="email" type="text" placeholder="Email*" class="email" >
				<input name="password" type="password" placeholder="Password*">
				<input name="password2" type="password" placeholder="Confirm Password*">
                <input type="text" placeholder="First Name" name="firstname">
                <input type="text" placeholder="Last Name" name="lastname">
			  	<div class="send-button">
			    	<input name="do_register" type="submit" value="Register" >
			  	</div>
			    <p>Already have an account?<a href="index.php">&nbsp;Log in</a></p>
			</form>
		</div>
	</div>
</div><!--end of content main division-->
		
<?php include('includes/footer.php'); ?>