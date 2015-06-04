/**
 * Form Controller (AngularJS Based)
 */
var app = angular.module("transactionCreateApp", []);

app.controller("FormController", function($scope, $http) {
	
	// Variables
	$scope.account_debit;
	$scope.account_credit;
	
	// Get the account information when changed
	$scope.$watch('account_debit_id', function(value) {
		$http.get('/accounting/account/get-account-summary', {
			params: { accountid: $scope.account_debit_id }
		})
		.success(function(data, status, headers, config) { $scope.account_debit = data; });
	}); 
	$scope.$watch('account_credit_id', function(value) {
		$http.get('/accounting/account/get-account-summary', {
			params: { accountid: $scope.account_credit_id }
		})
		.success(function(data, status, headers, config) { $scope.account_credit = data; });
	});
	
});