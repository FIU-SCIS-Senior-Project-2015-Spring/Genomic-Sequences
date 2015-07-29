// All the controllers to be loaded on index.php. 
// Controllers for the pages home.html, help.html, about.html, contact.html, and register.html

//Created the module GenomePro
var GenomePro = angular.module('GenomePro', ['angularFileUpload','ngRoute']);

//Routes for index when you write in the url /home or /help or /about or /contact or/register angular will load in the ng-view 
//home.html or help.html or about.html or contact.thml or register.html with the respective controler.	
GenomePro.config(['$routeProvider',function($routeProvider) {
	$routeProvider
		.when('/home', {
			templateUrl: 'HtmlPages/home.html',
			controller: 'home'
		  })
		.when('/home/activated', {
			templateUrl: function(){
			$('#showAlertTitle').text("Activation Successful.");		
			$('#showAlertText').text("Activation was succesful, now you can log in.");
			$('#showAlert').modal('show');

			return 'HtmlPages/home.html';},
			controller: 'home'
		  })
		.when('/register', {
			templateUrl: 'HtmlPages/register.html',
			controller: 'register'
		  })
		.when('/help', {
			templateUrl: 'HtmlPages/help.html',
			controller: 'help'
		  })		  
		.when('/contact', {
			templateUrl: 'HtmlPages/contact.html',
			controller: 'contact'
		  })
		.when('/about', {
			templateUrl: 'HtmlPages/about.html',
			controller: 'about'
		  })
		.otherwise({
			redirectTo : '/home'
		});
}]);

//this interceptor will intercept http errors, responser other than 200, and will show a message error
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

});                                    

//this controller is for home.html.
GenomePro.controller('home', function($scope, $http, $location, $timeout) {
	
	//variables that links to input fields	
	$scope.email = "";
	$scope.password = "";
	$scope.recoverEmail = "";
	
	//function is called when button login is pressed
	$scope.login = function(){
		$http.post("CORE/validate_user.php",
		{email:$scope.email,
		password:$scope.password})
		.success(function(json) {
			 window.location.replace('http://genomepro.cis.fiu.edu/'+json);
		});
	}

	//this function is call when the button register is pressed
	$scope.register = function(){
		$location.path('/register');
	}

	//this fuction is call when the button recover password is pressed
	$scope.recover = function(){
		$http.post("CORE/recover_password.php",
		{email:$scope.recoverEmail})
		.success(function(json) {
			$('#showAlertTitle').text("Password Recovery.");		
			$('#showAlertText').text("Please check your email, we sent you a new password to login.");
			$('#showAlert').modal('show');
			$('#myForgetModalLabel').modal('hide');
		});		
	}

        //this is for clearing the forgot password window
	$scope.showForgotPassword = function () {
		$scope.recoverEmail="";
		$('#myForgetModalLabel').modal('show');	
	}
});

//this controller is for register.html.
GenomePro.controller('register', function($scope, $http, $location, $timeout) {

	//varibles for input type tests in register.hmtl 	
	$scope.first_name = "";
	$scope.last_name = "";
	$scope.email = "";
	$scope.password = "";
	$scope.conf_password = "";
	
	//This is call when the select registration button is click on
	$scope.registration = function(){

		//This is a call to register_user.php passing the arguments first_name, last_name, email, password, and conf_password, when it came back, 
		//the user is already register and it goes to index.php	
		$http.post("CORE/register_user.php",
		{first_name:$scope.first_name,
		last_name:$scope.last_name,
		email:$scope.email,
		password:$scope.password,
		conf_password:$scope.conf_password})
		.success(function(json) {
			$('#showAlertTitle').text("Registration Successful.");		
			$('#showAlertText').text("Please go to your email and confirm your account");
			$('#showAlert').modal('show');
			$location.path('/home');
		});		
	}
});

//this controller is for the help.html.
GenomePro.controller('help', function($scope, $http, $location, $timeout) {

});

//this controller is for the contact.html.
GenomePro.controller('contact', function($scope, $http, $location, $timeout) {

	//variables for input type test in contact.html
        $scope.name = "";
	$scope.from = "";
	$scope.subject = "";
	$scope.msg = "";
	
	//this is a call when the user click send
	$scope.send = function(){
		
		//This is a call to contact_admin.php passing the arguments from, subject, and msg, when it came back, the email is already send and it goes to index.php
		$http.post("CORE/contact_admin.php",
		{ name: $scope.name,
                from: $scope.from,
		subject:$scope.subject,
		msg:$scope.msg})
		.success(function(json) {
			$('#showAlertTitle').text("Message Sent.");		
			$('#showAlertText').text("Your message has been sent successfully");
			$('#showAlert').modal('show');
			$location.path('/home');
		});				
	}
});

//this controller is for the about.html.
GenomePro.controller('about', function($scope, $http, $location, $timeout) {

});
