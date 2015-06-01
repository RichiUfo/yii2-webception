var app = angular.module("createTransaction", []);

app.controller("FormCtrl", function($scope, $http) {
	
	// Variables
	$scope.account_debit;
	$scope.account_credit;
	
	// Get the account information when changed
	$scope.$watch(
		function(scope) { return [scope.account_debit_id, scope.account_credit_id]; }
		,function(media) {
			console.log('Account Change Detected !');
		}
	); 
	
	/*$http.get('data/posts.json')
	.success(function(data, status, headers, config) {
		$scope.posts = data;
	})
	.error(function(data, status, headers, config) {
	// log error
	});*/
});