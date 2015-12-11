<?php	
/* CHARTS.PHP *********************************************************
*	File: 			charts.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		11/30/2015
*
*	Purpose:		This PHP script has the capability of opening MAP
*					files and understand its contents, capable of
*					listing the subsequences in order and allowing
*					the user to ultimately pick from the set of
*					available subsequences. This script also uses the
*					ones selected and creates a graph from the data,
*					as MAP files contain the locations of each
*					subsequence. MAP files get converted into X and Y
*					values, Y values being each subsequence selected by
*					the user, and X being their respective locations.
*					For now, we've limited the subsequence count to
*					100 on this script, although that can be changed
*					if needed later. Check HTML page in case a change
*					in this is not working.
*
*					Note that this page works twice. First, it gives
*					the user a method of selecting a MAP file. As soon
*					as a MAP file is selected, it instantly refreshes,
*					updating itself with new data including the ID of
*					the file as well as the subsequences gathered. This
*					is when the second part of the script comes into 
*					play, as it generates the X and Y values as soon
*					as the user clicks to create the graph presumably
*					after the first step of this script since it 
*					provides to the HTML the list of subsequences to
*					select from. The second step of this page cannot
*					work without the first step, which is why we give
*					an error if the user tries to create a graph
*					without selecting a file first.
*
*	Requirements: 	init.php must be in the 'core' directory, as it
*					contains necessary imports as well as defined 
*					variables for this script to use. Check the file
*					to understand its contents if needed.
*
*					charts.php must also exist, as it is the HTML 
*					that contains information about what to display
*					to the web browser.
**********************************************************************/
?>

<?php require('core/init.php'); // import variables and libraries

if(!isLoggedIn()) redirect(INDEX); // redirect to index page if not logged in

//----------------------------- DEFAULT ACTION OF THE PAGE -----------------------------//

$template = new Template(TEMPLATES_DIR . CHARTS); // create new view

$template->map_name = "Select a Map File"; // this is used for an HTML element that contains the map file name
$template->map_val = 0;	// the id of the file selected, default 0 for none selected
$template->title = "Sample Graph"; // default map title

$file = new File; // create new FILE class to use its functions

// ------------------------------ USER CLICKS CREATE MAP -------------------------------//

if(isset($_POST['do_chart'])) { // if the user clicks to create a map
  $seq_list = $_POST['seq_list']; // grab the list of sequences
  $map_file = $_POST['map_file']; // grab the id of the file selected
  
  if(!(isset($seq_list) && isset($map_file))) redirect('charts.php', 'You did not submit your form correctly!', 'error');
  if(count($seq_list) > 100) redirect('charts.php', 'You did not submit your form correctly!', 'error');
  
  $info = $file->getFile($map_file); // grab the row on the database providing the id of the file
  
  $name = trim($info->name);
  $path = trim($info->path);
  
  $template->chart = createChart($name, $path, $seq_list); // this function is found under the system_helper.php
  $template->title = $name;
	/*
		createChart() function returns something of this format:
			y0,y1,y2,y3,y4,...
			x0-0
			x0-1
			x0-2
			x0-...
			,x1-0
			,x1-1
			,x1-2
			,x1-...
			,,x2-0
			,,x2-1
			,,x2-2
			,,x2-..
			..
		where the first line contains all the Y values separated by commas,
		and each subsequent line is an X value for a given Y, where this Y
		is differentiated by the number of commas before the X values. In other
		words, if there are no commas, the X value belongs to the first Y value 
		in the list of Y values on the first line. If the number of commas is,
		lets say, 3, then it belongs to the fourth Y value.
		
		NOTE: We're using highcharts.js, so it contains a script that understands
        this particular format and creates a chart out of it. These are
        imports that the HTML page contains. We're only interested in
        providing the data to that JS script, in which we create from a
        MAP file. Also note that this data is directly inserted into the
        HTML of the page, as the script uses a <DIV>'s inner HTML to source 
        the data to create the chart.
	*/
}

// -------------------------------- USER SELECTS FILE ----------------------------------//

if(isset($_POST['select_file'])) { // if the user clicks to select a map file
  $id = $_POST['select_file']; // grab the id of the file selected
  
  $info = $file->getFile($id); // get information about the file from the DB
  
  $name = trim($info->name);
  $path = trim($info->path);
  
  $template->map_name = $name . " selected!"; // let the user know this file has been selected by updating HTML.
  $template->map_val = $_POST['select_file']; // save that id for when the user clicks to create
  
  $template->sequences = getSequences($name, $path); // grab a list of sequences so that the user can select from
}

$template->files = $file->getAllMaps(); // grab a list of all MAP files that a user has to display to them and select from.

echo $template;	// print view