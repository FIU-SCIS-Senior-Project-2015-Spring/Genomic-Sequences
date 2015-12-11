<?php include('includes/header.php'); ?>

<!--Here starts the page content main division-->
<div class="content" id="myindex">
	<?php if(!isLoggedIn()) : ?>
	<div class="slider">
		<div class="container">
			<div id="top" class="callbacks_container">
				<ul class="rslides" id="slider3">
					<li>
						<div class="slider-text">
							<h1>Locate Sequences</h1>
							<p>Find the repeated sub-sequences in a genome file, their respective locations and the distances.</p>
						</div>
					</li>
					<li>
						<div class="slider-text">
							<h1>Visualize Results</h1>
							<p>Obtain a graphic representation for the pattern of the repeated sub-sequences in a genome file.
								<br>
							</p>
						</div>
					</li>
					<li>
						<div class="slider-text">
							<h1>Validate Contents</h1>
							<p>Verify which type of data is contained in a genome file: DNA, RNA or Protein and organize them in folders.
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
						<!--this is the forgot password link which is open in a modal window-->
						<label class="pwd"><a style="cursor:pointer" onclick="openModal()" id="modal_open">Forgot Password?</a></label>
						<button type="submit" name="do_login" class="btn-lg btn-block">Login</button>
						<label class="register-tag"><a href="register.php" class="home-register">register</a></label>
					</form>
				</div>
			</div>
			<!--end of login form-->
		</div>
		<!--end of slider container-->
	</div>
	<!--end of slider-->
	
	<!--start of forget password form on modal form-->
	<div id="modal_wrapper">
		<div id="modal_window">
			<div id="modal_close">
				<a id="modal_close" href="#"><img style="float:right" src="<?php echo BASE_DIR.TEMPLATES_DIR.'images/close2.png' ?>" alt="" height="25" width="25" ></a>
			</div>
			<h4 >Reset Password Form</h4>
			<p>Please enter a valid registered email and we will send you a temporary password</p>
			<form id="modal_feedback" method="post" action="index.php" accept-charset="UTF-8">
				<p><label>Email Address<strong>*</strong><br>
				<input type="email" required title="Please enter a valid email address" size="48" name="email" value=""></label></p>
				<p><input type="submit" name="do_forget" value="Send Request"></p>
			</form>
		</div> <!-- #modal_window -->
	</div> <!-- #modal_wrapper -->
	<!--scrip necessary for the modal forgot password feature: Do not remove-->
	<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/feedback-modal-window.js' ?>"></script>
	<!--end of forget password form on modal form-->
	
	<?php endif; ?><!--this if in case user is logged in-->

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
							<p class="finding-signatures">Creation of genome fingerprints/signatures that are predictive and prognostic for specific biologic events or treatment outcomes.</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="service2">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>Comparison</h4>
							<p class="comparison-mutations">We offer our users the power to efficiently process genomic data files and to create results containing accurate information
							 about the differences, similarities, and the analytics between genome files</p>
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
							<p class="tracking-mutations">Tracking of HIV/TB mutational changes in patients, offering the possibility for new treatment paradigms.</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="service1">
						<div class="left-grid1">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</div>
						<div class="left-grid2">
							<h4>New Diseases Cure And Prevention</h4>
							<p>Creating genetic fingerprints libraries of known bacteria, viruses, and tumors, which are currently cured with known treatments or medications, which will allow us to search for those fingerprints in other genomes and apply the known cures to new diseases. These fingerprints can also be useful to identify the source of drug resistance.</p>
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
	<div class="testimonials-section-header" id="clients" >
        <h3>Our Audience</h3>
    </div>
    <!--clients this is the slider for the audice images-->
    <div class="scroll-slider">											 
        <div class="nbs-flexisel-container">
            <div class="nbs-flexisel-inner">
                <ul class="clientSlider nbs-flexisel-ul" style="left: -253.6px; display: block;margin-left:60px">					    					    					       
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/jackson.jpg'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/dimaggio.jpg'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/baptist.jpg'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/broward.png'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/cdc.png'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/united.png'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/miami.jpg'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/society.png'; ?>" alt=""></li>
                    <li><img src="<?php echo TEMPLATES_DIR . 'images/fiu2.png'; ?>" alt=""></li>
                </ul>
            </div>
        </div> 
        <div class="clear"> </div>      
    </div>			
    <div class="testimonials-section">
        <div class="container">
            <div class="testimonials-section-header" id="testimonials" >
                <h3>What Professionals Say About GenomePro</h3>
            </div>
            <div class="founder-grids">
                <div class="col-md-3 founder">
                    <a>
                        <img class="img-responsive" src="<?php echo TEMPLATES_DIR . 'images/michael2.jpg'; ?>" alt="">
                        <div class="caption">
                            <h3>Michael Robinson</h3>
                            <p>As founder of GenomePro my vision is to help professionals discover breakthroughs that takes humankind beyond new stages!</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-9 description">
                    <div class="course_demo">
                        <ul id="testimonialSlider">	
                            <li>
                                <div class="testimonial-text">
                                    <p>GenomePro offers empowerment for health professionals to track HIV/TB mutational changes in patients, offering the possibility for new treatment paradigms.</p>
                                </div>
                            </li>
                            <li>
                                <div class="testimonial-text">		
                                    <p>The ability to find similarities in multiple genomes is a tremendous tool offered by GenomePro. Not only are you able to visualize results with graphical comparison,
                                    	but you can also find out the presence of unique and/or repeated sub-sequences in your files to perform more efficient and robust analysis.</p>
                                </div>
                            </li>	
                            <li>
                                <div class="testimonial-text">
                                    <p>GenomePro aims to help professionals and gene hunters by offering unheard specific tools and methods for sequence alignment with a robust structured analysis method
                                    	that allows for predictions of undiscovered genes.</p>
                                </div>
                            </li>									    	  	       	   	  									    	  	       	   	    	
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!--end of content main division-->
<style>#myindex{min-height:800px}</style><!--style for when page is logged in-->

<!--here starts JS for sliders on the home page-->
<script src="<?php echo TEMPLATES_DIR . 'js/jquery.flexisel.js' ?>"></script>
<script>
    $(window).load(function() {
        $("#testimonialSlider").flexisel({
            visibleItems: 1, animationSpeed: 2500, autoPlay: true, autoPlaySpeed: 7000,
            pauseOnHover: true, enableResponsiveBreakpoints: true, responsiveBreakpoints:{ 
                portrait:{changePoint:480, visibleItems: 1}, 
                landscape:{changePoint:640, visibleItems: 1},
                tablet:{changePoint:768, visibleItems: 1}
        }});
    });
</script>
<script type="text/javascript">
    $(window).load(function(){
        $(".clientSlider").flexisel({
            visibleItems: 4, animationSpeed: 2500, autoPlay: true, autoPlaySpeed: 7000,            
            pauseOnHover: true, enableResponsiveBreakpoints: true, responsiveBreakpoints:{ 
                portrait:{changePoint:480, visibleItems: 1}, 
                landscape:{changePoint:640, visibleItems: 2},
                tablet:{changePoint:768, visibleItems: 3}
            }});
        });
</script>

<!-- script for slider starts Here -->
<script src="<?php echo TEMPLATES_DIR . 'js/responsiveslides.min.js' ?>"></script>
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



<?php include('includes/footer.php'); ?>