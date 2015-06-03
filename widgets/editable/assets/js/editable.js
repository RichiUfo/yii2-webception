var app = angular.module("editableApp", []);

app.controller("EditableController", function($scope, $http, $window) {
	
	// Variables
	$scope.editionMode = false;
	$scope.value = $window.fpEditableInitial;
	
	$scope.save = function(){
	    $http.post('/accounting/rest/account/rename', {
	        id: '100',
	        alias: $scope.value,
	    })
	    .success(function(data, status, headers, config) {
            console.log('Account Alias Update', data);
        });
	}
	
});