/**
 * Form Controller (AngularJS Based)
 */
var app = angular.module("transactionCreateApp", []);

app.controller("FormController", function($scope, $http) {
	
	// Variables
	$scope.account_debit = null;
	$scope.account_credit = null;
	$scope.error = {invalid:true, msg:''};
	
	// Get the account information when changed
	$scope.$watch('account_debit_id', function(value) {
		if($scope.account_debit_id != ''){
			$http.get('/accounting/account/get-account-summary', {
				params: { accountid: $scope.account_debit_id }
			})
			.success(function(data, status, headers, config) { 
				$scope.account_debit = data; 
			});
		}
		else {
			$scope.account_debit = null; 
		}
		$scope.checkAccounts();
	}); 
	$scope.$watch('account_credit_id', function(value) {
		if($scope.account_credit_id != ''){
			$http.get('/accounting/account/get-account-summary', {
				params: { accountid: $scope.account_credit_id }
			})
			.success(function(data, status, headers, config) { 
				$scope.account_credit = data; 
			});
		}
		else {
			$scope.account_credit = null;
		}
		$scope.checkAccounts();
	});
	
	$scope.checkAccounts = function() {
		if($scope.account_credit_id == $scope.account_debit_id) {
			$scope.error.invalid = true;
			$scope.error.msg = 'Please choose different accounts';	
		}
		else if ($scope.account_credit == null || $scope.account_debit == null) {
			$scope.error.invalid = true;
			$scope.error.msg = 'One of the accounts is null';
		}
		else {
			$scope.error.invalid = false;
			$scope.error.msg = 'All Good';
		}
		
		// Activate or desactivate the next button
		angular.element( document.querySelector( '.btn-next' ) );
		
	}
	
});