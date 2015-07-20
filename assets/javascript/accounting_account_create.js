/**
 * Form Controller (AngularJS Based)
 */
var app = angular.module('accountCreateApp', []);

app.controller("NewAccountFormController", ['$scope', '$http', function($scope, $http) {
	
	// Variables
	$scope.parent_account = null;
	
	// Get the account information when changed
	$scope.$watch('parent_account', function(value) {
		if ($scope.parent_account !== null) {
			$http.get('/accounting/account/get-next-available-number', {
				params: { parentid: $scope.parent_account }
			})
			.success(function(data, status, headers, config) { 
				$scope.account_number = data.base;
			});
		}
	}); 
	
	
	
}]);