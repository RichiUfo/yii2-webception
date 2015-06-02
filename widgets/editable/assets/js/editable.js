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
	
	$scope.save = function(){
	    $http.post('/accounting/account/update', {
	        id: '100',
	        property: 'alias',
	        value: 'New Alias',
	    })
	    .success(function(data, status, headers, config) {
            console.log('Account Alias Update', data);
        });
	}
	
});