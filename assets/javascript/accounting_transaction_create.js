/**
 * Form Controller (AngularJS Based)
 */
var app = angular.module("transactionCreateApp", []);

app.controller("FormController", function($scope, $http) {
	
	// Variables
	$scope.account_debit;
	$scope.account_credit;
	$scope.error = {valid:false, msg:'Initial'};
	
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
			$scope.error.valid = false;
			$scope.error.msg = 'Please choose different accounts';	
		}
		else if ($scope.account_credit_id == null || $scope.account_debit_id == null) {
			$scope.error.valid = false;
			$scope.error.msg = '';
		}
		else {
			$scope.error.valid = tru;
			$scope.error.msg = '';
		}
		
		// Activate or desactivate the next button
		angular.element( document.querySelector( '.btn-next' ) );
		
	}
	
});