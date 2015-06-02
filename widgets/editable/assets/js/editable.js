// Use Case : User click on the editable title
/*$('#account-title').on('click', function(event) {
    $('#account-title').hide();
    $('#account-title-edit').show();
});

// Use Case : User click on the save button
$('#account-title-edit-form-button').on('click', function(event) {
    if($('#account-title-edit-form-field').val() === ''){
        $('#account-title-value').html('".$account->name."');
    }
    else {
        $('#account-title-value').html($('#account-title-edit-form-field').val());
    }
    $('#account-title').show();
    $('#account-title-edit').hide();
    
    $.ajax({
        method: 'POST',
        url: '/accounting/account/rename',
        data: $('#account-title-edit-form').serializeArray(),
        success: function(result){
            ToastrAjaxFeed.getNotifications('/notification/get-notifications', {'positionClass':'toast-bottom-right'});
        }
    });
});

// Use Case : User click on the default button
$('#account-title-edit-form-reset-button').on('click', function(event) {
    $('#account-title-edit-form-field').val('".$account->name."');
});
*/
  
var app = angular.module("editableApp", []);

app.controller("editableCtrl", function($scope, $http) {
	
	// Variables
	$scope.editionMode = false;
	//$scope.account_debit;
	//$scope.account_credit;
	$scope.count = 1; 
	
	$scope.incr = function(){
	    $scope.inc = 1*$scope.inc+1; 
	    console.log('inc', $scope.inc);
	}
	
	// Get the account information when changed
	/*$scope.$watch('account_debit_id', function(value) {
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
	*/
	
});