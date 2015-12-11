<?php include('includes/header.php'); ?>
<div class="content">		
	<div class="mycontent" id="myprofile" >
    	<div class="myprofile" >
			<div class="col-md-3 sidebar"  >
                <h1>Welcome</h1>
                <h5>
                    <?php 
                        if(($this->firstname != NULL) && ($this->lastname != NULL)) {
                            echo $this->firstname . ' ' . $this->lastname;
                        } else if ($this->firstname != NULL) {
                            echo $this->firstname;
                        } else {
                            echo ucfirst($this->username);
                        }
                    ?>
                </h5> 
                <img src="<?php echo AVATAR_DIR . $this->avatar; ?>" alt="" style="max-width:80%; max-height:80%">
                <form name="picform" method="post" action="profile.php" enctype="multipart/form-data">
                   	<input type="file" name="avatar" style="margin-top:15px;">
                   	<label class="btn-upload">
                   		<button class="btn" name="do_upload" type="submit">Upload Photo</button>
                   	</label>
                </form>
                <h4><span>Member Since: <span><?php echo timestampToDate($this->timestamp); ?></span></span></h4>
            	<h4>Jobs Submitted: <span><?php echo $this->jobCount; ?></span></h4>
            	<div class="clearfix"></div>
			</div>
        	<div class="col-md-9 rightside">
           	  	<div class="content">
           	  		<h3>Update Your Profile</h3>
                	<div class="update-profile">
	                    <div class="update-profile-form">
	                        <form action="profile.php" method="post">
	                            <input name="email" type="text" placeholder="<?php echo $this->email; ?>" class="email" />
	                            <input name="password" type="password" placeholder="Password" class="password"/>
	                            <input name="password2" type="password" placeholder="Confirm Password" class="confirm"/>
	                            <input name="firstname" type="text" placeholder="<?php if($this->firstname != NULL) echo $this->firstname; else echo 'First Name'; ?>" class="firstname"/>
	                            <input name="lastname" type="text" placeholder="<?php if($this->lastname != NULL) echo $this->lastname; else echo 'Last Name'; ?>" class="lastname"/>
	                            <input type="submit" value="Update" name="do_update" />
	                        </form>
	                    </div>
                	</div>
            	</div>	
				<div class="pending">
                	<h3>Pending Jobs</h3>
                	<?php if($jobs) : ?>
                	<div class="pending-jobs">
                    	<p>Bellow is a list of your jobs that have a pending status. </p>
                	</div>
                	<div class="pending-jobs-wrap">
                    	<table class="pending-jobs-table">
                        	<thead>
                            	<tr>
		                        	<th>Job</th>
		                            <th>Description</th>
		                            <th>Date</th>
		                            <th>Time</th>
                            	<tr>
                        	</thead>
                        	<tbody style="overflow:scroll">
                            	<?php foreach($jobs as $job) : ?>
                            		<tr>
		                            	<td><?php echo $job->job_id; ?></td>
		                                <td><?php echo $job->name; ?></td>
		                                <td><?php echo timestampToDate($job->timestamp); ?></td>
		                                <td><?php echo timestampToHour($job->timestamp); ?></td>		
                              		</tr>
                            	<?php endforeach; ?>
              					<?php else: ?>
                                <div class="pending-jobs">
                                   	<p>You have no pending jobs. Click on Tools to view your most recent completed jobs. </p>
                                </div>
                            	<?php endif; ?>
                        	</tbody>
                    	</table>
                	</div>
				</div>
         	</div>
    	</div>
	</div>
</div>

<?php include('includes/footer.php'); ?>