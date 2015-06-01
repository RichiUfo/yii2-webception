var app = angular.module("createTransaction", []);

app.controller("FormCtrl", function($scope, $http) {
	
	// Variables
	$scope.account_debit;
	$scope.account_credit;
	
	// Detect Forex Transactions
	$scope.isForex = ($scope.account_debit.currency.code != $scope.account_credit.currency.code);
	
	// Get the account information when changed
	$scope.$watch('account_debit_id', function(value) {
		$http.get('/accounting/account/get-account-summary', {
			params: { accountid: $scope.account_debit_id }
		})
		.success(function(data, status, headers, config) { $scope.account_debit = data; console.log($scope.account_debit); });
	}); 
	$scope.$watch('account_credit_id', function(value) {
		$http.get('/accounting/account/get-account-summary', {
			params: { accountid: $scope.account_credit_id }
		})
		.success(function(data, status, headers, config) { $scope.account_credit = data; });
	}); 
	
	
});