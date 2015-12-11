<!--include the header-->
<?php include('includes/header.php'); ?>	

<!--start of content main division for the tools page-->
<div class="content" id="tools">
	<!--container for left and right columns-->
  	<div class="container">
    	<!--start of left-column-->
    	<div class="col-md-6">
    		<!--upload files section-->
	      	<div class="tools-desk upload-files">
	        	<h2>Upload Files To Your Account</h2>
	        	<form class="tools-forms" id="form0" name="form0" action="tools.php" method="post" enctype="multipart/form-data">
	          		<div class="test1">
		            	<input type="file" name="data" id="0" single>
		            	<input type="submit" value="Upload" name="do_upload" id="1">
		            	<input type="reset" value="Clear" id="2">
	          		</div>
		        </form>
			</div><!--end of upload files section-->
      		
      		<!--start of job history-->
		    <div class="tools-desk job-history">
	        	<h2>Job History</h2>
	      	</div>
	      	<div class="history">
	        	<div class="tips" id="tips">
	          		<p>Tip: click on any JOB ID to View Results | click on any header for sorting<p>				
	        	</div>
	        	<table id="myTable" class="tablesorter" >
		          	<thead>
			            <tr>
			            	<th >JOB ID</th>
			              	<th >DESCRIPTION</th>
			              	<th >DATE</th>
			              	<th >TIME</th>
			            </tr>
		          	</thead>
		          	<tbody>
			            <?php if($jobs) : ?>
				            <?php foreach($jobs as $job) : ?>
					            <tr>
				              		<td><a href="<?php echo trim($job->results); ?>" target="_blank"><?php echo $job->job_id; ?></a></td>
				              		<td><a href="<?php echo trim($job->results); ?>" target="_blank"><?php echo trim($job->name); ?></a></td>
				              		<td><a href="<?php echo trim($job->results); ?>" target="_blank"><?php echo timestampToDate($job->timestamp); ?></a></td>
				              		<td><a href="<?php echo trim($job->results); ?>" target="_blank"><?php echo timestampToHour($job->timestamp); ?></a></td>
					            </tr>
				            <?php endforeach; ?>
			            <?php else : ?>
				            <tr>
				            	<td>There are no jobs submitted!</td>
	              				<td></td>
	              				<td></td>
	              				<td></td>
	            			</tr>          
	            		<?php endif ?>
	          		</tbody>
	          		<tfoot>
	          			<tr>
	          				<td>
	          					<form method="post" action="tools.php">
	            					<div class="job-submission">
	             						<input class="clearTable" type="submit" value="Clear Job History" name="do_clear_history" >
	            					</div>
	        					</form>
	          				</td>  	
	          			</tr>
	          		</tfoot>
	        	</table>
	      	</div><!--end of job history-->
    	</div><!--end of left-column-->
	    
	    <!--start of right-column-->
		<div class="col-md-6">
    		<!--start of main form for jos submission-->
			<form id="job-submission" method="post" action="tools.php">	
       			<!--start of tools selection-->
	       		<div class="tools-desk select-tools">
         			<h2>Select a GenomePro Tool</h2>
        		</div>
				<div class="tools-selector">
       			<!--start php scrip for tools-->  
        			<?php 
				    	if($tools)
						{  
					    	$total = count($tools); 
					        $half = ceil($total / 2);
					        echo '<div class="col-md-6">';
					        for($i = 0 ; $i < $half ; $i++)
					        {
					        	echo '<div class="check" >' . '<label class="checkbox"><input type="checkbox" value="' . $tools[$i]->tool_id . '" name="tools[]" '; 
					           	if($tools[$i]->tool_id == 5) echo 'id="extract-fasta"';
						        if($tools[$i]->tool_id == 3) echo 'id="probes"';
						        echo ' ><i> </i><p style="margin-left:25px">' . trim($tools[$i]->name) . '</p></label>';
				            	echo '</div>';
				            }
	            			echo '</div><div class="col-md-6">';
	            			for($i = $half ; $i < $total ; $i++)
	            			{
	              				echo '<div class="check" >' . '<label class="checkbox"><input type="checkbox" value="' . $tools[$i]->tool_id . '" name="tools[]" '; 
	              				if($tools[$i]->tool_id == 5) echo ' id="extract-fasta"';
	              				if($tools[$i]->tool_id == 3) echo ' id="probes"';
	              				echo ' ><i> </i><p style="margin-left:25px">' . trim($tools[$i]->name) . '</p></label>';
	              				echo '</div>';
	            			}
	            			echo '</div>';
						}
	          			else
	          				echo 'There are currently no tools to show. :(';
					?><!--end php script for tools-->
		        </div><!--end of tools selection-->
        		
		        <!--start of files selection-->
		        <div class="tools-desk select-files" style="margin-bottom:15px; width:100%">
		        	<h2>Select Files From your Account</h2>
		       	</div>
				<div id="file-type">
		        	<ul class="choice-list">
		           		<li class="pick-choice"  role="tab"><span>DNA</span></li>
				         <li class="pick-choice"  role="tab"><span>RNA</span></li>
				         <li class="pick-choice"  role="tab"><span>PROTEIN</span></li>
				         <li class="pick-choice"  role="tab"><span>MAPS</span></li>
		        	</ul>
		        	<!--Start of Tab choices for file selection-->
		        	<div class="choice-list-container">
				        <!--DNA TAB-->
				        <div class="choice-list-content">
				        	<div class="choice-fields">
				            <!--file types choices-->
					            <div class="placeholders">
							    	<!-- DNA: Type 3 -->
							      	<select class="select2" name="files[]" id="select1" draggable="true"  multiple="multiple">
										<?php 
											$total = 0;
											foreach($files as $file) if($file->type_id == TYPE_DNA) { echo '<option value="' . $file->file_id . "|" . $file->type_id  . '" ondblclick="window.open(\'' . trim($file->path) . trim($file->name) . '\',\'_blank\')">' . trim($file->name) . '</option>'; $total++; }
											if($total == 0) echo '<optgroup label="You have no DNA files! :(">'; 
										?>
							    	</select>
					            </div>					
								<a href="#" onclick="clearDNASelected();" class="clearSelection">Clear DNA Selection</a>
					     	</div>
				        </div>
				        <!--END OF DNA TAB-->
			            	
				        <!--START OF RNA TAB-->
			            <div class="choice-list-content">
			            	<div class="choice-fields">
			               		<div class="placeholders">
					           		<!-- RNA -->
					           		<select class="select2" name="files[]" id="select2" draggable="true"  multiple="multiple">
						               	<?php 
											$total = 0;
											foreach($files as $file) if($file->type_id == TYPE_RNA) { echo '<option value="' . $file->file_id . "|" . $file->type_id  . '" ondblclick="window.open(\'' . trim($file->path) . trim($file->name) . '\',\'_blank\')">' . trim($file->name) . '</option>'; $total++; }
											if($total == 0) echo '<optgroup label="You have no RNA files! :(">'; 
									    ?>
							        </select>
								</div>
								<a href="#" onclick="clearRNASelected();" class="clearSelection">Clear RNA Selection</a>
					        </div> 
						</div>
						<!--END OF RNA TAB-->
		            			
			            <!--START OF PROTEIN TAB-->
			            <div class="choice-list-content">
			            	<div class="choice-fields">
			               		<div class="placeholders">
				               		<!-- PROTEIN -->
				               		<select class="select2" name="files[]" id="select3" draggable="true"  multiple="multiple" >
			               				<?php 
											$total = 0;
											foreach($files as $file) if($file->type_id == TYPE_PROTEIN) { echo '<option value="' . $file->file_id . "|" . $file->type_id  . '" ondblclick="window.open(\'' . trim($file->path) . trim($file->name) . '\',\'_blank\')">' . trim($file->name) . '</option>'; $total++; }
											if($total == 0) echo '<optgroup label="You have no PROTEIN files! :(">'; 
							            ?>
							       	</select>
			               		</div>
								<a href="#" onclick="clearPROTEINSelected();" class="clearSelection">Clear PROTEIN Selection</a>
			            	</div> 
			            </div>
			            <!--END OF PROTEIN TAB-->
			
						<!--START OF MPS TAB-->
						<div class="choice-list-content">
			            	<div class="choice-fields">
			               		<div class="placeholders">
			               			<!-- MAPS -->
			               			<select class="select2" name="files[]" id="select4" draggable="true"  multiple="multiple">
						               	<?php
						                	$total = 0;
						                  	$ext = array();
						                  	$map = array();
						                  	$sorted = array();
							                foreach($files as $file)
											{
							                	switch($file->type_id)
							                  	{
							                  		case TYPE_EXT : 
														$ext[] = array("id" => $file->file_id, "type" => $file->type_id, "name" => $file->name, "path" => $file->path);
														$total++;
							                  			break;
							                  		case TYPE_SORTED:
														$sorted[] = array("id" => $file->file_id, "type" => $file->type_id, "name" => $file->name, "path" => $file->path);
														$total++;
							                  			break;
							                  		case TYPE_MAPS:
														$map[] = array("id" => $file->file_id, "type" => $file->type_id, "name" => $file->name, "path" => $file->path);
														$total++;
							                  			break;
							                  		default:
							                  	}
											}
							                if($total > 0)
							                {
							                	echo '<optgroup label="EXT">';
							                	foreach($ext as $e) echo '<option value="' . $e["id"] . "|" . $e["type"]  . '" ondblclick="window.open(\'' . trim($e["path"]) . trim($e["name"]) . '\',\'_blank\')">' . trim($e["name"]) . '</option>';
												echo '</optgroup>';
													
							                	echo '<optgroup label="SORTED">';
							                	foreach($sorted as $s) echo '<option value="' . $s["id"] . "|" . $s["type"]  . '" ondblclick="window.open(\'' . trim($s["path"]) . trim($s["name"]) . '\',\'_blank\')">' . trim($s["name"]) . '</option>';
												echo '</optgroup>';
													
							                	echo '<optgroup label="MAP">';
							                	foreach($map as $m) echo '<option value="' . $m["id"] . "|" . $m["type"]  . '" ondblclick="window.open(\'' . trim($m["path"]) . trim($m["name"]) . '\',\'_blank\')">' . trim($m["name"]) . '</option>';
												echo '</optgroup>';
							                }
							                else
							                {
							                	echo '<optgroup label="You have no EXT files! :(">';   	
							                }
										?>
									</select>
			               		</div>
			               		<a href="#" onclick="clearMAPSelected();" class="clearSelection">Clear MAPS Selection</a>
			            	</div> 
			            </div>
		            	<!--END OF MAPS TABS-->
					</div><!--end of tab choices for file selection-->
				</div><!--end of file type choices-->
        	
			    <!--option fiels for extract fasta/fastq tools-->
			    <div id="sub-sequences">
			    	<h5 style="color:#000099">Extract Options</h5>
			    	<input style="width:100%;background:#eee;border:1px solid #ccc;" type="text" placeholder="Enter lenght of sub-sequences to be extracted, each separated by spaces" name="arguments_single" >
					<div style="margin:15px 0 0 10px">
						<label class="radio"> <input type="radio" name="ext_options" value="1" id="extract-only" checked=""><i></i>Extract Only</label> 
						<label class="radio"> <input type="radio" name="ext_options" value="2" id="extract-sorted"><i></i>Extract and Sort</label> 
						<label class="radio"><input type="radio" name="ext_options" value="3" id="extract-maps"><i></i>Extract, Sort, and Map</label> 
					</div>
				</div>
				<!--opion field for genome probes tool-->
			    <div id="probes-field">
			    	<h5 style="color:#000099">Probes Options</h5>
			    	<input style="width:100%;background:#eee;border:1px solid #ccc;" type="text" placeholder="Enter probes, separated by spaces, use | for each file" name="arguments_multiple" >
			    </div>
			    <div class="job-submission">
			    	<input class="submitNewJob" type="submit" value="Submit New Job" name="do_job" >
			    	<input class="deleteFiles" type="submit" value="Delete Files" name="do_delete" >
			    </div>
			</form><!--end of form for jobs submissions-->	        					            	      
    	</div><!--end of right-columns-->
	</div><!--end of container for left and right columns-->

	<!--start of container for helper tabs-->
	<div class="container">	
    	<div class="col1">
      		<!-- HELPER TABS-->
      		<div class="sap_tabs">	
        		<div id="horizontalTab">
          			<ul class="resp-tabs-list">
            			<li class="resp-tab-item " aria-controls="tab_item-0" role="tab"><span>Tools Description</span></li>
            			<li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span>Tools Helper</span></li>
            			<li class="resp-tab-item" aria-controls="tab_item-2" role="tab"><span>FAQ</span></li>
            			<div class="clear"> </div>
          			</ul>				  	 
	          		<div class="resp-tabs-container">
	            		<h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0"><span class="resp-arrow"></span>Toosl Description</h2>
	            		<div class="tab-1 resp-tab-content resp-tab-content-active" aria-labelledby="tab_item-0" style="display:block;">
	              			<div class="facts">
	                			<ol>
	                    			<?php foreach($tools as $t): ?>
	                        			<li><p><strong class="helper-text"><?php echo $t->name; ?></strong>: <?php echo $t->description; ?></p></li>  
	                    			<?php endforeach; ?>
	                			</ol>
	              			</div>
	            		</div>
	            		<h2 class="resp-accordion" role="tab" aria-controls="tab_item-1"><span class="resp-arrow"></span>Tools Helper</h2>
	            		<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
	              			<div class="facts">		
	                			<ol>
	                  				<li><p><strong class="helper-text">Uploading Files</strong>: You can only upload one file at a time. Acceptable file formats are: FASTA, FASTQ and TXT.</p></li>
	                  				<li><p><strong class="helper-text">Choosing Multiple Tools</strong>: You can select multiple tools for one single job submission.</p></li>
	                  				<li><p><strong class="helper-text">Selecting Multiple Files</strong>: You can select multiple files and run the tools. To select multiple
	                   					files press the Shift key on your computer then click on your mouse to select your files. To select multiple files that are not in sequential order,
	                   					hold the Ctrl key on your computer and click on your mouse to select your files.</p></li>
	                  				<li><p><strong class="helper-text">Repeated Sequences</strong>: Currently supporting Mappped Files only. Choose a mapped file and submit a new job.</p></li>
	                  				<li><p><strong class="helper-text">Unique Sequences</strong>: Currently supporting Mappped Files only. Choose a mapped file and submit a new job.</p></li>
	                  				<li><p><strong class="helper-text">Genome Signatures</strong>: For this tool you must choose at lest 2 files. This tool will find the differences between each file, i.e.:
	                   					what is contained in each file that is not contained in every other file. For example, if you choose 5 files this tool will use each file as the source file
	                   					thus generating 20 different results with information that exist in one file but not in the other files.</p></li>
	                  				<li><p><strong class="helper-text">Extract Fasta/Fastq</strong>: You must enter sub-sequence lenght in the Extract Options Field and choose whether you want
	                   					to extract only to sorted files, or olny to mapped files, or both. For example: If you choose three files, enter the sub-sequence lenghts for each file,
	                   					each one separated by spaces, e.g.: 4 5 6 . The default option for this tool is to extract only but you can choose to sort and generate maps.</p></li>
	                  				<li><p><strong class="helper-text">Genome Probes</strong>: Enter sub-sequences (probes), each separated by spaces and use a bar ' | ' to distinguish between files. 
	                   					For example: if you choose 2 files and you want to find out if the probe aaaac is present in file 1 and if the probes aaaag and aaatg are present in file 2,
	                   					Enter in the Probes Options field: aaaac | aaaag aaatg .</p></li>
	                			</ol>
	              			</div>	
	            		</div>									
            			<h2 class="resp-accordion" role="tab" aria-controls="tab_item-2"><span class="resp-arrow"></span>FAQ</h2>
	            		<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-2">
	              			<div class="facts">
	                			<ol>
	                  				<li><p><strong class="helper-text">Where Can I find my Job Results</strong>: All your job results can be found on your job history
	                   					tab in your tools page. You can click on the table headers to sort all your jobs by ID, by description or by date and time of submission.
	                   					To view your actual results simply click on any job and you will be redirected to where your results are locted. A list of all your jobs with peding status
	                   					will be displayed on your profile page.</p></li>
	                			</ol>
	              			</div>	
            			</div>
          			</div><!--end of resp-tabs-container-->
        		</div><!--end of horizontal tabs-->
      		</div><!--end of sap_tabs-->
		</div><!--end of col1 div-->
	</div><!--end of contatiner for helper tabs-->
</div><!--end of content main division for the tools page-->

<!--start of javascripts used only on tools page-->
<!--This script is for the file selection tabs: DNA RNA PROTEIN MPS-->
<script src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/easyResponsiveTabs.js' ?>"></script>
<script type="text/javascript">
	$(document).ready(function (){
		$('#file-type').easyResponsiveTabs({
			type: 'default',            
			width: 'auto', 
			fit: true   
		});
	});
</script>
<!--this script is for the helper tabs-->
<script src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/easyResponsiveTabs1.js' ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#horizontalTab').easyResponsiveTabs1({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true   // 100% fit in a container
		});
	});
</script>	
<!--script for sorting table by headers used on job history table-->
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/tablesorter.js' ?>"></script>
<script>
	$(document).ready(function(){ 
		$("#myTable").tablesorter(); 
	});		
</script>
<!--scrip for showing hiding sub-sequences length for extract fasta and probes tools-->
<script type="text/javascript">
	$(document).ready(function() {
	    $('#extract-fasta').change(function() {
	        $('#sub-sequences').toggle();
    });
	});		
	$(document).ready(function() {
	    $('#probes').change(function() {
	        $('#probes-field').toggle();
	    });
	});		
</script>
<!--script for href inside a select option to show file contents on tools page-->
<script type="text/javascript">
	function OpenFileInNewTab(url) {
	  var win = window.open(url, '_blank');
	  win.focus();
	}
</script>

<!--script for clearing file selection on select tools boxes-->
<script>
	function clearDNASelected(){
	    var elements = document.getElementById("select1").options;
		for(var i = 0; i < elements.length; i++){
			elements[i].selected = false;
		}
	}
	function clearRNASelected(){
		var elements = document.getElementById("select2").options;
	    for(var i = 0; i < elements.length; i++){
	    	elements[i].selected = false;
		}
	}
	function clearPROTEINSelected(){
		var elements = document.getElementById("select3").options;
		for(var i = 0; i < elements.length; i++){
			elements[i].selected = false;
		}
	}
	function clearMAPSelected(){
		var elements = document.getElementById("select4").options;
	   	for(var i = 0; i < elements.length; i++){
			elements[i].selected = false;
		}
	}
</script>

<!--include the footer and also ends body + html-->
<?php include('includes/footer.php'); ?>
