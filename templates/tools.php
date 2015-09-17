<?php include('includes/header.php'); ?>

<div class="content">
    <div class="tools-section" id="tools">
        <div class="container">
            <h3>Tools</h3>
            <div class="tools-grids">              
                <div class="col-md-7 tools-leftgrid">
                    
                <?php foreach($tools as $tool) : ?>
                             
                    <div class="tools2">
                        <div class="left-grid1">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                        </div>
                        <div class="left-grid2">
                            <h4><?php echo $tool->name; ?></h4>
                            <p><?php echo $tool->description; ?></p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>        
                    
                    
                <?php endforeach; ?>
                
                </div><!--end of left grid-->      
                <div class="col-md-5 tools-rightgrid">
                    
                    <?php if($files) : ?>
                    
                        <div class="files">    
                            <form id="form1" method="post" action="tools.php">
                                <h4>Select Job:</h4><br>
                                
                                    <?php foreach($tools as $tool) : ?>

                                        <input type="radio" name="radio" value="<?php echo $tool->tool_id; ?>" lang="en"/> <?php echo $tool->name; ?><br>

                                    <?php endforeach; ?>
                                
                                <br />
                                
                                <h4>With Input:</h4><br>
                                <label>Select a File
                                    <select name="selector">
                                        
                                        <?php foreach($files as $file) : ?>
                                        
                                            <option value="<?php echo $file->file_id; ?>"><?php echo $file->name; ?></option>
                                        
                                        <?php endforeach; ?>
                                        
                                    </select>
                                </label>
                                <br />
                                <label style="visibility: hidden;">Select a File
                                    <select name="file" id="1">
                                        
                                        <?php foreach($files as $file) : ?>
                                        
                                            <option value="<?php echo $file->file_id; ?>"><?php echo $file->name; ?></option>
                                        
                                        <?php endforeach; ?>
                                        
                                    </select>
                                </label>
                                <br />
                                <input name="do_job" type="submit" value="Submit"/>
                            </form>
                        </div>
                    
                    <?php else : ?>
                    
                        <div class="tools-main">
                            <h4>There are no files to show :(</h4><br>	
                        </div>
                    
                    <?php endif; ?>
                    
                    <form method='post' enctype='multipart/form-data' action='tools.php'>
                        File: <input type='file' name='data'>
                        <input type='submit' name='do_upload'>
                    </form>
                </div><!--end of right grid-->
                <div class="clearfix"> </div>
            </div><!--end of tools-grids-->
            <!--start of manage files grid-->
        </div><!--end of container-->
    </div><!--end of services-->
</div><!--end of content main division-->

<?php include('includes/footer.php'); ?>