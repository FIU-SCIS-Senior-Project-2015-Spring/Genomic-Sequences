<?php include('includes/header.php'); ?>	
<div class="content">
	<!--start of content main division-->
	<div class="container charts">
		<div class="container charts-content">
			<!--start of sidebar for file and sub-sequences selection-->
			<div class="col-md-3 charts">
				<form id="charts-file" method="post" action="charts.php">
		            <div id="chart-data">
						<p class="message success" value="<?php echo $map_val; ?>"><?php echo $map_name; ?></p>
		              	<input type="hidden" name="map_file" value="<?php echo $map_val; ?>"/>
						<p>
							<select class="select-maps" id="select-maps" title="Mapped Files" multiple="multiple" name="select_file" size="5" onchange="this.form.submit()">
								<?php foreach($files as $file) : ?>
			                    	<option value="<?php echo $file->file_id; ?>" > <?php echo trim($file->name); ?></option>
								<?php endforeach; ?>
				            </select>
						</p>
					</div>
	            	<div id="chart-data">
						<p class="message2 success2">Select Maximum 10 Sequences</p>
						<p>
							<select class="select-sequences" id="select-sequences" title="Sub-Sequences" multiple="multiple" name="seq_list[]" size="5" >
								<?php if(isset($sequences)) : ?>
		                   			<?php foreach($sequences as $sequence) : ?>
		                     			<option value="<?php echo $sequence; ?>" > <?php echo $sequence; ?></option> 
		                   			<?php endforeach; ?>
	                			<?php endif; ?>
							</select>
						</p>
					</div>
					<div class="job-submission">
						<input class="createChart" type="submit" name="do_chart" value="Create Chart"/>
					</div>
				</form>          
			</div>
			<!--End of sidebar-->
			<!--Start of division for the graph-->
			<div class="col-md-9 charts" >
				<!--This is the div where the highchart graph is rendered-->
				<div id="charts-container" ></div>

<!--this is the pre id holding data for the graph: DO NOT ADD TABS-->
<pre id="csv" style="display:none">
  <?php if(isset($chart)) : ?>
    <?php echo $chart; ?>
  <?php else: ?>
    Sequences,aaaaa,aaaab,aaaac,aaaad, aaaae, aaaaf, aaaag, aaaah,aaaaai,aaaaaj,aaaaak,aaaaal,aaaaam,aaaaan,aaaaao,aaaaap,aaaaaq,aaaaar,aaaaa,aaaab,aaaac,aaaad, aaaae, aaaaf, aaaag, aaaah,aaaaai,aaaaaj,aaaaak,aaaaal,aaaaam,aaaaan,aaaaao,aaaaap,aaaaaq,aaaaar
    69023,1
    74036,1
    75239,1
    78401,1
    79093,1
    109713,1
    115431,1
    124721,1
    127353,1
    132570,1
    140042,1
    69022,1
    74035,1
    75238,1
    78406,1
    79095,1
    109783,1
    115461,1
    124781,1
    12733,1
    13270,1
    149042,1
    69823,1
    75436,1
    75539,1
    78411,1
    79083,1
    109813,1
    135631,1
    12421,1
    127533,1
    132670,1
    140542,1
    69063,1
    74076,1
    75299,1
    78451,1
    79063,1
    106613,1
    119931,1
    123221,1
    125653,1
    132570,1
    144542,1
    69021,,2
    69022,,2
    75238,,2
    109712,,2
    118884,,2
    123679,,2
    123680,,2
    124719,,2
    124720,,2
    124784,,2
    118884,,,3
    123679,,,3
    123680,,,3
    124719,,,3
    124720,,,3
    124784,,,3
    69023,,,,4
    74036,,,,4
    75239,,,,4
    78401,,,,4
    79093,,,,4
    109713,,,,4
    115431,,,,,5
    124721,,,,,5
    127353,,,,,5
    132570,,,,,5
    140042,,,,,5
    69021,,,,,,6
    69022,,,,,,6
    75238,,,,,,6
    109712,,,,,,6
    118884,,,,,,,7
    123679,,,,,,,7
    123680,,,,,,,7
    124719,,,,,,,7
    124720,,,,,,,7
    124784,,,,,,,,8
    118884,,,,,,,,8
    123679,,,,,,,,8
    123680,,,,,,,,,9
    124719,,,,,,,,,9
    124720,,,,,,,,,9
    124784,,,,,,,,,9
    69023,,,,,,,,,,10
    74036,,,,,,,,,,10
    75239,,,,,,,,,,10
    78401,,,,,,,,,,10
    79093,,,,,,,,,,10
    109713,,,,,,,,,,10
    115431,,,,,,,,,,10
    124721,,,,,,,,,,10
    127353,,,,,,,,,,10
    132570,,,,,,,,,,10
    140042,,,,,,,,,,10
    69021,,,,,,,,,,,11
    69022,,,,,,,,,,,11
    75238,,,,,,,,,,,11
    109712,,,,,,,,,,,11
    118884,,,,,,,,,,,11
    123679,,,,,,,,,,,11
    123680,,,,,,,,,,,11
    124719,,,,,,,,,,,11
    124720,,,,,,,,,,,11
    124784,,,,,,,,,,,11
    118884,,,,,,,,,,,,12
    123679,,,,,,,,,,,,12
    123680,,,,,,,,,,,,12
    124719,,,,,,,,,,,,12
    124720,,,,,,,,,,,,12
    124784,,,,,,,,,,,,12
    69023,,,,,,,,,,,,,13
    74036,,,,,,,,,,,,,13
    75239,,,,,,,,,,,,,13
    78401,,,,,,,,,,,,,13
    79093,,,,,,,,,,,,,13
    109713,,,,,,,,,,,,,13
    115431,,,,,,,,,,,,,,14
    124721,,,,,,,,,,,,,,14
    127353,,,,,,,,,,,,,,14
    132570,,,,,,,,,,,,,,14
    140042,,,,,,,,,,,,,,14
    69021,,,,,,,,,,,,,,,15
    69022,,,,,,,,,,,,,,,15
    75238,,,,,,,,,,,,,,,15
    109712,,,,,,,,,,,,,,,15
    118884,,,,,,,,,,,,,,,,16
    123679,,,,,,,,,,,,,,,,16
    123680,,,,,,,,,,,,,,,,16
    124719,,,,,,,,,,,,,,,,16
    124720,,,,,,,,,,,,,,,,16
    124784,,,,,,,,,,,,,,,,,17
    118884,,,,,,,,,,,,,,,,,17
    123679,,,,,,,,,,,,,,,,,17
    123680,,,,,,,,,,,,,,,,,,18
    124719,,,,,,,,,,,,,,,,,,18
    124720,,,,,,,,,,,,,,,,,,18
    124784,,,,,,,,,,,,,,,,,,18
    69023,,,,,,,,,,,,,,,,,,,19
    74036,,,,,,,,,,,,,,,,,,,19
    75239,,,,,,,,,,,,,,,,,,,19
    78401,,,,,,,,,,,,,,,,,,,19
    79093,,,,,,,,,,,,,,,,,,,19
    109713,,,,,,,,,,,,,,,,,,,19
    115431,,,,,,,,,,,,,,,,,,,19
    124721,,,,,,,,,,,,,,,,,,,19
    127353,,,,,,,,,,,,,,,,,,,19
    132570,,,,,,,,,,,,,,,,,,,19
    140042,,,,,,,,,,,,,,,,,,,19
    69022,,,,,,,,,,,,,,,,,,,19
    74035,,,,,,,,,,,,,,,,,,,19
    75238,,,,,,,,,,,,,,,,,,,19
    78406,,,,,,,,,,,,,,,,,,,19
    79095,,,,,,,,,,,,,,,,,,,19
    109783,,,,,,,,,,,,,,,,,,,19
    115461,,,,,,,,,,,,,,,,,,,19
    124781,,,,,,,,,,,,,,,,,,,19
    12733,,,,,,,,,,,,,,,,,,,19
    13270,,,,,,,,,,,,,,,,,,,19
    149042,,,,,,,,,,,,,,,,,,,19
    69823,,,,,,,,,,,,,,,,,,,19
    75436,,,,,,,,,,,,,,,,,,,19
    75539,,,,,,,,,,,,,,,,,,,19
    78411,,,,,,,,,,,,,,,,,,,19
    79083,,,,,,,,,,,,,,,,,,,19
    109813,,,,,,,,,,,,,,,,,,,19
    135631,,,,,,,,,,,,,,,,,,,19
    12421,,,,,,,,,,,,,,,,,,,19
    127533,,,,,,,,,,,,,,,,,,,19
    132670,,,,,,,,,,,,,,,,,,,19
    140542,,,,,,,,,,,,,,,,,,,19
    69063,,,,,,,,,,,,,,,,,,,19
    74076,,,,,,,,,,,,,,,,,,,19
    75299,,,,,,,,,,,,,,,,,,,19
    78451,,,,,,,,,,,,,,,,,,,19
    79063,,,,,,,,,,,,,,,,,,,19
    106613,,,,,,,,,,,,,,,,,,,19
    119931,,,,,,,,,,,,,,,,,,,19
    123221,,,,,,,,,,,,,,,,,,,19
    125653,,,,,,,,,,,,,,,,,,,19
    132570,,,,,,,,,,,,,,,,,,,19
    144542,,,,,,,,,,,,,,,,,,,19
    69021,,,,,,,,,,,,,,,,,,,,20
    69022,,,,,,,,,,,,,,,,,,,,20
    75238,,,,,,,,,,,,,,,,,,,,20
    109712,,,,,,,,,,,,,,,,,,,,20
    118884,,,,,,,,,,,,,,,,,,,,20
    123679,,,,,,,,,,,,,,,,,,,,20
    123680,,,,,,,,,,,,,,,,,,,,20
    124719,,,,,,,,,,,,,,,,,,,,20
    124720,,,,,,,,,,,,,,,,,,,,20
    124784,,,,,,,,,,,,,,,,,,,,20
    118884,,,,,,,,,,,,,,,,,,,,,21
    123679,,,,,,,,,,,,,,,,,,,,,21
    123680,,,,,,,,,,,,,,,,,,,,,21
    124719,,,,,,,,,,,,,,,,,,,,,21
    124720,,,,,,,,,,,,,,,,,,,,,21
    124784,,,,,,,,,,,,,,,,,,,,,21
    69023,,,,,,,,,,,,,,,,,,,,,,22
    74036,,,,,,,,,,,,,,,,,,,,,,22
    75239,,,,,,,,,,,,,,,,,,,,,,22
    78401,,,,,,,,,,,,,,,,,,,,,,22
    79093,,,,,,,,,,,,,,,,,,,,,,22
    109713,,,,,,,,,,,,,,,,,,,,,,22
    115431,,,,,,,,,,,,,,,,,,,,,,,23
    124721,,,,,,,,,,,,,,,,,,,,,,,23
    127353,,,,,,,,,,,,,,,,,,,,,,,23
    132570,,,,,,,,,,,,,,,,,,,,,,,23
    140042,,,,,,,,,,,,,,,,,,,,,,,23
    69021,,,,,,,,,,,,,,,,,,,,,,,,24
    69022,,,,,,,,,,,,,,,,,,,,,,,,24
    75238,,,,,,,,,,,,,,,,,,,,,,,,24
    109712,,,,,,,,,,,,,,,,,,,,,,,,24
    118884,,,,,,,,,,,,,,,,,,,,,,,,,25
    123679,,,,,,,,,,,,,,,,,,,,,,,,,25
    123680,,,,,,,,,,,,,,,,,,,,,,,,,25
    124719,,,,,,,,,,,,,,,,,,,,,,,,,25
    124720,,,,,,,,,,,,,,,,,,,,,,,,,25
    124784,,,,,,,,,,,,,,,,,,,,,,,,,,26
    118884,,,,,,,,,,,,,,,,,,,,,,,,,,26
    123679,,,,,,,,,,,,,,,,,,,,,,,,,,26
    123680,,,,,,,,,,,,,,,,,,,,,,,,,,,27
    124719,,,,,,,,,,,,,,,,,,,,,,,,,,,27
    124720,,,,,,,,,,,,,,,,,,,,,,,,,,,27
    124784,,,,,,,,,,,,,,,,,,,,,,,,,,,27
    69023,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    74036,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    75239,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    78401,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    79093,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    109713,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    115431,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    124721,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    127353,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    132570,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    140042,,,,,,,,,,,,,,,,,,,,,,,,,,,,28
    69021,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    69022,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    75238,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    109712,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    118884,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    123679,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    123680,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    124719,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    124720,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    124784,,,,,,,,,,,,,,,,,,,,,,,,,,,,,29
    118884,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,30
    123679,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,30
    123680,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,30
    124719,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,30
    124720,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,30
    124784,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,30
    69023,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,31
    74036,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,31
    75239,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,31
    78401,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,31
    79093,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,31
    109713,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,31
    115431,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,32
    124721,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,32
    127353,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,32
    132570,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,32
    140042,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,32
    69021,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,33
    69022,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,33
    75238,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,33
    109712,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,33
    118884,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,34
    123679,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,34
    123680,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,34
    124719,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,34
    124720,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,34
    124784,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,35
    118884,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,35
    123679,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,35
    123680,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,36
    124719,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,36
    124720,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,36
    124784,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,36
  <?php endif; ?>
</pre>	
			</div><!--end of col-md-9-->
		</div><!--end of sub-content of main division width: 90%-->
	</div><!--end of content main division-->
</div>
<!--this script is for the highcharts-->
<script type="text/javascript">
	$(function () {
	    $('#charts-container').highcharts({
	        data: {
	            csv: document.getElementById('csv').innerHTML
	        },
			chart: {
	            type: 'scatter',
	            renderTo: 'charts-container',
	            zoomType: 'xy'
	        },
	        title: {
	            text: '<?php echo $title; ?>'
	        },
	        subtitle: {
	            text: 'GenomePro'
	        },
	        xAxis: {
	            title: {
	                enabled: true,
	                text: 'Position'
	            },
	            startOnTick: false,
	            endOnTick: true,
	            showLastLabel: true,
	        },
	        yAxis: {
	            floor: 0,
	            title: {
	                enabled: true,
	                text: 'Sequences'
	            },
	        },
	        legend: {
	            layout: 'horizontal',
	            align: 'center',
	            verticalAlign: 'bottom',
	            floating: false,
	            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
	            borderWidth: 1
	        },
	        plotOptions: {
	            scatter: {
	                marker: {
	                	symbol:'circle',
	                    radius: 3,
	                    states: {
	                        hover: {
	                            enabled: true,
	                            lineColor: 'rgb(100,100,100)'
	                        }
	                    }
	                },
	                states: {
	                    hover: {
	                        marker: {
	                            enabled: true
	                        }
	                    }
	                },
	                tooltip: {
	                    headerFormat: '<b>{series.name}</b><br>',
	                    pointFormat: '{point.x}'
	                }
	            }
	        },
	    });
	});
</script>
	
<!--script for first select options in charts-->
<script type="text/javascript">
	$(function(){
		var warning = $(".message");
		
		$("#select-maps").multiselect({ 
			header: "Choose Only ONE File",
			click: function(e){
			
				if( $(this).multiselect("widget").find("input:checked").length > 1 ){
					warning.addClass("error").removeClass("success").html("You Can Only Select ONE File Per Graph!");
					return false;
				} else {
					warning.addClass("success").removeClass("error").html("Select A Mapped File");
				}
				
			},
			selectedList: 1 
		});
		$("#select-maps").multiselect().multiselectfilter(); 
	});
</script>
<!--script for second select options in charts-->
<script type="text/javascript">
	$(function(){
		var warning = $(".message2");
		
		$("#select-sequences").multiselect({ 
			header: "Select Maximum 10 Sequences",
			click: function(e){
			
				if( $(this).multiselect("widget").find("input:checked").length > 10 ){
					warning.addClass("error2").removeClass("success2").html("Select Maximum 10 Sequences!");
					return false;
				} else {
					warning.addClass("success2").removeClass("error2").html("Select Maximum 10 Sequences");
				}
				
			},
			selectedList: 10,
		});
		$("#select-sequences").multiselect().multiselectfilter(); 
	});
</script>		

<!--these are JS necessary for the highcharts to function-->
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/jquery-ui.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/jquery.multiselect.filter.js' ?>"></script>
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/jquery.multiselect.js' ?>"></script>
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/highstock.js' ?>"></script>
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/exporting.js' ?>"></script>
<script type="text/javascript" src="<?php echo BASE_DIR.TEMPLATES_DIR.'js/data.js' ?>"></script>

<!--include footer-->
<?php include('includes/footer.php'); ?>
