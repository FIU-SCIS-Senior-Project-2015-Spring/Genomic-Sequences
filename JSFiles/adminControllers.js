//All the controllers to be loaded on account.php. 
//Controllers for the pages profile.html, admin.html

//Created the module GenomePro
var GenomePro = angular.module('GenomePro', ['angularFileUpload','ngRoute']);

//Routes for Account when you write in the url /profile or /files or /history angular will load in the ng-view profile.html or files.html or history.html with the respective controler.	
GenomePro.config(['$routeProvider',function($routeProvider) {
	$routeProvider
		.when('/profile', {
			templateUrl: 'HtmlPages/profile.html',
			controller: 'profile'
		  })		
		.when('/admin', {
			templateUrl: 'HtmlPages/admin.html',
			controller: 'admin'
		  })
		.otherwise({
			redirectTo : '/profile'
		});
}]);

//function to post a photo if user doesn't provide one 
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

//this interceptor will intercept http errors, responser other than 200, and will show a massage error
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
			 window.location.replace('http://localhost/GenomePro/index.php');
		});
	}
});                                    

//this controller is for the admin.html.
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

//--------------------------------------------------------------------------------------------------------
//this controller is for the profile.html.
GenomePro.controller('admin', function($scope, $http, $location, $timeout) {

	$scope.searchEmail = "";
	$scope.emails = [];
	
	//this brings the list of users and displays it	
	$http.post("CORE/admin_information.php",
	{})
	.success(function(json) {
		$scope.emails = json;
	});
        
        //this delete users from the system	
	$scope.deleteUser = function($id){
            $http.post("CORE/deleteUser.php",
            {id: $id})
            .success(function(json) {
                $('#showAlertTitle').text("User Deletion succesful.");		
                $('#showAlertText').text(json);
                $('#showAlert').modal('show');

                //this brings the list of users and displays it	
                $http.post("CORE/admin_information.php",
                {})
                .success(function(json) {
                         $scope.emails = json;
                });
            });
	}
        
        //this change user to admin type 
	$scope.changeUserType = function($id){
            $http.post("CORE/userType.php",
            {id: $id})
            .success(function(json) {
                $('#showAlertTitle').text("Change User Type succesful.");		
                $('#showAlertText').text(json);
                $('#showAlert').modal('show');

                //this brings the list of users and displays it	
                $http.post("CORE/admin_information.php",
                {})
                .success(function(json) {
                         $scope.emails = json;
                });
            });
	}
	
});
