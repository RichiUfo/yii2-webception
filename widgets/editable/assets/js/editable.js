var app = angular.module("editableApp", []);

app.controller("EditableController", function($scope, $http, $window, $timeout) {
	
	// Variables
	$scope.editionMode = false;
	$scope.resetting = false;
	$scope.id = $window.fpEditableId;
	$scope.action = $window.fpEditableAction;
	$scope.value = $window.fpEditableInitial;
	$scope.default_value = $window.fpEditableDefault;
	
	$scope.reset = function(){
	    $scope.resetting = true;
	    $scope.value = $scope.default_value;
	    //$scope.resetting = false;
	}
	
	$scope.save = function(){
	    //$scope.resetting = false;
	    $timeout(function () {          // will be executed after ngClick function in case of click
            
            if ($scope.clicked) {
                return;
            }
	    
    	    $scope.editionMode = false;
    	    
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
	    });
	}
	
});