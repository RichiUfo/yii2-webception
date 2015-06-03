var app = angular.module("editableApp", []);

app.controller("EditableController", function($scope, $http, $window, $timeout) {
	
	// Variables
	$scope.editionMode = false;
	$scope.id = $window.fpEditableId;
	$scope.action = $window.fpEditableAction;
	$scope.value = $window.fpEditableInitial;
	$scope.default_value = $window.fpEditableDefault;
	
	$scope.reset = function(){
	    $scope.value = $scope.default_value;
	}
	
	$scope.save = function(){
	    $scope.editionMode = false;
	    
	    if($scope.value != $window.fpEditableInitial){
		    // Build the update data
		    $scope.data = {};
		    $scope.data['id'] = $scope.id;
		    $scope.data['alias'] = $scope.value;
		    console.log($scope.data);
		    
		    // Send the update request
		    $http.post($scope.action, $scope.data)
		    .success(function(data, status, headers, config) {
	            console.log('Create a Notification here', data);
	        });
	    }
	}
	
});