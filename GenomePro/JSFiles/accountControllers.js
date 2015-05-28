//All the controllers to be loaded on account.php. Controllers for the pages profile.html, files.html, history.html

//Created the module GenomePro
var GenomePro = angular.module('GenomePro', ['angularFileUpload','ngRoute']);

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


GenomePro.factory('sessionRecoverer', ['$q', '$injector', function($q, $injector) {  
	var sessionRecoverer = {
	        responseError: function(response) {
			$('#showAlertTitle').text("Error has occurred.");	
			$('#showAlertText').text(response.data.ErrorMsg);
			$('#showAlert').modal('show');
		return $q.reject(response);
		}
	};
	return sessionRecoverer;
}]);

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
			 window.location.replace('http://localhost/GenomePro/index.php');
		});
	}
});                                    

//this controller is for the profile.html.
GenomePro.controller('profile', function($scope, $http, $location, $timeout) {

	//varibles for input type tests in profile.hmtl 	
	$scope.theName ="";
	$scope.name = "";
	$scope.InputPassword = "Test";
	$scope.theOldPassword ="";
	$scope.theNewPassword="";
	$scope.theNewTwoPassword="";
	
	//call progile information to get user first name and last name
	$http.post("CORE/profile_information.php",
	{

	})
	.success(function(json) {
		$scope.name = json;
	});
	

	//This is call when the select photo button is click on 
	$scope.selectPhoto = function(){
		
	}
	
	//This is call when the upload photo button is click 
	$scope.uploadPhoto = function(){
		
	}
	
	//This is call when the change name button is click to open the change name modal
	$scope.OpenChangeNameModal = function(){
		
		//this show the change name modal
		$scope.theName = $scope.name;
		$('#ChangeNameModal').modal('show');
	}

	//This is call when the change password button is click to open change password modal	
	$scope.OpenChangePassModal = function(){
		
		//this show the change password modal		
		$('#ChangePasswordModal').modal('show');		
	}

	//This is call when the change password button is click 
	$scope.ChangePassword = function(){
		
	}	
	
	//This is call when the  change name button is click 
	$scope.ChangeName = function(){
		
	}	
});

//this controller is for the files.html.
GenomePro.controller('files', function($scope, $http, $location, $timeout) {
	
	//This is call when the upload files button is click	
	$scope.UploadFiles = function(){
		
	}	
});

//this controller is for the history.html.
GenomePro.controller('history', function($scope, $http, $location, $timeout) {

	//this is an example of data input to show the table on history.html	
	$scope.myhistory = [];
	$scope.myhistory[0] = [];
	$scope.myhistory[1] = [];
	$scope.myhistory[2] = [];
	$scope.myhistory[3] = [];
	$scope.myhistory[4] = [];
	$scope.myhistory[0].file1 = "aaaa";
	$scope.myhistory[0].file2 = "aaaa";
	$scope.myhistory[0].status = "Processed";
	$scope.myhistory[0].result = "lalalala";
	$scope.myhistory[1].file1 = "bbb";
	$scope.myhistory[1].file2 = "bbb";
	$scope.myhistory[1].status = "Processed";
	$scope.myhistory[1].result = "lalalala";
	$scope.myhistory[2].file1 = "ccc";
	$scope.myhistory[2].file2 = "ccc";
	$scope.myhistory[2].status = "Processed";
	$scope.myhistory[2].result = "lalalala";
	$scope.myhistory[3].file1 = "ddd";
	$scope.myhistory[3].file2 = "ddd";
	$scope.myhistory[3].status = "Processed";
	$scope.myhistory[3].result = "lalalala";
	$scope.myhistory[4].file1 = "eee";
	$scope.myhistory[4].file2 = "eee";
	$scope.myhistory[4].status = "Processed";
	$scope.myhistory[4].result = "lalalala";
});
