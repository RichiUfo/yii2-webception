var transaction_create_form_init = function() {
    
    /**
     * General Functions
     */
    var debit = null;
    var credit = null;
    
    /**
     * Initialize
     */
    $('input.btn-next').attr('disabled','disabled');
    
    /**
     * Buttons Click
     */
    $('input.btn-next').click(function(){
         $(this).attr('disabled','disabled');
    });
    $('input.btn-previous').click(function(){
         $('input.btn-next').removeAttr('disabled');
    });
    
     /**
     * Account Selection Change
     *
    $('.account-select').on('change', function(){
        $('input.btn-next').attr('disabled','disabled');
        
        var caller = $(this);
        /* 
        * Get The Account Summary 
        *
        if($(this).val()===''){
            caller.closest('.acccount-select-group').find('.account-summary').html('');
        }
        else {
            $.ajax({
                url: '/accounting/account/get-account-summary',
                method: 'GET',
                data: { accountid : $(this).val() },
                dataType : 'json'
            })
            .done(function(response){
                // Update the global var
                if(caller.attr('name')==='Transaction[account_debit_id]'){
                    debit = response;
                } else if(caller.attr('name')==='Transaction[account_credit_id]') {
                    credit = response;
                }
                
                // Update the transaction name
                if((debit !== null) && (credit !== null)){
                    $('#transaction-name').val("Debit "+debit.name+" and credit "+credit.name);
                }
        
                // Update the account summary display section
                var line_value = '<div class="value">'+response.display_value+' '+response.currency.symbol+'</div>'; 
                var line_category = '<div class="root">'+response.root+'</div>';
                var line_currency = '<div class="value">'+response.currency.name+'</div>';
                caller.closest('.acccount-select-group').find('.account-summary').html(line_value+line_currency+line_category);
            });
        }
        
        /* 
        * Validate the current account selection 
        */
        var valid = true;
        var message = '';
        
        // Selected Accounts Are Differents
        if($('#transaction-account_debit_id').val() === $('#transaction-account_credit_id').val()){
            valid = false;
            message = 'Error : Same account is selected for debit and credit !';
        }
        
        // Both accounts are selected
        if(($('#transaction-account_debit_id').val()==='') || ($('#transaction-account_credit_id').val()==='')){
            valid = false;
            message = '';
        }
        
        if(valid){
            caller.closest('.tab-pane').find('.feedback').html(message);
            $('input.btn-next').removeAttr('disabled');
            
        } else {
            caller.closest('.tab-pane').find('.feedback').html(message);
            $('input.btn-next').attr('disabled','disabled');
        }
        
    });
    
    /**
    * Transaction Amount Selection Change
    */
    $('#transaction-value').on('keyup', function(){
        var caller = $(this);
        var amount = Number($(this).val());
        var valid = true;
        var message = '';
        
        console.log(debit, credit);
        
        // Check the debit account (detect a change of sign)
        if(debit.sign * (debit.value - amount) < 0) {    // Different Signs
            valid = false;
            message = 'Error : Check the debit account value !';
        }
        
        // Check the credit account (detect a change of sign)
        console.log(credit.sign * (credit.value + amount));
        if(credit.sign * (credit.value + amount) < 0) {    // Different Signs
            valid = false;
            message = 'Error : Check the credit account value !';
        } 
        
        // Check that the amount is positive
        if(amount <= 0){
            valid = false;
            message = 'Error : The transaction amount must be greater than zero !';
        }
        
        // Display the feedback
        caller.closest('.tab-pane').find('.feedback').html(message);
        if(valid){
            $('input.btn-next').removeAttr('disabled');
        } else {
            $('input.btn-next').attr('disabled','disabled');
        }
    });
    
}