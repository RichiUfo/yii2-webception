var app = angular.module("editableApp", []);

app.controller("EditableController", function($scope, $http, $window) {
	
	// Variables
	$scope.editionMode = false;
	$scope.value = $window.fpEditableInitial;
	
	$scope.save = function(){
	    // Build the update data
	    $scope.data = [];
	    $scope.data['id'] = 100;
	    $scope.data['alias'] = 'Updated Alias';
	    
	    
	    // Send the update request
	    $http.post('/accounting/rest/account/rename', $scope.data)
	    .success(function(data, status, headers, config) {
            console.log('Create a Notification here', data);
        });
	}
	
});