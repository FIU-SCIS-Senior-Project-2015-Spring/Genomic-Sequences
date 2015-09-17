<?php include('includes/header.php'); ?>

<!--Here starts the page content main division-->
<div class="content">
	
	<?php if(!isLoggedIn()) : ?>
	
	<div class="slider">
		<div class="container">
			<div id="top" class="callbacks_container">
				<ul class="rslides" id="slider3">
					<li>
						<div class="slider-text">
							<h1>Locate Sequences</h1>
							<p>Find the sub-sequences that are repeated in a genome file, their respective locations and the distances.</p>
						</div>
					</li>
					<li>
						<div class="slider-text">
							<h1>Visualize Results</h1>
							<p>A graphical representation of the pattern of the repeated sub-sequences in a genome file.
								<br>
							</p>
						</div>
					</li>
					<li>
						<div class="slider-text">
							<h1>Validate Contents</h1>
							<p>Verify which type of data is contained in a genome file: DNA, RNA or Protein.
								<br>
								<br>
							</p>
						</div>
					</li>
				</ul>
			</div>
			<!--start of login form-->
			<div id="form">
				<div class="col-lg-4">
					<form role="form" method="post" action="index.php" class="form-signin" id="login-form">
						<input style="margin-bottom: 5px" name="username" type="username" placeholder="Username" class="form-control" required autofocus>
						<input name="password" type="password" placeholder="Password" class="form-control" required>
						<!--this is the forgot password link-->
						<label><a href="#home" class="forget">Forgot your password?</a></label>
						<button type="submit" name="do_login" class="btn btn-lg btn-primary btn-block">Log In</button>
						<a href="register.php" class="btn btn-lg btn-primary btn-block">Register</a>
					</form>
				</div>
			</div>
			<!--end of login form-->
		</div>
		<!--end of slider container-->
	</div>
	<!--end of slider-->
	
	<?php endif; ?>

	<!--start of services-->
	<div class="services-section" id="services">
		<div class="container">
			<h3>GenomePro at a Glance</h3>
			<div class="services-grids">
				<div class="col-md-6 service-leftgrid">
					<div class="service1">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>Finding Signatures</h4>
							<p>Creation of genome finger prints/signatures that are predictive and prognostic for specific biologic events or treatment outcomes.</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="service2">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>Comparison</h4>
							<p>Find Similarities in multiple genomes. Here goes more content we need to get from Robinson. Here goes more content we need to get from Robinson</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="service1">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>Preventive Health Care Measures</h4>
							<p>Identification of sources and types of bacteria or viruses that spread in hospital or community settings.</p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!--end of left grid-->
				<div class="col-md-6 service-rightgrid">
					<div class="service1">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>Cancer Risk Prediction And Assessment</h4>
							<p>Confirmation of the presence of either new primary lesions or metastatic disease in all solid tumors, aiding in staging of cancer and treatments strategies.</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="service2">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>Tracking Mutations</h4>
							<p>Tracking of HIV/TB mutational changes in patients, offering the possibility for new treatment paradigms.</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="service1">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>New Diseases Cure And Prevention</h4>
							<p>Creating genetic finger prints libraries of known bacteria, viruses, and tumors, which are currently cured with known treatments or medications, will allow us to search for those finger prints in other genomes and apply the known cures to new diseases. These finger prints can also be useful to identify the source of drug resistance.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<!--end of right grid-->
				<div class="clearfix"> </div>
			</div>
			<!--end of services-grids-->
		</div>
		<!--end of container-->
	</div>
	<!--end of services-->

	<!--start of testimonials-->
	<div class="testimonials-section">
		<div class="container">
			<h2>Testimonials</h2>
			<div class="testimonials-section-top">

			</div>
			<div class="top-testimonials-section">
				<h4>We have provided solutions for many profesionals. Don't wait get in touch!</h4>
				<p>Here goes just a few words to describe the audience</p>
			</div>
			<div class="testimonials-top-comments">
				<h3>What Professionals Say About GenomePro</h3>
				<div class="random">
					<div class="testimonials-text">
						<p>Nagaranja Prabakar<span>99/99/9999</span></p>
						<div class="clearfix"></div>
					</div>
					<div class="testimonials-comments">
						<div class="someone">
							<span class="glyphicon glyphicon-user user1" aria-hidden="true"></span>
						</div>
						<p class="someone-comment">Some wording</p>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="random random-comment">
					<div class="testimonials-text">
						<p>Jay Navlakha<span>99/99/9999</span></p>
						<div class="clearfix"></div>
					</div>
					<div class="comments-top-top top-comment">
						<div class="someone">
							<span class="glyphicon glyphicon-user user1" aria-hidden="true"></span>
						</div>
						<p class="someone-comment">Some wording</p>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="random">
					<div class="testimonials-text">
						<p>Masoud Sadjadi<span>99/99/9999</span></p>
						<div class="clearfix"></div>
					</div>
					<div class="testimonials-comments">
						<div class="someone">
							<span class="glyphicon glyphicon-user user1" aria-hidden="true"></span>
						</div>
						<p class="someone-comment">Some wording</p>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!--end of top comments-->
		</div>
		<!--end of container-->
	</div>
	<!--end of single-->
</div>
<!--end of content main division-->

<?php include('includes/footer.php'); ?>