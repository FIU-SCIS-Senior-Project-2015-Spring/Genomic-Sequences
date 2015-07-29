// All the controllers to be loaded on account.php. 
// Controllers for the pages profile.html, files.html, history.html

//Created the module GenomePro
var GenomePro = angular.module('GenomePro', ['angularFileUpload','ngRoute','angularCharts']);

//Routes for Account when you write in the url /profile or /files or /history angular will load in the ng-view profile.html or files.html or history.html with the respective controler.	
GenomePro.config(['$routeProvider',function($routeProvider) {
	$routeProvider
		.when('/profile', {
			templateUrl: 'HtmlPages/profile.html',
			controller: 'profile'
		  })
		.when('/files', {
			templateUrl: 'HtmlPages/files.html',
			controller: 'files'
		  })
		.when('/history', {
			templateUrl: 'HtmlPages/history.html',
			controller: 'history'
		  })		  
		.otherwise({
			redirectTo : '/profile'
		});
}]);

// directive to post a photo by default if user doesn't provide one 
GenomePro.directive('img', function () {
    return {
        restrict: 'E',        
        link: function (scope, element, attrs) {     
            // show an image-missing image
            element.error(function () {
                var w = element.width();
                var h = element.height();
                // using 20 here because it seems even a missing image will have ~18px width 
                // after this error function has been called
                if (w <= 20) { w = 100; }
                if (h <= 20) { h = 100; }
                var url = 'Images/logo.png';
                element.prop('src', url);
                element.css('border', 'double 3px #cccccc');
            });
        }
    }
});

// this directive is to make the tabs in the tools page work with html and angular
GenomePro.directive('showtab',
    function () {
        return {
            link: function (scope, element, attrs) {
                element.click(function(e) {
                    e.preventDefault();
                    $(element).tab('show');
                });
            }
        };
    });

//this interceptor will intercept http errors, responser other than 200, and will show a massage error with http.post from angular
GenomePro.factory('sessionRecoverer', ['$q', '$injector', function($q, $injector) {  
	var sessionRecoverer = {
	        responseError: function(response) {
			$('#showAlertTitle').text("An error has occurred.");	
			$('#showAlertText').text(response.data.ErrorMsg);
			$('#showAlert').modal('show');
		return $q.reject(response);
		}
	};
	return sessionRecoverer;
}]);

// this interceptor will intercept http errors, responser other than 200, and will show a massage error with ajax from Jquery
$(function() {
    $.ajaxSetup({
        error: function(jqXHR, exception) {
            $('#showAlertTitle').text("An error has occurred.");	
            $('#showAlertText').text(jqXHR.responseJSON.ErrorMsg);
            $('#showAlert').modal('show');

        }
    });
});

// this is for the loading indicator showing in the tools page when you click on one of the tools
$(document).bind("ajaxSend", function(){
   $("#loading-indicator").show();
 }).bind("ajaxComplete", function(){
   $("#loading-indicator").hide();
 });

// // this is for the loading indicator showing in the tools page when you click on one of the tools
$("button").click(function(event) {
    $.post( "/echo/json/", { delay: 2 } );
});

// this will add the previus interceptor to the http provider for ajax requests
$( document ).ajaxError(function( event, request, settings ) {
  $( "#msg" ).append( "<li>Error requesting page " + settings.url + "</li>" );
});

//this will add the previus interceptor to the http provider
GenomePro.config(['$httpProvider', function($httpProvider) {  
	$httpProvider.interceptors.push('sessionRecoverer');
}]);

//this controller is for the navegation bar.
GenomePro.controller('ControllerNavbar', function($scope, $location, $http) {

	//this function is call when you click the log out button, here the page logout.php is called and when it come back,the user is already log out,it redirect to index.php.
	$scope.logOut = function(){
		$http.post("CORE/logout.php",
		{})
		.success(function(json) {
			 window.location.replace('http://genomepro.cis.fiu.edu/index.php');
		});
	}
});                                    

//-----------------------------------------PROFILE------------------------------
//this controller is for the profile.html.
GenomePro.controller('profile', function($scope, $http, $location, $timeout) {

	//varibles for input type tests in profile.hmtl 	
	$scope.InputPassword = "Testing";
	$scope.currentPassword ="";
	$scope.newPassword="";
	$scope.newPasswordAgain="";
        $scope.images = [];
        $scope.newFirstName ="";
        $scope.newLastName = "";
	
	//call profile information to get user first name and last name
	$http.post("CORE/profile_information.php",
	{

	})
	.success(function(json) {
		$scope.name = json;
	});
		
	//This is call when the upload photo button is clicked 
	$scope.uploadPhoto = function(){
            var formData = new FormData();
            
            formData.append('image', $scope.images[0]);
            
            //Upload 
            $.ajax({ url: "CORE/userImageUpload.php", type: "POST", data: formData, processData: false, 
            // tell jQuery not to process the data
            contentType: false, 
            // tell jQuery not to set contentType
             transformRequest: angular.identity 
            })
            .done(function(json, status, headers, config) { 
                    $('#showAlertTitle').text("Image Uploaded.");	
                    $('#showAlertText').text("An image has been uploaded.");
                    $('#showAlert').modal('show');	
                    $("#profile_image").attr("src", "Images/"+$scope.name['id']);
            });
	}
        
        //function when image selected
	$scope.imageSelect = function($files) {
		$scope.images = $files;
	};
	
	//This is call when the change first name button is clicked
	$scope.OpenChangeFirstNameModal = function(){
		
		//this show the change first name modal
		$scope.newFirstName ="";
		$('#ChangeFirstNameModal').modal('show');
	}

	//This is call when the change last name button is clicked
	$scope.OpenChangeLastNameModal = function(){
		
		//this show the change last name modal
		$scope.newLastName ="";
		$('#ChangeLastNameModal').modal('show');
	}

	//This is call when the change password button is click to open change password modal	
	$scope.OpenChangePassModal = function(){
                // to clear the variables everytime its opened
                $scope.currentPassword ="";
                $scope.newPassword="";
                $scope.newPasswordAgain="";
		//this show the change password modal		
		$('#ChangePasswordModal').modal('show');		
	}

	//This is call when the change password button is click inside the modal 
	$scope.ChangePassword = function(){
            	$http.post("CORE/changePassword.php",
		{currentPassword:$scope.currentPassword,
                newPassword:$scope.newPassword, 
                newPasswordAgain:$scope.newPasswordAgain})
		.success(function(json){
			$('#showAlertTitle').text("Change Password.");		
			$('#showAlertText').text("Your password has been changed successfully.");
			$('#showAlert').modal('show');
			$('#ChangePasswordModal').modal('hide');
		});
            
		
	}
        
	//This is call when the submit change first name button is clicked 
	$scope.ChangeFirst = function(){
                $http.post("CORE/changeFirstName.php",
		{newFirstName:$scope.newFirstName})
		.success(function(json){
			$('#showAlertTitle').text("Change First Name.");		
			$('#showAlertText').text("Your first name has been changed successfully.");
			$('#showAlert').modal('show');
			$('#ChangeFirstNameModal').modal('hide');
                        $scope.name.first_name = $scope.newFirstName;
		});	
	}
        
        //This is call when the submit change last name button is clicked  
	$scope.ChangeLast = function(){
                $http.post("CORE/changeLastName.php",
		{newLastName:$scope.newLastName})
		.success(function(json){
			$('#showAlertTitle').text("Change Last Name.");		
			$('#showAlertText').text("Your last name has been changed successfully.");
			$('#showAlert').modal('show');
			$('#ChangeLastNameModal').modal('hide');
                        $scope.name.last_name = $scope.newLastName;
		});	
	}
});

//---------------------------------------------TOOLS--------------------------------------------
//this controller is for the files.html.
GenomePro.controller('files', function($scope, $http, $location, $timeout) {
	
        //this is for the find differences functionality
	$scope.file1 = []; 
	$scope.file2 = [];
        
	//This is call when the find differences button is click	
	$scope.FindDifferences = function(){
		var formData = new FormData();

		formData.append('fileOne', $scope.file1[0]);
		formData.append('fileTwo', $scope.file2[0]);

		//Upload 
		$.ajax({ url: "CORE/findDifferences.php", type: "POST", data: formData, processData: false, 
		// tell jQuery not to process the data
		contentType: false, 
		// tell jQuery not to set contentType
		 transformRequest: angular.identity 
		})
		.done(function(json, status, headers, config) { 
			$('#showAlertTitle').text("Files Uploaded.");	
			$('#showAlertText').text("The files has been uploaded to find the differences among them, an email will be sent to you with the result.");
			$('#showAlert').modal('show');			
		}); 
	}

	//function when file 1 is selected
	$scope.onFileOneSelect = function($files) {
		$scope.file1 = $files;
	};
    
        //function when file 2 is selected
	$scope.onFileTwoSelect = function($files) {
		$scope.file2 = $files;
	};
        
        
        //this is for the analyze data functionality
        $scope.file_analyze = [];
        
        //This is call when the Analyze button is click	
	$scope.AnalyzeFile = function(){
		var formData = new FormData();

		formData.append('file_an', $scope.file_analyze[0]);
		
		//Upload 
		$.ajax({ url: "CORE/analyzeFile.php", type: "POST", data: formData, processData: false, 
		// tell jQuery not to process the data
		contentType: false, 
		// tell jQuery not to set contentType
		 transformRequest: angular.identity 
		})
		.done(function(json, status, headers, config) { 
			$('#showAlertTitle').text("File Uploaded.");	
			$('#showAlertText').text("The file has been uploaded to be analyzed, an email will be sent to you with the result.");
			$('#showAlert').modal('show');			
		}); 
	}
        
        //function when file selected
        $scope.analyzeFile = function($files) {
		$scope.file_analyze = $files;
	};
        
        
        //this is for the find probes functionality
        $scope.probes_file = []; //the file that contains the data
        $scope.bash_file = [];   //the bash file that contains the probes to find
        
        //this is called when the Find button is clicked in the find probes section
        $scope.FindProbes = function(){
                var formData = new FormData();

		formData.append('probesFile', $scope.probes_file[0]);
                formData.append('bashFile', $scope.bash_file[0]);
		
		//Upload 
		$.ajax({ url: "CORE/findProbes.php", type: "POST", data: formData, processData: false, 
		// tell jQuery not to process the data
		contentType: false, 
		// tell jQuery not to set contentType
		 transformRequest: angular.identity 
		})
		.done(function(json, status, headers, config) { 
			$('#showAlertTitle').text("File Uploaded.");	
			$('#showAlertText').text("The file has been uploaded to find genome probes, an email will be sent to you with the result.");
			$('#showAlert').modal('show');			
		});    
        }
        
        //function when file selected
        $scope.theProbesFile = function($files) {
		$scope.probes_file = $files;
	};
        
        //function when file selected
        $scope.theBashFile = function($files) {
		$scope.bash_file = $files;
	};
        
        
        //This is call when the upload files button is click	
	$scope.UploadFilesTwo = function(){
		var formData = new FormData();

		formData.append('fileOne', $scope.files3[0]);

		//Upload 
		$.ajax({ url: "CORE/findSequences.php", type: "POST", data: formData, processData: false, 
		// tell jQuery not to process the data
		contentType: false, 
		// tell jQuery not to set contentType
		 transformRequest: angular.identity 
		})
		.done(function(json, status, headers, config) { 

			$('#showAlertTitle').text("File Uploaded.");	
			$('#showAlertText').text("The file has been uploaded to find the repeated sequences, an email will be sent to you with the result.");
			$('#showAlert').modal('show');			
		}); 
	}
        
        $scope.onFileThreeSelect = function($files) {
		$scope.files3 = $files;
	};
});

//-------------------------------------------HISTORY--------------------------------------------------
//this controller is for the history.html.
GenomePro.controller('history', function($scope, $http, $location, $timeout) {

	//this is an example of data input to show the table on history.html	
	$scope.probesHistory = [];
        $scope.dataTypesHistory = [];
        $scope.repeatedSequencesHistory = [];
        $scope.differencesDataHistory = [];
        $scope.fileToDownload ="";
        
        //Filters variables for the filtering in the history page
        $scope.RSeq ="";
        $scope.DType = "";
        $scope.GProbe ="";
        $scope.PData = "";
        
        //Order by variables
        $scope.predicate = '';
        $scope.reverse = true;

        //Order by function
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };        
        
        //Graph variables
        $scope.graphNames = [];
        $scope.graphValues = [];

	//this brings the list of genome probes and displays it	
        $scope.genomeProbes = function() {
            $http.post("CORE/getProbes.php",
            {})
            .success(function(json) {
                     $scope.probesHistory = json;
            });	
        }

	//this brings the list of data types and displays it	
        $scope.dataTypes = function() {
            $http.post("CORE/getDataTypes.php",
            {})
            .success(function(json) {
                     $scope.dataTypesHistory = json;
            });	
        }
        
	//this brings the list of repeated sequences and displays it	
        $scope.repeatedSequences = function() {
            $http.post("CORE/getRepSequences.php",
            {})
            .success(function(json) {
                     $scope.repeatedSequencesHistory = json;
            });	
        }
        
        //initialize the first history table in the history page
        $scope.repeatedSequences();
        
	//this brings the list of processed data and displays it	
        $scope.genomeDifferences = function() {
            $http.post("CORE/getDifferences.php",
            {})
            .success(function(json) {
                     $scope.differencesDataHistory = json;
            });	
        }
        
	//this function id for when download is called
	$scope.downloadFile = function($name,$realname) {
            $scope.fileToDownload = $realname;
		$http.post("CORE/downloadedFile.php",
		{fileName:$name,
                realName:$realname}
		).success(function(json) {
			var element = angular.element('<a/>');
				 element.attr({
					 href: 'data:attachment/csv;charset=utf-8,' + encodeURI(json),
					 target: '_blank',
					 download: $scope.fileToDownload
				 })[0].click();
		});
	};
        
//----------------------------GRAPH STARTS HERE---------------------------------//
        //show graph
        $scope.showGraph = function($fileid) {
            $http.post("CORE/getGraphInformation.php",
            {fileName:$fileid})
            .success(function(json) {
	        //fill the angular variables
                $scope.graphNames = json.name;
                $scope.graphValues = json.count;

		// time out so that graph load itself before opening modal
		//after 900ms call updateChart()
		$timeout(updateChart, 900);

		//show modal
                $('#showGraph').modal('show');

            });	
            
        };
                
        //GRAPH CONFIGURATION
        //BAR Graph
        $scope.chartTypeBar = 'bar';
        $scope.colorsChartsBar = ['#CC0000', '#000000', '#00CC00', '#FF007F', '#000099', '#CC6600', '#4C0099', '#009999', '#FF6666', '#331900', '#404040', '#660033', '#4C9900'];

        //BAR Graph Configuration
        $scope.configGraphBar = {
            title: '', // chart title. If this is false, no title element will be created.
            tooltips: true,
            labels: true, // labels on data points
            // exposed events
            mouseover: function() {},
            mouseout: function() {},
            click: function() {},
            // legend config
            legend: {
                display: false, // can be either 'left' or 'right'.
                position: 'right',
                // you can have html in series name
                htmlEnabled: false
            },
            // override this array if you're not happy with default colors
            colors: $scope.colorsChartsBar,
            lineCurveType: 'cardinal', // change this as per d3 guidelines to avoid smoothline
            isAnimate: true, // run animations while rendering chart
            yAxisTickFormat: 's', //refer tickFormats in d3 to edit this value
            xAxisMaxTicks: 6, // Optional: maximum number of X axis ticks to show if data points exceed this number
            yAxisTickFormat: 's', // refer tickFormats in d3 to edit this value
            waitForHeightAndWidth: false, // if true, it will not throw an error when the height or width are not defined (e.g. while creating a modal form), and it will be keep watching for valid height and width values
            lineLegend: 'traditional' // can be also 'traditional'
        };

        //BAR Graph Data is initialize, first time will be empty because there is no data in graphNames or graphValues
        $scope.dataGraphBar = {
            series: $scope.graphNames,
            data: [{
                    x: "",
                    y: $scope.graphValues
            }]
        };

	//after time out this function is called to overwrite the bar data with the new data on graphNames and graphValues
	var updateChart = function() {
                $scope.dataGraphBar = {
                series: $scope.graphNames,
                data: [{
                        x: "",
                        y: $scope.graphValues
                }]
            };
            }        
});
