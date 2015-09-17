<?php include('includes/header.php'); ?>

    <!--start of content main division-->
    <div class="content" id="history">
        <div class="history">
            
            
            
                <table id="myTable" class="tablesorter">
                    <caption>Results History</caption>  
                    <caption>Click on any header for sorting</caption>
                    <thead>
                        <tr>
                            <th scope="col">JOB ID</th>
                            <th scope="col">JOB DESCRIPTION</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php if($jobs) : ?>
                        
                        <?php foreach($jobs as $job) : ?>

                            <tr>
                                <td><?php echo $job->job_id; ?></td>
                                <td><?php echo $job->name; ?></td>    
                                <td><?php echo $job->timestamp; ?></td>
                                <td>
                                    <?php  
                                        switch($job->status) {
                                            case 1: echo 'In Queue'; break;
                                            case 2: echo 'Processing'; break;
                                            case 3: echo 'Done!'; break;
                                            default: echo 'Unknown';
                                        }
                                    ?>
                                </td>
                            </tr>

                    <?php endforeach; ?>
                        
                        <?php else : ?>

                            <tr><td>There are no jobs submitted!</td></tr>
                    
                        <?php endif ?>
                        
                    </tbody>
                </table>
            <div class="results">
                <button><img src="<?php echo BASE_DIR . TEMPLATES_DIR; ?>images/view.png" alt="" height="37" width="38">VIEW RESULTS</button>
            </div>
        </div>
    </div>
    <!--end of content main division-->

    <?php include('includes/footer.php'); ?>