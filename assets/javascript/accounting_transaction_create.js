/**
 * Form Controller (AngularJS Based)
 */
var app = angular.module("transactionCreateApp", []);

app.controller("FormController", function($scope, $http) {
	
	// Variables
	$scope.account_debit;
	$scope.account_credit;
	$scope.error = {exists:false, msg:'Initial'};
	
	// Get the account information when changed
	$scope.$watch('account_debit_id', function(value) {
		$http.get('/accounting/account/get-account-summary', {
			params: { accountid: $scope.account_debit_id }
		})
		.success(function(data, status, headers, config) { 
			$scope.account_debit = data; 
			$scope.checkAccounts();
		});
	}); 
	$scope.$watch('account_credit_id', function(value) {
		$http.get('/accounting/account/get-account-summary', {
			params: { accountid: $scope.account_credit_id }
		})
		.success(function(data, status, headers, config) { 
			$scope.account_credit = data; 
			$scope.checkAccounts();
		});
	});
	
	$scope.checkAccounts = function() {
		if($scope.account_credit_id == $scope.account_debit_id) {
			$scope.error.exists = true;
			$scope.error.msg = 'Please choose different accounts';	
		}
		else {
			$scope.error.exists = false;
			$scope.error.msg = '';
		}
	}
	
});